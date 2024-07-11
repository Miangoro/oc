<?php

namespace App\Http\Controllers\catalago_clase;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\clases;

class ClaseController extends Controller
{
    
    public function UserManagement()
    {
        $empresas = clases::all();
        $userCount = $empresas->count();
        $verified = 5;
        $notVerified = 10;
        $usersUnique = $empresas->unique(['clases']);
        $userDuplicates = 40;

        return view('catalago_clases.Catalago_Clases', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_clase',
            2 => 'clase'
        ];

        $search = [];

        $totalData = clases::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = clases::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = clases::where('id_clase', 'LIKE', "%{$search}%")
                ->orWhere('clase', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = clases::where('id_clase', 'LIKE', "%{$search}%")
                ->orWhere('clase', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id_clase'] = $user->id_clase; // Ajusta el nombre de la columna según tu base de datos
                $nestedData['fake_id'] = ++$ids;
                $nestedData['clase'] = $user->clase; // Ajusta el nombre de la columna según tu base de datos

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


        //funcion para eliminar
        public function destroy($id_clase)
        {
            $clase = clases::findOrFail($id_clase);
            $clase->delete();

            return response()->json(['success' => 'Clase eliminada correctamente']);
        }

                //funcion para crear
                public function store(Request $request)
                {
                    $request->validate([
                        'clase' => 'required|string|max:255',
                    ]);
                
                    $clase = new Clase();
                    $clase->clase = $request->input('clase');
                    $clase->save();
                
                    return response()->json(['success' => 'Clase agregada correctamente']);
                }
}
