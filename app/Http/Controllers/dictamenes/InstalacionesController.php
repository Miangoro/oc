<?php

namespace App\Http\Controllers\dictamenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dictamen_instalaciones;
use App\Models\Clases; 


class InstalacionesController extends Controller
{

  public function UserManagement()
    {
        $dictamenes = Dictamen_instalaciones::all(); // Obtener todos los datos
        $clases = Clases::all();
        return view('dictamenes.dictamen_instalaciones_view', compact('dictamenes', 'clases'));
    }


    public function index(Request $request)
    {
        $columns = [
            1 => 'id_dictamen',
            2 => 'tipo_dictamen',
            3 => 'num_dictamen',
            4 => 'id_inspeccion',
            5 => 'fecha_emision',
        ];

        $search = [];
        
        $totalData = Dictamen_instalaciones::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = Dictamen_instalaciones::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = Dictamen_instalaciones::where('id_dictamen', 'LIKE', "%{$search}%")
                ->orWhere('tipo_dictamen', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Dictamen_instalaciones::where('id_dictamen', 'LIKE', "%{$search}%")
                ->orWhere('tipo_dictamen', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id_dictamen'] = $user->id_dictamen;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['tipo_dictamen'] = $user->tipo_dictamen;
                $nestedData['num_dictamen'] = $user->num_dictamen;
                $nestedData['id_inspeccion'] = $user->id_inspeccion;
                $nestedData['fecha_emision'] = $user->fecha_emision;

                $data[] = $nestedData;
            }
        }

        if ($data) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'code' => 200,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
                'data' => [],
            ]);
        }
    }


// Función para agregar registro
     public function store(Request $request)
        {
            $request->validate([
                'tipo_dictamen' => 'required|integer',
                'num_dictamen' => 'required|string|max:255',
                'fecha_emision' => 'nullable|date',
                'fecha_vigencia' => 'nullable|date',
                'categorias' => 'required|string|max:255',
                //'id_clase' => 'integer|exists:catalogo_clases,id_clase',
            ]);
    
            try {
                $var = new Dictamen_instalaciones();
                $var->tipo_dictamen = $request->tipo_dictamen;
                $var->num_dictamen = $request->num_dictamen;
                $var->fecha_emision = $request->fecha_emision;
                //$var->fecha_emision = $request->fecha_emision[$index] ?? null;
                $var->fecha_vigencia = $request->fecha_vigencia;
                $var->categorias = $request->categorias;
                //$var->id_clase = $request['id_clase'];
    
                $var->save();//guardar en BD
    
                return response()->json(['success' => 'Registro agregada correctamente']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al agregar'], 500);
            }
        }


}
