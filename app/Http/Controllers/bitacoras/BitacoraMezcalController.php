<?php

namespace App\Http\Controllers\Bitacoras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BitacoraMezcal;
use App\Helpers\Helpers;

class BitacoraMezcalController extends Controller
{
    public function UserManagement()
    {
        $bitacora = BitacoraMezcal::all();
        return view('bitacoras.BitacoraMezcal_view', compact('bitacora'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'fecha',
            2 => 'id_tanque',
            3 => 'lote_a_granel',
            4 => 'operacion_adicional',
            5 => 'categoria',
        ];

        $search = $request->input('search.value');
        $totalData = BitacoraMezcal::count(); 
        $totalFiltered = $totalData; 

        $limit = $request->input('length'); 
        $start = $request->input('start'); 
        $order = $columns[$request->input('order.0.column')] ?? 'fecha'; 
        $dir = $request->input('order.0.dir');
        $query = BitacoraMezcal::query();

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('fecha', 'LIKE', "%{$search}%")
                    ->orWhere('id_tanque', 'LIKE', "%{$search}%")
                    ->orWhere('lote_a_granel', 'LIKE', "%{$search}%")
                    ->orWhere('operacion_adicional', 'LIKE', "%{$search}%")
                    ->orWhere('categoria', 'LIKE', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }

        $bitacoras = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];
        $counter = $start + 1;

        foreach ($bitacoras as $bitacora) {
            $nestedData = [
                'fake_id' => $counter++,
                'fecha' => Helpers::formatearFecha($bitacora->fecha),
                'id_tanque' => $bitacora->id_tanque ?? 'N/A',
                'lote_a_granel' => $bitacora->lote_a_granel ?? 'N/A',
                'operacion_adicional' => $bitacora->operacion_adicional ?? 'N/A',
                'categoria' => $bitacora->categoria ?? 'N/A',
                'clase' => $bitacora->clase ?? 'N/A',
                'ingredientes' => $bitacora->ingredientes ?? 'N/A',
                'edad' => $bitacora->edad ?? 'N/A', 
                'tipo_agave' => $bitacora->tipo_agave ?? 'N/A',
                'num_analisis' => $bitacora->num_analisis ?? 'N/A', 
                'num_certificado' => $bitacora->num_certificado ?? 'N/A',
                
                // Inventario inicial
                'volumen_inicial' => $bitacora->volumen_inicial ?? 'N/A',
                'alcohol_inicial' => $bitacora->alcohol_inicial ?? 'N/A',
        
                // Entrada
                'procedencia_entrada' => $bitacora->procedencia_entrada ?? 'N/A',
                'volumen_entrada' => $bitacora->volumen_entrada ?? 'N/A',
                'alcohol_entrada' => $bitacora->alcohol_entrada ?? 'N/A',
                'agua_entrada' => $bitacora->agua_entrada ?? 'N/A',
        
                // Salidas
                'volumen_salidas' => $bitacora->volumen_salidas ?? 'N/A',
                'alcohol_salidas' => $bitacora->alcohol_salidas ?? 'N/A',
                'destino_salidas' => $bitacora->destino_salidas ?? 'N/A',
        
                // Inventario final
                'volumen_final' => $bitacora->volumen_final ?? 'N/A',
                'alcohol_final' => $bitacora->alcohol_final ?? 'N/A',
        
                'observaciones' => $bitacora->observaciones ?? 'N/A',
                'firma_ui' => $bitacora->firma_ui ?? 'N/A',
            ];
            $data[] = $nestedData;
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
