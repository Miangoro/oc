<?php

namespace App\Http\Controllers\catalogo;

use App\Models\lotes_envasado;
use App\Models\empresa;
use App\Models\marcas;
use App\Models\LotesGranel;
use App\Models\Instalaciones;
use App\Http\Controllers\Controller;
use App\Models\lotes_envasado_granel;
use Illuminate\Http\Request;

class lotesEnvasadoController extends Controller
{
    public function UserManagement()
    {
        $clientes = empresa::where('tipo', '=', '2')->get();
        $marcas = marcas::all();
        $lotes_granel = LotesGranel::all();
        $lotes_envasado = lotes_envasado::all();
        $Instalaciones = Instalaciones::all();

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
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_lote_envasado',
            2 => 'id_empresa',
            3 => 'nombre_lote',
            4 => 'sku',
            5 => 'id_marca',
            6 => 'destino_lote',
            7 => 'cant_botellas',
            8 => 'presentacion',
            9 => 'unidad',
            10 => 'volumen_total',
            11 => 'lugar_envasado',
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'id_lote_envasado';
        $dir = $request->input('order.0.dir');

        $searchValue = $request->input('search.value');

        $query = lotes_envasado::with(['empresa', 'marca', 'Instalaciones']); // Cargar relaciones necesarias

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('destino_lote', 'LIKE', "%{$searchValue}%")
                    ->orWhere('nombre', 'LIKE', "%{$searchValue}%")
                    ->orWhere('estatus', 'LIKE', "%{$searchValue}%");

                $q->orWhereHas('marca', function ($qMarca) use ($searchValue) {
                    $qMarca->where('marca', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('Instalaciones', function ($qDireccion) use ($searchValue) {
                    $qDireccion->where('direccion_completa', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('empresa', function ($qEmpresa) use ($searchValue) {
                    $qEmpresa->where('razon_social', 'LIKE', "%{$searchValue}%");
                });
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
                // Obtener la dirección completa de la instalación mediante el id_empresa
                $instalacion = Instalaciones::where('id_instalacion', $user->lugar_envasado)->first();
                $direccion_completa = $instalacion ? $instalacion->direccion_completa : '';

                // Obtener el numero_cliente de la tabla empresa_num_cliente
                $numero_cliente = \App\Models\empresaNumCliente::where('id_empresa', $user->id_empresa)->value('numero_cliente');
                // Obtener la marca de la tabla marcas mediante el id_marca
                $marca = \App\Models\marcas::where('id_marca', $user->id_marca)->value('marca');
                $sku = json_decode($user->sku, true); // Decodifica el JSON en un array
                $inicial = isset($sku['inicial']) ? $sku['inicial'] : 0; // Obtén el valor de 'inicial' del JSON
                $nuevo = isset($sku['nuevo']) ? $sku['nuevo'] : 0; // Obtén el valor de 'inicial' del JSON
                $cantt_botellas = isset($sku['cantt_botellas']) ? $sku['cantt_botellas'] : $user->cant_botellas;
                $lotes_granel = \App\Models\LotesGranel::where('id_empresa', $user->id_empresa)->value('nombre_lote');
                // Obtener los ids de lote granel asociados al id de envasado
                $id_lote_granel = lotes_envasado_granel::where('id_lote_envasado', $user->id_lote_envasado)->pluck('id_lote_granel');
                // Usar esos IDs para obtener los nombres de los lotes en la tabla `lotes_granel`
                $nombres_lote = LotesGranel::whereIn('id_lote_granel', $id_lote_granel)->pluck('nombre_lote');
                $nombres_lote = lotes_envasado_granel::where('id_lote_envasado', $user->id_lote_envasado)
                    ->with('loteGranel')
                    ->get()
                    ->pluck('loteGranel.nombre_lote');


                $nestedData = [
                    'id_lote_envasado' => $user->id_lote_envasado,
                    'fake_id' => ++$ids,
                    'id_empresa' => $numero_cliente,
                    'id_marca' => $marca,
                    'razon_social' => $user->empresa ? $user->empresa->razon_social : '',
                    'lotes_granel' => $lotes_granel,
                    //nada
                    'nombre' => $user->nombre,
                    'cant_botellas' => $user->cant_botellas,
                    'presentacion' => $user->presentacion,
                    'unidad' => $user->unidad,
                    'destino_lote' => $user->destino_lote,
                    'volumen_total' => $user->volumen_total,
                    'lugar_envasado' => $direccion_completa,
                    'sku' => $user->sku,
                    'inicial' => $inicial,
                    'nuevo' => $nuevo,
                    'cantt_botellas' => $cantt_botellas,
                    'estatus' => $user->estatus,
                    'id_lote_granel' => $nombres_lote,


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

    //Metodo para eliminar
    public function destroy($id_lote_envasado)
    {
        $clase = lotes_envasado::findOrFail($id_lote_envasado);
        $clase->delete();
        return response()->json(['success' => 'Lote envasado eliminada correctamente']);
    }

    //Metodo para egistrar
    public function store(Request $request)
    {
        try {
            // Crear un nuevo registro en la tabla `lotes_envasado`
            $lotes = new lotes_envasado();
            $lotes->id_empresa = $request->id_empresa;
            $lotes->nombre = $request->nombre;
            $lotes->sku = $request->sku;

            $lotes->sku = json_encode([
                'inicial' => $request->sku,
            ]);
            $lotes->id_marca = $request->id_marca;
            $lotes->destino_lote = $request->destino_lote;
            $lotes->cant_botellas = $request->cant_botellas;
            $lotes->presentacion = $request->presentacion;
            $lotes->unidad = $request->unidad;
            $lotes->volumen_total = $request->volumen_total;
            $lotes->lugar_envasado = $request->lugar_envasado;
            $lotes->save();

            // Verificar si existen los arrays antes de procesarlos
            if ($request->has('id_lote_granel') && is_array($request->id_lote_granel) && $request->has('volumen_parcial') && is_array($request->volumen_parcial)) {
                for ($i = 0; $i < count($request->id_lote_granel); $i++) {
                    // Verificar que ambos arrays tengan el mismo tamaño
                    if (isset($request->id_lote_granel[$i]) && isset($request->volumen_parcial[$i])) {
                        $envasado = new lotes_envasado_granel();
                        $envasado->id_lote_envasado = $lotes->id_lote_envasado;  // Relacionar con el lote envasado creado
                        $envasado->id_lote_granel = $request->id_lote_granel[$i];
                        $envasado->volumen_parcial = $request->volumen_parcial[$i];
                        $envasado->save();
                    }
                }
            }
            return response()->json(['success' => 'Lote envasado registrado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    //Editar lotes envasados
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

    //Actualizar lotes envasados
    public function update(Request $request)
    {
        try {
            // Buscar el lote existente
            $lotes = lotes_envasado::findOrFail($request->input('id'));


            // Actualizar los campos del lote envasado
            $lotes->id_empresa = $request->edit_cliente;
            $lotes->nombre = $request->edit_nombre;

            // Decodificar el JSON existente
            $skuData = json_decode($lotes->sku, true) ?: [];
            // Actualizar solo el campo 'inicial' con el nuevo valor del request
            $skuData['inicial'] = $request->edit_sku;
            // Re-codificar el array a JSON y guardarlo en el campo 'sku'
            $lotes->sku = json_encode($skuData);
            // Guardar los cambios en la base de datos
            $lotes->save();

            $lotes->id_marca = $request->edit_marca;
            $lotes->destino_lote = $request->edit_destino_lote;
            $lotes->cant_botellas = $request->edit_cant_botellas;
            $lotes->presentacion = $request->edit_presentacion;
            $lotes->unidad = $request->edit_unidad;
            $lotes->volumen_total = $request->edit_volumen_total;
            $lotes->lugar_envasado = $request->edit_Instalaciones;
            $lotes->save();

            // Eliminar los registros de `lotes_envasado_granel` relacionados con este lote
            lotes_envasado_granel::where('id_lote_envasado', $lotes->id_lote_envasado)->delete();

            // Guardar los testigos relacionados si existen
            if ($request->has('id_lote_granel') && is_array($request->id_lote_granel) && $request->has('volumen_parcial') && is_array($request->volumen_parcial)) {
                for ($i = 0; $i < count($request->id_lote_granel); $i++) {
                    // Verificar que ambos arrays tengan el mismo tamaño
                    if (isset($request->id_lote_granel[$i]) && isset($request->volumen_parcial[$i])) {
                        $envasado = new lotes_envasado_granel();
                        $envasado->id_lote_envasado = $lotes->id_lote_envasado;  // Relacionar con el lote envasado
                        $envasado->id_lote_granel = $request->id_lote_granel[$i];
                        $envasado->volumen_parcial = $request->volumen_parcial[$i];
                        $envasado->save();
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
}
