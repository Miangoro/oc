<?php

namespace App\Http\Controllers\certificados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\Certificado_Exportacion;
use App\Models\Dictamen_Exportacion; 
use App\Models\User;
use App\Models\empresa; 
use App\Models\Revisor; 
use App\Models\lotes_envasado;
///Extensiones
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class Certificado_ExportacionController extends Controller
{

    
    public function UserManagement()
    {
        $certificado = Certificado_Exportacion::all(); // Obtener todos los datos
        $dictamen = Dictamen_Exportacion::all();
        $users = User::where('tipo',1)->get(); //Solo inspectores 
        $empresa = empresa::all();
        $revisores = Revisor::all(); 

        return view('certificados.certificado_exportacion', compact('certificado', 'dictamen', 'users', 'empresa', 'revisores'));
    }


public function index(Request $request)
{
    $columns = [
    //CAMPOS PARA ORDENAR LA TABLA DE INICIO "thead"
        1 => 'num_certificado',
        2 => 'id_dictamen',
        3 => 'razon_social',
        4 => 'fecha_emision',
    ];

    $search = [];
    $totalData = Certificado_Exportacion::count();
    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');


    if (empty($request->input('search.value'))) {
        // ORDENAR EL BUSCADOR "thead"
        $users = Certificado_Exportacion::where('id_dictamen', 'LIKE', "%{$request->input('search.value')}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

    } else {
    // BUSCADOR
    $search = $request->input('search.value');

    // Consulta con filtros
    $query = Certificado_Exportacion::where('id_dictamen', 'LIKE', "%{$search}%")
    ->where("id_dictamen", 1)
    ->orWhere('num_certificado', 'LIKE', "%{$search}%");

    $users = $query->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

    $totalFiltered = Certificado_Exportacion::where('id_dictamen', 'LIKE', "%{$search}%")
        ->where("id_dictamen", 1)
        ->orWhere('num_certificado', 'LIKE', "%{$search}%")
        ->count();
    }
    

    //MANDA LOS DATOS AL JS
    $data = [];

    if (!empty($users)) {
        $ids = $start;
        foreach ($users as $user) {
            $nestedData['id_certificado'] = $user->id_certificado ?? 'No encontrado';
            $nestedData['dictamen'] = $user->dictamen->id_dictamen ?? 'No encontrado';
            $nestedData['num_certificado'] = $user->num_certificado ?? 'No encontrado';
            $nestedData['estatus'] = $user->estatus ?? 'No encontrado';
            ///Folio y no. servicio
            $nestedData['folio'] = $user->dictamen->inspeccione->solicitud->folio ?? 'No encontrado';
            $nestedData['n_servicio'] = $user->dictamen->inspeccione->num_servicio ?? 'No encontrado';
            //Nombre y Numero empresa
            $empresa = $user->dictamen->inspeccione->solicitud->empresa ?? null;
            $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
            $nestedData['numero_cliente'] = $numero_cliente;
            $nestedData['razon_social'] = $user->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';
            //Fecha emisión y vigencia
            $fecha_emision = Helpers::formatearFecha($user->fecha_emision);
            $fecha_vigencia = Helpers::formatearFecha($user->fecha_vigencia);
            $nestedData['fechas'] = '<b>Expedición: </b>' .$fecha_emision. '<br> <b>Vigencia: </b>' .$fecha_vigencia;
            //Revisiones
            $nestedData['id_revisor'] = $user->revisor && $user->revisor->user ? $user->revisor->user->name : 'Sin asignar';
            $nestedData['id_revisor2'] = $user->revisor && $user->revisor->user2 ? $user->revisor->user2->name : 'Sin asignar';
            
            $data[] = $nestedData;
        }
    }

    if ($data) {
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
    } else {
        return response()->json([
            'message' => 'Internal Server Error',
            'code' => 500,
            'data' => [],
        ]);
    }
}




///FUNCION REGISTRAR
public function store(Request $request)
{
    try {
        // Crear y guardar
        $var = new Certificado_Exportacion();
        $var->num_certificado = $request->num_certificado;
        $var->id_dictamen = $request->id_dictamen;
        $var->fecha_emision = $request->fecha_emision;
        $var->fecha_vigencia = $request->fecha_vigencia;
        $var->id_firmante = $request->id_firmante;
        $var->save(); // Guardar en BD

        return response()->json(['success' => 'Registro agregado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Ocurrió un error al agregar'], 500);
    }
}



///FUNCION ELIMINAR
public function destroy($id_certificado)
{
    try {
        $eliminar = Certificado_Exportacion::findOrFail($id_certificado);
        $eliminar->delete();

        return response()->json(['success' => 'Eliminado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar'], 500);
    }
}



///FUNCION PARA OBTENER LOS REGISTROS
public function edit($id_certificado)
{
    try {
        $var1 = Certificado_Exportacion::findOrFail($id_certificado);

        return response()->json([
            'id_certificado' => $var1->id_certificado,
            'id_dictamen' => $var1->id_dictamen,
            'num_certificado' => $var1->num_certificado,
            'fecha_emision' => $var1->fecha_emision,
            'fecha_vigencia' => $var1->fecha_vigencia,
            'id_firmante' => $var1->id_firmante,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener'], 500);
    }
}

///FUNCION ACTUALIZAR
public function update(Request $request, $id_certificado) 
{
    $request->validate([
        'num_certificado' => 'required|string|max:255',
        'id_dictamen' => 'required|integer',
        'fecha_emision' => 'nullable|date',
        'fecha_vigencia' => 'nullable|date',
        'id_firmante' => 'required|integer',
    ]);

    try {
        $var2 = Certificado_Exportacion::findOrFail($id_certificado);
        $var2->num_certificado = $request->num_certificado;
        $var2->id_dictamen = $request->id_dictamen;
        $var2->fecha_emision = $request->fecha_emision;
        $var2->fecha_vigencia = $request->fecha_vigencia;
        $var2->id_firmante = $request->id_firmante;
        $var2->save();

        return response()->json(['success' => 'Registro editado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al editar'], 500);
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
                'num_certificado' => 'required|string|max:25',
                'id_dictamen' => 'required|integer',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'required|date',
                'id_firmante' => 'required|integer',
                /*'maestro_mezcalero' => 'nullable|string|max:60',
                'num_autorizacion' => 'nullable|integer',*/
            ]);
        }

        $certificado = Certificado_Exportacion::findOrFail($request->id_certificado);

        if ($request->accion_reexpedir == '1') {
            $certificado->estatus = 1; 
            //$certificado->observaciones = $request->observaciones;
                // Decodificar el JSON actual
                $observacionesActuales = json_decode($certificado->observaciones, true);
                // Actualiza solo 'observaciones' sin modificar 'id_certificado_sustituye'
                $observacionesActuales['observaciones'] = $request->observaciones;
                // Volver a codificar el array y asignarlo a $certificado->observaciones
            $certificado->observaciones = json_encode($observacionesActuales); 
            $certificado->save();
        } elseif ($request->accion_reexpedir == '2') {
            $certificado->estatus = 1;
                $observacionesActuales = json_decode($certificado->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
            $certificado->observaciones = json_encode($observacionesActuales);
            $certificado->save(); 

            // Crear un nuevo registro de certificado (reexpedición)
            $nuevoCertificado = new Certificado_Exportacion();
            $nuevoCertificado->num_certificado = $request->num_certificado;
            $nuevoCertificado->id_dictamen = $request->id_dictamen;
            $nuevoCertificado->fecha_emision = $request->fecha_emision;
            $nuevoCertificado->fecha_vigencia = $request->fecha_vigencia;
            $nuevoCertificado->id_firmante = $request->id_firmante;
            $nuevoCertificado->estatus = 2;
            $nuevoCertificado->observaciones = json_encode([
                'id_certificado_sustituye' => $request->id_certificado,
                ]);
            /*$nuevoCertificado->maestro_mezcalero = $request->maestro_mezcalero ?: null;
            $nuevoCertificado->num_autorizacion = $request->num_autorizacion ?: null;*/
            // Guarda el nuevo certificado
            $nuevoCertificado->save();
        }

        return response()->json(['message' => 'Certificado procesado correctamente.']);
    } catch (\Exception $e) {
        Log::error($e);
        return response()->json(['message' => 'Error al procesar el certificado.', 'error' => $e->getMessage()], 500);
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
            'id_certificado' => 'required|integer|exists:certificados_exportacion,id_certificado',
        ]);
        
        $user = User::find($validatedData['nombreRevisor']);
        if (!$user) {
            return response()->json(['message' => 'El revisor no existe.'], 404);
        }

        $certificado = Certificado_Exportacion::find($validatedData['id_certificado']);
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
        $revisor->tipo_certificado = 1;
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
        /*$users = User::whereIn('id', [18, 19, 20])->get();
        foreach ($users as $notifiedUser) {
            $notifiedUser->notify(new GeneralNotification($data1));
        }*/

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



///PDF CERTIFICADO
public function MostrarCertificadoExportacion($id_certificado) 
{
    $data = Certificado_Exportacion::find($id_certificado);//Obtener datos del certificado

    if (!$data) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
    }

    //$fecha = Helpers::formatearFecha($data->fecha_emision);
    //$fecha = Carbon::createFromFormat('Y-m-d H:i:s', $data->fecha_emision);//fecha y hora
    $fecha_emision = Carbon::parse($data->fecha_emision);
        $fecha1 = $fecha_emision->translatedFormat('d/m/Y');
    $fecha_vigencia = Carbon::parse($data->fecha_vigencia);
        $fecha2 = $fecha_vigencia->translatedFormat('d/m/Y');
    $empresa = $data->dictamen->inspeccione->solicitud->empresa ?? null;
    $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty() 
        ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
        ->id && !empty($item->numero_cliente)) ?->numero_cliente ?? 'No encontrado' : 'N/A';
    //Determinar si la marca de agua debe ser visible
    $watermarkText = $data->estatus == 1;
    //Obtener un valor específico del JSON
    $id_sustituye = json_decode($data->observaciones, true)//Decodifica el JSON actual
    ['id_certificado_sustituye'] ?? null;//obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ?//verifica si la variable $id_sustituye tiene valor asociado 
    //Busca el registro del certificado que tiene el id igual a $id_sustituye
    Certificado_Exportacion::find($id_sustituye)->num_certificado ?? '' : '';

    $datos = $data->dictamen->inspeccione->solicitud->caracteristicas ?? null; //Obtener Características Solicitud
        $caracteristicas =$datos ? json_decode($datos, true) : []; //Decodificar el JSON
        $aduana_salida = $caracteristicas['aduana_salida'] ?? '';
        $no_pedido = $caracteristicas['no_pedido'] ?? '';
        $detalles = $caracteristicas['detalles'] ?? [];//Acceder a detalles (que es un array)
        // Acceder a los detalles
        foreach ($detalles as $detalle) {
            $botellas = $detalle['cantidad_botellas'] ?? '';
            $cajas = $detalle['cantidad_cajas'] ?? '';
            $presentacion = $detalle['presentacion'] ?? '';
        }
        // Obtener todos los IDs de los lotes
        $loteIds = collect($detalles)->pluck('id_lote_envasado')->filter()->all();//elimina valor vacios y devuelve array
        // Buscar los lotes envasados
        $lotes = !empty($loteIds) ? lotes_envasado::whereIn('id_lote_envasado', $loteIds)->get()
            : collect(); // Si no hay IDs, devolvemos una colección vacía
        /*$lotes = collect();//mutliples lotes
        foreach (json_decode($datos)->detalles as $detalle) {
            $lote = Lotes_Envasado::find($detalle->id_lote_envasado);//compara el valor "id_lote_envasado" con "Lotes_Envasado"
            if ($lote) {
                $lotes->push($lote);//Agregar el lote a la colección
            }
        }*/
       
    //return response()->json(['message' => 'No se encontraron características.', $data], 404)


    $pdf = Pdf::loadView('pdfs.certificado_exportacion_ed12', [//formato del PDF
        'data' => $data,//declara todo = {{ $data->inspeccione->num_servicio }}
        'lotes' =>$lotes,
        'expedicion' => $fecha1 ?? "",
        'vigencia' => $fecha2 ?? "",
        'n_cliente' => $numero_cliente,
        'empresa' => $data->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado',
        'domicilio' => $data->dictamen->inspeccione->solicitud->empresa->domicilio_fiscal ?? 'No encontrado',
        'estado' => $data->dictamen->inspeccione->solicitud->empresa->estados->nombre ?? 'No encontrado',
        'rfc' => $data->dictamen->inspeccione->solicitud->empresa->rfc ?? 'No encontrado',
        'cp' => $data->dictamen->inspeccione->solicitud->empresa->cp ?? 'No encontrado',
        'convenio' => $data->dictamen->inspeccione->solicitud->empresa->convenio_corresp ?? 'NA',
        'DOM' => $data->dictamen->inspeccione->solicitud->empresa->registro_productor ?? 'NA',
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,
        'nombre_destinatario' => $data->dictamen->inspeccione->solicitud->direccion_destino->destinatario ?? 'No encontrado',
        'dom_destino' => $data->dictamen->inspeccione->solicitud->direccion_destino->direccion ?? 'No encontrado',
        'pais' => $data->dictamen->inspeccione->solicitud->direccion_destino->pais_destino ?? 'No encontrado',
        ///caracteristicas
        'aduana' => $aduana_salida ?? 'No encontrado',
        'n_pedido' => $no_pedido ?? 'No encontrado',
        'botellas' => $botellas ?? 'No encontrado',
        'cajas' => $cajas ?? 'No encontrado',
        'presentacion' => $presentacion ?? 'No encontrado',
    ]);

    //nombre al descargar
    return $pdf->stream('F7.1-01-23 Ver 12. Certificado de Autenticidad de Exportación de Mezcal.pdf');
}


