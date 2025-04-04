<?php

namespace App\Http\Controllers\dictamenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\inspecciones;
use App\Models\empresa;
use App\Models\Documentacion_url;
use App\Models\LotesGranel;
use App\Models\Dictamen_Granel;
use App\Models\User;
///Extensiones
use Illuminate\Support\Facades\Log;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;


class DictamenGranelController extends Controller  {


    public function UserManagement() {
        // Obtener los datos necesarios
        $inspecciones = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 3);
        })->orderBy('id_inspeccion', 'desc')->get();
        $empresas = Empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $inspectores = User::where('tipo', 2)->get(); // Obtener solo los usuarios con tipo '2' (inspectores)
        $lotesGranel = LotesGranel::all();

        // Pasar los datos a la vista
        return view('dictamenes.dictamen_granel_view', compact('inspecciones', 'empresas', 'lotesGranel', 'inspectores'));
    }


    public function index(Request $request)  {
        
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

        
        //Declara la relacion
        $query = Dictamen_Granel::with(['inspeccione.solicitud.empresa']);

        //Buscador
        if (!empty($search)) {
            $query = $query->where(function ($q) use ($search) {
                $q->where('id_dictamen', 'LIKE', "%{$search}%")
                    ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
                    ->orWhere('estatus', 'LIKE', "%{$search}%")
                    //empresa
                    ->orWhereHas('inspeccione.solicitud.empresa', function ($q) use ($search) {
                        $q->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    //inspecciones
                    ->orWhereHas('inspeccione', function ($q) use ($search) {
                        $q->where('num_servicio', 'LIKE', "%{$search}%");
                    })
                    //num-cliente
                    ->orWhereHas('inspeccione.solicitud.empresa.empresaNumClientes', function ($q) use ($search) {
                        $q->where('numero_cliente', 'LIKE', "%{$search}%");
                    })
                    //solicitudes
                    ->orWhereHas('inspeccione.solicitud', function ($q) use ($search) {
                        $q->where('folio', 'LIKE', "%{$search}%")
                        ->orWhere('caracteristicas', 'LIKE', "%{$search}%");
                    });
                    
            });

            // Calcular el total filtrado
            $totalFiltered = $query->count();
        }

        // Obtener resultados con paginación
        $dictamenes = $query->offset($start)
        ->limit($limit)
        ->offset($start)
        ->orderByRaw("
        CAST(SUBSTRING_INDEX(num_dictamen, '/', -1) AS UNSIGNED) DESC, -- Ordena el año (parte después de '/')
        CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(num_dictamen, '-', -1), '/', 1) AS UNSIGNED) DESC -- Ordena el consecutivo (parte entre '-' y '/')
        ")
        ->get();


        //MANDA LOS DATOS AL JS
        $data = [];

        if (!empty($dictamenes)) {
            //$ids = $start;
            foreach ($dictamenes as $dictamen) {
                $nestedData['id_dictamen'] = $dictamen->id_dictamen;
                $nestedData['num_dictamen'] = $dictamen->num_dictamen;
                $nestedData['id_inspeccion'] = $dictamen->inspeccione->num_servicio ?? 'N/A';
                $nestedData['id_lote_granel'] = $dictamen->lote_granel->nombre_lote ?? 'N/A';
                $nestedData['folio_fq'] = $dictamen->lote_granel->folio_fq ?? 'N/A';
                $nestedData['num_servicio'] = $dictamen->inspeccione->num_servicio;
                $nestedData['folio_solicitud'] = $dictamen->inspeccione->solicitud->folio;
                $nestedData['estatus'] = $dictamen->estatus;
                $nestedData['fecha_emision'] = Helpers::formatearFecha($dictamen->fecha_emision);
                $nestedData['fecha_vigencia'] = Helpers::formatearFecha($dictamen->fecha_vigencia);
                $nestedData['id_solicitud'] = $dictamen->inspeccione->solicitud->id_solicitud;
                $urls = $dictamen->inspeccione->solicitud->documentacion(69)->pluck('url')->toArray();
                    if (empty($urls)) {
                        $nestedData['url_acta'] = 'Sin subir';
                    } else {
                        $nestedData['url_acta'] = implode(', ', $urls);
                    }
                $nestedData['emision'] = $dictamen->fecha_emision;
                $nestedData['vigencia'] = $dictamen->fecha_vigencia;

                $caracteristicas = json_decode($dictamen->inspeccione->solicitud->caracteristicas, true);
                $idLoteGranel = $caracteristicas['id_lote_granel'] ?? null;
                $loteGranel = LotesGranel::find($idLoteGranel); // Busca el lote a granel


                $nestedData['nombre_lote'] = $loteGranel ? $loteGranel->nombre_lote : 'N/A';
                $nestedData['analisis'] = $caracteristicas['analisis'] ?? 'N/A';
                ///numero y nombre empresa
                $empresa = $dictamen->inspeccione->solicitud->empresa;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                    ? $empresa->empresaNumClientes
                    ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
                    : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['razon_social'] = $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';

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
public function store(Request $request) {

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
public function destroy($id_dictamen) {

    try {
        $dictamen = Dictamen_Granel::findOrFail($id_dictamen);
        $dictamen->delete();

        return response()->json(['success' => 'Dictamen eliminado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar dictamen'], 500);
    }
}




///FUNCION PARA OBTENER LOS DATOS REGISTRADOS
public function edit($id_dictamen) {

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
public function update(Request $request, $id_dictamen) {

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




///PDF DICTAMEN
public function MostrarDictamenGranel($id_dictamen) {

    // Obtener los datos del dictamen específico
    $data = Dictamen_Granel::find($id_dictamen);

    if (!$data) {
        return abort(404, 'Dictamen no encontrado');
    }
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

    if($data->id_firmante == 6){ //Karen velzquez
        $pass = '890418jks';
    }

    if($data->id_firmante == 7){ //Karen Zaida
        $pass = 'ZA27CI09';
    }

    if($data->id_firmante == 14){ //Mario
        $pass = 'v921009villa';
    }


    $firmaDigital = Helpers::firmarCadena($data->num_dictamen . '|' . $data->fecha_emision . '|' . $data->inspeccione->num_servicio, $pass, $data->id_firmante);  // 9 es el ID del usuario en este ejemplo
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
        'firmaDigital' => $firmaDigital,
        'qrCodeBase64' => $qrCodeBase64
    ]);

    return $pdf->stream('F-UV-04-16 Ver 7 Dictamen de Cumplimiento NOM Mezcal a Granel.pdf');
}



///FQ'S
public function foliofq($id_dictamen) {

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
public function reexpedirDictamen(Request $request) {

    try {
        $request->validate([
            'accion_reexpedir' => 'required|in:1,2',
            'observaciones' => 'nullable|string',
        ]);

        if ($request->accion_reexpedir == '2') {
            $request->validate([
                'id_dictamen' => 'required|exists:dictamenes_granel,id_dictamen',
                'num_dictamen' => 'required|string|max:25',
                'id_inspeccion' => 'required|integer',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'required|date',
                'id_firmante' => 'required|integer',
            ]);
        }

        $dictamen = Dictamen_Granel::findOrFail($request->id_dictamen);

        if ($request->accion_reexpedir == '1') {
            $dictamen->estatus = 1; 
            // Decodificar el JSON actual
            $observacionesActuales = json_decode($dictamen->observaciones, true);
            // Actualiza solo 'observaciones' sin modificar 'id_certificado_sustituye'
            $observacionesActuales['observaciones'] = $request->observaciones;
            // Volver a codificar el array y asignarlo a $certificado->observaciones
            $dictamen->observaciones = json_encode($observacionesActuales); 
            $dictamen->save();
        } elseif ($request->accion_reexpedir == '2') {
            $dictamen->estatus = 1;
                $observacionesActuales = json_decode($dictamen->observaciones, true);
                $observacionesActuales['observaciones'] = $request->observaciones;
            $dictamen->observaciones = json_encode($observacionesActuales);
            $dictamen->save(); 

            // Crear un nuevo registro de reexpedición
            $nuevoDictamen = new Dictamen_Granel();
            $nuevoDictamen->num_dictamen = $request->num_dictamen;
            $nuevoDictamen->id_inspeccion = $request->id_inspeccion;
            $nuevoDictamen->fecha_emision = $request->fecha_emision;
            $nuevoDictamen->fecha_vigencia = $request->fecha_vigencia;
            $nuevoDictamen->id_firmante = $request->id_firmante;
            $nuevoDictamen->estatus = 2;
            $nuevoDictamen->observaciones = json_encode([
                'id_sustituye' => $request->id_dictamen,
                ]);
            // Guardar
            $nuevoDictamen->save();
        }

        return response()->json(['message' => 'Dictamen procesado correctamente.']);
    } catch (\Exception $e) {
        Log::error($e);
        return response()->json(['message' => 'Error al procesar el dictamen.', 'error' => $e->getMessage()], 500);
    }
}




    
}//end-classController
