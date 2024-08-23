<?php

namespace App\Http\Controllers\hologramas;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\empresa;
use App\Models\solicitudHolograma as ModelsSolicitudHolograma;
use Illuminate\Http\Request;

class solicitudHolograma extends Controller
{
    public function UserManagement()
    {
        $instalaciones = ModelsSolicitudHolograma::all(); // Obtener todas las instalaciones
        $empresas = empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
  
       
        return view('inspecciones.find_inspecciones_view', compact('instalaciones', 'empresas'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_solicitud',
            2 => 'folio',
            3 => 'num_servicio',
            4 => 'razon_social',
            5 => 'fecha_solicitud',
            6 => 'tipo',
            7 => 'direccion_completa',
            8 => 'inspector',
            9 => 'fecha_servicio',
            10 => 'fecha_visita',
            11 => 'name',
        ];

        $search = [];

        $totalData = solicitudHolograma::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

       

        if (empty($request->input('search.value'))) {
           

                $solicitudes = solicitudHolograma::with('empresa','inspeccion','inspector', 'instalacion')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

        } else {
            $search = $request->input('search.value');

            $query = solicitudHolograma::with('empresa');
            dd($query->toSql());
            

            $solicitudes = solicitudHolograma::with('empresa','inspeccion','inspector', 'instalacion')
                ->where(function ($query) use ($search) {
                    $query->where('id_solicitud', 'LIKE', "%{$search}%")
                        ->orWhere('razon_social', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered =  solicitudHolograma::with('empresa','inspeccion','inspector', 'instalacion')
                ->where(function ($query) use ($search) {
                    $query->where('id_solicitud', 'LIKE', "%{$search}%")
                        ->orWhere('razon_social', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = [];

        if (!empty($solicitudes)) {
            $ids = $start;

            foreach ($solicitudes as $solicitud) {
                $nestedData['id_solicitud'] = $solicitud->id_solicitud ?? 'N/A';
                $nestedData['fake_id'] = ++$ids  ?? 'N/A';
                $nestedData['folio'] = '<b class="text-primary">'.$solicitud->folio.'</b>';
                 $nestedData['num_servicio'] = $solicitud->inspeccion->num_servicio ?? '<span class="badge bg-danger">Sin asignar</apan>';
                $nestedData['razon_social'] = $solicitud->empresa->razon_social  ?? 'N/A';
                $nestedData['fecha_solicitud'] = Helpers::formatearFechaHora($solicitud->fecha_solicitud)  ?? 'N/A';
                $nestedData['tipo'] = $solicitud->tipo  ?? 'N/A';
                $nestedData['direccion_completa'] = $solicitud->instalacion->direccion_completa  ?? 'N/A';
                $nestedData['fecha_visita'] = Helpers::formatearFechaHora($solicitud->fecha_visita)  ?? '<span class="badge bg-danger">Sin asignar</apan>';
                $nestedData['inspector'] = $solicitud->inspector->name ?? '<span class="badge bg-danger">Sin asignar</apan>'; // Maneja el caso donde el organismo sea nulo
                $nestedData['fecha_servicio'] = Helpers::formatearFecha(optional($solicitud->inspeccion)->fecha_servicio) ?? '<span class="badge bg-danger">Sin asignar</apan>';



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
}
