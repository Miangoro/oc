<?php

namespace App\Http\Controllers\bitacoras;


use App\Models\BitacoraProcesoElaboracion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\instalaciones;
use App\Models\empresa;
use App\Models\BitacoraProcesoMoliendaDestilacion;
use App\Models\BitacoraProcesoSegundaDestilacion;
use App\Models\maquiladores_model;
use Carbon\Carbon;
use App\Helpers\Helpers;
use App\Models\tipos;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Barryvdh\DomPDF\Facade\Pdf;
use TypeError;

class BitacoraProcesoElaboracionController extends Controller
{
  public function UserManagement()
  {
    $bitacora = BitacoraProcesoElaboracion::all();
                if (Auth::check() && Auth::user()->tipo == 3) {
        $empresaIdA = Auth::user()->empresa?->id_empresa;
        $empresas = empresa::with('empresaNumClientes')->where('id_empresa', $empresaIdA)->get();
          } else {
              $empresas = empresa::with('empresaNumClientes')
                  ->where('tipo', 2)
                  ->get();
          }
      $tipos = tipos::all(); // Obtén todos los tipos de agave
      $tipo_usuario =  Auth::user()->tipo;
      $instalacionesIds = Auth::user()->id_instalacion ?? [];
      $instalacionesUsuario = instalaciones::whereIn('id_instalacion', $instalacionesIds)->get();
      return view('bitacoras.BitacoraProcesoElaboracion_view', compact('bitacora', 'empresas', 'tipo_usuario', 'tipos',  'instalacionesIds','instalacionesUsuario'));
  }

