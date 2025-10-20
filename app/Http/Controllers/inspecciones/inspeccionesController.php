<?php

namespace App\Http\Controllers\inspecciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Documentacion_url;
use App\Models\instalaciones;
use App\Models\empresa;
use App\Models\estados;
use App\Models\actas_inspeccion;
use App\Models\actas_testigo;
use App\Models\actas_produccion;
use App\Models\actas_equipo_mezcal;
use App\Models\actas_equipo_envasado;
use App\Models\acta_produccion_mezcal;
use App\Models\actas_unidad_comercializacion;
use App\Models\actas_unidad_envasado;
use App\Models\Predios;
use App\Models\tipos;
use App\Models\equipos;
use App\Models\solicitudTipo;
use App\Models\guias;
use App\Models\LotesGranel;
use App\Models\lotes_envasado;
use App\Models\clases;
use App\Models\categorias;

use App\Models\Organismos;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helpers;
use App\Models\inspecciones;
use App\Models\solicitudesModel;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
/* clases de exportacion */
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SolicitudesExport;
use App\Exports\InspeccionesExport;
use App\Models\RevisionDictamen;

class inspeccionesController extends Controller
{
    public function UserManagement()
    {
        $solicitudesTipos = solicitudTipo::all();
        $instalaciones = instalaciones::all(); // Obtener todas las instalaciones
        $Predios = Predios::all(); // Obtener todas las instalaciones
        $empresas = empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $estados = estados::all(); // Obtener todos los estados
        $tipos = tipos::all(); // Obtener todos los estados
        $equipos = equipos::all(); // Obtener todos los estados
        $todasSolicitudes = solicitudesModel::select('id_solicitud', 'folio')
            ->where('id_tipo', '!=', 12)
            ->whereYear('fecha_solicitud', '>=', 2025)
            ->orderBy('id_solicitud', 'desc')
            ->get();

      $solcitudesSinInspeccion = solicitudesModel::whereDoesntHave('inspeccion')
          ->where('id_tipo', '!=', 12)
          ->whereYear('fecha_solicitud', '>=', 2025)
          ->orderBy('id_solicitud', 'desc')
          ->get();

        $inspectores = User::where('tipo', '=', '2')
            ->where('estatus', 'Activo')
            ->get(); // Obtener todos los organismos

        return view('inspecciones.find_inspecciones_view', compact('solicitudesTipos','instalaciones', 'empresas', 'estados', 'inspectores', 'Predios', 'tipos', 'equipos','todasSolicitudes', 'solcitudesSinInspeccion'));
    }


public function index(Request $request)
{
    $columns = [
        1 => 'id_solicitud',
        2 => 'folio',
        3 => 'num_servicio',
        4 => 'razon_social',
        5 => '',//fecha_solicitud
        6 => 'tipo',
        7 => 'direccion_completa',
        8 => 'inspector',
        9 => 'fecha_servicio',
        10 => 'fecha_visita',
        11 => 'name',
        12 => 'id_inspeccion',
        13 => 'id_empresa',
        14 => 'ubicacion_predio'
    ];

    $limit = $request->input('length');
    $start = $request->input('start');
    $orderIndex = $request->input('order.0.column');
    $orderColumn = $columns[$orderIndex] ?? 'id_solicitud';
    $dir = $request->input('order.0.dir', 'asc');
    $search = $request->input('search.value');

    ///CONSULTA QUERY BASE
    $query = solicitudesModel::with('tipo_solicitud', 'empresa', 'inspeccion', 'inspector', 'instalacion','predios')
        ->where('habilitado', 1)
        ->where('id_tipo', '!=', 12);


    $columnsInput = $request->input('columns');

    if ($columnsInput && isset($columnsInput[6]) && !empty($columnsInput[6]['search']['value'])) {
        $tipoFilter = $columnsInput[6]['search']['value'];
        // Filtro exacto o LIKE según necesites
        $query->whereHas('tipo_solicitud', function($q) use ($tipoFilter) {
            $q->where('tipo', 'LIKE', "%{$tipoFilter}%");
        });
    }


    // Búsqueda global
    if (!empty($search)) {

        //Buscar lote envasado -> granel
        $loteIds = DB::table('lotes_envasado')
            ->join('marcas', 'lotes_envasado.id_marca', '=', 'marcas.id_marca')
            ->select('lotes_envasado.id_lote_envasado')
            ->where(function ($query) use ($search) {
                $query->where('lotes_envasado.nombre', 'LIKE', "%{$search}%")
                      ->orWhere('marcas.marca', 'LIKE', "%{$search}%");
            })
            ->union(
                DB::table('lotes_envasado_granel')
                    ->join('lotes_granel', 'lotes_granel.id_lote_granel', '=', 'lotes_envasado_granel.id_lote_granel')
                    ->select('lotes_envasado_granel.id_lote_envasado')
                    ->where('lotes_granel.nombre_lote', 'LIKE', "%{$search}%")
            )
            ->get()
            ->pluck('id_lote_envasado')
            ->toArray();

        //Buscar lote envasado
        $loteEnvIds = DB::table('lotes_envasado')
          ->select('id_lote_envasado')
          ->where('nombre', 'LIKE', "%{$search}%")
          ->pluck('id_lote_envasado')
          ->toArray();

        // Buscar por lote granel
        // Paso 1: obtener IDs del catálogo que coincidan con el search
        $tipoAgaveIds = DB::table('catalogo_tipo_agave')
            ->where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('cientifico', 'LIKE', "%{$search}%")
            ->pluck('id_tipo')
            ->toArray();
        // Paso 2: buscar lotes_granel que contengan esos tipos
        $loteGranelIds = DB::table('lotes_granel')
            ->select('id_lote_granel')
            ->where(function ($query) use ($search, $tipoAgaveIds) {
                $query->where('nombre_lote', 'LIKE', "%{$search}%")
                    ->orWhere('folio_fq', 'LIKE', "%{$search}%")
                    ->orWhere('cont_alc', 'LIKE', "%{$search}%")
                    ->orWhere('volumen', 'LIKE', "%{$search}%")
                    ->orWhere('volumen_restante', 'LIKE', "%{$search}%");
                // buscar por coincidencias en el array JSON
                foreach ($tipoAgaveIds as $idTipo) {
                    $query->orWhere('id_tipo', 'LIKE', '%"'.$idTipo.'"%');
                }
            })
            ->pluck('id_lote_granel')
            ->toArray();

        $query->where(function ($q) use ($search, $loteIds, $loteEnvIds, $loteGranelIds) {
            $q->where('id_solicitud', 'LIKE', "%{$search}%")
                ->orWhere('folio', 'LIKE', "%{$search}%")
                ->orWhere('info_adicional', 'LIKE', "%{$search}%")
                ->orWhere('solicitudes.caracteristicas', 'LIKE', '%"no_pedido":"%' . $search . '%"%')
                ->orWhereHas('empresa', function ($q) use ($search) {
                    $q->where('razon_social', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('instalacion', function ($q) use ($search) {
                    $q->where('direccion_completa', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('predios', function ($q) use ($search) {
                    $q->where('ubicacion_predio', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('predios', function ($q) use ($search) {
                    $q->where('nombre_predio', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('inspeccion', function ($q) use ($search) {
                    $q->where('num_servicio', 'LIKE', "%{$search}%");
                })

                ->orWhereHas('tipo_solicitud', function ($q) use ($search) {
                    $q->where('tipo', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('inspector', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });

                //Buscar lote envasado -> granel
                foreach ($loteIds as $idLote) {
                    $q->orWhere('solicitudes.caracteristicas', 'LIKE', '%"id_lote_envasado":' . $idLote . '%');
                }
                //Buscar lote envasado
                foreach ($loteEnvIds as $idLoteEnv) {
                    $q->orWhere('solicitudes.caracteristicas', 'LIKE', '%"id_lote_envasado":"' . $idLoteEnv . '"%');
                }
                //Buscar lote granel
                foreach ($loteGranelIds as $idLoteGran) {
                    $q->orWhere('solicitudes.caracteristicas', 'LIKE', '%"id_lote_granel":"' . $idLoteGran . '"%');
                }
        });
    }


    $totalData = solicitudesModel::with('tipo_solicitud', 'empresa', 'inspeccion', 'inspector', 'instalacion', 'predios')
        ->where('id_tipo', '!=', 12)
        ->where('habilitado', 1)->count();
    $totalFiltered = $query->count();


    // Obtener datos paginados sin orden
    $solicitudes = $query->get();

        // Ordenar manualmente si es un campo de relación
        if ($orderColumn === 'folio') {
            // Ordenar por la parte numérica del folio "SOL-#####"
            $solicitudes = $solicitudes->sortBy(function ($item) {
                // Extraemos el número, asumiendo formato 'SOL-#####'
                return intval(substr($item->folio, 4));
            }, SORT_NUMERIC, $dir === 'desc');

        } elseif (in_array($orderColumn, ['num_servicio', 'razon_social', 'tipo', 'name'])) {
            $solicitudes = $solicitudes->sortBy(function ($item) use ($orderColumn) {
                switch ($orderColumn) {
                    case 'num_servicio':
                        return $item->inspeccion->num_servicio ?? '';
                    case 'razon_social':
                        return $item->empresa->razon_social ?? '';
                    case 'tipo':
                        return $item->tipo_solicitud->tipo ?? '';
                    case 'name':
                        return $item->inspector->name ?? '';
                }
            }, SORT_REGULAR, $dir === 'desc');

        } else {
            // Ordenar campos propios del modelo
            $solicitudes = $solicitudes->sortBy($orderColumn, SORT_REGULAR, $dir === 'desc');
        }


        // Paginar manualmente
        $solicitudes = $solicitudes->slice($start, $limit)->values();



        //MANDA LOS DATOS AL JS
        $data = [];
        if (!empty($solicitudes)) {
            $ids = $start;
            foreach ($solicitudes as $solicitud) {
                $empresa = $solicitud->empresa;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                    ? $empresa->empresaNumClientes
                    ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
                    : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['id_inspeccion'] = $solicitud->inspeccion->id_inspeccion ?? '0';
                $nestedData['id_empresa'] = $solicitud->empresa->id_empresa ?? '0';
                $nestedData['id_solicitud'] = $solicitud->id_solicitud ?? 'N/A';
                $nestedData['id_acta'] = $solicitud->inspeccion->actas_inspeccion->id_acta ?? 'N/A';
                $nestedData['fake_id'] = ++$ids  ?? 'N/A';
                $nestedData['folio'] = $solicitud->folio ?? '';
                $nestedData['folio_info'] = $solicitud->folio;
                $nestedData['num_servicio_info'] = $solicitud->inspeccion->num_servicio ?? 'Sin asignar';
                $nestedData['num_servicio'] = $solicitud->inspeccion->num_servicio ?? 'Sin asignar';
                $nestedData['razon_social'] = $solicitud->empresa->razon_social  ?? 'N/A';
                $nestedData['fecha_solicitud'] = Helpers::formatearFechaHora($solicitud->fecha_solicitud)  ?? 'N/A';
                $nestedData['tipo'] = $solicitud->tipo_solicitud->tipo  ?? 'N/A';
                $nestedData['direccion_completa'] = !empty($solicitud->instalacion->direccion_completa)
                            ? $solicitud->instalacion->direccion_completa
                            : (
                                isset($solicitud->predios)
                                    ? trim("{$solicitud->predios->ubicacion_predio} {$solicitud->predios->nombre_predio}")
                                    : 'N/A'
                            );

                $nestedData['tipo_instalacion'] = $solicitud->instalacion->tipo  ?? '';
                $nestedData['fecha_visita'] = Helpers::formatearFechaHora($solicitud->fecha_visita)  ?? '<span class="badge bg-danger">Sin asignar</span>';
                $nestedData['inspector'] = $solicitud->inspector->name ?? '<span class="badge bg-danger">Sin asignar</span>'; // Maneja el caso donde el organismo sea nulo
                $nestedData['inspectorName'] = $solicitud->inspector->name ?? 'Sin inspector';
                $nestedData['foto_inspector'] = $solicitud->inspector->profile_photo_path ?? '';
                $nestedData['id_tipo'] = $solicitud->tipo_solicitud->id_tipo ?? 'N/A';

                $nestedData['fecha_servicio'] = $nestedData['fecha_servicio'] = $solicitud->inspeccion && $solicitud->inspeccion->fecha_servicio
                    ? Helpers::formatearFechaHora($solicitud->inspeccion->fecha_servicio)
                    : '<span class="badge bg-danger">Sin asignar</span>';

                $urls = $solicitud->documentacion(69)->pluck('url')->toArray();
                if ($solicitud->inspeccion?->dictamen) {
                    switch ($solicitud->inspeccion->dictamen->tipo_dictamen) {
                        case 1:
                            $tipo_dictamen = 'dictamen_productor';
                            break;
                        case 2:
                            $tipo_dictamen = 'dictamen_envasador';
                            break;
                        case 3:
                            $tipo_dictamen = 'dictamen_comercializador';
                            break;
                        case 4:
                            $tipo_dictamen = 'dictamen_almacen';
                            break;
                        default:
                            $tipo_dictamen = 'Sin tipo';
                            break;
                    }
                    $id = $solicitud->inspeccion->dictamen->id_dictamen;
                } elseif ($solicitud->inspeccion?->dictamenGranel) {
                    $tipo_dictamen = 'dictamen_granel';
                    $id = $solicitud->inspeccion->dictamenGranel->id_dictamen;
                } elseif ($solicitud->inspeccion?->dictamenEnvasado) {
                    $tipo_dictamen = 'dictamen_envasado';
                    $id = $solicitud->inspeccion->dictamenEnvasado->id_dictamen_envasado;
                }elseif ($solicitud->inspeccion?->dictamenExportacion) {
                    $tipo_dictamen = 'dictamen_exportacion';
                    $id = $solicitud->inspeccion->dictamenExportacion->id_dictamen;
                } else {
                    $tipo_dictamen = null;
                    $id = null;
                }

                $nestedData['url_dictamen'] = $id ? $tipo_dictamen . '/' . $id : 'Sin subir';



                // Comprobamos si $urls está vacío
                if (empty($urls)) {
                    // Si está vacío, asignamos la etiqueta de "Sin subir"
                    $nestedData['url_acta'] = 'Sin subir';
                } else {
                    // Si hay URLs, las unimos en una cadena separada por comas
                    $nestedData['url_acta'] = implode(', ', $urls);
                }




        ///CAMPO DE CARACTERISTICAS
                $caracteristicas = json_decode($solicitud->caracteristicas, true);
                //GUIAS
                $idLoguiass = $caracteristicas['id_guia'] ?? null;
                $guias = [];
                if (!empty($idLoguiass)) {
                    // Busca las guías relacionadas
                    $guias = guias::whereIn('id_guia', $idLoguiass)->pluck('folio')->toArray();
                }
                // Devuelve las guías como una cadena separada por comas
                $nestedData['guias'] = !empty($guias) ? implode(', ', $guias) : 'N/A';
                //LOTE GRANEL
                $idLoteGranel = $caracteristicas['id_lote_granel'] ?? null;
                $loteGranel = LotesGranel::find($idLoteGranel); // Busca el lote a granel
                $nestedData['nombre_lote'] = $loteGranel ? $loteGranel->nombre_lote : 'N/A';

                $nestedData['nombre_predio'] = $caracteristicas['nombre_predio'] ?? 'N/A';
                $nestedData['art'] = $caracteristicas['art'] ?? 'N/A';
                $nestedData['analisis'] = $caracteristicas['analisis'] ?? 'N/A';
                $nestedData['etapa'] = $caracteristicas['etapa'] ?? 'N/A';
                $nestedData['fecha_corte'] = isset($caracteristicas['fecha_corte']) ? Carbon::parse($caracteristicas['fecha_corte'])->format('d/m/Y H:i') : 'N/A';
                ///TIPO MAGUEY
                $idTipoMagueyMuestreo = $caracteristicas['id_tipo_maguey'] ?? null;
                /*if ($idTipoMagueyMuestreo) {
                    if (is_array($idTipoMagueyMuestreo)) {
                        $idTipoMagueyMuestreo = implode(',', $idTipoMagueyMuestreo);
                    }
                    $idTipoMagueyMuestreoArray = explode(',', $idTipoMagueyMuestreo);
                    $tiposMaguey = tipos::whereIn('id_tipo', $idTipoMagueyMuestreoArray)->pluck('nombre')->toArray();
                    if ($tiposMaguey) {
                        $nestedData['id_tipo_maguey'] = implode(', ', $tiposMaguey);
                    } else {
                        $nestedData['id_tipo_maguey'] = 'N/A';
                    }
                } else {
                    $nestedData['id_tipo_maguey'] = 'N/A';
                }*/
                if ($idTipoMagueyMuestreo) {
                    if (is_array($idTipoMagueyMuestreo)) {
                        $idTipoMagueyMuestreo = implode(',', $idTipoMagueyMuestreo);
                    }
                    $idTipoMagueyMuestreoArray = explode(',', $idTipoMagueyMuestreo);

                    // Convertir a string para evitar problemas de coincidencia
                    $idTipoMagueyMuestreoArray = array_map('strval', $idTipoMagueyMuestreoArray);

                    // Obtenemos nombre de todos los tipos de maguey (clave = id)
                    $tiposMagueyDB = tipos::whereIn('id_tipo', $idTipoMagueyMuestreoArray)
                        ->pluck('nombre', 'id_tipo')
                        ->mapWithKeys(fn($nombre, $id) => [strval($id) => $nombre])
                        ->toArray();

                    // Mapear en el mismo orden que el array original
                    $tiposMagueyOrdenados = array_map(function($tipoId) use ($tiposMagueyDB) {
                        return $tiposMagueyDB[$tipoId] ?? 'Desconocido';
                    }, $idTipoMagueyMuestreoArray);

                    if (!empty($tiposMagueyOrdenados)) {
                        $nestedData['id_tipo_maguey'] = implode(', ', $tiposMagueyOrdenados);
                    } else {
                        $nestedData['id_tipo_maguey'] = 'N/A';
                    }
                } else {
                    $nestedData['id_tipo_maguey'] = 'N/A';
                }
                

                $nestedData['id_categoria'] = isset($caracteristicas['id_categoria']) ? categorias::find($caracteristicas['id_categoria'])->categoria : 'N/A';
                $nestedData['id_clase'] = isset($caracteristicas['id_clase']) ? clases::find($caracteristicas['id_clase'])->clase : 'N/A';
                $nestedData['id_certificado_muestreo'] = $caracteristicas['id_certificado_muestreo'] ?? 'N/A';
                $nestedData['cont_alc'] = $caracteristicas['cont_alc'] ?? 'N/A';
                $nestedData['id_categoria_traslado'] = $caracteristicas['id_categoria_traslado'] ?? 'N/A';
                $nestedData['id_clase_traslado'] = $caracteristicas['id_clase_traslado'] ?? 'N/A';
                $nestedData['id_tipo_maguey_traslado'] = $caracteristicas['id_tipo_maguey_traslado'] ?? 'N/A';
                $nestedData['id_vol_actual'] = $caracteristicas['id_vol_actual'] ?? 'N/A';
                $nestedData['id_vol_res'] = $caracteristicas['id_vol_res'] ?? 'N/A';
                $nestedData['analisis_traslado'] = $caracteristicas['analisis_traslado'] ?? 'N/A';
                //LOTE ENVASADO
                if (isset($caracteristicas['id_lote_envasado'])) {
                    $idLoteEnvasado = $caracteristicas['id_lote_envasado'];
                } elseif (isset($caracteristicas['detalles']) && is_array($caracteristicas['detalles']) && isset($caracteristicas['detalles'][0]['id_lote_envasado'])) {
                    $idLoteEnvasado = $caracteristicas['detalles'][0]['id_lote_envasado'];
                    $cajas = $caracteristicas['detalles'][0]['cantidad_cajas'];
                    $botellas = $caracteristicas['detalles'][0]['cantidad_botellas'];
                    $presentacion = $caracteristicas['detalles'][0]['presentacion'];
                } else {
                    $idLoteEnvasado = null;
                }
                $loteEnvasado = lotes_envasado::with('marca')->find($idLoteEnvasado); // Busca el lote envasado

                if ($loteEnvasado && $loteEnvasado->marca) {
                    $marca = $loteEnvasado->marca->marca;
                } else {
                    $marca = null; // O un valor por defecto
                }
                $nestedData['id_lote_envasado'] = $loteEnvasado ? $loteEnvasado->nombre : 'N/A';
                $primerLote = $loteEnvasado?->lotesGranel->first();
                $nestedData['lote_granel'] = $primerLote ? $primerLote->nombre_lote : 'N/A';


                $nestedData['info_adicional'] = $solicitud->info_adicional ?? 'Vacío';
                $nestedData['analisis_barricada'] = $caracteristicas['analisis'] ?? 'N/A';
                $nestedData['tipo_lote'] = $caracteristicas['tipoIngreso'] ?? 'N/A';
                $nestedData['fecha_inicio'] = isset($caracteristicas['fecha_inicio']) ? Carbon::parse($caracteristicas['fecha_inicio'])->format('d/m/Y') : 'N/A';
                $nestedData['fecha_termino'] = isset($caracteristicas['fecha_termino']) ? Carbon::parse($caracteristicas['fecha_termino'])->format('d/m/Y') : 'N/A';
                $nestedData['volumen_ingresado'] = $caracteristicas['volumen_ingresado'] ?? 'N/A';
                $nestedData['tipo_lote_lib'] = $caracteristicas['tipoLiberacion'] ?? 'N/A';
                $nestedData['punto_reunion'] = $caracteristicas['punto_reunion'] ?? 'N/A';
                $nestedData['marca'] = $marca ?? 'N/A';
                $nestedData['presentacion'] = $presentacion ?? 'N/A';
                $nestedData['cajas'] = $cajas ?? 'N/A';
                $nestedData['botellas'] = $botellas ?? 'N/A';
                $nestedData['no_pedido'] = $caracteristicas['no_pedido'] ?? 'N/A';
                $nestedData['pais'] = $solicitud->direccion_destino->pais_destino ?? 'No encontrado';
                $nestedData['certificado_exportacion'] = $solicitud->certificadoExportacion()?->num_certificado ?? '';
                $nestedData['combinado'] = ($caracteristicas['tipo_solicitud'] ?? null) == 2
                    ? '<span class="badge rounded-pill bg-info"><b>Combinado</b></span>'
                    : '';
                $nestedData['renovacion'] = $caracteristicas['renovacion'] ?? 'N/A';


                //REVISION DEL ACTA
                $idInspeccion = $solicitud->inspeccion->id_inspeccion ?? null;

                $ultimaRevision = $idInspeccion 
                    ? RevisionDictamen::where('id_inspeccion', $idInspeccion)
                        ->orderByDesc('numero_revision')
                        ->first()
                    : null;

                $nestedData['ultima_revision'] = $ultimaRevision ? [
                    'numero_revision' => $ultimaRevision->numero_revision,
                    'decision'        => $ultimaRevision->decision,
                    ] : null;



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



    public function destroy($id_instalacion)
    {
        try {
            $instalacion = instalaciones::findOrFail($id_instalacion);
            $instalacion->delete();

            return response()->json(['success' => 'Instalación eliminada correctamente']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Instalación no encontrada'], 404);
        }
    }


    public function edit($id_instalacion)
    {
        try {
            // Obtener la instalación y sus documentos asociados
            $instalacion = instalaciones::findOrFail($id_instalacion);

            // Obtener los documentos asociados
            $documentacion_urls = Documentacion_url::where('id_relacion', $id_instalacion)->get();

            // Extraer la URL del primer documento, si existe
            $archivo_url = $documentacion_urls->isNotEmpty() ? $documentacion_urls->first()->url : '';

            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $instalacion->id_empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

            return response()->json([
                'success' => true,
                'instalacion' => $instalacion,
                'archivo_url' => $archivo_url, // Incluir la URL del archivo
                'numeroCliente' => $numeroCliente
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false], 404);
        }
    }

public function asignarInspector(Request $request)
{
    try {
        // Validar datos
        $request->validate([
            'id_solicitud' => 'required|integer',
            'id_inspector' => 'required|integer|exists:users,id',
            'num_servicio' => 'required|string',
            'fecha_servicio' => 'required|date',
            'observaciones' => 'nullable|string',
            'solInspecciones' => 'nullable|array'
        ]);

        // Inspección principal
        inspecciones::updateOrCreate(
            ['id_solicitud' => $request->id_solicitud],
            [
                'id_inspector' => $request->id_inspector,
                'num_servicio' => $request->num_servicio,
                'fecha_servicio' => $request->fecha_servicio,
                'estatus_inspeccion' => 1,
                'observaciones' => $request->observaciones ?? '',
            ]
        );

        // Aplicar la misma inspección a solicitudes adicionales
        $solicitudesAdicionales = $request->solInspecciones ?? [];

        foreach ($solicitudesAdicionales as $idAdicional) {
            inspecciones::updateOrCreate(
                ['id_solicitud' => $idAdicional],
                [
                    'id_inspector' => $request->id_inspector,
                    'num_servicio' => $request->num_servicio,
                    'fecha_servicio' => $request->fecha_servicio,
                    'estatus_inspeccion' => 1,
                    'observaciones' => $request->observaciones ?? '',
                ]
            );
        }

        // Notificar al inspector
        $users = User::whereIn('id', [$request->id_inspector])->get();

        $data1 = [
            'title' => 'Nueva inspección',
            'message' => 'Se te asignó la inspección ' . $request->num_servicio,
            'url' => 'inspecciones',
        ];

        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }

        return response()->json([
            'success' => true,
            'message' => 'Inspector asignado correctamente.'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Errores de validación.',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}





    //Pdfs de inspecciones
    public function pdf_oficio_comision($id_inspeccion)
    {

        $datos = inspecciones::with(['inspector', 'solicitud.instalacion', 'solicitud.tipo_solicitud'])->find($id_inspeccion);

        $fecha_servicio = !empty($datos->fecha_servicio)
            ? Helpers::formatearFecha($datos->fecha_servicio)
            : null;

    $id_inspector = in_array($datos->id_inspector, [9, 15, 16, 17, 18])
    ? User::find(6)
    : User::find(9);


        $pdf = Pdf::loadView('pdfs.oficioDeComision', [
                'datos' => $datos,
                'fecha_servicio' => $fecha_servicio,
                'id_inspector' => $id_inspector,
            ]);
        return $pdf->stream('F-UV-02-09 Oficio de Comisión Ed.5, Vigente.pdf');
    }

    public function pdf_orden_servicio($id_inspeccion)
    {
        $datos = inspecciones::with(['inspector', 'solicitud.instalacion', 'solicitud.empresa.empresaNumClientes'])->find($id_inspeccion);
        $fecha_servicio = !empty($datos->fecha_servicio)
            ? Helpers::formatearFecha($datos->fecha_servicio)
            : null;
        $pdf = Pdf::loadView('pdfs.ordenDeServicio', ['datos' => $datos, 'fecha_servicio' => $fecha_servicio]);
        return $pdf->stream('F-UV-02-01 Orden de servicio Ed. 5, Vigente.pdf');
    }



//SUBIR DOCUMENTOS DE INSPECCION
public function agregarResultados(Request $request)
{
    $sol = solicitudesModel::find($request->id_solicitud);
    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $sol->empresa->id_empresa)->first();
    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
        return !empty($numero);
    });

    $mensaje = "";

    if ($request->hasFile('url')) {
        foreach ($request->file('url') as $index => $file) {
            if ($request->id_solicitud) {
                $documentacion_url = null;

                //si hay "ACTA"
                if ($request->id_documento[$index] == 69) {
                    $documentacion_url = Documentacion_url::where('id_relacion', $request->id_solicitud)
                        ->where('id_documento', 69)
                        ->first();

                    /// ASIGNAR REVISION AUTOMATICA
                    //if ($sol->inspeccion && $sol->id_tipo != 8) { // Verifica que exista la inspección
                    if ($sol->inspeccion) {
                        $inspeccion = $sol->inspeccion;
                    
                        // Buscar la última revisión de esta inspección
                        $ultimaRevision = RevisionDictamen::where('id_inspeccion', $inspeccion->id_inspeccion)
                            ->orderByDesc('numero_revision')
                            ->first();

                        $asignarRevision = false;
                        $esCorreccion = 'no';
                        $nuevoNumeroRevision = 1;
                        $revisorId = null;

                        // Primera revisión
                        if (!$ultimaRevision) { 
                            $asignarRevision = true;
                            $esCorreccion = 'no';
                            $nuevoNumeroRevision = 1;

                            // Selecciona revisor aleatorio tipo 2 activo, excepto el inspector
                            $excluirId = $inspeccion->id_inspector;
                            $excluirTipo2 = [$excluirId, 12, 353];//tipo 2 a excluir amairany,ricardo
                            $incluirManual = [319, 335, 344];//incluir tipo 1 gil, Sylvana, Elizabeth
                            $revisor = User::where(function($query) use ($excluirTipo2, $incluirManual) {
                                // Usuarios tipo 2, activos, excluyendo ciertos IDs
                                $query->where('tipo', 2)
                                    ->where('estatus', 'Activo')
                                    ->whereNotIn('id', $excluirTipo2)
                                    ->orWhereIn('id', $incluirManual);
                                })
                                ->inRandomOrder()
                                ->first();

                            $revisorId = $revisor?->id ?? 0;

                        // Corrección
                        } elseif ($ultimaRevision->decision === 'negativa') {
                            $asignarRevision = true;
                            $esCorreccion = 'si';
                            $nuevoNumeroRevision = $ultimaRevision->numero_revision + 1;

                            // Usar el mismo revisor que registró la negativa
                            $revisorId = $ultimaRevision->id_revisor;
                        }
                        // Si la última revisión es Pendiente o Positiva → no se asigna nada

                        if ($asignarRevision) {
                            // Crear la revisión automática
                            $revision = RevisionDictamen::create([
                                'tipo_revision'   => 1,
                                'id_revisor'      => $revisorId ?? 0,
                                'id_inspeccion'   => $inspeccion->id_inspeccion,
                                'numero_revision' => $nuevoNumeroRevision,
                                'es_correccion'   => $esCorreccion,
                                'tipo_solicitud'  => $sol->id_tipo ?? 0,
                            ]);

                            // Notificación al revisor
                            if ($revisorId) {
                                $url_clic = "/revision/ver/{$revision->id_revision}";
                                $titulo = 'Revisión de acta' . ($esCorreccion === 'si' ? ' CORRECCIÓN' : '');

                                $revisor = User::find($revisorId);
                                $revisor->notify(new GeneralNotification([
                                    'title'   => $titulo,
                                    'message' => 'Se te ha asignado el acta ' . $inspeccion->num_servicio,
                                    'url'     => $url_clic,
                                ]));
                            }
                        }
                    }//fin revision automatica
                } // fin acta
                

                if ($documentacion_url) {
                    $existingFilePath = 'uploads/' . $numeroCliente . '/actas/' . $documentacion_url->url;
                    if (Storage::disk('public')->exists($existingFilePath)) {
                        Storage::disk('public')->delete($existingFilePath);
                    }
                } else {
                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $request->id_solicitud;
                    $documentacion_url->id_documento = $request->id_documento[$index];
                    $documentacion_url->id_empresa = $sol->id_empresa;
                }

                // Guardar archivo
                $filename = str_replace('/', '-', $request->nombre_documento[$index]) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('uploads/' . $numeroCliente . '/actas/', $filename, 'public');

                $documentacion_url->nombre_documento = str_replace('/', '-', $request->nombre_documento[$index]);
                $documentacion_url->url = $filename;
                $documentacion_url->fecha_vigencia = $request->fecha_vigencia[$index] ?? null;
                $documentacion_url->save();

                $mensaje = str_replace('/', '-', $request->nombre_documento[$index]) . ", " . $mensaje;

                // Insertar en solicitudes adicionales enviadas en el request
                $solicitudesAdicionales = $request->solicitudes_adicionales ?? [];

                foreach ($solicitudesAdicionales as $idAdicional) {
                    // Verificar si ya existe el registro



                        $nuevoDoc = new Documentacion_url();
                        $nuevoDoc->id_relacion = $idAdicional;
                        $nuevoDoc->id_documento = $request->id_documento[$index];
                        $nuevoDoc->id_empresa = $sol->id_empresa;
                        $nuevoDoc->nombre_documento = str_replace('/', '-', $request->nombre_documento[$index]);
                        $nuevoDoc->url = $filename;
                        $nuevoDoc->fecha_vigencia = $request->fecha_vigencia[$index] ?? null;
                        $nuevoDoc->save();

                }
            }
        }
    }

    // return response()->json(['success' => true, 'mensaje' => $mensaje]);
}


    // Método para obtener una guía por ID
    public function editActa($id_acta)
    {
        try {
            // Aquí obtienes el acta de inspección junto con sus testigos
            $acta = actas_inspeccion::with(
                'actas_testigo',
                'acta_produccion_mezcal',
                'actas_equipo_mezcal',
                'actas_unidad_envasado',
                'actas_unidad_comercializacion',
                'actas_equipo_envasado',
                'actas_produccion'
            )->findOrFail($id_acta);

            return response()->json($acta);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el acta por ID'], 500);
        }
    }

    public function getInspeccion($id_solicitud)
    {
        try {
            // Aquí obtienes el acta de inspección junto con sus testigos
            $datos = solicitudesModel::with('inspeccion', 'empresa')->where('id_solicitud', $id_solicitud)->first();
            return response()->json(['success' => true, 'data' => $datos]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los datos de la inspección'], 500);
        }
    }

    // Método para insertar el formulario de Acta de Inspección
    public function store(Request $request)
    {
        try {
            // Crear un nuevo registro en la tabla `actas_inspeccion`
            $acta = new actas_inspeccion();
            $acta->id_inspeccion = $request->id_inspeccion;
            $acta->id_empresa = $request->acta_id_empresa;
            $acta->num_acta = $request->num_acta;
            $acta->categoria_acta = $request->categoria_acta;
            $acta->testigos = $request->testigos;
            $acta->encargado = $request->encargado;
            $acta->num_credencial_encargado = $request->num_credencial_encargado;
            $acta->lugar_inspeccion = $request->lugar_inspeccion;
            $acta->fecha_inicio = $request->fecha_inicio;
            $acta->fecha_fin = $request->fecha_fin;
            $acta->no_conf_infraestructura = $request->no_conf_infraestructura;
            $acta->no_conf_equipo = $request->no_conf_equipo;

            // Guardar el registro en la base de datos
            $acta->save();

            // Guardar los testigos relacionados si existen
            if (isset($request->nombre_testigo) && is_array($request->nombre_testigo)) {
                for ($i = 0; $i < count($request->nombre_testigo); $i++) {
                    $testigo = new actas_testigo();
                    $testigo->id_acta = $acta->id_acta;  // Relacionar con la acta creada
                    $testigo->nombre_testigo = $request->nombre_testigo[$i];
                    $testigo->domicilio = $request->domicilio[$i];
                    $testigo->save();
                }
            }

            // Guardar las producciones relacionadas si existen
            if (isset($request->id_plantacion) && is_array($request->id_plantacion)) {
                for ($i = 0; $i < count($request->id_plantacion); $i++) {
                    $produccion = new actas_produccion();
                    $produccion->id_acta = $acta->id_acta;  // Relacionar con la acta creada
                    $produccion->id_plantacion = $request->id_plantacion[$i];
                    $produccion->plagas = $request->plagas[$i];
                    $produccion->save();
                }
            }

            // Guardar el equipo de mezcal relacionado si existe
            if (isset($request->equipo) && is_array($request->equipo)) {
                for ($i = 0; $i < count($request->equipo); $i++) {
                    $equiMezcal = new actas_equipo_mezcal();
                    $equiMezcal->id_acta = $acta->id_acta;  // Relacionar con la acta creada
                    $equiMezcal->equipo = !empty($request->equipo[$i]) ? $request->equipo[$i] : null;
                    $equiMezcal->cantidad = $request->cantidad[$i];
                    $equiMezcal->capacidad = $request->capacidad[$i];
                    $equiMezcal->tipo_material = $request->tipo_material[$i];
                    $equiMezcal->save();
                }
            }

            // Guardar el equipo de envasado relacionado si existe
            if (isset($request->equipo_envasado) && is_array($request->equipo_envasado)) {
                for ($i = 0; $i < count($request->equipo_envasado); $i++) {
                    $equiEnvasado = new actas_equipo_envasado();
                    $equiEnvasado->id_acta = $acta->id_acta;  // Relacionar con la acta creada
                    $equiEnvasado->equipo_envasado = !empty($request->equipo_envasado[$i]) ? $request->equipo_envasado[$i] : null;
                    $equiEnvasado->cantidad_envasado = $request->cantidad_envasado[$i];
                    $equiEnvasado->capacidad_envasado = $request->capacidad_envasado[$i];
                    $equiEnvasado->tipo_material_envasado = $request->tipo_material_envasado[$i];
                    $equiEnvasado->save();
                }
            }

            // Guardar las respuestas de las áreas de producción de mezcal si existen
            if (isset($request->respuesta) && is_array($request->respuesta)) {
                $area = ['Recepción (materia prima)', 'Área de pesado', 'Área de cocción', 'Área de maguey cocido', 'Área de molienda', 'Área de fermentación', 'Área de destilación', 'Almacén a graneles'];

                foreach ($request->respuesta as $rowIndex => $respuestasPorFila) {
                    foreach ($respuestasPorFila as $areaIndex => $respuesta) {
                        if (isset($area[$areaIndex])) {
                            $actaProduc = new acta_produccion_mezcal();
                            $actaProduc->id_acta = $acta->id_acta; // Relacionar con la acta creada
                            $actaProduc->area = $area[$areaIndex]; // Guardar el área correspondiente
                            $actaProduc->respuesta = !empty($respuesta) ? $respuesta : null; // Convertir vacío a null
                            $actaProduc->save();
                        }
                    }
                }
            }



            // Guardar las respuestas de las áreas de envasado si existen
            if (isset($request->respuestas) && is_array($request->respuestas)) {
                $areas = [
                    'Almacén de insumos',
                    'Almacén a gráneles',
                    'Sistema de filtrado',
                    'Área de envasado',
                    'Área de tiquetado',
                    'Almacén de producto terminado',
                    'Área de aseo personal'
                ];

                foreach ($request->respuestas as $rowIndex => $respuestasPorFilas) {
                    foreach ($respuestasPorFilas as $areaIndex => $respuestas) {
                        if (isset($areas[$areaIndex])) {
                            $actaUnidadEnvasado = new actas_unidad_envasado();
                            $actaUnidadEnvasado->id_acta = $acta->id_acta; // Relacionar con la acta creada
                            $actaUnidadEnvasado->areas = $areas[$areaIndex]; // Guardar el área correspondiente
                            $actaUnidadEnvasado->respuestas = !empty($respuestas) ? $respuestas : null; // Guardar la respuesta seleccionada (C, NC, NA)
                            $actaUnidadEnvasado->save();
                        }
                    }
                }
            }

            // Guardar las respuestas de comercialización si existen
            if (isset($request->respuestas_comercio) && is_array($request->respuestas_comercio)) {
                $comercializacion = [
                    'Bodega o almacén',
                    'Tarimas',
                    'Bitácoras',
                    'Otro:',
                    'Otro:'
                ];

                foreach ($request->respuestas_comercio as $rowIndex => $respuestasPorFilas2) {
                    foreach ($respuestasPorFilas2 as $areaIndex => $respuestas_comercio) {
                        if (isset($comercializacion[$areaIndex])) {
                            $actaUnidadComer = new actas_unidad_comercializacion();
                            $actaUnidadComer->id_acta = $acta->id_acta; // Relacionar con la acta creada
                            $actaUnidadComer->comercializacion = $comercializacion[$areaIndex]; // Guardar el área correspondiente
                            $actaUnidadComer->respuestas_comercio = !empty($respuestas_comercio) ? $respuestas_comercio : null; // Guardar la respuesta seleccionada (C, NC, NA)
                            $actaUnidadComer->save();
                        }
                    }
                }
            }

            return response()->json(['success' => 'Acta circunstanciada para Unidades de producción registrado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }




    //Metodo para llenar el pdf
    public function acta_circunstanciada_produccion($id_inspeccion)
    {


        $datos = inspecciones::with(
            'solicitud.empresa',
            'actas_inspeccion.actas_testigo',
            'inspector',
            'actas_inspeccion.acta_produccion_mezcal',
            'actas_inspeccion.actas_equipo_mezcal',
            'actas_inspeccion.actas_equipo_envasado',
            'actas_inspeccion.actas_unidad_comercializacion',
            'actas_inspeccion.actas_unidad_envasado',
            'actas_inspeccion.actas_produccion.predio_plantacion.predio.catalogo_tipo_agave',
            'empresa_num_cliente'
        )->find($id_inspeccion);
        $fecha_llenado = Helpers::formatearFecha($datos->actas_inspeccion->fecha_inicio);
        $hora_llenado = Helpers::extraerHora($datos->actas_inspeccion->fecha_inicio);
        $fecha_llenado_fin = Helpers::formatearFecha($datos->actas_inspeccion->fecha_fin);
        $hora_llenado_fin = Helpers::extraerHora($datos->actas_inspeccion->fecha_fin);
        $pdf = Pdf::loadView('pdfs.acta_circunstanciada_unidades_produccion', compact('datos', 'hora_llenado', 'fecha_llenado', 'fecha_llenado_fin', 'hora_llenado_fin'));
        return $pdf->stream('F-UV-02-02 ACTA CIRCUNSTANCIADA V6.pdf');
    }




    ///PDF ETIQUETAS - MUESTRAS DE AGAVE ART (Muestreo de agave ART (1))
    public function etiqueta_muestra($id_inspeccion)
    {
        $datos = inspecciones::where('id_solicitud', $id_inspeccion)->first();

        //edicion del formato
        if ($datos->solicitud->fecha_solicitud < '2025-08-07') {
            $edicion = 'pdfs.etiqueta_agave_art'; // ed16
        } else {
            $edicion = 'pdfs.etiqueta_agave_art_ed17';
        }
        $pdf = Pdf::loadView($edicion, ['datos' => $datos]);

        return $pdf->stream('Etiqueta para agave (%ART).pdf');
    }
    ///PDF ETIQUETAS - TAPA MUESTRAS DE LOTE DE MEZCAL A GRANEL (Muestreo de lote a granel (3))
    public function etiqueta($id_inspeccion)
    {
        $datos = inspecciones::where('id_solicitud', $id_inspeccion)->first();
        //descodificar el json
        /*$lotesOriginales = [];
            if (!empty($datos->solicitud->lote_granel->lote_original_id)) {
                $json = json_decode($datos->solicitud->lote_granel->lote_original_id, true);

                if (isset($json['lotes']) && is_array($json['lotes'])) {
                    $lotesOriginales = LotesGranel::whereIn('id_lote_granel', $json['lotes'])
                        ->pluck('nombre_lote')
                        ->toArray();
                }
            }*/
            $lotesOriginales = collect();
            if (!empty($datos->solicitud->lote_granel->lote_original_id)) {
                $json = json_decode($datos->solicitud->lote_granel->lote_original_id, true);

                if (isset($json['lotes']) && is_array($json['lotes'])) {
                    $lotesOriginales = LotesGranel::with('certificadoGranel')
                        ->whereIn('id_lote_granel', $json['lotes'])
                        ->get(['id_lote_granel', 'nombre_lote', 'folio_fq', 'folio_certificado']);
                }
            }

        if ($datos->solicitud->fecha_solicitud < '2025-08-07') {//edicion del formato
            $edicion = 'pdfs.etiquetas_tapas_sellado'; // ed16
        } else {
            $edicion = 'pdfs.etiquetas_tapas_sellado_ed17';
        }
        $pdf = Pdf::loadView($edicion,  [
            'datos' => $datos,
            'lotesOriginales' => $lotesOriginales,
            //'lotes_procedencia' => $lotesOriginales,
        ]);

        return $pdf->stream('Etiqueta para tapa de la muestra.pdf');
    }
    ///PDF ETIQUETAS - LOTES DE MEZCAL A GRANEL (Vigilancia en el traslado del lote (4))
    public function etiqueta_granel($id_inspeccion)
    {
        $datos = inspecciones::where('id_solicitud', $id_inspeccion)->first();

        $lotesOriginales = collect();
        if (!empty($datos->solicitud->lote_granel->lote_original_id)) {
            $json = json_decode($datos->solicitud->lote_granel->lote_original_id, true);

            if (isset($json['lotes']) && is_array($json['lotes'])) {
                $lotesOriginales = LotesGranel::with('certificadoGranel')
                    ->whereIn('id_lote_granel', $json['lotes'])
                    ->get(['id_lote_granel', 'nombre_lote', 'folio_fq', 'folio_certificado']);
            }
        }

        if ($datos->solicitud->fecha_solicitud < '2025-08-07') {//edicion del formato
            $edicion = 'pdfs.etiqueta_lotes_mezcal_granel'; // ed16
        } else {
            $edicion = 'pdfs.etiqueta_lotes_mezcal_granel_ed17';
        }
        $pdf = Pdf::loadView($edicion, [
            'datos' => $datos,
            'lotesOriginales' => $lotesOriginales,
        ]);

        return $pdf->stream('Etiqueta para lotes de mezcal a granel.pdf');
    }
    ///PDF ETIQUETAS - INGRESO A MADURACION (Inspección ingreso a barrica/ contenedor de vidrio (7))
    public function etiqueta_barrica($id_inspeccion)
    {
        $datos = inspecciones::where('id_solicitud', $id_inspeccion)->first();

        if ($datos->solicitud->fecha_solicitud < '2025-08-07') {//edicion del formato
            $edicion = 'pdfs.etiqueta_barrica'; // ed16
        } else {
            $edicion = 'pdfs.etiqueta_barrica_ed17';
        }
        $pdf = Pdf::loadView($edicion, ['datos' => $datos]);

        return $pdf->stream('Etiqueta para ingreso a barrica.pdf');
    }




    public function exportar(Request $request)
    {
        $filtros = $request->only(['id_empresa', 'anio', 'estatus', 'mes', 'id_soli', 'id_inspector_export']);
        // Pasar los filtros a la clase InspeccionesExport
         $fechaHora = now()->format('d-m-Y H-i');
         $nombreArchivo = "Reporte de Inspecciones {$fechaHora}.xlsx";
        return Excel::download(new InspeccionesExport($filtros), $nombreArchivo);
    }

//FUNCION ELIMINAR DOCUMENTOS 69 Y 70
public function eliminarActa($id_solicitud, $id_documento, $id)
{
    if (!in_array($id_documento, [69, 70])) {
        return response()->json(['message' => 'Documento no permitido.'], 400);
    }

    $documento = Documentacion_url::where('id_relacion', $id_solicitud)
        ->where('id_documento', $id_documento)
        ->where('id', $id)
        ->first();

    if (!$documento) {
        return response()->json(['message' => 'Documento no encontrado.'], 404);
    }

     // Buscar el número de cliente a través de la empresa
    $empresa = empresa::find($documento->id_empresa);
    $numeroCliente = $empresa?->empresaNumClientes()->pluck('numero_cliente')->first();

    if (!$numeroCliente) {
        return response()->json(['message' => 'No se pudo encontrar el número de cliente.'], 404);
    }

    // Eliminar archivo físico
    $ruta = "uploads/{$numeroCliente}/actas/{$documento->url}";
        if (Storage::disk('public')->exists($ruta)) {
            Storage::disk('public')->delete($ruta);
        } else {
            return response()->json(['message' => 'Archivo físico no encontrado en: ' .$ruta], 404);
        }

    // Eliminar de base de datos
    $documento->delete();

    return response()->json(['message' => 'Documento eliminado correctamente.']);
}










}
