<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\equipos;


class catalagoEquiposController extends Controller
{
    public function UserManagement()
    {
        $equipos = equipos::all();
        $userCount = $equipos->count();
        $verified = 5;
        $notVerified = 10;
        $usersUnique = $equipos->unique(['EQUIPO']);
        $userDuplicates = 40;

        return view('catalogo.find_catalogo_equipos', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_equipo',
            2 => 'equipo'
        ];

        $search = [];

        $totalData = equipos::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = equipos::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = equipos::where('id_equipo', 'LIKE', "%{$search}%")
                ->orWhere('equipo', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = equipos::where('id_equipo', 'LIKE', "%{$search}%")
                ->orWhere('equipo', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id_equipo'] = $user->id_equipo;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['equipo'] = $user->equipo;

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

//eliminar registro
public function destroy($id_equipo)
{
    $clase = equipos::findOrFail($id_equipo);
    $clase->delete();

    return response()->json(['success' => 'Clase eliminada correctamente']);
}



//funcion para agregar registro
public function store(Request $request)
{
    $request->validate([
        'equipo' => 'required|string|max:255',
    ]);

    $equipo = new equipos();
    $equipo->equipo = $request->equipo;
    $equipo->save();

    return response()->json(['success' => 'Categoría agregada correctamente']);
}


}
