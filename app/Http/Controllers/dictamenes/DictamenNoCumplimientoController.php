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
        /*$inspecciones = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {//filtrar por campos dentro de la relación.
            $query->whereIn('id_tipo', [5, 8, 11, 3, 14]);
        })->orderBy('id_inspeccion', 'desc')->get();// filtra sobre la tabla principal*/
        $inspecciones = inspecciones::whereHas('solicitud', function ($q) {
                $q->whereDate('created_at', '>', '2024-12-01')
                ->whereHas('tipo_solicitud', function ($query) {
                    $query->whereIn('id_tipo', [5, 8, 11, 3, 14]);
                });
            })
            ->whereDoesntHave('dictamenExportacion')//SIN DICTAMENES
            ->whereDoesntHave('dictamenGranel')
            ->whereDoesntHave('dictamenEnvasado')
            ->whereDoesntHave('dictamen')
            ->orderBy('id_inspeccion', 'desc')
            ->get();
        $inspectores = User::where('tipo',2)->get(); 

        
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
        6 => 'estatus',            
        7 => '',// acciones
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
            $nestedData['fecha_emision'] = Helpers::formatearFecha($dictamen->fecha_emision);
            $nestedData['fecha_vigencia'] = Helpers::formatearFecha($dictamen->fecha_vigencia);
            $nestedData['estatus'] = $dictamen->estatus ?? 'No encontrado';
            $nestedData['num_servicio'] = $dictamen->inspeccione->num_servicio ?? 'No encontrado';
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
    try {
    $validated = $request->validate([
        'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
        'num_dictamen' => 'required|string|max:30',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
        'id_firmante' => 'required|exists:users,id',
    ]);
        // Crear un registro
        $new = new Dictamen_NoCumplimiento();
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










}
