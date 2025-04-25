<?php

namespace App\Http\Controllers\dictamenes;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dictamen_instalaciones;
use App\Models\clases;
use App\Models\categorias;
use App\Models\inspecciones;
use App\Models\empresa;
use App\Models\solicitudesModel;
use App\Models\User;
///Extensiones
use App\Notifications\GeneralNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;

class DictamenInstalacionesController extends Controller
{

    public function UserManagement()
    {
        $dictamenes = Dictamen_instalaciones::all(); // Obtener todos los datos
        $clases = clases::all();
        $users = User::where('tipo', 2)->get(); //Solo inspectores 
        $categoria = categorias::all();
        $inspeccion = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 14);
        })->orderBy('id_inspeccion', 'desc')->get();

        $empresa = empresa::all();
        $soli = solicitudesModel::all();

        return view('dictamenes.find_dictamen_instalaciones', compact('dictamenes', 'clases', 'categoria', 'inspeccion', 'users'));
    }


    public function index(Request $request)
    {
        $columns = [
            //CAMPOS PARA ORDENAR LA TABLA DE INICIO "thead"
            1 => 'id_dictamen',
            2 => 'num_dictamen',
            3 => 'tipo_dictamen',
            4 => 'num_servicio',
            5 => 'fecha_emision',
            6 => 'razon_social', //este lugar lo ocupa fecha en find
            7 => 'direccion_completa',
            //8 => 'fecha_vigencia'
        ];

        $search = [];
        $totalData = Dictamen_instalaciones::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if (empty($request->input('search.value'))) {
            // ORDENAR EL BUSCADOR "thead"
            $users = Dictamen_instalaciones::with('inspeccione.solicitud.empresa')
                ->offset($start)
                ->limit($limit)
                ->orderByRaw("
                CAST(SUBSTRING_INDEX(num_dictamen, '/', -1) AS UNSIGNED) DESC, -- Ordena el año (parte después de '/')
                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(num_dictamen, '-', -1), '/', 1) AS UNSIGNED) DESC -- Ordena el consecutivo (parte entre '-' y '/')
            ")
                ->get();
        } else {
            // BUSCADOR
            $search = $request->input('search.value');

            // Definimos el nombre al valor de "tipo_dictamen"
            $map = [
                'productor' => 1,
                'envasador' => 2,
                'comercializador' => 3,
                'almacén y bodega' => 4,
                'área de maduración' => 5,
            ];

            // Verificar si la búsqueda es uno de los valores mapeados
            $searchValue = strtolower(trim($search)); // Convertir a minúsculas
            $searchType = $map[$searchValue] ?? null; // Obtener el valor del mapa si existe

            // Consulta inicial con relaciones cargadas
            $query = Dictamen_instalaciones::with('inspeccione.solicitud.empresa');

            // Filtrar por tipo_dictamen si se proporciona un valor válido
            if ($searchType !== null) {
                $query->where('tipo_dictamen', $searchType);
            } else {
                // Filtrar por otros campos si no es un tipo_dictamen válido
                $query->where(function ($q) use ($search) {
                    $q->where('id_dictamen', 'LIKE', "%{$search}%")
                        ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
                        ->orWhereDate('dictamenes_instalaciones.fecha_emision', 'LIKE', "%{$search}%")
                        ->orWhereDate('dictamenes_instalaciones.fecha_vigencia', 'LIKE', "%{$search}%")
                        ->orWhereHas('inspeccione', function ($q) use ($search) {
                            $q->where('num_servicio', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('inspeccione.solicitud', function ($q) use ($search) {
                            $q->where('folio', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('inspeccione.solicitud.empresa.empresaNumClientes', function ($q) use ($search) {
                            $q->where('numero_cliente', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('inspeccione.solicitud.empresa', function ($q) use ($search) {
                            $q->where('razon_social', 'LIKE', "%{$search}%");
                        })
                        ->orWhereHas('inspeccione.solicitud.instalacion', function ($q) use ($search) {
                            $q->where('direccion_completa', 'LIKE', "%{$search}%");
                        });
                });
            }

            // Obtener resultados con paginación
            $users = $query->offset($start)
                ->limit($limit)
                ->orderByRaw("
                CAST(SUBSTRING_INDEX(num_dictamen, '/', -1) AS UNSIGNED) DESC, -- Ordena el año (parte después de '/')
                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(num_dictamen, '-', -1), '/', 1) AS UNSIGNED) DESC -- Ordena el consecutivo (parte entre '-' y '/')")
                ->get();

            // Calcular el total filtrado
            $totalFiltered = Dictamen_instalaciones::with('inspeccione.solicitud.empresa')
                ->where(function ($q) use ($search, $searchType) {
                    if ($searchType !== null) {
                        $q->where('tipo_dictamen', $searchType);
                    } else {
                        $q->where('id_dictamen', 'LIKE', "%{$search}%")
                            ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
                            ->orWhereDate('dictamenes_instalaciones.fecha_emision', 'LIKE', "%{$search}%")
                            ->orWhere('dictamenes_instalaciones.fecha_vigencia', 'LIKE', "%{$search}%")
                            ->orWhereHas('inspeccione', function ($q) use ($search) {
                                $q->where('num_servicio', 'LIKE', "%{$search}%");
                            })
                            ->orWhereHas('inspeccione.solicitud', function ($q) use ($search) {
                                $q->where('folio', 'LIKE', "%{$search}%");
                            })
                            ->orWhereHas('inspeccione.solicitud.empresa.empresaNumClientes', function ($q) use ($search) {
                                $q->where('numero_cliente', 'LIKE', "%{$search}%");
                            })
                            ->orWhereHas('inspeccione.solicitud.empresa', function ($q) use ($search) {
                                $q->where('razon_social', 'LIKE', "%{$search}%");
                            })
                            ->orWhereHas('inspeccione.solicitud.instalacion', function ($q) use ($search) {
                                $q->where('direccion_completa', 'LIKE', "%{$search}%");
                            });
                    }
                })
                ->count();
        }


        //MANDA LOS DATOS AL JS
        $data = [];
        if (!empty($users)) {
            foreach ($users as $dictamen) {
                $nestedData['id_dictamen'] = $dictamen->id_dictamen ?? 'No encontrado';
                $nestedData['tipo_dictamen'] = $dictamen->tipo_dictamen ?? 'No encontrado';
                $nestedData['num_dictamen'] = $dictamen->num_dictamen ?? 'No encontrado';
                $nestedData['estatus'] = $dictamen->estatus ?? 'No encontrado';
                $nestedData['fecha_emision'] = Helpers::formatearFecha($dictamen->fecha_emision);
                $nestedData['fecha_vigencia'] = Helpers::formatearFecha($dictamen->fecha_vigencia);
                $nestedData['num_servicio'] = $dictamen->inspeccione->num_servicio ?? 'No encontrado';
                $nestedData['folio_solicitud'] = $dictamen->inspeccione->solicitud->folio ?? 'No encontrado';
                $nestedData['direccion_completa'] = $dictamen->inspeccione->solicitud->instalacion->direccion_completa ?? 'No encontrada';
                ///numero y nombre empresa
                $empresa = $dictamen->inspeccione->solicitud->empresa ?? null;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                    ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                    ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['razon_social'] = $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';
                ///dias vigencia
                $fechaActual = Carbon::now()->startOfDay(); //trabajar solo fechas, sin horas
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
                $nestedData['id_solicitud'] = $dictamen->inspeccione->solicitud->id_solicitud ?? 'No encontrado';
                $urls = $dictamen->inspeccione?->solicitud?->documentacion(69)?->pluck('url')?->toArray();
                $nestedData['url_acta'] = (!empty($urls)) ? $urls : 'Sin subir';
                
                    
                $data[] = $nestedData;
            }
        }

        if ($data) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'code' => 200,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
                'data' => [],
            ]);
        }
    }



///FUNCION REGISTRAR
public function store(Request $request)
{
    try {
        // Busca la inspección y carga las relaciones necesarias
        $instalaciones = inspecciones::with(['solicitud.instalacion'])->find($request->id_inspeccion);

        // Verifica si la inspección y las relaciones existen
        if (!$instalaciones || !$instalaciones->solicitud || !$instalaciones->solicitud->instalacion) {
            return response()->json(['error' => 'No se encontró la instalación asociada a la inspección'], 404);
        }

        $validated = $request->validate([
            //$var->id_instalacion = $instalaciones->solicitud->instalacion->id_instalacion;
            'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
            'tipo_dictamen' => 'required|int',
            'num_dictamen' => 'required|string|max:40',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'id_firmante' => 'required|exists:users,id',
        ]);
        // Crear un registro
        $new = new Dictamen_instalaciones();
        $new->id_instalacion = $instalaciones->solicitud->instalacion->id_instalacion;
        $new->id_inspeccion = $validated['id_inspeccion'];
        $new->tipo_dictamen = $validated['tipo_dictamen'];
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
public function destroy($id_dictamen)
{
    try {
        $eliminar = Dictamen_instalaciones::findOrFail($id_dictamen);
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
public function edit($id_dictamen)
{
    try {
        $editar = Dictamen_instalaciones::findOrFail($id_dictamen);

        return response()->json([
            'id_dictamen' => $editar->id_dictamen,
            'id_inspeccion' => $editar->id_inspeccion,
            'tipo_dictamen' => $editar->tipo_dictamen,
            'num_dictamen' => $editar->num_dictamen,
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
public function update(Request $request, $id_dictamen) 
{
    try {
        // Validar los datos del formulario
        $validated = $request->validate([
            'id_inspeccion' => 'required|exists:inspecciones,id_inspeccion',
            'tipo_dictamen' => 'required|int',
            'num_dictamen' => 'required|string|max:70',
            'fecha_emision' => 'required|date',
            'fecha_vigencia' => 'required|date',
            'id_firmante' => 'required|exists:users,id',
        ]);

        //carga las relaciones
        $instalaciones = inspecciones::with(['solicitud.instalacion'])->find($request->id_inspeccion);
        // Verifica si la relacione existen
        if (!$instalaciones || !$instalaciones->solicitud || !$instalaciones->solicitud->instalacion) {
            return response()->json(['error' => 'No se encontró la instalación asociada a la inspección'], 404);
        }
        // Obtener id_instalacion automáticamente desde la relación
        $id_instalacion = $instalaciones->solicitud->instalacion->id_instalacion ?? null;

        $actualizar = Dictamen_instalaciones::findOrFail($id_dictamen);
        $actualizar->update([// Actualizar
            'id_instalacion' => $id_instalacion,
            'id_inspeccion' => $validated['id_inspeccion'],
            'tipo_dictamen' => $validated['tipo_dictamen'],
            'num_dictamen' => $validated['num_dictamen'],
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
                'id_dictamen' => 'required|exists:dictamenes_instalaciones,id_dictamen',
                'id_inspeccion' => 'required|integer',
                'tipo_dictamen' => 'required|int',
                'num_dictamen' => 'required|string|min:8',
                'fecha_emision' => 'required|date',
                'fecha_vigencia' => 'required|date',
                'id_firmante' => 'required|integer',
            ]);
        }

        //carga las relaciones
        $instalaciones = inspecciones::with(['solicitud.instalacion'])->find($request->id_inspeccion);
        // Verifica si la relacione existen
        if (!$instalaciones || !$instalaciones->solicitud || !$instalaciones->solicitud->instalacion) {
            return response()->json(['error' => 'No se encontró la instalación asociada a la inspección'], 404);
        }
        // Obtener id_instalacion automáticamente desde la relación
        $id_instalacion = $instalaciones->solicitud->instalacion->id_instalacion ?? null;
        $reexpedir = Dictamen_instalaciones::findOrFail($request->id_dictamen);

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
            // Validar que sea array, si no, inicializarlo
            /*if (!is_array($observacionesActuales)) {
                $observacionesActuales = [];
            }
            $observacionesActuales['observaciones'] = $request->observaciones;
            $reexpedir->observaciones = json_encode($observacionesActuales);*/
            $reexpedir->save(); 

            // Crear un nuevo registro de reexpedición
            $new = new Dictamen_instalaciones();
            $new->id_instalacion = $id_instalacion;
            $new->id_inspeccion = $request->id_inspeccion;
            $new->tipo_dictamen = $request->tipo_dictamen;
            $new->num_dictamen = $request->num_dictamen;
            $new->fecha_emision = $request->fecha_emision;
            $new->fecha_vigencia = $request->fecha_vigencia;
            $new->id_firmante = $request->id_firmante;
            $new->estatus = 2;
            $new->observaciones = json_encode(['id_sustituye' => $request->id_dictamen]);
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



//PDF'S DICTAMEN DE INSTALACIONES
public function dictamen_productor($id_dictamen)
{
    $datos = Dictamen_instalaciones::with(['inspeccione.solicitud.empresa.empresaNumClientes', 'instalaciones', 'inspeccione.inspector'])->find($id_dictamen);

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

    $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    $firmaDigital = Helpers::firmarCadena($datos->num_dictamen . '|' . $datos->fecha_emision . '|' . $datos?->inspeccione?->num_servicio, 'Mejia2307', $datos->id_firmante);  // 9 es el ID del usuario en este ejemplo
    $pdf = Pdf::loadView('pdfs.DictamenProductor', ['datos' => $datos, 'fecha_inspeccion' => $fecha_inspeccion, 'fecha_emision' => $fecha_emision, 'fecha_vigencia' => $fecha_vigencia, 'firmaDigital' => $firmaDigital, 'qrCodeBase64' => $qrCodeBase64])->setPaper('letter', 'portrait');
    return $pdf->stream($datos->num_dictamen .' Dictamen de cumplimiento de Instalaciones como productor.pdf');
}

public function dictamen_envasador($id_dictamen)
{
    $datos = Dictamen_instalaciones::with(['inspeccione.solicitud.empresa.empresaNumClientes', 'instalaciones', 'inspeccione.inspector'])->find($id_dictamen);
    // URL que quieres codificar en el QR
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

    $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    $firmaDigital = Helpers::firmarCadena($datos->num_dictamen . '|' . $datos->fecha_emision . '|' . $datos?->inspeccione?->num_servicio, 'Mejia2307', $datos->id_firmante);  // 9 es el ID del usuario en este ejemplo
    $pdf = Pdf::loadView('pdfs.DictamenEnvasado', ['datos' => $datos, 'fecha_inspeccion' => $fecha_inspeccion, 'fecha_emision' => $fecha_emision, 'fecha_vigencia' => $fecha_vigencia, 'firmaDigital' => $firmaDigital, 'qrCodeBase64' => $qrCodeBase64])->setPaper('letter', 'portrait');
    return $pdf->stream($datos->num_dictamen.' Dictamen de cumplimiento de Instalaciones como envasador.pdf');
}

public function dictamen_comercializador($id_dictamen)
{
    $datos = Dictamen_instalaciones::with(['inspeccione.solicitud.empresa.empresaNumClientes', 'instalaciones', 'inspeccione.inspector'])->find($id_dictamen);
    // URL que quieres codificar en el QR
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

    $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    $firmaDigital = Helpers::firmarCadena($datos->num_dictamen . '|' . $datos->fecha_emision . '|' . $datos?->inspeccione?->num_servicio, 'Mejia2307', $datos->id_firmante);  // 9 es el ID del usuario en este ejemplo
    $pdf = Pdf::loadView('pdfs.DictamenComercializador', ['datos' => $datos, 'fecha_inspeccion' => $fecha_inspeccion, 'fecha_emision' => $fecha_emision, 'fecha_vigencia' => $fecha_vigencia, 'firmaDigital' => $firmaDigital, 'qrCodeBase64' => $qrCodeBase64])->setPaper('letter', 'portrait');
    return $pdf->stream($datos->num_dictamen . ' Dictamen de cumplimiento de instalaciones como comercializador.pdf');
}

public function dictamen_almacen($id_dictamen)
{
    $datos = Dictamen_instalaciones::find($id_dictamen);

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

    $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);

    // Solucion al problema de la cadena, como se guarda en la BD: ["Blanco o Joven","Reposado", "A\u00f1ejo"
    $categorias = json_decode($datos->categorias, true);
    $clases = json_decode($datos->clases, true);
    $firmaDigital = Helpers::firmarCadena($datos->num_dictamen . '|' . $datos->fecha_emision . '|' . $datos?->inspeccione?->num_servicio, 'Mejia2307', $datos->id_firmante);  // 9 es el ID del usuario en este ejemplo
    $pdf = Pdf::loadView('pdfs.Dictamen_cumplimiento_Instalaciones', [
        'datos' => $datos,
        'fecha_inspeccion' => $fecha_inspeccion ?? '',
        'fecha_emision' => $fecha_emision ?? '',
        'fecha_vigencia' => $fecha_vigencia ?? '', 'firmaDigital' => $firmaDigital, 'qrCodeBase64' => $qrCodeBase64])->setPaper('letter', 'portrait');

    return $pdf->stream($datos->num_dictamen .' Dictamen de cumplimiento de Instalaciones almacén.pdf');
}

public function dictamen_maduracion($id_dictamen)
{
    $datos = Dictamen_instalaciones::find($id_dictamen);

    $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);

    // Solucion al problema de la cadena, como se guarda en la BD: ["Blanco o Joven","Reposado", "A\u00f1ejo"
    $categorias = json_decode($datos->categorias, true);
    $clases = json_decode($datos->clases, true);

    $pdf = Pdf::loadView('pdfs.Dictamen_Instalaciones_maduracion_mezcal', [
        'datos' => $datos,
        'fecha_inspeccion' => $fecha_inspeccion,
        'fecha_emision' => $fecha_emision,
        'fecha_vigencia' => $fecha_vigencia,
        'categorias' => $categorias,
        'clases' => $clases
    ]);

    return $pdf->stream('F-UV-02-12 Ver 5, Dictamen de cumplimiento de Instalaciones del área de maduración.pdf');
}







}
