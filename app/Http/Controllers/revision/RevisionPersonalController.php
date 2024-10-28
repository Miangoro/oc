<?php

namespace App\Http\Controllers\revision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Revisor;
use App\Models\Certificados;
use App\Models\empresa;
use App\Models\User;
use App\Models\empresaNumCliente;
use App\Helpers\Helpers;
use App\Models\preguntas_revision;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;

class RevisionPersonalController extends Controller
{
    public function userManagement()
    {
        $userId = auth()->id();   
        $certificadosData = $this->calcularCertificados($userId); // Estadisticas
        $revisor = Revisor::with('certificado')->where('id_revisor', $userId)->first(); // Autentificado
        $users = User::where('tipo', 1)->get(); // Select Aprobacion
        $preguntas = preguntas_revision::where('tipo_revisor', '1')->orWhere('tipo_certificado', '1')->get();
        return view('revision.revision_certificados-personal_view', compact('revisor', 'preguntas', 'certificadosData', 'users'));
    }
    
    public function index(Request $request)
    {
        $columns = [
            1 => 'id_revisor',
            2 => 'id_revisor2',
            3 => 'observaciones',
            4 => 'tipo_revision',
            5 => 'id_certificado',
            6 => 'num_certificado',
            7 => 'created_at',
            8 => 'desicion'
        ];
    
        $search = $request->input('search.value');
        $userId = auth()->id();
    
        $totalData = Revisor::with(['certificado.dictamen']);
    
        // Si el usuario es el admin (ID 8), contar todos los registros
        if ($userId == 8) {
            $totalData = $totalData->count();
        } else {
            $totalData = $totalData->where('id_revisor', $userId)->count();
        }
    
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');
    
        $order = $columns[$orderIndex] ?? 'id_revisor';
        $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';
    
        $query = Revisor::with(['certificado.dictamen']);
    
        if ($userId != 8) {
            $query->where('id_revisor', $userId);
        }
    
        $query->when($search, function ($q) use ($search) {
            $q->where('id_revisor', 'LIKE', "%{$search}%")
                ->orWhereHas('certificado', function ($q) use ($search) {
                    $q->where('num_certificado', 'LIKE', "%{$search}%");
                })
                ->orWhere('observaciones', 'LIKE', "%{$search}%")
                ->orWhere('tipo_revision', 'LIKE', "%{$search}%");
        })
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir);
    
        $revisores = $query->get();
    
        if ($search) {
            $filteredQuery = Revisor::with('certificado.dictamen');
    
            if ($userId == 8) {
                $totalFiltered = $filteredQuery->where('id_revisor', 'LIKE', "%{$search}%")
                    ->orWhereHas('certificado', function ($q) use ($search) {
                        $q->where('num_certificado', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('observaciones', 'LIKE', "%{$search}%")
                    ->orWhere('tipo_revision', 'LIKE', "%{$search}%")
                    ->count();
            } else {
                $totalFiltered = $filteredQuery->where('id_revisor', $userId)
                    ->where(function ($query) use ($search) {
                        $query->where('id_revisor', 'LIKE', "%{$search}%")
                              ->orWhereHas('certificado', function ($q) use ($search) {
                                  $q->where('num_certificado', 'LIKE', "%{$search}%");
                              })
                              ->orWhere('observaciones', 'LIKE', "%{$search}%")
                              ->orWhere('tipo_revision', 'LIKE', "%{$search}%");
                    })
                    ->count();
            }
        }
    
        // Mapeando los resultados
        $data = $revisores->map(function ($revisor) use (&$start) {
            $nameRevisor = $revisor->user->name ?? null;
            $tipoDictamen = $revisor->certificado && $revisor->certificado->dictamen ? $revisor->certificado->dictamen->tipo_dictamen : null;
    
            $numDictamen = $revisor->certificado && $revisor->certificado->dictamen ? $revisor->certificado->dictamen->num_dictamen : null;
    
            $fechaVigencia = $revisor->certificado ? $revisor->certificado->fecha_vigencia : null;
            $fechaVencimiento = $revisor->certificado ? $revisor->certificado->fecha_vencimiento : null;
            $fechaCreacion = $revisor->created_at; 
            $fechaActualizacion = $revisor->updated_at;
    
            return [
                'id_revision' => $revisor->id_revision,
                'fake_id' => ++$start,
                'id_revisor' => $nameRevisor,
                'id_revisor2' => $revisor->id_revisor2,
                'observaciones' => $revisor->observaciones,
                'tipo_revision' => $revisor->tipo_revision,
                'num_certificado' => $revisor->certificado ? $revisor->certificado->num_certificado : null,
                'id_certificado' => $revisor->certificado ? $revisor->certificado->id_certificado : null,
                'tipo_dictamen' => $tipoDictamen,
                'num_dictamen' => $numDictamen,
                'fecha_vigencia' => Helpers::formatearFecha($fechaVigencia),
                'fecha_vencimiento' => Helpers::formatearFecha($fechaVencimiento),
                'fecha_creacion' => Helpers::formatearFecha($fechaCreacion),
                'created_at' => Helpers::formatearFecha($revisor->created_at), 
                'updated_at' => Helpers::formatearFecha($revisor->updated_at),
                'desicion' => $revisor->desicion,
            ];
        })->filter(function ($item) {
            return $item['id_revisor'] !== null;
        });
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ]);
    }

