<?php

namespace App\Http\Controllers\guias;

use App\Models\guias;
//use App\Models\empresa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class guiasController extends Controller
{
    public function UserManagement()
    {
      
        $guias = guias::all();
        $userCount = $guias->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('Guias.find_guias_maguey_agave', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_guia', 
            2 => 'Folio',
            3 => 'id_empresa',

            
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'id_guia';
        $dir = $request->input('order.0.dir');

        $searchValue = $request->input('search.value');

        $query = guias::with('empresa');

        if (!empty($searchValue)) {
            $query->where(function($q) use ($searchValue) {
                $q->where('id_guia', 'LIKE', "%{$searchValue}%")
                  ->orWhere('Folio', 'LIKE', "%{$searchValue}%")
                  ->orWhere('id_empresa', 'LIKE', "%{$searchValue}%");
            });
        }

        $totalData = guias::count();
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
                    'id_guia' => $user->id_guia,
                    'fake_id' => ++$ids,
                    'Folio' => $user->Folio,
                    //'razon_social' => $user->empresa ? $user->empresa->razon_social : '',
                    'id_empresa' => $user->id_empresa,

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