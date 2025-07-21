<?php

namespace App\Http\Controllers\bitacoras;


use App\Models\BitacoraProcesoElaboracion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\empresa;
use App\Models\BitacoraProcesoMoliendaDestilacion;
use App\Models\BitacoraProcesoSegundaDestilacion;
use Carbon\Carbon;
use App\Helpers\Helpers;
use App\Models\tipos;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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
      return view('bitacoras.BitacoraProcesoElaboracion_view', compact('bitacora', 'empresas', 'tipo_usuario', 'tipos'));
  }

  public function index(Request $request)
  {
      $empresaId = $request->input('empresa');
      DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para meses
      $columns = [
          1 => 'id',
          2 => 'fecha_ingreso',
          3 => 'lote_granel'
      ];
        $empresaIdAut = null;
          if (Auth::check() && Auth::user()->tipo == 3) {
              $empresaIdAut = Auth::user()->empresa?->id_empresa;
          }

      $search = [];
      $totalData = BitacoraProcesoElaboracion::count(); // Cambiado por el modelo correcto
      $totalFiltered = $totalData;

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');

        $query = BitacoraProcesoElaboracion::query()->when($empresaIdAut, function ($query) use ($empresaIdAut) {
                  $query->where('id_empresa', $empresaIdAut);
              });

        if ($empresaId) {
            $query->where('id_empresa', $empresaId);
        }

      if (empty($request->input('search.value'))) {
          $users = BitacoraProcesoElaboracion::offset($start)
              ->limit($limit)
              ->orderBy($order, $dir)
              ->get();
      } else {
          $search = $request->input('search.value');

          $users = $query->where(function ($q) use ($search) {
              $q->where('id', 'LIKE', "%{$search}%")
                ->orWhere('fecha_ingreso', 'LIKE', "%{$search}%");
          })
          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();

          $totalFiltered = $query->where(function ($q) use ($search) {
          $q->where('id', 'LIKE', "%{$search}%")
            ->orWhere('fecha_ingreso', 'LIKE', "%{$search}%");
      })->count();
      }

      $data = [];

      if (!empty($users)) {
          $ids = $start;
          foreach ($users as $bitacora) {
              $nestedData = [];
              $nestedData['id'] = $bitacora->id ?? 'N/A';
              $nestedData['fake_id'] = ++$ids; // ← ¡Aquí está tu índice visible!
              $nestedData['fecha_ingreso'] = Helpers::formatearFecha($bitacora->fecha_ingreso);
              $nestedData['nombre_cliente'] = $bitacora->empresaBitacora->razon_social ?? 'Sin razón social';
              $nestedData['id_empresa'] = $bitacora->id_empresa ?? 'N/A';
              $nestedData['numero_tapada'] = $bitacora->numero_tapada ?? 'N/A';
              $nestedData['lote_granel'] = $bitacora->lote_granel ?? 'N/A';
              $nestedData['id_firmante'] = $bitacora->id_firmante ?? 'N/A';
              $nestedData['numero_guia'] = $bitacora->numero_guia ?? 'N/A';
              $nestedData['tipo_maguey'] = $bitacora->tipo_maguey ?? 'N/A';
              $nestedData['numero_pinas'] = $bitacora->numero_pinas ?? 'N/A';
              $nestedData['kg_maguey'] = $bitacora->kg_maguey ?? 'N/A';
              $nestedData['observaciones'] = $bitacora->observaciones ?? 'N/A';
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
              'code' => 500,
              'data' => [],
          ]);
      }
  }


      public function PDFBitacoraProcesoElab(Request $request)
      {
          $empresaId = $request->query('empresa');
          $title = 'PRODUCTOR';

          $bitacoras = BitacoraProcesoElaboracion::with([
              'empresaBitacora.empresaNumClientes',
              'firmante',
          ])
          ->when($empresaId, function ($query) use ($empresaId) {
              $query->where('id_empresa', $empresaId);
          })
          ->orderBy('fecha_ingreso', 'desc')
          ->get();

          if ($bitacoras->isEmpty()) {
              return response()->json([
                  'message' => 'No hay registros de bitácora para los filtros seleccionados.'
              ], 404);
          }

          $pdf = Pdf::loadView('pdfs.Bitacora_Productor', compact('bitacoras', 'title'))
              ->setPaper([0, 0, 1190.55, 1681.75], 'landscape');

          return $pdf->stream('Bitácora PROCESO DE ELABORACIÓN DE MEZCAL.pdf');
      }


      public function store(Request $request)
      {
          $request->validate([
              'fecha_ingreso'           => 'required|date',
              'id_empresa'              => 'required|integer|exists:empresa,id_empresa',
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
              'volumen_total_formulado'=> 'required|numeric|min:0',
              'puntas_volumen'         => 'required|numeric|min:0',
              'puntas_alcohol'         => 'required|numeric|min:0|max:100',
              'mezcal_volumen'         => 'required|numeric|min:0',
              'mezcal_alcohol'         => 'required|numeric|min:0|max:100',
              'colas_volumen'          => 'required|numeric|min:0',
              'colas_alcohol'          => 'required|numeric|min:0|max:100',
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
              ]);
              // Guardar molienda
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
              // Guardar segunda destilación
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

      public function firmarBitacora($id_bitacora)
      {
        try {
          $bitacora = BitacoraMezcal::findOrFail($id_bitacora);
          // Solo usuarios tipo 2 pueden firmar
          if (auth()->user()->tipo === 2) {
              $bitacora->id_firmante = auth()->id();
              $bitacora->save();
              return response()->json(['message' => 'Bitácora firmada correctamente.']);
          }
          return response()->json(['message' => 'No tienes permiso para firmar esta bitácora.'], 403);
          }catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Error al firmar la bitácora.'], 500);
          }
      }

      public function update(Request $request, $id_bitacora)
      {
          $request->validate([
              'fecha_ingreso'           => 'required|date',
              'id_empresa'              => 'required|integer|exists:empresa,id_empresa',
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
              'volumen_total_formulado'=> 'required|numeric|min:0',
              'puntas_volumen'         => 'required|numeric|min:0',
              'puntas_alcohol'         => 'required|numeric|min:0|max:100',
              'mezcal_volumen'         => 'required|numeric|min:0',
              'mezcal_alcohol'         => 'required|numeric|min:0|max:100',
              'colas_volumen'          => 'required|numeric|min:0',
              'colas_alcohol'          => 'required|numeric|min:0|max:100',
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
