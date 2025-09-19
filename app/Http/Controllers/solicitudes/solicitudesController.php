<?php

namespace App\Http\Controllers\solicitudes;

use App\Helpers\Helpers;
use Carbon\Carbon;

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
use App\Models\Documentacion_url;
use App\Models\Documentos;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\tipos;
use App\Models\marcas;
use App\Models\guias;
use App\Models\Destinos;
use App\Models\BitacoraMezcal;
use App\Models\catalogo_aduanas;
use App\Models\solicitudes_eliminadas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
//clase de exportacion
use App\Exports\SolicitudesExport;
use App\Models\etiquetas;
use App\Models\solicitudesValidacionesModel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;//Permisos de empresa
use Illuminate\Support\Facades\DB;

use App\Models\maquiladores_model;

class solicitudesController extends Controller
{
    public function UserManagement()
    {
        $solicitudes = solicitudesModel::where('habilitado', 1)
            ->where('id_tipo', '!=', 12)
            ->get();
        $solicitudesTipos = solicitudTipo::all();
        $instalaciones = instalaciones::all(); // Obtener todas las instalaciones
        $estados = estados::all(); // Obtener todos los estados
       // $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get();// Obtener solo las empresas tipo '2'

       // FILTRO DE EMPRESAS SEGÚN EL USUARIO
        //if (auth()->user()->tipo == 3) {
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

        $tipo_usuario =  Auth::user()->tipo;

        $organismos = organismos::all(); // Obtener todos los estados
        $LotesGranel = lotesGranel::all();
        $categorias = categorias::all();
        $clases = clases::all();
        $tipos = tipos::all();
        $marcas = marcas::all();
        $aduanas = catalogo_aduanas::all();

        $inspectores = User::where('tipo', '=', '2')->get(); // Obtener todos los organismos
        return view('solicitudes.find_solicitudes_view', compact('tipo_usuario','instalaciones', 'empresas', 'estados', 'inspectores', 'solicitudesTipos', 'organismos', 'LotesGranel', 'categorias', 'clases', 'tipos', 'marcas', 'aduanas', 'solicitudes'));
    }
    public function findCertificadosExportacion()
    {
        $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get();
        return view('certificados.find_certificados_exportacion', compact('empresas'));
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
    /*if (!empty($instalacionAuth)) {
        $query->where(function($q) use ($instalacionAuth) {
            $q->whereIn('solicitudes.id_instalacion', $instalacionAuth)
            ->orWhere('solicitudes.id_instalacion', 0);
        });
    }*/
    if (!empty($instalacionAuth)) {
        $query->where(function($q) use ($instalacionAuth, $empresaId) {
            $q->whereIn('solicitudes.id_instalacion', $instalacionAuth) // instalaciones asignadas
            ->orWhere(function($sub) use ($empresaId) {
                $sub->where('solicitudes.id_instalacion', 0)//solo su propia georreferenciacion
                    ->where('solicitudes.id_empresa', $empresaId); // solo su empresa
            });
        });
    }
    
    // Filtro especial para usuario 49
    if ($userId == 49) {
        $query->where('solicitudes.id_tipo', 11);
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

    // Paginación + relaciones
    /*$solicitudes = $query
        ->with([
            'tipo_solicitud',
            'empresa',
            'instalacion',
            'inspeccion.inspector',
            'ultima_validacion_oc',
            'ultima_validacion_ui'
        ])
        ->offset($start)
        ->limit($limit)
        ->get();*/
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
            //'message' => 'No tienes solicitudes asignadas.',
            'message' => empty($data) ? 'No tienes solicitudes asignadas.' : null,
        ]);
        
}



///REGISTRAR SOLICITUDES
public function storeVigilanciaProduccion(Request $request)
{
      $validated = $request->validate([
          'id_empresa' => 'required|integer',
          'fecha_solicitud' => 'nullable|date',
          'fecha_visita' => 'required|date',
          'id_instalacion' => 'required|integer',
          'nombre_produccion' => 'required|string|max:255',
          'etapa_proceso' => 'nullable|string|max:255',
          'cantidad_pinas' => 'nullable|integer|min:1',
          'info_adicional' => 'nullable|string',
          'documento_guias.*' => 'nullable|file|max:10240' // 10 MB por archivo
      ]);

      DB::beginTransaction();

      try {
          // Obtener número de cliente
          $empresa = empresa::with("empresaNumClientes")
              ->where("id_empresa", $validated['id_empresa'])
              ->first();

          $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
              return !empty($numero);
          });

          if (!$numeroCliente) {
              return response()->json(['message' => 'No se encontró un número de cliente válido'], 422);
          }

          $VigilanciaProdu = new solicitudesModel();
          $VigilanciaProdu->folio = Helpers::generarFolioSolicitud();
          $VigilanciaProdu->id_empresa = $validated['id_empresa'];
          $VigilanciaProdu->id_tipo = 2;
          $VigilanciaProdu->id_predio = 0;
          $VigilanciaProdu->fecha_solicitud = $validated['fecha_solicitud'];
          $VigilanciaProdu->fecha_visita = $validated['fecha_visita'];
          $VigilanciaProdu->id_instalacion = $validated['id_instalacion'];
          $VigilanciaProdu->info_adicional = $validated['info_adicional'] ?? null;

          $VigilanciaProdu->caracteristicas = json_encode([
              'nombre_produccion' => $validated['nombre_produccion'],
              'etapa_proceso' => $validated['etapa_proceso'],
              'cantidad_pinas' => $validated['cantidad_pinas'],
          ]);

          $VigilanciaProdu->save();

          // Guardar archivos si hay
          $carpetaDestino = "uploads/{$numeroCliente}";

          if (!Storage::disk('public')->exists($carpetaDestino)) {
              Storage::disk('public')->makeDirectory($carpetaDestino);
          }

          if ($request->hasFile('documento_guias')) {
              foreach ($request->file('documento_guias') as $file) {
                  if (!$file->isValid()) {
                      throw new \Exception("Uno de los archivos no se pudo cargar correctamente.");
                  }

                    $extension = $file->getClientOriginalExtension();
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $originalNameSlug = Str::slug($originalName); // Limpia y convierte a formato tipo "factura-12345"
                    $uniq = uniqid();
                    $nombreArchivo = "Guía de agave {$originalNameSlug}_{$uniq}.{$extension}";

                    $ruta = $file->storeAs($carpetaDestino, $nombreArchivo, 'public');

                    if (!$ruta) {
                        throw new \Exception("No se pudo guardar el archivo en el servidor.");
                    }

                  DB::table('documentacion_url')->insert([
                      'id_documento' => 71,
                      'nombre_documento' => 'Guía de traslado de agave',
                      'id_empresa' => $VigilanciaProdu->id_empresa,
                      'id_relacion' => $VigilanciaProdu->id_solicitud,
                      'url' => $nombreArchivo,
                      'created_at' => now(),
                      'updated_at' => now(),
                  ]);
              }
          }

          ///Notificacion 
        $user =  Auth::user(); // el usuario que hace la solicitud
        $contacto = Auth::user()->contacto;

        $data1 = [
            'title' => 'Nueva solicitud',
            'message' => $VigilanciaProdu->folio . " " . $VigilanciaProdu->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        if ($contacto) {
                $contacto->notify(new GeneralNotification($data1));
        }else{
                $users = User::whereIn('id', [4, 3, 7, 320,319])->get(); 
                foreach ($users as $user) {
                $user->notify(new GeneralNotification($data1));
            }
        }
      

          DB::commit();

          return response()->json(['message' => 'Vigilancia en producción de lote registrada exitosamente']);

      } catch (\Throwable $e) {
          DB::rollBack();

        return response()->json(['message' =>  $e->getMessage()], 500);
      }
}


public function storeEmisionCertificadoVentaNacional(Request $request)
{
        $emisionCertificado = new solicitudesModel();
        $emisionCertificado->folio = Helpers::generarFolioSolicitud();
        $emisionCertificado->id_empresa = $request->id_empresa;
        $emisionCertificado->id_tipo = 13;
        $emisionCertificado->id_predio = 0;
        $emisionCertificado->fecha_solicitud = $request->fecha_solicitud;
        $emisionCertificado->fecha_visita = $request->fecha_visita;
        $emisionCertificado->id_instalacion = $request->id_instalacion;
        $emisionCertificado->info_adicional = $request->info_adicional;

        $emisionCertificado->caracteristicas = json_encode([
            'id_dictamen_envasado' => $request->id_dictamen_envasado,
            'id_lote_envasado' => $request->id_lote_envasado,
            'cantidad_cajas' => $request->cantidad_cajas,
            'cantidad_botellas' => $request->cantidad_botellas,
            'cont_alc' => $request->cont_alc,
        ]);

        $emisionCertificado->save();

        ///Notificacion 
        $user =  Auth::user(); // el usuario que hace la solicitud
        $contacto = Auth::user()->contacto;

          $data1 = [
              'title' => 'Nueva solicitud',
              'message' => $emisionCertificado->folio . " " . $emisionCertificado->tipo_solicitud->tipo,
              'url' => 'solicitudes-historial',
          ];

            if ($contacto) {
                    $contacto->notify(new GeneralNotification($data1));
            }else{
                    $users = User::whereIn('id', [4, 3, 7, 320,319])->get(); 
                    foreach ($users as $user) {
                    $user->notify(new GeneralNotification($data1));
                }
            }
        
    return response()->json(['message' => 'Emision de certificado venta nacional registrada exitosamente']);
}