    public function registrarRespuestas(Request $request)
    {
        try {
            $request->validate([
                'id_revision' => 'required|integer',
                'respuestas' => 'nullable|array',
                'observaciones' => 'nullable|array',
                'desicion' => 'nullable|string', 
            ]);
    
            $revisor = Revisor::where('id_revision', $request->id_revision)->first();
            if (!$revisor) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }
    
            // Cargar historial de respuestas y convertir a array si es null
            $historialRespuestas = json_decode($revisor->respuestas, true) ?? [];
    
            // Determinar el número de la siguiente revisión
            $numRevision = count($historialRespuestas) + 1;
            $revisionKey = "Revision $numRevision";
    
            // Crear nuevo registro de respuestas directamente bajo la clave de la revisión
            $nuevoRegistro = [];
            $todasLasRespuestasSonC = true;
    
            foreach ($request->respuestas as $key => $nuevaRespuesta) {
                $nuevaObservacion = $request->observaciones[$key] ?? null;
    
                if ($nuevaRespuesta !== 'C') {
                    $todasLasRespuestasSonC = false;
                }
    
                // Agregar nueva respuesta directamente al registro
                $nuevoRegistro[$key] = [
                    'respuesta' => $nuevaRespuesta,
                    'observacion' => $nuevaObservacion,
                ];
            }
    
            // Añadir el nuevo registro de revisión al historial sin sobrescribir
            $historialRespuestas[$revisionKey] = $nuevoRegistro;
            $revisor->respuestas = json_encode($historialRespuestas);
    
            // Establecer la decisión
            $revisor->desicion = $todasLasRespuestasSonC ? 'positiva' : 'negativa';
    
            $revisor->save();
            return response()->json(['message' => 'Respuestas y decisión registradas exitosamente.'], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al registrar las respuestas: ' . $e->getMessage(),
            ], 500);
        }
    }    
    
    public function obtenerRespuestas($id_revision)
    {
        try {
            $revisor = Revisor::where('id_revision', $id_revision)->first();
    
            if (!$revisor) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }
    
            // Cargar el historial completo de respuestas y convertir a array
            $historialRespuestas = json_decode($revisor->respuestas, true);
    
            // Obtener la última revisión
            $ultimaRevision = end($historialRespuestas); 
            $desicion = $revisor->desicion;
    
            return response()->json([
                'message' => 'Datos de la revisión más actual recuperados exitosamente.',
                'respuestas' => $ultimaRevision,
                'desicion' => $desicion,
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al cargar las respuestas: ' . $e->getMessage(),
            ], 500);
        }
    }
    
 
    public function getCertificadoUrl($id_revision, $tipo)
    {
        $revisor = Revisor::with('certificado')->where('id_revision', $id_revision)->first();
    
        if ($revisor && $revisor->certificado) {
            $certificadoUrl = '';
    
            if ($tipo == 1 || $tipo == 5) { 
                $certificadoUrl = "../certificado_productor_mezcal/{$revisor->certificado->id_certificado}";
            } elseif ($tipo == 2) { 
                $certificadoUrl = "../certificado_envasador_mezcal/{$revisor->certificado->id_certificado}";
            } elseif ($tipo == 3 || $tipo == 4) { 
                $certificadoUrl = "../certificado_comercializador/{$revisor->certificado->id_certificado}";
            } else {
                return response()->json(['certificado_url' => null]);
            }
    
            return response()->json(['certificado_url' => $certificadoUrl]);
        } else {
            return response()->json(['certificado_url' => null]);
        }
    }

    public function bitacora_revicionPersonalOCCIDAM($id)
    {
        $datos_revisor = Certificados::findOrFail($id);
        $id_dictamen = $datos_revisor->dictamen->id_dictamen; 
    
        $tipo_certificado = '';
        switch ($id_dictamen) {
            case 1:
                $tipo_certificado = 'Productor';
                break;
            case 2:
                $tipo_certificado = 'Envasador';
                break;
            case 3:
                $tipo_certificado = 'Comercializador';
                break;
            case 4:
                $tipo_certificado = 'Almacén y bodega';
                break;
            case 5:
                $tipo_certificado = 'Área de maduración';
                break;
            default:
                $tipo_certificado = 'Desconocido';
        }
    
        $revisor = Revisor::where('id_certificado', $id)->first();
        if (!$revisor) {
            return response()->json(['error' => 'Revisor not found'], 404);
        }
    
        // Cargar el historial de respuestas
        $respuestas = json_decode($revisor->respuestas, true);
        // Obtener la última revisión
        $respuestasRecientes = end($respuestas);
        $desicion = $revisor->desicion; 
        $nameRevisor = $revisor->user->name ?? null;
        $fecha = $revisor->updated_at;
        $id_aprobador = $revisor->aprobador->name ?? 'Sin asignar';
        $aprobacion = $revisor->aprobacion ?? 'Pendiente de aprobar';
        $fecha_aprobacion = $revisor->fecha_aprobacion;
    
        $razonSocial = $datos_revisor->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'Sin asignar';
        $numero_cliente = $datos_revisor->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->first()->numero_cliente ?? 'Sin asignar';
    
        $pdfData = [
            'num_certificado' => $datos_revisor->num_certificado,
            'tipo_certificado' => $tipo_certificado,
            'respuestas' => $respuestasRecientes, // Solo la revisión más reciente
            'desicion' => $desicion,
            'id_revisor' => $nameRevisor,
            'razon_social' => $razonSocial,
            'fecha' => Helpers::formatearFecha($fecha),
            'numero_cliente' => $numero_cliente,
            'aprobacion' => $aprobacion,
            'id_aprobador' => $id_aprobador,
            'fecha_aprobacion' => Helpers::formatearFecha($fecha_aprobacion),
        ];
    
        $pdf = Pdf::loadView('pdfs.bitacora_revicionPersonalOCCIDAM', $pdfData);
        return $pdf->stream('Bitácora de revisión documental.pdf');
    }    

    public function calcularCertificados($userId)
    {
    // Total de certificados asignados al revisor
    $totalCertificados = Revisor::where('id_revisor', $userId)->count();

    // Total de certificados globales
    $totalCertificadosGlobal = Revisor::count();

    // Calcular el porcentaje general
    $porcentaje = $totalCertificados > 0 ? ($totalCertificados / $totalCertificadosGlobal) * 100 : 0;

    // Contar certificados pendientes (donde 'desicion' es null o vacío)
    $certificadosPendientes = Revisor::where('id_revisor', $userId)
        ->where(function ($query) {
            $query->whereNull('desicion')
                  ->orWhere('desicion', ''); 
        })
        ->count();

    // Contar certificados revisados (donde 'desicion' no es null)
    $certificadosRevisados = Revisor::where('id_revisor', $userId)
        ->whereNotNull('desicion')
        ->count();
    
    $porcentajePendientes = $totalCertificados > 0 ? ($certificadosPendientes / $totalCertificados) * 100 : 0;
    $porcentajeRevisados = $totalCertificados > 0 ? ($certificadosRevisados / $totalCertificados) * 100 : 0;

    return [
        'totalCertificados' => $totalCertificados,
        'porcentaje' => $porcentaje,
        'certificadosPendientes' => $certificadosPendientes,
        'porcentajePendientes' => $porcentajePendientes,
        'certificadosRevisados' => $certificadosRevisados,
        'porcentajeRevisados' => $porcentajeRevisados
    ];  
    }
    
    public function registrarAprobacion(Request $request)
    {
        $request->validate([
            'id_revisor' => 'required|exists:certificados_revision,id_revision',
            'id_aprobador' => 'required|exists:users,id',
            'aprobacion' => 'required|string|in:aprobado,desaprobado', 
            'fecha_aprobacion' => 'required|date', 
        ]);
    
        try {
            $revisor = Revisor::findOrFail($request->input('id_revisor'));
            $revisor->aprobacion = $request->input('aprobacion'); 
            $revisor->fecha_aprobacion = $request->input('fecha_aprobacion'); 
            $revisor->id_aprobador = $request->input('id_aprobador'); 
            $revisor->save();
    
            return response()->json([
                'message' => 'Aprobación registrada exitosamente.',
                'revisor' => $revisor
            ], 200);
    
        } catch (\Exception $e) {
            \Log::error('Error al registrar la aprobación', ['exception' => $e]); 
            return response()->json([
                'message' => 'Error al registrar la aprobación: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    public function cargarAprobacion($id)
    {
    try {
        $revisor = Revisor::findOrFail($id);

        return response()->json([
            'revisor' => $revisor
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al cargar la aprobación: ' . $e->getMessage(),
        ], 500);
    }
    }
    public function cargarHistorial($id_revision)
    {
        try {
            // Busca todas las revisiones asociadas a la ID
            $revisores = Revisor::where('id_revision', $id_revision)->get();
    
            if ($revisores->isEmpty()) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }
    
            $historialFormateado = [];
            foreach ($revisores as $revisor) {
                $historialRespuestas = json_decode($revisor->respuestas, true) ?? [];
                // Agrega la revisión al historial formateado
                $historialFormateado[] = [
                    'revision' => $revisor->id_revision, // o cualquier otra propiedad que identifique la revisión
                    'respuestas' => $historialRespuestas,
                ];
            }
    
            return response()->json([
                'message' => 'Historial de respuestas recuperado exitosamente.',
                'respuestas' => $historialFormateado,
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al cargar el historial: ' . $e->getMessage(),
            ], 500);
        }
    }
    

//end
}