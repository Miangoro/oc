<?php

namespace App\Http\Controllers\clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\empresa;
use Illuminate\Support\Str;

class clientesProspectoController extends Controller
{
    public function UserManagement()
  {
    // dd('UserManagement');
    $empresas = empresa::all();
    $userCount = $empresas->count();
    $verified = 5;
    $notVerified = 10;
    $usersUnique = $empresas->unique(['estado']);
    $userDuplicates = 40;

    return view('clientes.find_clientes_prospecto_view', [
      'totalUser' => $userCount,
      'verified' => $verified,
      'notVerified' => $notVerified,
      'userDuplicates' => $userDuplicates,
    ]);
  }
  public function index(Request $request)
  {
    $columns = [
      1 => 'id_empresa',
      2 => 'razon_social',
      3 => 'domicilio_fiscal',
      4 => 'regimen',
    ];

    $search = [];

    $totalData = empresa::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = empresa::offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $users = empresa::where('id_empresa', 'LIKE', "%{$search}%")
        ->orWhere('razon_social', 'LIKE', "%{$search}%")
        ->orWhere('domicilio_fiscal', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = empresa::where('id_empresa', 'LIKE', "%{$search}%")
        ->orWhere('razon_social', 'LIKE', "%{$search}%")
        ->orWhere('domicilio_fiscal', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($users)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($users as $user) {
        $nestedData['id_empresa'] = $user->id_empresa;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['razon_social'] = $user->razon_social;
        $nestedData['domicilio_fiscal'] = $user->domicilio_fiscal;
        $nestedData['regimen'] = $user->regimen;

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
