<?php

namespace App\Http\Controllers\domicilios;

use App\Http\Controllers\Controller;
use App\Models\Instalaciones;
use App\Models\Empresa;
use App\Models\Estados;
use App\Models\Organismos;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DomiciliosController extends Controller
{
    public function UserManagement()
    {
        $instalaciones = Instalaciones::all(); // Obtener todas las instalaciones
        $empresas = Empresa::all(); // Obtener todas las empresas
        $estados = Estados::all(); // Obtener todos los estados
        $organismos = Organismos::all(); // Obtener todos los organismos
        return view('domicilios.find_domicilio_instalaciones_view', compact('instalaciones', 'empresas', 'estados', 'organismos'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_instalacion',
            2 => 'tipo',
            3 => 'estado',
            4 => 'direccion_completa',
            5 => 'folio',
            6 => 'id_organismo',
        ];

        $search = [];

        $totalData = Instalaciones::whereHas('empresa', function($query) {
            $query->where('tipo', 2);
        })->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $instalaciones = Instalaciones::with('empresa', 'estados', 'organismos')
                ->whereHas('empresa', function($query) {
                    $query->where('tipo', 2);
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $instalaciones = Instalaciones::with('empresa', 'estados', 'organismos')
                ->whereHas('empresa', function($query) {
                    $query->where('tipo', 2);
                })
                ->where(function($query) use ($search) {
                    $query->where('id_instalacion', 'LIKE', "%{$search}%")
                        ->orWhere('direccion_completa', 'LIKE', "%{$search}%")
                        ->orWhere('estado', 'LIKE', "%{$search}%")
                        ->orWhere('folio', 'LIKE', "%{$search}%")
                        ->orWhere('id_organismo', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Instalaciones::with('empresa', 'estados', 'organismos')
                ->whereHas('empresa', function($query) {
                    $query->where('tipo', 2);
                })
                ->where(function($query) use ($search) {
                    $query->where('id_instalacion', 'LIKE', "%{$search}%")
                        ->orWhere('direccion_completa', 'LIKE', "%{$search}%")
                        ->orWhere('estado', 'LIKE', "%{$search}%")
                        ->orWhere('folio', 'LIKE', "%{$search}%")
                        ->orWhere('id_organismo', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = [];

        if (!empty($instalaciones)) {
            $ids = $start;

            foreach ($instalaciones as $instalacion) {
                $nestedData['id_instalacion'] = $instalacion->id_instalacion ?? 'N/A';
                $nestedData['fake_id'] = ++$ids  ?? 'N/A';
                $nestedData['razon_social'] = $instalacion->empresa->razon_social  ?? 'N/A';
                $nestedData['tipo'] = $instalacion->tipo  ?? 'N/A';
                $nestedData['estado'] = $instalacion->estados->nombre  ?? 'N/A';
                $nestedData['direccion_completa'] = $instalacion->direccion_completa  ?? 'N/A';
                $nestedData['folio'] = $instalacion->folio ?? 'N/A'; // Corregido 'folion' a 'folio'
                $nestedData['organismo'] = $instalacion->organismos->organismo ?? 'N/A'; // Maneja el caso donde el organismo sea nulo
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
        try {
            $instalacion = Instalaciones::findOrFail($id_instalacion);
            $instalacion->delete();

            return response()->json(['success' => 'Instalación eliminada correctamente']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Instalación no encontrada'], 404);
}
}

    public function store(Request $request)
    {
        $request->validate([
          'id_empresa' => 'required|exists:empresa,id_empresa',
            'tipo' => 'required|string',
            'estado' => 'required|exists:estados,id',
            'direccion_completa' => 'required|string',
        ]);

        try {
            Instalaciones::create([
                'id_empresa' => $request->input('id_empresa'),
                'tipo' => $request->input('tipo'),
                'estado' => $request->input('estado'),
                'direccion_completa' => $request->input('direccion_completa'),
            ]);

            return response()->json(['code' => 200, 'message' => 'Instalación registrada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error al registrar la instalación.']);
     }
}

}
