<?php

namespace App\Http\Controllers\dictamenes;

use App\Http\Controllers\Controller;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;
use App\Models\inspecciones; 
use App\Models\empresa; 
use App\Models\Documentacion;
use App\Models\Documentacion_url;
use App\Models\solicitudesModel;
use App\Models\LotesGranel;
use App\Models\Dictamen_Granel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


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
            9 => 'estatus',
        ];
    
        $search = $request->input('search.value');
        $totalData = Dictamen_Granel::count();
        $totalFiltered = $totalData;
    
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
    
        $query = Dictamen_Granel::with(['inspeccion', 'empresa', 'lote_granel']);
    
        if (!empty($search)) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('id_dictamen', 'LIKE', "%{$search}%")
                    ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
                    ->orWhereHas('empresa', function ($q) use ($search) {
                        $q->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('inspeccion', function ($q) use ($search) {
                        $q->where('num_servicio', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('lote_granel', function ($q) use ($search) {
                        $q->where('nombre_lote', 'LIKE', "%{$search}%");
                        $q->orWhere('folio_fq', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('estatus', 'LIKE', "%{$search}%");
            });
    
            $totalFiltered = $query->count();
        }
    
        $dictamenes = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    
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
                $nestedData['folio_fq'] = $dictamen->lote_granel->folio_fq ?? 'N/A';
                $nestedData['fecha_emision'] = Helpers::formatearFecha($dictamen->fecha_emision);
                $nestedData['fecha_vigencia'] = Helpers::formatearFecha($dictamen->fecha_vigencia);
                $nestedData['fecha_servicio'] = Helpers::formatearFecha($dictamen->fecha_servicio);
                $nestedData['estatus'] = $dictamen->estatus;
    
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
    
/* funcion para eliminar */
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


/* funcion para insertar datos */
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
    
    /* obtener los datos de los registros */
    
    public function edit($id_dictamen)
    {
        try {
            // Cargar el dictamen específico
            $dictamen = Dictamen_Granel::findOrFail($id_dictamen);
            return response()->json([
                'success' => true,
                'dictamen' => $dictamen, // Enviar el dictamen específico
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false], 404);
        }
    }
    

    /* funcion para actualizar */
    public function update(Request $request, $id_dictamen)
    {
        try {
            // Validar los datos del formulario
            $validated = $request->validate([
                'num_dictamen' => 'required|string|max:70',
                'id_empresa' => 'required|exists:empresa,id_empresa',
                'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
                'id_lote_granel' => 'required|integer|exists:lotes_granel,id_lote_granel',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'required|date',
                'fecha_servicio' => 'required|date'
            ]);
    
            $dictamen = Dictamen_Granel::findOrFail($id_dictamen);

            // Actualizar lote
            $dictamen->update([
                'num_dictamen' => $validated['num_dictamen'],
                'id_empresa' => $validated['id_empresa'],
                'id_inspeccion' => $validated['id_inspeccion'],
                'id_lote_granel' => $validated['id_lote_granel'],
                'fecha_emision' => $validated['fecha_emision'],
                'fecha_vigencia' => $validated['fecha_vigencia'],
                'fecha_servicio' => $validated['fecha_servicio'],
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Dictamen a granel actualizado exitosamente',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar el el dictamen a granel:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }


public function dictamenDeCumplimientoGranel($id_dictamen)
{
    // Obtener los datos del dictamen específico
    $data = Dictamen_Granel::find($id_dictamen);

    if (!$data) {
        return abort(404, 'Dictamen no encontrado');
    }

    // Verifica qué valor tiene esta variable

    $fecha_emision = Helpers::formatearFecha($data->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($data->fecha_vigencia);
    $fecha_servicio = Helpers::formatearFecha($data->fecha_servicio);

    // Determinar si la marca de agua debe ser visible
    $watermarkText = $data->estatus === 'Cancelado';

    $pdf = Pdf::loadView('pdfs.DictamenDeCumplimientoMezcalGranel', [
        'data' => $data,
        'fecha_servicio' => $fecha_servicio,
        'fecha_emision' => $fecha_emision,
        'fecha_vigencia' => $fecha_vigencia,
        'watermarkText' => $watermarkText,
    ]);
   
    return $pdf->stream('F-UV-04-16 Ver 7 Dictamen de Cumplimiento NOM Mezcal a Granel.pdf');
}

     
    public function foliofq($id_dictamen)
    {
        try {
            Log::info('ID del Dictamen: ' . $id_dictamen);
    
            // Buscar el lote a granel asociado con el dictamen
            $dictamen = Dictamen_Granel::find($id_dictamen);
    
            if (!$dictamen) {
                Log::error('Dictamen no encontrado para el ID: ' . $id_dictamen);
                return response()->json(['success' => false, 'message' => 'Dictamen no encontrado'], 404);
            }
    
            $lote = LotesGranel::find($dictamen->id_lote_granel);
    
            if (!$lote) {
                Log::error('Lote a granel no encontrado para el ID: ' . $dictamen->id_lote_granel);
                return response()->json(['success' => false, 'message' => 'Lote a granel no encontrado'], 404);
            }
    
            // Obtener los documentos asociados al lote a granel
            $documentos = Documentacion_url::where('id_relacion', $lote->id_lote_granel)->get();
    
            Log::info('Documentos obtenidos: ', $documentos->toArray());
    
            $documentosConUrl = $documentos->map(function ($documento) {
                return [
                    'id_documento' => $documento->id_documento,
                    'nombre' => $documento->nombre_documento,
                    'url' => $documento->url,
                    'tipo' => $documento->nombre_documento
                ];
            });
    
            $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
            if (!$empresa) {
                Log::error('Empresa no encontrada para el ID: ' . $lote->id_empresa);
                return response()->json(['success' => false, 'message' => 'Empresa no encontrada'], 404);
            }
    
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
    
            $archivoUrlOtroOrganismo = $lote->tipo_lote == '2' ? $lote->url_certificado : '';
    
            return response()->json([
                'success' => true,
                'lote' => $lote,
                'documentos' => $documentosConUrl,
                'numeroCliente' => $numeroCliente,
                'archivo_url_otro_organismo' => $archivoUrlOtroOrganismo
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error('Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error en la solicitud'], 500);
        }
    }
    



}
