<?php

namespace App\Http\Controllers\certificados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificados;
use App\Models\Dictamen_instalaciones;

class Certificado_InstalacionesController extends Controller
{
    public function UserManagement()
    {
        $dictamenes = Dictamen_instalaciones::all();
        return view('certificados.certificados_instalaciones_view', compact('dictamenes'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_certificado',
            2 => 'num_certificado',
            3 => 'fecha_vigencia',
            4 => 'fecha_vencimiento',
            5 => 'maestro_mezcalero',
        ];
    
        try {
            $totalData = Certificados::count();
            $totalFiltered = $totalData;
    
            $limit = $request->input('length', 10);
            $start = $request->input('start', 0);
            $order = $columns[$request->input('order.0.column', 0)] ?? 'id_certificado';
            $dir = $request->input('order.0.dir', 'asc');
    
            if (empty($request->input('search.value'))) {
                $certificados = Certificados::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');
    
                $certificados = Certificados::where('num_certificado', 'LIKE', "%{$search}%")
                    ->orWhere('maestro_mezcalero', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
    
                $totalFiltered = Certificados::where('num_certificado', 'LIKE', "%{$search}%")
                    ->orWhere('maestro_mezcalero', 'LIKE', "%{$search}%")
                    ->count();
            }
    
            $data = [];
            foreach ($certificados as $certificado) {
                $data[] = [
                    'id_certificado' => $certificado->id_certificado,
                    'num_certificado' => $certificado->num_certificado,
                    'fecha_vigencia' => $certificado->fecha_vigencia,
                    'fecha_vencimiento' => $certificado->fecha_vencimiento,
                    'maestro_mezcalero' => $certificado->maestro_mezcalero,
                ];
            }
    
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Error en el método index del controlador Certificado_InstalacionesController: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

public function destroy($id_certificado)
{
    try {
        // Encuentra el certificado por ID
        $certificado = Certificados::findOrFail($id_certificado);
        
        // Elimina el certificado
        $certificado->delete();
        
        // Respuesta JSON para éxito
        return response()->json(['success' => 'Certificado eliminado correctamente.']);
    } catch (\Exception $e) {
        // Respuesta JSON para error
        return response()->json(['error' => 'Error al eliminar el certificado: ' . $e->getMessage()], 500);
    }
}


}
