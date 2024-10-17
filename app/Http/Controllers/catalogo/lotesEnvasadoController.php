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
        $clientes = Empresa::where('tipo','=','2')->get(); // Esto depende de cómo tengas configurado tu modelo Empresa
        $marcas = marcas::all(); // Obtener todas las marcas
        $lotes_granel = LotesGranel::all(); // Obtener todas las marcas
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
            'clientes' => $clientes, // Pasa la lista de clientes a la vista
            'marcas' => $marcas,     // Pasa la lista de marcas a la vista
            'lotes_granel' => $lotes_granel,     // Pasa la lista de marcas a la vista
            'lotes_envasado' => $lotes_envasado,     // Pasa la lista de marcas a la vista
            'Instalaciones' => $Instalaciones,     // Pasa la lista de marcas a la vista


        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_lote_envasado',
            2 => 'id_empresa',
            3 => 'nombre_lote',
            4 => 'tipo_lote',
            5 => 'sku',
            6 => 'id_marca',
            7 => 'destino_lote',
            8 => 'cant_botellas',
            9 => 'presentacion',
            10 => 'unidad',
            11 => 'volumen_total',
            12 => 'lugar_envasado',

        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'id_lote_envasado';
        $dir = $request->input('order.0.dir');

        $searchValue = $request->input('search.value');

        $query = lotes_envasado::with('empresa');

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('id_empresa', 'LIKE', "%{$searchValue}%")
                    ->orWhere('nombre_lote', 'LIKE', "%{$searchValue}%")
                    ->orWhere('cant_botellas', 'LIKE', "%{$searchValue}%");
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
                $numero_cliente = \App\Models\EmpresaNumCliente::where('id_empresa', $user->id_empresa)->value('numero_cliente');
                
                // Obtener la marca de la tabla marcas mediante el id_marca
                $marca = \App\Models\Marcas::where('id_marca', $user->id_marca)->value('marca');
        
                $nestedData = [
                    'id_lote_envasado' => $user->id_lote_envasado,
                    'fake_id' => ++$ids,
                    'id_empresa' => $numero_cliente, // Asignar numero_cliente a id_empresa
                    'id_marca' => $marca, // Asignar el nombre de la marca a id_marca
                    'razon_social' => $user->empresa ? $user->empresa->razon_social : '',
                    'tipo_lote' => $user->tipo_lote,
                    'nombre_lote' => $user->nombre_lote,
                    'cant_botellas' => $user->cant_botellas,
                    'presentacion' => $user->presentacion,
                    'unidad' => $user->unidad,
                    'destino_lote' => $user->destino_lote,
                    'volumen_total' => $user->volumen_total,
                    'lugar_envasado' => $direccion_completa, // Asignar direccion_completa a lugar_envasado
                    'sku' => $user->sku,
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

        return response()->json(['success' => 'Clase eliminada correctamente']);
    }

//Metodo para egistrar
    public function store(Request $request)
{
    try {
        // Crear un nuevo registro en la tabla `lotes_envasado`
        $lotes = new lotes_envasado();
        $lotes->id_empresa = $request->id_empresa;
        $lotes->nombre_lote = $request->nombre_lote;
        $lotes->tipo_lote = $request->tipo_lote;
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

    //mostrar lotes envasados registrados
    public function edit($id)
    {
        try {
            // Aquí obtienes el acta de inspección junto con sus testigos
            $envasado_granel = lotes_envasado::with('lotes_envasado_granel')->findOrFail($id);
            $sku = json_decode($envasado_granel->sku, true);

            // Añadir los valores de folio inicial y folio final
            $envasado_granel->inicial = $sku['inicial'] ?? null;
            return response()->json($envasado_granel);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el lote envasado'], 500);
        }
    }


    //editar lotes envasados
    public function update(Request $request, $id)
    {
        try {
            // Buscar el lote existente
            $lotes = lotes_envasado::findOrFail($id);
    
            // Actualizar los campos del lote envasado
            $lotes->id_empresa = $request->id_empresa;
            $lotes->nombre_lote = $request->nombre_lote;
            $lotes->tipo_lote = $request->tipo_lote;
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
            $edicionsku->cant_botellas = $sku['cant_botellas'] ?? null;

            return response()->json($edicionsku);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el sku'], 500);
        }
    }
    
    

    public function updateSKU(Request $request)
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $sku_nuevo = lotes_envasado::findOrFail($request->input('id'));

            $sku_nuevo->sku = json_encode([
                'inicial' => $request->edictt_sku,
                'observaciones' => $request->observaciones,
                'nuevo' => $request->nuevo, // Puedes agregar otros valores también
                'cant_botellas' => $request->cant_botellas, // Puedes agregar otros valores también


            ]);
            $sku_nuevo->save();


            // Retorna una respuesta exitosa
            return response()->json(['success' => 'Solicitud de envio actualizada correctamente']);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el proceso
            return response()->json(['error' => 'Error al actualizar la solicitud de envio'], 500);
        }
    } 



    

}
