<?php

namespace App\Http\Controllers\bitacoras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\BitacoraMezcal;
use App\Helpers\Helpers;
use Barryvdh\DomPDF\Facade\Pdf;

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
            1 => 'id',
            2 => 'fecha',
            3 => 'lote_a_granel',
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
                    ->orWhere('lote_a_granel', 'LIKE', "%{$search}%");
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
                'id' => $bitacora->id,
                'lote_a_granel' => $bitacora->lote_a_granel ?? 'N/A',

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

    public function PDFBitacoraMezcal() {
        $bitacoras = BitacoraMezcal::with('loteBitacora')->orderBy('fecha', 'desc')->get();
        $pdf = Pdf::loadView('pdfs.Bitacora_Mezcal', compact('bitacoras'))
        ->setPaper('a4', 'landscape');
          return $pdf->stream('Bitácora Mezcal a Granel.pdf');
    }
}
