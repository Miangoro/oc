<?php

namespace App\Http\Controllers\bitacoras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\BitacoraMezcal;
use App\Models\empresa;
use Carbon\Carbon;
use App\Helpers\Helpers;
use Barryvdh\DomPDF\Facade\Pdf;

class BitacoraMezcalController extends Controller
{
    public function UserManagement()
    {
        $bitacora = BitacoraMezcal::all();
        $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get();
        return view('bitacoras.BitacoraMezcal_view', compact('bitacora', 'empresas'));

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

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'id_empresa' => 'required|integer|exists:empresa,id_empresa',
            'id_lote_granel' => 'required|integer|exists:lotes_granel,id_lote_granel',
            'id_instalacion' => 'required|integer',
            'volumen_salida' => 'required|numeric|min:0' ,
            'alc_vol_salida' => 'required|numeric|min:0',
            'destino' => 'required|string|max:255',
            'volumen_final' => 'required|numeric|',
            'alc_vol_final' => 'required|numeric|',
            'observaciones' => 'nullable|string|',
        ]);

        try {
            $bitacora = new BitacoraMezcal();
            $bitacora->fecha = $request->fecha;
            $bitacora->id_empresa = $request->id_empresa;
            $bitacora->id_instalacion = $request->id_instalacion;
            $bitacora->id_lote_granel = $request->id_lote_granel;
            $bitacora->volumen_salidas = $request->volumen_salida;
            $bitacora->alcohol_salidas = $request->alc_vol_salida;
            $bitacora->destino_salidas = $request->destino;
            $bitacora->volumen_final = $request->volumen_final;
            $bitacora->alcohol_final = $request->alc_vol_final;
            $bitacora->observaciones = $request->observaciones;
            $bitacora->save();

            return response()->json(['success' => 'Bitácora registrada correctamente']);
        } catch (\Exception $e) {
            \Log::error('Error al registrar bitácora: ' . $e->getMessage());
            return response()->json(['error' => 'Error al registrar la bitácora'], 500);
        }
    }

    public function edit($id_bitacora)
    {
        try {
            $bitacora = BitacoraMezcal::findOrFail($id_bitacora);
            $fecha_formateada = Carbon::parse($bitacora->fecha)->format('Y-m-d');
            return response()->json([
                'success' => true,
                'bitacora' => [
                    'id' => $bitacora->id,
                    'id_empresa' => $bitacora->id_empresa,
                    'id_instalacion' => $bitacora->id_instalacion,
                    'fecha' => $fecha_formateada, // para que el input date lo acepte
                    'id_lote_granel' => $bitacora->id_lote_granel,
                    'volumen_salida' => $bitacora->volumen_salidas,
                    'alc_vol_salida' => $bitacora->alcohol_salidas,
                    'destino' => $bitacora->destino_salidas,
                    'volumen_final' => $bitacora->volumen_final,
                    'alc_vol_final' => $bitacora->alcohol_final,
                    'observaciones' => $bitacora->observaciones,
                    // agrega otros campos que necesites si existen
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al obtener bitácora para editar: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'No se encontró la bitácora.'], 404);
        }
    }


      public function update(Request $request, $id_bitacora)
      {
       /*  dd($request); */
          $request->validate([
              'edit_bitacora_id' => 'required|exists:bitacora_mezcal,id',
              'id_empresa'       => 'required|exists:empresa,id_empresa',
              'id_lote_granel'   => 'required|exists:lotes_granel,id_lote_granel',
              'id_instalacion'   => 'required|integer',
              'fecha'            => 'required|date',
              'volumen_salida'   => 'required|numeric|min:0',
              'alc_vol_salida'   => 'required|numeric|min:0',
              'destino'          => 'required|string|max:255',
              'volumen_final'    => 'required|numeric|min:0',
              'alc_vol_final'    => 'required|numeric|min:0',
              'observaciones'    => 'nullable|string',
          ]);

          $bitacora = BitacoraMezcal::findOrFail($id_bitacora);

          $bitacora->update([
              'id_empresa'       => $request->id_empresa,
              'id_lote_granel'   => $request->id_lote_granel,
              'id_instalacion'   => $request->id_instalacion,
              'fecha'            => $request->fecha,
              'volumen_salidas'   => $request->volumen_salida,
              'alcohol_salidas'   => $request->alc_vol_salida,
              'destino_salidas'  => $request->destino,
              'volumen_final'    => $request->volumen_final,
              'alcohol_final'    => $request->alc_vol_final,
              'observaciones'    => $request->observaciones,
          ]);

          return response()->json(['success' => 'Bitácora actualizada correctamente.']);
      }

}