  public function index(Request $request)
  {
      $empresaId = $request->input('empresa');
      $instalacionId = $request->input('instalacion');
      DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para meses
        $columns = [                     // id oculto o de control
            1 => 'id',
            2 => 'fecha_ingreso',
            3 => 'numero_tapada',
            4 => 'lote_granel',
            5 => 'numero_guia',
            6 => 'id_tipo_maguey',          // es JSON, NO debes ordenarlo
            7 => 'numero_pinas',
            8 => 'kg_maguey',
            9 => 'observaciones',
            10 => 'id_firmante',
        ];

        $empresaIdAut = null;
          if (Auth::check() && Auth::user()->tipo == 3) {
              $empresaIdAut = Auth::user()->empresa?->id_empresa;
          }
          $instalacionAuth = [];
            if (Auth::check() && Auth::user()->tipo == 3) {
                $instalacionAuth = (array) Auth::user()->id_instalacion; // cast a array
                $instalacionAuth = array_filter(array_map('intval', $instalacionAuth), fn($id) => $id > 0);

                // Si el usuario tipo 3 no tiene instalaciones, devolver vacío
                if (empty($instalacionAuth)) {
                    return response()->json([
                        'draw' => intval($request->input('draw')),
                        'recordsTotal' => 0,
                        'recordsFiltered' => 0,
                        'code' => 200,
                        'data' => []
                    ]);
                }
           }
      $search = $request->input('search.value'); // <-- aquí viene el valor del campo de búsqueda de DataTables
     /*  $totalData = BitacoraProcesoElaboracion::count();  */// Cambiado por el modelo correcto
      $totalData = BitacoraProcesoElaboracion::query()->when($empresaIdAut, function ($query) use ($empresaIdAut) {
                  $query->where('id_empresa', $empresaIdAut);
              })->count();

      $totalFiltered = $totalData;

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')] ?? 'id';
      $dir = $request->input('order.0.dir') ?? 'desc';

        $query = BitacoraProcesoElaboracion::query()->when($empresaIdAut, function ($query) use ($empresaIdAut) {
                  $query->where('id_empresa', $empresaIdAut);
              });

      if (Auth::check() && Auth::user()->tipo == 3 && !empty($instalacionAuth)) {
                $query->whereIn('id_instalacion', $instalacionAuth);
            }
        /* if ($empresaId) {
            $query->where('id_empresa', $empresaId);
        } */
         if ($empresaId) {
              $empresa = empresa::find($empresaId);
              if ($empresa) {
                  // Buscar maquiladores hijos en la tabla intermedia
                  $idsMaquiladores = maquiladores_model::where('id_maquiladora', $empresaId)
                  ->pluck('id_maquilador')
                  ->toArray();
                  // Si tiene hijos, se asume maquiladora
                  if (count($idsMaquiladores)) {
                      $idsEmpresas = array_merge([$empresaId], $idsMaquiladores);
                  } else {
                      // Sin hijos, solo su propio ID
                      $idsEmpresas = [$empresaId];
                  }
                  $query->whereIn('id_empresa', $idsEmpresas);
                  if ($instalacionId) {
                      $query->where('id_instalacion', $instalacionId);
                  }
              }
          }

        $filteredQuery = clone $query;
        if (!empty($search)) {
            $lower = strtolower($search);

            $idsCoincidentes = tipos::where('nombre', 'LIKE', "%{$search}%")
                ->orWhere('cientifico', 'LIKE', "%{$search}%")
                ->pluck('id_tipo')
                ->toArray();

            $filteredQuery->where(function ($q) use ($search, $idsCoincidentes, $lower) {
                if ($lower === 'firmado') {
                    $q->where(function ($q2) {
                        $q2->whereRaw("JSON_EXTRACT(id_firmante, '$.entrada_maguey.id_firmante') > 0")
                          ->orWhereRaw("JSON_EXTRACT(id_firmante, '$.coccion.id_firmante') > 0")
                          ->orWhereRaw("JSON_EXTRACT(id_firmante, '$.molienda.id_firmante') > 0")
                          ->orWhereRaw("JSON_EXTRACT(id_firmante, '$.segunda_destilacion.id_firmante') > 0")
                          ->orWhereRaw("JSON_EXTRACT(id_firmante, '$.producto_terminado.id_firmante') > 0");
                    });
                } elseif ($lower === 'sin firmar' || $lower === 'sin firmado') {
                    $q->where(function ($q2) {
                        $q2->whereRaw("IFNULL(JSON_EXTRACT(id_firmante, '$.entrada_maguey.id_firmante'), 0) = 0")
                          ->whereRaw("IFNULL(JSON_EXTRACT(id_firmante, '$.coccion.id_firmante'), 0) = 0")
                          ->whereRaw("IFNULL(JSON_EXTRACT(id_firmante, '$.molienda.id_firmante'), 0) = 0")
                          ->whereRaw("IFNULL(JSON_EXTRACT(id_firmante, '$.segunda_destilacion.id_firmante'), 0) = 0")
                          ->whereRaw("IFNULL(JSON_EXTRACT(id_firmante, '$.producto_terminado.id_firmante'), 0) = 0");
                    });
                } else {
                    // El resto de búsquedas normales
                    $q->where('fecha_ingreso', 'LIKE', "%{$search}%")
                      ->orWhere('lote_granel', 'LIKE', "%{$search}%")
                      ->orWhere('id_empresa', 'LIKE', "%{$search}%")
                      ->orWhere('numero_tapada', 'LIKE', "%{$search}%")
                      ->orWhere('numero_guia', 'LIKE', "%{$search}%")
                      ->orWhere('numero_pinas', 'LIKE', "%{$search}%")
                      ->orWhere('kg_maguey', 'LIKE', "%{$search}%")
                      ->orWhere('observaciones', 'LIKE', "%{$search}%")
                      ->orWhereHas('empresaBitacora', function ($sub) use ($search) {
                          $sub->where('razon_social', 'LIKE', "%{$search}%");
                      })
                       ->orWhereHas('instalacion', function ($sub) use ($search) {
                          $sub->where('direccion_completa', 'LIKE', "%{$search}%");
                      });

                    if (!empty($idsCoincidentes)) {
                        foreach ($idsCoincidentes as $tipoId) {
                            $q->orWhereRaw("JSON_CONTAINS(id_tipo_maguey, '\"{$tipoId}\"')");
                        }
                    }
                }
            });

            $totalFiltered = $filteredQuery->count();
        } else {
            $totalFiltered = $filteredQuery->count();
        }



        $users = $filteredQuery->offset($start)
        ->limit($limit)
        ->orderBy('id', 'desc')
        ->get();


      $data = [];

      if (!empty($users)) {
        $tipos = tipos::all();
        $tiposNombres = tipos::all()
        ->mapWithKeys(fn($tipo) => [
            (int) $tipo->id_tipo => [
                'nombre' => $tipo->nombre,
                'cientifico' => $tipo->cientifico, // asegúrate de que este campo exista
            ]
        ])
        ->toArray();
          $ids = $start;
          foreach ($users as $bitacora) {
          $razonSocial = $bitacora->empresaBitacora->razon_social ?? 'Sin razón social';
           $numeroCliente = null;
                if ($bitacora->empresaBitacora && $bitacora->empresaBitacora->empresaNumClientes) {
                    $clientes = $bitacora->empresaBitacora->empresaNumClientes;
                    foreach ([0, 1, 2] as $index) {
                        if (isset($clientes[$index]) && !empty($clientes[$index]->numero_cliente)) {
                            $numeroCliente = $clientes[$index]->numero_cliente;
                            break;
                        }
                    }
                }
                $numeroCliente = $numeroCliente ?? 'Sin número cliente';

              $nestedData = [];
              $nestedData['id'] = $bitacora->id ?? 'N/A';
              $nestedData['fake_id'] = ++$ids; // ← ¡Aquí está tu índice visible!
                if ($bitacora->id_tipo_maguey && $bitacora->id_tipo_maguey !== 'N/A') {
                  $idTipo = json_decode($bitacora->id_tipo_maguey, true);
                  if (is_array($idTipo)) {
                      $nombresTipos = array_map(function($tipoId) use ($tiposNombres) {
                      $tipoId = (int) $tipoId; // 🔧 fuerza a entero
                      if (isset($tiposNombres[$tipoId])) {

                              $nombre = $tiposNombres[$tipoId]['nombre'] ?? 'Desconocido';
                              $cientifico = $tiposNombres[$tipoId]['cientifico'] ?? '';
                             return $cientifico
                    ? "$nombre <em>(" . strtolower($cientifico) . ")</em>"
                    : $nombre;
                          }
                          return 'Desconocido';
                      }, $idTipo);
                      $nestedData['id_tipo_maguey'] = implode(', ', $nombresTipos);
                  } else {
                      $nestedData['id_tipo_maguey'] = 'Desconocido';
                  }
              } else {
                  $nestedData['id_tipo_maguey'] = 'N/A';
              }


              $nestedData['fecha_ingreso'] = Helpers::formatearFecha($bitacora->fecha_ingreso);
              $nestedData['nombre_cliente'] = $bitacora->empresaBitacora->razon_social ?? 'Sin razón social';
              $nestedData['cliente'] = '<b>' . $numeroCliente . '</b><br>' . $razonSocial ?? 'N/A';
              $nestedData['id_empresa'] = $bitacora->id_empresa ?? 'N/A';
              $nestedData['instalacion'] = $bitacora->instalacion->direccion_completa ?? 'N/A';
              $nestedData['numero_tapada'] = $bitacora->numero_tapada ?? 'N/A';
              $nestedData['lote_granel'] = $bitacora->lote_granel ?? 'N/A';
              $nestedData['id_firmante'] = $bitacora->id_firmante ?? 'N/A';
              $nestedData['numero_guia'] = $bitacora->numero_guia ?? 'N/A';
              $nestedData['tipo_maguey'] = $bitacora->tipo_maguey ?? 'N/A';
              $nestedData['numero_pinas'] = $bitacora->numero_pinas ?? 'N/A';
              $nestedData['kg_maguey'] = $bitacora->kg_maguey ?? 'N/A';
              $nestedData['observaciones'] = $bitacora->observaciones ?? 'N/A';
              $nestedData['id_usuario_registro'] = $bitacora->registro->name ?? 'N/A';
              $nestedData['action'] = '';

              $data[] = $nestedData;
          }

      }

      if ($data) {
          return response()->json([
              'draw' => intval($request->input('draw')),
              'recordsTotal' => intval($totalData),
              'recordsFiltered' => intval($totalFiltered),
              'code' => 200,
              'data' => $data,
          ]);
      } else {
          return response()->json([
              'message' => 'Internal Server Error',
              /* 'draw' => intval($request->input('draw')), */
              /* 'recordsTotal' => intval($totalData), */
              'recordsFiltered' => 0,
              'code' => 500,
              'data' => [],
          ]);
      }
  }


