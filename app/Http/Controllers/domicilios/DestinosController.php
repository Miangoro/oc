<?php

namespace App\Http\Controllers\domicilios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Destinos;

class DestinosController extends Controller
{
    
    public function UserManagement()
    {
        // Obtener todos los registros de destinos con la relación empresa cargada
        $destinos = Destinos::with('empresa')->get();

        // Obtener solo las empresas tipo '2'
        $empresas = Empresa::where('tipo', 2)->get();

        // Pasar los datos a la vista
        return view('domicilios.find_domicilio_destinos_view', [
            'destinos' => $destinos,
            'empresas' => $empresas,
        ]);
        }

        public function index(Request $request)
        {
            $columns = [
                1 => 'id_direccion',
                2 => 'tipo_direccion',
                3 => 'id_empresa',
                4 => 'direccion',
                5 => 'destinatario',
                6 => 'aduana',
                7 => 'pais_destino',
                8 => 'nombre_recibe',
                9 => 'correo_recibe',
                10 => 'celular_recibe',
            ];
        
            $search = [];
        
            // Obtener el total de registros filtrados
            $totalData = Destinos::whereHas('empresa', function ($query) {
                $query->where('tipo', 2);
            })->count();
        
            $totalFiltered = $totalData;
        
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
        
            if (empty($request->input('search.value'))) {
                $destinos = Destinos::with('empresa') // Carga la relación
                    ->whereHas('empresa', function ($query) {
                        $query->where('tipo', 2);
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');
        
                $destinos = Destinos::with('empresa')
                    ->whereHas('empresa', function ($query) {
                        $query->where('tipo', 2);
                    })
                    ->where(function ($query) use ($search) {
                        $query->whereHas('empresa', function ($q) use ($search) {
                            $q->where('razon_social', 'LIKE', "%{$search}%");
                        })
                            ->orWhere('direccion', 'LIKE', "%{$search}%")
                            ->orWhere('destinatario', 'LIKE', "%{$search}%")
                            ->orWhere('aduana', 'LIKE', "%{$search}%")
                            ->orWhere('pais_destino', 'LIKE', "%{$search}%")
                            ->orWhere('nombre_recibe', 'LIKE', "%{$search}%")
                            ->orWhere('correo_recibe', 'LIKE', "%{$search}%")
                            ->orWhere('celular_recibe', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
        
                $totalFiltered = Destinos::with('empresa')
                    ->whereHas('empresa', function ($query) {
                        $query->where('tipo', 2);
                    })
                    ->where(function ($query) use ($search) {
                        $query->whereHas('empresa', function ($q) use ($search) {
                            $q->where('razon_social', 'LIKE', "%{$search}%");
                        })
                            ->orWhere('direccion', 'LIKE', "%{$search}%")
                            ->orWhere('destinatario', 'LIKE', "%{$search}%")
                            ->orWhere('aduana', 'LIKE', "%{$search}%")
                            ->orWhere('pais_destino', 'LIKE', "%{$search}%")
                            ->orWhere('nombre_recibe', 'LIKE', "%{$search}%")
                            ->orWhere('correo_recibe', 'LIKE', "%{$search}%")
                            ->orWhere('celular_recibe', 'LIKE', "%{$search}%");
                    })
                    ->count();
            }
        
            $data = [];
        
            if (!empty($destinos)) {
                $ids = $start;
        
                foreach ($destinos as $destino) {
                    $nestedData['id_direccion'] = $destino->id_direccion;
                    $nestedData['fake_id'] = ++$ids;
                    $nestedData['tipo_direccion'] = $destino->tipo_direccion;
                    $nestedData['id_empresa'] = $destino->empresa->razon_social;
                    $nestedData['direccion'] = $destino->direccion;
                    $nestedData['destinatario'] = $destino->destinatario ?? 'N/A';
                    $nestedData['aduana'] = $destino->aduana ?? 'N/A';
                    $nestedData['pais_destino'] = $destino->pais_destino ?? 'N/A';
                    $nestedData['nombre_recibe'] = $destino->nombre_recibe ?? 'N/A';
                    $nestedData['correo_recibe'] = $destino->correo_recibe ?? 'N/A';
                    $nestedData['celular_recibe'] = $destino->celular_recibe ?? 'N/A';
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
            public function destroy($id_direccion)
            {
                try {
                    $destino = Destinos::findOrFail($id_direccion);
                     $destino->delete();
                
                     return response()->json(['success' => 'Direccion eliminada correctamente']);
                } catch (\Exception $e) {
                     return response()->json(['error' => 'Error al eliminar la dirección ' . $e->getMessage()], 500);
                 }
            }

            public function store(Request $request)
            {
                // Validar los datos del formulario
                $validated = $request->validate([
                    'tipo_direccion' => 'required|string',
                    'id_empresa' => 'required|exists:empresa,id_empresa',
                    'direccion' => 'required|string',
                    'destinatario' => 'nullable|string',
                    'aduana' => 'nullable|string',
                    'pais_destino' => 'nullable|string',
                    'nombre_recibe' => 'nullable|string',
                    'correo_recibe' => 'nullable|email',
                    'celular_recibe' => 'nullable|string',
                ]);
            
                // Crear una nueva instancia del modelo Predios
                $destino = new Destinos();
                $destino->tipo_direccion = $validated['tipo_direccion'];
                $destino->id_empresa = $validated['id_empresa'];
                $destino->direccion = $validated['direccion'];
                $destino->destinatario = $validated['destinatario'];
                $destino->aduana = $validated['aduana'];
                $destino->pais_destino = $validated['pais_destino'];
                $destino->nombre_recibe = $validated['nombre_recibe'];
                $destino->correo_recibe = $validated['correo_recibe'];
                $destino->celular_recibe = $validated['celular_recibe'];


            
                // Guardar el nuevo predio en la base de datos
                $destino->save();
        
            
                // Retornar una respuesta
                return response()->json([
                    'success' => true,
                    'message' => 'Domicilio de destino registrado exitosamente',
                ]);
            }

            //funcion para llenar el campo del formulario
    public function edit($id_direccion)
    {

        try {
            $destino = Destinos::findOrFail($id_direccion);
            return response()->json($destino);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el domicilio de destino'], 500);
        }
    }

    public function update(Request $request, $id_direccion)
    {
        try {
            // Validar los datos del formulario
            $validated = $request->validate([
                'tipo_direccion' => 'required|string',
                'id_empresa' => 'required|exists:empresa,id_empresa',
                'direccion' => 'required|string',
                'destinatario' => 'nullable|string',
                'aduana' => 'nullable|string',
                'pais_destino' => 'nullable|string',
                'nombre_recibe' => 'nullable|string',
                'correo_recibe' => 'nullable|email',
                'celular_recibe' => 'nullable|string',
            ]);
            
            $destino = Destinos::findOrFail($id_direccion);
            
            // Actualizar destino
            $destino->update([
                'tipo_direccion' => $validated['tipo_direccion'],
                'id_empresa' => $validated['id_empresa'],
                'direccion' => $validated['direccion'],
                'destinatario' => $validated['destinatario'],
                'aduana' => $validated['aduana'],
                'pais_destino' => $validated['pais_destino'],
                'nombre_recibe' => $validated['nombre_recibe'],
                'correo_recibe' => $validated['correo_recibe'],
                'celular_recibe' => $validated['celular_recibe'],
            ]);
    
            // Devolver una respuesta de éxito
            return response()->json([
                'success' => true,
                'message' => 'Destino actualizado correctamente.',
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el domicilio de destino: ' . $e->getMessage(),
            ], 500);
        }
    }
               
}