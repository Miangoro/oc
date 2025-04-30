<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertificadosGranel;
use App\Models\Dictamen_Granel;
use App\Models\User;
use App\Models\tipos;
use App\Models\Revisor;
use App\Models\LotesGranel;
//Notificacion
use App\Notifications\GeneralNotification;
//Enviar Correo
use App\Mail\CorreoCertificado;
use Illuminate\Support\Facades\Mail; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class Certificado_GranelController extends Controller
{
    public function UserManagement()
    {
        $certificados = CertificadosGranel::all(); 
        $dictamenes = Dictamen_Granel::where('estatus','!=',1)->get();
        $users = User::where('tipo',1)->get();
        $revisores = Revisor::all(); 
        return view('certificados.find_certificados_granel', compact('certificados' , 'dictamenes' , 'users', 'revisores'));
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
    $totalData = CertificadosGranel::count();
    $totalFiltered = $totalData;
    $limit = $request->input('length');
    $start = $request->input('start');
    $orderIndex = $request->input('order.0.column');
    $orderDir = $request->input('order.0.dir');

    $order = $columns[$orderIndex] ?? 'id_dictamen';
    $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';

    $query = CertificadosGranel::with(['dictamen.inspeccione.solicitud.empresa'])
        ->when($search, function($q, $search) {
        $q->orWhere('id_firmante', 'LIKE', "%{$search}%")
            ->orWhere('fecha_emision', 'LIKE', "%{$search}%")
            ->orWhere('fecha_vigencia', 'LIKE', "%{$search}%");
    })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir);

            $certificados = $query->get();

    if ($search) {
        $totalFiltered = CertificadosGranel::where('id_firmante', 'LIKE', "%{$search}%")
            ->orWhere('fecha_emision', 'LIKE', "%{$search}%")
            ->orWhere('fecha_vigencia', 'LIKE', "%{$search}%")
            ->count();
    }

    /*$data = $certificados->map(function ($certificado) use (&$start) {
    $empresa = $certificado->dictamen->empresa;
    $numero_cliente = $empresa ? $empresa->empresaNumClientes->firstWhere('empresa_id', $empresa->id)->numero_cliente : 'N/A';

    $lote = $certificado->dictamen->lote_granel;
    $tipoNombres = 'N/A';
    if (!empty($lote->id_tipo)) {
        $idTipos = json_decode($lote->id_tipo, true); // Decodificar JSON
        if (json_last_error() === JSON_ERROR_NONE && is_array($idTipos)) {
            $tiposNombres = \App\Models\tipos::whereIn('id_tipo', $idTipos)->pluck('nombre')->toArray();
            $tipoNombres = !empty($tiposNombres) ? implode(', ', $tiposNombres) : 'Sin coincidencias';
        } else {
            $tipoNombres = 'Formato inválido';
        }
    }

    return [
        'fake_id' => ++$start,
        'id_certificado' => $certificado->id_certificado,
        'id_dictamen' => $certificado->dictamen->num_dictamen ?? 'N/A',
        'id_firmante' => $certificado->user->name ?? 'N/A',
        'fecha_emision' => Helpers::formatearFecha($certificado->fecha_emision),
        'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
        'num_certificado' => $certificado->num_certificado,
        'razon_social' => $empresa->razon_social ?? 'N/A',
        'numero_cliente' => $numero_cliente,
        'id_revisor' => $certificado->revisor && $certificado->revisor->user ? $certificado->revisor->user->name : 'Sin asignar',
        'id_revisor2' => $certificado->revisor && $certificado->revisor->user2 ? $certificado->revisor->user2->name : 'Sin asignar',
        'estatus' => $certificado->estatus,

        // Datos del Certificado
        'clase' => $certificado->dictamen->lote_granel->clase->clase ?? 'N/A',
        'ingredientes' => $certificado->dictamen->lote_granel->ingredientes ?? 'N/A',
        'tipo' => $tipoNombres, // Incluye los nombres de los tipos
        'lote' => $certificado->dictamen->lote_granel->nombre_lote ?? 'N/A',
        'volumen' => $certificado->dictamen->lote_granel->volumen ?? 'N/A',
        'edad' => $certificado->dictamen->lote_granel->edad ?? 'N/A',
        'analisis' => $certificado->dictamen->lote_granel->folio_fq ?? 'N/A',
        'cont_alc' => $certificado->dictamen->lote_granel->cont_alc ?? 'N/A',
    ];
    });*/
    $data = [];
    if (!empty($certificados)) {
        foreach ($certificados as $certificado) {
            $nestedData['id_certificado'] = $certificado->id_certificado ?? 'No encontrado';
            $nestedData['num_certificado'] = $certificado->num_certificado ?? 'No encontrado';
            $nestedData['id_dictamen'] = $certificado->dictamen->id_dictamen ?? 'No encontrado';
            $nestedData['num_dictamen'] = $certificado->dictamen->num_dictamen ?? 'No encontrado';
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
            $nestedData['id_revisor'] = $certificado->revisor && $certificado->revisor->user ? $certificado->revisor->user->name : 'Sin asignar';
            $nestedData['id_revisor2'] = $certificado->revisor && $certificado->revisor->user2 ? $certificado->revisor->user2->name : 'Sin asignar';
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
            //Lote granel
            $caracteristicas = json_decode($certificado->dictamen?->inspeccione?->solicitud?->caracteristicas, true);
                $idLote = $caracteristicas['id_lote_granel'] ?? null;
            $nestedData['nombre_lote'] = LotesGranel::find($idLote)?->nombre_lote ?? 'No encontrado';


            $data[] = $nestedData;
        }
    }

    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'code' => 200,
        'data' => $data,
    ]);
}



