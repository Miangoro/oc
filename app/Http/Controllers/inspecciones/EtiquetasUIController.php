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
            $nestedData['fecha'] = $etiqueta->fecha_servicio ?? '';
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

/// REGISTRAR MEZCAL A GRANEL
public function store(Request $request)
{
    $etiqueta = new EtiquetaUIMezcalGranel();
    $etiqueta->fecha_servicio = $request->fecha_servicio;
    $etiqueta->num_servicio = $request->num_servicio;
    $etiqueta->razon_social = $request->razon_social;
    $etiqueta->nombre_lote = $request->nombre_lote;
    $etiqueta->volumen = $request->volumen;
    $etiqueta->folio_fq = $request->folio_fq;
    $etiqueta->categoria = $request->categoria;
    $etiqueta->clase = $request->clase;
    $etiqueta->tipo_agave = $request->tipo_agave;
    $etiqueta->edad = $request->edad;
    $etiqueta->tanque = $request->tanque;
    $etiqueta->ingredientes = $request->ingredientes;
    $etiqueta->num_certificado = $request->num_certificado;
    $etiqueta->inspector = $request->inspector;
    $etiqueta->responsable = $request->responsable;
    $etiqueta->save();

    return response()->json([
        'success' => true,
        'message' => 'Registrado correctamente.',
    ]);
}

/// ELIMINAR MEZCAL A GRANEL
public function destroy($id)
{
    $etiqueta = EtiquetaUIMezcalGranel::find($id);
    $etiqueta->delete();

    return response()->json(['message' => 'Eliminado correctamente.']);
}