      public function PDFBitacoraProcesoElab(Request $request, $id_bitacora)
      {
          $bitacora = BitacoraProcesoElaboracion::with([
            'empresaBitacora.empresaNumClientes',
            'firmante',
            'molienda',              // Agrega molienda para tenerla disponible
            'segundaDestilacion'     // y también segunda destilación
        ])->find($id_bitacora);
         if (!$bitacora) {
            return response()->json(['message' => 'Bitácora no encontrada'], 404);
          }
            $firmantes = json_decode($bitacora->id_firmante, true);

            $entrada_maguey        = $firmantes['entrada_maguey']['id_firmante'] ?? null;
            $coccion               = $firmantes['coccion']['id_firmante'] ?? null;
            $molienda              = $firmantes['molienda']['id_firmante'] ?? null;
            $segunda_destilacion   = $firmantes['segunda_destilacion']['id_firmante'] ?? null;
            $producto_terminado    = $firmantes['producto_terminado']['id_firmante'] ?? null;

            // Si quieres cargar los modelos User (opcional)
            $userEntradaMaguey      = $entrada_maguey ? User::find($entrada_maguey) : null;
            $userCoccion            = $coccion ? User::find($coccion) : null;
            $userMolienda           = $molienda ? User::find($molienda) : null;
            $userSegundaDestilacion = $segunda_destilacion ? User::find($segunda_destilacion) : null;
            $userProductoTerminado  = $producto_terminado ? User::find($producto_terminado) : null;

            $pdf = Pdf::loadView('pdfs.Bitacora_Productor_procesoEd0_2025', compact('bitacora','userEntradaMaguey',
            'userCoccion',
            'userMolienda',
            'userSegundaDestilacion',
            'userProductoTerminado'))
              ->setPaper([0, 0, 1005.25, 612.3]); // 355 x 216 mm (horizontal)



          return $pdf->stream('Bitácora PROCESO DE ELABORACIÓN DE MEZCAL.pdf');
      }


