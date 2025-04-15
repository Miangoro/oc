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
//firma electronica
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;


class DictamenExportacionController extends Controller
{

    public function UserManagement()
    {
        $dictamenes = Dictamen_Exportacion::all(); // Obtener todos los datos
        $inspeccion = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 11);
            })->orderBy('id_inspeccion', 'desc')->get();
        $users = User::where('tipo',2)->get(); //Solo inspectores 
        $empresa = empresa::where('tipo', 2)->get(); //solo empresas tipo '2'

        // Pasar los datos a la vista
        return view('dictamenes.find_dictamen_exportacion', compact('dictamenes', 'inspeccion', 'users', 'empresa'));
    }


public function index(Request $request)
{
    $columns = [
    //CAMPOS PARA ORDENAR LA TABLA DE INICIO "thead"
        1 => 'id_dictamen_envasado',
        2 => 'id_inspeccion',
        3 => '',
        4 => '',
        5 => 'fecha_emision',
        6 => 'estatus',
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
        foreach ($users as $dictamen) {
            $nestedData['id_dictamen'] = $dictamen->id_dictamen ?? 'No encontrado';
            $nestedData['num_dictamen'] = $dictamen->num_dictamen ?? 'No encontrado';
            $nestedData['estatus'] = $dictamen->estatus ?? 'No encontrado';
            $nestedData['fecha_emision'] = Helpers::formatearFecha($dictamen->fecha_emision);
            $nestedData['fecha_vigencia'] = Helpers::formatearFecha($dictamen->fecha_vigencia);
            $nestedData['num_servicio'] = $dictamen->inspeccione->num_servicio ?? 'No encontrado';
            $nestedData['folio_solicitud'] = $dictamen->inspeccione->solicitud->folio ?? 'No encontrado';
            ///numero y nombre empresa
            $empresa = $dictamen->inspeccione->solicitud->empresa ?? null;
            $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes
                ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
                : 'N/A';
            $nestedData['numero_cliente'] = $numero_cliente;
            $nestedData['razon_social'] = $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';
            ///dias vigencia
            $fechaActual = Carbon::now()->startOfDay(); //Asegúrate de trabajar solo con fechas, sin horas
            $nestedData['fecha_actual'] = $fechaActual;
            $nestedData['vigencia'] = $dictamen->fecha_vigencia;
            $fechaVigencia = Carbon::parse($dictamen->fecha_vigencia)->startOfDay();
                if ($fechaActual->isSameDay($fechaVigencia)) {
                    $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Hoy se vence este dictamen</span>";
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
            $nestedData['id_solicitud'] = $dictamen->inspeccione->solicitud->id_solicitud ?? 'No encontrado';
            $urls = isset($dictamen->inspeccione, $dictamen->inspeccione->solicitud) 
                ? $dictamen->inspeccione->solicitud->documentacion(69)->pluck('url')->toArray()
                : null;
            $nestedData['url_acta'] = is_null($urls) ? 'No encontrado'//si no hay relacion
                : (empty($urls) ? 'Sin subir' : implode(', ', $urls));//hay relacion pero no documentos
            
                
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
    $validated = $request->validate([
        'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
        'num_dictamen' => 'required|string|max:40',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
        'id_firmante' => 'required|exists:users,id',
    ]);
        // Crear un registro
        $new = new Dictamen_Exportacion();
        $new->id_inspeccion = $validated['id_inspeccion'];
        $new->num_dictamen = $validated['num_dictamen'];
        $new->fecha_emision = $validated['fecha_emision'];
        $new->fecha_vigencia = $validated['fecha_vigencia'];
        $new->id_firmante = $validated['id_firmante'];
        $new->save();

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
public function destroy($id_dictamen)
{
    try {
        $eliminar = Dictamen_Exportacion::findOrFail($id_dictamen);
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
public function edit($id_dictamen)
{
    try {
        $editar = Dictamen_Exportacion::findOrFail($id_dictamen);

        return response()->json([
            'id_dictamen' => $editar->id_dictamen,
            'num_dictamen' => $editar->num_dictamen,
            'id_inspeccion' => $editar->id_inspeccion,
            'fecha_emision' => $editar->fecha_emision,
            'fecha_vigencia' => $editar->fecha_vigencia,
            'id_firmante' => $editar->id_firmante,
        ]);
    } catch (\Exception $e) {
        Log::error('Error al obtener', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al obtener los datos.'], 500);
    }
}

///FUNCION ACTUALIZAR
public function update(Request $request, $id_dictamen) 
{
    try {
        // Validar los datos del formulario
        $validated = $request->validate([
            'num_dictamen' => 'required|string|max:70',
            'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'id_firmante' => 'required|exists:users,id',
        ]);

        $actualizar = Dictamen_Exportacion::findOrFail($id_dictamen);
        $actualizar->update([// Actualizar
            'num_dictamen' => $validated['num_dictamen'],
            'id_inspeccion' => $validated['id_inspeccion'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_vigencia' => $validated['fecha_vigencia'],
            'id_firmante' => $validated['id_firmante'],
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
                'id_dictamen' => 'required|exists:dictamenes_exportacion,id_dictamen',
                'id_inspeccion' => 'required|integer',
                'num_dictamen' => 'required|string|min:8',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'required|date',
                'id_firmante' => 'required|integer',
            ]);
        }

        $reexpedir = Dictamen_Exportacion::findOrFail($request->id_dictamen);

        if ($request->accion_reexpedir == '1') {
            $reexpedir->estatus = 1; 
            // Decodificar el JSON actual
            $observacionesActuales = json_decode($reexpedir->observaciones, true);
            // Actualiza solo 'observaciones' sin modificar 'id_certificado_sustituye'
            $observacionesActuales['observaciones'] = $request->observaciones;
            // Volver a codificar el array y asignarlo a $certificado->observaciones
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
            $new = new Dictamen_Exportacion();
            $new->num_dictamen = $request->num_dictamen;
            $new->id_inspeccion = $request->id_inspeccion;
            $new->fecha_emision = $request->fecha_emision;
            $new->fecha_vigencia = $request->fecha_vigencia;
            $new->id_firmante = $request->id_firmante;
            $new->estatus = 2;
            $new->observaciones = json_encode(['id_sustituye' => $request->id_dictamen]);
            $new->save();// Guardar

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



///PDF DICTAMEN
public function MostrarDictamenExportacion($id_dictamen) 
{
    // Obtener los datos del dictamen
    //$datos = Dictamen_Exportacion::with(['inspeccione.solicitud.empresa.empresaNumClientes', 'instalaciones', 'inspeccione.inspector'])->find($id_dictamen);    
    $data = Dictamen_Exportacion::find($id_dictamen);

    if (!$data) {
        return abort(404, 'Registro no encontrado');
        return response()->json(['data']);
    }
    //firma electronica
    $url = route('validar_dictamen', ['id_dictamen' => $id_dictamen]);
    $qrCode = new QrCode(
        data: $url,
        encoding: new Encoding('UTF-8'),
        errorCorrectionLevel: ErrorCorrectionLevel::Low,
        size: 300,
        margin: 10,
        roundBlockSizeMode: RoundBlockSizeMode::Margin,
        foregroundColor: new Color(0, 0, 0),
        backgroundColor: new Color(255, 255, 255)
    );
    // Escribir el QR en formato PNG
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    // Convertirlo a Base64
    $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());

    if($data->id_firmante == 9){ //Erik
        $pass = 'Mejia2307';
    }
    if($data->id_firmante == 6){ //Karen velazquez
        $pass = '890418jks';
    }
    if($data->id_firmante == 7){ //Zaida
        $pass = 'ZA27CI09';
    }
    if($data->id_firmante == 14){ //Mario
        $pass = 'v921009villa';
    }
    $firmaDigital = Helpers::firmarCadena($data->num_dictamen . '|' . $data->fecha_emision . '|' . $data->inspeccione->num_servicio, $pass, $data->id_firmante);
    
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
        'firmaDigital' => $firmaDigital,
        'qrCodeBase64' => $qrCodeBase64,
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





}//end-classController
