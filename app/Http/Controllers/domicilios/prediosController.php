<?php

namespace App\Http\Controllers\domicilios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Predios;
use App\Models\Empresa;
use App\Models\Tipos;
use App\Models\PredioCoordenadas;
use App\Models\PredioPlantacion;
use Illuminate\Support\Facades\Log;



class PrediosController extends Controller
{
    public function UserManagement()
    {
        $predios = Predios::with('empresa')->get(); // Obtener todos los registros con la relación cargada
        $empresas = Empresa::all(); // Obtener todas las empresas
        $tipos = Tipos::all(); // Obtén todos los tipos de agave
    
        return view('domicilios.find_domicilio_predios_view', [
            'predios' => $predios, // Pasar los datos a la vista
            'empresas' => $empresas, // Pasar las empresas a la vista
            'tipos' => $tipos // Pasar los tipos a la vista
        ]);
    }
    

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_predio',
            2 => 'id_empresa',
            3 => 'nombre_productor',
            4 => 'nombre_predio',
            5 => 'ubicacion_predio',
            6 => 'tipo_predio',
            7 => 'puntos_referencia',
            8 => 'cuenta_con_coordenadas',
            9 => 'superficie',   
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
                ->where('id_predio', 'LIKE', "%{$search}%")
                ->orWhere('id_empresa', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
    
            $totalFiltered = Predios::with('empresa')
                ->where('id_predio', 'LIKE', "%{$search}%")
                ->orWhere('id_empresa', 'LIKE', "%{$search}%")
                ->count();
        }
    
        $data = [];
    
        if (!empty($predios)) {
            $ids = $start;
    
            foreach ($predios as $predio) {
                $nestedData['id_predio'] = $predio->id_predio;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['id_empresa'] = $predio->empresa->razon_social ?? 'N/A'; // Muestra la razón social de la empresa
                $nestedData['nombre_productor'] = $predio->nombre_productor;
                $nestedData['nombre_predio'] = $predio->nombre_predio;
                $nestedData['ubicacion_predio'] = $predio->ubicacion_predio ?? 'N/A';
                $nestedData['tipo_predio'] = $predio->tipo_predio;
                $nestedData['puntos_referencia'] = $predio->puntos_referencia  ?? 'N/A';
                $nestedData['cuenta_con_coordenadas'] = $predio->cuenta_con_coordenadas  ?? 'N/A';
                $nestedData['superficie'] = $predio->superficie;
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
        public function destroy($id_predio)
        {
            try {
                $predio = Predios::findOrFail($id_predio);
                $predio->delete();
        
                return response()->json(['success' => 'Predio eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al eliminar el predio: ' . $e->getMessage()], 500);
            }
        }


        public function store(Request $request)
        {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'id_empresa' => 'required|exists:empresa,id_empresa',
                'nombre_productor' => 'required|string|max:70',
                'nombre_predio' => 'required|string',
                'ubicacion_predio' => 'nullable|string',
                'tipo_predio' => 'required|string',
                'puntos_referencia' => 'required|string',
                'tiene_coordenadas' => 'nullable|string|max:2',
                'superficie' => 'required|string',
            ]);
        
            // Crear una nueva instancia del modelo Predios
            $predio = new Predios();
            $predio->id_empresa = $validatedData['id_empresa'];
            $predio->nombre_productor = $validatedData['nombre_productor'];
            $predio->nombre_predio = $validatedData['nombre_predio'];
            $predio->ubicacion_predio = $validatedData['ubicacion_predio'];
            $predio->tipo_predio = $validatedData['tipo_predio'];
            $predio->puntos_referencia = $validatedData['puntos_referencia'];
            $predio->cuenta_con_coordenadas = $validatedData['tiene_coordenadas'];
            $predio->superficie = $validatedData['superficie'];
        
            // Guardar el nuevo predio en la base de datos
            $predio->save();
        
            // Guardar coordenadas, si existen
            if ($request->has('latitud') && $request->has('longitud')) {
                foreach ($request->latitud as $index => $latitud) {
                    PredioCoordenadas::create([
                        'id_predio' => $predio->id_predio,
                        'latitud' => $latitud,
                        'longitud' => $request->longitud[$index],
                    ]);
                }
            }
        
            // Almacenar los datos de plantación en la tabla predio_plantacion
            if ($request->has('id_tipo')) {
                foreach ($request->id_tipo as $index => $id_tipo) {
                    PredioPlantacion::create([
                        'id_predio' => $predio->id_predio,
                        'id_tipo' => $id_tipo,
                        'num_plantas' => $request->numero_plantas[$index],
                        'anio_plantacion' => $request->edad_plantacion[$index],
                        'tipo_plantacion' => $request->tipo_plantacion[$index],
                    ]);
                }
            }
        
            // Retornar una respuesta
            return response()->json([
                'success' => true,
                'message' => 'Predio registrado exitosamente',
            ]);
        }

        
        public function edit($id_predio)
        {
            try {
                // Cargar el lote y las guías asociadas
                /* $lote = LotesGranel::with('lotesGuias.guia')->findOrFail($id_lote_granel); */

                $predio = Predios::findOrFail($id_predio);
                // Obtener los IDs de las guías asociadas
                /* $guiasIds = $lote->lotesGuias->pluck('id_guia')->toArray(); */

                return response()->json([
                    'success' => true,
                    'predio' => $predio,
                ]);
            } catch (ModelNotFoundException $e) {
                return response()->json(['success' => false], 404);
            }
        }        


        public function update(Request $request, $id_predio)
        {
            try {
                Log::info('Datos recibidos:', $request->all());
    
                // Validar los datos del formulario
                $validated = $request->validate([
                    'id_empresa' => 'required|exists:empresa,id_empresa',
                    'nombre_productor' => 'required|string|max:70',
                    'nombre_predio' => 'required|string',
                    'ubicacion_predio' => 'nullable|string',
                    'tipo_predio' => 'required|string',
                    'puntos_referencia' => 'required|string',
                    'tiene_coordenadas' => 'nullable|string|max:2',
                    'superficie' => 'required|string',
                ]);
    
                $predio = Predios::findOrFail($id_predio);
    
                // Actualizar predio
                $predio->update([
                    'id_empresa' => $validated['id_empresa'],
                    'nombre_productor' => $validated['nombre_productor'],
                    'nombre_predio' => $validated['nombre_predio'],
                    'ubicacion_predio' => $validated['ubicacion_predio'],
                    'tipo_predio' => $validated['tipo_predio'],
                    'puntos_referencia' => $validated['puntos_referencia'],
                    'cuenta_con_coordenadas' => $validated['tiene_coordenadas'],
                    'superficie' => $validated['superficie'],
                ]);
    
                return response()->json([
                    'success' => true,
                    'message' => 'Predio actualizado exitosamente',
                ]);
            } catch (\Exception $e) {
                Log::error('Error al actualizar el predio: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el predio: ' . $e->getMessage(),
                ], 500);
            }
        }
        

}
