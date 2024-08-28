<?php

namespace App\Http\Controllers\certificados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificados;
use App\Models\Dictamen_instalaciones;
use App\Models\Empresa; // Asegúrate de tener este modelo si `id_empresa` es una clave foránea

class Certificado_InstalacionesController extends Controller
{
    public function UserManagement()
    {
        // Obtener todos los dictámenes
        $dictamenes = Dictamen_instalaciones::all();

        // Pasar los dictámenes a la vista
        return view('certificados.certificados_instalaciones_view', compact('dictamenes'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'num_dictamen',
            2 => 'num_certificado',
            3 => 'maestro_mezcalero',
            4 => 'fecha_vigencia',
            5 => 'fecha_vencimiento',
        ];

        $search = [];

        // Obtener el total de registros sin filtro
        $certificados_temp = Certificados::with('dictamen')->get();
        $totalData = $certificados_temp->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        // Validar el índice del orden
        $order = isset($columns[$orderIndex]) ? $columns[$orderIndex] : 'num_certificado'; // Valor predeterminado
        $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc'; // Valor predeterminado

        if (empty($request->input('search.value'))) {
            $certificados = Certificados::with('dictamen')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $certificados = Certificados::with('dictamen')
                ->where('num_certificado', 'LIKE', "%{$search}%")
                ->orWhere('maestro_mezcalero', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Certificados::with('dictamen')
                ->where('num_certificado', 'LIKE', "%{$search}%")
                ->orWhere('maestro_mezcalero', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($certificados)) {
            // Providing a dummy id instead of database ids
            $ids = $start;

            foreach ($certificados as $certificado) {
                $nestedData['id_certificado'] = $certificado->id_certificado;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['num_certificado'] = $certificado->num_certificado;
                $nestedData['fecha_vigencia'] = $certificado->fecha_vigencia;
                $nestedData['fecha_vencimiento'] = $certificado->fecha_vencimiento;
                $nestedData['maestro_mezcalero'] = $certificado->maestro_mezcalero;
                $nestedData['num_dictamen'] = $certificado->dictamen->num_dictamen ?? 'No disponible';

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

    // Función para eliminar
    public function destroy($id_certificado)
    {
        $certificado = Certificados::findOrFail($id_certificado);
        $certificado->delete();

        return response()->json(['success' => 'Certificado eliminado correctamente']);
    }

}
