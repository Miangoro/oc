<?php
namespace App\Http\Controllers\hologramas;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use APP\Models\Hologramas;
use App\Models\empresa;


class solicitudHologramaController extends Controller
{
    public function UserManagement()
    {
        $Hologramas = Hologramas::all();
        $empresa = Empresa::where('tipo', 2)->get();
        $userCount = $Hologramas->count();
        $verified = 5;
        $notVerified = 10;
/*         $usersUnique = $empresas->unique(['CATEGORIA']);
 */      $userDuplicates = 40;

        return view('hologramas.find_solicitud_hologramas', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'empresa' => $empresa,
            'Hologramas' => $Hologramas,


        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_solicitud',
            2 => 'folio',
            3 => 'id_empresa',
            4 => 'id_solicitante',
            5 => 'id_marca',
            6 => 'cantidad_hologramas',
            7 => 'id_direccion',
            8 => 'comentarios'
        ];

        $search = [];

        $totalData = Hologramas::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = Hologramas::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = Hologramas::where('id_solicitud', 'LIKE', "%{$search}%")
                ->orWhere('folio', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Hologramas::where('id_solicitud', 'LIKE', "%{$search}%")
                ->orWhere('folio', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if ($users->isNotEmpty()) {
            $ids = $start;

            foreach ($users as $user) {

                $nestedData = [
                    'id_solicitud' => $user->id_solicitud,
                    'folio' => $user->folio,
                    'fake_id' => ++$ids,
                    'razon_social' => $user->empresa ? $user->empresa->razon_social : '',
                    'id_empresa' => $user->id_empresa,
                    'id_solicitante' => $user->id_solicitante,
                    'id_marca' => $user->id_marca,
                    'cantidad_hologramas' => $user->cantidad_hologramas,
                    'id_direccion' => $user->id_direccion,
                    'comentarios' => $user->comentarios,

                    

                ];

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
