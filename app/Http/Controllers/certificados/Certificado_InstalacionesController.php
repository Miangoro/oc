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
use App\Models\Documentacion_url;
use App\Models\instalaciones;
//Notificacion
use App\Notifications\GeneralNotification;
//Enviar Correo
use App\Mail\CorreoCertificado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class Certificado_InstalacionesController extends Controller
{

    public function UserManagement()
    {
        $dictamenes = Dictamen_instalaciones::where('estatus', '!=', 1)->get();
        $users = User::where('tipo', 1)->get();
        $revisores = Revisor::all();
        return view('certificados.find_certificados_instalaciones', compact('dictamenes', 'users', 'revisores'));
    }


    public function index(Request $request)
    {
        $columns = [
            1 => 'id_certificado',
            2 => 'id_dictamen',
            3 => '',
            4 => '',
            5 => 'fechas',
            6 => 'estatus',
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
                })->orWhereHas('dictamen.instalaciones', function ($q) use ($search) {
                    $q->where('direccion_completa', 'LIKE', "%{$search}%");
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
        /*$data = $certificados->map(function ($certificado, $index) use ($request) {
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
                            $res = "<span class='badge bg-label-success'>$diasRestantes días de vigencia.</span>";
                        }else{
                            $res = "<span class='badge bgl-label-warning'>$diasRestantes días de vigencia.</span>";
                        }
                        $restantes = $res;
                    } else {
                        $restantes = "<span class='badge bg-label-danger'>Vencido hace " . abs($diasRestantes) . " días.</span>";
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
        });*/
        $data = [];
        if (!empty($certificados)) {
            foreach ($certificados as $certificado) {
                $nestedData['id_certificado'] = $certificado->id_certificado ?? 'No encontrado';
                $nestedData['num_certificado'] = $certificado->num_certificado ?? 'No encontrado';
                $nestedData['id_dictamen'] = $certificado->dictamen->id_dictamen ?? 'No encontrado';
                $nestedData['num_dictamen'] = $certificado->dictamen->num_dictamen ?? 'No encontrado';
                $nestedData['tipo_dictamen'] = $certificado->dictamen->tipo_dictamen ?? 'No encontrado';
                $nestedData['direccion_completa'] = $certificado->dictamen->inspeccione->solicitud->instalacion->direccion_completa ?? 'No encontrado';
                $nestedData['estatus'] = $certificado->estatus ?? 'No encontrado';
                $nestedData['fecha_emision'] = Helpers::formatearFecha($certificado->fecha_emision);
                $nestedData['fecha_vigencia'] = Helpers::formatearFecha($certificado->fecha_vigencia);
                ///Folio y no. servicio
                $nestedData['num_servicio'] = $certificado->dictamen->inspeccione->num_servicio ?? 'No encontrado';
                $nestedData['folio_solicitud'] = $certificado->dictamen->inspeccione->solicitud->folio ?? 'No encontrado';
                //Nombre y Numero empresa
                $empresa = $certificado->dictamen->inspeccione->solicitud->empresa ?? null;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                    ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                        ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['razon_social'] = $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';
                //Revisiones
                //$nestedData['id_revisor'] = $certificado->revisor && $certificado->revisor->user ? $certificado->revisor->user->name : 'Sin asignar';
                $nestedData['id_revisor2'] = $certificado->revisor && $certificado->revisor->user2 ? $certificado->revisor->user2->name : 'Sin asignar';
                $nestedData['id_revisor'] = $certificado->revisor->user->name ?? null;
                $nestedData['numero_revision'] = $certificado->revisor->numero_revision ?? null;
                $nestedData['decision'] = $certificado->revisor->decision ?? null;
                ///dias vigencia
                $fechaActual = Carbon::now()->startOfDay(); //Asegúrate de trabajar solo con fechas, sin horas
                $nestedData['fecha_actual'] = $fechaActual;
                $nestedData['vigencia'] = $certificado->fecha_vigencia;
                $fechaVigencia = Carbon::parse($certificado->fecha_vigencia)->startOfDay();
                if ($fechaActual->isSameDay($fechaVigencia)) {
                    $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Hoy se vence este certificado</span>";
                } else {
                    $diasRestantes = $fechaActual->diffInDays($fechaVigencia, false);
                    if ($diasRestantes > 0) {
                        if ($diasRestantes > 15) {
                            $res = "<span class='badge bg-success'>$diasRestantes días de vigencia.</span>";
                        } else {
                            $res = "<span class='badge bg-warning'>$diasRestantes días de vigencia.</span>";
                        }
                        $nestedData['diasRestantes'] = $res;
                    } else {
                        $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Vencido hace " . abs($diasRestantes) . " días.</span>";
                    }
                }
                ///solicitud y acta
                $nestedData['id_solicitud'] = $certificado->dictamen->inspeccione->solicitud->id_solicitud ?? 'No encontrado';
                $urls = $certificado->dictamen?->inspeccione?->solicitud?->documentacion(69)?->pluck('url')?->toArray();
                $nestedData['url_acta'] = (!empty($urls)) ? $urls : 'Sin subir';


                $data[] = $nestedData;
            }
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ]);

    }



    ///FUNCION REGISTRAR
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'maestro_mezcalero' => 'nullable|string|max:60',
            'num_autorizacion' => 'nullable|integer',
            'id_firmante' => 'required|integer',
        ]);

        $certificado = Certificados::create([
            'id_dictamen' => $validatedData['id_dictamen'],
            'num_certificado' => $validatedData['num_certificado'],
            'fecha_emision' => $validatedData['fecha_emision'],
            'fecha_vigencia' => $validatedData['fecha_vigencia'],
            'maestro_mezcalero' => $validatedData['maestro_mezcalero'] ?: null,
            'num_autorizacion' => $validatedData['num_autorizacion'] ?: null,
            'id_firmante' => $validatedData['id_firmante']
        ]);
        /*
        $id_instalacion = $certificado->dictamen->inspeccione->solicitud->id_instalacion;
        $instalaciones = instalaciones::find($id_instalacion);
        $instalaciones->folio = $certificado->num_certificado;
        $instalaciones->fecha_emision = $certificado->fecha_emision;
        $instalaciones->fecha_vigencia = $certificado->fecha_vigencia;
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
                
        */
        return response()->json(['message' => 'Registrado correctamente.']);
    }



    ///FUNCION ELIMINAR
    public function destroy($id_certificado)
    {
        try {
            $certificado = Certificados::findOrFail($id_certificado);
            // Eliminar todos los revisores asociados al certificado en la tabla certificados_revision
            Revisor::where('id_certificado', $id_certificado)->delete();
            // Luego, eliminar el certificado
            $certificado->delete();

            return response()->json(['message' => 'Eliminado correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al eliminar', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al eliminar.'], 500);
        }
    }



    ///FUNCION PARA OBTENER LOS REGISTROS
    public function edit($id)
    {
        try {
            $certificado = Certificados::find($id);

            if ($certificado) {
                //return response()->json($certificado);
                return response()->json([
                    'id_certificado' => $certificado->id_certificado,
                    'id_dictamen' => $certificado->id_dictamen,
                    'tipo_dictamen' => $certificado->dictamen->tipo_dictamen ?? null,
                    'num_certificado' => $certificado->num_certificado,
                    'fecha_emision' => $certificado->fecha_emision,
                    'fecha_vigencia' => $certificado->fecha_vigencia,
                    'id_firmante' => $certificado->id_firmante,
                    'maestro_mezcalero' => $certificado->maestro_mezcalero,
                    'num_autorizacion' => $certificado->num_autorizacion,
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error al obtener', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al obtener los datos.'], 500);
        }
    }

    ///FUNCION ACTUALIZAR
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'nullable|date',
            'maestro_mezcalero' => 'nullable|string|max:60',
            'num_autorizacion' => 'nullable|integer',
            'id_firmante' => 'required|integer',
        ]);

        try {
            $certificado = Certificados::findOrFail($id);

            /*
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
            */

            $certificado->id_dictamen = $validated['id_dictamen'];
            $certificado->num_certificado = $validated['num_certificado'];
            $certificado->fecha_emision = $validated['fecha_emision'];
            $certificado->fecha_vigencia = $validated['fecha_vigencia'];
            $certificado->maestro_mezcalero = $validated['maestro_mezcalero'] ?: null;
            $certificado->num_autorizacion = $validated['num_autorizacion'] ?: null;
            $certificado->id_firmante = $validated['id_firmante'];
            $certificado->save();

            /*
            $id_instalacion = $certificado->dictamen->id_instalacion;
            $instalaciones = instalaciones::find($id_instalacion);
            $instalaciones->folio = $certificado->num_certificado;
            $instalaciones->fecha_emision = $certificado->fecha_emision;
            $instalaciones->fecha_vigencia = $certificado->fecha_vigencia;
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
            */

            return response()->json(['message' => 'Actualizado correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al actualizar', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al actualizar.'], 500);
        }
    }



    ///FUNCION REEXPEDIR 
    public function reexpedir(Request $request)
    {
        try {
            $request->validate([
                'accion_reexpedir' => 'required|in:1,2',
                'observaciones' => 'nullable|string',
            ]);

            if ($request->accion_reexpedir == '2') {
                $request->validate([
                    'id_certificado' => 'required|exists:certificados,id_certificado',
                    'id_dictamen' => 'required|integer',
                    'num_certificado' => 'required|string|max:25',
                    'fecha_emision' => 'required|date',
                    'fecha_vigencia' => 'required|date',
                    'maestro_mezcalero' => 'nullable|string|max:60',
                    'num_autorizacion' => 'nullable|integer',
                    'id_firmante' => 'required|integer',
                ]);
            }

            $reexpedir = Certificados::findOrFail($request->id_certificado);

            if ($request->accion_reexpedir == '1') {
                $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;//Actualiza solo 'observaciones'
                $reexpedir->observaciones = json_encode($observacionesActuales);
                $reexpedir->save();

                return response()->json(['message' => 'Cancelado correctamente.']);

            } else if ($request->accion_reexpedir == '2') {
                $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
                $reexpedir->observaciones = json_encode($observacionesActuales);
                $reexpedir->save();

                // Crear un nuevo registro de reexpedición
                $new = new Certificados();
                $new->id_dictamen = $request->id_dictamen;
                $new->num_certificado = $request->num_certificado;
                $new->fecha_emision = $request->fecha_emision;
                $new->fecha_vigencia = $request->fecha_vigencia;
                $new->id_firmante = $request->id_firmante;
                $new->estatus = 2;
                $new->observaciones = json_encode(['id_sustituye' => $request->id_certificado]);
                $new->maestro_mezcalero = $request->maestro_mezcalero ?: null;
                $new->num_autorizacion = $request->num_autorizacion ?: null;
                $new->save();

                return response()->json(['message' => 'Registrado correctamente.']);
            }

            return response()->json(['message' => 'Procesado correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al reexpedir', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error al procesar.'], 500);
        }
    }



    // Funcion LLenar Select
    public function obtenerRevisores(Request $request)
    {
        $tipo = $request->get('tipo');
        $revisores = User::where('tipo', $tipo)->get(['id', 'name']);

        return response()->json($revisores);
    }

       
    ///FUNCION AGREGAR REVISOR
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

            $revisor = Revisor::where('id_certificado', $validatedData['id_certificado'])
            ->where('tipo_certificado', 1)
            ->where('tipo_revision', $validatedData['tipoRevisor']) // buscar según tipo de revisión
            ->first();
        
        $message = '';
        
        if ($revisor) {
            if ($revisor->id_revisor == $validatedData['nombreRevisor']) {
                $message = 'Revisor reasignado.';
            } else {
                $revisor->id_revisor = $validatedData['nombreRevisor'];
                $message = 'Revisor asignado exitosamente.';
            }
        } else {
            $revisor = new Revisor();
            $revisor->id_certificado = $validatedData['id_certificado'];
            $revisor->tipo_certificado = 1;
            $revisor->tipo_revision = $validatedData['tipoRevisor'];
            $revisor->id_revisor = $validatedData['nombreRevisor'];
            $message = 'Revisor asignado exitosamente.';
        }
        
        // Datos comunes
        $revisor->numero_revision = $validatedData['numeroRevision'];
        $revisor->es_correccion = $validatedData['esCorreccion'] ?? 'no';
        $revisor->observaciones = $validatedData['observaciones'] ?? '';
        $revisor->save();
        
        
                $empresa =  $certificado->dictamen->inspeccione->solicitud->empresa;
                $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                    return !empty($numero);
                });
                
        
                // Preparar datos para el correo
                $data1 = [
                    'asunto' => 'Revisión de certificado '. $certificado->num_certificado,
                    'title' => 'Revisión de certificado',
                    'message' => 'Se te ha asignado el certificado ' . $certificado->num_certificado, 
                    'url' => '/add_revision/'.$revisor->id_revision,
                    'nombreRevisor' => $user->name,
                    'emailRevisor' => $user->email,
                    'num_certificado' => $certificado->num_certificado,
                    'fecha_emision' => Helpers::formatearFecha($certificado->fecha_emision),
                    'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia), 
                    'razon_social' => $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'Sin asignar',
                    'numero_cliente' => $numeroCliente ?? 'Sin asignar',
                    'tipo_certificado' => 'Certificado de instalaciones',
                    'observaciones' => $revisor->observaciones,
                ];
        
                // Notificación Local
                $users = User::whereIn('id', [$validatedData['nombreRevisor']])->get();
                foreach ($users as $notifiedUser) {
                    $notifiedUser->notify(new GeneralNotification($data1));
                }

            // Correo a Revisores
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
            }

            return response()->json([
                'message' => $message ?? 'Revisor del OC asignado exitosamente',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al asignar el revisor: ' . $e->getMessage()], 500);
        }
    }



    ///PDF CERTIFICADOS
    public function pdf_certificado_productor($id_certificado, $guardar = false, $rutaGuardado = null)
    {
        $datos = Certificados::with([
            'dictamen.inspeccione.solicitud.empresa',
            'dictamen.instalaciones',
            'dictamen.inspeccione.inspector',
            'firmante'
        ])->findOrFail($id_certificado);

        $empresa = $datos->dictamen->instalaciones->empresa ?? null;
        $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
            ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
            ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
        $id_sustituye = json_decode($datos->observaciones, true)['id_sustituye'] ?? null;//obtiene el valor del JSON/sino existe es null
        $nombre_id_sustituye = $id_sustituye ? Certificados::find($id_sustituye)->num_certificado ?? 'No encontrado' : '';

        $watermarkText = $datos->estatus === 1;

        // Preparar los datos para el PDF
        $pdfData = [
            'datos' => $datos,
            'num_certificado' => $datos->num_certificado ?? 'No encontrado',
            'num_autorizacion' => $datos->num_autorizacion ?? 'No encontrado',
            'num_dictamen' => $datos->dictamen->num_dictamen ?? 'No encontrado',
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),
            'domicilio_fiscal' => $empresa->domicilio_fiscal ?? 'No encontrado',
            'rfc' => $empresa->rfc ?? 'No encontrado',
            'telefono' => $empresa->telefono ?? 'No encontrado',
            'correo' => $empresa->correo ?? 'No encontrado',
            'watermarkText' => $watermarkText,
            'id_sustituye' => $nombre_id_sustituye,
            ///
            'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa ?? 'No encontrado',
            'razon_social' => $empresa->razon_social ?? 'No encontrado',
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------',
            'numero_cliente' => $numero_cliente,
            'representante_legal' => $empresa->representante_legal ?? 'No encontrado',
            'nombre_firmante' => $datos->firmante->name,
            'firma_firmante' => $datos->firmante->firma ?? '',
            'puesto_firmante' => $datos->firmante->puesto ?? '',
            'categorias' => $datos->dictamen->inspeccione->solicitud->categorias_mezcal()->pluck('categoria')->implode(', '),
            'clases' => $datos->dictamen->inspeccione->solicitud->clases_agave()->pluck('clase')->implode(', '),
        ];

        if ($guardar && $rutaGuardado) {
            $pdf = Pdf::loadView('pdfs.Certificado_productor_mezcal', $pdfData);
            $pdf->save($rutaGuardado);
            return $rutaGuardado;
        }

        /*if ( $datos->fecha_emision >= '2025-04-01' ) {
            return Pdf::loadView('pdfs.certificado_productor_ed6', $pdfData)->stream('Certificado de productor de mezcal_ed6.pdf');
        }else{*/
        return Pdf::loadView('pdfs.Certificado_productor_ed6', $pdfData)->stream('Certificado de productor de mezcal.pdf');

        //}
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
            'domicilio_fiscal' => $empresa->domicilio_fiscal,
            'rfc' => $empresa->rfc,
            'watermarkText' => $watermarkText,
            'telefono' => $empresa->telefono,
            'correo' => $empresa->correo,
            'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa,
            'razon_social' => $empresa->razon_social,
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------',
            'numero_cliente' => $numero_cliente ?? 'No encontrado',
            'representante_legal' => $empresa->representante_legal ?? 'No encontrado',
            'nombre_firmante' => $datos->firmante->name ?? 'No encontrado',
            'firma_firmante' => $datos->firmante->firma ?? '',
            'puesto_firmante' => $datos->firmante->puesto ?? '',
            'leyenda' => $leyenda,
            'categorias' => $datos->dictamen->inspeccione->solicitud->categorias_mezcal()->pluck('categoria')->implode(', '),
            'clases' => $datos->dictamen->inspeccione->solicitud->clases_agave()->pluck('clase')->implode(', '),
        ];

        $formato = 'pdfs.certificado_envasador_ed4';

        if ($datos->fecha_emision >= "2025-04-01") {
            $formato = 'pdfs.Certificado_envasador_mezcal_ed6';
        }

        if ($guardar && $rutaGuardado) {
            $pdf = Pdf::loadView($formato, $pdfData);
            $pdf->save($rutaGuardado);
            return $rutaGuardado;
        }

        /*$formato = 'pdfs.certificado_envasador_ed4';
        if ($datos->fecha_emision >= "2025-04-01") {
            $formato = 'pdfs.Certificado_envasador_mezcal_ed6';
        }*/

        // Generar y retornar el PDF
        return Pdf::loadView($formato, $pdfData)->stream('Certificado de envasador de mezcal.pdf');
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
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),
            'domicilio_fiscal' => $empresa->domicilio_fiscal ?? 'No encontrado',
            'rfc' => $empresa->rfc ?? 'No encontrado',
            'telefono' => $empresa->telefono ?? 'No encontrado',
            'correo' => $empresa->correo ?? 'No encontrado',
            'watermarkText' => $watermarkText,
            'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa ?? 'No encontrado',
            'razon_social' => $empresa->razon_social ?? 'No encontrado',
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------',
            'numero_cliente' => $numero_cliente ?? 'No encontrado',
            'representante_legal' => $empresa->representante_legal ?? 'No encontrado',
            'nombre_firmante' => $datos->firmante->name ?? 'Nombre del firmante no disponible',
            'firma_firmante' => $datos->firmante->firma ?? 'No encontrado',
            'puesto_firmante' => $datos->firmante->puesto ?? '',
            'leyenda' => $leyenda ?? 'No encontrado',
            'categorias' => $datos->dictamen->inspeccione->solicitud->categorias_mezcal()->pluck('categoria')->implode(', '),
            'clases' => $datos->dictamen->inspeccione->solicitud->clases_agave()->pluck('clase')->implode(', '),
            // Nuevos campos
            'marcas' => $datos->dictamen->inspeccione->solicitud->marcas()->pluck('marca')->implode(', '),
            'domicilio_unidad' => $empresa->domicilio_unidad ?? 'Domicilio no disponible',
            'convenio_corresponsabilidad' => $datos->convenio_corresponsabilidad ?? 'No especificado',
        ];

        if ($guardar && $rutaGuardado) {
            $pdf = Pdf::loadView('pdfs.Certificado_comercializador', $pdfData);
            $pdf->save($rutaGuardado);
            return $rutaGuardado;
        }
        $pdf = Pdf::loadView('pdfs.Certificado_comercializador', $pdfData);
        return $pdf->stream('Certificado de comercializador.pdf');
    }





    ///SUBIR CERTIFICADO FIRMADO
    public function subirCertificado(Request $request)
    {
        $request->validate([
            'id_certificado' => 'required|exists:certificados,id_certificado',
            'documento' => 'required|mimes:pdf|max:3072',
        ]);

        $certificado = Certificados::findOrFail($request->id_certificado);

        $anio = now()->year;// Obtener año actual
        // Limpiar num_certificado para evitar crear carpetas por error
        $nombreCertificado = preg_replace('/[^A-Za-z0-9_\-]/', '_', $certificado->num_certificado ?? 'No encontrado');
        // Generar nombre de archivo con num_certificado + cadena aleatoria
        $nombreArchivo = $nombreCertificado . '_' . uniqid() . '.pdf'; //uniqid() para asegurar nombre único

        // Ruta de carpeta física donde se guardará
        $rutaCarpeta = "public/certificados_instalaciones_pdf/{$anio}";

        // Eliminar archivo anterior si existe
        if ($certificado->url_pdf_firmado) {
            $rutaAnterior = "{$rutaCarpeta}/{$certificado->url_pdf_firmado}";
            if (Storage::exists($rutaAnterior)) {
                Storage::delete($rutaAnterior);
            }
        }

        // Guardar nuevo archivo
        Storage::putFileAs($rutaCarpeta, $request->file('documento'), $nombreArchivo);

        // Guardar solo el nombre del archivo en la BD
        $certificado->url_pdf_firmado = $nombreArchivo;
        $certificado->save();

        return response()->json(['message' => 'Documento actualizado correctamente.']);
    }

    ///OBTENER CERTIFICADO FIRMADO
    public function CertificadoFirmado($id)
    {
        $certificado = Certificados::findOrFail($id);

        if ($certificado->url_pdf_firmado) {
            // Obtener año actual desde el archivo
            $anio = now()->year;

            // Construir la ruta completa dentro del storage
            $rutaArchivo = "certificados_instalaciones_pdf/{$anio}/" . $certificado->url_pdf_firmado;

            // Comprobar si el archivo existe
            if (Storage::exists("public/{$rutaArchivo}")) {
                return response()->json([
                    'documento_url' => Storage::url($rutaArchivo),  // URL correcta
                    'nombre_archivo' => $certificado->url_pdf_firmado, // Nombre del archivo
                ]);
            } else {
                return response()->json([
                    'documento_url' => null,
                    'nombre_archivo' => null,
                ], 404);
            }
        }

        return response()->json([
            'documento_url' => null,
            'nombre_archivo' => null,
        ]);
    }






}//end-classController
