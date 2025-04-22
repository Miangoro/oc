<?php

namespace App\Http\Controllers\dictamenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\inspecciones; 
use App\Models\User;
use App\Models\empresa; 
use App\Models\lotes_envasado;
use App\Models\Dictamen_Envasado; 
use App\Models\marcas;
use App\Models\LotesGranel;
///Extensiones
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;


class DictamenEnvasadoController extends Controller
{
    
    public function UserManagement()
    {
        $inspecciones = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 6);
            })->orderBy('id_inspeccion', 'desc')->get();
        $empresas = empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
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
    

        //MANDA LOS DATOS AL JS
        $data = [];
        if (!empty($res)) {
            foreach ($res as $dictamen) {
                $nestedData['id_dictamen_envasado'] = $dictamen->id_dictamen_envasado ?? 'No encontrado';
                $nestedData['num_dictamen'] = $dictamen->num_dictamen ?? 'No encontrado';
                $nestedData['estatus'] = $dictamen->estatus ?? 'No encontrado';
                $nestedData['fecha_emision'] = Helpers::formatearFecha($dictamen->fecha_emision);
                $nestedData['fecha_vigencia'] = Helpers::formatearFecha($dictamen->fecha_vigencia);
                $nestedData['num_servicio'] = $dictamen->inspeccion->num_servicio ?? 'No encontrado';
                $nestedData['folio_solicitud'] = $dictamen->inspeccion->solicitud->folio ?? 'No encontrado';
                $nestedData['id_lote_envasado'] = $dictamen->lote_envasado->nombre_lote ?? 'No encontrado';
                $nestedData['fecha_servicio'] = Helpers::formatearFecha($dictamen->fecha_servicio);
                ///numero y nombre empresa
                $empresa = $dictamen->inspeccion->solicitud->empresa ?? null;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                    ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                    ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['razon_social'] = $dictamen->inspeccion->solicitud->empresa->razon_social ?? 'No encontrado';
                ///dias vigencia
                $fechaActual = Carbon::now()->startOfDay(); //Asegúrate de trabajar solo con fechas, sin horas
                $nestedData['fecha_actual'] = $fechaActual;
                $nestedData['vigencia'] = $dictamen->fecha_vigencia;
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
                ///solicitud y acta
                $nestedData['id_solicitud'] = $dictamen->inspeccion->solicitud->id_solicitud ?? 'No encontrado';
                $urls = $dictamen->inspeccion?->solicitud?->documentacion(69)?->pluck('url')?->toArray();
                $nestedData['url_acta'] = (!empty($urls)) ? $urls : 'Sin subir';
               

                $data[] = $nestedData;
            }
        }
    
        return response()->json([//Devuelve los datos y el total de registros filtrados
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
    }



///FUNCION REGISTRAR
public function store(Request $request)
{
    try {
    $validated = $request->validate([
        'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
        'num_dictamen' => 'required|string|max:40',
        'fecha_emision' => 'required|date',
        'fecha_vigencia' => 'required|date',
        'id_firmante' => 'required|exists:users,id',
    ]);
        // Crear un registro
        $new = new Dictamen_Envasado();
        $new->id_inspeccion = $validated['id_inspeccion'];
        $new->num_dictamen = $validated['num_dictamen'];
        $new->fecha_emision = $validated['fecha_emision'];
        $new->fecha_vigencia = $validated['fecha_vigencia'];
        $new->id_firmante = $validated['id_firmante'];
        $new->save();
    
        return response()->json(['message' => 'Registrado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al registrar', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al registrar.'], 500);
    }
}



///FUNCION ELIMINAR
public function destroy($id_dictamen_envasado) 
{
    try {
        $eliminar = Dictamen_Envasado::findOrFail($id_dictamen_envasado);
        $eliminar->delete();

        return response()->json(['message' => 'Eliminado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al eliminar', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al eliminar.'], 500);
    }
}



///FUNCION PARA OBTENER LOS REGISTROS
public function edit($id_dictamen_envasado) 
{
    try {
        $editar = Dictamen_Envasado::findOrFail($id_dictamen_envasado);

        return response()->json([
            'id_dictamen' => $editar->id_dictamen_envasado,
            'num_dictamen' => $editar->num_dictamen,
            'id_inspeccion' => $editar->id_inspeccion,
            'fecha_emision' => $editar->fecha_emision,
            'fecha_vigencia' => $editar->fecha_vigencia,
            'id_firmante' => $editar->id_firmante,
        ]);
    } catch (\Exception $e) {
        Log::error('Error al obtener', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al obtener los datos.'], 500);
    }
}

///FUNCION ACTUALIZAR
public function update(Request $request, $id_dictamen_envasado) 
{
    try {
        $validated = $request->validate([
            'num_dictamen' => 'required|string|max:70',
            'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'id_firmante' => 'required|exists:users,id',
        ]);

        $actualizar = Dictamen_Envasado::findOrFail($id_dictamen_envasado);
        $actualizar->update([// Actualizar
            'num_dictamen' => $validated['num_dictamen'],
            'id_inspeccion' => $validated['id_inspeccion'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_vigencia' => $validated['fecha_vigencia'],
            'id_firmante' => $validated['id_firmante'],
        ]);

        return response()->json(['message' => 'Actualizado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al actualizar', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al actualizar.'], 500);
    }
}


     
///FUNCION REEXPEDIR 
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
                'num_dictamen' => 'required|string|min:8',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'required|date',
                'id_firmante' => 'required|integer',
            ]);
        }

        $reexpedir = Dictamen_Envasado::findOrFail($request->id_dictamen_envasado);

        if ($request->accion_reexpedir == '1') {
            $reexpedir->estatus = 1; 
                $observacionesActuales = json_decode($reexpedir->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;//Actualiza solo 'observaciones'
            $reexpedir->observaciones = json_encode($observacionesActuales); 
            $reexpedir->save();

            return response()->json(['message' => 'Cancelado correctamente.']);

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
            $new->observaciones = json_encode(['id_sustituye' => $request->id_dictamen_envasado]);
            $new->save();

            return response()->json(['message' => 'Registrado correctamente.']);
        }

        return response()->json(['message' => 'Procesado correctamente.']);
    } catch (\Exception $e) {
        Log::error('Error al reexpedir', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Error al procesar.'], 500);
    }
}



///PDF DICTAMEN
public function MostrarDictamenEnvasado($id_dictamen)
{
    // Obtener los datos del dictamen con la relación de lotes a granel
    $data = Dictamen_Envasado::with(['lote_envasado.lotesGranel'])->find($id_dictamen);

    if (!$data) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
    }
    //firma electronica
    $url = route('validar_dictamen', ['id_dictamen' => $id_dictamen]);
    $qrCode = new QrCode(
        data: $url,
        encoding: new Encoding('UTF-8'),
        errorCorrectionLevel: ErrorCorrectionLevel::Low,
        size: 300,
        margin: 10,
        roundBlockSizeMode: RoundBlockSizeMode::Margin,
        foregroundColor: new Color(0, 0, 0),
        backgroundColor: new Color(255, 255, 255)
    );
    // Escribir el QR en formato PNG
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    // Convertirlo a Base64
    $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());

    if($data->id_firmante == 9){ //Erik
        $pass = 'Mejia2307';
    }
    if($data->id_firmante == 6){ //Karen velazquez
        $pass = '890418jks';
    }
    if($data->id_firmante == 7){ //Zaida
        $pass = 'ZA27CI09';
    }
    if($data->id_firmante == 14){ //Mario
        $pass = 'v921009villa';
    }
    $firmaDigital = Helpers::firmarCadena($data->num_dictamen . '|' . $data->fecha_emision . '|' . $data->inspeccion?->num_servicio, $pass, $data->id_firmante);
    
    $loteEnvasado = $data->lote_envasado ?? null;
    $marca = $loteEnvasado ? $loteEnvasado->marca : null;
    $lotesGranel = $loteEnvasado ? $loteEnvasado->lotesGranel : collect(); // Si no hay, devuelve una colección vacía
    $fecha_emision = Helpers::formatearFecha($data->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($data->fecha_vigencia);
    $fecha_servicio = Helpers::formatearFecha($data->inspeccion?->fecha_servicio);
    $watermarkText = $data->estatus == 1;
    $id_sustituye = json_decode($data->observaciones, true)['id_sustituye'] ?? null;
    $nombre_id_sustituye = $id_sustituye ? Dictamen_Envasado::find($id_sustituye)->num_dictamen ?? 'No encontrado' : '';

    // Renderizar el PDF con los lotes a granel
    $pdf = Pdf::loadView('pdfs.dictamen_envasado_ed6', [
        'data' => $data,
        'lote_envasado' => $loteEnvasado,
        'marca' => $marca,
        'lotesGranel' => $lotesGranel,
        'fecha_emision' => $fecha_emision,
        'fecha_vigencia' => $fecha_vigencia,
        'fecha_servicio' => $fecha_servicio ?? '',
        'watermarkText' => $watermarkText,
        'id_sustituye' => $nombre_id_sustituye,
        'firmaDigital' => $firmaDigital,
        'qrCodeBase64' => $qrCodeBase64
    ]);

    return $pdf->stream('F-UV-04-17 Ver 6 Dictamen de Cumplimiento NOM de Mezcal Envasado.pdf');
}

   



}
