<?php

namespace App\Http\Controllers\revision;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\preguntas_revision_dictamen;
use App\Models\RevisionDictamen;

use App\Helpers\Helpers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;//Autentificar


class RevisionUIController extends Controller
{

    public function userManagement()
    {
        $revisor = User::where('tipo', 2)
            ->where('estatus', 'Activo')
            ->get();
        ///Preguntas
        $preguntasInstalacion = preguntas_revision_dictamen::where('tipo_revisor', 1)
            ->where('tipo_dictamen', 1)
            ->get();
        $preguntasGranel = preguntas_revision_dictamen::where('tipo_revisor', 1)
            ->where('tipo_dictamen', 2)
            ->get();
        $preguntasExportacion = preguntas_revision_dictamen::where('tipo_revisor', 1)
            ->where('tipo_dictamen', 3)
            ->get();

        return view('revision.revision_dictamenes_view', compact('revisor'));
    }


public function index(Request $request)
{
    $userId = Auth::id();

    DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para meses
    $columns = [
        1 => 'id_revision',
        2 => 'id_dictamen',
        3 => 'num_dictamen',
        4 => 'observaciones',
        5 => 'decision'
    ];

    $limit = $request->input('length');
    $start = $request->input('start');
    $orderColumnIndex = $request->input('order.0.column');// Indice de columna en DataTables
    $orderDirection = $request->input('order.0.dir') ?? 'desc';// Dirección de ordenamiento
    $orderColumn = $columns[$orderColumnIndex] ?? 'id_revision'; // Por defecto
    $search = $request->input('search.value');


    $query = RevisionDictamen::with([
            'dictamenInstalacion',
            'dictamenGranel',
            'dictamenEnvasado',
            'dictamenExportacion'
        ])->where('tipo_revision', 1); // Solo revisiones de OC


    // Si no es admin(ID especial) solo ve sus revisiones
    /*if (!in_array($userId, [1, 2, 3, 4, 320])) {
        $query->where('id_revisor', $userId);
    }*/

    $baseQuery = clone $query;
    $totalData = $baseQuery->count();//total sin filtros


    /// Búsqueda Global
    if (!empty($search)) {
        // Convertir a minúsculas sin tildes para comparar
        $searchNormalized = mb_strtolower(trim($search), 'UTF-8');
        // También elimina tildes para mejor comparación
        $searchNormalized = strtr($searchNormalized, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u'
        ]);

        // Buscar coincidencia de nombres a valores numéricos de tipo dictamen
        $tiposDictamen = [// Palabras clave -> valor de tipo_dictamen
            'productor'      => 1,
            'envasador'      => 1,
            'comercializador'=> 1,
            'bodega'         => 1,
            'maduracion'     => 1,
            'gran'         => 2,
            'env'       => 3,
            'expo'    => 4,
        ];

        // Buscar coincidencia con nombre
        $tipoDictamen = null;
        foreach ($tiposDictamen as $clave => $valor) {
            if (strpos($searchNormalized, $clave) !== false) {
                $tipoDictamen = $valor;
                break; // en cuanto encuentre coincidencia, detenemos
            }
        }

        // Aplicar la búsqueda
        $query->where(function ($q) use ($search, $tipoDictamen) {
            // Buscar por número de dictamen en distintos modelos
            $q->orWhereHas('dictamenInstalacion', fn($q) => $q->where('num_dictamen', 'LIKE', "%{$search}%"))
            ->orWhereHas('dictamenGranel', fn($q) => $q->where('num_dictamen', 'LIKE', "%{$search}%"))
            ->orWhereHas('dictamenEnvasado', fn($q) => $q->where('num_dictamen', 'LIKE', "%{$search}%"))
            ->orWhereHas('dictamenExportacion', fn($q) => $q->where('num_dictamen', 'LIKE', "%{$search}%"))
            
            // Buscar por nombre del revisor
            ->orWhereHas('user', fn($q) => $q->where('name', 'LIKE', "%{$search}%"))

            // Buscar por fechas
            ->orWhereRaw("DATE_FORMAT(created_at, '%d de %M del %Y') LIKE ?", ["%$search%"])
            ->orWhereRaw("DATE_FORMAT(updated_at, '%d de %M del %Y') LIKE ?", ["%$search%"]);
            
            // Filtrar por tipo de dictamen si se detectó una palabra clave
            if (!is_null($tipoDictamen)) {
                $q->orWhere('tipo_dictamen', $tipoDictamen);
            }

        });

        $totalFiltered = $query->count();// total con filtros
    } else {
        $totalFiltered = $totalData;// total sin filtros
    }