      public function store(Request $request)
      {

          $request->validate([
              'fecha_ingreso'           => 'required|date',
              'id_empresa'              => 'required|integer|exists:empresa,id_empresa',
              'id_instalacion'        => 'nullable|integer|exists:instalaciones,id_instalacion',
              'lote_granel'             => 'required|string|max:100',
              'numero_tapada'           => 'required|string|max:100',
              'numero_guia'             => 'required|string|max:100',
              'id_tipo'                 => 'required|array|min:1',
              'id_tipo.*'               => 'required|integer',
              'numero_pinas'           => 'required|integer|min:1',
              'kg_maguey'              => 'required|numeric|min:0',
              'porcentaje_azucar'      => 'required|numeric|min:0|max:100',
              'kg_coccion'             => 'required|numeric|min:0',
              'fecha_inicio_coccion'   => 'required|date',
              'fecha_fin_coccion'      => 'required|date',
              'volumen_total_formulado'=> 'nullable|numeric|min:0',
              'puntas_volumen'         => 'nullable|numeric|min:0',
              'puntas_alcohol'         => 'nullable|numeric|min:0|max:100',
              'mezcal_volumen'         => 'nullable|numeric|min:0',
              'mezcal_alcohol'         => 'nullable|numeric|min:0|max:100',
              'colas_volumen'          => 'nullable|numeric|min:0',
              'colas_alcohol'          => 'nullable|numeric|min:0|max:100',
              'observaciones'          => 'nullable|string',

              'molienda'                      => 'nullable|array',
              'molienda.*.fecha_molienda'    => 'nullable|date',
              'molienda.*.numero_tina'       => 'nullable|string',
              'molienda.*.fecha_formulacion' => 'nullable|date',
              'molienda.*.volumen_formulacion' => 'nullable|numeric|min:0',
              'molienda.*.fecha_destilacion' => 'nullable|date',
              'molienda.*.puntas_volumen'    => 'nullable|numeric|min:0',
              'molienda.*.puntas_alcohol'    => 'nullable|numeric|min:0|max:100',
              'molienda.*.mezcal_volumen'    => 'nullable|numeric|min:0',
              'molienda.*.mezcal_alcohol'    => 'nullable|numeric|min:0|max:100',
              'molienda.*.colas_volumen'     => 'nullable|numeric|min:0',
              'molienda.*.colas_alcohol'     => 'nullable|numeric|min:0|max:100',

              'segunda_destilacion'                      => 'nullable|array',
              'segunda_destilacion.*.fecha_destilacion'  => 'nullable|date',
              'segunda_destilacion.*.puntas_volumen'     => 'nullable|numeric|min:0',
              'segunda_destilacion.*.puntas_alcohol'     => 'nullable|numeric|min:0|max:100',
              'segunda_destilacion.*.mezcal_volumen'     => 'nullable|numeric|min:0',
              'segunda_destilacion.*.mezcal_alcohol'     => 'nullable|numeric|min:0|max:100',
              'segunda_destilacion.*.colas_volumen'      => 'nullable|numeric|min:0',
              'segunda_destilacion.*.colas_alcohol'      => 'nullable|numeric|min:0|max:100',
          ]);
          try {
              DB::beginTransaction();
              $bitacora = BitacoraProcesoElaboracion::create([
                  'fecha_ingreso'            => $request->fecha_ingreso,
                  'id_empresa'               => $request->id_empresa,
                  'id_instalacion'         => $request->id_instalacion ?? 0,
                  'lote_granel'              => $request->lote_granel,
                  'numero_tapada'            => $request->numero_tapada,
                  'numero_guia'              => $request->numero_guia,
                  /* 'id_tipo_maguey'           => json_encode($request->id_tipo), */
                  'id_tipo_maguey' => is_array($request->id_tipo) ? json_encode($request->id_tipo) : null,
                  'numero_pinas'             => $request->numero_pinas,
                  'kg_maguey'                => $request->kg_maguey,
                  'porcentaje_azucar'        => $request->porcentaje_azucar,
                  'kg_coccion'               => $request->kg_coccion,
                  'fecha_inicio_coccion'     => $request->fecha_inicio_coccion,
                  'fecha_fin_coccion'        => $request->fecha_fin_coccion,
                  'molienda_total_formulado' => $request->volumen_total_formulado,
                  'total_puntas_volumen'     => $request->puntas_volumen,
                  'total_puntas_porcentaje'  => $request->puntas_alcohol,
                  'total_mezcal_volumen'     => $request->mezcal_volumen,
                  'total_mezcal_porcentaje'  => $request->mezcal_alcohol,
                  'total_colas_volumen'      => $request->colas_volumen,
                  'total_colas_porcentaje'   => $request->colas_alcohol,
                  'observaciones'            => $request->observaciones,
                  'id_usuario_registro'      => auth()->id(),
              ]);
              // Guardar molienda
              if (is_array($request->input('molienda')) && count($request->input('molienda')) > 0) {
                  foreach ($request->input('molienda') as $fila) {
                          BitacoraProcesoMoliendaDestilacion::create([
                      'id_bitacora'         => $bitacora->id,
                      'fecha_molienda'      => $fila['fecha_molienda'],
                      'numero_tina'         => $fila['numero_tina'],
                      'fecha_formulacion'   => $fila['fecha_formulacion'],
                      'volumen_formulacion' => $fila['volumen_formulacion'],
                      'fecha_destilacion'   => $fila['fecha_destilacion'],
                      'puntas_volumen'      => $fila['puntas_volumen'],
                      'puntas_porcentaje'   => $fila['puntas_alcohol'],
                      'mezcal_volumen'      => $fila['mezcal_volumen'],
                      'mezcal_porcentaje'   => $fila['mezcal_alcohol'],
                      'colas_volumen'       => $fila['colas_volumen'],
                      'colas_porcentaje'    => $fila['colas_alcohol'],
                                  ]);
                    }
                }
              // Guardar segunda destilación
              if (is_array($request->input('segunda_destilacion')) && count($request->input('segunda_destilacion')) > 0) {
                  foreach ($request->input('segunda_destilacion') as $fila) {
                      BitacoraProcesoSegundaDestilacion::create([
                      'id_bitacora'        => $bitacora->id,
                      'fecha_destilacion'  => $fila['fecha_destilacion'],
                      'puntas_volumen'     => $fila['puntas_volumen'],
                      'puntas_porcentaje'  => $fila['puntas_alcohol'],
                      'mezcal_volumen'     => $fila['mezcal_volumen'],
                      'mezcal_porcentaje'  => $fila['mezcal_alcohol'],
                      'colas_volumen'      => $fila['colas_volumen'],
                      'colas_porcentaje'   => $fila['colas_alcohol'],
                  ]);
              }
            }
              DB::commit();
              return response()->json(['success' => 'Bitácora registrada correctamente']);
          } catch (\Throwable $e) {
              DB::rollBack();
              Log::error('Error al guardar bitácora: ' . $e->getMessage());
              return response()->json(['error' => 'Ocurrió un error al guardar la bitácora'], 500);
          }
      }

