<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificados;
use App\Models\Dictamen_instalaciones;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Revisor; 
//Notificacion
use App\Notifications\GeneralNotification;
//Enviar Correo
use App\Mail\CorreoCertificado;
use App\Models\Documentacion_url;
use App\Models\instalaciones;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Storage;

class Certificado_InstalacionesController extends Controller
{
    public function UserManagement()
    {
        $dictamenes = Dictamen_instalaciones::all();
        $users = User::all(); 
        $revisores = Revisor::all(); 
        return view('certificados.certificados_instalaciones_view', compact('dictamenes', 'users', 'revisores'));
    }
    
    public function index(Request $request)
    {
        $columns = [
            1 => 'num_dictamen',
            2 => 'num_certificado',
            3 => 'id_firmante',
            4 => 'maestro_mezcalero',
            5 => 'num_autorizacion',
            6 => 'fecha_vigencia',
            7 => 'fecha_vencimiento',
        ];
        
        $search = $request->input('search.value');
        $totalData = Certificados::count();
        
        $orderIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');
        $order = $columns[$orderIndex] ?? 'num_certificado';
        $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';
        
        // Base query with eager loading
        $query = Certificados::with([
            'dictamen.inspeccione.solicitud.instalaciones.empresa.empresaNumClientes',
            'dictamen.instalaciones',
            'dictamen.inspeccione.inspector',
            'firmante'
        ]);
        
        // Apply search filter if present
        if ($search) {
            $query->where('num_certificado', 'LIKE', "%{$search}%")
                ->orWhere('maestro_mezcalero', 'LIKE', "%{$search}%")
                ->orWhereHas('firmante', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        }
        
        // Calculate filtered records
        $totalFiltered = $query->count();
        
        // Apply sorting and pagination
        $query->offset($request->input('start'))
            ->limit($request->input('length'))
            ->orderByRaw("
                CAST(SUBSTRING_INDEX(num_certificado, '/', -1) AS UNSIGNED) {$dir}, -- Ordena el año
                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(num_certificado, '-', -1), '/', 1) AS UNSIGNED) {$dir} -- Ordena el consecutivo
            ");
        
        $certificados = $query->get();
        
        // Map data for DataTables
        $data = $certificados->map(function ($certificado, $index) use ($request) {
            $empresa = $certificado->dictamen->instalaciones->empresa ?? null;
            $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes
                    ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
                : 'N/A';

                $fechaActual = Carbon::now()->startOfDay(); // Asegúrate de trabajar solo con fechas, sin horas
                $fechaVigencia = Carbon::parse($certificado->fecha_vencimiento)->startOfDay();
                
                if ($fechaActual->isSameDay($fechaVigencia)) {
                   $restantes = "<span class='badge bg-danger'>Hoy se vence este dictamen</span>";
                } else {
                    $diasRestantes = $fechaActual->diffInDays($fechaVigencia, false);
                
                    if ($diasRestantes > 0) {
                        if($diasRestantes > 15){
                            $res = "<span class='badge bg-success'>$diasRestantes días de vigencia.</span>";
                        }else{
                            $res = "<span class='badge bg-warning'>$diasRestantes días de vigencia.</span>";
                        }
                        $restantes = $res;
                    } else {
                        $restantes = "<span class='badge bg-danger'>Vencido hace " . abs($diasRestantes) . " días.</span>";
                    }
                }
        
            return [
                'id_certificado' => $certificado->id_certificado,
                'id_dictamen' => $certificado->id_dictamen,
                'fake_id' => $request->input('start') + $index + 1,
                'num_certificado' => $certificado->num_certificado,
                'razon_social' => $empresa->razon_social ?? 'N/A',
                'domicilio_instalacion' => $certificado->dictamen->instalaciones->direccion_completa ?? "N/A",
                'numero_cliente' => $numero_cliente,
                'num_autorizacion' => $certificado->num_autorizacion ?? 'N/A',
                'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
                'fecha_vencimiento' => Helpers::formatearFecha($certificado->fecha_vencimiento),
                'maestro_mezcalero' => $certificado->maestro_mezcalero ?? 'N/A',
                'num_dictamen' => $certificado->dictamen->num_dictamen,
                'num_servicio' => $certificado->dictamen->inspeccione->num_servicio ?? 'Sin definir',
                'tipo_dictamen' => $certificado->dictamen->tipo_dictamen,
                'id_revisor' => $certificado->revisor && $certificado->revisor->user ? $certificado->revisor->user->name : 'Sin asignar',
                'id_revisor2' => $certificado->revisor && $certificado->revisor->user2 ? $certificado->revisor->user2->name : 'Sin asignar',
                'id_firmante' => $certificado->firmante->name ?? 'Sin asignar',
                'estatus' => $certificado->estatus,
                'diasRestantes' => $restantes,

                
            ];
        });
        
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ]);
        
    }
    
    // Funcion de eliminar
    public function destroy($id_certificado)
    {
        try {
            // Buscar el certificado
            $certificado = Certificados::findOrFail($id_certificado);
    
            // Eliminar todos los revisores asociados al certificado en la tabla certificados_revision
            Revisor::where('id_certificado', $id_certificado)->delete();
    
            // Luego, eliminar el certificado
            $certificado->delete();
    
            return response()->json(['success' => 'Certificado y revisores eliminados correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al eliminar el certificado y los revisores: ' . $e->getMessage()], 500);
        }
    }
    
    // Funcion agregar
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_vigencia' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'maestro_mezcalero' => 'nullable|string|max:60',
            'num_autorizacion' => 'nullable|integer',
            'id_firmante' => 'required|integer',
        ]);
    
        $certificado = Certificados::create([
            'id_dictamen' => $validatedData['id_dictamen'],
            'num_certificado' => $validatedData['num_certificado'],
            'fecha_vigencia' => $validatedData['fecha_vigencia'],
            'fecha_vencimiento' => $validatedData['fecha_vencimiento'],
            'maestro_mezcalero' => $validatedData['maestro_mezcalero'] ?: null, 
            'num_autorizacion' => $validatedData['num_autorizacion'] ?: null,
            'id_firmante' => $validatedData['id_firmante']
        ]);

        $id_instalacion = $certificado->dictamen->id_instalacion;
        $instalaciones = instalaciones::find($id_instalacion);
        $instalaciones->folio = $certificado->num_certificado;
        $instalaciones->fecha_emision = $certificado->fecha_vigencia;
        $instalaciones->fecha_vigencia = $certificado->fecha_vencimiento;
        $instalaciones->save();

         // Obtener información de la empresa
       
         $numeroCliente = $certificado->dictamen->instalaciones->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
             return !empty($numero);
         });
 
         // Manejo de archivos si se suben
   
             $directory = 'uploads/' . $numeroCliente;
             $path = storage_path('app/public/' . $directory);
             if (!file_exists($path)) {
                 mkdir($path, 0777, true); 
             }  
             
              
                 $nombreDocumento =  'Certificado '.str_replace('/', '-', $certificado->num_certificado);
                
 
                 $filename = $nombreDocumento .  '.pdf' ;
                 $filePath = storage_path('app/public/' . $directory . '/' . $filename);
                 if($certificado->dictamen->tipo_dictamen==1){
                    $id_documento =127;
                    $this->pdf_certificado_productor($certificado->id_certificado,true,$filePath);
                 }
                 if($certificado->dictamen->tipo_dictamen==2){
                    $id_documento =128;
                    $this->pdf_certificado_envasador($certificado->id_certificado,true,$filePath);
                 }
                 if($certificado->dictamen->tipo_dictamen==3){
                    $id_documento =128;
                    $this->pdf_certificado_comercializador($certificado->id_certificado,true,$filePath);
                 }
                    
                
 
                 $documentacion_url = new Documentacion_url();
                 $documentacion_url->id_relacion =  $certificado->dictamen->id_instalacion;
                 $documentacion_url->id_documento = $id_documento ?? null;
                 $documentacion_url->nombre_documento = $nombreDocumento;  
                 $documentacion_url->url = $filename;  
                 $documentacion_url->id_empresa =  $certificado->dictamen->instalaciones->id_empresa;
                 $documentacion_url->save();
             
    
        return response()->json([
            'message' => 'Certificado registrado exitosamente',
            'certificado' => $certificado
        ]);
    }
    
    // Funcion para cargar
    public function edit($id)
    {
        $certificado = Certificados::find($id);
    
        if ($certificado) {
            return response()->json($certificado);
        }
    
        return response()->json(['error' => 'Certificado no encontrado'], 404);
    }
 
    // Funcion Actualizar
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_vigencia' => 'required|date_format:Y-m-d',
            'fecha_vencimiento' => 'nullable|date_format:Y-m-d',
            'maestro_mezcalero' => 'nullable|string|max:60',
            'num_autorizacion' => 'nullable|integer',
            'id_firmante' => 'required|integer',
        ]);
    
        try {
            $certificado = Certificados::findOrFail($id);

               // Obtener información de la empresa
       
                $numeroCliente = $certificado->dictamen->instalaciones->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                    return !empty($numero);
                });


                $directory = 'uploads/' . $numeroCliente;
                    $path = storage_path('app/public/' . $directory);
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true); 
                    }  
             
                $nombreDocumento =  'Certificado '.str_replace('/', '-', $certificado->num_certificado);
                $certificado_actual = Documentacion_url::where('nombre_documento', $nombreDocumento)->first();
               // dd($certificado_actual);

                if ($certificado_actual) {
                    // Elimina el archivo físico si existe
                    
                    if (Storage::exists('public/' . $directory . '/' . $certificado_actual->url)) {
                        Storage::delete('public/' . $directory . '/' . $certificado_actual->url);
                    }
                
                    // Elimina el registro de la base de datos
                    $certificado_actual->delete();
                }
    
            $certificado->id_dictamen = $validatedData['id_dictamen'];
            $certificado->num_certificado = $validatedData['num_certificado'];
            $certificado->fecha_vigencia = $validatedData['fecha_vigencia'];
            $certificado->fecha_vencimiento = $validatedData['fecha_vencimiento'];
            $certificado->maestro_mezcalero = $validatedData['maestro_mezcalero'] ?: null;
            $certificado->num_autorizacion = $validatedData['num_autorizacion'] ?: null;
            $certificado->id_firmante = $validatedData['id_firmante']; 
            $certificado->save();

            $id_instalacion = $certificado->dictamen->id_instalacion;
            $instalaciones = instalaciones::find($id_instalacion);
            $instalaciones->folio = $certificado->num_certificado;
            $instalaciones->fecha_emision = $certificado->fecha_vigencia;
            $instalaciones->fecha_vigencia = $certificado->fecha_vencimiento;
            $instalaciones->save();

      
                
                 $nombreDocumento =  'Certificado '.str_replace('/', '-', $certificado->num_certificado);
                 $filename = $nombreDocumento.'.pdf' ;
                 $filePath = storage_path('app/public/' . $directory . '/' . $filename);
                 if($certificado->dictamen->tipo_dictamen==1){
                    $id_documento =127;
                    $this->pdf_certificado_productor($certificado->id_certificado,true,$filePath);
                 }
                 if($certificado->dictamen->tipo_dictamen==2){
                    $id_documento =128;
                    $this->pdf_certificado_envasador($certificado->id_certificado,true,$filePath);
                 }
                 if($certificado->dictamen->tipo_dictamen==3){
                    $id_documento =128;
                    $this->pdf_certificado_comercializador($certificado->id_certificado,true,$filePath);
                 }
                    
                
 
                 $documentacion_url = new Documentacion_url();
                 $documentacion_url->id_relacion =  $certificado->dictamen->id_instalacion;
                 $documentacion_url->id_documento = $id_documento ?? null;
                 $documentacion_url->nombre_documento = $nombreDocumento;  
                 $documentacion_url->url = $filename;  
                 $documentacion_url->id_empresa =  $certificado->dictamen->instalaciones->id_empresa;
                 $documentacion_url->save();
    
            return response()->json([
                'message' => 'Certificado actualizado correctamente.',
                'certificado' => $certificado
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar el certificado. Por favor, intente de nuevo.'
            ], 500);
        }
    }
    
    public function pdf_certificado_productor($id_certificado, $guardar = false, $rutaGuardado = null)   
    {
        $datos = Certificados::with([
            'dictamen.inspeccione.solicitud.empresa', 
            'dictamen.instalaciones',                
            'dictamen.inspeccione.inspector',          
            'firmante'                                 
        ])->findOrFail($id_certificado);

        $empresa = $datos->dictamen->instalaciones->empresa;
        $numero_cliente = $empresa->empresaNumClientes
        ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))
        ?->numero_cliente ?? 'N/A';
    
        $watermarkText = $datos->estatus === 1;
        $leyenda = $datos->estatus === 2;

        // Preparar los datos para el PDF
        $pdfData = [
            'datos' => $datos,
            'num_certificado' => $datos->num_certificado,
            'num_autorizacion' => $datos->num_autorizacion,
            'num_dictamen' => $datos->dictamen->num_dictamen,
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),
            'fecha_vencimiento' => Helpers::formatearFecha($datos->fecha_vencimiento),
            'domicilio_fiscal' => $empresa->domicilio_fiscal,
            'rfc' => $empresa->rfc,
            'telefono' => $empresa->telefono,
            'correo' => $empresa->correo,
            'watermarkText' => $watermarkText,
            'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa,
            'razon_social' => $empresa->razon_social,  
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------',
            'numero_cliente' => $numero_cliente,
            'nombre_firmante' => $datos->firmante->name,
            'leyenda' => $leyenda,
            'categorias' => $datos->dictamen->inspeccione->solicitud->categorias_mezcal()->pluck('categoria')->implode(', '),
            'clases' => $datos->dictamen->inspeccione->solicitud->clases_agave()->pluck('clase')->implode(', '),
        ];

    if ($guardar && $rutaGuardado) {
        $pdf = Pdf::loadView('pdfs.Certificado_productor_mezcal', $pdfData);
        $pdf->save($rutaGuardado);
        return $rutaGuardado; 
    }

    return Pdf::loadView('pdfs.Certificado_productor_mezcal', $pdfData)->stream('Certificado de productor de mezcal.pdf');

       
    }

    public function pdf_certificado_envasador($id_certificado, $guardar = false, $rutaGuardado = null)   
    {
        $datos = Certificados::with([
            'dictamen.inspeccione.solicitud.instalaciones.empresa',  
            'dictamen.inspeccione.solicitud.empresa', 
            'dictamen.instalaciones',
            'dictamen.inspeccione.inspector',
            'firmante'
        ])->findOrFail($id_certificado);
    
        $empresa = $datos->dictamen->instalaciones->empresa;
        $numero_cliente = $empresa->empresaNumClientes->firstWhere('empresa_id', $empresa->id)->numero_cliente;
        $watermarkText = $datos->estatus === 1;
        $leyenda = $datos->estatus === 2;
    
        // Preparar los datos para el PDF
        $pdfData = [
            'datos' => $datos,
            'num_certificado' => $datos->num_certificado,
            'num_autorizacion' => $datos->num_autorizacion,
            'num_dictamen' => $datos->dictamen->num_dictamen,
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),
            'fecha_vencimiento' => Helpers::formatearFecha($datos->fecha_vencimiento),
            'domicilio_fiscal' => $empresa->domicilio_fiscal,
            'rfc' => $empresa->rfc,
            'watermarkText' => $watermarkText,
            'telefono' => $empresa->telefono,
            'correo' => $empresa->correo,
            'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa,
            'razon_social' => $empresa->razon_social, 
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------',
            'numero_cliente' => $numero_cliente,
            'nombre_firmante' => $datos->firmante->name,
            'leyenda' => $leyenda,
            'categorias' => $datos->dictamen->inspeccione->solicitud->categorias_mezcal()->pluck('categoria')->implode(', '),
            'clases' => $datos->dictamen->inspeccione->solicitud->clases_agave()->pluck('clase')->implode(', '),
        ];

        if ($guardar && $rutaGuardado) {
            $pdf = Pdf::loadView('pdfs.Certificado_envasador_mezcal', $pdfData);
            $pdf->save($rutaGuardado);
            return $rutaGuardado; 
        }
    
        // Generar y retornar el PDF
        return Pdf::loadView('pdfs.Certificado_envasador_mezcal', $pdfData)->stream('Certificado de envasador de mezcal.pdf');
    }
    
    public function pdf_certificado_comercializador($id_certificado, $guardar = false, $rutaGuardado = null)   
    {
        $datos = Certificados::with([
            'dictamen.inspeccione.solicitud.empresa',  
            'dictamen.instalaciones',                  
            'dictamen.inspeccione.inspector',          
            'firmante'                             
        ])->findOrFail($id_certificado);
    
        $empresa = $datos->dictamen->instalaciones->empresa;
        $numero_cliente = $empresa->empresaNumClientes->firstWhere('empresa_id', $empresa->id)->numero_cliente;
        $watermarkText = $datos->estatus === 1;
        $leyenda = $datos->estatus === 2;
    
        // Preparar los datos para el PDF
        $pdfData = [
            'datos' => $datos,
            'num_certificado' => $datos->num_certificado,
            'num_autorizacion' => $datos->num_autorizacion,
            'num_dictamen' => $datos->dictamen->num_dictamen,
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),
            'fecha_vencimiento' => Helpers::formatearFecha($datos->fecha_vencimiento),
            'domicilio_fiscal' => $empresa->domicilio_fiscal,
            'rfc' => $empresa->rfc,
            'telefono' => $empresa->telefono,
            'correo' => $empresa->correo,
            'watermarkText' => $watermarkText,
            'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa,
            'razon_social' => $empresa->razon_social, 
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------',
            'numero_cliente' => $numero_cliente,
            'nombre_firmante' => $datos->firmante->name ?? 'Nombre del firmante no disponible',
            'leyenda' => $leyenda,
            'categorias' => $datos->dictamen->inspeccione->solicitud->categorias_mezcal()->pluck('categoria')->implode(', '),
            'clases' => $datos->dictamen->inspeccione->solicitud->clases_agave()->pluck('clase')->implode(', '),
        ];
    
        if ($guardar && $rutaGuardado) {
            $pdf = Pdf::loadView('pdfs.Certificado_comercializador', $pdfData);
            $pdf->save($rutaGuardado);
            return $rutaGuardado; 
        }
        $pdf = Pdf::loadView('pdfs.Certificado_comercializador', $pdfData);
        return $pdf->stream('Certificado de comercializador.pdf');
    }
    

    // Funcion LLenar Select
    public function obtenerRevisores(Request $request)
    {
        $tipo = $request->get('tipo');
        $revisores = User::where('tipo', $tipo)->get(['id', 'name']);
        
        return response()->json($revisores);
    }
    
    // Función agregar Revisor
    public function storeRevisor(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'tipoRevisor' => 'required|string|in:1,2',
                'nombreRevisor' => 'required|integer|exists:users,id',
                'numeroRevision' => 'required|string|max:50',
                'esCorreccion' => 'nullable|in:si,no',
                'observaciones' => 'nullable|string|max:255',
                'id_certificado' => 'required|integer|exists:certificados,id_certificado',
            ]);
            
            $user = User::find($validatedData['nombreRevisor']);
            if (!$user) {
                return response()->json(['message' => 'El revisor no existe.'], 404);
            }

            $certificado = Certificados::find($validatedData['id_certificado']);
            if (!$certificado) {
                return response()->json(['message' => 'El certificado no existe.'], 404);
            }

            $revisor = Revisor::where('id_certificado', $validatedData['id_certificado'])->first();
            $message = ''; // Inicializar el mensaje

            if ($revisor) {
                // Actualizar el revisor existente
                if ($validatedData['tipoRevisor'] == '1') {
                    if ($revisor->id_revisor == $validatedData['nombreRevisor']) {
                        $message = 'Revisor reasignado.'; 
                    } else {
                        $revisor->id_revisor = $validatedData['nombreRevisor'];
                        $message = 'Revisor asignado exitosamente.';
                    }
                } else {
                    if ($revisor->id_revisor2 == $validatedData['nombreRevisor']) {
                        $message = 'Revisor reasignado.';
                    } else {
                        $revisor->id_revisor2 = $validatedData['nombreRevisor'];
                        $message = 'Revisor Miembro del consejo asignado exitosamente.';
                    }
                }
            } else {
                // Crear un nuevo revisor
                $revisor = new Revisor();
                $revisor->id_certificado = $validatedData['id_certificado'];
                $revisor->tipo_revision = $validatedData['tipoRevisor'];

                if ($validatedData['tipoRevisor'] == '1') {
                    $revisor->id_revisor = $validatedData['nombreRevisor'];
                    $message = 'Revisor asignado exitosamente.';
                } else {
                    $revisor->id_revisor2 = $validatedData['nombreRevisor'];
                    $message = 'Revisor Miembro del consejo asignado exitosamente.';
                }
            }

            // Guardar los datos del revisor
            $revisor->numero_revision = $validatedData['numeroRevision'];
            $revisor->es_correccion = $validatedData['esCorreccion'] ?? 'no';
            $revisor->observaciones = $validatedData['observaciones'] ?? '';
            $revisor->save();

            // Preparar datos para el correo
            $data1 = [
                'title' => 'Nuevo registro de solicitud',
                'message' => 'Se ha asignado el revisor (' . $user->name . ') al certificado número ' . $certificado->num_certificado, 
                'url' => 'solicitudes-historial',
                'nombreRevisor' => $user->name,
                'emailRevisor' => $user->email,
                'num_certificado' => $certificado->num_certificado,
                'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
                'fecha_vencimiento' => Helpers::formatearFecha($certificado->fecha_vencimiento), 
                'razon_social' => $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'Sin asignar',
                'numero_cliente' => $certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->first()->numero_cliente ?? 'Sin asignar',
                'tipo_certificado' => $certificado->id_dictamen
            ];

            // Notificación Local
            $users = User::whereIn('id', [18, 19, 20])->get();
            foreach ($users as $notifiedUser) {
                $notifiedUser->notify(new GeneralNotification($data1));
            }

