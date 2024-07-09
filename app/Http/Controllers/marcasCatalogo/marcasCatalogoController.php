<?php

namespace App\Http\Controllers\marcasCatalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\marcas;


class marcasCatalogoController extends Controller
{
  
    public function index2()
    {
        return view('solicitudes.solicitudCliente');
    }

  public function RegistroExitoso()
  {
    return view('solicitudes.Registro_exitoso');
  }

  public function registrar(Request $request)
  {

    $empresa = new marcas();
    $empresa->folio = $request->folio;
    $empresa->marca = $request->marca;
    $empresa->save();
    $id_marca = $empresa->id_marca;





    return view('solicitudes.Registro_exitoso');
  }

  public function UserManagement()
  {
    // dd('UserManagement');
    $marcas = marcas::all();
    $userCount = $marcas->count();
    $verified = 5;
    $notVerified = 10;
    $userDuplicates = 40;

    return view('clientesMarcas.find_catalago_marcas', [
      'totalUser' => $userCount,
      'verified' => $verified,
      'notVerified' => $notVerified,
      'userDuplicates' => $userDuplicates,
    ]);
  }


  public function index(Request $request)
  {
    $columns = [
      1 => 'id_marca',
      2 => 'folio',
      3 => 'marca',
      4 => 'id_empresa',
    ];

    $search = [];

    $totalData = marcas::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = marcas::offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $users = marcas::where('id_marca', 'LIKE', "%{$search}%")
        ->orWhere('folio', 'LIKE', "%{$search}%")
        ->orWhere('marca', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = marcas::where('id_marca', 'LIKE', "%{$search}%")
        ->orWhere('folio', 'LIKE', "%{$search}%")
        ->orWhere('marca', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($users)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($users as $user) {
        $nestedData['id_marca'] = $user->id_marca;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['folio'] = $user->folio;
        $nestedData['marca'] = $user->marca;

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
