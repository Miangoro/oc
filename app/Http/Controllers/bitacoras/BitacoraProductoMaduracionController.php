<?php

namespace App\Http\Controllers\bitacoras;

use App\Models\BitacoraProductoMaduracion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\empresa;
use App\Models\maquiladores_model;
use Carbon\Carbon;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class BitacoraProductoMaduracionController extends Controller
{
    public function UserManagement()
    {
        $bitacora = BitacoraProductoMaduracion::all();
/*         $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get(); */
           /*  if (Auth::check() && Auth::user()->tipo == 3) {
        $empresaIdA = Auth::user()->empresa?->id_empresa;
        $empresas = empresa::with('empresaNumClientes')->where('id_empresa', $empresaIdA)->get();
          } else {
              $empresas = empresa::with('empresaNumClientes')
                  ->where('tipo', 2)
                  ->get();
          } */
         $empresaIdAut = Auth::check() && Auth::user()->tipo == 3
        ? Auth::user()->empresa?->id_empresa
        : null;
          if ($empresaIdAut) {
                  // 👇 Usa la función que ya tienes
                  $idsEmpresas = $this->obtenerEmpresasVisibles($empresaIdAut, null);

                  $empresas = empresa::with('empresaNumClientes')
                      ->whereIn('id_empresa', $idsEmpresas)
                      ->get();
              } else {
                  $empresas = empresa::with('empresaNumClientes')
                      ->where('tipo', 2)
                      ->get();
              }
      $tipo_usuario =  Auth::user()->tipo;
        return view('bitacoras.BitacoraProductoMaduracion_view', compact('bitacora', 'empresas', 'tipo_usuario'));

    }
     private function obtenerEmpresasVisibles($empresaIdAut, $empresaId)
      {
          $idsEmpresas = [];
          if ($empresaIdAut) {
              $idsEmpresas[] = $empresaIdAut;
              $idsEmpresas = array_merge($idsEmpresas,
                  maquiladores_model::where('id_maquiladora', $empresaIdAut)->pluck('id_maquilador')->toArray()
              );
          }
          if ($empresaId) {
              $idsEmpresas[] = $empresaId;
              $idsEmpresas = array_merge($idsEmpresas,
                  maquiladores_model::where('id_maquiladora', $empresaId)->pluck('id_maquilador')->toArray()
              );
          }
          return array_unique($idsEmpresas);
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
        /* $totalData = BitacoraMezcal::count(); */
        $totalData = BitacoraProductoMaduracion::where('tipo', 2)->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')]  ?? 'id';
        $dir = $request->input('order.0.dir') ?? 'desc';

        $query = BitacoraProductoMaduracion::query()->where('tipo', 2);
        $idsEmpresas = $this->obtenerEmpresasVisibles($empresaIdAut, $empresaId);
                      if (count($idsEmpresas)) {
                          $query->whereIn('id_empresa', $idsEmpresas);
                      }

        /* $query = BitacoraProductoMaduracion::query()->when($empresaIdAut, function ($query) use ($empresaIdAut) {
                  $query->where('id_empresa', $empresaIdAut);
              })->where('tipo', 2); */

        /* if ($empresaId) {
            $query->where('id_empresa', $empresaId);

            if ($instalacionId) {
                $query->where('id_instalacion', $instalacionId);
            }
        } */
        /* if ($empresaId) {
              $empresa = empresa::find($empresaId);

              if ($empresa) {
                  // Buscar maquiladores hijos en la tabla intermedia
                  $idsMaquiladores = maquiladores_model::where('id_maquiladora', $empresaId)
                  ->pluck('id_maquilador')
                  ->toArray();


                  // Si tiene hijos, se asume maquiladora
                  if (count($idsMaquiladores)) {
                      $idsEmpresas = array_merge([$empresaId], $idsMaquiladores);
                  } else {
                      // Sin hijos, solo su propio ID
                      $idsEmpresas = [$empresaId];
                  }

                  $query->whereIn('id_empresa', $idsEmpresas);
              }
          } */


          $filteredQuery = clone $query;
          if (!empty($search)) {
              $filteredQuery->where(function ($q) use ($search) {
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
                    ->orWhere('volumen_inicial', 'LIKE', "%{$search}%")
                    ->orWhere('alcohol_inicial', 'LIKE', "%{$search}%")
                    ->orWhere('volumen_entrada', 'LIKE', "%{$search}%")
                    ->orWhere('alcohol_entrada', 'LIKE', "%{$search}%")
                    ->orWhere('volumen_salidas', 'LIKE', "%{$search}%")
                    ->orWhere('alcohol_salidas', 'LIKE', "%{$search}%")
                    ->orWhere('volumen_final', 'LIKE', "%{$search}%")
                    ->orWhere('alcohol_final', 'LIKE', "%{$search}%")
                    ->orWhere('num_recipientes_final', 'LIKE', "%{$search}%")
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
              /* $totalFiltered = $query->count(); */
               $totalFiltered = $filteredQuery->count();
          } else{
              $totalFiltered = $filteredQuery->count();
          }

        $bitacoras = $filteredQuery->offset($start)
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
                'volumen_inicial' => $bitacora->volumen_inicial ?? 'N/A',
                'alcohol_inicial' => $bitacora->alcohol_inicial ?? 'N/A',

                  'tipo_recipientes' => $bitacora->tipo_recipientes ?? 'N/A',
                  'tipo_madera' => $bitacora->tipo_madera ?? 'N/A',
                  'num_recipientes' => $bitacora->num_recipientes ?? 'N/A',

                  // Entradas
                  'num_recipientes_entrada' => $bitacora->num_recipientes_entrada ?? 'N/A',
                  'procedencia_entrada' => $bitacora->procedencia_entrada ?? 'N/A',
                  'volumen_entrada' => $bitacora->volumen_entrada ?? 'N/A',
                  'alcohol_entrada' => $bitacora->alcohol_entrada ?? 'N/A',

                  // Salidas
                  'fecha_salida' => Helpers::formatearFecha($bitacora->fecha_salida),
                  'num_recipientes_salida' => $bitacora->num_recipientes_salida ?? 'N/A',
                  'volumen_salidas' => $bitacora->volumen_salidas ?? 'N/A',
                  'alcohol_salidas' => $bitacora->alcohol_salidas ?? 'N/A',
                  'destino_salidas' => $bitacora->destino_salidas ?? 'N/A',

                  // Final
                  'num_recipientes_final' => $bitacora->num_recipientes_final ?? 'N/A',
                  'volumen_final' => $bitacora->volumen_final ?? 'N/A',
                  'alcohol_final' => $bitacora->alcohol_final ?? 'N/A',

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

     public function PDFProductoMaduracion(Request $request)
    {
        $empresaId = $request->query('empresa');
        $empresaSeleccionada = empresa::with('empresaNumClientes')->find($empresaId);
        $title = 'PRODUCTOR'; // Cambia a 'Envasador' si es necesario
        $idsEmpresas = [$empresaId];
        if ($empresaId) {
            $idsMaquiladores = maquiladores_model::where('id_maquiladora', $empresaId)
                ->pluck('id_maquilador')
                ->toArray();

            if (count($idsMaquiladores)) {
                $idsEmpresas = array_merge([$empresaId], $idsMaquiladores);
            }
        }
        $bitacoras = BitacoraProductoMaduracion::with([
            'empresaBitacora.empresaNumClientes',
            'firmante',
            'loteBitacora',
        ])->where('tipo', 2)
         ->when($empresaId, function ($query) use ($idsEmpresas) {
              $query->whereIn('id_empresa', $idsEmpresas);
          })
       /*  ->when($empresaId, function ($query) use ($empresaId) {
            $query->where('id_empresa', $empresaId);
        }) */
        ->orderBy('id', 'desc')
        ->get();
       /*  $empresaPadre = null;
        if ($empresaId) {
            // Ver si la empresa enviada es una maquiladora
            $esMaquiladora = maquiladores_model::where('id_maquilador', $empresaId)->exists();

            if ($esMaquiladora) {
                // Buscar su empresa padre
                $idMaquiladora = maquiladores_model::where('id_maquilador', $empresaId)
                    ->value('id_maquiladora');

                $empresaPadre = empresa::with('empresaNumClientes')->find($idMaquiladora);
            } else {
                // Es empresa padre
                $empresaPadre = empresa::with('empresaNumClientes')->find($empresaId);
            }
        } */
          if ($bitacoras->isEmpty()) {
              return response()->json([
                  'message' => 'No hay registros de bitácora para los filtros seleccionados.'
              ], 404);
          }
        $pdf = Pdf::loadView('pdfs.Bitacora_Maduracion', compact('bitacoras', 'title', 'empresaSeleccionada'))
            ->setPaper([0, 0, 1190.55, 1681.75], 'landscape');
        return $pdf->stream('Bitácora Producto en Maduración.pdf');
    }


    public function store(Request $request)
    {
        $request->validate([
          'fecha' => 'required|date',
          'id_empresa' => 'required|integer|exists:empresa,id_empresa',
          'id_lote_granel' => 'required|integer|exists:lotes_granel,id_lote_granel',
          'tipo_recipientes' => 'nullable|string|max:255',
          'tipo_madera' => 'nullable|string|max:255',
          'num_recipientes' => 'nullable|integer|min:0',
          'num_recipientes_entrada' => 'nullable|integer|min:0',
          'fecha_salida' => 'nullable|date',
          'num_recipientes_salida' => 'nullable|integer|min:0',
          'num_recipientes_final' => 'nullable|integer|min:0',
          'tipo_operacion' => 'required|string',
          'volumen_inicial' => 'nullable|numeric|min:0',
          'alcohol_inicial' => 'nullable|numeric|min:0',
          'procedencia_entrada' => 'nullable|string',
          'volumen_entrada'=> 'nullable|numeric|min:0',
          'alcohol_entrada' => 'nullable|numeric|min:0',
          'volumen_salida' => 'nullable|numeric|min:0',
          'alc_vol_salida' => 'nullable|numeric|min:0',
          'destino' => 'nullable|string|max:255',
          'volumen_final' => 'required|numeric',
          'alc_vol_final' => 'required|numeric',
          'observaciones' => 'nullable|string',
      ]);


       try {
          $bitacora = new BitacoraProductoMaduracion();
          $bitacora->fecha = $request->fecha;
          $bitacora->id_empresa = $request->id_empresa;
          $bitacora->id_lote_granel = $request->id_lote_granel;

          $bitacora->tipo_recipientes = $request->tipo_recipientes;
          $bitacora->tipo_madera = $request->tipo_madera;
          $bitacora->num_recipientes = $request->num_recipientes;
          $bitacora->num_recipientes_entrada = $request->num_recipientes_entrada ?? 0;
          $bitacora->fecha_salida = $request->fecha_salida ?? 0;
          $bitacora->num_recipientes_salida = $request->num_recipientes_salida ?? 0;
          $bitacora->num_recipientes_final = $request->num_recipientes_final;

          $bitacora->tipo_operacion = $request->tipo_operacion;
          $bitacora->tipo = 2;

          $bitacora->volumen_inicial = $request->volumen_inicial;
          $bitacora->alcohol_inicial = $request->alcohol_inicial;
          $bitacora->procedencia_entrada = $request->procedencia_entrada ?? 0;
          $bitacora->volumen_entrada = $request->volumen_entrada ?? 0;
          $bitacora->alcohol_entrada = $request->alcohol_entrada ?? 0;

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
        $bitacora = BitacoraProductoMaduracion::find($id_bitacora);

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
            $bitacora = BitacoraProductoMaduracion::findOrFail($id_bitacora);
            $fecha_formateada = Carbon::parse($bitacora->fecha)->format('Y-m-d');
            $fecha_formateada2 = Carbon::parse($bitacora->fecha_salida)->format('Y-m-d');
            return response()->json([
                'success' => true,
                'bitacora' => [
                    'id' => $bitacora->id,
                    'id_empresa' => $bitacora->id_empresa,

                    'fecha' => $fecha_formateada, // para que el input date lo acepte
                    'id_lote_granel' => $bitacora->id_lote_granel,

                    'tipo_operacion' => $bitacora->tipo_operacion,
                    'tipo' => $bitacora->tipo, // 1=Productor, 2=Envasador, 3=Comercializador

                    'tipo_recipientes' => $bitacora->tipo_recipientes,
                    'tipo_madera' => $bitacora->tipo_madera,
                    'num_recipientes' => $bitacora->num_recipientes,

                    'volumen_inicial' => $bitacora->volumen_inicial,
                    'alcohol_inicial' => $bitacora->alcohol_inicial,

                    'num_recipientes_entrada' => $bitacora->num_recipientes_entrada,
                    'procedencia_entrada' => $bitacora->procedencia_entrada,
                    'volumen_entrada' => $bitacora->volumen_entrada,
                    'alcohol_entrada' => $bitacora->alcohol_entrada,

                    'fecha_salida' => $fecha_formateada2,
                    'num_recipientes_salida' => $bitacora->num_recipientes_salida,
                    'volumen_salidas' => $bitacora->volumen_salidas,
                    'alcohol_salidas' => $bitacora->alcohol_salidas,
                    'destino_salidas' => $bitacora->destino_salidas,

                    'num_recipientes_final' => $bitacora->num_recipientes_final,
                    'volumen_final' => $bitacora->volumen_final,
                    'alcohol_final' => $bitacora->alcohol_final,
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
              'edit_bitacora_id' => 'required|exists:bitacora_maduracion,id',
              'id_empresa'       => 'required|exists:empresa,id_empresa',
              'id_lote_granel' => 'required|integer|exists:lotes_granel,id_lote_granel',
              'operacion_adicional' => 'nullable|string',
              'tipo_operacion' => 'required|string',
              'volumen_inicial' => 'nullable|numeric|min:0',
              'alcohol_inicial' => 'nullable|numeric|min:0',
              'num_recipientes_entrada' => 'nullable|numeric|min:0',
              'num_recipientes' => 'nullable|numeric|min:0',
              'num_recipientes_salida' => 'nullable|numeric|min:0',
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

          $bitacora = BitacoraProductoMaduracion::findOrFail($id_bitacora);

          $bitacora->update([
              'id_empresa'       => $request->id_empresa,
              'id_lote_granel'   => $request->id_lote_granel,
              'fecha'            => $request->fecha,
              'operacion_adicional' => $request->operacion_adicional,
              'tipo' => 2,
              'tipo_operacion' => $request->tipo_operacion,
              'volumen_inicial' => $request->volumen_inicial,
              'alcohol_inicial' => $request->alcohol_inicial ,
              'num_recipientes' => $request->num_recipientes,
              'num_recipientes_entrada' => $request->num_recipientes_entrada ?? 0,
              'num_recipientes_salida' => $request->num_recipientes_salida ?? 0,
              'procedencia_entrada' => $request->procedencia_entrada ?? 0,
              'volumen_entrada'=> $request->volumen_entrada ?? 0,
              'alcohol_entrada' => $request->alcohol_entrada ?? 0,
              'agua_entrada' => $request->agua_entrada ?? 0,
              'volumen_salidas'   => $request->volumen_salida ?? 0,
              'alcohol_salidas'   => $request->alc_vol_salida ?? 0,
              'destino_salidas'  => $request->destino ?? 0,
              'volumen_final'    => $request->volumen_final,
              'alcohol_final'    => $request->alc_vol_final,
              'num_recipientes_final'=> $request->num_recipientes_final ?? 0,
              'observaciones'    => $request->observaciones,
          ]);

          return response()->json(['success' => 'Bitácora actualizada correctamente.']);
      }

      public function firmarBitacora($id_bitacora)
      {
        try {
          $bitacora = BitacoraProductoMaduracion::findOrFail($id_bitacora);
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
