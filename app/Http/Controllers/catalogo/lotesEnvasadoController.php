<?php

namespace App\Http\Controllers\catalogo;
use App\Models\marcas;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\empresaContrato;
use App\Models\empresaNumCliente;
use App\Models\solicitud_informacion;
use App\Models\User;
//modelos
use App\Models\empresa;
use App\Models\Instalaciones;
use App\Models\lotes_envasado;
use App\Models\lotes_envasado_granel;


use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class lotesEnvasadoController extends Controller
{
  public function UserManagement()
  {
      $lotes_envasado = lotes_envasado::all();
      $userCount = $lotes_envasado->count();
      $verified = 5;
      $notVerified = 10;
      $userDuplicates = 40;

      return view('catalogo.find_lotes_envasados', [
          'totalUser' => $userCount,
          'verified' => $verified,
          'notVerified' => $notVerified,
          'userDuplicates' => $userDuplicates,
      ]);
  }

  public function index(Request $request)
  {
      $columns = [
          1 => 'id_lote_envasado', 
           2 => 'id_empresa',
           3 => 'nombre_lote',
           4 => 'tipo_lote',
           5 => 'sku',
           6 =>  'id_marca',
           7 => 'destino_lote',
           8 =>  'cant_botellas',
           9 =>  'presentacion',
           10 =>  'unidad',
           11 =>  'volumen_total',
           12 =>  'lugar_envasado',
      ];

      $search = [];

      $totalData = lotes_envasado::count();

      $totalFiltered = $totalData;

      $limit = $request->input('length');
      $start = $request->input('start');
      $order = $columns[$request->input('order.0.column')];
      $dir = $request->input('order.0.dir');

      if (empty($request->input('search.value'))) {
          $users = lotes_envasado::with('empresa') // Incluye la relación empresa
              ->offset($start)
              ->limit($limit)
              ->orderBy($order, $dir)
              ->get();
      } else {
          $search = $request->input('search.value');

          $users = lotes_envasado::with('empresa') // Incluye la relación empresa
              ->where('id_empresa', 'LIKE', "%{$search}%")
              ->orWhere('nombre_lote', 'LIKE', "%{$search}%")
              ->orWhere('cant_botellas', 'LIKE', "%{$search}%")
              ->offset($start)
              ->limit($limit)
              ->orderBy($order, $dir)
              ->get();

          $totalFiltered = lotes_envasado::where('id_empresa', 'LIKE', "%{$search}%")
              ->orWhere('nombre_lote', 'LIKE', "%{$search}%")
              ->orWhere('cant_botellas', 'LIKE', "%{$search}%")
              ->count();
      }

      $data = [];

      if (!empty($users)) {
          // providing a dummy id instead of database ids
          $ids = $start;

          foreach ($users as $user) {
              $nestedData['id_lote_envasado'] = $user->id_lote_envasado;
              $nestedData['fake_id'] = ++$ids;
              $nestedData['id_empresa'] = $user->id_empresa;
              $nestedData['razon_social'] = $user->empresa ? $user->empresa->razon_social : ''; // Obtiene la razón social
              $nestedData['tipo_lote'] = $user->tipo_lote;
              $nestedData['nombre_lote'] = $user->nombre_lote;
              $nestedData['cant_botellas'] = $user->cant_botellas;


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

}
