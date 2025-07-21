<?php

namespace App\Http\Controllers\bitacoras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\BitacoraMezcal;
use App\Models\empresa;
use Carbon\Carbon;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class BitacoraPTComController extends Controller
{
     public function UserManagement()
    {
        $bitacora = BitacoraMezcal::all();
/*         $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get(); */
            if (Auth::check() && Auth::user()->tipo == 3) {
        $empresaIdA = Auth::user()->empresa?->id_empresa;
        $empresas = empresa::with('empresaNumClientes')->where('id_empresa', $empresaIdA)->get();
          } else {
              $empresas = empresa::with('empresaNumClientes')
                  ->where('tipo', 2)
                  ->get();
          }
      $tipo_usuario =  Auth::user()->tipo;
        return view('bitacoras.BitacoraProductoTerminadoCom_view', compact('bitacora', 'empresas', 'tipo_usuario'));

    }

    public function index(Request $request)
    {
      $empresaId = $request->input('empresa');
      $instalacionId = $request->input('instalacion');
      DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para meses

        $columns = [
            1 => 'id',
            2 => 'fecha',
            3 => 'id_lote_granel',
        ];

        $empresaIdAut = null;
          if (Auth::check() && Auth::user()->tipo == 3) {
              $empresaIdAut = Auth::user()->empresa?->id_empresa;
          }

        $search = $request->input('search.value');
        $totalData = BitacoraMezcal::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')] ?? 'fecha';
        $dir = $request->input('order.0.dir');

        $query = BitacoraMezcal::query()->when($empresaIdAut, function ($query) use ($empresaIdAut) {
                  $query->where('id_empresa', $empresaIdAut);
              })->where('tipo', 1);

        if ($empresaId) {
            $query->where('id_empresa', $empresaId);

            if ($instalacionId) {
                $query->where('id_instalacion', $instalacionId);
            }
        }
          if (!empty($search)) {
              $query->where(function ($q) use ($search) {
                  $lower = strtolower($search);

                  if ($lower === 'firmado') {
                      $q->whereNotNull('id_firmante')->where('id_firmante', '<>', 0);
                  } elseif ($lower === 'sin firmar') {
                      $q->where(function ($sub) {
                          $sub->whereNull('id_firmante')->orWhere('id_firmante', 0);
                      });
                  } else {

                    $q->where('fecha', 'LIKE', "%{$search}%")
                      ->orWhere('id_lote_granel', 'LIKE', "%{$search}%")
                      ->orWhere('procedencia_entrada', 'LIKE', "%{$search}%")
                      ->orWhere('destino_salidas', 'LIKE', "%{$search}%")
                      ->orWhere('operacion_adicional', 'LIKE', "%{$search}%")
                      ->orWhere('volumen_inicial', 'LIKE', "%{$search}%")
                      ->orWhere('alcohol_inicial', 'LIKE', "%{$search}%")
                      ->orWhere('volumen_entrada', 'LIKE', "%{$search}%")
                      ->orWhere('alcohol_entrada', 'LIKE', "%{$search}%")
                      ->orWhere('volumen_salidas', 'LIKE', "%{$search}%")
                      ->orWhere('alcohol_salidas', 'LIKE', "%{$search}%")
                      ->orWhere('volumen_final', 'LIKE', "%{$search}%")
                      ->orWhere('alcohol_final', 'LIKE', "%{$search}%")
                      ->orWhere(function ($date) use ($search) {
                       $date->whereRaw("DATE_FORMAT(fecha, '%d de %M del %Y') LIKE ?", ["%$search%"]); })
                      ->orWhereHas('empresaBitacora', function ($sub) use ($search) {
                          $sub->where('razon_social', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('loteBitacora', function ($sub) use ($search) {
                          $sub->where('nombre_lote', 'LIKE', "%{$search}%")
                              ->orWhere('folio_fq', 'LIKE', "%{$search}%")
                              ->orWhere('folio_certificado', 'LIKE', "%{$search}%");
                      });
                  }
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
          $razonSocial = $bitacora->empresaBitacora->razon_social ?? 'Sin razón social';
           $numeroCliente = null;
                if ($bitacora->empresaBitacora && $bitacora->empresaBitacora->empresaNumClientes) {
                    $clientes = $bitacora->empresaBitacora->empresaNumClientes;
                    foreach ([0, 1, 2] as $index) {
                        if (isset($clientes[$index]) && !empty($clientes[$index]->numero_cliente)) {
                            $numeroCliente = $clientes[$index]->numero_cliente;
                            break;
                        }
                    }
                }
                $numeroCliente = $numeroCliente ?? 'Sin número cliente';

            $nestedData = [
                'fake_id' => $counter++,
                'fecha' => Helpers::formatearFecha($bitacora->fecha),
                'id' => $bitacora->id,
                //numero de cliente
                'razon_social' => $razonSocial,
                'numero_cliente' => $numeroCliente,
                'cliente' => '<b>' . $numeroCliente . '</b><br>' . $razonSocial,
                //
                'nombre_lote' => $bitacora->loteBitacora->nombre_lote ?? 'N/A',
                'folio_fq' => $bitacora->loteBitacora->folio_fq ?? 'N/A',
                'folio_certificado' => $bitacora->loteBitacora->folio_certificado ?? 'N/A',
/*                 'volumen_inicial' => $bitacora->volumen_inicial ?? 'N/A',
                'alcohol_inicial' => $bitacora->alcohol_inicial ?? 'N/A', */

                //Entradas
                'procedencia_entrada' => $bitacora->procedencia_entrada ?? 'N/A',
                'volumen_entrada' => $bitacora->volumen_entrada ?? 'N/A',
                'alcohol_entrada' => $bitacora->alcohol_entrada ?? 'N/A',
                'agua_entrada' => $bitacora->agua_entrada ?? 'N/A',
                'id_firmante' => $bitacora->id_firmante ?? 'N/A',
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

     public function PDFBitacoraMezcal(Request $request)
    {
        $empresaId = $request->query('empresa');
        $instalacionId = $request->query('instalacion');
        $title = 'PRODUCTOR'; // Cambia a 'Envasador' si es necesario
        $bitacoras = BitacoraMezcal::with([
            'empresaBitacora.empresaNumClientes',
            'firmante',
        ])->where('tipo', 1)
        ->when($empresaId, function ($query) use ($empresaId, $instalacionId) {
            $query->where('id_empresa', $empresaId);
            if ($instalacionId) {
                $query->where('id_instalacion', $instalacionId);
            }
        })
        ->orderBy('fecha', 'desc')
        ->get();

          if ($bitacoras->isEmpty()) {
              return response()->json([
                  'message' => 'No hay registros de bitácora para los filtros seleccionados.'
              ], 404);
          }
        $pdf = Pdf::loadView('pdfs.Bitacora_Mezcal', compact('bitacoras', 'title'))
            ->setPaper([0, 0, 1190.55, 1681.75], 'landscape');

        return $pdf->stream('Bitácora Mezcal a Granel.pdf');
    }


    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'id_empresa' => 'required|integer|exists:empresa,id_empresa',
            'id_lote_granel' => 'required|integer|exists:lotes_granel,id_lote_granel',
            'id_instalacion' => 'required|integer',
            'operacion_adicional' => 'nullable|string',
            'tipo_operacion' => 'required|string',
            'volumen_inicial' => 'nullable|numeric|min:0',
            'alcohol_inicial' => 'nullable|numeric|min:0',
            'procedencia_entrada' => 'nullable|string',
            'volumen_entrada'=> 'nullable|numeric|min:0',
            'alcohol_entrada' => 'nullable|numeric|min:0',
            'agua_entrada' => 'nullable|numeric|min:0',
            'volumen_salida' => 'nullable|numeric|min:0' ,
            'alc_vol_salida' => 'nullable|numeric|min:0',
            'destino' => 'nullable|string|max:255',
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
            $bitacora->tipo_operacion = $request->tipo_operacion;
            $bitacora->tipo = 1;
            $bitacora->operacion_adicional = $request->operacion_adicional;
            $bitacora->volumen_inicial = $request->volumen_inicial;
            $bitacora->alcohol_inicial = $request->alcohol_inicial;
            $bitacora->procedencia_entrada  = $request->procedencia_entrada ?? 0;
            $bitacora->volumen_entrada  = $request->volumen_entrada ?? 0;
            $bitacora->alcohol_entrada  = $request->alcohol_entrada ?? 0;
            $bitacora->agua_entrada  = $request->agua_entrada ?? 0;
            $bitacora->volumen_salidas = $request->volumen_salida ?? 0;
            $bitacora->alcohol_salidas = $request->alc_vol_salida ?? 0;
            $bitacora->destino_salidas = $request->destino ?? 0;
            $bitacora->volumen_final = $request->volumen_final;
            $bitacora->alcohol_final = $request->alc_vol_final;
            $bitacora->observaciones = $request->observaciones;

            $bitacora->save();

            return response()->json(['success' => 'Bitácora registrada correctamente']);
        } catch (\Exception $e) {
          /*   Log::error('Error al registrar bitácora: ' . $e->getMessage()); */
          /*   return response()->json(['error' => 'Error al registrar la bitácora'], 500); */
          return response()->json(['error' => $e->getMessage()], 500);

        }
    }
    public function destroy($id_bitacora)
    {
        $bitacora = BitacoraMezcal::find($id_bitacora);

        if (!$bitacora) {
            return response()->json([
                'error' => 'Bitácora no encontrada.'
            ], 404);
        }

        $bitacora->delete();

        return response()->json([
            'success' => 'Bitácora eliminada correctamente.'
        ]);
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
                    'operacion_adicional' => $bitacora->operacion_adicional,
                    'volumen_inicial'    =>     $bitacora->volumen_inicial,
                    'alcohol_inicial'   =>     $bitacora->alcohol_inicial,
                    'tipo_operacion' => $bitacora->tipo_operacion,
                    'procedencia_entrada'  =>     $bitacora->procedencia_entrada,
                    'volumen_entrada'   =>    $bitacora->volumen_entrada,
                    'alcohol_entrada'  =>     $bitacora->alcohol_entrada,
                    'agua_entrada' => $bitacora->agua_entrada,
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
              'id_lote_granel' => 'required|integer|exists:lotes_granel,id_lote_granel',
              'id_instalacion' => 'required|integer',
              'operacion_adicional' => 'nullable|string',
              'tipo_operacion' => 'required|string',
              'volumen_inicial' => 'nullable|numeric|min:0',
              'alcohol_inicial' => 'nullable|numeric|min:0',
              'procedencia_entrada' => 'nullable|string',
              'volumen_entrada'=> 'nullable|numeric|min:0',
              'alcohol_entrada' => 'nullable|numeric|min:0',
              'agua_entrada' => 'nullable|numeric|min:0',
              'volumen_salida' => 'nullable|numeric|min:0' ,
              'alc_vol_salida' => 'nullable|numeric|min:0',
              'destino' => 'nullable|string|max:255',
              'volumen_final' => 'required|numeric|',
              'alc_vol_final' => 'required|numeric|',
              'observaciones'    => 'nullable|string',
          ]);

          $bitacora = BitacoraMezcal::findOrFail($id_bitacora);

          $bitacora->update([
              'id_empresa'       => $request->id_empresa,
              'id_lote_granel'   => $request->id_lote_granel,
              'id_instalacion'   => $request->id_instalacion,
              'fecha'            => $request->fecha,
              'operacion_adicional' => $request->operacion_adicional,
              'tipo' => 1,
              'tipo_operacion' => $request->tipo_operacion,
              'volumen_inicial' => $request->volumen_inicial,
              'alcohol_inicial' => $request->alcohol_inicial ,
              'procedencia_entrada' => $request->procedencia_entrada ?? 0,
              'volumen_entrada'=> $request->volumen_entrada ?? 0,
              'alcohol_entrada' => $request->alcohol_entrada ?? 0,
              'agua_entrada' => $request->agua_entrada ?? 0,
              'volumen_salidas'   => $request->volumen_salida ?? 0,
              'alcohol_salidas'   => $request->alc_vol_salida ?? 0,
              'destino_salidas'  => $request->destino ?? 0,
              'volumen_final'    => $request->volumen_final,
              'alcohol_final'    => $request->alc_vol_final,
              'observaciones'    => $request->observaciones,
          ]);

          return response()->json(['success' => 'Bitácora actualizada correctamente.']);
      }

      public function firmarBitacora($id_bitacora)
      {
        try {
          $bitacora = BitacoraMezcal::findOrFail($id_bitacora);
          // Solo usuarios tipo 2 pueden firmar
          if (auth()->user()->tipo === 2) {
              $bitacora->id_firmante = auth()->id();
              $bitacora->save();
              return response()->json(['message' => 'Bitácora firmada correctamente.']);
          }
          return response()->json(['message' => 'No tienes permiso para firmar esta bitácora.'], 403);
          }catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Error al firmar la bitácora.'], 500);
          }
      }

}