    // Paginación y ordenación
    $revisores = $query
        ->offset($start)
        ->limit($limit)
        ->orderBy($orderColumn, $orderDirection)
        ->get();



    // Formatear los datos para la vista
    $dataRevisor = $revisores->map(function ($revisor) use (&$start) {

        $nameRevisor = $revisor->user->name ?? null;

        // Mapeo de tipos de dictamen → modelo + etiqueta
        $tipos = [
            1 => ['modelo' => 'dictamenInstalacion',
                'etiquetas' => [
                    1 => 'Instalaciones de productor',
                    2 => 'Instalaciones de envasador',
                    3 => 'Instalaciones de comercializador',
                    4 => 'Instalaciones de almacén y bodega',
                    5 => 'Instalaciones de área de maduración',
                ],
            ],
            2 => ['modelo' => 'dictamenGranel',
                'etiqueta' => 'Granel',
                ],
            3 => ['modelo' => 'dictamenEnvasado', 
                'etiqueta' => 'Envasado',
                ],
            4 => ['modelo' => 'dictamenExportacion',
                'etiqueta' => 'Exportación',
                ],
        ];

        $tipoDictamen = $revisor->tipo_dictamen;
        $tipoCertificado = "No encontrado";
        $fechaVigencia = $num_dictamen = $id_dictamen = null;

        if (isset($tipos[$tipoDictamen])) {
            $modelo = $tipos[$tipoDictamen]['modelo'];
            $relacion = $revisor->$modelo ?? null;

            if ($relacion) {
                $fechaVigencia = $relacion->fecha_vigencia ?? null;
                $num_dictamen = $relacion->inspeccione->num_servicio ?? null;
                $id_dictamen = $relacion->id_dictamen ?? null;

                // Si es instalación, validar sub-tipo
                if ($tipoDictamen === 1) {
                    $subTipo = $relacion->tipo_dictamen ?? null;
                    $tipoCertificado = $tipos[1]['etiquetas'][$subTipo] ?? "No encontrado";
                } else {
                    $tipoCertificado = $tipos[$tipoDictamen]['etiqueta'] ?? "No encontrado";
                }
            }
        }

        return [
            'fake_id' => ++$start,
            'id_revision' => $revisor->id_revision,
            'id_revisor' => $nameRevisor,
            'observaciones' => $revisor->observaciones,
            'num_dictamen' => $num_dictamen,
            'id_dictamen' => $id_dictamen,
            'tipo_dictamen' => $tipoDictamen,
            'fecha_vigencia' => Helpers::formatearFecha($fechaVigencia),
            'created_at' => Helpers::formatearFechaHora($revisor->created_at),
            'updated_at' => Helpers::formatearFechaHora($revisor->updated_at),
            'decision' => $revisor->decision,
            'num_revision' => $revisor->numero_revision,
            'tipo_revision' => $tipoCertificado,
        ];
    });


    // Devolver los resultados como respuesta JSON
    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),   // total sin filtros
        'recordsFiltered' => intval($totalFiltered), // total con filtros
        'data' => array_merge($dataRevisor->toArray()), // Combinacion
    ]);
}



