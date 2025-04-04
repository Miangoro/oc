<?php

namespace App\Http\Controllers\dictamenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inspecciones; 
use App\Models\User;
use App\Models\empresa; 
use App\Models\lotes_envasado;
use App\Models\Dictamen_Envasado; 
use App\Models\marcas;
use App\Models\LotesGranel;
use App\Helpers\Helpers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class DictamenEnvasadoController extends Controller
{
    
    public function UserManagement()
    {
        $inspecciones = Inspecciones::all();
        $empresas = Empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $inspectores = User::where('tipo', 2)->get(); // Obtener solo los usuarios con tipo '2' (inspectores)
        $marcas = marcas::all(); // Obtener todas las marcas
        $lotes_granel = LotesGranel::all();
        $envasado = lotes_envasado::all(); // Usa la clase correcta

        // Pasar los datos a la vista
        return view('dictamenes.dictamen_envasado_view', compact('inspecciones', 'empresas', 'envasado', 'inspectores',  'marcas', 'lotes_granel'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_dictamen_envasado',
            2 => 'num_dictamen',
            3 => 'id_empresa',
            4 => 'id_inspeccion',
            5 => 'id_lote_envasado',
            6 => 'fecha_emision',
            7 => 'fecha_vigencia',
            8 => 'fecha_servicio',
            9 => 'estatus',
        ];
    
        $search = $request->input('search.value');
        $totalData = dictamen_envasado::count();
        $totalFiltered = $totalData;
    
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')] ?? 'id_dictamen_envasado';
        $dir = $request->input('order.0.dir', 'asc');
    
        $query = dictamen_envasado::with(['inspeccion', 'empresa', 'lote_envasado']);
    
        if (!empty($search)) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('id_dictamen_envasado', 'LIKE', "%{$search}%")
                    ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
                    ->orWhereHas('empresa', function ($q) use ($search) {
                        $q->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('inspeccion', function ($q) use ($search) {
                        $q->where('num_servicio', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('lote_envasado', function ($q) use ($search) {
                        $q->where('nombre_lote', 'LIKE', "%{$search}%");
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
                $nestedData['id_dictamen_envasado'] = $dictamen->id_dictamen_envasado;
                $nestedData['num_dictamen'] = $dictamen->num_dictamen;
                $nestedData['id_inspeccion'] = $dictamen->inspeccion->num_servicio ?? 'N/A';
                $nestedData['id_lote_envasado'] = $dictamen->lote_envasado->nombre_lote ?? 'N/A';
                $nestedData['fecha_servicio'] = Helpers::formatearFecha($dictamen->fecha_servicio);
                $nestedData['estatus'] = $dictamen->estatus;
                
                $fecha_emision = Helpers::formatearFecha($dictamen->fecha_emision);
                $fecha_vigencia = Helpers::formatearFecha($dictamen->fecha_vigencia);
                $nestedData['fechas'] = '<span class="small"> <b>Fecha Emisión: </b>' .$fecha_emision. '<br> <b>Fecha Vigencia: </b>' .$fecha_vigencia. '</span>';
                ///numero y nombre empresa
                $empresa = $dictamen->inspeccion->solicitud->empresa;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes
                    ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
                : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['razon_social'] = $dictamen->inspeccion->solicitud->empresa->razon_social ?? 'No encontrado';

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


    
//FUNCION PARA ELIMIAR 
public function destroy($id_dictamen_envasado)
{
    try {
        $dictamen = Dictamen_Envasado::findOrFail($id_dictamen_envasado);
        $dictamen->delete();

        return response()->json(['success' => 'dictamen eliminado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar el dictamen'], 500);
    }
}



//FUNCION PARA INSERTAR DATOS
public function store(Request $request)
{
    $validatedData = $request->validate([
        'num_dictamen' => 'required|string|max:100',
        'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
        'id_firmante' => 'required|exists:users,id',
    ]);
    
    // Crear una nueva instancia del modelo Dictamen
    $dictamen = new Dictamen_Envasado();
    $dictamen->num_dictamen = $validatedData['num_dictamen'];
    $dictamen->id_inspeccion = $validatedData['id_inspeccion'];
    $dictamen->fecha_emision = $validatedData['fecha_emision'];
    $dictamen->fecha_vigencia = $validatedData['fecha_vigencia'];
    $dictamen->id_firmante = $validatedData['id_firmante'];
    $dictamen->save();
    
    return response()->json([
        'success' => true,
        'message' => 'Dictamen registrado exitosamente',
    ]);
}



//FUNCION PARA OBTENER LOS REGISTROS
public function edit($id_dictamen_envasado)
{
    try {
        // Cargar el dictamen específico
        $dictamen = Dictamen_Envasado::findOrFail($id_dictamen_envasado);
        return response()->json([
            'success' => true,
            'dictamen' => $dictamen, // Enviar el dictamen específico
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json(['success' => false], 404);
    }
}
     
 

//FUNCION PARA ACTUALIZAR
public function update(Request $request, $id_dictamen_envasado)
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
        $dictamen = Dictamen_Envasado::findOrFail($id_dictamen_envasado);
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
            'message' => 'Dictamen envasado actualizado exitosamente',
        ]);
    } catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Error al actualizar el dictamen envasado',
    ], 500);
    }
}


     
//REEXPEDIR DICTAMEN
public function reexpedirDictamen(Request $request, $id_dictamen_envasado)
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
        $dictamenOriginal = Dictamen_Envasado::findOrFail($id_dictamen_envasado);
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
            $nuevoDictamen->id_inspeccion = $request->input('id_inspeccion');
            $nuevoDictamen->fecha_emision = $request->input('fecha_emision');
            $nuevoDictamen->fecha_vigencia = $request->input('fecha_vigencia');
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
    


//PDF DICTAMEN ENVASADO
public function MostrarDictamenEnvasado($id_dictamen)
{
    // Obtener los datos del dictamen con la relación de lotes a granel
    $data = Dictamen_Envasado::with(['lote_envasado.lotesGranel'])->find($id_dictamen);

    if (!$data) {
        return abort(404, 'Dictamen no encontrado');
    }

    $loteEnvasado = $data->lote_envasado;
    $marca = $loteEnvasado ? $loteEnvasado->marca : null;
    $lotesGranel = $loteEnvasado ? $loteEnvasado->lotesGranel : collect(); // Si no hay, devuelve una colección vacía

    $fecha_emision = Helpers::formatearFecha($data->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($data->fecha_vigencia);
    $fecha_servicio = Helpers::formatearFecha($data->fecha_servicio);

    // Determinar si la marca de agua debe ser visible
    $watermarkText = $data->estatus === 'Cancelado';

    // Renderizar el PDF con los lotes a granel
    $pdf = Pdf::loadView('pdfs.dictamen_envasado_ed6', [
        'lote_envasado' => $loteEnvasado,
        'marca' => $marca,
        'lotesGranel' => $lotesGranel, // Pasamos los lotes a granel a la vista
        'data' => $data,
        'fecha_servicio' => $fecha_servicio,
        'fecha_emision' => $fecha_emision,
        'fecha_vigencia' => $fecha_vigencia,
        'watermarkText' => $watermarkText,
    ]);

    return $pdf->stream('Dictamen de Cumplimiento NOM de Mezcal Envasado.pdf');
}

    



}
