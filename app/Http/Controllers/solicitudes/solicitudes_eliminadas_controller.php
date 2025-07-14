<?php

namespace App\Http\Controllers\solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;

use App\Models\categorias;
use App\Models\empresa;
use App\Models\estados;
use App\Models\instalaciones;
use App\Models\organismos;
use App\Models\lotesGranel;
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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Exports\SolicitudesExport;
use App\Models\etiquetas;
use App\Models\solicitudesValidacionesModel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;//Permisos de empresa
use Illuminate\Support\Facades\DB;

class solicitudes_eliminadas_controller extends Controller
{
       public function UserManagement()
    {
        $solicitudes = solicitudesModel::where('habilitado', 0)
            ->where('id_tipo', '!=', 12)
            ->get();
        $solicitudesTipos = solicitudTipo::all();
        $instalaciones = instalaciones::all();
        $estados = estados::all();
            $empresas = empresa::with('empresaNumClientes')
                ->where('tipo', 2)
                ->get();


        $tipo_usuario =  Auth::user()->tipo;

        $organismos = organismos::all(); // Obtener todos los estados
        $LotesGranel = lotesGranel::all();
        $categorias = categorias::all();
        $clases = clases::all();
        $tipos = tipos::all();
        $marcas = marcas::all();
        $aduanas = catalogo_aduanas::all();

        $inspectores = User::where('tipo', '=', '2')->get(); // Obtener todos los organismos
        return view('solicitudes.find_solicitudes_eliminadas_view', compact('tipo_usuario','instalaciones', 'empresas', 'estados', 'inspectores', 'solicitudesTipos', 'organismos', 'LotesGranel', 'categorias', 'clases', 'tipos', 'marcas', 'aduanas', 'solicitudes'));
    }
    public function findCertificadosExportacion()
    {
        $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get();
        return view('certificados.find_certificados_exportacion', compact('empresas'));
    }