///FUNCION REGISTRAR
public function store(Request $request)
{
    try {
    $validated = $request->validate([
        'id_dictamen' => 'required|integer',
        'num_certificado' => 'required|string',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
        'id_firmante' => 'required|integer',
    ]);

    $new = CertificadosGranel::create([
        'id_dictamen' => $validated['id_dictamen'],
        'num_certificado' => $validated['num_certificado'],
        'fecha_emision' => $validated['fecha_emision'],
        'fecha_vigencia' => $validated['fecha_vigencia'],
        'id_firmante' => $validated['id_firmante']
    ]);
    
        return response()->json(['message' => 'Registrado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al registrar', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al registrar.'], 500);
    }
}



///FUNCION ELIMINAR
public function destroy($id_certificado)
{
    try {
        // Buscar el certificado
        $eliminar = CertificadosGranel::findOrFail($id_certificado);

        // Eliminar todos los revisores asociados al certificado en la tabla certificados_revision
        Revisor::where('id_certificado', $id_certificado)->delete();

        // Luego, eliminar el certificado
        $eliminar->delete();

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
    $certificado = CertificadosGranel::find($id);

    if ($certificado) {
        return response()->json($certificado);
    }

    return response()->json(['error' => 'Error al obtener los datos.'], 500);
}
    
///FUNCION ACTUALIZAR
public function update(Request $request, $id_certificado)
{
    $validated = $request->validate([
        'id_firmante' => 'required|integer',
        'id_dictamen' => 'required|integer',
        'num_certificado' => 'required|string',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
    ]);

    try {
        $actualizar = CertificadosGranel::findOrFail($id_certificado);
        
        $actualizar->update([
            'id_firmante' => $validated['id_firmante'],
            'id_dictamen' => $validated['id_dictamen'],
            'num_certificado' => $validated['num_certificado'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_vigencia' => $validated['fecha_vigencia'],
        ]);

        return response()->json(['message' => 'Actualizado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al actualizar', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al actualizar.'], 500);
    }
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
            'id_certificado' => 'required|integer|exists:certificados_granel,id_certificado',
        ]);
        
        $user = User::find($validatedData['nombreRevisor']);
        if (!$user) {
            return response()->json(['message' => 'El revisor no existe.'], 404);
        }

        $certificado = CertificadosGranel::find($validatedData['id_certificado']);
        if (!$certificado) {
            return response()->json(['message' => 'El certificado no existe.'], 404);
        }

        $revisor = Revisor::where('id_certificado', $validatedData['id_certificado'])->where('tipo_certificado',2)->first();
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
        $revisor->tipo_certificado = 2; //El 2 corresponde al certificado de granel
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
            'fecha_emision' => Helpers::formatearFecha($certificado->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia), 
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
            'id_firmante' => 'required|integer',
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'observaciones' => 'nullable|string',
            ]);
        }

        $reexpedir = CertificadosGranel::findOrFail($request->id_certificado);

        if ($request->accion_reexpedir == '1') {
            $reexpedir->estatus = 1; 
            $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
            $reexpedir->observaciones = json_encode($observacionesActuales); 
            $reexpedir->save();
            return response()->json(['message' => 'Cancelado correctamente.']);

        } elseif ($request->accion_reexpedir == '2') {
            $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
            $reexpedir->observaciones = json_encode($observacionesActuales);
            $reexpedir->save(); 

            // Crear un nuevo registro de certificado (reexpedición)
            $new = new CertificadosGranel();
            $new->id_dictamen = $request->id_dictamen;
            $new->num_certificado = $request->num_certificado;
            $new->fecha_emision = $request->fecha_emision;
            $new->fecha_vigencia = $request->fecha_vigencia;
            $new->id_firmante = $request->id_firmante;
            $new->estatus = 2;
            $new->observaciones = json_encode(['id_sustituye' => $request->id_certificado]);
            // Guarda el nuevo certificado
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



///PDF CERTIFICADO
public function CertificadoGranel($id_certificado)
{
    $certificado = CertificadosGranel::find($id_certificado);

    if (!$certificado) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
    }

    $direccionCompleta = $certificado->dictamen->inspeccione->solicitud->empresa->instalaciones->first()->direccion_completa ?? 'N/A';
    $clase = $certificado->dictamen->lote_granel->clase->clase ?? 'N/A';
    $ingredientes = $certificado->dictamen->lote_granel->ingredientes ?? 'N/A';
    $volumen = $certificado->dictamen->lote_granel->volumen ?? 'N/A';
    $nombre_lote = $certificado->dictamen->lote_granel->nombre_lote ?? 'N/A';
    $edad = $certificado->dictamen->lote_granel->edad ?? 'N/A';
    $cont_alc = $certificado->dictamen->lote_granel->cont_alc ?? 'N/A';
    $folio_fq = $certificado->dictamen->lote_granel->folio_fq ?? 'N/A';
    $num_dictamen = $certificado->dictamen->num_dictamen ?? 'N/A';
    $watermarkText = $certificado->estatus === 1;
    $leyenda = $certificado->estatus === 2;

    // Procesar los nombres de los tipos
    $tipoNombres = 'N/A';
    /*if ($certificado->dictamen->lote_granel->id_tipo) {
        $idTipos = json_decode($certificado->dictamen->lote_granel->id_tipo, true);
        if (is_array($idTipos)) {
            $tipoNombresArray = tipos::whereIn('id_tipo', $idTipos)->pluck('nombre')->toArray();
            $tipoNombres = implode(', ', $tipoNombresArray);
        }
    }*/

    // Datos para el PDF
    $pdfData = [
        // Tabla #1
        'num_certificado' => $certificado->num_certificado ?? '',
        'razon_social' => $certificado->dictamen->empresa->razon_social ?? '',
        'representante' => $certificado->dictamen->empresa->representante ?? '',
        'domicilio_fiscal' => $certificado->dictamen->empresa->domicilio_fiscal ?? '',
        'rfc' => $certificado->dictamen->empresa->rfc ?? '',
        'direccion_completa' => $direccionCompleta ?? '',
        'fecha_emision' => Helpers::formatearFecha($certificado->fecha_emision),
        'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
        'watermarkText' => $watermarkText,
        'leyenda' => $leyenda ?? '',

        // Tabla #2
        'lote' => $clase ?? '',
        'ingredientes' => $ingredientes ?? '',
        'volumen' => $volumen ?? '',
        'nombre_lote' => $nombre_lote ?? '',
        'edad' => $edad ?? '',
        'cont_alc' => $cont_alc ?? '',
        'folio_fq' => $folio_fq ?? '',
        'num_dictamen' => $num_dictamen ?? '',
        'tipo' => $tipoNombres ?? '',
    ];

    // Generar y mostrar el PDF
    return Pdf::loadView('pdfs.certificado_granel_ed7', $pdfData)->stream("F7.1-01-07 Certificado NOM de Mezcal a Granel.pdf");
}




///SUBIR CERTIFICADO FIRMADO
public function subirCertificado(Request $request)
{
    $request->validate([
        'id_certificado' => 'required|exists:certificados_granel,id_certificado',
        'documento' => 'required|mimes:pdf|max:3072',
    ]);

    $certificado = CertificadosGranel::findOrFail($request->id_certificado);

    $anio = now()->year;// Obtener año actual
    // Limpiar num_certificado para evitar crear carpetas por error
    $nombreCertificado = preg_replace('/[^A-Za-z0-9_\-]/', '_', $certificado->num_certificado ?? 'No encontrado');
    // Generar nombre de archivo con num_certificado + cadena aleatoria
    $nombreArchivo = $nombreCertificado.'_'. uniqid() .'.pdf'; //uniqid() para asegurar nombre único

    // Ruta de carpeta física donde se guardará
    $rutaCarpeta = "public/certificados_granel_pdf/{$anio}";

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
    $certificado = CertificadosGranel::findOrFail($id);

    if ($certificado->url_pdf_firmado) {
        // Obtener año actual desde el archivo
        $anio = now()->year;

        // Construir la ruta completa dentro del storage
        $rutaArchivo = "certificados_granel_pdf/{$anio}/" . $certificado->url_pdf_firmado;

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