///VER REVISION
public function add_revision($id)
{
    $revision = RevisionDictamen::findOrFail($id);//espera exista registro
    
    // Obtiene dictamen según tipo_dictamen
    $dictamen = $revision->dictamen;
        if ($revision->tipo_dictamen == 1) { //Instalaciones
            switch ($dictamen->tipo_dictamen) {
                case 1:
                    $tipo = 'Instalaciones de productor';
                    $url = "/dictamen_productor/" . $dictamen->id_dictamen;
                    break;
                case 2:
                    $tipo = 'Instalaciones de envasador';
                    $url = "/dictamen_envasador/" . $dictamen->id_dictamen;
                    break;
                case 3:
                    $tipo = 'Instalaciones de comercializador';
                    $url = "/dictamen_comercializador/" . $dictamen->id_dictamen;
                    break;
                case 4:
                    $tipo = 'Instalaciones de almacén y bodega';
                    $url = "/dictamen_almacen/" . $dictamen->id_dictamen;
                    break;
                case 5:
                    $tipo = 'Instalaciones de área de maduración';
                    $url = "/dictamen_maduracion/" . $dictamen->id_dictamen;
                    break;
                default:
                    $tipo = 'Desconocido';
            }
        } elseif ($revision->tipo_dictamen == 2) { //Granel
            $url = "/dictamen_granel/" . $dictamen->id_dictamen;
            $tipo = "Granel";
        } elseif ($revision->tipo_dictamen == 3) { //envasado
            $url = "/dictamen_envasado/" . $dictamen->id_dictamen;
            $tipo = "Envasado";
        } elseif ($revision->tipo_dictamen == 4) { //exportacion
            $url = "/dictamen_exportacion/" . $dictamen->id_dictamen;
            $tipo = "Exportación";
        }

    $preguntas = preguntas_revision_dictamen::where('tipo_revisor', 1)->get();
   
    return view('dictamenes.add_revision', compact('revision', 'dictamen', 'tipo', 'url', 'preguntas'));
}
///REGISTRAR REVISION
public function registrar(Request $request)
{
    $request->validate([
        'id_revision' => 'required|integer',
        'respuesta' => 'required|array',
        'observaciones' => 'nullable|array',
        'id_pregunta' => 'required|array',
    ]);

    $revisor = RevisionDictamen::where('id_revision', $request->id_revision)->first();
    if (!$revisor) {
        return response()->json(['message' => 'El registro no fue encontrado.'], 404);
    }

    // Obtener el historial de respuestas como array
    $historialRespuestas = $revisor->respuestas ?? [];

    // Asegurarse de que es un array, por si viene como JSON string
    if (is_string($historialRespuestas)) {
        $historialRespuestas = json_decode($historialRespuestas, true);
    }

    // Definir número de revisión
    $numRevision = count($historialRespuestas) + 1;
    $revisionKey = "Revision $numRevision";



    $nuevoRegistro = [];
    $todasLasRespuestasSonC = true;

    foreach ($request->respuesta as $key => $nuevaRespuesta) {
        $nuevaObservacion = $request->observaciones[$key] ?? null;
        $nuevaIdPregunta = $request->id_pregunta[$key] ?? null;

        if ($nuevaRespuesta == 'NC') {
            $todasLasRespuestasSonC = false;
        }

        $nuevoRegistro[] = [ // Aquí usamos `[]` en lugar de `$key`
            'id_pregunta' => $nuevaIdPregunta,
            'respuesta' => $nuevaRespuesta,
            'observacion' => $nuevaObservacion,
        ];
    }

    // Guardar respuestas en formato JSON (Laravel lo maneja automáticamente)
    $historialRespuestas[$revisionKey] = $nuevoRegistro;
    $revisor->fill([
        'respuestas' => $historialRespuestas,
        'decision' => $todasLasRespuestasSonC ? 'positiva' : 'negativa',
    ]);

    $revisor->save();


    return response()->json(['message' => 'Respuestas y decisión registradas exitosamente.'], 201);
}