    public function index(Request $request)
    {

        $userId = Auth::id();

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

        $search = [];

        $query = solicitudesModel::query()->where('habilitado', 0)
            ->where('id_tipo', '!=', 12);


        if ($userId == 49) {
            $query->where('id_tipo', 11);
        }
        // Filtros específicos por columna
      $columnsInput = $request->input('columns');

      if ($columnsInput && isset($columnsInput[6]) && !empty($columnsInput[6]['search']['value'])) {
          $tipoFilter = $columnsInput[6]['search']['value'];
          // Filtro exacto o LIKE según necesites
          $query->whereHas('tipo_solicitud', function($q) use ($tipoFilter) {
              $q->where('tipo', 'LIKE', "%{$tipoFilter}%");
          });
      }

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        if (empty($request->input('search.value'))) {
            // Construir la consulta base
            $query = solicitudesModel::with([
                'tipo_solicitud',
                'empresa',
                'instalacion',
                'inspeccion.inspector',
                'ultima_validacion_oc',
                'ultima_validacion_ui'
            ])->where('habilitado', 0)
                ->where('id_tipo', '!=', 12);

            // Si se necesita ordenar por nombre del inspector
            if ($order === 'inspector') {
                $query->orderBy('inspector_name', $dir);
            } elseif ($order === 'folio') {
                $query->orderByRaw("CAST(SUBSTRING(folio, 5) AS UNSIGNED) $dir");
            } else {
                $query->orderBy($order, $dir);
            }

            // Filtrar por empresa si aplica

            if ($userId == 49) {
            $query->where('id_tipo', 11);
         }

            // Paginación
            $solicitudes = $query->offset($start)
                ->limit($limit)
                ->get();
                        } else {
                            // Consulta con búsqueda
                            $search = $request->input('search.value');

                            $solicitudes = solicitudesModel::with([
                        'tipo_solicitud',
                        'empresa',
                        'instalacion',
                        'inspeccion.inspector',
                        'ultima_validacion_oc',
                        'ultima_validacion_ui'
                    ])->where('habilitado', 0)
                    ->where('id_tipo', '!=', 12)
                    ->where(function ($query) use ($search) {
                        $query->where(function ($q) use ($search) {
                            $q->where('solicitudes.id_solicitud', 'LIKE', "%{$search}%")
                                ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
                                ->orWhere('solicitudes.estatus', 'LIKE', "%{$search}%")
                                ->orWhereHas('empresa', function ($q) use ($search) {
                                    $q->where('razon_social', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('tipo_solicitud', function ($q) use ($search) {
                                    $q->where('tipo', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('instalacion', function ($q) use ($search) {
                                    $q->where('direccion_completa', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('inspeccion', function ($q) use ($search) {
                                    $q->where('num_servicio', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('inspeccion.inspector', function ($q) use ($search) {
                                    $q->where('name', 'LIKE', "%{$search}%");
                                });
                        });
                    });

                if ($userId == 49) {
                     $solicitudes->where('id_tipo', 11);
                }

                $solicitudes = $solicitudes->offset($start)
                    ->limit($limit)
                    //->orderBy("solicitudes.id_solicitud", $dir)
                    ->when($order === 'folio', function ($q) use ($dir) {
                        return $q->orderByRaw("CAST(SUBSTRING(folio, 5) AS UNSIGNED) $dir");
                    }, function ($q) use ($order, $dir) {
                        return $q->orderBy($order, $dir);
                    })
                    ->get();


                            $totalFilteredQuery = solicitudesModel::with('tipo_solicitud',
                        'empresa',
                        'instalacion',
                        'inspeccion.inspector',
                        'ultima_validacion_oc',
                        'ultima_validacion_ui')->where('habilitado', 0)
                            ->where('id_tipo', '!=', 12)
                    ->where(function ($query) use ($search) {
                        $query->where(function ($q) use ($search) {
                            $q->where('solicitudes.id_solicitud', 'LIKE', "%{$search}%")
                                ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
                                ->orWhere('solicitudes.estatus', 'LIKE', "%{$search}%")
                                ->orWhereHas('empresa', function ($q) use ($search) {
                                    $q->where('razon_social', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('tipo_solicitud', function ($q) use ($search) {
                                    $q->where('tipo', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('instalacion', function ($q) use ($search) {
                                    $q->where('direccion_completa', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('inspeccion', function ($q) use ($search) {
                                    $q->where('num_servicio', 'LIKE', "%{$search}%");
                                })
                                ->orWhereHas('inspeccion.inspector', function ($q) use ($search) {
                                    $q->where('name', 'LIKE', "%{$search}%");
                                });
                        });
                    });
                if ($userId == 49) {
                     $totalFilteredQuery->where('id_tipo', 11);
                }
                $totalFiltered = $totalFilteredQuery->count();
        }
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
                $nestedData['id_tipo'] = $solicitud->tipo_solicitud->id_tipo ?? 'N/A';
                $nestedData['motivo'] = $solicitud->eliminada->motivo ?? 'N/A';
                $nestedData['estatus'] = $solicitud->estatus ?? 'Vacío';
                $nestedData['estatus_validado_oc'] = $solicitud->ultima_validacion_oc->estatus ?? 'Pendiente';
                $nestedData['estatus_validado_ui'] = $solicitud->ultima_validacion_ui->estatus ?? 'Pendiente';
                $nestedData['info_adicional'] = $solicitud->info_adicional ?? 'Vacío';
                $nestedData['folio_info'] = $solicitud->folio;
                $nestedData['num_servicio_info'] = $solicitud->inspeccion->num_servicio ?? 'Sin asignar';
                $nestedData['inspectorName'] = $solicitud->inspector->name ?? 'Sin inspector';
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
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data ?? [],
        ]);
    }

    public function restore(Request $request, $id_solicitud)
    {
        try {
            $solicitud = solicitudesModel::findOrFail($id_solicitud);
            // Restaurar solicitud
            $solicitud->habilitado = 1;
            $solicitud->save();

            // Eliminar el registro de la tabla de eliminados
            solicitudes_eliminadas::where('id_solicitud', $id_solicitud)->delete();

            return response()->json(['success' => 'Solicitud restaurada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
