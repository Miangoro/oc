<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tipos;


class tiposController extends Controller
{

  public function UserManagement()
    {
        $todos = Tipos::all(); // Obtener todos los datos
        return view('catalogo.tipos_view', compact('todos'));
    }


    public function index(Request $request)
    {
        $columns = [
            1 => 'id_tipo',
            2 => 'nombre',
            3 => 'cientifico',
        ];

        $search = [];
        
        $totalData = Tipos::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = Tipos::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = Tipos::where('id_tipo', 'LIKE', "%{$search}%")
                ->orWhere('nombre', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Tipos::where('id_tipo', 'LIKE', "%{$search}%")
                ->orWhere('nombre', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id_tipo'] = $user->id_tipo;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['nombre'] = $user->nombre;
                $nestedData['cientifico'] = $user->cientifico;

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




    // Función para eliminar una clase
    public function destroy($id_tipo)
    {
        try {
            $clase = clases::findOrFail($id_tipo);
            $clase->delete();

            return response()->json(['success' => 'Clase eliminada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la clase'], 500);
        }
    }



}
