<?php

namespace App\Http\Controllers\bitacoras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\BitacoraMezcal;
use App\Models\User;
use App\Models\clases;
use App\Models\marcas;
use App\Models\categorias;
use App\Models\BitacoraProductoTerminado;
use App\Models\empresa;
use Carbon\Carbon;
use App\Models\tipos;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class BitacoraPTComController extends Controller
{
     public function UserManagement()
    {
        $bitacora = BitacoraProductoTerminado::all();
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
        $tipos = tipos::all();
        $clases = clases::all();
        $marcas = marcas::all();
        $categorias = categorias::all();
        return view('bitacoras.BitacoraProductoTerminadoCom_view', compact('bitacora', 'empresas', 'tipo_usuario', 'tipos', 'clases', 'marcas', 'categorias'));

    }

    public function index(Request $request)
    {
      $empresaId = $request->input('empresa');

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
        /* $totalData = BitacoraProductoTerminado::count(); */
        $totalData = BitacoraProductoTerminado::where('tipo', 3)->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')] ?? 'fecha';
        $dir = $request->input('order.0.dir');

        $query = BitacoraProductoTerminado::query()->when($empresaIdAut, function ($query) use ($empresaIdAut) {
                  $query->where('id_empresa', $empresaIdAut);
              })->where('tipo', 3);

        if ($empresaId) {
            $query->where('id_empresa', $empresaId);

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
                  // Datos generales
                'tipo_operacion' => $bitacora->tipo_operacion ?? 'N/A',
                'tipo' => $bitacora->tipo ?? 'N/A',
                'lote_granel' => $bitacora->lote_granel ?? 'N/A',
                'lote_envasado' => $bitacora->lote_envasado ?? 'N/A',
                'proforma_predio' => $bitacora->proforma_predio ?? 'N/A',
                'folio_fq' => $bitacora->folio_fq ?? 'N/A',
                'alc_vol' => $bitacora->alc_vol ?? 'N/A',
                'sku' => $bitacora->sku ?? 'N/A',
                'cantidad_botellas_cajas' => $bitacora->cantidad_botellas_cajas ?? 'N/A',
                'ingredientes' => $bitacora->ingredientes ?? 'N/A',
                'edad' => $bitacora->edad ?? 'N/A',

                // Inventario inicial
                'cant_cajas_inicial' => $bitacora->cant_cajas_inicial ?? 'N/A',
                'cant_bot_inicial' => $bitacora->cant_bot_inicial ?? 'N/A',

                // Entradas
                'procedencia_entrada' => $bitacora->procedencia_entrada ?? 'N/A',
                'cant_cajas_entrada' => $bitacora->cant_cajas_entrada ?? 'N/A',
                'cant_bot_entrada' => $bitacora->cant_bot_entrada ?? 'N/A',

                // Salidas
                'destino_salidas' => $bitacora->destino_salidas ?? 'N/A',
                'cant_cajas_salidas' => $bitacora->cant_cajas_salidas ?? 'N/A',
                'cant_bot_salidas' => $bitacora->cant_bot_salidas ?? 'N/A',

                // Inventario final
                'cant_cajas_final' => $bitacora->cant_cajas_final ?? 'N/A',
                'cant_bot_final' => $bitacora->cant_bot_final ?? 'N/A',

                // Extras
                'observaciones' => $bitacora->observaciones ?? 'N/A',
                'id_firmante' => $bitacora->id_firmante ?? 'N/A',


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

     public function PDFBitacoraPTCom(Request $request)
    {
        $empresaId = $request->query('empresa');
        $instalacionId = $request->query('instalacion');
        $title = 'COMERCIALIZADOR'; // Cambia a 'Envasador' si es necesario
        $bitacoras = BitacoraProductoTerminado::with([
            'empresaBitacora.empresaNumClientes',
            'firmante',
            'marca',
            'categorias',
            'clases',
        ])->where('tipo', 3)
        ->when($empresaId, function ($query) use ($empresaId, $instalacionId) {
            $query->where('id_empresa', $empresaId);
            if ($instalacionId) {
                $query->where('id_instalacion', $instalacionId);
            }
        })
        ->orderBy('id', 'desc')
        ->get();

          if ($bitacoras->isEmpty()) {
              return response()->json([
                  'message' => 'No hay registros de bitácora para los filtros seleccionados.'
              ], 404);
          }
        $pdf = Pdf::loadView('pdfs.Bitacora_Terminado', compact('bitacoras', 'title'))
            ->setPaper([0, 0, 1190.55, 1681.75], 'landscape');

        return $pdf->stream('Bitácora de inventario de producto terminado.pdf');
    }


public function store(Request $request)
{
    $request->validate([
        'fecha' => 'required|date',
        'id_empresa' => 'required|integer|exists:empresa,id_empresa',
        'tipo_operacion' => 'required|string',

        'lote_granel' => 'nullable|string',
        'lote_envasado' => 'nullable|string',
        'id_categoria' => 'required|integer|exists:catalogo_categorias,id_categoria',
        'id_clase' => 'required|integer|exists:catalogo_clases,id_clase',
        'proforma_predio' => 'nullable|string',
        'folio_fq' => 'nullable|string',
        'id_tipo' => 'nullable|array',
        'id_tipo.*' => 'integer',
        'alc_vol' => 'nullable|numeric|min:0',
        'sku' => 'nullable|string|max:100',
        'cantidad_botellas_cajas' => 'nullable|numeric|min:0',
        'edad' => 'nullable|string|max:100',
        'ingredientes' => 'nullable|string',
        'id_marca' => 'nullable|integer',
        'cant_cajas_inicial' => 'nullable|numeric|min:0',
        'cant_bot_inicial' => 'nullable|numeric|min:0',

        'procedencia_entrada' => 'nullable|string|max:255',
        'cant_cajas_entrada' => 'nullable|numeric|min:0',
        'cant_bot_entrada' => 'nullable|numeric|min:0',

        'destino_salidas' => 'nullable|string|max:255',
        'cant_cajas_salidas' => 'nullable|numeric|min:0',
        'cant_bot_salidas' => 'nullable|numeric|min:0',

        'cant_cajas_final' => 'required|numeric|min:0',
        'cant_bot_final' => 'required|numeric|min:0',

        'id_solicitante' => 'nullable|string|max:255',
        'capacidad' => 'required|string|max:100',
        'mermas' => 'required|string|max:100',

        'observaciones' => 'nullable|string',
    ]);

    try {
        $bitacora = new BitacoraProductoTerminado();
        $bitacora->fecha = $request->fecha;
        $bitacora->id_empresa = $request->id_empresa;
        $bitacora->tipo_operacion = $request->tipo_operacion;

        $bitacora->lote_granel = $request->lote_granel;
        $bitacora->lote_envasado = $request->lote_envasado;
        $bitacora->id_categoria = $request->id_categoria;
        $bitacora->id_clase = $request->id_clase;
        $bitacora->proforma_predio = $request->proforma_predio;
        $bitacora->folio_fq = $request->folio_fq;
        $bitacora->id_marca = $request->id_marca;
        $bitacora->id_tipo = is_array($request->id_tipo) ? implode(',', $request->id_tipo) : null;
        $bitacora->alc_vol = $request->alc_vol;
        $bitacora->sku = $request->sku;
        $bitacora->cantidad_botellas_cajas = $request->cantidad_botellas_cajas;
        $bitacora->edad = $request->edad;
        $bitacora->ingredientes = $request->ingredientes;
        $bitacora->cant_cajas_inicial = $request->cant_cajas_inicial ?? 0;
        $bitacora->cant_bot_inicial = $request->cant_bot_inicial ?? 0;

        $bitacora->procedencia_entrada = $request->procedencia_entrada ?? 0;
        $bitacora->cant_cajas_entrada = $request->cant_cajas_entrada ?? 0;
        $bitacora->cant_bot_entrada = $request->cant_bot_entrada ?? 0;

        $bitacora->destino_salidas = $request->destino_salidas ?? 0;
        $bitacora->cant_cajas_salidas = $request->cant_cajas_salidas ?? 0;
        $bitacora->cant_bot_salidas = $request->cant_bot_salidas ?? 0;

        $bitacora->cant_cajas_final = $request->cant_cajas_final;
        $bitacora->cant_bot_final = $request->cant_bot_final;

        $bitacora->id_solicitante = $request->id_solicitante;
        $bitacora->capacidad = $request->capacidad;
        $bitacora->mermas = $request->mermas;

        $bitacora->observaciones = $request->observaciones;

        $bitacora->tipo = 3; // Fijo

        $bitacora->save();

        return response()->json(['success' => 'Bitácora registrada correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function destroy($id_bitacora)
    {
        $bitacora = BitacoraProductoTerminado::find($id_bitacora);

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
            $bitacora = BitacoraProductoTerminado::findOrFail($id_bitacora);

            $fecha_formateada = Carbon::parse($bitacora->fecha)->format('Y-m-d');

            return response()->json([
                'success' => true,
                'bitacora' => [
                    'id' => $bitacora->id,
                    'id_empresa' => $bitacora->id_empresa,
                    'tipo_operacion' => $bitacora->tipo_operacion,
                    'tipo' => $bitacora->tipo,
                    'fecha' => $fecha_formateada,
                    'lote_granel' => $bitacora->lote_granel,
                    'lote_envasado' => $bitacora->lote_envasado,
                    'id_marca' => $bitacora->id_marca,
                    'id_categoria' => $bitacora->id_categoria,
                    'id_clase' => $bitacora->id_clase,
                    'proforma_predio' => $bitacora->proforma_predio,
                    'folio_fq' => $bitacora->folio_fq,
                    'id_tipo' => $bitacora->id_tipo,
                    'alc_vol' => $bitacora->alc_vol,
                    'sku' => $bitacora->sku,
                    'cantidad_botellas_cajas' => $bitacora->cantidad_botellas_cajas,
                    'ingredientes' => $bitacora->ingredientes,
                    'edad' => $bitacora->edad,
                    'cant_cajas_inicial' => $bitacora->cant_cajas_inicial,
                    'cant_bot_inicial' => $bitacora->cant_bot_inicial,
                    'procedencia_entrada' => $bitacora->procedencia_entrada,
                    'cant_cajas_entrada' => $bitacora->cant_cajas_entrada,
                    'cant_bot_entrada' => $bitacora->cant_bot_entrada,
                    'destino_salidas' => $bitacora->destino_salidas,
                    'cant_cajas_salidas' => $bitacora->cant_cajas_salidas,
                    'cant_bot_salidas' => $bitacora->cant_bot_salidas,
                    'cant_cajas_final' => $bitacora->cant_cajas_final,
                    'cant_bot_final' => $bitacora->cant_bot_final,
                    'observaciones' => $bitacora->observaciones,
                    'id_solicitante' => $bitacora->id_solicitante,
                    'capacidad' => $bitacora->capacidad,
                    'mermas' => $bitacora->mermas,
                    'id_firmante' => $bitacora->id_firmante,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al obtener bitácora para editar: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'No se encontró la bitácora.'], 404);
        }
    }



    public function update(Request $request, $id_bitacora)
    {
        $request->validate([
            'edit_bitacora_id' => 'required|exists:bitacora_mezcal,id',
            'fecha' => 'required|date',
            'id_empresa' => 'required|integer|exists:empresa,id_empresa',
            'tipo_operacion' => 'required|string',

            'lote_granel' => 'nullable|string',
            'lote_envasado' => 'nullable|string',
            'id_categoria' => 'required|integer|exists:catalogo_categorias,id_categoria',
            'id_clase' => 'required|integer|exists:catalogo_clases,id_clase',
            'id_marca' => 'nullable|integer',
            'proforma_predio' => 'nullable|string',
            'folio_fq' => 'nullable|string',
            'id_tipo' => 'nullable|array',
            'id_tipo.*' => 'integer',
            'alc_vol' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:100',
            'cantidad_botellas_cajas' => 'nullable|numeric|min:0',
            'edad' => 'nullable|string|max:100',
            'ingredientes' => 'nullable|string',

            'cant_cajas_inicial' => 'nullable|numeric|min:0',
            'cant_bot_inicial' => 'nullable|numeric|min:0',

            'procedencia_entrada' => 'nullable|string|max:255',
            'cant_cajas_entrada' => 'nullable|numeric|min:0',
            'cant_bot_entrada' => 'nullable|numeric|min:0',

            'destino_salidas' => 'nullable|string|max:255',
            'cant_cajas_salidas' => 'nullable|numeric|min:0',
            'cant_bot_salidas' => 'nullable|numeric|min:0',

            'cant_cajas_final' => 'required|numeric|min:0',
            'cant_bot_final' => 'required|numeric|min:0',

            'id_solicitante' => 'nullable|string|max:255',
            'capacidad' => 'required|string|max:100',
            'mermas' => 'required|string|max:100',

            'observaciones' => 'nullable|string',
        ]);

        $bitacora = BitacoraProductoTerminado::findOrFail($id_bitacora);

        $bitacora->update([
            'fecha' => $request->fecha,
            'id_empresa' => $request->id_empresa,
            'tipo_operacion' => $request->tipo_operacion,

            'lote_granel' => $request->lote_granel,
            'lote_envasado' => $request->lote_envasado,
            'id_categoria' => $request->id_categoria,
            'id_clase' => $request->id_clase,
            'proforma_predio' => $request->proforma_predio,
            'folio_fq' => $request->folio_fq,
            'id_tipo' => is_array($request->id_tipo) ? implode(',', $request->id_tipo) : null,
            'alc_vol' => $request->alc_vol,
            'sku' => $request->sku,
            'cantidad_botellas_cajas' => $request->cantidad_botellas_cajas,
            'edad' => $request->edad,
            'ingredientes' => $request->ingredientes,
            'id_marca' => $request->id_marca,
            'cant_cajas_inicial' => $request->cant_cajas_inicial ?? 0,
            'cant_bot_inicial' => $request->cant_bot_inicial ?? 0,

            'procedencia_entrada' => $request->procedencia_entrada ?? 0,
            'cant_cajas_entrada' => $request->cant_cajas_entrada ?? 0,
            'cant_bot_entrada' => $request->cant_bot_entrada ?? 0,

            'destino_salidas' => $request->destino_salidas ?? 0,
            'cant_cajas_salidas' => $request->cant_cajas_salidas ?? 0,
            'cant_bot_salidas' => $request->cant_bot_salidas ?? 0,

            'cant_cajas_final' => $request->cant_cajas_final,
            'cant_bot_final' => $request->cant_bot_final,

            'id_solicitante' => $request->id_solicitante,
            'capacidad' => $request->capacidad,
            'mermas' => $request->mermas,

            'observaciones' => $request->observaciones,

            'tipo' => 3, // fijo
        ]);

        return response()->json(['success' => 'Bitácora actualizada correctamente.']);
    }

      public function firmarBitacora($id_bitacora)
      {
        try {
          $bitacora = BitacoraProductoTerminado::findOrFail($id_bitacora);
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
