<?php

namespace App\Http\Controllers\catalogo;

use App\Models\lotes_envasado;
use App\Models\empresa;
use App\Models\marcas;
use App\Models\etiquetas;
use App\Models\LotesGranel;
use App\Models\instalaciones;
use App\Http\Controllers\Controller;
use App\Models\lotes_envasado_granel;
use Illuminate\Http\Request;
use App\Models\Documentacion_url;
use App\Models\Dictamen_Envasado;
use App\Models\empresaNumCliente;

use Illuminate\Support\Facades\DB;
use App\Models\BitacoraMezcal;
use App\Models\tipos;
use App\Models\clases;
use App\Models\categorias;
use App\Models\Destinos;
use App\Models\maquiladores_model;
use App\Models\Exception;
//use Exception as GlobalException;
use Illuminate\Support\Facades\Auth;//Permiso empresa


class lotesEnvasadoController extends Controller
{
    public function UserManagement()
    {
       $empresaIdAut = Auth::check() && Auth::user()->tipo == 3
        ? Auth::user()->empresa?->id_empresa
        : null;
          if ($empresaIdAut) {
                  //Usa la función que ya tienes
                  $idsEmpresas = $this->obtenerEmpresasVisibles($empresaIdAut, null);

                  $clientes = empresa::with('empresaNumClientes')
                      ->whereIn('id_empresa', $idsEmpresas)
                      ->get();
              } else {
                  $clientes = empresa::with('empresaNumClientes')
                      ->where('tipo', 2)
                      ->get();
              }
        $marcas = marcas::all();
        $lotes_granel = LotesGranel::all();
        $lotes_envasado = lotes_envasado::all();
        $Instalaciones = instalaciones::all();
        $clases = clases::all();
        $categorias = categorias::all();

        $tipos = tipos::all();
        $marcas = marcas::all();
        $userCount = $lotes_envasado->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('catalogo.find_lotes_envasados', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'clientes' => $clientes,
            'marcas' => $marcas,
            'lotes_granel' => $lotes_granel,
            'lotes_envasado' => $lotes_envasado,
            'Instalaciones' => $Instalaciones,
            'clases' => $clases,
            'categorias' => $categorias,
            'tipos' => $tipos,

        ]);
    }


private function obtenerEmpresasVisibles($empresaId)
{
    $idsEmpresas = [];
    if ($empresaId) {
        $idsEmpresas[] = $empresaId; // Siempre incluye la empresa del usuario
        $idsEmpresas = array_merge(
            $idsEmpresas,
            maquiladores_model::where('id_maquiladora', $empresaId)->pluck('id_maquilador')->toArray()
        );/* id_maquiladora  id_maquilador */
    }

    return array_unique($idsEmpresas);
}