/*             // Correo a Revisores
            try {
                info('Enviando correo a: ' . $user->email);

                if (empty($user->email)) {
                    return response()->json(['message' => 'El correo del revisor no está disponible.'], 404);
                }

                Mail::to($user->email)->send(new CorreoCertificado($data1)); 
                info('Correo enviado a: ' . $user->email);
            } catch (\Exception $e) {
                Log::error('Error al enviar el correo: ' . $e->getMessage()); 
                return response()->json(['message' => 'Error al enviar el correo: ' . $e->getMessage()], 500);
            } */

            return response()->json([
                'message' => $message ?? 'Revisor del OC asignado exitosamente',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al asignar el revisor: ' . $e->getMessage()], 500);
        }
    }

    //Funcion para reexpedir certificado
    public function reexpedir(Request $request)
    {
        try {
            $request->validate([
                'id_certificado' => 'required|exists:certificados,id_certificado',
                'accion_reexpedir' => 'required|in:1,2', 
                'observaciones' => 'nullable|string',
                'id_dictamen' => 'required|integer',
                'num_certificado' => 'required|string|max:25',
                'fecha_vigencia' => 'required|date',
                'fecha_vencimiento' => 'required|date',
                'maestro_mezcalero' => 'nullable|string|max:60',
                'num_autorizacion' => 'nullable|integer',
                'id_firmante' => 'required|integer',
            ]);
    
            $certificado = Certificados::findOrFail($request->id_certificado);
    
            if ($request->accion_reexpedir == '1') {
                $certificado->estatus = 1; 
                $certificado->observaciones = $request->observaciones; 
                $certificado->save();
            } elseif ($request->accion_reexpedir == '2') {
                $certificado->estatus = 1;
                $certificado->observaciones = $request->observaciones; 
                $certificado->save(); 
    
                // Crear un nuevo registro de certificado (reexpedición)
                $nuevoCertificado = new Certificados();
                $nuevoCertificado->id_dictamen = $request->id_dictamen;
                $nuevoCertificado->num_certificado = $request->num_certificado;
                $nuevoCertificado->fecha_vigencia = $request->fecha_vigencia;
                $nuevoCertificado->fecha_vencimiento = $request->fecha_vencimiento;
                $nuevoCertificado->maestro_mezcalero = $request->maestro_mezcalero ?: null;
                $nuevoCertificado->num_autorizacion = $request->num_autorizacion ?: null;
                $nuevoCertificado->id_firmante = $request->id_firmante;
                $nuevoCertificado->estatus = 2;
                
                // Guarda el nuevo certificado
                $nuevoCertificado->save();
            }
    
            return response()->json(['message' => 'Certificado procesado correctamente.']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Error al procesar el certificado.', 'error' => $e->getMessage()], 500);
        }
    }
    
    
//end
}
