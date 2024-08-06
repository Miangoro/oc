<?php

namespace App\Http\Controllers\domicilios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Predios;
use App\Models\Empresa;
use App\Models\Tipos;

class PrediosController extends Controller
{
    public function UserManagement()
    {
        $predios = Predios::with('empresa')->get(); // Obtener todos los registros con la relación cargada
        $empresas = Empresa::all(); // Obtener todas las empresas
        $tipos = Tipos::all(); // Obtén todos los tipos de agave
    
        return view('domicilios.find_domicilio_predios_view', [
            'predios' => $predios, // Pasar los datos a la vista
            'empresas' => $empresas // Pasar las empresas a la vista
        ]);
    }
    

    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'id_empresa',
            3 => 'nombre_productor',
            4 => 'nombre_predio',
            5 => 'ubicacion_predio',
            6 => 'tipo_predio',
            7 => 'puntos_referencia',
            8 => 'cuenta_con_coordenadas',
            9 => 'latitud',
            10 => 'longitud',
            11 => 'superficie',
            12 => 'id_tipo',
            13 => 'numero_plantas',
            14 => 'edad_plantacion',
            15 => 'tipo_plantacion'
        ];
    
        $search = [];
    
        $totalData = Predios::count();
    
        $totalFiltered = $totalData;
    
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
    
        if (empty($request->input('search.value'))) {
            $predios = Predios::with('empresa') // Carga la relación
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
    
            $predios = Predios::with('empresa') // Carga la relación
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('id_empresa', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
    
            $totalFiltered = Predios::with('empresa')
                ->where('id', 'LIKE', "%{$search}%")
                ->orWhere('id_empresa', 'LIKE', "%{$search}%")
                ->count();
        }
    
        $data = [];
    
        if (!empty($predios)) {
            $ids = $start;
    
            foreach ($predios as $predio) {
                $nestedData['id'] = $predio->id;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['id_empresa'] = $predio->empresa->razon_social ?? 'N/A'; // Muestra la razón social de la empresa
                $nestedData['nombre_productor'] = $predio->nombre_productor;
                $nestedData['nombre_predio'] = $predio->nombre_predio;
                $nestedData['ubicacion_predio'] = $predio->ubicacion_predio;
                $nestedData['tipo_predio'] = $predio->tipo_predio;
                $nestedData['puntos_referencia'] = $predio->puntos_referencia;
                $nestedData['cuenta_con_coordenadas'] = $predio->cuenta_con_coordenadas;
                $nestedData['latitud'] = $predio->latitud ?? 'N/A';
                $nestedData['longitud'] = $predio->longitud ?? 'N/A';
                $nestedData['superficie'] = $predio->superficie;
                $nestedData['id_tipo'] = $predio->tipo->nombre ?? 'N/A';
                $nestedData['numero_plantas'] = $predio->numero_plantas;
                $nestedData['edad_plantacion'] = $predio->edad_plantacion;
                $nestedData['tipo_plantacion'] = $predio->tipo_plantacion;
    
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

        // Función para eliminar un predio
        public function destroy($id)
        {
            try {
                $predio = Predios::findOrFail($id);
                $predio->delete();
    
                return response()->json(['success' => 'Clase eliminada correctamente']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al eliminar la clase'], 500);
            }
        }

}