public function storeMuestreoLote(Request $request)
{
        $MuestreoLote = new solicitudesModel();
        $MuestreoLote->folio = Helpers::generarFolioSolicitud();
        $MuestreoLote->id_empresa = $request->id_empresa;
        $MuestreoLote->id_tipo = 3;
        $MuestreoLote->id_predio = 0;
        $MuestreoLote->fecha_solicitud = $request->fecha_solicitud;
        $MuestreoLote->fecha_visita = $request->fecha_visita;
        $MuestreoLote->id_instalacion = $request->id_instalacion;
        $MuestreoLote->info_adicional = $request->info_adicional;

        $idTipoMaguey = $request->id_tipo_maguey_muestreo;

        // Verifica que es un array
        if (!is_array($idTipoMaguey)) {
            $idTipoMaguey = [];
        }

        $MuestreoLote->caracteristicas = json_encode([
            'id_lote_granel' => $request->id_lote_granel_muestreo,
            'tipo_analisis' => $request->destino_lote,
            'id_categoria' => $request->id_categoria_muestreo,
            'id_clase' => $request->id_clase_muestreo,
            'id_tipo_maguey' => $idTipoMaguey,
            'analisis' => $request->analisis_muestreo,
            'cont_alc' => $request->volumen_muestreo,
            'id_certificado_muestreo' => $request->id_certificado_muestreo,

        ]);

        $MuestreoLote->save();

        ///Notificacion 
        $user =  Auth::user(); // el usuario que hace la solicitud
        $contacto = Auth::user()->contacto;

        $data1 = [
            'title' => 'Nueva solicitud',
            'message' => $MuestreoLote->folio . " " . $MuestreoLote->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        if ($contacto) {
                $contacto->notify(new GeneralNotification($data1));
        }else{
                $users = User::whereIn('id', [4, 3, 7, 320,319])->get(); 
                foreach ($users as $user) {
                $user->notify(new GeneralNotification($data1));
            }
        }

    return response()->json(['message' => 'Solcitud de Muestreo registrado exitosamente']);
}


public function storeVigilanciaTraslado(Request $request)
{
        $VigilanciaTras = new solicitudesModel();
        $VigilanciaTras->folio = Helpers::generarFolioSolicitud();
        $VigilanciaTras->id_empresa = $request->id_empresa;
        $VigilanciaTras->id_tipo = 4;
        $VigilanciaTras->id_predio = 0;
        $VigilanciaTras->fecha_solicitud = $request->fecha_solicitud;
        $VigilanciaTras->fecha_visita = $request->fecha_visita;
        $VigilanciaTras->id_instalacion = $request->id_instalacion;
        $VigilanciaTras->info_adicional = $request->info_adicional;

        $VigilanciaTras->caracteristicas = json_encode([
            'instalacion_vigilancia' => $request->instalacion_vigilancia,
            'id_lote_granel' => $request->id_lote_granel_traslado,
            'id_categoria_traslado' => $request->id_categoria_traslado,
            'id_clase_traslado' => $request->id_clase_traslado,
            'id_tipo_maguey_traslado' => $request->id_tipo_maguey_traslado,
            'id_salida' => $request->id_salida,
            'id_contenedor' => $request->id_contenedor,
            'id_sobrante' => $request->id_sobrante,
            'id_vol_actual' => $request->id_vol_actual,
            'id_vol_traslado' => $request->id_vol_traslado,
            'id_vol_res' => $request->id_vol_res,
            'analisis_traslado' => $request->analisis_traslado,
            'volumen_traslado' => $request->volumen_traslado,
            'id_certificado_traslado' => $request->id_certificado_traslado,
        ]);

        $VigilanciaTras->save();

        // Crear nuevo registro en la Bitácora de Mezcal
      /*  $bitacora = new BitacoraMezcal();
        $bitacora->fecha = now(); // o $request->fecha_visita si aplica
        $bitacora->id_tanque = $request->id_contenedor;
        $bitacora->lote_a_granel = $request->id_lote_granel_traslado;
        // inicial
        $bitacora->volumen_inicial = $request->id_vol_actual ?? 0;
        $bitacora->alcohol_inicial = $request->volumen_traslado ?? 0;

        // Entrada
        $bitacora->procedencia_entrada = 0;
        $bitacora->volumen_entrada = $request->volumen_entrada ?? 0;
        $bitacora->alcohol_entrada = $request->volumen_traslado ?? 0;
        $bitacora->agua_entrada = 0;

        // Salida
        $bitacora->volumen_salidas = $request->id_vol_traslado ?? 0;
        $bitacora->alcohol_salidas = $request->volumen_traslado ?? 0;
        $bitacora->destino_salidas = $request->instalacion_vigilancia;

        // Inventario Final
        $bitacora->volumen_final = $request->id_vol_res ?? 0;
        $bitacora->alcohol_final = $request->volumen_traslado ?? 0;

        // Otros campos opcionales
        $bitacora->categoria = $request->id_categoria_traslado ?? null;
        $bitacora->clase = $request->id_clase_traslado ?? null;

        // ✅ Esta es la línea que debes cambiar:
        $bitacora->tipo_agave = is_array($request->id_tipo_maguey_traslado)
            ? implode(', ', $request->id_tipo_maguey_traslado)
            : $request->id_tipo_maguey_traslado;

        $bitacora->num_analisis = $request->analisis_traslado ?? null;
        $bitacora->num_certificado = $request->id_certificado_traslado ?? null;
        $bitacora->observaciones = "Registro automático desde vigilancia en traslado.";

        $bitacora->save();*/


        ///Notificacion 
       
        $user =  Auth::user(); // el usuario que hace la solicitud
        $contacto = Auth::user()->contacto;

          $data1 = [
              'title' => 'Nueva solicitud',
              'message' => $VigilanciaTras->folio . " " . $VigilanciaTras->tipo_solicitud->tipo,
              'url' => 'solicitudes-historial',
          ];

            if ($contacto) {
                    $contacto->notify(new GeneralNotification($data1));
            }else{
                    $users = User::whereIn('id', [4, 3, 7, 320,319])->get(); 
                    foreach ($users as $user) {
                    $user->notify(new GeneralNotification($data1));
                }
            }

    return response()->json(['message' => 'Vigilancia en traslado de lote registrada exitosamente']);
}


public function storeInspeccionEnvasado(Request $request)
{
        $InspeccionEnva = new solicitudesModel();
        $InspeccionEnva->folio = Helpers::generarFolioSolicitud();
        $InspeccionEnva->id_empresa = $request->id_empresa;
        $InspeccionEnva->id_tipo = 5;
        $InspeccionEnva->id_predio = 0;
        $InspeccionEnva->fecha_solicitud = $request->fecha_solicitud;
        $InspeccionEnva->fecha_visita = $request->fecha_visita;
        $InspeccionEnva->id_instalacion = $request->id_instalacion;
        $InspeccionEnva->info_adicional = $request->info_adicional;

        $InspeccionEnva->caracteristicas = json_encode([
            'id_lote_envasado' => $request->id_lote_envasado_inspeccion,
            'cantidad_caja' => $request->id_cantidad_caja,
            'fecha_inicio' => $request->id_inicio_envasado,
            'fecha_fin' => $request->id_previsto,
        ]);

        $InspeccionEnva->save();

      

        // Notificación 1
        $user =  Auth::user(); // el usuario que hace la solicitud
        $contacto = Auth::user()->contacto;

          $data1 = [
              'title' => 'Nueva solicitud',
              'message' => $InspeccionEnva->folio . " " . $InspeccionEnva->tipo_solicitud->tipo,
              'url' => 'solicitudes-historial',
          ];

            if ($contacto) {
                    $contacto->notify(new GeneralNotification($data1));
            }else{
                    $users = User::whereIn('id', [4, 3, 7, 320,319])->get(); 
                    foreach ($users as $user) {
                    $user->notify(new GeneralNotification($data1));
                }
            }

    return response()->json(['message' => 'Inpeccion de envasado de lote registrada exitosamente']);
}


public function storeInspeccionBarricada(Request $request)
{
        $InspeccionBarri = new solicitudesModel();
        $InspeccionBarri->folio = Helpers::generarFolioSolicitud();
        $InspeccionBarri->id_empresa = $request->id_empresa;
        $InspeccionBarri->id_tipo = 7;
        $InspeccionBarri->id_predio = 0;
        $InspeccionBarri->fecha_solicitud = $request->fecha_solicitud;
        $InspeccionBarri->fecha_visita = $request->fecha_visita;
        $InspeccionBarri->id_instalacion = $request->id_instalacion;
        $InspeccionBarri->info_adicional = $request->info_adicional;

        $InspeccionBarri->caracteristicas = json_encode([
            'id_lote_granel' => $request->id_lote_granel_barricada,
            'id_categoria' => $request->id_categoria_barricada,
            'id_clase' => $request->id_clase_barricada,
            'id_tipo_maguey' => $request->id_tipo_maguey_barricada,
            'edad' => $request->id_edad,
            'analisis' => $request->analisis_barricada,
            'cont_alc' => $request->alc_vol_barrica,
            'tipoIngreso' => $request->tipo_lote,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_termino' => $request->fecha_termino,
            'material' => $request->material,
            'capacidad' => $request->capacidad,
            'num_recipientes' => $request->num_recipientes,
            'tiempo_maduracion' => $request->tiempo_maduracion,
            'id_certificado' => $request->id_certificado_barricada,
            'volumen_ingresado' => $request->volumen_ingresado,
        ]);

        $InspeccionBarri->save();


        // Notificación 1
       $user =  Auth::user(); // el usuario que hace la solicitud
        $contacto = Auth::user()->contacto;

          $data1 = [
              'title' => 'Nueva solicitud',
              'message' => $InspeccionBarri->folio . " " . $InspeccionBarri->tipo_solicitud->tipo,
              'url' => 'solicitudes-historial',
          ];

            if ($contacto) {
                    $contacto->notify(new GeneralNotification($data1));
            }else{
                    $users = User::whereIn('id', [4, 3, 7, 320,319])->get(); 
                    foreach ($users as $user) {
                    $user->notify(new GeneralNotification($data1));
                }
            }

    return response()->json(['message' => 'Inspeccion ingreso a barrica de lote registrada exitosamente']);
}


public function storeInspeccionBarricadaLiberacion(Request $request)
{
        $BarricadaLib = new solicitudesModel();
        $BarricadaLib->folio = Helpers::generarFolioSolicitud();
        $BarricadaLib->id_empresa = $request->id_empresa;
        $BarricadaLib->id_tipo = 9;
        $BarricadaLib->id_predio = 0;
        $BarricadaLib->fecha_solicitud = $request->fecha_solicitud;
        $BarricadaLib->fecha_visita = $request->fecha_visita;
        $BarricadaLib->id_instalacion = $request->id_instalacion;
        $BarricadaLib->info_adicional = $request->info_adicional;

        $BarricadaLib->caracteristicas = json_encode([
            'id_lote_granel' => $request->id_lote_granel_liberacion,
            'id_categoria' => $request->id_categoria_liberacion,
            'id_clase' => $request->id_clase_liberacion,
            'id_tipo_maguey' => $request->id_tipo_maguey_liberacion,
            'edad' => $request->id_edad_liberacion,
            'analisis' => $request->analisis_liberacion,
            'cont_alc' => $request->volumen_liberacion,
            'tipoLiberacion' => $request->tipo_lote_lib,
            'fecha_inicio' => $request->fecha_inicio_lib,
            'fecha_termino' => $request->fecha_termino_lib,
            'material' => $request->material_liberacion,
            'capacidad' => $request->capacidad_liberacion,
            'num_recipientes' => $request->num_recipientes_lib,
            'tiempo_dura' => $request->tiempo_dura_lib,
            'id_certificado' => $request->id_certificado_liberacion,
        ]);

        $BarricadaLib->save();

        //Notificacion
        $user =  Auth::user(); // el usuario que hace la solicitud
        $contacto = Auth::user()->contacto;

          $data1 = [
              'title' => 'Nueva solicitud',
              'message' => $BarricadaLib->folio . " " . $BarricadaLib->tipo_solicitud->tipo,
              'url' => 'solicitudes-historial',
          ];

            if ($contacto) {
                    $contacto->notify(new GeneralNotification($data1));
            }else{
                    $users = User::whereIn('id', [4, 3, 7, 320,319])->get(); 
                    foreach ($users as $user) {
                    $user->notify(new GeneralNotification($data1));
                }
            }

    return response()->json(['message' => 'Inspeccion liberacion a barrica de lote registrada exitosamente']);
}


public function registrarSolicitudGeoreferenciacion(Request $request)
{
        $solicitud = new solicitudesModel();
        $solicitud->folio = Helpers::generarFolioSolicitud();
        $solicitud->id_empresa = $request->id_empresa;
        $solicitud->id_tipo = 10;
        $solicitud->fecha_solicitud = $request->fecha_solicitud;
        $solicitud->fecha_visita = $request->fecha_visita;
        $solicitud->id_instalacion = $request->id_instalacion ? $request->id_instalacion : 0;
        $solicitud->id_predio = $request->id_predio;
        $solicitud->info_adicional = $request->info_adicional;
        /*
        //Manejo de empresa_destino de la solicitud
        if ($request->filled('id_empresa_destino')) {
            // Si viene en el request, se guarda (maquilador con destino)
            $solicitud->id_empresa_destino = $request->id_empresa_destino;
        } else {
            // No maquilador → no aplica
            $solicitud->id_empresa_destino = null;
        }
        */

        // Preparar el JSON para la columna `caracteristicas`
        $caracteristicas = [
            'punto_reunion' => $request->punto_reunion,
        ];

        // Convertir a JSON y asignarlo
        $solicitud->caracteristicas = json_encode($caracteristicas);

        $solicitud->save();

        ///Notificacion 
       
        $user =  Auth::user(); // el usuario que hace la solicitud
        $contacto = Auth::user()->contacto;

          $data1 = [
              'title' => 'Nueva solicitud',
              'message' => $solicitud->folio . " " . $solicitud->tipo_solicitud->tipo,
              'url' => 'solicitudes-historial',
          ];

            if ($contacto) {
                    $contacto->notify(new GeneralNotification($data1));
            }else{
                    $users = User::whereIn('id', [4, 3, 7, 320,319])->get(); 
                    foreach ($users as $user) {
                    $user->notify(new GeneralNotification($data1));
                }
            }

    return response()->json(['success' => 'Solicitud registrada correctamente']);
}


public function registrarSolicitudMuestreoAgave(Request $request)
{
        $solicitud = new solicitudesModel();
        $solicitud->folio = Helpers::generarFolioSolicitud();
        $solicitud->id_empresa = $request->id_empresa;
        $solicitud->id_tipo = 1;
        $solicitud->fecha_solicitud = $request->fecha_solicitud;
        $solicitud->fecha_visita = $request->fecha_visita;
        $solicitud->id_instalacion = $request->id_instalacion ? $request->id_instalacion : 0;
        $solicitud->info_adicional = $request->info_adicional;
        // Preparar el JSON para la columna `caracteristicas`

        if (!empty($request->id_guia)) {
            $caracteristicas = [
                'id_guia' => $request->id_guia,
            ];
            // Convertir a JSON y asignarlo
            $solicitud->caracteristicas = json_encode($caracteristicas);
        } else {
            $solicitud->caracteristicas = json_encode([
                'mensaje' => 'sin caracteristicas'
            ]);
        }

        $solicitud->save();


        ///Notificacion 
        $user =  Auth::user(); // el usuario que hace la solicitud
        $contacto = Auth::user()->contacto;

        $data1 = [
            'title' => 'Nueva solicitud',
            'message' => $solicitud->folio . " " . $solicitud->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        if ($contacto) {
                $contacto->notify(new GeneralNotification($data1));
        }else{
                $users = User::whereIn('id', [4, 3, 7, 320,319])->get(); 
                foreach ($users as $user) {
                $user->notify(new GeneralNotification($data1));
            }
        }

    return response()->json(['success' => 'Solicitud registrada correctamente']);
}


public function store(Request $request)
{
        $solicitud = new solicitudesModel();
        $solicitud->folio = Helpers::generarFolioSolicitud();
        $solicitud->id_empresa = $request->id_empresa;
        $solicitud->id_tipo = 14;
        $solicitud->fecha_solicitud = $request->fecha_solicitud;
        $solicitud->fecha_visita = $request->fecha_visita;
        //Auth::user()->id;
        $solicitud->id_instalacion = $request->id_instalacion;
        $solicitud->info_adicional = $request->info_adicional;
        // Guardar el nuevo registro en la base de datos

        // Verificar si los campos tienen valores
        $clases = $request->input('clases', []);
        $categorias = $request->input('categorias', []);
        $renovacion = $request->input('renovacion', null);

        if (!empty($clases) || !empty($categorias) || $renovacion !== null) {
            $caracteristicas = [
                'clases' => $clases,
                'categorias' => $categorias,
                'renovacion' => $renovacion,
            ];
            // Convertir el array a JSON y guardarlo en la columna 'caracteristicas'
            $solicitud->caracteristicas = json_encode($caracteristicas);
        }

        $solicitud->save();

        ///Notificacion 
        $user =  Auth::user(); // el usuario que hace la solicitud
        $contacto = Auth::user()->contacto;

        $data1 = [
            'title' => 'Nueva solicitud',
            'message' => $solicitud->folio . " " . $solicitud->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        if ($contacto) {
                $contacto->notify(new GeneralNotification($data1));
        }else{
                $users = User::whereIn('id', [4, 3, 7, 320,319])->get(); 
                foreach ($users as $user) {
                $user->notify(new GeneralNotification($data1));
            }
        }

        // Retornar una respuesta JSON indicando éxito
    return response()->json(['success' => 'Solicitud registrada correctamente']);
}



///PDF SOLICITUD DE SERVICIOS
public function pdf_solicitud_servicios_070($id_solicitud)
{
        $datos = solicitudesModel::find($id_solicitud);

        // Inicializa las variables con un valor vacío
        $muestreo_agave = '------------';
        $vigilancia_produccion = '------------';
        $muestreo_granel = '------------';
        $vigilancia_traslado = '------------';
        $inspeccion_envasado = '------------';
        $muestreo_envasado = '------------';
        $ingreso_barrica = '------------';
        $liberacion = '------------';
        $liberacion_barrica = '------------';
        $geo = '------------';
        $exportacion = '------------';
        $certificado_granel = '------------';
        $certificado_nacional = '------------';
        $dictaminacion = '------------';
        $renovacion_dictaminacion = '------------';
        $productor = '----';
        $envasador = '----';
        $comercializador = '----';

        $caracteristicas = json_decode($datos->caracteristicas);


        // Verificar el valor de id_tipo y marcar la opción correspondiente
        if ($datos->id_tipo == 1) {
            $muestreo_agave = 'X';
        }

        if ($datos->id_tipo == 2) {
            $vigilancia_produccion = 'X';
        }

        if ($datos->id_tipo == 3) {
            $muestreo_granel = 'X';
        }

        if ($datos->id_tipo == 4) {
            $vigilancia_traslado = 'X';
        }

        if ($datos->id_tipo == 5) {
            $inspeccion_envasado = 'X';
        }

        if ($datos->id_tipo == 6) {
            $muestreo_envasado = 'X';
        }

        if ($datos->id_tipo == 7) {
            $ingreso_barrica = 'X';
        }

        if ($datos->id_tipo == 8) {
            $liberacion = 'X';
        }

        if ($datos->id_tipo == 9) {
            $liberacion_barrica = 'X';
        }

        if ($datos->id_tipo == 10) {
            $geo = 'X';
        }

        if ($datos->id_tipo == 11) {
            $exportacion = 'X';
        }

        if ($datos->id_tipo == 12) {
            $certificado_granel = 'X';
        }

        if ($datos->id_tipo == 13) {
            $certificado_nacional = 'X';
        }


        if ($datos->id_tipo == 14) {
            $dictaminacion = 'X';
            if (isset($caracteristicas->renovacion) && $caracteristicas->renovacion == "si") {
                $renovacion_dictaminacion = 'X';
                $dictaminacion = '';
            }

            $tipos = is_string($datos->instalacion->tipo)
                ? json_decode($datos->instalacion->tipo, true)
                : $datos->instalacion->tipo;

            // Verificar si es un arreglo válido
            if (is_array($tipos)) {
                if (in_array('Productora', $tipos)) {
                    $productor = 'X';
                }
                if (in_array('Envasadora', $tipos)) {
                    $envasador = 'X';
                }
                if (in_array('Comercializadora', $tipos)) {
                    $comercializador = 'X';
                }
            }
        }


        $fecha_visita = Helpers::formatearFechaHora($datos->fecha_visita);

        $pdf = Pdf::loadView('pdfs.SolicitudDeServicio', compact(
            'datos',
            'muestreo_agave',
            'vigilancia_produccion',
            'dictaminacion',
            'muestreo_granel',
            'vigilancia_traslado',
            'inspeccion_envasado',
            'muestreo_envasado',
            'ingreso_barrica',
            'liberacion',
            'liberacion_barrica',
            'geo',
            'exportacion',
            'certificado_granel',
            'certificado_nacional',
            'dictaminacion',
            'renovacion_dictaminacion',
            'fecha_visita',
            'productor',
            'envasador',
            'comercializador'
        ))->setPaper([0, 0, 640, 910]);;

    return $pdf->stream('Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32 Ed10 VIGENTE.pdf');
}



    public function verificarSolicitud(Request $request)
    {
        $id_predios = $request->input('id_predios');

        // Verifica si existe una solicitud asociada al id_predio
        $exists = solicitudesModel::where('id_predio', $id_predios)
            ->pluck('id_predio')->toArray();;

        return response()->json(['hasSolicitud' => $exists]);
    }



///OBTENER SOLICITUDES
public function obtenerDatosSolicitud($id_solicitud)
{
        // Buscar los datos necesarios en la tabla "solicitudes"
        $solicitud = solicitudesModel::find($id_solicitud);

        if (!$solicitud) {
            return response()->json([
                'success' => false,
                'message' => 'Solicitud no encontrada.',
            ], 404);
        }
        // Obtener solo la factura proforma
        $facturaProforma = $solicitud->documentacion(55)->first();

        // Obtener todos los documentos
        $documentos = $solicitud->documentacion_completa;
        // Obtener instalaciones relacionadas con la empresa de la solicitud
        $instalaciones = Instalaciones::where('id_empresa', $solicitud->id_empresa)->get();
        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $solicitud->id_empresa)->first();
        $numero_cliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });
        // Obtener las características decodificadas (si existen)
        $caracteristicas = $solicitud->caracteristicas
            ? json_decode($solicitud->caracteristicas, true)
            : null;

        // Verificar si hay características para procesar
        if ($caracteristicas) {
            $categoria = isset($caracteristicas['id_categoria'])
                ? categorias::find($caracteristicas['id_categoria'])
                : null;
            $marcas = isset($caracteristicas['id_marca'])
                ? marcas::find($caracteristicas['id_marca'])
                : null;
            $clase = isset($caracteristicas['id_clase'])
                ? clases::find($caracteristicas['id_clase'])
                : null;
            $tipoMagueyIds = isset($caracteristicas['id_tipo_maguey'][0])
                ? explode(',', $caracteristicas['id_tipo_maguey'][0])
                : [];
            $tiposMaguey = tipos::whereIn('id_tipo', $tipoMagueyIds)->get();
            $tipoMagueyConcatenados = $tiposMaguey->map(function ($tipo) {
                return $tipo->nombre . ' (' . $tipo->cientifico . ')';
            })->toArray();
            $caracteristicas['categoria'] = $categoria->categoria ?? 'N/A';
            $caracteristicas['clase'] = $clase->clase ?? 'N/A';
            $caracteristicas['marca'] = $marcas->marca ?? 'N/A';
            $caracteristicas['nombre'] = $tipoMagueyConcatenados;
        }


        return response()->json([
            'success' => true,
            'data' => $solicitud,
            'caracteristicas' => $caracteristicas,
            'instalaciones' => $instalaciones,
            'factura_proforma' => $facturaProforma,
            'documentos' => $documentos,
            'numero_cliente' => $numero_cliente,

            //'id_empresa_destino' => $solicitud->id_empresa_destino,
        ]);
}
///ACTUALIZAR SOLICITUDES
public function actualizarSolicitudes(Request $request, $id_solicitud)
{
        // Encuentra la solicitud por ID
        $solicitud = solicitudesModel::find($id_solicitud);

        if (!$solicitud) {
            return response()->json(['success' => false, 'message' => 'Solicitud no encontrada'], 404);
        }

        // Verifica el tipo de formulario
        $formType = $request->input('form_type');

        switch ($formType) {
            case 'vigilanciaenproduccion':
                // Validar solo los campos que sí estás enviando
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_solicitud' => 'nullable|date',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'nombre_produccion' => 'required|string|max:255',
                    'etapa_proceso' => 'nullable|string|max:255',
                    'cantidad_pinas' => 'nullable|integer|min:1',
                    'info_adicional' => 'nullable|string',
                    'documento_guias.*' => 'nullable|file|max:10240', // 10MB por archivo
                ]);

                // Actualizar la solicitud con solo los datos actuales
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_solicitud' => $request->fecha_solicitud,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => json_encode([
                        'nombre_produccion' => $request->nombre_produccion,
                        'etapa_proceso' => $request->etapa_proceso,
                        'cantidad_pinas' => $request->cantidad_pinas,
                    ]),
                ]);

                if ($request->hasFile('documento_guias')) {
                    // 1. Obtener el número de cliente
                    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->id_empresa)->first();
                    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                        return !empty($numero);
                    });

                    if (!$numeroCliente) {
                        return response()->json(['message' => 'No se encontró un número de cliente válido'], 422);
                    }

                    // 2. Eliminar archivos anteriores del disco y registros de la base
                    $documentosAnteriores = DB::table('documentacion_url')
                        ->where('id_relacion', $solicitud->id_solicitud)
                        ->where('id_documento', 71)
                        ->get();

                    foreach ($documentosAnteriores as $doc) {
                        Storage::disk('public')->delete("uploads/{$numeroCliente}/{$doc->url}");
                    }

                    DB::table('documentacion_url')
                        ->where('id_relacion', $solicitud->id_solicitud)
                        ->where('id_documento', 71)
                        ->delete();

                    // 3. Guardar nuevos archivos
                    $carpetaDestino = "uploads/{$numeroCliente}";

                    if (!Storage::disk('public')->exists($carpetaDestino)) {
                        Storage::disk('public')->makeDirectory($carpetaDestino);
                    }

                    foreach ($request->file('documento_guias') as $file) {
                        $extension = $file->getClientOriginalExtension();
                        $nombreOriginal = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $nombreSeguro = preg_replace('/[^A-Za-z0-9_\-]/', '-', $nombreOriginal); // sanitiza el nombre
                        $nombreArchivo = "Guía de traslado de agave {$nombreSeguro}_" . uniqid() . '.' . $extension;

                        $ruta = $file->storeAs($carpetaDestino, $nombreArchivo, 'public');

                        DB::table('documentacion_url')->insert([
                            'id_documento' => 71,
                            'nombre_documento' => 'Guía de traslado de agave',
                            'id_empresa' => $solicitud->id_empresa,
                            'id_relacion' => $solicitud->id_solicitud,
                            'url' => $nombreArchivo,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                  }


                break;

            case 'muestreoloteagranel':
                // Validar datos 
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_solicitud' => 'nullable|date',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string'
                ]);
                // Preparar el JSON para guardar en `caracteristicas`
                $caracteristicasJson = [
                    'id_lote_granel' => $request->id_lote_granel_muestreo,
                    'tipo_analisis' => $request->tipo_analisis,
                    'id_categoria' => $request->id_categoria_muestreo,
                    'id_clase' => $request->id_clase_muestreo,
                    'id_tipo_maguey' => $request->id_tipo_maguey_muestreo,
                    'analisis' => $request->analisis_muestreo,
                    'cont_alc' => $request->volumen_muestreo,
                    'id_certificado_muestreo' => $request->id_certificado_muestreo,
                ];

                // Convertir el array a JSON
                $jsonContent = json_encode($caracteristicasJson);

                // Actualizar datos específicos
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_solicitud' => $request->fecha_solicitud,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);

                break;

            case 'vigilanciatraslado':
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_solicitud' => 'nullable|date',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string'
                ]);
                $caracteristicasJson = [
                    'instalacion_vigilancia' => $request->instalacion_vigilancia,
                    'id_lote_granel' => $request->id_lote_granel_traslado,
                    'id_categoria_traslado' => $request->id_categoria_traslado,
                    'id_clase_traslado' => $request->id_clase_traslado,
                    'id_tipo_maguey_traslado' => $request->id_tipo_maguey_traslado,
                    'id_salida' => $request->id_salida,
                    'id_contenedor' => $request->id_contenedor,
                    'id_sobrante' => $request->id_sobrante,
                    'id_vol_actual' => $request->id_vol_actual,
                    'id_vol_traslado' => $request->id_vol_traslado,
                    'id_vol_res' => $request->id_vol_res,
                    'analisis_traslado' => $request->analisis_traslado,
                    'volumen_traslado' => $request->volumen_traslado,
                    'id_certificado_traslado' => $request->id_certificado_traslado,

                ];
                $jsonContent = json_encode($caracteristicasJson);
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_solicitud' => $request->fecha_solicitud,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);
                break;

            case 'LiberacionProductoTerminado':
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_solicitud' => 'nullable|date',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string'
                ]);

                $caracteristicasJson = [
                    'id_lote_envasado' => $request->id_lote_envasado,
                    'cantidad_botellas' => $request->cantidad_botellas,
                    'presentacion' => $request->presentacion,
                    'cantidad_pallets' => $request->cantidad_pallets,
                    'cajas_por_pallet' => $request->cajas_por_pallet,
                    'botellas_por_caja' => $request->botellas_por_caja,
                    'hologramas_utilizados' => $request->hologramas_utilizados,
                    'hologramas_mermas' => $request->hologramas_mermas,
                ];
                $jsonContent = json_encode($caracteristicasJson);
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_solicitud' => $request->fecha_solicitud,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);
                break;

            case 'inspeccionenvasado':
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_solicitud' => 'nullable|date',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string'
                ]);
                $caracteristicasJson = [
                    'id_lote_envasado' => $request->edit_id_lote_envasado_inspeccion,
                    'cantidad_caja' => $request->id_cantidad_caja,
                    'fecha_inicio' => $request->id_inicio_envasado,
                    'fecha_fin' => $request->id_previsto,

                ];
                $jsonContent = json_encode($caracteristicasJson);
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_solicitud' => $request->fecha_solicitud,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);
                break;

            case 'muestreobarricada':
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_solicitud' => 'nullable|date',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string'
                ]);
                $caracteristicasJson = [
                    'id_lote_granel' => $request->id_lote_granel_barricada,
                    'id_categoria' => $request->id_categoria_barricada,
                    'id_clase' => $request->id_clase_barricada,
                    'id_tipo_maguey' => $request->id_tipo_maguey_barricada,
                    'id_edad' => $request->id_edad,
                    'analisis' => $request->analisis_barricada,
                    'cont_alc' => $request->alc_vol_barrica,
                    'tipoIngreso' => $request->tipo_lote,
                    'fecha_inicio' => $request->fecha_inicio,
                    'fecha_termino' => $request->fecha_termino,
                    'material' => $request->material,
                    'capacidad' => $request->capacidad,
                    'num_recipientes' => $request->num_recipientes,
                    'tiempo_maduracion' => $request->tiempo_maduracion,
                    'id_certificado' => $request->id_certificado_barricada,
                    'volumen_ingresado' => $request->volumen_ingresado,


                ];
                $jsonContent = json_encode($caracteristicasJson);
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_solicitud' => $request->fecha_solicitud,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);
                break;

            case 'muestreobarricadaliberacion':
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_solicitud' => 'nullable|date',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string'
                ]);
                $caracteristicasJson = [
                    'id_lote_granel' => $request->id_lote_granel_liberacion,
                    'id_categoria' => $request->id_categoria_liberacion,
                    'id_clase' => $request->id_clase_liberacion,
                    'id_tipo_maguey' => $request->id_tipo_maguey_liberacion,
                    'id_edad' => $request->id_edad_liberacion,
                    'analisis' => $request->analisis_liberacion,
                    'cont_alc' => $request->volumen_liberacion,
                    'tipoLiberacion' => $request->tipo_lote_lib,
                    'fecha_inicio' => $request->fecha_inicio_lib,
                    'fecha_termino' => $request->fecha_termino_lib,
                    'material' => $request->material_liberacion,
                    'capacidad' => $request->capacidad_liberacion,
                    'num_recipientes' => $request->num_recipientes_lib,
                    'tiempo_dura' => $request->tiempo_dura_lib,
                    'id_certificado' => $request->id_certificado_liberacion,
                ];
                $jsonContent = json_encode($caracteristicasJson);
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_solicitud' => $request->fecha_solicitud,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);
                break;


            case 'georreferenciacion': ///OBTENER SOLICITUD GEORREFERENCIACION
                // Validar datos para georreferenciación
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_solicitud' => 'nullable|date',
                    'fecha_visita' => 'required|date',
                    'id_predio' => 'required|integer|exists:predios,id_predio',
                    'punto_reunion' => 'required|string|max:255',
                    'info_adicional' => 'nullable|string'
                ]);
                // Preparar el JSON para guardar en `caracteristicas`
                $caracteristicasJson = [
                    'punto_reunion' => $request->punto_reunion,
                ];

                // Convertir el array a JSON
                $jsonContent = json_encode($caracteristicasJson);

                // Actualizar datos específicos para georreferenciación
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_solicitud' => $request->fecha_solicitud,
                    'fecha_visita' => $request->fecha_visita,
                    'id_predio' => $request->id_predio,
                    'punto_reunion' => $request->punto_reunion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                    //'id_empresa_destino' => $request->id_empresa_destino,
                ]);

                break;


            case 'dictaminacion':
                // Validar datos para dictaminación
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_solicitud' => 'nullable|date',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string|max:5000',
                ]);
                // Preparar el JSON para guardar en `caracteristicas`
                $caracteristicasJson = [
                    'clases' => $request->clases,
                    'categorias' => $request->categorias,
                    'renovacion' => $request->renovacion,
                ];

                // Convertir el array a JSON
                $jsonContent = json_encode($caracteristicasJson);
                // Actualizar datos específicos para dictaminación
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_solicitud' => $request->fecha_solicitud,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);
                break;

            case 'muestreoagave':
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_solicitud' => 'nullable|date',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string',
                    'id_guia' => 'nullable|array', // Validación para un arreglo
                    'id_guia.*' => 'integer|exists:guias,id_guia', // Validación para cada elemento del arreglo
                ]);

                // Preparar el JSON para guardar en `caracteristicas`
                $caracteristicas = !empty($request->id_guia)
                    ? ['id_guia' => $request->id_guia] // Guardar como arreglo si hay guías
                    : ['mensaje' => 'sin caracteristicas']; // Guardar mensaje si no hay guías

                // Actualizar los datos de la solicitud
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_solicitud' => $request->fecha_solicitud,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => json_encode($caracteristicas), // Convertir a JSON
                ]);
                break;

            case 'pedidosExportacion':
             /* dd($request->all()); */
                // Validación de datos del formulario
                $validated = $request->validate([
                    'id_empresa' => 'required|integer',
                    'fecha_solicitud' => 'nullable|date',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer',
                    'id_nstalaciones_envasado_2_edit' => 'required|integer',
                    'direccion_destinatario' => 'required|integer',
                    'aduana_salida' => 'required|string|max:255',
                    'no_pedido' => 'required|string|max:255',
                    'info_adicional' => 'nullable|string|max:5000',
                    'factura_proforma' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                    'factura_proforma_cont' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                    /*  */
                    'lote_envasado' => 'required|array',  // Asegurarse de que los lotes sean arrays
                    'cantidad_botellas' => 'required|array',  // Asegurarse de que las cantidades sean arrays
                    'cantidad_cajas' => 'required|array',  // Asegurarse de que las cantidades sean arrays
                    'presentacion' => 'required|array',  // Asegurarse de que las presentaciones sean arrays
                    'id_etiqueta' => 'required|integer',
                    'lote_envasado.*.id_lote_envasado' => 'required|integer',

                    'lote_envasado.*.cont_alc' => [
                        'required',            // Ya no nullable si siempre se guarda
                        'numeric',
                        'between:0,99.99',
                        'regex:/^\d{1,2}(\.\d{1,2})?$/',
                    ],

                    'lotes_granel' => 'nullable|array',
                    'lotes_granel.*.id_lote_granel' => 'required|integer|exists:lotes_granel,id_lote_granel',
                    'lotes_granel.*.folio_fq' => 'nullable|string',
                ]);

                // Procesar características
                $data = json_decode($request->input('caracteristicas'), true);

                // Incluir los demás campos dentro del JSON de 'caracteristicas'
                $data['tipo_solicitud'] = $validated['tipo_solicitud'] ?? $data['tipo_solicitud'];  // Solo si es enviado
                $data['no_pedido'] = $validated['no_pedido'];  // Solo si es enviado
                $data['aduana_salida'] = $validated['aduana_salida'];  // Solo si es enviado
                $data['direccion_destinatario'] = $validated['direccion_destinatario'];  // Solo si es enviado
                $data['id_etiqueta'] = $validated['id_etiqueta'];  // Solo si es enviado
                $data['id_instalacion_envasado'] = $validated['id_nstalaciones_envasado_2_edit'];  // Solo si es enviado
                // Preparar los detalles


                  $detalles = [];

                  foreach ($validated['lote_envasado'] as $i => $lote) {
                    /* dd($i, $lote); */
                      $idLote = $lote['id_lote_envasado'] ?? null;
                      if (!$idLote) continue;

                      if ($i === 0) {
                          $detalles[] = [
                              'id_lote_envasado' => (int) $idLote,
                              'cantidad_botellas' => (int) ($validated['cantidad_botellas'][0] ?? 0),
                              'cantidad_cajas' => (int) ($validated['cantidad_cajas'][0] ?? 0),
                              'presentacion' => [ $validated['presentacion'][0] ?? '' ],
                          ];
                      } else {
                          $detalles[] = [
                              'id_lote_envasado' => (int) $idLote,
                          ];
                      }

                      // Actualizar contenido alcohólico
                      if (!is_null($lote['cont_alc'] ?? null)) {
                          lotes_envasado::where('id_lote_envasado', $idLote)
                              ->update(['cont_alc_envasado' => $lote['cont_alc']]);
                      }
                  }

                  $data['detalles'] = $detalles;



                // Obtener el número del cliente desde la tabla empresa_num_cliente
                $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $validated['id_empresa'])->first();
                $empresaNumCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                    return !empty($numero);
                });


                // Guardar la solicitud
                $solicitud->id_empresa = $validated['id_empresa'];
                $solicitud->fecha_solicitud = $validated['fecha_solicitud'];
                $solicitud->fecha_visita = $validated['fecha_visita'];
                $solicitud->id_instalacion = $validated['id_instalacion'];
                $solicitud->info_adicional = $validated['info_adicional'];
                $solicitud->caracteristicas = json_encode($data);  // Guardar el JSON completo con las características (incluyendo facturas)
                $solicitud->save();

                  // Actualizar lotes a granel si los hay
                  if ($request->has('lotes_granel')) {
                      foreach ($request->input('lotes_granel') as $granel) {
                          if (!empty($granel['id_lote_granel'])) {LotesGranel::where('id_lote_granel', $granel['id_lote_granel'])
                                  ->update([
                                      'folio_fq' => $granel['folio_fq'] ?? null,

                                  ]);
                          }
                      }
                  }

                // Almacenar archivos si se enviaron
                    if ($request->hasFile('factura_proforma')) {
                        // Elimina el anterior
                        Documentacion_url::where('id_relacion', $solicitud->id_solicitud)
                            ->where('id_documento', 55)
                            ->where('nombre_documento', 'Factura Proforma')
                            ->delete();

                        $file = $request->file('factura_proforma');
                        $uniqueId = uniqid();
                        $filename = 'FacturaProforma_' . $uniqueId . '.' . $file->getClientOriginalExtension();
                        $directory = $empresaNumCliente;
                        $path = storage_path('app/public/uploads/' . $directory);

                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }

                        $filePath = $file->storeAs($directory, $filename, 'public_uploads');
                        Documentacion_url::create([
                            'id_empresa' => $validated['id_empresa'],
                            'url' => basename($filePath),
                            'id_relacion' => $solicitud->id_solicitud,
                            'id_documento' => 55, // ID de factura
                            'nombre_documento' => 'Factura Proforma',
                        ]);
                        $data['factura_proforma'] = $filename;
                    }

                    if ($request->hasFile('factura_proforma_cont')) {
                        // Elimina el anterior
                        Documentacion_url::where('id_relacion', $solicitud->id_solicitud)
                            ->where('id_documento', 55)
                            ->where('nombre_documento', 'Factura Proforma (Continuación)')
                            ->delete();

                        $file = $request->file('factura_proforma_cont');
                        $uniqueId = uniqid();
                        $filename = 'FacturaProformaCont_' . $uniqueId . '.' . $file->getClientOriginalExtension();
                        $directory = $empresaNumCliente;
                        $path = storage_path('app/public/uploads/' . $directory);

                        if (!file_exists($path)) {
                            mkdir($path, 0777, true);
                        }

                        $filePath = $file->storeAs($directory, $filename, 'public_uploads');
                        Documentacion_url::create([
                            'id_empresa' => $validated['id_empresa'],
                            'url' => basename($filePath),
                            'id_relacion' => $solicitud->id_solicitud,
                            'id_documento' => 55, // ID de factura
                            'nombre_documento' => 'Factura Proforma (Continuación)',
                        ]);
                        $data['factura_proforma_cont'] = $filename;
                    }

                $solicitud->caracteristicas = json_encode($data); // Ahora incluye las rutas de los archivos
                $solicitud->save();
                break;
                /* emision certificado venta nacional */
            case 'emisionCertificadoVentaNacional':
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_solicitud' => 'nullable|date',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'nullable|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string'
                ]);
                $caracteristicasJson = [
                  'id_dictamen_envasado' => $request->id_dictamen_envasado,
                  'id_lote_envasado' => $request->id_lote_envasado,
                  'cantidad_cajas' => $request->cantidad_cajas,
                  'cantidad_botellas' => $request->cantidad_botellas,
                  'cont_alc' => $request->cont_alc,
                ];
                $jsonContent = json_encode($caracteristicasJson);
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_solicitud' => $request->fecha_solicitud,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);
                break;
                /* fin de los case */


            default:
                return response()->json(['success' => false, 'message' => 'Tipo de solicitud no reconocido'], 400);
        }

    return response()->json(['success' => true, 'message' => 'Solicitud actualizada correctamente']);
}



    public function obtenerMarcasPorEmpresa($id_marca, $id_direccion)
    {

                $etiquetas = etiquetas::with([
                'marca.empresa.empresaNumClientes',
                'destinos' => function ($query) use ($id_direccion) {
                    $query->where('direcciones.id_direccion', $id_direccion);
                },
                'url_etiqueta',
                'url_corrugado',
                'tipo',
                'clase',
                'categoria'
            ])
            ->where('id_marca', $id_marca)
            ->whereHas('destinos', function ($query) use ($id_direccion) {
                $query->where('direcciones.id_direccion', $id_direccion);
            })
            ->get();

            foreach ($etiquetas as $etiqueta) {
                $tipoIds = [];
                if (!empty($etiqueta->id_tipo)) {
                    $tipoIds = json_decode($etiqueta->id_tipo, true);
                }
                $tipos = [];
                if (!empty($tipoIds)) {
                    $tipos = \App\Models\tipos::whereIn('id_tipo', $tipoIds)
                        ->get(['nombre', 'cientifico'])
                        ->toArray();
                }
                $etiqueta->tipos_info = $tipos; // <-- ahora es un array de objetos
            }

        // Retornar las marcas como respuesta JSON
        return response()->json($etiquetas);
    }

    public function obtenerMarcasPorEmpresaAntiguo($id_marca, $id_direccion)
    {

        $marcas = marcas::with('empresa.empresaNumClientes', 'documentacion_url')->whereJsonContains('etiquetado->id_direccion', $id_direccion)
            ->where('id_marca', $id_marca)
            ->get();

        foreach ($marcas as $marca) {
            // Decodificar el campo 'etiquetado'
            $etiquetado = is_string($marca->etiquetado) ? json_decode($marca->etiquetado, true) : $marca->etiquetado;

            // Si el campo etiquetado no es válido o no puede ser decodificado
            if (is_null($etiquetado) || !is_array($etiquetado)) {
                $marca->tipo_nombre = [];
                $marca->clase_nombre = [];
                $marca->categoria_nombre = [];
                $marca->direccion_nombre = [];
                $marca->etiquetado = [];
                continue;
            }

            // Verificar la existencia de claves antes de procesar las relaciones
            $tipos = isset($etiquetado['id_tipo']) ? tipos::whereIn('id_tipo', $etiquetado['id_tipo'])->pluck('nombre')->toArray() : [];
            $clases = isset($etiquetado['id_clase']) ? clases::whereIn('id_clase', $etiquetado['id_clase'])->pluck('clase')->toArray() : [];
            $categorias = isset($etiquetado['id_categoria']) ? categorias::whereIn('id_categoria', $etiquetado['id_categoria'])->pluck('categoria')->toArray() : [];

            // Procesar direcciones individualmente
            $direcciones = [];
            if (isset($etiquetado['id_direccion']) && is_array($etiquetado['id_direccion'])) {
                foreach ($etiquetado['id_direccion'] as $id_direccion) {
                    $direccion = Destinos::where('id_direccion', $id_direccion)->value('direccion');
                    $direcciones[] = $direccion ?? 'N/A'; // Si no se encuentra, asignar 'N/A'
                }
            }

            // Agregar los datos procesados al resultado
            $marca->tipo_nombre = $tipos;
            $marca->clase_nombre = $clases;
            $marca->categoria_nombre = $categorias;
            $marca->direccion_nombre = $direcciones;
            $marca->etiquetado = $etiquetado; // Incluye el JSON decodificado para referencia
        }

        // Retornar las marcas como respuesta JSON
        return response()->json($marcas);
    }




