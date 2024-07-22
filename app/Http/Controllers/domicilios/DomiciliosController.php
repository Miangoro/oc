<?php

namespace App\Http\Controllers\domicilios;

use App\Http\Controllers\Controller;
use App\Models\Instalaciones;
use App\Models\Empresa;
use Illuminate\Http\Request;

class DomiciliosController extends Controller
{

  public function UserManagement()
  {
    $instalaciones = Instalaciones::all(); // Obtener todas las instalaciones

    return view('domicilios.find_domicilio_instalaciones_view', compact('instalaciones'));
  }

  public function index(Request $request)
  {
    $columns = [
      1 => 'id_instalacion',
      2 => 'razon_social',
      3 => 'tipo',
      4 => 'estado',
      5 => 'direccion_completa',
     
    ];

    $search = [];


    $totalData = Instalaciones::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = Instalaciones::with('empresa')
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $users = Instalaciones::with('empresa')
        ->where('id_instalacion', 'LIKE', "%{$search}%")
        ->orWhere('direccion_completa', 'LIKE', "%{$search}%")
        ->orWhere('estado', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = Instalaciones::with('empresa')->where('id_instalacion', 'LIKE', "%{$search}%")
        ->orWhere('direccion_completa', 'LIKE', "%{$search}%")
        ->orWhere('estado', 'LIKE', "%{$search}%")
        ->count();
    }

    $data = [];

    if (!empty($users)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($users as $user) {
        $nestedData['id_instalacion'] = $user->id_instalacion;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['razon_social'] = $user->razon_social;
        $nestedData['tipo'] = $user->tipo;
        $nestedData['estado'] = $user->estado;
        $nestedData['direccion_completa'] = $user->direccion_completa;
        
       

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
