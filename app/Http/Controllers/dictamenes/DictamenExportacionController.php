<?php

namespace App\Http\Controllers\dictamenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\Dictamen_Exportacion;
use App\Models\inspecciones; 
use App\Models\User;
use App\Models\empresa; 
use App\Models\lotes_envasado;
//Extensiones
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Notifications\GeneralNotification;
use Faker\Extension\Helper;


class DictamenExportacionController extends Controller
{


    public function UserManagement()
    {
        $dictamenes = Dictamen_Exportacion::all(); // Obtener todos los datos
        $users = User::where('tipo',2)->get(); //Solo inspectores 
        $inspeccion = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 11);
        })
        ->orderBy('id_inspeccion', 'desc')
        ->get();
        $empresa = empresa::all();

        return view('dictamenes.dictamen_exportacion', compact('dictamenes', 'inspeccion', 'users', 'empresa'));
    }


public function index(Request $request)
{
    $columns = [
    //CAMPOS PARA ORDENAR LA TABLA DE INICIO "thead"
        1 => 'num_dictamen',
        2 => 'id_inspeccion',
        3 => 'razon_social',
        4 => 'fecha_emision',
    ];

    $search = [];
    
    $totalData = Dictamen_Exportacion::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');


    if (empty($request->input('search.value'))) {
        // ORDENAR EL BUSCADOR "thead"
        $users = Dictamen_Exportacion::where('id_dictamen', 'LIKE', "%{$request->input('search.value')}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
        // BUSCADOR
        $search = $request->input('search.value');
    
    
        // Consulta con filtros
        $query = Dictamen_Exportacion::where('id_dictamen', 'LIKE', "%{$search}%")
        ->where("id_dictamen", 1)
        ->orWhere('num_dictamen', 'LIKE', "%{$search}%");

        $users = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = Dictamen_Exportacion::where('id_dictamen', 'LIKE', "%{$search}%")
            ->where("id_dictamen", 1)
            ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
            ->count();
    }
    

    //MANDA LOS DATOS AL JS
    $data = [];

    if (!empty($users)) {
        $ids = $start;
        foreach ($users as $user) {
            $nestedData['id_dictamen'] = $user->id_dictamen;
            $nestedData['num_dictamen'] = $user->num_dictamen;
            $nestedData['estatus'] = $user->estatus;
            $nestedData['id_inspeccion'] = $user->inspeccione->num_servicio;
            ///numero y nombre empresa
            $empresa = $user->inspeccione->solicitud->empresa;
            $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
            ? $empresa->empresaNumClientes
                ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
            : 'N/A';
            $nestedData['numero_cliente'] = $numero_cliente;
            $nestedData['razon_social'] = $user->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';

            $fecha_emision = Helpers::formatearFecha($user->fecha_emision);
            $fecha_vigencia = Helpers::formatearFecha($user->fecha_vigencia);
            $nestedData['fechas'] = '<b>Fecha Emisión: </b>' .$fecha_emision. '<br> <b>Fecha Vigencia: </b>' .$fecha_vigencia;
            
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




//FUNCION PARA REGISTRAR
public function store(Request $request)
{
    try {
        // Crear y guardar el nuevo dictamen
        $var = new Dictamen_Exportacion();
        $var->num_dictamen = $request->num_dictamen;
        $var->id_inspeccion = $request->id_inspeccion;
        $var->fecha_emision = $request->fecha_emision;
        $var->fecha_vigencia = $request->fecha_vigencia;
        $var->id_firmante = $request->id_firmante;
        $var->save(); // Guardar en BD

        return response()->json(['success' => 'Registro agregado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Ocurrió un error al intentar agregar el registro'], 500);
    }
}




//FUNCION PARA ELIMINAR
public function destroy($id_dictamen)
{
    try {
        $eliminar = Dictamen_Exportacion::findOrFail($id_dictamen);
        $eliminar->delete();

        return response()->json(['success' => 'Eliminado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar'], 500);
    }
}




//FUNCION PARA LLENAR EL FORMULARIO
public function edit($id_dictamen)
{
    try {
        $var1 = Dictamen_Exportacion::findOrFail($id_dictamen);

        return response()->json([
            'id_dictamen' => $var1->id_dictamen,
            'num_dictamen' => $var1->num_dictamen,
            'id_inspeccion' => $var1->id_inspeccion,
            'fecha_emision' => $var1->fecha_emision,
            'fecha_vigencia' => $var1->fecha_vigencia,
            'id_firmante' => $var1->id_firmante,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener el dictamen'], 500);
    }
}

//FUNCION PARA EDITAR
    public function update(Request $request, $id_dictamen) 
{
    $request->validate([
        'num_dictamen' => 'required|string|max:255',
        'id_inspeccion' => 'required|integer',
        'fecha_emision' => 'nullable|date',
        'fecha_vigencia' => 'nullable|date',
        'id_firmante' => 'required|integer',
    ]);
    try {
        $var2 = Dictamen_Exportacion::findOrFail($id_dictamen);
        $var2->num_dictamen = $request->num_dictamen;
        $var2->id_inspeccion = $request->id_inspeccion;
        $var2->fecha_emision = $request->fecha_emision;
        $var2->fecha_vigencia = $request->fecha_vigencia;
        $var2->id_firmante = $request->id_firmante;
        $var2->save();

        return response()->json(['success' => 'Editado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al editar'], 500);
    }
}




///FUNCION PDF DICTAMEN EXPORTACION
public function MostrarDictamenExportacion($id_dictamen) 
{
    // Obtener los datos del dictamen específico
    //$datos = Dictamen_Exportacion::with(['inspeccione.solicitud.empresa.empresaNumClientes', 'instalaciones', 'inspeccione.inspector'])->find($id_dictamen);    
    $data = Dictamen_Exportacion::find($id_dictamen);

    if (!$data) {
        return abort(404, 'Dictamen no encontrado');
    }

    // Verifica qué valor tiene esta variable
    $fecha_emision2 = Helpers::formatearFecha($data->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($data->fecha_vigencia);
    $fecha_servicio = Helpers::formatearFecha($data->fecha_servicio);
    //Determinar si la marca de agua debe ser visible
    $watermarkText = $data->estatus == 1;
    //Obtener un valor específico del JSON
    $id_sustituye = json_decode($data->observaciones, true)//Decodifica el JSON actual
    ['id_sustituye'] ?? null;//obtiene el valor del JSON/sino existe es null
    $nombre_id_sustituye = $id_sustituye ?//verifica si la variable $id_sustituye tiene valor asociado 
    //Busca el registro del certificado que tiene el id igual a $id_sustituye
    Dictamen_Exportacion::find($id_sustituye)->num_dictamen ?? '' : '';

    $datos = $data->inspeccione->solicitud->caracteristicas; //Obtener Características Solicitud
    if ($datos) {
        $caracteristicas = json_decode($datos, true); //Decodificar el JSON
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
        $loteIds = collect($detalles)->pluck('id_lote_envasado');
        // Buscar los lotes envasados
        $lotes = Lotes_Envasado::whereIn('id_lote_envasado', $loteIds)->get();

    } else {
        return abort(404, 'No se encontraron características');
    }

    $pdf = Pdf::loadView('pdfs.dictamen_exportacion_ed2', [//formato del PDF
        'data' => $data,//declara todo = {{ $data->inspeccione->num_servicio }}
        'lotes' =>$lotes,
        'no_dictamen' => $data->num_dictamen,
        'fecha_emision' => $fecha_emision2,
        'empresa' => $data->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado',
        'domicilio' => $data->inspeccione->solicitud->empresa->domicilio_fiscal ?? "No encontrado",
        'rfc' => $data->inspeccione->solicitud->empresa->rfc ?? 'No encontrado',
        'productor_autorizado' => $data->inspeccione->solicitud->empresa->registro_productor ?? '',
        'importador' => $data->inspeccione->solicitud->direccion_destino->destinatario ?? "No encontrada",
        //'direccion' => $data->inspeccione->solicitud->instalacion->direccion_completa ?? 'No encontrada',
        'direccion' => $data->inspeccione->solicitud->direccion_destino->direccion ?? "No encontrada",
        'pais' => $data->inspeccione->solicitud->direccion_destino->pais_destino ?? "No encontrada",
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,
        ///caracteristicas
        'aduana' => $aduana_salida ?? "No encontrada",
        'n_pedido' => $no_pedido ?? "No encontrada",
        'botellas' => $botellas ?? "No encontrada",
        'cajas' => $cajas ?? "No encontrada",
        'presentacion' => $presentacion ?? "No encontrada",

        'fecha_servicio' => $fecha_servicio,
        'fecha_vigencia' => $fecha_vigencia,
        
    ]);
    //nombre al descarga
    return $pdf->stream('F-UV-04-18 Ver 2. Dictamen de Cumplimiento para Producto de Exportación.pdf');
}




//FUNCION PARA REEXPEDIR 
public function reexpedir(Request $request)
{
    try {
        $request->validate([
            'accion_reexpedir' => 'required|in:1,2',
            'observaciones' => 'nullable|string',
        ]);

        if ($request->accion_reexpedir == '2') {
            $request->validate([
                'id_dictamen' => 'required|exists:dictamenes_exportacion,id_dictamen',
                'num_dictamen' => 'required|string|max:25',
                'id_inspeccion' => 'required|integer',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'required|date',
                'id_firmante' => 'required|integer',
            ]);
        }

        $dictamen = Dictamen_Exportacion::findOrFail($request->id_dictamen);

        if ($request->accion_reexpedir == '1') {
            $dictamen->estatus = 1; 
            // Decodificar el JSON actual
            $observacionesActuales = json_decode($dictamen->observaciones, true);
            // Actualiza solo 'observaciones' sin modificar 'id_certificado_sustituye'
            $observacionesActuales['observaciones'] = $request->observaciones;
            // Volver a codificar el array y asignarlo a $certificado->observaciones
            $dictamen->observaciones = json_encode($observacionesActuales); 
            $dictamen->save();
        } elseif ($request->accion_reexpedir == '2') {
            $dictamen->estatus = 1;
                $observacionesActuales = json_decode($dictamen->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
            $dictamen->observaciones = json_encode($observacionesActuales);
            $dictamen->save(); 


            // Crear un nuevo registro de reexpedición
            $nuevoDictamen = new Dictamen_Exportacion();
            $nuevoDictamen->num_dictamen = $request->num_dictamen;
            $nuevoDictamen->id_inspeccion = $request->id_inspeccion;
            $nuevoDictamen->fecha_emision = $request->fecha_emision;
            $nuevoDictamen->fecha_vigencia = $request->fecha_vigencia;
            $nuevoDictamen->id_firmante = $request->id_firmante;
            $nuevoDictamen->estatus = 2;
            $nuevoDictamen->observaciones = json_encode([
                'id_sustituye' => $request->id_dictamen,
                ]);
            // Guardar
            $nuevoDictamen->save();
        }

        return response()->json(['message' => 'Dictamen procesado correctamente.']);
    } catch (\Exception $e) {
        Log::error($e);
        return response()->json(['message' => 'Error al procesar el dictamen.', 'error' => $e->getMessage()], 500);
    }
}





}//end-classController
