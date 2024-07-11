<?php

namespace App\Http\Controllers\marcasCatalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\marcas;
use App\Models\empresa;



class marcasCatalogoController extends Controller
{

  public function store(Request $request)
  {
      $request->validate([
          'cliente' => 'required|exists:empresa,id_empresa',
          'company' => 'required|string|max:60',
          'folio' => 'required|string|max:1',
      ]);
  
      if ($request->id) {
          // Actualizar marca existente
          $marca = marcas::findOrFail($request->id);
          $marca->id_empresa = $request->cliente;
          $marca->marca = $request->company;
          $marca->folio = $request->folio;
          $marca->save();
          return response()->json(['success' => 'Marca actualizada exitosamente.']);
      } else {
          // Crear nueva marca
          $marca = new marcas();
          $marca->id_empresa = $request->cliente;
          $marca->marca = $request->company;
          $marca->folio = $request->folio;
          $marca->save();
          return response()->json(['success' => 'Marca registrada exitosamente.']);
      }
  }
  


  public function marcas()
  {
      $clientes = empresa::where('tipo', 1)->get();
      $opciones = marcas::all();
      return view('clientesMarcas.find_catalago_marcas', compact('opciones', 'clientes'));
  }

  

  
//funcion para eliminar
public function destroy($id_marca)
{
    $clase = marcas::findOrFail($id_marca);
    $clase->delete();

    return response()->json(['success' => 'Clase eliminada correctamente']);
}

  
  /*Crea la solicitud JSEON*/
  public function UserManagement()
  {
    // Obtener listado de clientes (empresas)
    $clientes = Empresa::all(); // Esto depende de cómo tengas configurado tu modelo Empresa

    // Otros datos que puedas querer pasar a la vista
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
        'clientes' => $clientes, // Pasa la lista de clientes a la vista
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
        $nestedData['id_empresa'] = $user->id_empresa;

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
