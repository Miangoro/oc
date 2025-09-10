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


    // Si el usuario no es admin(ID especial) solo ve sus propias revisiones
    /*if (!in_array($userId, [1, 2, 3, 4, 320])) {
        $query->where('id_revisor', $userId);
    }*/


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
            'granel'         => 2,
            'envasado'       => 3,
            'exportacion'    => 4,
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
    }


    // Paginación y ordenación
    


    // Obtener los totales de registros por separado
    $totalDataRevisor = $query->count();


    // Consultar los registros
    $revisores = $query->offset($start)->limit($limit)->orderBy($orderColumn, $orderDirection)->get();



    // Formatear los datos para la vista
    // Formatear los datos para la vista
    $dataRevisor = $revisores->map(function ($revisor) use (&$start) {

        $nameRevisor = $revisor->user->name ?? null;

        // Mapeo de tipos de dictamen → modelo + etiqueta
        $tipos = [
            1 => [
                'modelo' => 'dictamenInstalacion',
                'etiquetas' => [
                    1 => 'Instalaciones de productor',
                    2 => 'Instalaciones de envasador',
                    3 => 'Instalaciones de comercializador',
                    4 => 'Instalaciones de almacén y bodega',
                    5 => 'Instalaciones de área de maduración',
                ],
            ],
            2 => [
                'modelo' => 'dictamenGranel',
                'etiqueta' => 'Granel',
            ],
            3 => [
                'modelo' => 'dictamenEnvasado',
                'etiqueta' => 'Envasado',
            ],
            4 => [
                'modelo' => 'dictamenExportacion',
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
                $num_dictamen = $relacion->num_dictamen ?? null;
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


    // Total de resultados
    $totalData = $totalDataRevisor;

    // Devolver los resultados como respuesta JSON
    return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalData),
        'data' => array_merge($dataRevisor->toArray()), // Combinacion
    ]);
}








}//end-Controller
