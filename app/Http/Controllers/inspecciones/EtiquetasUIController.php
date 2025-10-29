<?php

namespace App\Http\Controllers\inspecciones;

use App\Http\Controllers\Controller;
use App\Models\EtiquetaUIMezcalGranel;
use App\Models\EtiquetaUIAgaveArt;
use App\Models\EtiquetaUIMaduracion;
use App\Models\EtiquetaUITapaMuestra;
///Extensiones
use Carbon\Carbon;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class EtiquetasUIController extends Controller
{

    public function UserManagement()
    {
        $etiquetas = EtiquetaUIMezcalGranel::all();

        // Pasar los datos a la vista
        return view('inspecciones.find_etiqueta_ui_mezcal_granel', compact('etiquetas'));
    }

public function index(Request $request)
{
    DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para nombres meses
    // Mapear las columnas según el orden DataTables (índice JS)
    $columns = [
        0 => '', 
        1 => 'id', 
        2 => 'fecha_servicio', 
        3 => 'num_servicio', 
        4 => 'nombre_lote',
        5 => 'razon_social',
        6 => 'num_certificado',
        7 => '',//formato
        8 => '',//acciones
    ];
    $limit = $request->input('length');
    $start = $request->input('start');
    
    // Columnas ordenadas desde DataTables
    $orderColumnIndex = $request->input('order.0.column');// Indice de columna en DataTables
    $orderDirection = $request->input('order.0.dir') ?? 'desc';// Dirección de ordenamiento
    $orderColumn = $columns[$orderColumnIndex] ?? 'id'; // Por defecto
    $search = $request->input('search.value');//Define la búsqueda global.

    $query = EtiquetaUIMezcalGranel::query();
    
    $totalData = $query->count();// Total registros sin filtro

    // Búsqueda Global
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('nombre_lote', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(fecha_servicio, '%d de %M del %Y') LIKE ?", ["%$search%"]);
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }

    // Paginación y ordenación
    $etiquetas = $query
        ->offset($start)
        ->limit($limit)
        ->orderBy($orderColumn, $orderDirection)
        ->get();


    //MANDA LOS DATOS AL JS
    $data = [];
    if (!empty($etiquetas)) {
        $ids = $start;
        foreach ($etiquetas as $etiqueta) {
            $nestedData['fake_id'] = ++$ids;
            $nestedData['id'] = $etiqueta->id ?? '';
            $nestedData['fecha'] = $etiqueta->fecha ?? '';
            $nestedData['num_servicio'] = $etiqueta->num_servicio ?? '';
            $nestedData['lote'] = $etiqueta->nombre_lote ?? '';
            $nestedData['cliente'] = $etiqueta->razon_social ?? '';
            $nestedData['num_certificado'] = $etiqueta->num_certificado ?? '';

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



//------------------- AGAVE ART -------------------
    public function UserManagement2()
        {
            $etiquetas = EtiquetaUIAgaveArt::all();

            // Pasar los datos a la vista
            return view('inspecciones.find_etiqueta_ui_agave_art', compact('etiquetas'));
        }

public function index2(Request $request)
{
    DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para nombres meses
    // Mapear las columnas según el orden DataTables (índice JS)
    $columns = [
        0 => '', 
        1 => 'id', 
        2 => 'fecha_servicio', 
        3 => 'num_servicio', 
        4 => 'nombre_lote',
        5 => 'razon_social',
        6 => 'num_certificado',
        7 => '',//formato
        8 => '',//acciones
    ];
    $limit = $request->input('length');
    $start = $request->input('start');
    
    // Columnas ordenadas desde DataTables
    $orderColumnIndex = $request->input('order.0.column');// Indice de columna en DataTables
    $orderDirection = $request->input('order.0.dir') ?? 'desc';// Dirección de ordenamiento
    $orderColumn = $columns[$orderColumnIndex] ?? 'id'; // Por defecto
    $search = $request->input('search.value');//Define la búsqueda global.

    $query = EtiquetaUIAgaveArt::query();
    
    $totalData = $query->count();// Total registros sin filtro

    // Búsqueda Global
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('nombre_lote', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(fecha_servicio, '%d de %M del %Y') LIKE ?", ["%$search%"]);
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }

    // Paginación y ordenación
    $etiquetas = $query
        ->offset($start)
        ->limit($limit)
        ->orderBy($orderColumn, $orderDirection)
        ->get();


    //MANDA LOS DATOS AL JS
    $data = [];
    if (!empty($etiquetas)) {
        $ids = $start;
        foreach ($etiquetas as $etiqueta) {
            $nestedData['fake_id'] = ++$ids;
            $nestedData['id'] = $etiqueta->id ?? '';
            $nestedData['fecha'] = $etiqueta->fecha ?? '';
            $nestedData['num_servicio'] = $etiqueta->num_servicio ?? '';
            $nestedData['lote'] = $etiqueta->nombre_lote ?? '';
            $nestedData['cliente'] = $etiqueta->razon_social ?? '';
            $nestedData['num_certificado'] = $etiqueta->num_certificado ?? '';

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



//------------------- INGRESO MADURACION -------------------
    public function UserManagement3()
        {
            $etiquetas = EtiquetaUIMaduracion::all();

            // Pasar los datos a la vista
            return view('inspecciones.find_etiqueta_ui_maduracion', compact('etiquetas'));
        }

public function index3(Request $request)
{
    DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para nombres meses
    // Mapear las columnas según el orden DataTables (índice JS)
    $columns = [
        0 => '', 
        1 => 'id', 
        2 => 'fecha_servicio', 
        3 => 'num_servicio', 
        4 => 'nombre_lote',
        5 => 'razon_social',
        6 => 'num_certificado',
        7 => '',//formato
        8 => '',//acciones
    ];
    $limit = $request->input('length');
    $start = $request->input('start');
    
    // Columnas ordenadas desde DataTables
    $orderColumnIndex = $request->input('order.0.column');// Indice de columna en DataTables
    $orderDirection = $request->input('order.0.dir') ?? 'desc';// Dirección de ordenamiento
    $orderColumn = $columns[$orderColumnIndex] ?? 'id'; // Por defecto
    $search = $request->input('search.value');//Define la búsqueda global.

    $query = EtiquetaUIMaduracion::query();
    
    $totalData = $query->count();// Total registros sin filtro

    // Búsqueda Global
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('nombre_lote', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(fecha_servicio, '%d de %M del %Y') LIKE ?", ["%$search%"]);
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }

    // Paginación y ordenación
    $etiquetas = $query
        ->offset($start)
        ->limit($limit)
        ->orderBy($orderColumn, $orderDirection)
        ->get();


    //MANDA LOS DATOS AL JS
    $data = [];
    if (!empty($etiquetas)) {
        $ids = $start;
        foreach ($etiquetas as $etiqueta) {
            $nestedData['fake_id'] = ++$ids;
            $nestedData['id'] = $etiqueta->id ?? '';
            $nestedData['fecha'] = $etiqueta->fecha ?? '';
            $nestedData['num_servicio'] = $etiqueta->num_servicio ?? '';
            $nestedData['lote'] = $etiqueta->nombre_lote ?? '';
            $nestedData['cliente'] = $etiqueta->razon_social ?? '';
            $nestedData['num_certificado'] = $etiqueta->num_certificado ?? '';

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



//------------------- TAPA MUESTRA -------------------
    public function UserManagement4()
        {
            $etiquetas = EtiquetaUITapaMuestra::all();

            // Pasar los datos a la vista
            return view('inspecciones.find_etiqueta_ui_tapa_muestra', compact('etiquetas'));
        }

public function index4(Request $request)
{
    DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para nombres meses
    // Mapear las columnas según el orden DataTables (índice JS)
    $columns = [
        0 => '', 
        1 => 'id', 
        2 => 'fecha_servicio', 
        3 => 'num_servicio', 
        4 => 'nombre_lote',
        5 => 'razon_social',
        6 => 'num_certificado',
        7 => '',//formato
        8 => '',//acciones
    ];
    $limit = $request->input('length');
    $start = $request->input('start');
    
    // Columnas ordenadas desde DataTables
    $orderColumnIndex = $request->input('order.0.column');// Indice de columna en DataTables
    $orderDirection = $request->input('order.0.dir') ?? 'desc';// Dirección de ordenamiento
    $orderColumn = $columns[$orderColumnIndex] ?? 'id'; // Por defecto
    $search = $request->input('search.value');//Define la búsqueda global.

    $query = EtiquetaUITapaMuestra::query();
    
    $totalData = $query->count();// Total registros sin filtro

    // Búsqueda Global
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('num_servicio', 'LIKE', "%{$search}%")
            ->orWhere('nombre_lote', 'LIKE', "%{$search}%")
            ->orWhereRaw("DATE_FORMAT(fecha_servicio, '%d de %M del %Y') LIKE ?", ["%$search%"]);
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }

    // Paginación y ordenación
    $etiquetas = $query
        ->offset($start)
        ->limit($limit)
        ->orderBy($orderColumn, $orderDirection)
        ->get();


    //MANDA LOS DATOS AL JS
    $data = [];
    if (!empty($etiquetas)) {
        $ids = $start;
        foreach ($etiquetas as $etiqueta) {
            $nestedData['fake_id'] = ++$ids;
            $nestedData['id'] = $etiqueta->id ?? '';
            $nestedData['fecha'] = $etiqueta->fecha ?? '';
            $nestedData['num_servicio'] = $etiqueta->num_servicio ?? '';
            $nestedData['lote'] = $etiqueta->nombre_lote ?? '';
            $nestedData['cliente'] = $etiqueta->razon_social ?? '';
            $nestedData['num_certificado'] = $etiqueta->num_certificado ?? '';

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









}//end-controller