        public function edit($id_bitacora)
        {
            try {
                $bitacora = BitacoraProcesoElaboracion::with(['molienda', 'segundaDestilacion'])->findOrFail($id_bitacora);
                return response()->json([
                    'success' => true,
                    'bitacora' => [
                        'id'                     => $bitacora->id,
                        'fecha_ingreso'          => $bitacora->fecha_ingreso,
                        'id_empresa'             => $bitacora->id_empresa,
                        'id_instalacion'         => $bitacora->id_instalacion,
                        'lote_granel'            => $bitacora->lote_granel,
                        'numero_tapada'          => $bitacora->numero_tapada,
                        'numero_guia'            => $bitacora->numero_guia,
                        'id_tipo'                => json_decode($bitacora->id_tipo_maguey),
                        'numero_pinas'           => $bitacora->numero_pinas,
                        'kg_maguey'              => $bitacora->kg_maguey,
                        'porcentaje_azucar'      => $bitacora->porcentaje_azucar,
                        'kg_coccion'             => $bitacora->kg_coccion,
                        'fecha_inicio_coccion'   => $bitacora->fecha_inicio_coccion,
                        'fecha_fin_coccion'      => $bitacora->fecha_fin_coccion,
                        'volumen_total_formulado'=> $bitacora->molienda_total_formulado,
                        'puntas_volumen'         => $bitacora->total_puntas_volumen,
                        'puntas_alcohol'         => $bitacora->total_puntas_porcentaje,
                        'mezcal_volumen'         => $bitacora->total_mezcal_volumen,
                        'mezcal_alcohol'         => $bitacora->total_mezcal_porcentaje,
                        'colas_volumen'          => $bitacora->total_colas_volumen,
                        'colas_alcohol'          => $bitacora->total_colas_porcentaje,
                        'observaciones'          => $bitacora->observaciones,
                        'molienda'               => $bitacora->molienda,
                        'segunda_destilacion'    => $bitacora->segundaDestilacion,
                    ]
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener datos: ' . $e->getMessage()
                ], 500);
            }
        }