public function storePedidoExportacion(Request $request)
{
      /* dd($request->all()); */
        // Validación de datos del formulario
        $validated = $request->validate([
            'id_empresa' => 'required|integer',
            'fecha_solicitud' => 'nullable|date',
            'fecha_visita' => 'required|date',
            'id_instalacion' => 'required|integer',
            'id_instalacion_envasado_2' => 'required|integer',
            'direccion_destinatario' => 'required|integer',
            'aduana_salida' => 'required|string|max:255',
            'no_pedido' => 'required|string|max:255',
            'info_adicional' => 'nullable|string|max:5000',
            'factura_proforma' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'factura_proforma_cont' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            /*  */
            'lote_envasado' => 'required|array',
            'lote_envasado.*.id_lote_envasado' => 'required|integer',
            'lote_envasado.*.cont_alc' => [
                'required',            // Ya no nullable si siempre se guarda
                'numeric',
                'between:0,99.99',
                'regex:/^\d{1,2}(\.\d{1,2})?$/',
            ],
            'cantidad_botellas' => 'required|array|min:1',
            'cantidad_botellas.*' => 'required|integer|min:1',

            'cantidad_cajas' => 'required|array|min:1',
            'cantidad_cajas.*' => 'required|integer|min:1',

            'presentacion' => 'required|array|min:1',
            'presentacion.*' => 'required|string|',

            'id_etiqueta' => 'required|integer',
            'lotes_granel' => 'nullable|array',
            'lotes_granel.*.id_lote_granel' => 'required|integer|exists:lotes_granel,id_lote_granel',
            'lotes_granel.*.folio_fq' => 'nullable|string',
        ]);

        // Procesar características
        $data = json_decode($request->input('caracteristicas'), true);

        // Incluir los demás campos dentro del JSON de 'caracteristicas'
        $data['tipo_solicitud'] = $validated['tipo_solicitud'] ?? $data['tipo_solicitud'];  // Solo si es enviado
        $data['no_pedido'] = $validated['no_pedido'];  // Solo si es enviado
        $data['aduana_salida'] = $validated['aduana_salida'];  // Solo si es enviado
        $data['direccion_destinatario'] = $validated['direccion_destinatario'];  // Solo si es enviado
        $data['id_etiqueta'] = $validated['id_etiqueta'];  // Solo si es enviado
        $data['id_instalacion_envasado'] = $validated['id_instalacion_envasado_2'];  // Solo si es enviado
        /* $data['cont_alc'] = $validated['cont_alc']; */

        // Preparar los detalles
/*             $detalles = [];
            $totalLotes = count($validated['lote_envasado']);

          foreach ($validated['lote_envasado'] as $index => $idLoteEnvasado) {
                $detalle = [
                    'id_lote_envasado' => (int) $idLoteEnvasado,
                ];

                if (isset($validated['cantidad_botellas'][$index])) {
                    $detalle['cantidad_botellas'] = (int) $validated['cantidad_botellas'][$index];
                }

                if (isset($validated['cantidad_cajas'][$index])) {
                    $detalle['cantidad_cajas'] = (int) $validated['cantidad_cajas'][$index];
                }

                if (isset($validated['presentacion'][$index])) {
                    $detalle['presentacion'] = [$validated['presentacion'][$index]];
                }

                $detalles[] = $detalle;
            }
        $data['detalles'] = $detalles;
 */
          $detalles = [];

          foreach ($validated['lote_envasado'] as $index => $lote) {
              $idLoteEnvasado = $lote['id_lote_envasado'] ?? null;
              $contenidoAlc = $lote['cont_alc'] ?? null;

              if (!$idLoteEnvasado) {
                  continue;
              }

              if ($index === 0) {
                  $detalle = [
                      'id_lote_envasado' => (int) $idLoteEnvasado,
                      'cantidad_botellas' => (int) ($validated['cantidad_botellas'][$index] ?? 0),
                      'cantidad_cajas' => (int) ($validated['cantidad_cajas'][$index] ?? 0),
                      'presentacion' => [$validated['presentacion'][$index] ?? ''],
                  ];
              } else {
                  $detalle = [
                      'id_lote_envasado' => (int) $idLoteEnvasado,
                  ];
              }

              $detalles[] = $detalle;

              // Actualizar contenido alcohólico
              if (!is_null($contenidoAlc)) {
                  lotes_envasado::where('id_lote_envasado', $idLoteEnvasado)
                      ->update(['cont_alc_envasado' => $contenidoAlc]);
              }
          }

          $data['detalles'] = $detalles;


        // Obtener el número del cliente desde la tabla empresa_num_cliente
        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $validated['id_empresa'])->first();
        $empresaNumCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });


        // Guardar la solicitud
        $pedido = new solicitudesModel();
        $pedido->folio = Helpers::generarFolioSolicitud();
        $pedido->id_empresa = $validated['id_empresa'];
        $pedido->fecha_solicitud = $validated['fecha_solicitud'];
        $pedido->fecha_visita = $validated['fecha_visita'];
        $pedido->id_tipo = 11;
        $pedido->id_instalacion = $validated['id_instalacion'];
        $pedido->info_adicional = $validated['info_adicional'];
        $pedido->caracteristicas = json_encode($data);  // Guardar el JSON completo con las características (incluyendo facturas)
        $pedido->save();

        if ($request->has('lotes_granel')) {
         foreach ($request->input('lotes_granel') as $granel) {
              if (!empty($granel['id_lote_granel'])) {LotesGranel::where('id_lote_granel', $granel['id_lote_granel'])
                  ->update([
                    'folio_fq' => $granel['folio_fq'] ?? null,
                ]);
                  }
              }
          }

        // Almacenar archivos si se enviaron
        if ($request->hasFile('factura_proforma')) {
            $file = $request->file('factura_proforma');
            $uniqueId = uniqid();
            $filename = 'FacturaProforma_' . $uniqueId . '.' . $file->getClientOriginalExtension();
            $directory = $empresaNumCliente;
            $path = storage_path('app/public/uploads/' . $directory);

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $filePath = $file->storeAs($directory, $filename, 'public_uploads');
            Documentacion_url::create([
                'id_empresa' => $validated['id_empresa'],
                'url' => basename($filePath),
                'id_relacion' => $pedido->id_solicitud,
                'id_documento' => 55, // ID de factura
                'nombre_documento' => 'Factura Proforma',
            ]);
            $data['factura_proforma'] = $filename;
        }

        if ($request->hasFile('factura_proforma_cont')) {
            $file = $request->file('factura_proforma_cont');
            $uniqueId = uniqid();
            $filename = 'FacturaProformaCont_' . $uniqueId . '.' . $file->getClientOriginalExtension();
            $directory = $empresaNumCliente;
            $path = storage_path('app/public/uploads/' . $directory);

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $filePath = $file->storeAs($directory, $filename, 'public_uploads');
            Documentacion_url::create([
                'id_empresa' => $validated['id_empresa'],
                'url' => basename($filePath),
                'id_relacion' => $pedido->id_solicitud,
                'id_documento' => 55, // ID de factura
                'nombre_documento' => 'Factura Proforma (Continuación)',
            ]);
            $data['factura_proforma_cont'] = $filename;
        }

        $pedido->caracteristicas = json_encode($data); // Ahora incluye las rutas de los archivos
        $pedido->save();
        // Obtener varios usuarios (por ejemplo, todos los usuarios con cierto rol o todos los administradores)
        $users = User::whereIn('id', [4, 2, 3, 7])->get(); // IDs de los usuarios

        // Notificación 1
        $data1 = [
            'title' => 'Nuevo registro de solicitud',
            'message' => $pedido->folio . " " . $pedido->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }

    return response()->json(['success' => true, 'message' => 'Pedido registrado.']);
}


