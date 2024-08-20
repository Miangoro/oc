<?php

namespace App\Http\Controllers\inspecciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Documentacion_url;
use App\Models\Instalaciones;
use App\Models\Empresa;
use App\Models\Estados;
use App\Models\Organismos;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helpers;
use App\Models\inspecciones;
use App\Models\solicitudesModel;
use App\Models\User;

class inspeccionesController extends Controller
{
    public function UserManagement()
    {
        $instalaciones = Instalaciones::all(); // Obtener todas las instalaciones
        $empresas = Empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $estados = Estados::all(); // Obtener todos los estados
     
        $inspectores = User::where('tipo','=','2')->get(); // Obtener todos los organismos
        return view('inspecciones.find_inspecciones_view', compact('instalaciones', 'empresas', 'estados', 'inspectores'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_solicitud',
            2 => 'folio',
            3 => 'razon_social',
            4 => 'fecha_solicitud',
            5 => 'num_servicio',
            6 => 'tipo',
            7 => 'inspector',
            8 => 'fecha_servicio',
            9 => 'fecha_visita',
            10 => 'name',
        ];

        $search = [];

        $totalData = solicitudesModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

       

        if (empty($request->input('search.value'))) {
           

                $solicitudes = solicitudesModel::with('empresa','inspeccion','inspector')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

        } else {
            $search = $request->input('search.value');

            $query = solicitudesModel::with('empresa');
            dd($query->toSql());
            

            $solicitudes = solicitudesModel::with('empresa','inspeccion','inspector')
                ->where(function ($query) use ($search) {
                    $query->where('id_solicitud', 'LIKE', "%{$search}%")
                        ->orWhere('razon_social', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered =  solicitudesModel::with('empresa','inspeccion','inspector')
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
                $nestedData['razon_social'] = $solicitud->empresa->razon_social  ?? 'N/A';
                $nestedData['fecha_solicitud'] = Helpers::formatearFechaHora($solicitud->fecha_solicitud)  ?? 'N/A';
                $nestedData['num_servicio'] = $solicitud->inspeccion->num_servicio ?? '<span class="badge bg-danger">Sin asignar</apan>';
                $nestedData['tipo'] = $solicitud->tipo  ?? 'N/A';
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


    public function edit($id_instalacion)
    {
        try {
            // Obtener la instalación y sus documentos asociados
            $instalacion = Instalaciones::findOrFail($id_instalacion);

            // Obtener los documentos asociados
            $documentacion_urls = Documentacion_url::where('id_relacion', $id_instalacion)->get();

            // Extraer la URL del primer documento, si existe
            $archivo_url = $documentacion_urls->isNotEmpty() ? $documentacion_urls->first()->url : '';

            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $instalacion->id_empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

            return response()->json([
                'success' => true,
                'instalacion' => $instalacion,
                'archivo_url' => $archivo_url, // Incluir la URL del archivo
                'numeroCliente' => $numeroCliente
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false], 404);
        }
    }

        public function asignarInspector(Request $request){
    
                // Asignar o actualizar la inspección
                $asignar = inspecciones::updateOrCreate(
                    [
                        'id_solicitud' => $request->id_solicitud, 
                    ],
                    [   
                        'id_inspector' => $request->id_inspector,
                        'num_servicio' => $request->num_servicio,
                        'fecha_servicio' => $request->fecha_servicio,
                        'estatus_inspeccion' => 1, // Es pendiente
                        'observaciones' => $request->observaciones ?? '',
                    ]
                );
        }


 
}
