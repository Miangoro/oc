<?php

namespace App\Http\Controllers\bitacoras;


use App\Models\BitacoraProcesoElaboracion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\empresa;
use Carbon\Carbon;
use App\Helpers\Helpers;
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
      $tipo_usuario =  Auth::user()->tipo;
      return view('Bitacoras.BitacoraProcesoElaboracion_view', compact('bitacora', 'empresas', 'tipo_usuario'));
  }

  public function index(Request $request)
  {
      $empresaId = $request->input('empresa');
      DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para meses
      $columns = [
          1 => 'id',
          2 => 'fecha_ingreso',
          3 => 'id_lote_granel'
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

          $users = BitacoraProcesoElaboracion::where('id_bitacora_elaboracion', 'LIKE', "%{$search}%")
              ->orWhere('fecha_ingreso', 'LIKE', "%{$search}%")
              ->offset($start)
              ->limit($limit)
              ->orderBy($order, $dir)
              ->get();

          $totalFiltered = BitacoraProcesoElaboracion::where('id_bitacora_elaboracion', 'LIKE', "%{$search}%")
              ->orWhere('fecha_ingreso', 'LIKE', "%{$search}%")
              ->count();
      }

      $data = [];

      if (!empty($users)) {
          $ids = $start;
          foreach ($users as $bitacora) {
              $nestedData = [];

              $nestedData['fake_id'] = ++$ids; // ← ¡Aquí está tu índice visible!
              $nestedData['fecha_ingreso'] = Helpers::formatearFecha($bitacora->fecha_ingreso);
              $nestedData['nombre_cliente'] = $bitacora->empresaBitacora->razon_social ?? 'Sin razón social';
              $nestedData['numero_tapada'] = $bitacora->numero_tapada ?? 'N/A';
              $nestedData['lote_granel'] = $bitacora->loteBitacora->nombre_lote ?? 'N/A';
              $nestedData['numero_guia'] = $bitacora->numero_guia ?? 'N/A';
              $nestedData['tipo_maguey'] = $bitacora->tipo_maguey ?? 'N/A';
              $nestedData['numero_pinas'] = $bitacora->numero_pinas ?? 'N/A';
              $nestedData['kg_maguey'] = $bitacora->kg_maguey ?? 'N/A';
              $nestedData['observaciones'] = $bitacora->observaciones ?? 'N/A';

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

}
