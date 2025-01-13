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
        //$tramites = Impi::all();
        return view('Tramite_impi.impi');
    }

    // Método para mostrar la vista principal de trámites
    public function index(Request $request)
    {
        $columns = [
        //CAMPOS PARA ORDENAR LA TABLA DE INICIO "thead"
            1 => 'id_impi',
            2 => 'folio',
            3 => 'tramite',
            4 => 'nombre',
        ];

        $search = [];
        
        $totalData = Impi::count();

        $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = Impi::count()
      ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
        //BUSCADOR
            $search = $request->input('search.value');
      
            $users = Impi::count('id', 'LIKE', "%{$search}%")
              ->orWhere('folio', 'LIKE', "%{$search}%")
              ->orWhere('tramite', 'LIKE', "%{$search}%")
              ->offset($start)
              ->limit($limit)
              ->orderBy($order, $dir)
              ->get();
      
            $totalFiltered = Impi::count('id', 'LIKE', "%{$search}%")
              ->orWhere('folio', 'LIKE', "%{$search}%")
              ->orWhere('tramite', 'LIKE', "%{$search}%")
      
              ->count();
          }

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
            //MANDA LOS DATOS AL JS
                //$nestedData['fake_id'] = ++$ids;
                $nestedData['id_impi'] = $user->id_impi;
                $nestedData['folio'] = $user->folio;
                $nestedData['tramite'] = $user->tramite;
                $nestedData['nombre'] = $user->nombre;
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
    public function create()
    {
        return view('tramites_impi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_tramite' => 'required|string|max:255',
            'numero_solicitud' => 'required|string|max:255',
            'estado' => 'required|string|in:pendiente,en_proceso,finalizado',
            'fecha_solicitud' => 'required|date',
        ]);

        Impi::create($request->all());

        return redirect()->route('tramites_impi.index');
    }

    public function show($id)
    {
        $tramite = Impi::findOrFail($id);
        return view('tramites_impi.show', compact('tramite'));
    }

    public function edit($id)
    {
        $tramite = Impi::findOrFail($id);
        return view('tramites_impi.edit', compact('tramite'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_tramite' => 'required|string|max:255',
            'numero_solicitud' => 'required|string|max:255',
            'estado' => 'required|string|in:pendiente,en_proceso,finalizado',
            'fecha_solicitud' => 'required|date',
        ]);

        $tramite = Impi::findOrFail($id);
        $tramite->update($request->all());

        return redirect()->route('tramites_impi.index');
    }

    public function destroy($id)
    {
        $tramite = Impi::findOrFail($id);
        $tramite->delete();

        return redirect()->route('tramites_impi.index');
    }
*/


}///CONTROLLER
