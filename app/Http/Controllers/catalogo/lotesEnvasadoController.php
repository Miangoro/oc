<?php

namespace App\Http\Controllers\catalogo;

use App\Models\lotes_envasado;
use App\Models\empresa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class lotesEnvasadoController extends Controller
{
    public function UserManagement()
    {
      
        $lotes_envasado = lotes_envasado::all();
        $userCount = $lotes_envasado->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('catalogo.find_lotes_envasados', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_lote_envasado', 
            2 => 'id_empresa',
            3 => 'nombre_lote',
            4 => 'tipo_lote',
            5 => 'sku',
            6 => 'id_marca',
            7 => 'destino_lote',
            8 => 'cant_botellas',
            9 => 'presentacion',
            10 => 'unidad',
            11 => 'volumen_total',
            12 => 'lugar_envasado',
            
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'id_lote_envasado';
        $dir = $request->input('order.0.dir');

        $searchValue = $request->input('search.value');

        $query = lotes_envasado::with('empresa');

        if (!empty($searchValue)) {
            $query->where(function($q) use ($searchValue) {
                $q->where('id_empresa', 'LIKE', "%{$searchValue}%")
                  ->orWhere('nombre_lote', 'LIKE', "%{$searchValue}%")
                  ->orWhere('cant_botellas', 'LIKE', "%{$searchValue}%");
            });
        }

        $totalData = lotes_envasado::count();
        $totalFiltered = $query->count();

        $users = $query->offset($start)
                       ->limit($limit)
                       ->orderBy($order, $dir)
                       ->get();

        $data = [];

        if ($users->isNotEmpty()) {
            $ids = $start;

            foreach ($users as $user) {
                $nestedData = [
                    'id_lote_envasado' => $user->id_lote_envasado,
                    'fake_id' => ++$ids,
                    'id_empresa' => $user->id_empresa,
                    'razon_social' => $user->empresa ? $user->empresa->razon_social : '',
                    'tipo_lote' => $user->tipo_lote,
                    'nombre_lote' => $user->nombre_lote,
                    'cant_botellas' => $user->cant_botellas,
                ];

                $data[] = $nestedData;
            }
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
    }
}
