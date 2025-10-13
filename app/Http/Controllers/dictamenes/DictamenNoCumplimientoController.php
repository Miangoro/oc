<?php

namespace App\Http\Controllers\dictamenes;

use App\Http\Controllers\Controller;
use App\Models\Dictamen_NoCumplimiento;
use App\Models\inspecciones;
use App\Models\User;
///Extensiones
use Carbon\Carbon;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
//QR
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;


class DictamenNoCumplimientoController extends Controller
{

    public function UserManagement()
    {
        $inspecciones = inspecciones::whereHas('solicitud', function ($q) {
                $q->whereIn('id_tipo', [3, 5, 8, 11, 14]);
            })
            ->whereDoesntHave('dictamenGranel')
            ->whereDoesntHave('dictamenEnvasado')
            ->whereDoesntHave('dictamen')//instalaciones
            ->whereDoesntHave('dictamenExportacion')
            ->whereDoesntHave('dictamenNoCumplimiento')
            ->where('fecha_servicio', '>', '2024-12-31')
            ->with('solicitud') // trae la relación
            ->get()
            ->sortByDesc('solicitud.id_solicitud'); // ordenar en la colección

        $inspectores = User::where('tipo',2)
            ->where('estatus', '!=', 'Inactivo')
            ->get(); 

        // Pasar los datos a la vista
        return view('dictamenes.find_dictamen_no_cumplimiento', compact('inspecciones', 'inspectores'));
    }


public function index(Request $request)
{
    //Permiso de empresa
    $empresaId = null;
    if (Auth::check() && Auth::user()->tipo == 3) {
        $empresaId = Auth::user()->empresa?->id_empresa;
    }

    DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para nombres meses
    // Mapear las columnas según el orden DataTables (índice JS)
    $columns = [
        0 => '',               
        1 => 'num_dictamen',
        2 => '', //nombre de mi tabla y atributo
        3 => '', 
        4 => '', //caracteristicas
        5 => 'fecha_emision',
        6 => '',// acciones
    ];

    /*$totalData = Dictamen_Exportacion::count();
    $totalFiltered = $totalData;*/
    $limit = $request->input('length');
    $start = $request->input('start');
    
    // Columnas ordenadas desde DataTables
    $orderColumnIndex = $request->input('order.0.column');// Indice de columna en DataTables
    $orderDirection = $request->input('order.0.dir') ?? 'asc';// Dirección de ordenamiento
    $orderColumn = $columns[$orderColumnIndex] ?? 'num_dictamen'; // Por defecto
    
    $search = $request->input('search.value');//Define la búsqueda global.


    //1)$query = Dictamen_Exportacion::query();
    /*2)$query = Dictamen_Exportacion::select('inspecciones.*')
    ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_exportacion.id_inspeccion');
    */
    $query = Dictamen_NoCumplimiento::query()
        ->leftJoin('inspecciones', 'inspecciones.id_inspeccion', '=', 'dictamenes_no_cumplimiento.id_inspeccion')
        ->leftJoin('solicitudes', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
        ->leftJoin('empresa', 'empresa.id_empresa', '=', 'solicitudes.id_empresa')
        ->select('dictamenes_no_cumplimiento.*', 'empresa.razon_social')//especifica la columna obtenida
        /*->where(function ($q) use ($search) {
            $q->where('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhere('dictamenes_exportacion.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%");
        })*/;

    if ($empresaId) {
        $query->where('solicitudes.id_empresa', $empresaId);
    }
    $baseQuery = clone $query;// Clonamos el query antes de aplicar búsqueda, paginación u ordenamiento
    $totalData = $baseQuery->count();// totalData (sin búsqueda)

    
    // Búsqueda Global
    if (!empty($search)) {//solo se aplica si hay búsqueda global
        /*1)$query->where(function ($q) use ($search) {
            $q->where('num_dictamen', 'LIKE', "%{$search}%")
              ->orWhere('num_servicio', 'LIKE', "%{$search}%");
        });*/
        $query->where(function ($q) use ($search) {
            $q->where('dictamenes_no_cumplimiento.num_dictamen', 'LIKE', "%{$search}%")
            ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
            ->orWhere('empresa.razon_social', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(dictamenes_no_cumplimiento.fecha_emision, '%d de %M del %Y') LIKE ?", ["%$search%"]);
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }


    // Ordenamiento especial para num_dictamen con formato 'UMEXP##-###'
    $query->orderBy($orderColumn, $orderDirection);


    
    //dd($query->toSql(), $query->getBindings());ver que manda
    // Paginación
    //1)$dictamenes = $query->offset($start)->limit($limit)->get();
    $dictamenes = $query
        ->with([// 1 consulta por cada tabla relacionada en conjunto (menos busqueda adicionales de query en BD)
            'inspeccione', // Relación directa
            'inspeccione.solicitud',// Relación anidada: inspeccione > solicitud
            'inspeccione.solicitud.empresa',
            'inspeccione.solicitud.empresa.empresaNumClientes',
        ])->offset($start)->limit($limit)->get();



    //MANDA LOS DATOS AL JS
    $data = [];
    if (!empty($dictamenes)) {
        foreach ($dictamenes as $dictamen) {
            $nestedData['id_dictamen'] = $dictamen->id_dictamen ?? 'No encontrado';
            $nestedData['num_dictamen'] = $dictamen->num_dictamen ?? 'No encontrado';
            $nestedData['motivo'] = "<span class='small'><b>Motivo de incumplimiento:</b> $dictamen->observaciones</span>";

            $nestedData['fecha_emision'] = Helpers::formatearFecha($dictamen->fecha_emision);
            $nestedData['fecha_vigencia'] = Helpers::formatearFecha($dictamen->fecha_vigencia);
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

            $nestedData['num_servicio'] = $dictamen->inspeccione->num_servicio ?? 'No encontrado';
            $nestedData['folio_solicitud'] = $dictamen->inspeccione->solicitud->folio ?? 'No encontrado';
            ///solicitud y acta
            $nestedData['id_solicitud'] = $dictamen->inspeccione->solicitud->id_solicitud ?? 'No encontrado';
            $urls = $dictamen->inspeccione?->solicitud?->documentacion(69)?->pluck('url')?->toArray();
            $nestedData['url_acta'] = (!empty($urls)) ? $urls : 'Sin subir';

            ///numero y nombre empresa
            $empresa = $dictamen->inspeccione->solicitud->empresa ?? null;
            $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
            $nestedData['numero_cliente'] = $numero_cliente;
            $nestedData['razon_social'] = $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';

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
    $validated = $request->validate([
        'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
        'num_dictamen' => 'required|string|max:30',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
        'id_firmante' => 'required|exists:users,id',
        'observaciones' => 'nullable|string',
    ]);
        // Crear un registro
        $new = new Dictamen_NoCumplimiento();
        $new->id_inspeccion = $validated['id_inspeccion'];
        $new->num_dictamen = $validated['num_dictamen'];
        $new->fecha_emision = $validated['fecha_emision'];
        $new->fecha_vigencia = $validated['fecha_vigencia'];
        $new->id_firmante = $validated['id_firmante'];
        $new->observaciones = $validated['observaciones'];
        $new->save();

        return response()->json(['message' => 'Registrado correctamente.']);
}



///FUNCION ELIMINAR
public function destroy($id_dictamen)
{
    try {
        $eliminar = Dictamen_NoCumplimiento::findOrFail($id_dictamen);
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
        $editar = Dictamen_NoCumplimiento::findOrFail($id_dictamen);

        return response()->json([
            'id_dictamen' => $editar->id_dictamen,
            'num_dictamen' => $editar->num_dictamen,
            'id_inspeccion' => $editar->id_inspeccion,
            'fecha_emision' => $editar->fecha_emision,
            'fecha_vigencia' => $editar->fecha_vigencia,
            'id_firmante' => $editar->id_firmante,
            'observaciones' => $editar->observaciones,

            // Datos relacionados sin tener que guardarlos en base de datos
            'folio' => $editar->inspeccione->solicitud->folio ?? '',
            'num_servicio' => $editar->inspeccione->num_servicio ?? '',
            'direccion_completa' => $editar->inspeccione->solicitud->instalacion->direccion_completa ?? ''
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
        // Validar los datos del formulario
        $validated = $request->validate([
            'num_dictamen' => 'required|string|max:30',
            'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'id_firmante' => 'required|exists:users,id',
            'observaciones' => 'nullable|string',
        ]);

        $actualizar = Dictamen_NoCumplimiento::findOrFail($id_dictamen);
        $actualizar->update([// Actualizar
            'num_dictamen' => $validated['num_dictamen'],
            'id_inspeccion' => $validated['id_inspeccion'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_vigencia' => $validated['fecha_vigencia'],
            'id_firmante' => $validated['id_firmante'],
            'observaciones' => $validated['observaciones'],
        ]);

        return response()->json(['message' => 'Actualizado correctamente.']);
}



///PDF DICTAMEN
public function DictamenNoCumplimiento($id_dictamen)
{
    // Obtener los datos del dictamen
    $data = Dictamen_NoCumplimiento::find($id_dictamen);

    if (!$data) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
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
    $firmaDigital = Helpers::firmarCadena($data->num_dictamen . '|' . $data->fecha_emision . '|' . $data->inspeccione?->num_servicio, $pass, $data->id_firmante);


    // Verifica qué valor tiene esta variable
    $fecha_emision = Helpers::formatearFecha($data->fecha_emision);
    $fecha_servicio = Helpers::formatearFecha($data->inspeccione->fecha_servicio);
    

    //$query->whereIn('id_tipo', [5, 8, 11, 3, 14]);
    $tipo_solicitud = $data->inspeccione->solicitud->id_tipo ?? null;
    // Inicializa marcadores
    $instalaciones = $granel = $envasado = $exportacion = ' ';

    switch ($tipo_solicitud) {
        case 14:
            $instalaciones = 'X';
            break;
        case 3:
            $granel = 'X';
            break;
        case 5:
        case 8:
            $envasado = 'X';
            break;
        case 11:
            $exportacion = 'X';
            break;
    }
    //return response()->json(['message' => 'No se encontraron características.', $data], 404);

    $pdf = Pdf::loadView('pdfs.dictamen_no_cumplimiento_ed0', [//formato del PDF
        'data' => $data,
        'num_dictamen' => $data->num_dictamen ?? 'No encontrado',
        'observaciones' => $data->observaciones ?? 'No encontrado',
        'inspector' => $data->inspeccione->inspector->name ?? 'No encontrado',
        'empresa' => $data->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado',
        'dom_fiscal' => $data->inspeccione->solicitud->empresa->domicilio_fiscal ?? "No encontrado",
        'cp' => $data->inspeccione->solicitud->empresa->cp ?? "No encontrado",
        'rfc' => $data->inspeccione->solicitud->empresa->rfc ?? 'No encontrado',
        'representante' => $data->inspeccione->solicitud->empresa->representante ?? 'No encontrado',
        'dom_inspeccion' => $data->inspeccione->solicitud->instalacion->direccion_completa ?? "No encontrado",
        'num_servicio' => $data->inspeccione->num_servicio ?? 'No encontrado',
        'fecha_emision' => $fecha_emision ?? 'No encontrado',
        'fecha_servicio' => $fecha_servicio ?? 'No encontrado',

        'firmaDigital' => $firmaDigital ?? 'No encontrado',
        'qrCodeBase64' => $qrCodeBase64 ?? 'No encontrado',

        'instalaciones' => $instalaciones ?? ' ',
        'granel' => $granel ?? ' ',
        'envasado' => $envasado ?? ' ',
        'exportacion' => $exportacion ?? ' ',
    ]);
    //nombre al descarga
    return $pdf->stream('F-UV-04-30 Dictamen de no cumplimiento Ed. 0.pdf');
}







}
