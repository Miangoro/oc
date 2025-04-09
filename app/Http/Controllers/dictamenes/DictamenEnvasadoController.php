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
///Extensiones
use App\Helpers\Helpers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class DictamenEnvasadoController extends Controller
{
    
    public function UserManagement()
    {
        $inspecciones = Inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 5);
            })->orderBy('id_inspeccion', 'desc')->get();
        $empresas = Empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $inspectores = User::where('tipo', 2)->get(); // Obtener solo los usuarios con tipo '2' (inspectores)
        $marcas = marcas::all(); // Obtener todas las marcas
        $lotes_granel = LotesGranel::all();
        $envasado = lotes_envasado::all(); // Usa la clase correcta

        // Pasar los datos a la vista
        return view('dictamenes.find_dictamen_envasado', compact('inspecciones', 'empresas', 'envasado', 'inspectores',  'marcas', 'lotes_granel'));
    }


    public function index(Request $request)
    {
        $columns = [
            1 => 'id_dictamen_envasado',
            2 => 'id_inspeccion',
            3 => '',
            4 => '',
            5 => 'fecha_emision',
            6 => 'estatus',
        ];
    
        $search = $request->input('search.value');
        $totalData = Dictamen_envasado::count();
        $totalFiltered = $totalData;
    
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        /*$order = $columns[$request->input('order.0.column')] ?? 'id_dictamen_envasado';
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
        }*/

        $order = isset($columns[$order]) ? $columns[$order] : 'id_dictamen_envasado';//Por defecto ordenar por 'id_dictamen'

        // Si el índice de la columna es 2 (id_inspeccion), ignoramos la ordenación
        if ($order === 'id_inspeccion') {
            $order = 'id_dictamen_envasado';  // Cambiar a id_dictamen si la columna es id_inspeccion
        }

        $query = Dictamen_envasado::with(['inspeccion.solicitud.empresa']);
        //Buscador
        if (!empty($search)) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('id_dictamen_envasado', 'LIKE', "%{$search}%")
                    ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
                    ->orWhere('estatus', 'LIKE', "%{$search}%")
                    //empresa
                    ->orWhereHas('inspeccion.solicitud.empresa', function ($q) use ($search) {
                        $q->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    //inspecciones
                    ->orWhereHas('inspeccion', function ($q) use ($search) {
                        $q->where('num_servicio', 'LIKE', "%{$search}%")
                        ->orWhere('id_inspeccion', 'LIKE', "%{$search}%");
                    })
                    //num-cliente
                    ->orWhereHas('inspeccion.solicitud.empresa.empresaNumClientes', function ($q) use ($search) {
                        $q->where('numero_cliente', 'LIKE', "%{$search}%");
                    })
                    //solicitudes
                    ->orWhereHas('inspeccion.solicitud', function ($q) use ($search) {
                        $q->where('folio', 'LIKE', "%{$search}%")
                        ->orWhere('caracteristicas', 'LIKE', "%{$search}%");
                    });
            });
            // Calcular el total filtrado
            $totalFiltered = $query->count();
        }
    
        $res = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    

        $data = [];
        if (!empty($res)) {
            foreach ($res as $dictamen) {
                $nestedData['id_dictamen_envasado'] = $dictamen->id_dictamen_envasado;
                $nestedData['num_dictamen'] = $dictamen->num_dictamen;
                $nestedData['num_servicio'] = $dictamen->inspeccion->num_servicio ?? 'N/A';
                $nestedData['folio_solicitud'] = $dictamen->inspeccion->solicitud->folio;
                $nestedData['id_lote_envasado'] = $dictamen->lote_envasado->nombre_lote ?? 'N/A';
                $nestedData['fecha_servicio'] = Helpers::formatearFecha($dictamen->fecha_servicio);
                $nestedData['estatus'] = $dictamen->estatus;
                $nestedData['fecha_emision'] = Helpers::formatearFecha($dictamen->fecha_emision);
                $nestedData['fecha_vigencia'] = Helpers::formatearFecha($dictamen->fecha_vigencia);
                ///solicitud y acta
                $nestedData['id_solicitud'] = $dictamen->inspeccion->solicitud->id_solicitud;
                $urls = $dictamen->inspeccion->solicitud->documentacion(69)->pluck('url')->toArray();
                    if (empty($urls)) {
                        $nestedData['url_acta'] = 'Sin subir';
                    } else {
                        $nestedData['url_acta'] = implode(', ', $urls);
                    }
                $nestedData['emision'] = $dictamen->fecha_emision;
                $nestedData['vigencia'] = $dictamen->fecha_vigencia;
                ///numero y nombre empresa
                $empresa = $dictamen->inspeccion->solicitud->empresa;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes
                    ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
                : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['razon_social'] = $dictamen->inspeccion->solicitud->empresa->razon_social ?? 'No encontrado';
                ///dias vigencia
                $fechaActual = Carbon::now()->startOfDay(); // Asegúrate de trabajar solo con fechas, sin horas
                $fechaVigencia = Carbon::parse($dictamen->fecha_vigencia)->startOfDay();
                    if ($fechaActual->isSameDay($fechaVigencia)) {
                        $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Hoy se vence este dictamen</span>";
                    } else {
                        $diasRestantes = $fechaActual->diffInDays($fechaVigencia, false);

                        if ($diasRestantes > 0) {
                            if ($diasRestantes > 15) {
                                $res = "<span class='badge bg-success'>$diasRestantes días de vigencia.</span>";
                            } else {
                                $res = "<span class='badge bg-warning'>$diasRestantes días de vigencia.</span>";
                            }
                            $nestedData['diasRestantes'] = $res;
                        } else {
                            $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Vencido hace " . abs($diasRestantes) . " días.</span>";
                        }
                    }

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



///FUNCION PARA REGISTRAR
public function store(Request $request)
{
    try {
    $validated = $request->validate([
        'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
        'num_dictamen' => 'required|string|max:100',
        'id_firmante' => 'required|exists:users,id',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
    ]);
    
    // Crear un registro
    $new = new Dictamen_Envasado();
    $new->num_dictamen = $validated['num_dictamen'];
    $new->id_inspeccion = $validated['id_inspeccion'];
    $new->fecha_emision = $validated['fecha_emision'];
    $new->fecha_vigencia = $validated['fecha_vigencia'];
    $new->id_firmante = $validated['id_firmante'];
    $new->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Registrado correctamente',
        ]);
    } catch (\Exception $e) {
        //Log::error('Error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error inesperado'], 500);
    }
}