public function index(Request $request)
{
    //Permiso de empresa
    $empresaId = null;
    if (Auth::check() && Auth::user()->tipo == 3) {
        $empresaId = Auth::user()->empresa?->id_empresa;
    }

    $columns = [
        1 => 'id_lote_envasado',
        2 => 'id_empresa',
        3 => 'nombre',
        4 => 'sku',
        5 => 'id_marca',
        6 => 'destino_lote',
        7 => 'cant_botellas',
        8 => 'presentacion',
        9 => 'unidad',
        10 => 'volumen_total',
        11 => 'lugar_envasado',
        12 => 'estatus'
    ];

    $limit = $request->input('length');
    $start = $request->input('start');
    $dir = $request->input('order.0.dir') ?? 'desc';
    $order = $columns[$request->input('order.0.column')] ?? 'id_lote_envasado';
    $search = $request->input('search.value');


        $query = lotes_envasado::with([
                'empresa.empresaNumClientes',
                'marca',
                'Instalaciones',
                'lotes_envasado_granel'
            ]); // Cargar relaciones necesarias

        // Filtro empresa (propia + maquiladores)  SE OCULTO PORQUE YA NO SERA POR MAQUILADOR
        /*if ($empresaId) {
            $empresasVisibles = $this->obtenerEmpresasVisibles($empresaId);
            $query->whereIn('id_empresa', $empresasVisibles);
        }*/
        // Filtro empresa (creadora y destino)
        if ($empresaId) {
            $query->where(function ($q) use ($empresaId) {
                $q->where('id_empresa', $empresaId)
                ->orWhere('id_empresa_destino', $empresaId);
            });
        }

        $baseQuery = clone $query;// Clonamos el query antes de aplicar búsqueda, paginación u ordenamiento
        $totalData = $baseQuery->count();// totalData (sin búsqueda)


    // Búsqueda global
    if (!empty($search)) {
        // Convertir a minúsculas / elimina espacios al inicio y al final
        $searchNormalized = mb_strtolower(trim($search), 'UTF-8');
        // También elimina tildes para mejor comparación
        $searchNormalized = strtr($searchNormalized, [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u'
        ]);

        // Mapeamos posibles búsquedas de texto a su valor numérico
        $estatusMap = [
            //coincidencia a partir de 4 letras
            0 => 'pend',
            1 => 'disp',
            2 => 'agot'
        ];
        // Buscar coincidencia de nombre
        $tipoEstado = null;
        foreach ($estatusMap as $clave => $valor) {
            $valorNormalized = mb_strtolower($valor, 'UTF-8');
            $valorNormalized = strtr($valorNormalized, [
                'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u'
            ]);
            if (strpos($searchNormalized, $valorNormalized) !== false) {
                $tipoEstado = $clave; // guardamos el número, no el nombre
                break;
            }
        }
        
        $query->where(function ($q) use ($search, $tipoEstado) {
            $q->where('destino_lote', 'LIKE', "%{$search}%")
                ->orWhere('nombre', 'LIKE', "%{$search}%")
                ->orWhere('sku', 'LIKE', "%{$search}%")
                ->orWhereHas('empresa', fn($q) => $q->where('razon_social', 'LIKE', "%{$search}%"))
                ->orWhereHas('Instalaciones', fn($q) => $q->where('direccion_completa', 'LIKE', "%{$search}%"))
                ->orWhereHas('marca', fn($q) => $q->where('marca', 'LIKE', "%{$search}%"))
                ->orWhereHas('lotes_envasado_granel.lotes_granel', fn($q) => $q->where('nombre_lote', 'LIKE', "%{$search}%"))
                ->orWhereHas('empresa.empresaNumClientes', fn($q) => $q->where('numero_cliente', 'LIKE', "%{$search}%"))
                //dictamen
                ->orWhereHas('dictamenEnvasado', fn($q) => $q->where('num_dictamen', 'LIKE', "%{$search}%")); 

                // Filtrar por estatus de lote si se detectó una palabra clave
                if (!is_null($tipoEstado)) {
                    $q->orWhere('estatus', $tipoEstado);
                }
        });

        $totalFiltered = $query->count();
    } else {
        $totalFiltered = $totalData;
    }


    $users = $query
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();



        //MANDA LOS DATOS AL JS
        $data = [];
        if ($users->isNotEmpty()) {
            $ids = $start;

            foreach ($users as $user) {

                $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $user->id_empresa)->first();
                $numero_cliente = $empresa?->empresaNumClientes?->pluck('numero_cliente')->first(fn($numero) => !empty($numero));

                $sku = json_decode($user->sku, true); // Decodifica el JSON en un array
                $inicial = isset($sku['inicial']) ? $sku['inicial'] : 0; // Obtén el valor de 'inicial' del JSON
                $nuevo = isset($sku['nuevo']) ? $sku['nuevo'] : 0; // Obtén el valor de 'inicial' del JSON
                $cantt_botellas = isset($sku['cantt_botellas']) ? $sku['cantt_botellas'] : $user->cant_bot_restantes;
                $nombres_lote = lotes_envasado_granel::where('id_lote_envasado', $user->id_lote_envasado)
                    ->with('loteGranel') // Carga la relación
                    ->get()
                    ->pluck('loteGranel.nombre_lote'); // Obtén los nombres de los lotes
                
                //dictamen relacionado
                $dictamenes = Dictamen_Envasado::where('id_lote_envasado', $user->id_lote_envasado)
                    ->where('estatus', '!=', 1) // ignorar estatus 1
                    ->orderByDesc('id_dictamen_envasado')
                    ->get();
                $dictamenLinks = [];
                foreach ($dictamenes as $d) {
                    $url = url("dictamen_envasado/{$d->id_dictamen_envasado}");
                    $num = $d->num_dictamen;
                    // Creamos array de links
                    $dictamenLinks[] = [
                        'num' => $num,
                        'url' => $url
                    ];
                }

                $nestedData = [
                    'id_lote_envasado' => $user->id_lote_envasado,
                    'fake_id' => ++$ids,
                    'id_empresa' => $numero_cliente,
                    'id_marca' => $user->marca->marca ?? '',
                    'razon_social' => $user->empresa ? $user->empresa->razon_social : '',
                    'nombre' => $user->nombre ?? 'No encontrado',
                    'cant_botellas' => $user->cant_botellas,
                    'presentacion' => $user->presentacion,
                    'cont_alc_envasado' => $user->cont_alc_envasado,
                    'unidad' => $user->unidad,
                    'destino_lote' => $user->destino_lote,
                    'volumen_total' => $user->volumen_total,
                    'vol_restante' => $user->vol_restante,
                    'lugar_envasado' => $user->Instalaciones->direccion_completa ?? '',
                    'sku' => $user->sku,
                    'inicial' => $inicial,
                    'nuevo' => $nuevo,
                    'cantt_botellas' => $cantt_botellas,
                    'estatus' => $user->estatus,
                    'id_lote_granel' => $nombres_lote,

                    'dictamenes' => $dictamenLinks //todos los dictámenes
                ];

                $data[] = $nestedData;
            }
        }


        return response()->json([
            'draw' => intval($request->input('draw')),
            //'recordsTotal' => intval($totalData),
            'recordsTotal' => $empresaId ? intval($totalFiltered) : intval($totalData),//total oculto a clientes
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
}




    //Metodo para eliminar
    public function destroy($id_lote_envasado)
    {
        $clase = lotes_envasado::findOrFail($id_lote_envasado);
        $clase->delete();
        return response()->json(['success' => 'Lote envasado eliminada correctamente']);
    }



    //Metodo para egistrar
/*     public function store(Request $request)
    {
        try {
            // Crear lote envasado
            $lotes = new lotes_envasado();
            $lotes->id_empresa = $request->id_empresa;
            $lotes->nombre = $request->nombre;
            $lotes->sku = json_encode(['inicial' => $request->sku]);
            $lotes->id_marca = $request->id_marca;
            $lotes->destino_lote = $request->destino_lote;
            $lotes->cant_botellas = $request->cant_botellas;
            $lotes->cant_bot_restantes = $request->cant_botellas;
            $lotes->presentacion = $request->presentacion;
            $lotes->unidad = $request->unidad;
            $lotes->volumen_total = $request->volumen_total;
            $lotes->vol_restante = $request->volumen_total;
            $lotes->lugar_envasado = $request->lugar_envasado;
            $lotes->tipo = $request->tipo;
            $lotes->id_etiqueta = $request->id_etiqueta ?? null;
            $lotes->cont_alc_envasado = $request->cont_alc_envasado;

            $lotes->save();

            // Guardar relaciones con lotes a granel (si las hay)
            if ($request->has('id_lote_granel') && is_array($request->id_lote_granel)) {
                for ($i = 0; $i < count($request->id_lote_granel); $i++) {
                    $volumenParcial = $request->volumen_parcial[$i] ?? 0;

                    // Si hay algún lote seleccionado, se guarda la relación
                    if ($volumenParcial > 0) {
                        $envasado = new lotes_envasado_granel();
                        $envasado->id_lote_envasado = $lotes->id_lote_envasado;
                        $envasado->id_lote_granel = $request->id_lote_granel[$i];
                        $envasado->volumen_parcial = $volumenParcial;
                        $envasado->save();

                        // Actualiza volumen restante del lote a granel
                        $loteGranel = LotesGranel::find($request->id_lote_granel[$i]);
                        if ($loteGranel) {
                            $loteGranel->volumen_restante -= $volumenParcial;
                            $loteGranel->save();
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Lote envasado registrado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    } */
///REGISTRAR NUEVO LOTE
public function store(Request $request)
{
            DB::beginTransaction();

            try {
                $warning = false;
                $warningMessage = '';

                // Validar que ningún volumen parcial supere el volumen restante del lote granel
                if ($request->has('id_lote_granel') && is_array($request->id_lote_granel)) {
                    foreach ($request->id_lote_granel as $i => $idGranel) {
                        $volumenParcial = $request->volumen_parcial[$i] ?? 0;
                        $loteGranel = LotesGranel::find($idGranel);

                        if (!$loteGranel) {
                            return response()->json([
                                'success' => false,
                                'message' => "Lote granel con ID {$idGranel} no encontrado."
                            ], 404);
                        }

                        if ($volumenParcial > $loteGranel->volumen_restante) {
                            /*return response()->json([
                                'success' => false,
                                'message' => "El volumen parcial ({$volumenParcial} L) excede el volumen restante del lote granel: {$loteGranel->nombre_lote}."
                            ], 422);*/

                            $warning = true;
                            $warningMessage = 'Se registró con volumen excedente del lote granel';
                        }
                    }
                }

                // Crear lote envasado
                $lotes = new lotes_envasado();
                $lotes->id_empresa = $request->id_empresa;

                //Manejo de empresa_destino
                if ($request->filled('id_empresa_destino')) {
                    // Si viene en el request, se guarda (maquilador con destino)
                    $lotes->id_empresa_destino = $request->id_empresa_destino;
                } else {
                    // No maquilador → no aplica
                    $lotes->id_empresa_destino = null;
                }

                $lotes->nombre = $request->nombre;
                $lotes->sku = json_encode(['inicial' => $request->sku]);
                $lotes->id_marca = $request->id_marca;
                $lotes->destino_lote = $request->destino_lote;
                $lotes->cant_botellas = $request->cant_botellas;
                $lotes->cant_bot_restantes = $request->cant_botellas;
                $lotes->presentacion = $request->presentacion;
                $lotes->unidad = $request->unidad;
                $lotes->volumen_total = $request->volumen_total;
                $lotes->vol_restante = $request->volumen_total;
                $lotes->lugar_envasado = $request->lugar_envasado;
                $lotes->tipo = $request->tipo;
                $lotes->id_etiqueta = $request->id_etiqueta ?? null;
                $lotes->cont_alc_envasado = $request->cont_alc_envasado ?? 0;
                $lotes->save();

                // Guardar relaciones con lotes a granel
                if ($request->has('id_lote_granel') && is_array($request->id_lote_granel)) {
                    for ($i = 0; $i < count($request->id_lote_granel); $i++) {
                      $volumenParcial = $request->volumen_parcial[$i] ?? 0;

                      if ($volumenParcial > 0) {
                          $loteGranel = LotesGranel::find($request->id_lote_granel[$i]);

                          // Guardar volumen inicial ANTES de la resta
                          $volumenInicial = $loteGranel->volumen_restante;
                          $volumenFinal = $volumenInicial - $volumenParcial;

                          // Relación con lote envasado
                          $envasado = new lotes_envasado_granel();
                          $envasado->id_lote_envasado = $lotes->id_lote_envasado;
                          $envasado->id_lote_granel = $loteGranel->id_lote_granel;
                          $envasado->volumen_parcial = $volumenParcial;
                          $envasado->save();

                          // Actualizar volumen restante
                          $loteGranel->volumen_restante = $volumenFinal;
                          $loteGranel->save();

                          // Registrar bitácora de salida
                          BitacoraMezcal::create([
                              'fecha' => now()->toDateString(),
                              'id_tanque' => $loteGranel->id_tanque ?? 0,
                              'id_empresa' => $loteGranel->id_empresa,
                              'id_lote_granel' => $loteGranel->id_lote_granel,
                              /* 'id_instalacion' => auth()->user()->id_instalacion ?? 0, */
                              'id_instalacion' => Auth::user()->id_instalacion[0] ?? 0,
                              'tipo_operacion' => 'Salidas',
                              'tipo' => 2,
                              'procedencia_entrada' => 'Salida por creación de lote envasado',
                              'operacion_adicional' => null,
                              'volumen_inicial' => $volumenInicial,
                              'alcohol_inicial' => $loteGranel->cont_alc,
                              'volumen_entrada' => 0,
                              'alcohol_entrada' => 0,
                              'agua_entrada' => $loteGranel->agua_entrada ?? 0,
                              'volumen_salidas' => $volumenParcial,
                              'alcohol_salidas' => $loteGranel->cont_alc,
                              'destino_salidas' => $lotes->nombre,
                              'volumen_final' => $volumenFinal,
                              'alcohol_final' => $loteGranel->cont_alc,
                              'observaciones' => 'Salida por creación del lote envasado: ' . $lotes->nombre,
                              'id_firmante' => 0,
                          ]);
                      }
                  }

                }

                DB::commit();

                /*return response()->json([
                    'success' => true,
                    'message' => 'Lote envasado registrado exitosamente.'
                ]);*/
                $response = [
                    'success' => true,
                    'message' => 'Lote envasado registrado exitosamente.'
                ];

                if ($warning) {
                    $response['warning'] = true;
                    $response['message'] = $warningMessage;
                }
                
                return response()->json($response);
                
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
}



///OBTENER LOTE
public function edit($id)
{
        try {
            $envasado_granel = lotes_envasado::with(['lotes_envasado_granel.loteGranel'])->findOrFail($id);
            $sku = json_decode($envasado_granel->sku, true);
            // Añadir los valores de folio inicial y folio final
            $envasado_granel->inicial = $sku['inicial'] ?? null;
            // Extraer el nombre_lote de cada lote_granel relacionado
            $envasado_granel->lotes_envasado_granel->each(function ($loteGranel) {
                $loteGranel->nombre_lote = $loteGranel->loteGranel->nombre_lote ?? 'N/A';
            });
            // Retornar el objeto JSON
            return response()->json($envasado_granel);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Error al obtener el lote envasado'], 500);
        }
}
///ACTUALIZAR LOTE
public function update(Request $request)
{
    try {
            // Buscar el lote existente
            $lotes = lotes_envasado::findOrFail($request->input('id'));

            // 1. Restaurar volumen_restante de los lotes a granel originales
            $relacionesOriginales = lotes_envasado_granel::where('id_lote_envasado', $lotes->id_lote_envasado)->get();
            foreach ($relacionesOriginales as $relacion) {
                $loteGranel = LotesGranel::find($relacion->id_lote_granel);
                if ($loteGranel) {
                    $loteGranel->volumen_restante += $relacion->volumen_parcial;
                    $loteGranel->save();
                }
            }

            lotes_envasado_granel::where('id_lote_envasado', $lotes->id_lote_envasado)->delete();
          // Validar solo si vienen esos campos en el request
          $validated = $request->validate([
              'vol_restante' => 'nullable|numeric|min:0',
              'cant_bot_restantes' => 'nullable|integer|min:0',
          ]);
            // Actualizar los campos del lote envasado
            $lotes->id_empresa = $request->edit_cliente;

    $lotes->id_empresa_destino = $request->filled('id_empresa_destino') ? $request->id_empresa_destino : null;

            $lotes->nombre = $request->edit_nombre;

            // Decodificar el JSON existente
            $skuData = json_decode($lotes->sku, true) ?: [];
            // Actualizar solo el campo 'inicial' con el nuevo valor del request
            $skuData['inicial'] = $request->edit_sku;
            // Re-codificar el array a JSON y guardarlo en el campo 'sku'
            $lotes->sku = json_encode($skuData);
            // Guardar los cambios en la base de datos
            /* $lotes->save(); */
            $lotes->id_marca = $request->edit_marca;
           // Asignar solo si existen en $validated
            if (isset($validated['vol_restante'])) {
                $lotes->vol_restante = $validated['vol_restante'];
            }

            if (isset($validated['cant_bot_restantes'])) {
                $lotes->cant_bot_restantes = $validated['cant_bot_restantes'];
            }
            $lotes->destino_lote = $request->edit_destino_lote;
            $lotes->cant_botellas = $request->edit_cant_botellas;
            $lotes->presentacion = $request->edit_presentacion;
            $lotes->unidad = $request->edit_unidad;
            $lotes->volumen_total = $request->edit_volumen_total;
            $lotes->lugar_envasado = $request->edit_Instalaciones;
            $lotes->tipo = $request->tipo;
            $lotes->id_etiqueta = $request->id_etiqueta ?? null;
            $lotes->cont_alc_envasado = $request->cont_alc_envasado;
            $lotes->save();

            // Eliminar los registros de `lotes_envasado_granel` relacionados con este lote
            /* lotes_envasado_granel::where('id_lote_envasado', $lotes->id_lote_envasado)->delete(); */

            // Guardar los testigos relacionados si existen
        // 4. Guardar los nuevos testigos relacionados y actualizar volumen_restante
        if ($request->has('id_lote_granel') && is_array($request->id_lote_granel) && $request->has('volumen_parcial') && is_array($request->volumen_parcial)) {
            for ($i = 0; $i < count($request->id_lote_granel); $i++) {
                if (isset($request->id_lote_granel[$i]) && isset($request->volumen_parcial[$i])) {
                    $envasado = new lotes_envasado_granel();
                    $envasado->id_lote_envasado = $lotes->id_lote_envasado;
                    $envasado->id_lote_granel = $request->id_lote_granel[$i];
                    $envasado->volumen_parcial = $request->volumen_parcial[$i];
                    $envasado->save();

                    // Restar el nuevo volumen parcial al lote a granel
                    $loteGranel = LotesGranel::find($request->id_lote_granel[$i]);
                    if ($loteGranel) {
                        $loteGranel->volumen_restante -= $request->volumen_parcial[$i];
                        if ($loteGranel->volumen_restante < 0) {
                            return response()->json([
                                'success' => false,
                                'message' => 'El volumen del lote a granel no puede ser negativo.'
                            ], 400);
                        }
                        $loteGranel->save();
                    }
                }
            }
        }


        return response()->json(['success' => 'Lote envasado actualizado exitosamente.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}



    //Modificar SKU
    public function editSKU($id)
    {
        try {
            // Aquí obtienes el acta de inspección junto con sus testigos
            $edicionsku = lotes_envasado::findOrFail($id);
            $sku = json_decode($edicionsku->sku, true);

            // Añadir los valores de folio inicial y folio final
            $edicionsku->inicial = $sku['inicial'] ?? null;
            $edicionsku->observaciones = $sku['observaciones'] ?? null;
            $edicionsku->nuevo = $sku['nuevo'] ?? null;
            $edicionsku->cantt_botellas = $sku['cantt_botellas'] ?? null;

            return response()->json($edicionsku);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el sku'], 500);
        }
    }

    //Actualizar SKU
    public function updateSKU(Request $request)
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $sku_nuevo = lotes_envasado::findOrFail($request->input('id'));
            $sku_nuevo->sku = json_encode([
                'inicial' => $request->edictt_sku,
                'observaciones' => $request->observaciones,
                'nuevo' => $request->nuevo, // Puedes agregar otros valores también
                'cantt_botellas' => $request->cantt_botellas, // Puedes agregar otros valores también
            ]);
            $sku_nuevo->save();
            // Retorna una respuesta exitosa
            return response()->json(['success' => 'Reclasificación  actualizada correctamente']);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el proceso
            return response()->json(['error' => 'Error al actualizar la solicitud de envió'], 500);
        }
    }

    //Metodo obtener etiquetas
    public function obtenerMarcasPorEmpresa($id_empresa)
    {
        $marcas = marcas::where('id_empresa', $id_empresa)->get();

        foreach ($marcas as $marca) {
            $etiquetado = is_string($marca->etiquetado) ? json_decode($marca->etiquetado, true) : $marca->etiquetado;

            if (is_null($etiquetado) || !is_array($etiquetado)) {
                $marca->tipo_nombre = [];
                $marca->clase_nombre = [];
                $marca->categoria_nombre = [];
                $marca->direccion_nombre = [];
                $marca->etiquetado = [];
                continue;
            }

            $tipos = isset($etiquetado['id_tipo']) ? tipos::whereIn('id_tipo', $etiquetado['id_tipo'])->pluck('nombre')->toArray() : [];
            $clases = isset($etiquetado['id_clase']) ? clases::whereIn('id_clase', $etiquetado['id_clase'])->pluck('clase')->toArray() : [];
            $categorias = isset($etiquetado['id_categoria']) ? categorias::whereIn('id_categoria', $etiquetado['id_categoria'])->pluck('categoria')->toArray() : [];

            $direcciones = [];
            if (isset($etiquetado['id_direccion']) && is_array($etiquetado['id_direccion'])) {
                foreach ($etiquetado['id_direccion'] as $id_direccion) {
                    $direccion = Destinos::where('id_direccion', $id_direccion)->value('direccion');
                    $direcciones[] = $direccion ?? 'N/A';
                }
            }

            // Obtener los documentos asociados a la marca
            $documentos = Documentacion_url::where('id_empresa', $marca->id_empresa)
                                            ->where('id_relacion', $marca->id_marca)
                                            ->get();

            // Agregar los datos procesados al resultado
            $marca->tipo_nombre = $tipos;
            $marca->clase_nombre = $clases;
            $marca->categoria_nombre = $categorias;
            $marca->direccion_nombre = $direcciones;
            $marca->etiquetado = $etiquetado;
            $marca->documentos = $documentos; // Agregar documentos a la marca
        }

        return response()->json($marcas);
    }

    public function obtenerEtiquetasPorEmpresa($id_empresa)
    {
        $etiquetas = etiquetas::with(['tipo', 'clase', 'categoria', 'marca'])
            ->where('id_empresa', $id_empresa)
            ->get();

        foreach ($etiquetas as $etiqueta) {
            $etiqueta->marca_nombre = $etiqueta->marca->marca ?? 'N/A';
            $etiqueta->clase_nombre = $etiqueta->clase->clase ?? 'N/A';
            $etiqueta->categoria_nombre = $etiqueta->categoria->categoria ?? 'N/A';

            // Si id_tipo es un JSON (array), decodifica y busca nombres
            $tipoIds = is_string($etiqueta->id_tipo) ? json_decode($etiqueta->id_tipo, true) : $etiqueta->id_tipo;
            if (is_array($tipoIds)) {
                $etiqueta->tipo_nombre = tipos::whereIn('id_tipo', $tipoIds)->pluck('nombre')->implode(', ');
            } else {
                $etiqueta->tipo_nombre = $etiqueta->tipo->nombre ?? 'N/A';
            }
        }

        return response()->json($etiquetas);
    }






}
