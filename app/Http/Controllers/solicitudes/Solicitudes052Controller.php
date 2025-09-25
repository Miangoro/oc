<?php

namespace App\Http\Controllers\solicitudes;

use App\Http\Controllers\Controller;
use App\Models\categorias;
use App\Models\empresa;
use App\Models\estados;
use App\Models\instalaciones;
use App\Models\organismos;
use App\Models\LotesGranel;
use App\Models\lotes_envasado;
use App\Models\solicitudesModel;
use App\Models\clases;
use App\Models\solicitudTipo;
use App\Models\maquiladores_model;
use App\Models\User;
use App\Models\tipos;
use App\Models\marcas;
use App\Models\guias;
use App\Models\catalogo_aduanas;
use App\Models\solicitudes_eliminadas;
/// Extensiones / Librerías
use Carbon\Carbon;
use App\Helpers\Helpers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\GeneralNotification;//Notificaciones
// Laravel / Facades
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;//Manejo de autenticación
use Illuminate\Support\Facades\DB;


class Solicitudes052Controller extends Controller
{
    public function UserManagement()
    {
        $solicitudes = solicitudesModel::where('habilitado', 1)
            ->where('id_tipo', '!=', 12)
            ->get();
        $solicitudesTipos = solicitudTipo::all();
        $instalaciones = instalaciones::all(); // Obtener todas las instalaciones
        $estados = estados::all(); // Obtener todos los estados
        $tipo_usuario =  Auth::user()->tipo;
        $organismos = organismos::all(); // Obtener todos los estados
        $LotesGranel = lotesGranel::all();
        $categorias = categorias::all();
        $clases = clases::all();
        $tipos = tipos::all();
        $marcas = marcas::all();
        $aduanas = catalogo_aduanas::all();
        $inspectores = User::where('tipo', '=', '2')->get();

        // FILTRO DE EMPRESAS SEGÚN EL USUARIO
        if (Auth::check() && Auth::user()->tipo == 3) {
            $empresas = empresa::with('empresaNumClientes')
                ->where('tipo', 2)
                ->where('id_empresa', Auth::user()->empresa?->id_empresa)
                ->get();
        } else {
            $empresas = empresa::with('empresaNumClientes')
                ->where('tipo', 2)
                ->get();
        }


        return view('solicitudes.find_solicitudes_052', compact('tipo_usuario','instalaciones', 'empresas', 'estados', 'inspectores', 'solicitudesTipos', 'organismos', 'LotesGranel', 'categorias', 'clases', 'tipos', 'marcas', 'aduanas', 'solicitudes'));
    }


private function obtenerEmpresasVisibles($empresaId)
{
    $idsEmpresas = [];
    if ($empresaId) {
        $idsEmpresas[] = $empresaId; // Siempre incluye la empresa del usuario
        $idsEmpresas = array_merge(
            $idsEmpresas,
            maquiladores_model::where('id_maquiladora', $empresaId)
                ->pluck('id_maquilador')
                ->toArray()
        );
    }

    return array_unique($idsEmpresas);
}

public function index(Request $request)
{
    $userId = Auth::id();

    // Permisos de empresa e instalaciones
    $empresaId = null;
    $instalacionAuth = [];
    if (Auth::check() && Auth::user()->tipo == 3) {
        $empresaId = Auth::user()->empresa?->id_empresa;
        $instalacionAuth = (array) Auth::user()->id_instalacion;
        $instalacionAuth = array_filter(array_map('intval', $instalacionAuth), fn($id) => $id > 0);

        // Si no tiene instalaciones, no ve nada
        if (empty($instalacionAuth)) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'code' => 200,
                'data' => [],
                'message' => 'Asigna una instalación para poder ver solicitudes.',
            ]);
        }
    }


    // Configuración general
    DB::statement("SET lc_time_names = 'es_ES'"); // Forzar idioma español
    // Mapear columnas DataTables
    $columns = [
        1 => 'id_solicitud',
        2 => 'folio',
        3 => 'num_servicio',
        4 => 'razon_social',
        5 => 'created_at',
        6 => 'tipo',
        7 => 'direccion_completa',
        8 => 'fecha_visita',
        9 => 'inspector',
        10 => 'fecha_servicio',
        12 => 'estatus'
    ];

    $limit = $request->input('length');
    $start = $request->input('start');
    $orderColumnIndex = $request->input('order.0.column');
    $orderDirection = $request->input('order.0.dir') ?? 'desc';
    $orderColumn = $columns[$orderColumnIndex] ?? 'id_solicitud';
    $search = $request->input('search.value');

    ///CONSULTA QUERY BASE
    $query = solicitudesModel::with([
            'tipo_solicitud',
            'empresa',
            'instalacion',
            'inspeccion.inspector',
            'ultima_validacion_oc',
            'ultima_validacion_ui'
        ])->where('habilitado', 1)
        ->where('id_tipo', '!=', 12);

    // Filtro empresa (propia + maquiladores)  SE OCULTO PORQUE YA NO SERA POR MAQUILADOR
    if ($empresaId) {
        $empresasVisibles = $this->obtenerEmpresasVisibles($empresaId);
        //$query->whereIn('solicitudes.id_empresa', $empresasVisibles);
        $query->whereIn('id_empresa', $empresasVisibles);
    }
    /*// Filtro empresa (creadora o destino)
    if ($empresaId) {
        $query->where(function ($q) use ($empresaId) {
            $q->where('id_empresa', $empresaId)
              ->orWhere('id_empresa_destino', $empresaId);
        });
    }*/

    // Filtro por instalaciones (usuario tipo 3)
    /* if (!empty($instalacionAuth)) {
        $query->whereIn('solicitudes.id_instalacion', $instalacionAuth);
    } */
    if (!empty($instalacionAuth)) {
        $query->where(function($q) use ($instalacionAuth, $empresaId) {
            $q->whereIn('solicitudes.id_instalacion', $instalacionAuth) // instalaciones asignadas
            ->orWhere(function($sub) use ($empresaId) {
                $sub->where('solicitudes.id_instalacion', 0)//solo su propia georreferenciacion
                    ->where('solicitudes.id_empresa', $empresaId); // solo su empresa
            });
        });
    }
    
    $baseQuery = clone $query;// Clonamos el query antes de aplicar búsqueda, paginación u ordenamiento
    $totalData = $baseQuery->count();// totalData (sin búsqueda)


    // Búsqueda global
    if (!empty($search)) {

        // Preparar IDs de lotes envasado y granel según el search
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

        // Lotes envasado
        $loteEnvIds = DB::table('lotes_envasado')
            ->select('id_lote_envasado')
            ->where('nombre', 'LIKE', "%{$search}%")
            ->pluck('id_lote_envasado')
            ->toArray();

        // Lotes granel por tipo de agave
        $tipoAgaveIds = DB::table('catalogo_tipo_agave')
            ->where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('cientifico', 'LIKE', "%{$search}%")
            ->pluck('id_tipo')
            ->toArray();

        $loteGranelIds = DB::table('lotes_granel')
            ->where(function ($query) use ($search, $tipoAgaveIds) {
                $query->where('nombre_lote', 'LIKE', "%{$search}%")
                    ->orWhere('folio_fq', 'LIKE', "%{$search}%")
                    ->orWhere('cont_alc', 'LIKE', "%{$search}%")
                    ->orWhere('volumen', 'LIKE', "%{$search}%")
                    ->orWhere('volumen_restante', 'LIKE', "%{$search}%");
                foreach ($tipoAgaveIds as $idTipo) {
                    $query->orWhere('id_tipo', 'LIKE', '%"'.$idTipo.'"%');
                }
            })
            ->pluck('id_lote_granel')
            ->toArray();


        $query->where(function ($q) use ($search, $loteIds, $loteEnvIds, $loteGranelIds) {
            $q->where('solicitudes.id_solicitud', 'LIKE', "%{$search}%")
                ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
                ->orWhere('solicitudes.estatus', 'LIKE', "%{$search}%")
                ->orWhere('solicitudes.info_adicional', 'LIKE', "%{$search}%")
                ->orWhere('solicitudes.caracteristicas', 'LIKE', '%"no_pedido":"%' . $search . '%"%')
                ->orWhereHas('empresa', fn($q) => $q->where('razon_social', 'LIKE', "%{$search}%"))
                ->orWhereHas('tipo_solicitud', fn($q) => $q->where('tipo', 'LIKE', "%{$search}%"))
                ->orWhereHas('instalacion', fn($q) => $q->where('direccion_completa', 'LIKE', "%{$search}%"))
                ->orWhereHas('inspeccion', fn($q) => $q->where('num_servicio', 'LIKE', "%{$search}%"))
                ->orWhereHas('inspeccion.inspector', fn($q) => $q->where('name', 'LIKE', "%{$search}%"));

            foreach ($loteIds as $idLote) {//Buscar lote envasado -> granel
                $q->orWhere('solicitudes.caracteristicas', 'LIKE', '%"id_lote_envasado":' . $idLote . '%');
            }
            foreach ($loteEnvIds as $idLoteEnv) {//Buscar lote envasado
                $q->orWhere('solicitudes.caracteristicas', 'LIKE', '%"id_lote_envasado":"' . $idLoteEnv . '"%');
            }
            foreach ($loteGranelIds as $idLoteGran) {//Buscar lote granel
                $q->orWhere('solicitudes.caracteristicas', 'LIKE', '%"id_lote_granel":"' . $idLoteGran . '"%');
            }
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }

    
    // Ordenamiento
    if ($orderColumn === 'folio') {
        $query->orderByRaw("CAST(SUBSTRING(folio, 5) AS UNSIGNED) $orderDirection");
    } else {
        $query->orderBy($orderColumn, $orderDirection);
    }

    // Paginación
    $solicitudes = $query
        ->offset($start)
        ->limit($limit)
        ->get();



    //MANDA LOS DATOS AL JS
        $data = [];
        if (!empty($solicitudes)) {
            $ids = $start;
            $cajas = '';
            $botellas = '';
            $presentacion = '';
            foreach ($solicitudes as $solicitud) {
                $nestedData['id_solicitud'] = $solicitud->id_solicitud ?? 'N/A';
                $nestedData['fake_id'] = ++$ids ?? 'N/A';
                $nestedData['folio'] = $solicitud->folio;
                $nestedData['num_servicio'] = $solicitud->inspeccion->num_servicio ?? '<span class="badge bg-danger">Sin asignar</span>';
                $nestedData['razon_social'] = $solicitud->empresa->razon_social ?? 'N/A';
                $nestedData['fecha_solicitud'] = Helpers::formatearFechaHora($solicitud->fecha_solicitud) ?? 'N/A';
                $nestedData['tipo'] = $solicitud->tipo_solicitud->tipo ?? 'N/A';
                $nestedData['direccion_completa'] = $solicitud->instalacion->direccion_completa ?? $solicitud->predios->ubicacion_predio ?? 'N/A';
                $nestedData['fecha_visita'] = Helpers::formatearFechaHora($solicitud->fecha_visita) ?? '<span class="badge bg-danger">Sin asignar</span>';
                $nestedData['inspector'] = $solicitud->inspector->name ?? '<span class="badge bg-danger">Sin asignar</span>';
                $nestedData['foto_inspector'] = $solicitud->inspector->profile_photo_path ?? '';
                $nestedData['fecha_servicio'] = Helpers::formatearFecha(optional($solicitud->inspeccion)->fecha_servicio) ?? '<span class="badge bg-danger">Sin asignar</span>';
                $nestedData['fecha_inspeccion'] = $solicitud->inspeccion->fecha_servicio ?? '0';
                $nestedData['id_tipo'] = $solicitud->tipo_solicitud->id_tipo ?? 'N/A';
                $nestedData['estatus'] = $solicitud->estatus ?? 'Vacío';
                $nestedData['estatus_validado_oc'] = $solicitud->ultima_validacion_oc->estatus ?? 'Pendiente';
                $nestedData['estatus_validado_ui'] = $solicitud->ultima_validacion_ui->estatus ?? 'Pendiente';
                $nestedData['info_adicional'] = $solicitud->info_adicional ?? 'Vacío';
                $nestedData['folio_info'] = $solicitud->folio;
                $nestedData['num_servicio_info'] = $solicitud->inspeccion->num_servicio ?? 'Sin asignar';
                $nestedData['inspectorName'] = $solicitud->inspector->name ?? 'Sin inspector';

                $nestedData['id_inspeccion'] = $solicitud->inspeccion->id_inspeccion ?? 'Sin inspeccion';
                $nestedData['estatus_activado'] = $solicitud->estatus_activado;
                $urls = $solicitud->documentacion(69)->pluck('url')->toArray();
                // Comprobamos si $urls está vacío
                if (empty($urls)) {
                    // Si está vacío, asignamos la etiqueta de "Sin subir"
                    $nestedData['url_acta'] = 'Sin subir';
                } else {
                    // Si hay URLs, las unimos en una cadena separada por comas
                    $nestedData['url_acta'] = implode(', ', $urls);
                }

                $empresa = $solicitud->empresa;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                    ? $empresa->empresaNumClientes
                    ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
                    : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;

                // Decodificar JSON y extraer datos específicos
                $caracteristicas = json_decode($solicitud->caracteristicas, true);
                $idLoteGranel = $caracteristicas['id_lote_granel'] ?? null;
                $loteGranel = LotesGranel::find($idLoteGranel); // Busca el lote a granel

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


                $idLoguiass = $caracteristicas['id_guia'] ?? null;
                $guias = [];
                if (!empty($idLoguiass)) {
                    // Busca las guías relacionadas
                    $guias = guias::whereIn('id_guia', $idLoguiass)->pluck('folio')->toArray();
                }

                // Devuelve las guías como una cadena separada por comas
                $nestedData['guias'] = !empty($guias) ? implode(', ', $guias) : 'N/A';


                $nestedData['nombre_lote'] = $loteGranel ? $loteGranel->nombre_lote : 'N/A';
                $nestedData['id_lote_envasado'] = $loteEnvasado ? $loteEnvasado->nombre : 'N/A';
                $primerLote = $loteEnvasado?->lotesGranel->first();
                $nestedData['lote_granel'] = $primerLote ? $primerLote->nombre_lote : 'N/A';
                $nestedData['nombre_predio'] = $caracteristicas['nombre_predio'] ?? 'N/A';
                $nestedData['art'] = $caracteristicas['art'] ?? 'N/A';
                $nestedData['analisis'] = $caracteristicas['analisis'] ?? 'N/A';
                $nestedData['folio_caracteristicas'] = $caracteristicas['folio'] ?? 'N/A';
                $nestedData['combinado'] = ($caracteristicas['tipo_solicitud'] ?? null) == 2
    ? '<span class="badge rounded-pill bg-info"><b>Combinado</b></span>'
    : '';

                $nestedData['etapa'] = $caracteristicas['etapa'] ?? 'N/A';
                $nestedData['fecha_corte'] = isset($caracteristicas['fecha_corte']) ? Carbon::parse($caracteristicas['fecha_corte'])->format('d/m/Y H:i') : 'N/A';
                $nestedData['marca'] = $marca ?? 'N/A';
                $nestedData['cajas'] = $cajas ?? 'N/A';
                $nestedData['botellas'] = $botellas ?? 'N/A';
                $idTipoMagueyMuestreo = $caracteristicas['id_tipo_maguey'] ?? null;
                $nestedData['presentacion'] = $presentacion ?? 'N/A';

                if ($idTipoMagueyMuestreo) {
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
                }

                // Asumiendo que los IDs siempre están presentes (pero con verificación de claves faltantes)
                $nestedData['id_categoria'] = isset($caracteristicas['id_categoria']) ? categorias::find($caracteristicas['id_categoria'])->categoria : 'N/A';
                $nestedData['id_clase'] = isset($caracteristicas['id_clase']) ? clases::find($caracteristicas['id_clase'])->clase : 'N/A';
                $nestedData['cont_alc'] = $caracteristicas['cont_alc'] ?? 'N/A';
                $nestedData['id_certificado_muestreo'] = $caracteristicas['id_certificado_muestreo'] ?? 'N/A';
                $nestedData['no_pedido'] = $caracteristicas['no_pedido'] ?? 'N/A';
                $nestedData['pais'] = $solicitud->direccion_destino->pais_destino ?? 'No encontrado';
                $nestedData['id_categoria_traslado'] = $caracteristicas['id_categoria_traslado'] ?? 'N/A';
                $nestedData['id_clase_traslado'] = $caracteristicas['id_clase_traslado'] ?? 'N/A';
                $nestedData['id_tipo_maguey_traslado'] = $caracteristicas['id_tipo_maguey_traslado'] ?? 'N/A';
                $nestedData['id_vol_actual'] = $caracteristicas['id_vol_actual'] ?? 'N/A';
                $nestedData['id_vol_res'] = $caracteristicas['id_vol_res'] ?? 'N/A';
                $nestedData['analisis_traslado'] = $caracteristicas['analisis_traslado'] ?? 'N/A';
                $nestedData['id_categoria_inspeccion'] = $caracteristicas['id_categoria_inspeccion'] ?? 'N/A';
                $nestedData['id_clase_inspeccion'] = $caracteristicas['id_clase_inspeccion'] ?? 'N/A';
                $nestedData['id_tipo_maguey_inspeccion'] = $caracteristicas['id_tipo_maguey_inspeccion'] ?? 'N/A';
                $nestedData['id_marca'] = $caracteristicas['id_marca'] ?? 'N/A';
                $nestedData['volumen_inspeccion'] = $caracteristicas['volumen_inspeccion'] ?? 'N/A';
                $nestedData['analisis_inspeccion'] = $caracteristicas['analisis_inspeccion'] ?? 'N/A';
                $nestedData['id_categoria_barricada'] = $caracteristicas['id_categoria'] ?? 'N/A';
                $nestedData['id_clase_barricada'] = $caracteristicas['id_clase'] ?? 'N/A';
                $nestedData['id_tipo_maguey_barricada'] = $caracteristicas['id_tipo_maguey'] ?? 'N/A';
                $nestedData['analisis_barricada'] = $caracteristicas['analisis'] ?? 'N/A';
                $nestedData['tipo_lote'] = $caracteristicas['tipoIngreso'] ?? 'N/A';
                $nestedData['fecha_inicio'] = isset($caracteristicas['fecha_inicio']) ? Carbon::parse($caracteristicas['fecha_inicio'])->format('d/m/Y') : 'N/A';
                $nestedData['fecha_termino'] = isset($caracteristicas['fecha_termino']) ? Carbon::parse($caracteristicas['fecha_termino'])->format('d/m/Y') : 'N/A';
                $nestedData['tipo_lote_lib'] = $caracteristicas['tipoLiberacion'] ?? 'N/A';
                $nestedData['punto_reunion'] = $caracteristicas['punto_reunion'] ?? 'N/A';
                $nestedData['renovacion'] = $caracteristicas['renovacion'] ?? 'N/A';
                $nestedData['volumen_ingresado'] = $caracteristicas['volumen_ingresado'] ?? 'N/A';
                $nestedData['certificado_exportacion'] = $solicitud->certificadoExportacion()?->num_certificado ?? '';


                $data[] = $nestedData;
            }
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            //'recordsTotal' => intval($totalData),
            'recordsTotal' => $empresaId ? intval($totalFiltered) : intval($totalData),//total oculto a clientes
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data ?? [],
            'message' => empty($data) ? 'No tienes solicitudes asignadas.' : null,
        ]);
        
}








}//end-Controller