    public function destroy($id_bitacora)
    {
        $bitacora = BitacoraProcesoElaboracion::find($id_bitacora);

        if (!$bitacora) {
            return response()->json([
                'error' => 'Bitácora no encontrada.'
            ], 404);
        }

        $bitacora->delete();

        return response()->json([
            'success' => 'Bitácora eliminada correctamente.'
        ]);
    }

          public function firmarBitacora(Request $request, $id_bitacora)
        {
            try {
                $bitacora = BitacoraProcesoElaboracion::findOrFail($id_bitacora);

                if (auth()->user()->tipo === 2) {
                    $etapasSeleccionadas = $request->input('etapa_proceso', []); // array

                    // Forzar que sea array aunque venga vacío
                    if (!is_array($etapasSeleccionadas)) {
                        $etapasSeleccionadas = [$etapasSeleccionadas];
                    }

                    $etapasBitacora = $bitacora->id_firmante ? json_decode($bitacora->id_firmante, true) : [];

                    $etapasDefinidas = ['entrada_maguey', 'coccion', 'molienda', 'segunda_destilacion', 'producto_terminado'];
                    // Inicializar claves si no existen
                    foreach ($etapasDefinidas as $etapa) {
                        if (!isset($etapasBitacora[$etapa])) {
                            $etapasBitacora[$etapa] = ['id_firmante' => 0];
                        }
                    }

                    // Marcar firmadas las etapas seleccionadas
                    foreach ($etapasSeleccionadas as $etapa) {
                        if (in_array($etapa, $etapasDefinidas)) {
                            $etapasBitacora[$etapa]['id_firmante'] = auth()->id();
                        }
                    }

                    // Guardar como JSON
                    $bitacora->id_firmante = json_encode($etapasBitacora);
                    $bitacora->save();

                    return response()->json(['message' => 'Etapa(s) firmada(s) correctamente.']);
                }

                return response()->json(['message' => 'No tienes permiso para firmar esta bitácora.'], 403);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return response()->json(['message' => $e->getMessage()], 500);
            }
        }





