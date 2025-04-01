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
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class DictamenGranelController extends Controller
{
    public function UserManagement()
    {
        // Obtener los datos necesarios
        $inspecciones = inspecciones::all();
        $empresas = Empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $inspectores = User::where('tipo', 2)->get(); // Obtener solo los usuarios con tipo '2' (inspectores)
        $lotesGranel = LotesGranel::all();
    
        // Pasar los datos a la vista
        return view('dictamenes.dictamen_granel_view', compact('inspecciones', 'empresas', 'lotesGranel', 'inspectores'));
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
    
        $query = Dictamen_Granel::with(['inspeccione', 'empresa', 'lote_granel']);
    
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
        ->orderByRaw("
        CAST(SUBSTRING_INDEX(num_dictamen, '/', -1) AS UNSIGNED) DESC, -- Ordena el año (parte después de '/')
        CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(num_dictamen, '-', -1), '/', 1) AS UNSIGNED) DESC -- Ordena el consecutivo (parte entre '-' y '/')")
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    
        $data = [];
        if (!empty($dictamenes)) {
            $ids = $start;
    
            foreach ($dictamenes as $dictamen) {
                $nestedData['id_dictamen'] = $dictamen->id_dictamen;
                $nestedData['num_dictamen'] = $dictamen->num_dictamen;
                $nestedData['id_inspeccion'] = $dictamen->inspeccione->num_servicio ?? 'N/A';
                $nestedData['id_lote_granel'] = $dictamen->lote_granel->nombre_lote ?? 'N/A';
                $nestedData['folio_fq'] = $dictamen->lote_granel->folio_fq ?? 'N/A';
                $nestedData['fecha_servicio'] = Helpers::formatearFecha($dictamen->fecha_servicio);
                $nestedData['estatus'] = $dictamen->estatus;
                $fecha_emision = Helpers::formatearFecha($dictamen->fecha_emision);
                $fecha_vigencia = Helpers::formatearFecha($dictamen->fecha_vigencia);
                $nestedData['fechas'] = '<span class="small"><b>Fecha Emisión: </b>' .$fecha_emision. '<br> <b>Fecha Vigencia: </b>' .$fecha_vigencia. '</span>';
                ///numero y nombre empresa
                $empresa = $dictamen->inspeccione->solicitud->empresa;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes
                    ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
                : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['razon_social'] = $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';
    
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




///FUNCION PARA INSERTAR DATOS
public function store(Request $request)
{
    $validatedData = $request->validate([
        'num_dictamen' => 'required|string|max:100',
        'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
        'id_firmante' => 'required|exists:users,id',
    ]);
    
    // Crear una nueva instancia del modelo Dictamen_Granel
    $dictamen = new Dictamen_Granel();
    $dictamen->num_dictamen = $validatedData['num_dictamen'];
    $dictamen->id_inspeccion = $validatedData['id_inspeccion'];
    $dictamen->fecha_emision = $validatedData['fecha_emision'];
    $dictamen->fecha_vigencia = $validatedData['fecha_vigencia'];
    $dictamen->id_firmante = $validatedData['id_firmante'];
    $dictamen->save();
    
    return response()->json([
        'success' => true,
        'message' => 'Dictamen agregado correctamente',
    ]);
}



///FUNCION PARA ELIMINAR
public function destroy($id_dictamen)
{
    try {
        $dictamen = Dictamen_Granel::findOrFail($id_dictamen);
        $dictamen->delete();

        return response()->json(['success' => 'Dictamen eliminado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar dictamen'], 500);
    }
}



///FUNCION PARA OBTENER LOS DATOS REGISTRADOS
public function edit($id_dictamen)
{
    try {
        // Cargar el dictamen específico
        $dictamen = Dictamen_Granel::findOrFail($id_dictamen);
        return response()->json([
            'success' => true,
            'dictamen' => $dictamen, // Enviar el dictamen específico
        ]);
    //} catch (ModelNotFoundException $e) {
    } catch (\Exception $e) {
        return response()->json(['success' => false], 404);
    }
}

///FUNCION PARA ACTUALIZAR
public function update(Request $request, $id_dictamen)
{
    try {
        // Validar los datos del formulario
        $validated = $request->validate([
            'num_dictamen' => 'required|string|max:70',
            'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'id_firmante' => 'required|exists:users,id',
        ]);

        $dictamen = Dictamen_Granel::findOrFail($id_dictamen);

        // Actualizar lote
        $dictamen->update([
            'num_dictamen' => $validated['num_dictamen'],
            'id_inspeccion' => $validated['id_inspeccion'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_vigencia' => $validated['fecha_vigencia'],
            'id_firmante' => $validated['id_firmante'],
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Dictamen actualizado exitosamente',
        ]);
    } catch (\Exception $e) {
        Log::error('Error al actualizar dictamen granel', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
}



public function MostrarDictamenGranel($id_dictamen)
{
    // Obtener los datos del dictamen específico
    $data = Dictamen_Granel::find($id_dictamen);

    if (!$data) {
        return abort(404, 'Dictamen no encontrado');
    }

    $fecha_emision = Helpers::formatearFecha($data->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($data->fecha_vigencia);
    $fecha_servicio = Helpers::formatearFecha($data->inspeccione->fecha_servicio);
    // Determinar si la marca de agua debe ser visible
    $watermarkText = $data->estatus == 1;

    $pdf = Pdf::loadView('pdfs.dictamen_granel_ed7', [
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

        // Buscar el dictamen
        $dictamen = Dictamen_Granel::find($id_dictamen);
        if (!$dictamen) {
            Log::error('Dictamen no encontrado para el ID: ' . $id_dictamen);
            return response()->json(['success' => false, 'message' => 'Dictamen no encontrado'], 404);
        }

        // Buscar el lote a granel asociado con el dictamen
        $lote = LotesGranel::find($dictamen->id_lote_granel);
        if (!$lote) {
            Log::error('Lote a granel no encontrado para el ID: ' . $dictamen->id_lote_granel);
            return response()->json(['success' => false, 'message' => 'Lote a granel no encontrado'], 404);
        }

        Log::info('Lote encontrado: ' . $lote->nombre_lote);

        // Obtener los documentos asociados al lote a granel
        $documentos = Documentacion_url::where('id_relacion', $lote->id_lote_granel)->get();
        Log::info('Documentos obtenidos: ', $documentos->toArray());

        // Mapear documentos con URL
        $documentosConUrl = $documentos->map(function ($documento) {
            return [
                'id_documento' => $documento->id_documento,
                'nombre' => $documento->nombre_documento,
                'url' => $documento->url,
                'tipo' => $documento->nombre_documento
            ];
        });

        // Obtener la empresa asociada
        $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
        if (!$empresa) {
            Log::error('Empresa no encontrada para el ID: ' . $lote->id_empresa);
            return response()->json(['success' => false, 'message' => 'Empresa no encontrada'], 404);
        }

        Log::info('Empresa encontrada: ' . $empresa->nombre_empresa);

        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

        // Obtener la URL del archivo para "otro organismo"
        // Corregido
        $documentoOtroOrganismo = $documentos->firstWhere('tipo', 'Certificado de lote a granel:  - ');
        $archivoUrlOtroOrganismo = $lote->tipo_lote == '2' && $documentoOtroOrganismo ? $documentoOtroOrganismo['url'] : '';

        Log::info('Archivo URL Otro Organismo: ' . $archivoUrlOtroOrganismo);

        return response()->json([
            'success' => true,
            'lote' => $lote,
            'documentos' => $documentosConUrl,
            'numeroCliente' => $numeroCliente,
            'archivo_url_otro_organismo' => $archivoUrlOtroOrganismo
        ]);
    //} catch (ModelNotFoundException $e) {
    } catch (\Exception $e) {
        Log::error('Error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error en la solicitud'], 500);
    } catch (\Exception $e) {
        Log::error('Error inesperado: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error inesperado'], 500);
    }
}



///REEXPEDIR DICTAMEN
public function reexpedirDictamen(Request $request, $id_dictamen)
{
    DB::beginTransaction();
    try {
        // Validar los datos
        $validatedData = $request->validate([
            'num_dictamen' => 'required',
            'id_inspeccion' => 'required',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'id_firmante' => 'required',
            'observaciones' => 'required',
            'cancelar_reexpedir' => 'required'
        ]);

        // Obtener el dictamen original
        $dictamenOriginal = Dictamen_Granel::findOrFail($id_dictamen);

        // Actualizar el dictamen original con observaciones y estatus
        $dictamenOriginal->update([
            'estatus' => 1,
            'observaciones' => $request->input('observaciones')
        ]);

        // Verificar la opción seleccionada
        if ($request->input('cancelar_reexpedir') == '2') {  // Opción 2: Cancelar y reexpedir
            // Crear un nuevo dictamen
            $nuevoDictamen = $dictamenOriginal->replicate();
            $nuevoDictamen->num_dictamen = $request->input('num_dictamen');
            $nuevoDictamen->id_empresa = $request->input('id_empresa');
            $nuevoDictamen->id_inspeccion = $request->input('id_inspeccion');
            $nuevoDictamen->id_lote_granel = $request->input('id_lote_granel');
            $nuevoDictamen->fecha_emision = $request->input('fecha_emision');
            $nuevoDictamen->fecha_vigencia = $request->input('fecha_vigencia');
            $nuevoDictamen->fecha_servicio = $request->input('fecha_servicio');
            $nuevoDictamen->estatus = 2;
            $nuevoDictamen->save();
        }

        DB::commit();
        return response()->json(['message' => 'Operación realizada con éxito.']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => 'Error al procesar la operación.', 'error' => $e->getMessage()], 500);
    }
}
    




}
