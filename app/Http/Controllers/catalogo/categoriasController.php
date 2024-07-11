<?php
namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\categorias;

class categoriasController extends Controller
{
    public function UserManagement()
    {
        $empresas = categorias::all();
        $userCount = $empresas->count();
        $verified = 5;
        $notVerified = 10;
        $usersUnique = $empresas->unique(['CATEGORIA']);
        $userDuplicates = 40;

        return view('categorias.categorias_view', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_categoria',
            2 => 'categoria'
        ];

        $search = [];

        $totalData = categorias::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = categorias::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = categorias::where('id_categoria', 'LIKE', "%{$search}%")
                ->orWhere('categoria', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = categorias::where('id_categoria', 'LIKE', "%{$search}%")
                ->orWhere('categoria', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id_categoria'] = $user->id_categoria;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['categoria'] = $user->categoria;

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
public function destroy($id_categoria)
{
    $clase = categorias::findOrFail($id_categoria);
    $clase->delete();

    return response()->json(['success' => 'Clase eliminada correctamente']);
}

//funcion para agregar registro

}
