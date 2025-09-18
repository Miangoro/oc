<?php

namespace App\Http\Controllers\bitacoras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BitacoraHologramas;
use App\Models\lotes_envasado;
use App\Models\User;
use App\Models\empresa;
use App\Models\maquiladores_model;
use App\Models\instalaciones;
use Carbon\Carbon;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class BitacoraHologramasComercializadorController extends Controller
{
        public function UserManagement()
    {
        $bitacora = BitacoraHologramas::all();
/*         $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get(); */
        /* if (Auth::check() && Auth::user()->tipo == 3) {
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
      $instalacionesIds = Auth::user()->id_instalacion ?? [];
      $instalacionesUsuario = instalaciones::whereIn('id_instalacion', $instalacionesIds)->get();
        return view('bitacoras.find_BitacoraHologramasComercializador_view', compact('bitacora', 'empresas', 'tipo_usuario',  'instalacionesIds','instalacionesUsuario'));
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
      $instalacionId = $request->input('instalacion');
      DB::statement("SET lc_time_names = 'es_ES'");//Forzar idioma español para meses

        $columns = [
            1 => 'id',
            2 => 'fecha',
            3 => 'id_lote_envasado',
        ];

        $empresaIdAut = null;
          if (Auth::check() && Auth::user()->tipo == 3) {
              $empresaIdAut = Auth::user()->empresa?->id_empresa;
          }
        $instalacionAuth = [];
        if (Auth::check() && Auth::user()->tipo == 3) {
            $instalacionAuth = (array) Auth::user()->id_instalacion; // cast a array
            $instalacionAuth = array_filter(array_map('intval', $instalacionAuth), fn($id) => $id > 0);

            // Si el usuario tipo 3 no tiene instalaciones, devolver vacío
            if (empty($instalacionAuth)) {
                return response()->json([
                    'draw' => intval($request->input('draw')),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'code' => 200,
                    'data' => []
                ]);
            }
        }
        $search = $request->input('search.value');
        $totalData = BitacoraHologramas::where('tipo', 3)->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')] ?? 'id';
        $dir = $request->input('order.0.dir') ?? 'desc';
        /* $query = BitacoraHologramas::query()->when($empresaIdAut, function ($query) use ($empresaIdAut) {
                  $query->where('id_empresa', $empresaIdAut);
              })->where('tipo', 3); */
              $query = BitacoraHologramas::query()->where('tipo', 3);
            // Si el usuario autenticado es tipo 3, obtener su empresa y maquiladores
            $idsEmpresas = $this->obtenerEmpresasVisibles($empresaIdAut, $empresaId);
            if (count($idsEmpresas)) {
                $query->whereIn('id_empresa', $idsEmpresas);
            }

         if (Auth::check() && Auth::user()->tipo == 3 && !empty($instalacionAuth)) {
            $query->whereIn('id_instalacion', $instalacionAuth);
        }
        if ($empresaId) {
            $query->where('id_empresa', $empresaId);
        }
       if ($instalacionId) {
          $query->where('id_instalacion', $instalacionId);
        }
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
                      ->orWhere('id_lote_envasado', 'LIKE', "%{$search}%")
                      ->orWhere('serie_inicial', 'LIKE', "%{$search}%")
                      ->orWhere('num_sellos_inicial', 'LIKE', "%{$search}%")
                      ->orWhere('serie_entrada', 'LIKE', "%{$search}%")
                      ->orWhere('num_sellos_entrada', 'LIKE', "%{$search}%")
                      ->orWhere('serie_salidas', 'LIKE', "%{$search}%")
                      ->orWhere('num_sellos_salidas', 'LIKE', "%{$search}%")
                      ->orWhere('serie_final', 'LIKE', "%{$search}%")
                      ->orWhere('num_sellos_final', 'LIKE', "%{$search}%")
                      ->orWhere('observaciones', 'LIKE', "%{$search}%")
                      ->orWhere(function ($date) use ($search) {
                       $date->whereRaw("DATE_FORMAT(fecha, '%d de %M del %Y') LIKE ?", ["%$search%"]); })
                      ->orWhereHas('empresaBitacora', function ($sub) use ($search) {
                          $sub->where('razon_social', 'LIKE', "%{$search}%");
                      })->orWhereHas('loteBitacora', function ($sub) use ($search) {
                          $sub->where('nombre', 'LIKE', "%{$search}%");
                      })->orWhereHas('instalacion', function ($sub) use ($search) {
                          $sub->where('direccion_completa', 'LIKE', "%{$search}%");
                              });
                  }
              });

              $totalFiltered = $filteredQuery->count();
          } else {
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
                 'id_instalacion' => $bitacora->instalacion->direccion_completa ?? 'N/A',
                //
                'serie_inicial' => $bitacora->serie_inicial,
                'nombre_lote' => $bitacora->loteBitacora->nombre ?? 'N/A',
                'folio_fq' => $bitacora->loteBitacora->folio_fq ?? 'N/A',
                'folio_certificado' => $bitacora->loteBitacora->folio_certificado ?? 'N/A',
                'num_sellos_inicial' => $bitacora->num_sellos_inicial ?? 'N/A',
/*                 'volumen_inicial' => $bitacora->volumen_inicial ?? 'N/A',
                'alcohol_inicial' => $bitacora->alcohol_inicial ?? 'N/A', */
                //Entradas
                'serie_entrada' => $bitacora->serie_entrada ?? 'N/A',
                'num_sellos_entrada' => $bitacora->num_sellos_entrada ?? 'N/A',
                'id_firmante' => $bitacora->id_firmante ?? 'N/A',
                // Salidas
                'serie_salidas' => $bitacora->serie_salidas ?? 'N/A',
                'num_sellos_salidas' => $bitacora->num_sellos_salidas ?? 'N/A',
                'tipo_operacion' => $bitacora->tipo_operacion ?? 'N/A',
                // Inventario final
                'serie_final' => $bitacora->serie_final ?? 'N/A',
                'num_sellos_final' => $bitacora->num_sellos_final ?? 'N/A',
                /* 'num_sellos_merma' => $bitacora->num_sellos_merma ?? 'N/A', */
              'serie_merma' => $bitacora->serie_merma,
                'observaciones' => $bitacora->observaciones ?? 'N/A',
                'firma_ui' => $bitacora->firma_ui ?? 'N/A',

                'mermas' => $bitacora->num_sellos_merma ?? 'N/A',
                'id_usuario_registro'=> $bitacora->registro->name ?? 'N/A',
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

     public function PDFBitacoraHologramas(Request $request)
    {
        $user = Auth::user();
        $instalacionId = $request->query('instalacion');
        $empresaId = $request->query('empresa');
        $empresaSeleccionada = empresa::with('empresaNumClientes')->find($empresaId);
        $title = 'COMERCIALIZADOR'; // Cambia a 'Envasador' si es necesario
        $idsEmpresas = [$empresaId];
        if ($empresaId) {
            $idsMaquiladores = maquiladores_model::where('id_maquiladora', $empresaId)
                ->pluck('id_maquilador')
                ->toArray();

            if (count($idsMaquiladores)) {
                $idsEmpresas = array_merge([$empresaId], $idsMaquiladores);
            }
        }
        $idsInstalaciones = $user->id_instalacion ?? [];
        if ($user->tipo === 3 && empty($idsInstalaciones)) {
                  return response()->json([
                      'message' => 'El usuario no tiene instalaciones asignadas.'
                  ], 403);
          }
      if ($instalacionId) {
           $idsInstalaciones = [intval($instalacionId)];
          }
        $bitacoras = BitacoraHologramas::with([
            'empresaBitacora.empresaNumClientes',
            'firmante',
            'loteBitacora.marca',
            'loteBitacora.lotes_envasado_granel.loteGranel.categoria',
            'loteBitacora.lotes_envasado_granel.loteGranel.clase',             // <-- asegúrate de esto
        ])
        ->where('tipo', 3)
        /* inicio */
        ->when($empresaId, function ($query) use ($idsEmpresas) {
              $query->whereIn('id_empresa', $idsEmpresas);
          })
          ->when(!empty($idsInstalaciones), function ($query) use ($idsInstalaciones) {
        $query->whereIn('id_instalacion', $idsInstalaciones);
    })
          /* fin */

        /* ->when($empresaId, function ($query) use ($empresaId) {
            $query->where('id_empresa', $empresaId);
        }) */
        ->orderBy('id', 'desc')
        ->get();
        /* $empresaPadre = null;
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
        $pdf = Pdf::loadView('pdfs.Bitacora_Hologramas', compact('bitacoras', 'title', 'empresaSeleccionada'))
            ->setPaper([0, 0, 1190.55, 1681.75], 'landscape');
        return $pdf->stream('Bitácora de control de hologramas de comercializador.pdf');
    }


    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'id_empresa' => 'required|integer|exists:empresa,id_empresa',
            'id_instalacion' => 'nullable|integer',
            'id_lote_envasado' => 'required|integer|exists:lotes_envasado,id_lote_envasado',
            'tipo_operacion' => 'required|string',
            'serie_inicial' => 'nullable|string',
            'num_sellos_inicial' => 'nullable|string',
            'serie_entrada'=> 'nullable|string',
            'num_sellos_entrada' => 'nullable|string',
            'serie_salida' => 'nullable|string' ,
            'num_sellos_salida' => 'nullable|string',
            'serie_final' => 'required|string',
            'num_sellos_final' => 'required|string',
            'serie_merma' => 'nullable|string',
            'num_sellos_merma' => 'nullable|string',
            'observaciones' => 'nullable|string|',
        ]);

        try {
            $bitacora = new BitacoraHologramas();
            $bitacora->fecha = $request->fecha;
            $bitacora->id_empresa = $request->id_empresa;
            $bitacora->id_instalacion = $request->id_instalacion ?? 0;
            $bitacora->id_lote_envasado = $request->id_lote_envasado;
            $bitacora->tipo_operacion = $request->tipo_operacion;
            $bitacora->tipo = 3;
            $bitacora->serie_inicial = $request->serie_inicial ?? 0;
            $bitacora->num_sellos_inicial = $request->num_sellosl_inicial ?? 0;
            $bitacora->serie_entrada  = $request->serie_entrada ?? 0;
            $bitacora->num_sellos_entrada  = $request->num_sellos_entrada ?? 0;
            $bitacora->serie_salidas = $request->serie_salida ?? 0;
            $bitacora->num_sellos_salidas = $request->num_sellos_salida ?? 0;
            $bitacora->serie_final = $request->serie_final;
            $bitacora->num_sellos_final = $request->num_sellos_final;
            $bitacora->serie_merma = $request->serie_merma ?? 0;
            $bitacora->num_sellos_merma = $request->num_sellos_merma ?? 0;
            $bitacora->observaciones = $request->observaciones;
            $bitacora->id_usuario_registro = auth()->id();

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
        $bitacora = BitacoraHologramas::find($id_bitacora);

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
            $bitacora = BitacoraHologramas::findOrFail($id_bitacora);
            $fecha_formateada = Carbon::parse($bitacora->fecha)->format('Y-m-d');
            return response()->json([
                'success' => true,
                'bitacora' => [
                    'id' => $bitacora->id,
                    'id_empresa' => $bitacora->id_empresa,
                    'id_instalacion' => $bitacora->id_instalacion,
                    'fecha' => $fecha_formateada, // para que el input date lo acepte
                    'id_lote_envasado' => $bitacora->id_lote_envasado,
                    'serie_inicial'    =>     $bitacora->serie_inicial,
                    'num_sellos_inicial'   =>     $bitacora->num_sellos_inicial,
                    'tipo_operacion' => $bitacora->tipo_operacion,
                    'serie_entrada'   =>    $bitacora->serie_entrada,
                    'num_sellos_entrada'  =>     $bitacora->num_sellos_entrada,
                    'serie_salida' => $bitacora->serie_salidas,
                    'num_sellos_salida' => $bitacora->num_sellos_salidas,
                    'serie_final' => $bitacora->serie_final,
                    'num_sellos_final' => $bitacora->num_sellos_final,
                    'serie_merma' => $bitacora->serie_merma,
                    'num_sellos_merma' => $bitacora->num_sellos_merma,
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
              'edit_bitacora_id' => 'required|exists:bitacora_hologramas,id',
              'id_empresa'       => 'required|exists:empresa,id_empresa',
              'id_lote_envasado' => 'required|integer|exists:lotes_envasado,id_lote_envasado',
              'id_instalacion' => 'required|integer',
              'tipo_operacion' => 'required|string',
              'serie_inicial' => 'nullable|string',
              'num_sellos_inicial' => 'nullable|string',
              'serie_entrada'=> 'nullable|string',
              'num_sellos_entrada' => 'nullable|string',
              'serie_salida' => 'nullable|string' ,
              'num_sellos_salida' => 'nullable|string',
              'serie_final' => 'required|string',
              'num_sellos_final' => 'required|string',
              'serie_merma' => 'nullable|string',
              'num_sellos_merma' => 'nullable|string',
              'observaciones'    => 'nullable|string',
          ]);

          $bitacora = BitacoraHologramas::findOrFail($id_bitacora);

          $bitacora->update([
              'id_empresa'       => $request->id_empresa,
              'id_lote_envasado'   => $request->id_lote_envasado,
              'id_instalacion'   => $request->id_instalacion,
              'fecha'            => $request->fecha,
              'tipo' => 3,
              'tipo_operacion' => $request->tipo_operacion,
              'serie_inicial' => $request->serie_inicial ?? 0,
              'num_sellos_inicial' => $request->num_sellos_inicial ?? 0,
              'serie_entrada'=> $request->serie_entrada ?? 0,
              'num_sellos_entrada' => $request->num_sellos_entrada ?? 0,
              'serie_salidas'   => $request->serie_salida ?? 0,
              'num_sellos_salidas'   => $request->num_sellos_salida ?? 0,
              'serie_final'    => $request->serie_final ?? 0,
              'num_sellos_final'    => $request->num_sellos_final ?? 0,
              'serie_merma' => $request->serie_merma ?? 0,
              'num_sellos_merma' => $request->num_sellos_merma ?? 0,
              'observaciones'    => $request->observaciones,
              'id_usuario_registro' => auth()->id(),
          ]);

          return response()->json(['success' => 'Bitácora actualizada correctamente.']);
      }

      public function firmarBitacora($id_bitacora)
      {
        try {
          $bitacora = BitacoraHologramas::findOrFail($id_bitacora);
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
