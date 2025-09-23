<?php

namespace App\Http\Controllers\revision;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\preguntas_revision_dictamen;
use App\Models\RevisionDictamen;
use App\Notifications\GeneralNotification;

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
            ->get();

        return view('revision.revision_dictamenes_view', compact('revisor'));
    }


public function index(Request $request)
{
    $userId = Auth::id();

    DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para meses
    $columns = [
        1 => 'id_revision',
        2 => 'id_inspeccion',
        3 => 'num_servicio',
        4 => 'id_revisor',
        5 => '',//fecha asignacion
        6 => 'decision',//estatus
        7 => ''//opciobnes
    ];

    $limit = $request->input('length');
    $start = $request->input('start');
    $orderColumnIndex = $request->input('order.0.column');// Indice de columna en DataTables
    $orderDirection = $request->input('order.0.dir') ?? 'desc';// Dirección de ordenamiento
    $orderColumn = $columns[$orderColumnIndex] ?? 'id_revision'; // Por defecto
    $search = $request->input('search.value');


    $query = RevisionDictamen::with('inspeccion')
        ->where('tipo_revision', 1);


    // Si no es admin(ID especial) solo ve sus revisiones
    $admins = [1, 7, 9, 319, 335];
    if (!in_array($userId, $admins)) {
        $query->where('id_revisor', $userId);
    }

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
        $tipoSolicitud = [
            1  => 'Muestreo de agave (ART)',
            2  => 'Vigilancia en producción de lote',
            3  => 'Muestreo de lote a granel',
            4  => 'Vigilancia en el traslado del lote',
            5  => 'Inspección de envasado',
            6  => 'Muestreo de lote envasado',
            7  => 'Inspección ingreso a barrica/ contenedor de vidrio',
            8  => 'Liberación de producto terminado nacional',
            9  => 'Inspección de liberación a barrica/contenedor de vidrio',
            10 => 'Georreferenciación',
            11 => 'Pedidos para exportación',
            12 => 'Emisión de certificado NOM a granel',
            13 => 'Emisión de certificado venta nacional',
            14 => 'Dictaminación de instalaciones',
            15 => 'Revisión de etiquetas',
        ];

        // Buscar coincidencia con nombre
        $tipoDictamen = null;
        foreach ($tipoSolicitud as $clave => $valor) {
            if (strpos($searchNormalized, $clave) !== false) {
                $tipoDictamen = $valor;
                break; // en cuanto encuentre coincidencia, detenemos
            }
        }

        // Aplicar la búsqueda
        $query->where(function ($q) use ($search, $tipoDictamen) {
            // Buscar por número de dictamen en distintos modelos
            $q->orWhereHas('inspeccion', fn($q) => $q->where('num_servicio', 'LIKE', "%{$search}%"))
            
            // Buscar por nombre del revisor
            ->orWhereHas('user', fn($q) => $q->where('name', 'LIKE', "%{$search}%"))

            // Buscar por fechas
            ->orWhereRaw("DATE_FORMAT(created_at, '%d de %M del %Y') LIKE ?", ["%$search%"])
            ->orWhereRaw("DATE_FORMAT(updated_at, '%d de %M del %Y') LIKE ?", ["%$search%"]);
            
            // Filtrar por tipo de dictamen si se detectó una palabra clave
            if (!is_null($tipoDictamen)) {
                $q->orWhere('tipo_solicitud', $tipoDictamen);
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

        // Mapeo de tipos de solicitud
        $tipoSolicitud = [
            1  => ['label' => 'Muestreo de agave (ART)', 'class' => 'success'],
            2  => ['label' => 'Vigilancia en producción de lote', 'class' => 'warning text-dark'],
            3  => ['label' => 'Muestreo de lote a granel', 'class' => 'dark'],
            4  => ['label' => 'Vigilancia en el traslado del lote', 'class' => 'secondary'],
            5  => ['label' => 'Inspección de envasado', 'class' => 'info text-dark'],
            6  => ['label' => 'Muestreo de lote envasado', 'class' => 'info text-dark'],
            7  => ['label' => 'Inspección ingreso a barrica/ contenedor de vidrio', 'class' => 'danger'],
            8  => ['label' => 'Liberación de producto terminado nacional', 'class' => 'success'],
            9  => ['label' => 'Inspección de liberación a barrica/contenedor de vidrio', 'class' => 'success'],
            10 => ['label' => 'Georreferenciación', 'class' => 'primary'],
            11 => ['label' => 'Pedidos para exportación', 'class' => 'primary'],
            12 => ['label' => 'Emisión de certificado NOM a granel', 'class' => 'dark'],
            13 => ['label' => 'Emisión de certificado venta nacional', 'class' => 'success'],
            14 => ['label' => 'Dictaminación de instalaciones', 'class' => 'danger'],
            15 => ['label' => 'Revisión de etiquetas', 'class' => 'light text-dark'],
        ];

        $tipoInfo = $tipoSolicitud[$revisor->tipo_solicitud] ?? ['label' => 'No encontrado', 'class' => 'light text-dark'];


        $fechaVigencia   = null;
        $num_servicio    = $revisor->inspeccion->num_servicio ?? null;
        $id_inspeccion   = $revisor->id_inspeccion ?? null;
        return [
            'fake_id' => ++$start,
            'id_revision' => $revisor->id_revision,
            'id_revisor' => $nameRevisor,
            'observaciones' => $revisor->observaciones,
            'num_servicio' => $num_servicio,
            'id_dictamen' => $id_inspeccion,
            'fecha_vigencia' => Helpers::formatearFecha($fechaVigencia),
            'created_at' => Helpers::formatearFechaHora($revisor->created_at),
            'updated_at' => Helpers::formatearFechaHora($revisor->updated_at),
            'decision' => $revisor->decision,
            'num_revision' => $revisor->numero_revision,
            'tipo_revision' => $tipoInfo['label'],//tipo solicitud
            'badge_class'   => $tipoInfo['class'],
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
    $tipoSolicitud = [
            1  => 'Muestreo de agave (ART)',
            2  => 'Vigilancia en producción de lote',
            3  => 'Muestreo de lote a granel',
            4  => 'Vigilancia en el traslado del lote',
            5  => 'Inspección de envasado',
            6  => 'Muestreo de lote envasado',
            7  => 'Inspección ingreso a barrica/ contenedor de vidrio',
            8  => 'Liberación de producto terminado nacional',
            9  => 'Inspección de liberación a barrica/contenedor de vidrio',
            10 => 'Georreferenciación',
            11 => 'Pedidos para exportación',
            12 => 'Emisión de certificado NOM a granel',
            13 => 'Emisión de certificado venta nacional',
            14 => 'Dictaminación de instalaciones',
            15 => 'Revisión de etiquetas',
        ];


    $tipo = $tipoSolicitud[$revision->tipo_solicitud ?? 0] ?? 'Desconocido';
    //$url = '/solicitud_de_servicio/' .$revision->inspeccion->solicitud->id_solicitud;

    $preguntas = preguntas_revision_dictamen::where('tipo_revisor', 1)->get();

    ///
    // obtengo id_solicitud desde la relación inspeccion -> solicitud
    $id_solicitud = $revision->inspeccion->id_solicitud ?? null;
   
    return view('dictamenes.add_revision', compact('revision', 'tipo', 'preguntas', 'id_solicitud'));
}
///REGISTRAR REVISION
public function registrar(Request $request)
{
    /*
    RevisionDictamen::create([
        'id_inspeccion'   => $inspeccion->id_inspeccion,
        'tipo_revision'   => 1,
        'id_revisor'      => $revisor?->id ?? 0,
        'numero_revision' => 1,
        'es_correccion'   => 'no',
        //'decision'       => 'Pendiente',
        'tipo_solicitud'  => $sol->id_tipo ?? 0,
    ]);
    */
    $request->validate([
        'id_revision' => 'required|integer',
        'respuesta' => 'required|array',
        'observaciones' => 'nullable|array',
        'id_pregunta' => 'required|array',
    ]);

    /*$revisor = RevisionDictamen::where('id_revision', $request->id_revision)->first();
    if (!$revisor) {
        return response()->json(['message' => 'El registro no fue encontrado.'], 404);
    }*/
    $revisor = RevisionDictamen::find($request->id_revision);
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


        // Notificación si es negativa
        if (!$todasLasRespuestasSonC) {
            $inspector = $revisor->inspeccion->inspector;

            if ($inspector) {
                $url_clic = "/revision/obtener/{$revisor->id_revision}";

                $inspector->notify(new GeneralNotification([
                    'title'   => 'Revisión de acta NEGATIVA',
                    'message' => 'La revisión del acta ' .$revisor->inspeccion->num_servicio. ' ha sido negativa.',
                    'url'     => $url_clic,
                ]));
            }
        }


    return response()->json(['message' => 'Respuestas y decisión registradas exitosamente.'], 201);
}




///OBTENER REVISION
public function edit_revision($id)
{
    $datos = RevisionDictamen::findOrFail($id);

    // Verificar que el usuario logueado sea el revisor asignado
    /*if ($datos->id_revisor != Auth::id()) {
        abort(403, 'No tienes permisos para editar esta revisión.');
    }*/

    $preguntasQuery = preguntas_revision_dictamen::where('tipo_revisor', 1);
    $preguntas = $preguntasQuery->get();
    $respuestas_json = json_decode($datos->respuestas, true); // Convierte el campo JSON a array PHP
    $respuestas_revision = $respuestas_json['Revision '.$datos->numero_revision] ?? []; // O la clave correspondiente
    // Crear un array indexado por id_pregunta para fácil acceso
    $respuestas_map = collect($respuestas_revision)->keyBy('id_pregunta');


    // Obtiene dictamen según tipo_dictamen
    $tipoSolicitud = [
            1  => 'Muestreo de agave (ART)',
            2  => 'Vigilancia en producción de lote',
            3  => 'Muestreo de lote a granel',
            4  => 'Vigilancia en el traslado del lote',
            5  => 'Inspección de envasado',
            6  => 'Muestreo de lote envasado',
            7  => 'Inspección ingreso a barrica/ contenedor de vidrio',
            8  => 'Liberación de producto terminado nacional',
            9  => 'Inspección de liberación a barrica/contenedor de vidrio',
            10 => 'Georreferenciación',
            11 => 'Pedidos para exportación',
            12 => 'Emisión de certificado NOM a granel',
            13 => 'Emisión de certificado venta nacional',
            14 => 'Dictaminación de instalaciones',
            15 => 'Revisión de etiquetas',
        ];

    $tipo = $tipoSolicitud[$datos->tipo_solicitud ?? 0] ?? 'Desconocido';

    $preguntas = preguntas_revision_dictamen::where('tipo_revisor', 1)->get();

    ///
    // obtengo id_solicitud desde la relación inspeccion -> solicitud
    $id_solicitud = $datos->inspeccion->id_solicitud ?? null;


    return view('dictamenes.edit_revision', compact('datos', 'preguntas', 'tipo', 'respuestas_map', 'id_solicitud'));
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

        // Validar que administrador o revisor asignado puedan editar
        if (Auth::id() != 1 && $revisor->id_revisor != Auth::id()) {
            return response()->json(['message' => 'No tienes permisos para editar esta revisión.'], 403);
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