public function storeSolicitudLibProdTerm(Request $request)
{
        // Validación de datos del formulario
        $solicitud = new solicitudesModel();
        $solicitud->folio = Helpers::generarFolioSolicitud();
        $solicitud->id_empresa = $request->id_empresa;
        $solicitud->id_tipo = 8;
        $solicitud->fecha_solicitud = $request->fecha_solicitud;
        $solicitud->fecha_visita = $request->fecha_visita;
        //Auth::user()->id;
        $solicitud->id_instalacion = $request->id_instalacion;
        $solicitud->info_adicional = $request->info_adicional;
        // Guardar el nuevo registro en la base de datos

        $caracteristicas = [
            'id_lote_envasado' => $request->id_lote_envasado,
            'cantidad_botellas' => $request->cantidad_botellas,
            'presentacion' => $request->presentacion,
            'cantidad_pallets' => $request->cantidad_pallets,
            'cajas_por_pallet' => $request->cajas_por_pallet,
            'botellas_por_caja' => $request->botellas_por_caja,
            'hologramas_utilizados' => $request->hologramas_utilizados,
            'hologramas_mermas' => $request->hologramas_mermas,
        ];
        // Convertir el array a JSON y guardarlo en la columna 'caracteristicas'
        $solicitud->caracteristicas = json_encode($caracteristicas);


        $solicitud->save();

        // Obtener varios usuarios (por ejemplo, todos los usuarios con cierto rol o todos los administradores)
        $users = User::whereIn('id', [4, 2, 3, 7,])->get(); // IDs de los usuarios

        // Notificación 1
        $data1 = [
            'title' => 'Nuevo registro de solicitud',
            'message' => $solicitud->folio . " " . $solicitud->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }

    // Retornar una respuesta JSON indicando éxito
    return response()->json(['success' => 'Solicitud registrada correctamente']);
}



    public function getDetalleLoteEnvasado($id_lote_envasado)
    {
        $lote = lotes_envasado::with('lotesGranel.categoria', 'lotesGranel.clase', 'lotesGranel.certificadoGranel')->find($id_lote_envasado); // Cargar relación

        if (!$lote) {
            return response()->json(['error' => 'Lote no encontrado'], 404);
        }

        return response()->json([
            'lote_envasado' => $lote, // Devuelve todos los datos del lote envasado
            'detalle' => $lote->lotesGranel->isEmpty() ? null : $lote->lotesGranel->map(function ($granel) {
                return array_merge($granel->toArray(), [
                    'tiposMaguey' => $granel->tiposRelacionados
                ]);
            })
        ], 200);
    }

    public function getDetalleLoteTipo($id_lote_granel)
    {
        $lote = LotesGranel::find($id_lote_granel);
        if (!$lote) {
            return response()->json(['error' => 'Lote no encontrado'], 404);
        }
        // Usando la relación 'lotesGranel' para obtener los lotes a granel asociados
        $lotesGranel = $lote->lotesGranel; // Esto devuelve los lotes a granel asociados
        // Si no hay lotes a granel asociados, puedes devolver un mensaje o array vacío
        if ($lotesGranel->isEmpty()) {
            return response()->json(['detalle' => null], 200);
        }
        // Si hay lotes a granel, devolverlos en el formato adecuado
        return response()->json([
            'detalle' => $lotesGranel->pluck('nombre_lote') // Puedes cambiar 'nombre_lote' por cualquier campo relevante de LotesGranel
        ]);
    }


    public function exportar(Request $request)
    {
        $filtros = $request->only(['id_empresa', 'anio', 'estatus', 'mes', 'id_soli']);
        // Pasar los filtros a la clase SolicitudesExport
         $fechaHora = now()->format('d-m-Y H-i');
         $nombreArchivo = "Reporte de Solicitudes {$fechaHora}.xlsx";
        return Excel::download(new SolicitudesExport($filtros),  $nombreArchivo);
    }


    public function destroy(Request $request, $id_solicitud)
    {
        try {
            $solicitud = solicitudesModel::findOrFail($id_solicitud);
            // Guardar motivo recibido del request
            $motivo = $request->input('reason', 'Sin motivo especificado');
            // Registrar en tabla solicitudes_eliminadas
            solicitudes_eliminadas::create([
                'id_solicitud' => $id_solicitud,
                'motivo' => $motivo,
                'responsable'       => Auth::id(),
                'fecha_eliminacion' => Carbon::now(), // Laravel te da la fecha/hora actual
            ]);
            // Deshabilitar la solicitud
            $solicitud->habilitado = 0;
            $solicitud->save();
            return response()->json(['success' => 'Solicitud eliminada correctamente']);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function Etiqueta_240($id_solicitud)
    {
        $pdf = Pdf::loadView('pdfs.Etiqueta-2401ESPTOB');
        return $pdf->stream('Etiqueta-2401ESPTOB.pdf');
    }


    public function registrarValidarSolicitud(Request $request)
    {
        $validar = new solicitudesValidacionesModel();

        // Extraer solo los datos dinámicos enviados, excluyendo el ID de la solicitud
        $dynamicData = $request->except(['solicitud_id', '_token']);

        // Almacenar los datos dinámicos en 'validacion_oc' en formato JSON
        $validar->validacion = json_encode($dynamicData);
        $validar->id_solicitud = $request->solicitud_id;
        $estatus = 'Validada';
        foreach ($dynamicData as $key => $value) {
            if ($value != 'si') {
                $estatus = 'Rechazada';
                break; // Si algún valor no es 'si', se establece como 'Rechazada' y salimos del bucle
            }
        }
        $validar->estatus = $estatus;
        $validar->tipo_validacion = 'oc';
        //$validar->id_usuario = auth()->id();
        $validar->id_usuario = Auth::id();

        // Guardar los cambios en la base de datos
        $validar->save();

        // Buscar usuarios para notificar
        $users = User::whereIn('id', [18, 19, 20])->get();

        // Notificación
        $data1 = [
            'title' => 'Solicitud validada',
            'message' => $validar->folio,
            'url' => 'solicitudes-historial',
        ];

        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }

        // Respuesta exitosa
        return response()->json(['message' => 'Validado exitosamente']);
    }


    public function pdf_validar_solicitud($id_validacion)
    {
        $datos = solicitudesValidacionesModel::find($id_validacion);
        $datos['validacion'] = json_decode($datos['validacion'], true);
        $fecha = Helpers::formatearFechaHora($datos->fecha_realizo);
        //$pdf = Pdf::loadView('pdfs.pdf_validar_solicitud', compact('datos', 'fecha'))->setPaper('letter');;
        //return $pdf->stream('Validación de solicitud.pdf');
        return view('pdfs.pdf_validar_solicitud', compact('datos', 'fecha'));
    }



///ESTATUS ACTIVAR HOLOGRAMAS
public function cambiarEstatus(Request $request, $id)
{
    $solicitud = solicitudesModel::findOrFail($id);
    $solicitud->estatus_activado = $request->estatus_activado; // 0 o 1
    $solicitud->save();

    return response()->json(['success' => true]);
}


       public function delete_document($id_documento)
{
    try {
        $documento = Documentacion_url::findOrFail($id_documento);

        // Si quieres borrar también el archivo físico
        if ($documento->url && Storage::exists('uploads/'.$documento->id_empresa.'/'.$documento->url)) {
            Storage::delete('uploads/'.$documento->id_empresa.'/'.$documento->url);
        }

        $documento->delete();

        return response()->json([
            'success' => true,
            'message' => 'Documento eliminado correctamente.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al eliminar el documento: '.$e->getMessage()
        ], 500);
    }
}




}
