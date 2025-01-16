<?php

namespace App\Http\Controllers\Tramite_impi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\Impi;


class impiController extends Controller
{

    public function UserManagement()
    {
      $tramites = Impi::all();
      return view('Tramite_impi.find_impi', compact('tramites'));
    }

    // Método para mostrar la vista principal de trámites
    public function index(Request $request)
    {
        $columns = [
        //CAMPOS PARA ORDENAR LA TABLA DE INICIO "thead"
            /*1 => 'id_impi',
            2 => 'folio',
            3 => 'tramite',
            4 => 'fecha_solicitud',
            5 => 'cliente',
            6 => 'contrasena',
            7 => 'pago',
            8 => 'estatus',
            9 => 'observaciones'*/
            1 => 'folio',
            2 => 'tramite',
            3 => 'fecha_solicitud',
            4 => 'cliente',
            5 => 'contrasena',
            6 => 'pago',
            7 => 'estatus',
            8 => 'observaciones'
        ];
        $search = [];


      $totalData = Impi::count();
      $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    $search1 = $request->input('search.value');

      if (empty($request->input('search.value'))) {
        //$users = Impi::where("nombre", 2)->offset($start)
        $impi = Impi::where('id_impi', 'LIKE', "%{$request->input('search.value')}%")

        ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();
      } else {
        $search = $request->input('search.value');
  
        $impi = Impi::where('id_impi', 'LIKE', "%{$search}%")
          ->where("nombre", 1)
          ->orWhere('tramite', 'LIKE', "%{$search}%")
  
          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();
  
        $totalFiltered = Impi::where('id_impi', 'LIKE', "%{$search}%")
          ->where("nombre", 1)
          ->orWhere('tramite', 'LIKE', "%{$search}%")
          ->count();
      }
      $data = [];



        if (!empty($impi)) {
            $ids = $start;

            foreach ($impi as $impi) {
            //MANDA LOS DATOS AL JS
                //$nestedData['fake_id'] = ++$ids;
                $nestedData['id_impi'] = $impi->id_impi;
                $nestedData['folio'] = $impi->folio;
                $nestedData['tramite'] = $impi->tramite;
                $nestedData['fecha'] = $impi->fecha_solicitud;
                $nestedData['cliente'] = $impi->cliente;
                $nestedData['contrasena'] = $impi->contrasena;
                $nestedData['pago'] = $impi->pago;
                $nestedData['estatus'] = $impi->estatus;
                $nestedData['obs'] = $impi->observaciones;

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


      /*
        $var = new Impi();
        //$var->folio = $request->folio;
        $var->tramite = $request->tramite;
        $var->fecha_solicitud = $request->fecha_solicitud;
        $var->cliente = $request->cliente;
        $var->contrasena = $request->contrasena;
        $var->pago = $request->pago;
        $var->estatus = $request->estatus;
        $var->observaciones = $request->observaciones;
        $var->save();//guardar en BD
        */
    // Función para agregar registro
    public function store(Request $request)
    {
        /*$request->validate([
            'contrasena' => 'string|max:255',
            'pago' => 'string|max:255',
        ]);*/

        try {
            $var = new Impi();
            $var->contrasena = $request->contrasena;
            $var->pago = $request->pago;

            $var->save();//guardar en BD

            return response()->json(['success' => 'Registro agregada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al agregar'], 500);
        }
    }



//FUNCION PARA LLENAR EL FORMULARIO
public function edit($id_impi)
{
    try {
        $var1 = Impi::findOrFail($id_impi);

        //return response()->json($var1);
        return response()->json([
            'id_impi' => $var1->id_impi,
            'tramite' => $var1->tramite,
            'fecha_solicitud' => $var1->fecha_solicitud,
            'cliente' => $var1->cliente,
            'contrasena' => $var1->contrasena,
            'pago' => $var1->pago,
            'estatus' => $var1->estatus,
            'observaciones' => $var1->observaciones,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener el controller'], 500);
    }
}

//FUNCION PARA EDITAR
public function update(Request $request, $id_impi) 
{
    try {
        $var2 = Impi::findOrFail($id_impi);
        $var2->id_impi = $request->id_impi;
        $var2->tramite = $request->tramite;
        $var2->fecha_solicitud = $request->fecha_solicitud;
        $var2->cliente = $request->cliente;
        $var2->contrasena = $request->contrasena;
        $var2->pago = $request->pago;
        $var2->estatus = $request->estatus;
        $var2->observaciones = $request->observaciones;
        $var2->save();

        return response()->json(['success' => 'Editado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al editar'], 500);
    }
}








}//CONTROLLER