/*public function obtenerRespuestas($id)
{
    
        $revisor = RevisionDictamen::where('id_revision', $id)->first();

        if (!$revisor) {
            return response()->json(['message' => 'El registro no fue encontrado.'], 404);
        }

        // Decodificar respuestas
        $historialRespuestas = json_decode($revisor->respuestas, true);

        // Verificar si es un array válido
        $ultimaRevision = is_array($historialRespuestas) ? end($historialRespuestas) : null;
        $decision = $revisor->decision;


        // Respuesta con datos o vacío si no hay historial
        return response()->json([
            'message' => 'Datos de la revisión más actual recuperados exitosamente.',
            'respuestas' => $ultimaRevision,
            'decision' => $decision,
        ], 200);
}*/
///OBTENER REVISION
public function edit_revision($id)
{
    $datos = RevisionDictamen::findOrFail($id);
    $preguntasQuery = preguntas_revision_dictamen::where('tipo_revisor', 1);


    $preguntas = $preguntasQuery->get();

    $respuestas_json = json_decode($datos->respuestas, true); // Convierte el campo JSON a array PHP
    $respuestas_revision = $respuestas_json['Revision '.$datos->numero_revision] ?? []; // O la clave correspondiente

    // Crear un array indexado por id_pregunta para fácil acceso
    $respuestas_map = collect($respuestas_revision)->keyBy('id_pregunta');

    $id_dictamen = $datos->tipo_dictamen ?? '';


    // Obtiene dictamen según tipo_dictamen
    $dictamen = $datos->dictamen;
        if ($datos->tipo_dictamen == 1) { //Instalaciones
            switch ($dictamen->tipo_dictamen) {
                case 1:
                    $tipo = 'Instalaciones de productor';
                    $url = "/dictamen_productor/" . $dictamen->id_dictamen;
                    break;
                case 2:
                    $tipo = 'Instalaciones de envasador';
                    $url = "/dictamen_envasador/" . $dictamen->id_dictamen;
                    break;
                case 3:
                    $tipo = 'Instalaciones de comercializador';
                    $url = "/dictamen_comercializador/" . $dictamen->id_dictamen;
                    break;
                case 4:
                    $tipo = 'Instalaciones de almacén y bodega';
                    $url = "/dictamen_almacen/" . $dictamen->id_dictamen;
                    break;
                case 5:
                    $tipo = 'Instalaciones de área de maduración';
                    $url = "/dictamen_maduracion/" . $dictamen->id_dictamen;
                    break;
                default:
                    $tipo = 'Desconocido';
            }
        } elseif ($datos->tipo_dictamen == 2) { //Granel
            $url = "/dictamen_granel/" . $dictamen->id_dictamen;
            $tipo = "Granel";
        } elseif ($datos->tipo_dictamen == 3) { //envasado
            $url = "/dictamen_envasado/" . $dictamen->id_dictamen;
            $tipo = "Envasado";
        } elseif ($datos->tipo_dictamen == 4) { //exportacion
            $url = "/dictamen_exportacion/" . $dictamen->id_dictamen;
            $tipo = "Exportación";
        }

    return view('dictamenes.edit_revision', compact('datos', 'dictamen', 'preguntas', 'url', 'tipo', 'respuestas_map'));
}
///EDITAR REVISION
public function editar(Request $request)
{
        $request->validate([
            'id_revision' => 'required|integer',
            'respuesta' => 'required|array',
            'observaciones' => 'nullable|array',
            'id_pregunta' => 'required|array',
          // Número de la revisión a editar
        ]);

        $revisor = RevisionDictamen::where('id_revision', $request->id_revision)->first();
        if (!$revisor) {
            return response()->json(['message' => 'El registro no fue encontrado.'], 404);
        }

        // Obtener el historial de respuestas como array
        $historialRespuestas = $revisor->respuestas ?? [];

        // Asegurarse de que es un array, por si viene como JSON string
        if (is_string($historialRespuestas)) {
            $historialRespuestas = json_decode($historialRespuestas, true);
        }

        $revisionKey = "Revision " . $request->numero_revision;

        // Verificar que la revisión exista
        if (!array_key_exists($revisionKey, $historialRespuestas)) {
            return response()->json(['message' => "La $revisionKey no existe."], 404);
        }

        $nuevoRegistro = [];
        $todasLasRespuestasSonC = true;

        foreach ($request->respuesta as $key => $nuevaRespuesta) {
            $nuevaObservacion = $request->observaciones[$key] ?? null;
            $nuevaIdPregunta = $request->id_pregunta[$key] ?? null;

            if ($nuevaRespuesta == 'NC') {
                $todasLasRespuestasSonC = false;
            }

            $nuevoRegistro[] = [
                'id_pregunta' => $nuevaIdPregunta,
                'respuesta' => $nuevaRespuesta,
                'observacion' => $nuevaObservacion,
            ];
        }

        // Actualizar la revisión específica
        $historialRespuestas[$revisionKey] = $nuevoRegistro;

        $revisor->fill([
            'respuestas' => $historialRespuestas,
            'decision' => $todasLasRespuestasSonC ? 'positiva' : 'negativa',
        ]);

        $revisor->save();

    return redirect('/revision/unidad_inspeccion');
}






}//end-Controller
