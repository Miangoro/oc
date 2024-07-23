<?php

namespace App\Http\Controllers\domicilios;

use App\Http\Controllers\Controller;
use App\Models\Instalaciones;
use App\Models\Empresa;
use Illuminate\Http\Request;

class DomiciliosController extends Controller
{
    public function UserManagement()
    {
        $instalaciones = Instalaciones::all(); // Obtener todas las instalaciones
        return view('domicilios.find_domicilio_instalaciones_view', compact('instalaciones'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_instalacion',
            2 => 'tipo',
            3 => 'estado',
            4 => 'direccion_completa',
        ];

        $search = [];

        $totalData = Instalaciones::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $instalaciones = Instalaciones::with('empresa')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $instalaciones = Instalaciones::with('empresa')
                ->where('id_instalacion', 'LIKE', "%{$search}%")
                ->orWhere('direccion_completa', 'LIKE', "%{$search}%")
                ->orWhere('estado', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Instalaciones::with('empresa')
                ->where('id_instalacion', 'LIKE', "%{$search}%")
                ->orWhere('direccion_completa', 'LIKE', "%{$search}%")
                ->orWhere('estado', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($instalaciones)) {
            // Providing a dummy id instead of database ids
            $ids = $start;

            foreach ($instalaciones as $instalacion) {
                $nestedData['id_instalacion'] = $instalacion->id_instalacion;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['razon_social'] = $instalacion->empresa->razon_social;
                $nestedData['tipo'] = $instalacion->tipo;
                $nestedData['estado'] = $instalacion->estado;
                $nestedData['direccion_completa'] = $instalacion->direccion_completa;

                // Agregar una acción para eliminar el registro
                $nestedData['actions'] = '<button class="btn btn-danger btn-sm delete-record" data-id="' . $instalacion->id_instalacion . '">Eliminar</button>';

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

    public function destroy($id_instalacion)
    {
        $instalacion = Instalaciones::findOrFail($id_instalacion);
        $instalacion->delete();
    
        return response()->json(['success' => 'Instalación eliminada correctamente']);
    }
    
}
