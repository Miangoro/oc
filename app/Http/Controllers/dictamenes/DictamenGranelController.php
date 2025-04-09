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


    public function UserManagement() 
    {
        // Obtener los datos necesarios
        $inspecciones = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 3);
            })->orderBy('id_inspeccion', 'desc')->get();
        $empresas = Empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $inspectores = User::where('tipo', 2)->get(); // Obtener solo los usuarios con tipo '2' (inspectores)
        $lotesGranel = LotesGranel::all();

        // Pasar los datos a la vista
        return view('dictamenes.find_dictamen_granel', compact('inspecciones', 'empresas', 'lotesGranel', 'inspectores'));
    }


    public function index(Request $request)  
    {
        $columns = [
        //CAMPOS PARA ORDENAR LA TABLA DE INICIO "thead"
            1 => 'id_dictamen',
            2 => 'id_inspeccion',//servicio
            3 => '',//num-cliente
            4 => '',//caracteristicas
            5 => 'fecha_emision',
            6 => 'estatus',
        ];

        $search = $request->input('search.value');//Obtener el valor de búsqueda
        $totalData = Dictamen_Granel::count();// Contar todos los registros sin filtros
        $totalFiltered = $totalData;// Inicializar totalFiltered con el valor total de registros

        $limit = $request->input('length');// Número de registros por página
        $start = $request->input('start');// Inicio de la paginación
        //$order = $columns[$request->input('order.0.column')];//Orden de columna
        $order = $request->input('order.0.column');//Orden de columna
        $dir = $request->input('order.0.dir');// Dirección del orden (asc o desc)

        // Validamos si el índice de la columna es válido
    $orderColumn = isset($columns[$order]) ? $columns[$order] : 'id_dictamen'; //Por defecto ordenar por 'id_dictamen'
    
    // Si el índice de la columna es 2 (id_inspeccion), ignoramos la ordenación
    if ($orderColumn === 'id_inspeccion') {
        $orderColumn = 'id_dictamen';  // Cambiar a id_dictamen si la columna es id_inspeccion
    }
    
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
                        $q->where('num_servicio', 'LIKE', "%{$search}%")
                        ->orWhere('id_inspeccion', 'LIKE', "%{$search}%");
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
        $res = $query->offset($start)//$query vincula al foreach del JS
            ->limit($limit)
            ->orderBy($orderColumn, $dir)// Ordenamos por la columna seleccionada
            /*->orderByRaw("
        CAST(SUBSTRING_INDEX(num_dictamen, '/', -1) AS UNSIGNED) DESC, -- Ordena el año (parte después de '/')
        CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(num_dictamen, '-', -1), '/', 1) AS UNSIGNED) DESC -- Ordena el consecutivo (parte entre '-' y '/')
        ")*/
            //->orderBy('id_dictamen', 'desc')
            ->get();

        
        //MANDA LOS DATOS AL JS
        $data = [];
        if (!empty($res)) {
            foreach ($res as $dictamen) {
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
                ///solicitud y acta
                $nestedData['id_solicitud'] = $dictamen->inspeccione->solicitud->id_solicitud;
                $urls = $dictamen->inspeccione->solicitud->documentacion(69)->pluck('url')->toArray();
                    if (empty($urls)) {
                        $nestedData['url_acta'] = 'Sin subir';
                    } else {
                        $nestedData['url_acta'] = implode(', ', $urls);
                    }
                $nestedData['emision'] = $dictamen->fecha_emision;
                $nestedData['vigencia'] = $dictamen->fecha_vigencia;
                ///caractetisticas->id_lote_granel->nombre_lote
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


        return response()->json([//Devuelve los datos y el total de registros filtrados
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

    // Crear una nuevo registro
    $new = new Dictamen_Granel();
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
        Log::error('Error: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Error inesperado'], 500);
    }
}



///FUNCION PARA ELIMINAR
public function destroy($id_dictamen) 
{
    try {
        $eliminar = Dictamen_Granel::findOrFail($id_dictamen);
        $eliminar->delete();

        return response()->json(['success' => 'Eliminado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar'], 500);
    }
}



///FUNCION PARA OBTENER LOS REGISTROS
public function edit($id_dictamen) 
{
    try {
        // Cargar el dictamen específico
        $editar = Dictamen_Granel::findOrFail($id_dictamen);

        return response()->json([
            'success' => true,
            'id' => $editar, // Enviar el id específico
        ]);
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

        $actualizar = Dictamen_Granel::findOrFail($id_dictamen);

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
public function reexpedir(Request $request) 
{
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

        $reexpedir = Dictamen_Granel::findOrFail($request->id_dictamen);

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
            $new = new Dictamen_Granel();
            $new->num_dictamen = $request->num_dictamen;
            $new->id_inspeccion = $request->id_inspeccion;
            $new->fecha_emision = $request->fecha_emision;
            $new->fecha_vigencia = $request->fecha_vigencia;
            $new->id_firmante = $request->id_firmante;
            $new->estatus = 2;
            $new->observaciones = json_encode([
                'id_sustituye' => $request->id_dictamen,
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



///PDF DICTAMEN
public function MostrarDictamenGranel($id_dictamen) 
{
    // Obtener los datos del dictamen específico
    $data = Dictamen_Granel::find($id_dictamen);

    if (!$data) {
        return abort(404, 'Registro no encontrado');
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
    if($data->id_firmante == 6){ //Karen velazquez
        $pass = '890418jks';
    }
    if($data->id_firmante == 7){ //Zaida
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
public function foliofq($id_dictamen) 
{
    try {
        Log::info('ID del Dictamen: ' . $id_dictamen);

        // Buscar el dictamen
        $dictamen = Dictamen_Granel::find($id_dictamen);
        if (!$dictamen) {
            Log::error('Registro no encontrado para el ID: ' . $id_dictamen);
            return response()->json(['success' => false, 'message' => 'No encontrado'], 404);
        }

        // Buscar el lote a granel asociado con el dictamen
        $lote = LotesGranel::find($dictamen->id_lote_granel);
        if (!$lote) {
            Log::error('Registro no encontrado para el ID: ' . $dictamen->id_lote_granel);
            return response()->json(['success' => false, 'message' => 'No encontrado'], 404);
        }

        Log::info('Registro no encontrado: ' . $lote->nombre_lote);

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
            Log::error('Registro no encontrado para el ID: ' . $lote->id_empresa);
            return response()->json(['success' => false, 'message' => 'No encontrado'], 404);
        }

        Log::info('Registro encontrado: ' . $empresa->nombre_empresa);

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




    
}//end-classController
