<?php

namespace App\Http\Controllers\domicilios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Predios;
use App\Models\Empresa;
use App\Models\Tipos;
use App\Models\PredioCoordenadas;
use App\Models\predio_plantacion;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;



class PrediosController extends Controller
{
    public function UserManagement()
    {
        $predios = Predios::with('empresa')->get(); // Obtener todos los registros con la relación cargada
        $empresas = Empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
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
    
        // Obtener el total de registros filtrados
        $totalData = Predios::whereHas('empresa', function ($query) {
            $query->where('tipo', 2);
        })->count();
    
        $totalFiltered = $totalData;
    
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
    
        if (empty($request->input('search.value'))) {
            $predios = Predios::with('empresa') // Carga la relación
                ->whereHas('empresa', function ($query) {
                    $query->where('tipo', 2);
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
    
            $predios = Predios::with('empresa')
                ->whereHas('empresa', function ($query) {
                    $query->where('tipo', 2);
                })
                ->where(function ($query) use ($search) {
                    $query->whereHas('empresa', function ($q) use ($search) {
                        $q->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('nombre_productor', 'LIKE', "%{$search}%")
                    ->orWhere('nombre_predio', 'LIKE', "%{$search}%")
                    ->orWhere('ubicacion_predio', 'LIKE', "%{$search}%")
                    ->orWhere('tipo_predio', 'LIKE', "%{$search}%")
                    ->orWhere('puntos_referencia', 'LIKE', "%{$search}%")
                    ->orWhere('superficie', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
    
            $totalFiltered = Predios::with('empresa')
                ->whereHas('empresa', function ($query) {
                    $query->where('tipo', 2);
                })
                ->where(function ($query) use ($search) {
                    $query->whereHas('empresa', function ($q) use ($search) {
                        $q->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('nombre_productor', 'LIKE', "%{$search}%")
                    ->orWhere('nombre_predio', 'LIKE', "%{$search}%")
                    ->orWhere('ubicacion_predio', 'LIKE', "%{$search}%")
                    ->orWhere('tipo_predio', 'LIKE', "%{$search}%")
                    ->orWhere('puntos_referencia', 'LIKE', "%{$search}%")
                    ->orWhere('superficie', 'LIKE', "%{$search}%");
                })
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
        
            // Guardar coordenadas, si existen y no son nulas
            if ($request->has('latitud') && $request->has('longitud')) {
                foreach ($request->latitud as $index => $latitud) {
                    // Asegurarse de que tanto latitud como longitud no sean nulas
                    if (!is_null($latitud) && !is_null($request->longitud[$index])) {
                        PredioCoordenadas::create([
                            'id_predio' => $predio->id_predio,
                            'latitud' => $latitud,
                            'longitud' => $request->longitud[$index],
                        ]);
                    }
                }
            }
        
            // Almacenar los datos de plantación en la tabla predio_plantacion, si existen
            if ($request->has('id_tipo')) {
                foreach ($request->id_tipo as $index => $id_tipo) {
                    // Asegurarse de que los campos no sean nulos
                    if (!is_null($id_tipo) && !is_null($request->numero_plantas[$index]) && !is_null($request->edad_plantacion[$index]) && !is_null($request->tipo_plantacion[$index])) {
                        predio_plantacion::create([
                            'id_predio' => $predio->id_predio,
                            'id_tipo' => $id_tipo,
                            'num_plantas' => $request->numero_plantas[$index],
                            'anio_plantacion' => $request->edad_plantacion[$index],
                            'tipo_plantacion' => $request->tipo_plantacion[$index],
                        ]);
                    }
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
                $predio = Predios::with(['coordenadas', 'predio_plantaciones'])->findOrFail($id_predio);
                $tipos = Tipos::all(); // Asegúrate de cargar los tipos de agave disponibles

                return response()->json([
                    'success' => true,
                    'predio' => $predio,
                    'coordenadas' => $predio->coordenadas,
                    'plantaciones' => $predio->predio_plantaciones,
                    'tipos' => $tipos, // Incluye los tipos de agave
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
                    'latitud' => 'nullable|array',
                    'latitud.*' => 'nullable|numeric',
                    'longitud' => 'nullable|array',
                    'longitud.*' => 'nullable|numeric',
                    'id_tipo' => 'nullable|array',
                    'id_tipo.*' => 'nullable|exists:catalogo_tipo_agave,id_tipo',
                    'numero_plantas' => 'nullable|array',
                    'numero_plantas.*' => 'nullable|numeric',
                    'edad_plantacion' => 'nullable|array',
                    'edad_plantacion.*' => 'nullable|numeric',
                    'tipo_plantacion' => 'nullable|array',
                    'tipo_plantacion.*' => 'nullable|string',
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
        
                // Manejar coordenadas
                if ($validated['tiene_coordenadas'] === 'no') {
                    $predio->coordenadas()->delete(); // Eliminar todas las coordenadas
                } else {
                    // Actualizar coordenadas
                    if (isset($validated['latitud']) && isset($validated['longitud'])) {
                        $predio->coordenadas()->delete(); // Borra las coordenadas actuales
        
                        foreach ($validated['latitud'] as $index => $latitud) {
                            if ($latitud && isset($validated['longitud'][$index])) {
                                $predio->coordenadas()->create([
                                    'latitud' => $latitud,
                                    'longitud' => $validated['longitud'][$index],
                                ]);
                            }
                        }
                    }
                }
        
                // Manejar plantaciones
                if (isset($validated['id_tipo']) && isset($validated['numero_plantas']) &&
                    isset($validated['edad_plantacion']) && isset($validated['tipo_plantacion'])) {
        
                    $predio->predio_plantaciones()->delete(); // Borra las plantaciones actuales
        
                    foreach ($validated['id_tipo'] as $index => $id_tipo) {
                        if ($id_tipo && isset($validated['numero_plantas'][$index])) {
                            $predio->predio_plantaciones()->create([
                                'id_tipo' => $id_tipo,
                                'num_plantas' => $validated['numero_plantas'][$index],
                                'anio_plantacion' => $validated['edad_plantacion'][$index],
                                'tipo_plantacion' => $validated['tipo_plantacion'][$index],
                            ]);
                        }
                    }
                }
        
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
        
        
        public function PdfPreRegistroPredios($id_predio)
        {   

            $datos = Predios::with(['predio_plantaciones.tipo','empresa.empresaNumClientes'])->find($id_predio);
            $comunal = '___';
            $ejidal = '___';
            $propiedad = '___';
            $otro = '___';

            switch ($datos->tipo_predio) {
                case 'Comunal':
                    $comunal = 'X';
                    break;
                case 'Ejidal':
                    $ejidal = 'X';
                    break;
                case 'Propiedad Privada':
                    $propiedad = 'X';
                    break;
                case 'Otro':
                    $otro = 'X';
                    break;
            }


            $pdf = Pdf::loadView('pdfs.Pre-registro_predios', ['datos'=>$datos, 'comunal' => $comunal, 'ejidal' => $ejidal, 'propiedad' => $propiedad, 'otro' => $otro]);
            return $pdf->stream('F-UV-21-01 Pre-registro de predios de maguey o agave Ed.1 Vigente.pdf');
        }
        

}