      public function update(Request $request, $id_bitacora)
      {
          $request->validate([
              'fecha_ingreso'           => 'required|date',
              'id_empresa'              => 'required|integer|exists:empresa,id_empresa',
              'id_instalacion'        => 'nullable|integer|exists:instalaciones,id_instalacion',
              'lote_granel'             => 'required|string|max:100',
              'numero_tapada'           => 'required|string|max:100',
              'numero_guia'             => 'required|string|max:100',
              'id_tipo'                 => 'required|array|min:1',
              'id_tipo.*'               => 'required|integer',
              'numero_pinas'           => 'required|integer|min:1',
              'kg_maguey'              => 'required|numeric|min:0',
              'porcentaje_azucar'      => 'required|numeric|min:0|max:100',
              'kg_coccion'             => 'required|numeric|min:0',
              'fecha_inicio_coccion'   => 'required|date',
              'fecha_fin_coccion'      => 'required|date',
              'volumen_total_formulado'=> 'nullable|numeric|min:0',
              'puntas_volumen'         => 'nullable|numeric|min:0',
              'puntas_alcohol'         => 'nullable|numeric|min:0|max:100',
              'mezcal_volumen'         => 'nullable|numeric|min:0',
              'mezcal_alcohol'         => 'nullable|numeric|min:0|max:100',
              'colas_volumen'          => 'nullable|numeric|min:0',
              'colas_alcohol'          => 'nullable|numeric|min:0|max:100',
              'observaciones'          => 'nullable|string',
              'molienda'                      => 'nullable|array',
              'molienda.*.fecha_molienda'    => 'nullable|date',
              'molienda.*.numero_tina'       => 'nullable|string',
              'molienda.*.fecha_formulacion' => 'nullable|date',
              'molienda.*.volumen_formulacion' => 'nullable|numeric|min:0',
              'molienda.*.fecha_destilacion' => 'nullable|date',
              'molienda.*.puntas_volumen'    => 'nullable|numeric|min:0',
              'molienda.*.puntas_alcohol'    => 'nullable|numeric|min:0|max:100',
              'molienda.*.mezcal_volumen'    => 'nullable|numeric|min:0',
              'molienda.*.mezcal_alcohol'    => 'nullable|numeric|min:0|max:100',
              'molienda.*.colas_volumen'     => 'nullable|numeric|min:0',
              'molienda.*.colas_alcohol'     => 'nullable|numeric|min:0|max:100',

              'segunda_destilacion'                      => 'nullable|array',
              'segunda_destilacion.*.fecha_destilacion'  => 'nullable|date',
              'segunda_destilacion.*.puntas_volumen'     => 'nullable|numeric|min:0',
              'segunda_destilacion.*.puntas_alcohol'     => 'nullable|numeric|min:0|max:100',
              'segunda_destilacion.*.mezcal_volumen'     => 'nullable|numeric|min:0',
              'segunda_destilacion.*.mezcal_alcohol'     => 'nullable|numeric|min:0|max:100',
              'segunda_destilacion.*.colas_volumen'      => 'nullable|numeric|min:0',
              'segunda_destilacion.*.colas_alcohol'      => 'nullable|numeric|min:0|max:100',
          ]);

          try {
              DB::beginTransaction();

              $bitacora = BitacoraProcesoElaboracion::findOrFail($id_bitacora);

              $bitacora->update([
                  'fecha_ingreso'            => $request->fecha_ingreso,
                  'id_empresa'               => $request->id_empresa,
                  'id_instalacion'         => $request->id_instalacion ?? 0,
                  'lote_granel'              => $request->lote_granel,
                  'numero_tapada'            => $request->numero_tapada,
                  'numero_guia'              => $request->numero_guia,
                  'id_tipo_maguey'           => is_array($request->id_tipo) ? json_encode($request->id_tipo) : null,
                  'numero_pinas'            => $request->numero_pinas,
                  'kg_maguey'               => $request->kg_maguey,
                  'porcentaje_azucar'       => $request->porcentaje_azucar,
                  'kg_coccion'              => $request->kg_coccion,
                  'fecha_inicio_coccion'    => $request->fecha_inicio_coccion,
                  'fecha_fin_coccion'       => $request->fecha_fin_coccion,
                  'molienda_total_formulado'=> $request->volumen_total_formulado,
                  'total_puntas_volumen'    => $request->puntas_volumen,
                  'total_puntas_porcentaje' => $request->puntas_alcohol,
                  'total_mezcal_volumen'    => $request->mezcal_volumen,
                  'total_mezcal_porcentaje' => $request->mezcal_alcohol,
                  'total_colas_volumen'     => $request->colas_volumen,
                  'total_colas_porcentaje'  => $request->colas_alcohol,
                  'observaciones'           => $request->observaciones,
              ]);

              // 🔥 Eliminar registros relacionados existentes
              $bitacora->molienda()->delete();
              $bitacora->segundaDestilacion()->delete();

              // ✅ Insertar molienda (si hay)
              foreach ($request->input('molienda', []) as $fila) {
                  BitacoraProcesoMoliendaDestilacion::create([
                      'id_bitacora'         => $bitacora->id,
                      'fecha_molienda'      => $fila['fecha_molienda'],
                      'numero_tina'         => $fila['numero_tina'],
                      'fecha_formulacion'   => $fila['fecha_formulacion'],
                      'volumen_formulacion' => $fila['volumen_formulacion'],
                      'fecha_destilacion'   => $fila['fecha_destilacion'],
                      'puntas_volumen'      => $fila['puntas_volumen'],
                      'puntas_porcentaje'   => $fila['puntas_alcohol'],
                      'mezcal_volumen'      => $fila['mezcal_volumen'],
                      'mezcal_porcentaje'   => $fila['mezcal_alcohol'],
                      'colas_volumen'       => $fila['colas_volumen'],
                      'colas_porcentaje'    => $fila['colas_alcohol'],
                  ]);
              }

              // ✅ Insertar segunda destilación (si hay)
              foreach ($request->input('segunda_destilacion', []) as $fila) {
                  BitacoraProcesoSegundaDestilacion::create([
                      'id_bitacora'        => $bitacora->id,
                      'fecha_destilacion'  => $fila['fecha_destilacion'],
                      'puntas_volumen'     => $fila['puntas_volumen'],
                      'puntas_porcentaje'  => $fila['puntas_alcohol'],
                      'mezcal_volumen'     => $fila['mezcal_volumen'],
                      'mezcal_porcentaje'  => $fila['mezcal_alcohol'],
                      'colas_volumen'      => $fila['colas_volumen'],
                      'colas_porcentaje'   => $fila['colas_alcohol'],
                  ]);
              }

              DB::commit();
              return response()->json(['success' => 'Bitácora actualizada correctamente']);
          } catch (\Throwable $e) {
              DB::rollBack();
              Log::error('Error al actualizar bitácora: ' . $e->getMessage());
              return response()->json(['error' => 'Ocurrió un error al actualizar la bitácora'], 500);
          }
      }


}
