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
        // Valida los datos
        $validated = $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'nombre_lote' => 'required|string|max:100',
            'tipo_lote' => 'required|string|max:120',
            'sku' => 'required|string|max:60',
            'id_marca' => 'required|exists:marcas,id_marca',
            'destino_lote' => 'required|string|max:120',
            'cant_botellas' => 'required|integer',
            'presentacion' => 'required|integer',
            'unidad' => 'required|string|max:50',
            'volumen_total' => 'required|numeric',
            'lugar_envasado' => 'required|exists:instalaciones,id_instalacion',
            'id_lote_granel.*' => 'nullable',
            'volumen_parcial.*' => 'nullable',
        ]);
    
        // Crea un nuevo registro en la base de datos
        try {
            lotes_envasado::create($validated);

            $ultimoLote = lotes_envasado::latest()->first();

            

            for ($i = 0; $i < count($request->id_lote_granel); $i++) {

                if(empty($request->volumen_total)){
                    $volumen_parcial =  $request->volumen_parcial[$i];
                }else{
                    $volumen_parcial = $request->volumen_total;
                }
               
                $envasado_granel = new lotes_envasado_granel();
                $envasado_granel->id_lote_envasado = $ultimoLote->id_lote_envasado;
                $envasado_granel->id_lote_granel = $request->id_lote_granel[$i];
                $envasado_granel->volumen_parcial = $volumen_parcial;
                $envasado_granel->save();
              }
          

            return response()->json(['success' => 'Lote registrado exitosamente.']);
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
    
            return response()->json($envasado_granel);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el acta por ID'], 500);
        }
    }


    //editar lotes envasados
    public function update(Request $request, $id)
    {
        // Valida los datos
        $validated = $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'nombre_lote' => 'required|string|max:100',
            'tipo_lote' => 'required|string|max:120',
            'sku' => 'required|string|max:60',
            'id_marca' => 'required|exists:marcas,id_marca',
            'destino_lote' => 'required|string|max:120',
            'cant_botellas' => 'required|integer',
            'presentacion' => 'required|integer',
            'unidad' => 'required|string|max:50',
            'volumen_total' => 'required|numeric',
            'lugar_envasado' => 'required|exists:instalaciones,id_instalacion',
            'id_lote_granel.*' => 'nullable',
            'volumen_parcial.*' => 'nullable',
        ]);
    
        // Busca el lote que se quiere actualizar
        try {
            $lote = lotes_envasado::findOrFail($id);
    
            // Actualiza el registro principal en la tabla 'lotes_envasado'
            $lote->update($validated);
    
            // Elimina los registros anteriores relacionados en 'lotes_envasado_granel'
            lotes_envasado_granel::where('id_lote_envasado', $lote->id_lote_envasado)->delete();
    
            // Inserta los nuevos registros en 'lotes_envasado_granel'
            for ($i = 0; $i < count($request->id_lote_granel); $i++) {
                if (empty($request->volumen_total)) {
                    $volumen_parcial = $request->volumen_parcial[$i];
                } else {
                    $volumen_parcial = $request->volumen_total;
                }
    
                $envasado_granel = new lotes_envasado_granel();
                $envasado_granel->id_lote_envasado = $lote->id_lote_envasado;
                $envasado_granel->id_lote_granel = $request->id_lote_granel[$i];
                $envasado_granel->volumen_parcial = $volumen_parcial;
                $envasado_granel->save();
            }
    
            return response()->json(['success' => 'Lote actualizado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    

}