/// OBTENER MEZCAL A GRANEL
public function edit($id)
{
    $etiqueta = EtiquetaUIMezcalGranel::findOrFail($id);
    return response()->json($etiqueta);
}
/// EDITAR MEZCAL A GRANEL
public function update(Request $request, $id)
{
    $etiqueta = EtiquetaUIMezcalGranel::findOrFail($id);
    $etiqueta->update($request->all());

    return response()->json(['message' => 'Actualizado correctamente.']);
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
            ->orWhere('razon_social', 'LIKE', "%{$search}%")
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
            $nestedData['fecha'] = $etiqueta->fecha_servicio ?? '';
            $nestedData['num_servicio'] = $etiqueta->domicilio ?? '';
            $nestedData['lote'] = $etiqueta->nombre_lote ?? '';
            $nestedData['cliente'] = $etiqueta->razon_social ?? '';
            $nestedData['tipo_agave'] = $etiqueta->tipo_agave ?? '';

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

/// REGISTRAR AGAVE ART
public function store2(Request $request)
{
    $etiqueta = new EtiquetaUIAgaveArt();
    $etiqueta->fecha_servicio   = $request->fecha_servicio;
    $etiqueta->num_servicio     = $request->num_servicio;
    $etiqueta->razon_social     = $request->razon_social;
    $etiqueta->domicilio        = $request->domicilio;
    $etiqueta->maestro_mezcalero = $request->maestro_mezcalero;
    $etiqueta->destino          = $request->destino;
    $etiqueta->predio           = $request->predio;
    $etiqueta->tapada           = $request->tapada;
    $etiqueta->kg_maguey        = $request->kg_maguey;
    $etiqueta->edad             = $request->edad;
    $etiqueta->no_pinas         = $request->no_pinas;
    $etiqueta->tipo_agave       = $request->tipo_agave;
    $etiqueta->analisis         = $request->analisis;
    $etiqueta->muestra          = $request->muestra;
    $etiqueta->inspector        = $request->inspector;
    $etiqueta->responsable      = $request->responsable;
    $etiqueta->save();

    return response()->json([
        'success' => true,
        'message' => 'Registrado correctamente.',
    ]);
}

/// ELIMINAR AGAVE ART
public function destroy2($id)
{
    $etiqueta = EtiquetaUIAgaveArt::find($id);
    $etiqueta->delete();

    return response()->json(['message' => 'Eliminado correctamente.']);
}

/// OBTENER AGAVE ART
public function edit2($id)
{
    $etiqueta = EtiquetaUIAgaveArt::findOrFail($id);
    return response()->json($etiqueta);
}
/// EDITAR AGAVE ART
public function update2(Request $request, $id)
{
    $etiqueta = EtiquetaUIAgaveArt::findOrFail($id);
    $etiqueta->update($request->all());

    return response()->json(['message' => 'Actualizado correctamente.']);
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
            ->orWhere('razon_social', 'LIKE', "%{$search}%")
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

/// REGISTRAR INGRESO MADURACION
public function store3(Request $request)
{
    $etiqueta = new EtiquetaUIMaduracion();
    $etiqueta->fecha_servicio       = $request->fecha_servicio;
    $etiqueta->num_servicio         = $request->num_servicio;
    $etiqueta->razon_social         = $request->razon_social;
    $etiqueta->nombre_lote          = $request->nombre_lote;
    $etiqueta->volumen_total        = $request->volumen_total;
    $etiqueta->folio_fq             = $request->folio_fq;
    $etiqueta->categoria            = $request->categoria;
    $etiqueta->clase                = $request->clase;
    $etiqueta->tipo_agave           = $request->tipo_agave;
    $etiqueta->cont_alc             = $request->cont_alc;
    $etiqueta->num_certificado      = $request->num_certificado;
    $etiqueta->maduracion           = $request->maduracion;
    $etiqueta->tipo_madera          = $request->tipo_madera;
    $etiqueta->tipo_recipiente      = $request->tipo_recipiente;
    $etiqueta->no_recipiente        = $request->no_recipiente;
    $etiqueta->capacidad_recipiente = $request->capacidad_recipiente;
    $etiqueta->volumen_ingresado    = $request->volumen_ingresado;
    $etiqueta->inspector            = $request->inspector;
    $etiqueta->responsable          = $request->responsable;
    $etiqueta->save();

    return response()->json([
        'success' => true,
        'message' => 'Registrado correctamente.',
    ]);
}

/// ELIMINAR INGRESO MADURACION
public function destroy3($id)
{
    $etiqueta = EtiquetaUIMaduracion::find($id);
    $etiqueta->delete();

    return response()->json(['message' => 'Eliminado correctamente.']);
}

/// OBTENER INGRESO MADURACION
public function edit3($id)
{
    $etiqueta = EtiquetaUIMaduracion::findOrFail($id);
    return response()->json($etiqueta);
}
/// EDITAR INGRESO MADURACION
public function update3(Request $request, $id)
{
    $etiqueta = EtiquetaUIMaduracion::findOrFail($id);
    $etiqueta->update($request->all());

    return response()->json(['message' => 'Actualizado correctamente.']);
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
            ->orWhere('razon_social', 'LIKE', "%{$search}%")
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

/// REGISTRAR TAPA MUESTRA
public function store4(Request $request)
{
    $etiqueta = new EtiquetaUITapaMuestra();
    $etiqueta->fecha_servicio   = $request->fecha_servicio;
    $etiqueta->num_servicio     = $request->num_servicio;
    $etiqueta->razon_social     = $request->razon_social;
    $etiqueta->domicilio        = $request->domicilio;
    $etiqueta->nombre_lote      = $request->nombre_lote;
    $etiqueta->producto         = $request->producto;
    $etiqueta->volumen          = $request->volumen;
    $etiqueta->folio_fq         = $request->folio_fq;
    $etiqueta->categoria        = $request->categoria;
    $etiqueta->tipo_agave       = $request->tipo_agave;
    $etiqueta->edad             = $request->edad;
    $etiqueta->ingredientes     = $request->ingredientes;
    $etiqueta->tipo_analisis    = $request->tipo_analisis;
    $etiqueta->lote_procedencia = $request->lote_procedencia;
    $etiqueta->estado           = $request->estado;
    $etiqueta->destino          = $request->destino;
    $etiqueta->inspector        = $request->inspector;
    $etiqueta->responsable      = $request->responsable;
    $etiqueta->save();

    return response()->json([
        'success' => true,
        'message' => 'Registrado correctamente.',
    ]);
}

/// ELIMINAR TAPA MUESTRA
public function destroy4($id)
{
    $etiqueta = EtiquetaUITapaMuestra::find($id);
    $etiqueta->delete();

    return response()->json(['message' => 'Eliminado correctamente.']);
}

/// OBTENER TAPA MUESTRA
public function edit4($id)
{
    $etiqueta = EtiquetaUITapaMuestra::findOrFail($id);
    return response()->json($etiqueta);
}
/// EDITAR TAPA MUESTRA
public function update4(Request $request, $id)
{
    $etiqueta = EtiquetaUITapaMuestra::findOrFail($id);
    $etiqueta->update($request->all());

    return response()->json(['message' => 'Actualizado correctamente.']);
}








}//end-controller