///FUNCION PARA ELIMINAR
public function destroy($id_dictamen_envasado) 
{
    try {
        $eliminar = Dictamen_Envasado::findOrFail($id_dictamen_envasado);
        $eliminar->delete();

        return response()->json(['success' => 'Eliminado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar'], 500);
    }
}



//FUNCION PARA OBTENER LOS REGISTROS
public function edit($id_dictamen_envasado) 
{
    try {
        // Cargar el dictamen específico
        $editar = Dictamen_Envasado::findOrFail($id_dictamen_envasado);

        return response()->json([
            'success' => true,
            'id' => $editar, // Enviar el id específico
        ]);
    } catch (\Exception $e) {
        return response()->json(['success' => false], 404);
    }
}

///FUNCION PARA ACTUALIZAR
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

        $actualizar = Dictamen_Envasado::findOrFail($id_dictamen_envasado);

        // Actualizar lote
        $actualizar->update([
            'num_dictamen' => $validated['num_dictamen'],
            'id_inspeccion' => $validated['id_inspeccion'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_vigencia' => $validated['fecha_vigencia'],
            'id_firmante' => $validated['id_firmante'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Actualizado correctamente',
        ]);
    } catch (\Exception $e) {
        Log::error('Error al actualizar', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
}


     
///REEXPEDIR
/*public function reexpedirDictamen(Request $request, $id_dictamen_envasado)
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
}*/
///otro
public function reexpedir(Request $request) 
{
    try {
        $request->validate([
            'accion_reexpedir' => 'required|in:1,2',
            'observaciones' => 'nullable|string',
        ]);

        if ($request->accion_reexpedir == '2') {
            $request->validate([
                'id_dictamen_envasado' => 'required|exists:dictamenes_envasado,id_dictamen_envasado',
                'id_inspeccion' => 'required|integer',
                'num_dictamen' => 'required|string|max:25',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'required|date',
                'id_firmante' => 'required|integer',
            ]);
        }

        $reexpedir = Dictamen_Envasado::findOrFail($request->id_dictamen_envasado);

        if ($request->accion_reexpedir == '1') {
            $reexpedir->estatus = 1; 
            // Decodificar el JSON actual
            $observacionesActuales = json_decode($reexpedir->observaciones, true);
            // Actualiza solo 'observaciones' sin modificar 'id_certificado_sustituye'
            $observacionesActuales['observaciones'] = $request->observaciones;
            // Volver a codificar el array y asignarlo a $certificado->observaciones
            $reexpedir->observaciones = json_encode($observacionesActuales); 
            $reexpedir->save();

            return response()->json(['message' => 'Cancelado correctamente']);

        } else if ($request->accion_reexpedir == '2') {
            $reexpedir->estatus = 1;
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
            $reexpedir->observaciones = json_encode($observacionesActuales);
            $reexpedir->save(); 

            // Crear un nuevo registro de reexpedición
            $new = new Dictamen_Envasado();
            $new->num_dictamen = $request->num_dictamen;
            $new->id_inspeccion = $request->id_inspeccion;
            $new->fecha_emision = $request->fecha_emision;
            $new->fecha_vigencia = $request->fecha_vigencia;
            $new->id_firmante = $request->id_firmante;
            $new->estatus = 2;
            $new->observaciones = json_encode([
                'id_sustituye' => $request->id_dictamen_envasado,
                ]);
            $new->save();// Guardar

            return response()->json(['message' => 'Registrado correctamente']);
        }

        return response()->json(['message' => 'Procesado correctamente']);
    } catch (\Exception $e) {
        Log::error($e);
        return response()->json(['message' => 'Error al procesar.', 'error' => $e->getMessage()], 500);
    }
}




//PDF DICTAMEN
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
