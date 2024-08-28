<?php

namespace App\Http\Controllers\dictamenes;

use App\Http\Controllers\Controller;
use App\Helpers\Helpers;
use App\Models\inspecciones; 
use App\Models\empresa; 
use App\Models\solicitudesModel;
use App\Models\LotesGranel;
use App\Models\Dictamen_Granel;
use Illuminate\Http\Request;

class DictamenGranelController extends Controller
{
    public function UserManagement()
    {
        // Obtener los datos necesarios
        $inspecciones = inspecciones::all();
        $empresas = Empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $lotesGranel = LotesGranel::all();
    
        // Pasar los datos a la vista
        return view('dictamenes.dictamen_granel_view', compact('inspecciones', 'empresas', 'lotesGranel'));
    }
    

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_dictamen',
            2 => 'num_dictamen',
            3 => 'id_empresa',
            4 => 'id_inspeccion',
            5 => 'id_lote_granel',
            6 => 'fecha_emision',
            7 => 'fecha_vigencia',
            8 => 'fecha_servicio',
        ];

        $search = [];

        $totalData = Dictamen_Granel::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $dictamenes = Dictamen_Granel::with('inspeccion', 'empresa', 'lote_granel')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $dictamenes = Dictamen_Granel::with('inspeccion', 'empresa', 'lote_granel')
                ->where('id_dictamen', 'LIKE', "%{$search}%")
                ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Dictamen_Granel::where('id_dictamen', 'LIKE', "%{$search}%")
                ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($dictamenes)) {
            $ids = $start;

            foreach ($dictamenes as $dictamen) {
                $nestedData['id_dictamen'] = $dictamen->id_dictamen;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['num_dictamen'] = $dictamen->num_dictamen;
                $nestedData['id_empresa'] = $dictamen->empresa->razon_social ?? 'N/A';
                $nestedData['id_inspeccion'] = $dictamen->inspeccion->num_servicio ?? 'N/A';
                $nestedData['id_lote_granel'] = $dictamen->lote_granel->nombre_lote ?? 'N/A';
                $nestedData['fecha_emision'] = Helpers::formatearFecha($dictamen->fecha_emision);
                $nestedData['fecha_vigencia'] = Helpers::formatearFecha($dictamen->fecha_vigencia);
                $nestedData['fecha_servicio'] = Helpers::formatearFecha($dictamen->fecha_servicio);
           
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

    public function destroy($id_dictamen)
    {
        try {
            $dictamen = Dictamen_Granel::findOrFail($id_dictamen);
            $dictamen->delete();

            return response()->json(['success' => 'dictamen eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el dictamen'], 500);
        }
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'num_dictamen' => 'required|string|max:70',
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
            'id_lote_granel' => 'required|integer|exists:lotes_granel,id_lote_granel',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'fecha_servicio' => 'required|date'
        ]);
        
        // Crear una nueva instancia del modelo Dictamen_Granel
        $dictamen = new Dictamen_Granel();
        $dictamen->num_dictamen = $validatedData['num_dictamen'];
        $dictamen->id_empresa = $validatedData['id_empresa'];
        $dictamen->id_inspeccion = $validatedData['id_inspeccion'];
        $dictamen->id_lote_granel = $validatedData['id_lote_granel'];
        $dictamen->fecha_emision = $validatedData['fecha_emision'];
        $dictamen->fecha_vigencia = $validatedData['fecha_vigencia'];
        $dictamen->fecha_servicio = $validatedData['fecha_servicio'];
        $dictamen->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Dictamen registrado exitosamente',
        ]);
    }
    

    

}