///PDF SOLICITUD CERTIFICADO
public function MostrarSolicitudCertificadoExportacion($id_certificado) 
{
    $data = Certificado_Exportacion::find($id_certificado);
    if (!$data) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
    }

    $fecha = Helpers::formatearFecha($data->fecha_emision);
    //$fecha = Carbon::createFromFormat('Y-m-d H:i:s', $data->fecha_emision);//fecha y hora
    /*$fecha_emision = Carbon::parse($data->fecha_emision);
        $fecha1 = $fecha_emision->translatedFormat('d/m/Y');
    $fecha_vigencia = Carbon::parse($data->fecha_vigencia);
        $fecha2 = $fecha_vigencia->translatedFormat('d/m/Y');*/
    $empresa = $data->dictamen->inspeccione->solicitud->empresa ?? null;
    $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty() ? $empresa
        ->empresaNumClientes
        ->first(fn($item) => $item->empresa_id === $empresa
        ->id && !empty($item->numero_cliente)) ?->numero_cliente ?? 'N/A' : 'N/A';
    $watermarkText = $data->estatus == 1;//Determinar si marca de agua es visible
    $id_sustituye = json_decode($data->observaciones, true)//Decodifica el JSON
        ['id_sustituye'] ?? null;//obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ?//verifica si $id_sustituye tiene valor  
        //Busca el registro del certificado que tiene el id igual a $id_sustituye
        Certificado_Exportacion::find($id_sustituye)->num_certificado ?? '' : '';

    $datos = $data->dictamen?->inspeccione?->solicitud?->caracteristicas; //Obtener Características Solicitud
        $caracteristicas =$datos ? json_decode($datos, true) : []; //Decodificar el JSON
        $aduana_salida = $caracteristicas['aduana_salida'] ?? '';
        $no_pedido = $caracteristicas['no_pedido'] ?? '';
        $detalles = $caracteristicas['detalles'] ?? [];//Acceder a detalles (que es un array)
        foreach ($detalles as $detalle) {// Acceder a los detalles
            $botellas = $detalle['cantidad_botellas'] ?? '';
            $cajas = $detalle['cantidad_cajas'] ?? '';
            $presentacion = $detalle['presentacion'] ?? '';
        }
        $loteIds = collect($detalles)->pluck('id_lote_envasado')->filter()->all();//elimina valor vacios y devuelve array
        $lotes = !empty($loteIds) ? lotes_envasado::whereIn('id_lote_envasado', $loteIds)->get()
            : collect(); // Si no hay IDs, devolvemos una colección vacía

    //return response()->json(['message' => 'No se encontraron características.', $data], 404);


    $pdf = Pdf::loadView('pdfs.solicitud_certificado_exportacion_ed10', [//formato del PDF
        'data' => $data,
        'lotes' =>$lotes,
        'expedicion' => $fecha ?? "",
        'vigencia' => $fecha2 ?? "",
        'n_cliente' => $numero_cliente,
        'empresa' => $data->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado',
        'domicilio' => $data->dictamen->inspeccione->solicitud->empresa->domicilio_fiscal ?? 'No encontrado',
        'estado' => $data->dictamen->inspeccione->solicitud->empresa->estados->nombre ?? 'No encontrado',
        'rfc' => $data->dictamen->inspeccione->solicitud->empresa->rfc ?? 'No encontrado',
        'cp' => $data->dictamen->inspeccione->solicitud->empresa->cp ?? 'No encontrado',
        'convenio' => $data->dictamen->inspeccione->solicitud->empresa->convenio_corresp ?? 'NA',
        'DOM' => $data->dictamen->inspeccione->solicitud->empresa->registro_productor ?? 'NA',
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,
        'nombre_destinatario' => $data->dictamen->inspeccione->solicitud->direccion_destino->destinatario ?? 'No encontrado',
        'dom_destino' => $data->dictamen->inspeccione->solicitud->direccion_destino->direccion ?? 'No encontrado',
        'pais' => $data->dictamen->inspeccione->solicitud->direccion_destino->pais_destino ?? 'No encontrado',
        ///caracteristicas
        'aduana' => $aduana_salida ?? 'No encontrado',
        'n_pedido' => $no_pedido ?? 'No encontrado',
        'botellas' => $botellas ?? 'No encontrado',
        'cajas' => $cajas ?? 'No encontrado',
        'presentacion' => $presentacion ?? 'No encontrado',
    ]);
    //nombre al descargar
    return $pdf->stream('F7.1-01-21 Ver 10. Solicitud de emisión de Certificado para Exportación.pdf');
}





}//end-classController
