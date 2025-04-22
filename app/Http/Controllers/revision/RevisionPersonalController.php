<?php

namespace App\Http\Controllers\revision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Revisor;
use App\Models\RevisorGranel;
use App\Models\RevisorExportacion; //EXPORTACION
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
        $EstadisticasInstalaciones = $this->calcularCertificados($userId, 1); // Estadisticas Instalaciones
        $EstadisticasGranel = $this->calcularCertificados($userId, 2); // Estadisticas Granel

        $revisorQuery = Revisor::with('certificadoNormal','certificadoGranel','certificadoExportacion');
        if ($userId != 1) {
            $revisorQuery->where('id_revisor', $userId);
        }
        $revisor = $revisorQuery->first();

        

        //EXPORTACION
        $EstadisticasExportacion = $this->calcularCertificados($userId, 2);


        $users = User::where('tipo', 1)->get(); // Select Aprobacion
        $preguntasRevisor = preguntas_revision::where('tipo_revisor', 1)->where('tipo_certificado', 1)->get(); // Preguntas Instalaciones
        $preguntasRevisorGranel = preguntas_revision::where('tipo_revisor', 1)->where('tipo_certificado', 2)->get(); // Preguntas Granel
        $noCertificados = (!$revisor || !$revisor->certificado); // Alerta si no hay Certificados Asignados al Revisor

        return view('revision.revision_certificados-personal_view', compact('revisor','preguntasRevisor', 'preguntasRevisorGranel', 'EstadisticasInstalaciones', 'EstadisticasGranel', 'users', 'noCertificados', 'EstadisticasExportacion'));
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
            8 => 'decision'
        ];

        $search = $request->input('search.value');
        $userId = auth()->id();

        // Inicializar la consulta para Revisor y RevisorGranel
        $queryRevisor = Revisor::with([
            'certificadoNormal.dictamen',
            'certificadoGranel.dictamen',
            'certificadoExportacion.dictamen'
        ]);


        // Filtrar por usuario si no es admin (ID 8)
        if ($userId != 1) {
            $queryRevisor->where('id_revisor', $userId);
        }

        // Filtros de búsqueda
        if ($search) {
            $queryRevisor->where(function ($q) use ($search) {
                $q->where('id_revisor', 'LIKE', "%{$search}%")
                    ->orWhereHas('certificado', function ($q) use ($search) {
                        $q->where('num_certificado', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('observaciones', 'LIKE', "%{$search}%")
                    ->orWhere('tipo_revision', 'LIKE', "%{$search}%");
            });
        }

        // Paginación y ordenación
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        $order = $columns[$orderIndex] ?? 'id_revisor';
        $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';

        // Obtener los totales de registros por separado
        $totalDataRevisor = $queryRevisor->count();


        // Consultar los registros
        $revisores = $queryRevisor->offset($start)->limit($limit)->orderBy($order, $dir)->get();


        // Formatear los datos para la vista
        $dataRevisor = $revisores->map(function ($revisor) use (&$start) {
            $nameRevisor = $revisor->user->name ?? null;
            $tipoDictamen = $revisor->certificado && $revisor->certificado->dictamen ? $revisor->certificado->dictamen->tipo_dictamen : null;

            $tipoCertificado = "Sin definir";
            if ($revisor->tipo_certificado == 1) {

                switch ($tipoDictamen) {
                    case 1:
                        $tipoCertificado = 'Instalaciones de productor';
                        break;
                    case 2:
                        $tipoCertificado = 'Instalaciones de envasador';
                        break;
                    case 3:
                        $tipoCertificado = 'Instalaciones de comercializador';
                        break;
                    case 4:
                        $tipoCertificado = 'Instalaciones de almacén y bodega';
                        break;
                    case 5:
                        $tipoCertificado = 'Instalaciones de área de maduración';
                        break;
                    default:
                }
            }
            if ($revisor->tipo_certificado == 2) {
                $tipoCertificado = 'Granel';
            }
            if ($revisor->tipo_certificado == 3) {
                $tipoCertificado = 'Exportación';
            }


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
                'num_certificado' => $revisor->certificado ? $revisor->certificado->num_certificado : null,
                'id_certificado' => $revisor->certificado ? $revisor->certificado->id_certificado : null,
                'tipo_dictamen' => $tipoDictamen,
                'num_dictamen' => $numDictamen,
                'fecha_vigencia' => Helpers::formatearFecha($fechaVigencia),
                'fecha_vencimiento' => Helpers::formatearFecha($fechaVencimiento),
                'fecha_creacion' => Helpers::formatearFecha($fechaCreacion),
                'created_at' => Helpers::formatearFecha($revisor->created_at),
                'updated_at' => Helpers::formatearFecha($revisor->updated_at),
                'decision' => $revisor->decision,
                'tipo_revision' => $tipoCertificado,
            ];
        });





        // Total de resultados
        $totalData = $totalDataRevisor;

        // Devolver los resultados como respuesta JSON
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalData),
            'data' => array_merge($dataRevisor->toArray()), // Combinacion
        ]);
    }

    public function registrarRespuestas(Request $request)
    {
        try {
            $request->validate([
                'id_revision' => 'required|integer',
                'respuestas' => 'nullable|array',
                'observaciones' => 'nullable|array',
                'decision' => 'nullable|string',
            ]);

            $revisor = Revisor::where('id_revision', $request->id_revision)->first();
            if (!$revisor) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }

            $historialRespuestas = json_decode($revisor->respuestas, true) ?? [];
            $numRevision = count($historialRespuestas) + 1;
            $revisionKey = "Revision $numRevision";

            $nuevoRegistro = [];
            $todasLasRespuestasSonC = true;

            foreach ($request->respuestas as $key => $nuevaRespuesta) {
                $nuevaObservacion = $request->observaciones[$key] ?? null;

                if ($nuevaRespuesta !== 'C') {
                    $todasLasRespuestasSonC = false;
                }

                $nuevoRegistro[$key] = [
                    'respuesta' => $nuevaRespuesta,
                    'observacion' => $nuevaObservacion,
                ];
            }

            $historialRespuestas[$revisionKey] = $nuevoRegistro;
            $revisor->respuestas = json_encode($historialRespuestas);
            $revisor->decision = $todasLasRespuestasSonC ? 'positiva' : 'negativa';

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

            // Decodificar respuestas
            $historialRespuestas = json_decode($revisor->respuestas, true);

            // Verificar si es un array válido
            $ultimaRevision = is_array($historialRespuestas) ? end($historialRespuestas) : null;
            $decision = $revisor->decision;

            // Respuesta con datos o vacío si no hay historial
            return response()->json([
                'message' => 'Datos de la revisión más actual recuperados exitosamente.',
                'respuestas' => $ultimaRevision,
                'decision' => $decision,
            ], 200);
        } catch (\Exception $e) {
            // Manejo de errores
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

    public function bitacora_revisionPersonal_Instalaciones($id)
    {
        $datos_revisor = Revisor::findOrFail($id);
        $id_dictamen = $datos_revisor->certificado->dictamen->id_dictamen;

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

        $revisor = Revisor::where('id_certificado', $datos_revisor->certificado->id_certificado)->first();
        if (!$revisor) {
            return response()->json(['error' => 'Revisor not found'], 404);
        }

        $respuestas = json_decode($revisor->respuestas, true);
        $respuestasRecientes = end($respuestas);
        $decision = $revisor->decision;
        $nameRevisor = $revisor->user->name ?? null;
        $fecha = $revisor->updated_at;
        $id_aprobador = $revisor->aprobador->name ?? 'Sin asignar';
        $aprobacion = $revisor->aprobacion ?? 'Pendiente de aprobar';
        $fecha_aprobacion = $revisor->fecha_aprobacion;

        $razonSocial = $datos_revisor->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'Sin asignar';
        $numero_cliente = $datos_revisor->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->first()->numero_cliente ?? 'Sin asignar';

        $pdfData = [
            'num_certificado' => $datos_revisor->certificado->num_certificado,
            'tipo_certificado' => $tipo_certificado,
            'respuestas' => $respuestasRecientes,
            'decision' => $decision,
            'id_revisor' => $nameRevisor,
            'razon_social' => $razonSocial,
            'fecha' => Helpers::formatearFecha($fecha),
            'numero_cliente' => $numero_cliente,
            'aprobacion' => $aprobacion,
            'id_aprobador' => $id_aprobador,
            'fecha_aprobacion' => Helpers::formatearFecha($fecha_aprobacion),
        ];

        $pdf = Pdf::loadView('pdfs.Bitacora_revisionPersonal_Instalaciones', $pdfData);
        return $pdf->stream('Bitácora de revisión documental.pdf');
    }

    public function calcularCertificados($userId, $tipo_certificado)
    {
        $totalCertificados = Revisor::where('id_revisor', $userId)->where('tipo_certificado', $tipo_certificado)->count();
        $totalCertificadosGlobal = Revisor::where('tipo_certificado', $tipo_certificado)->count();
        $porcentaje = $totalCertificados > 0 ? ($totalCertificados / $totalCertificadosGlobal) * 100 : 0;

        $certificadosPendientes = Revisor::where('id_revisor', $userId)->where('tipo_certificado', $tipo_certificado)
            ->where(function ($query) {
                $query->whereNull('decision')
                    ->orWhere('decision', '');
            })
            ->count();

        $certificadosRevisados = Revisor::where('id_revisor', $userId)->where('tipo_certificado', $tipo_certificado)
            ->whereNotNull('decision')
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
            $revisores = Revisor::where('id_revision', $id_revision)->get();

            if ($revisores->isEmpty()) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }

            $historialFormateado = [];
            foreach ($revisores as $revisor) {
                $historialRespuestas = json_decode($revisor->respuestas, true) ?? [];
                $historialFormateado[] = [
                    'revision' => $revisor->id_revision,
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

    public function editarRespuestas(Request $request)
    {
        try {
            $request->validate([
                'id_revision' => 'required|integer',
                'respuestas' => 'nullable|array',
                'observaciones' => 'nullable|array',
                'decision' => 'nullable|string',
            ]);

            $revisor = Revisor::where('id_revision', $request->id_revision)->first();
            if (!$revisor) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }

            $historialRespuestas = json_decode($revisor->respuestas, true) ?? [];

            $numRevision = count($historialRespuestas);
            if ($numRevision < 1) {
                return response()->json(['message' => 'No hay revisiones para editar.'], 404);
            }

            $revisionKey = "Revision $numRevision";
            if (!isset($historialRespuestas[$revisionKey])) {
                return response()->json(['message' => 'No se encontró la última revisión para editar.'], 404);
            }

            $todasLasRespuestasSonC = true;
            foreach ($request->respuestas as $key => $nuevaRespuesta) {
                $nuevaObservacion = $request->observaciones[$key] ?? null;

                if ($nuevaRespuesta !== 'C') {
                    $todasLasRespuestasSonC = false;
                }

                if (isset($historialRespuestas[$revisionKey][$key])) {
                    $historialRespuestas[$revisionKey][$key]['respuesta'] = $nuevaRespuesta;
                    $historialRespuestas[$revisionKey][$key]['observacion'] = $nuevaObservacion;
                }
            }

            $revisor->respuestas = json_encode($historialRespuestas);
            $revisor->decision = $todasLasRespuestasSonC ? 'positiva' : 'negativa';
            $revisor->save();
            return response()->json(['message' => 'Revisión actualizada exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al editar las respuestas: ' . $e->getMessage(),
            ], 500);
        }
    }

    //CERTIFICADOS DE GRANEL 

    public function calcularCertificadosGranel($userId)
    {
        $totalCertificadosGranel = RevisorGranel::where('id_revisor', $userId)->count();
        $totalCertificadosGranelGlobal = RevisorGranel::count();
        $porcentajeGranel = $totalCertificadosGranel > 0 ? ($totalCertificadosGranel / $totalCertificadosGranelGlobal) * 100 : 0;

        $certificadosPendientesGranel = RevisorGranel::where('id_revisor', $userId)
            ->where(function ($query) {
                $query->whereNull('decision')
                    ->orWhere('decision', '');
            })
            ->count();

        $certificadosRevisadosGranel = RevisorGranel::where('id_revisor', $userId)
            ->whereNotNull('decision')
            ->count();

        $porcentajePendientesGranel = $totalCertificadosGranel > 0 ? ($certificadosPendientesGranel / $totalCertificadosGranel) * 100 : 0;
        $porcentajeRevisadosGranel = $totalCertificadosGranel > 0 ? ($certificadosRevisadosGranel / $totalCertificadosGranel) * 100 : 0;

        return [
            'totalCertificadosGranel' => $totalCertificadosGranel,
            'porcentajeGranel' => $porcentajeGranel,
            'certificadosPendientesGranel' => $certificadosPendientesGranel,
            'porcentajePendientesGranel' => $porcentajePendientesGranel,
            'certificadosRevisadosGranel' => $certificadosRevisadosGranel,
            'porcentajeRevisadosGranel' => $porcentajeRevisadosGranel
        ];
    }

    public function Bitacora_revisionPersonal_Granel()
    {
        $pdf = Pdf::loadView('pdfs.Bitacora_revisionPersonal_Granel');
        return $pdf->stream('Bitácora de revisión documental.pdf');
    }

    public function PreCertificado($id_certificado)
    {
        $certificado = CertificadosGranel::with('dictamen.empresa.instalaciones', 'dictamen.lote_granel.clase', 'dictamen.lote_granel.tipo')->findOrFail($id_certificado);

        $direccionCompleta = $certificado->dictamen->empresa->instalaciones->first()->direccion_completa ?? 'N/A';
        $clase = $certificado->dictamen->lote_granel->clase->clase ?? 'N/A';
        $ingredientes = $certificado->dictamen->lote_granel->ingredientes ?? 'N/A';
        $volumen = $certificado->dictamen->lote_granel->volumen ?? 'N/A';
        $nombre_lote = $certificado->dictamen->lote_granel->nombre_lote ?? 'N/A';
        $edad = $certificado->dictamen->lote_granel->edad ?? 'N/A';
        $cont_alc = $certificado->dictamen->lote_granel->cont_alc ?? 'N/A';
        $folio_fq = $certificado->dictamen->lote_granel->folio_fq ?? 'N/A';
        $num_dictamen = $certificado->dictamen->num_dictamen ?? 'N/A';
        $watermarkText = $certificado->estatus === 1;
        $leyenda = $certificado->estatus === 2;

        // Procesar los nombres de los tipos
        $tipoNombres = 'N/A';
        if ($certificado->dictamen->lote_granel->id_tipo) {
            $idTipos = json_decode($certificado->dictamen->lote_granel->id_tipo, true);
            if (is_array($idTipos)) {
                $tipoNombresArray = tipos::whereIn('id_tipo', $idTipos)->pluck('nombre')->toArray();
                $tipoNombres = implode(', ', $tipoNombresArray);
            }
        }

        // Datos para el PDF
        $pdfData = [
            // Tabla #1
            'num_certificado' => $certificado->num_certificado,
            'razon_social' => $certificado->dictamen->empresa->razon_social,
            'representante' => $certificado->dictamen->empresa->representante,
            'domicilio_fiscal' => $certificado->dictamen->empresa->domicilio_fiscal,
            'rfc' => $certificado->dictamen->empresa->rfc,
            'direccion_completa' => $direccionCompleta,
            'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
            'fecha_vencimiento' => Helpers::formatearFecha($certificado->fecha_vencimiento),
            'watermarkText' => $watermarkText,
            'leyenda' => $leyenda,

            // Tabla #2
            'lote' => $clase,
            'ingredientes' => $ingredientes,
            'volumen' => $volumen,
            'nombre_lote' => $nombre_lote,
            'edad' => $edad,
            'cont_alc' => $cont_alc,
            'folio_fq' => $folio_fq,
            'num_dictamen' => $num_dictamen,
            'tipo' => $tipoNombres,
        ];

        // Generar y mostrar el PDF
        return Pdf::loadView('pdfs.pre-certificado', $pdfData)->stream("Pre-certificado.pdf");
    }




    public function add_revision($id_revision)
    {

        $datos = Revisor::with('certificadoNormal','certificadoGranel', 'certificadoExportacion')->where("id_revision", $id_revision)->first();
        $preguntas = preguntas_revision::where('tipo_revisor', 1)->where('tipo_certificado', $datos->tipo_certificado)->get();

        $id_dictamen = $datos->certificado->dictamen->tipo_dictamen ?? '';




        if ($datos->tipo_certificado == 1) { //Instalaciones

            switch ($id_dictamen) {
                case 1:
                    $tipo = 'Instalaciones de productor';
                    $url = "/certificado_productor_mezcal/" . $datos->id_certificado;
                    break;
                case 2:
                    $tipo = 'Instalaciones de envasador';
                    $url = "/certificado_envasador_mezcal/" . $datos->id_certificado;
                    break;
                case 3:
                    $tipo = 'Instalaciones de comercializador';
                    $url = "/certificado_comercializador/" . $datos->id_certificado;
                    break;
                case 4:
                    $tipo = 'Instalaciones de almacén y bodega';
                    $url = "/certificado_almacen/" . $datos->id_certificado;
                    break;
                case 5:
                    $tipo = 'Instalaciones de área de maduración';
                    $url = "/certificado_maduracion/" . $datos->id_certificado;
                    break;
                default:
                    $tipo = 'Desconocido';
            }
        }elseif ($datos->tipo_certificado == 3){
            $url = 'certificado_exportacion'. $datos->id_certificado;
            $tipo = 'Exportación';
        }
        if ($datos->tipo_certificado == 2) { //Granel
            $url = "/Pre-certificado/" . $datos->id_certificado;
            $tipo = "Granel";
        }
        if ($datos->tipo_certificado == 3) { //Exportación
            $url = "/certificado_exportacion/" . $datos->id_certificado;
            $tipo = "Exportación";
        }
        return view('certificados.add_revision', compact('datos', 'preguntas', 'url', 'tipo'));
    }
    public function registrar_revision(Request $request)
    {
        try {
            $request->validate([
                'id_revision' => 'required|integer',
                'respuesta' => 'required|array',
                'observaciones' => 'nullable|array',
                'id_pregunta' => 'required|array',
            ]);

            $revisor = Revisor::where('id_revision', $request->id_revision)->first();
            if (!$revisor) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }

            // Obtener el historial de respuestas como array
            $historialRespuestas = $revisor->respuestas ?? [];

            // Definir número de revisión
            $numRevision = count($historialRespuestas) + 1;
            $revisionKey = "Revision $numRevision";

            $nuevoRegistro = [];
            $todasLasRespuestasSonC = true;

            foreach ($request->respuesta as $key => $nuevaRespuesta) {
                $nuevaObservacion = $request->observaciones[$key] ?? null;
                $nuevaIdPregunta = $request->id_pregunta[$key] ?? null;

                if ($nuevaRespuesta == 'NC') {
                    $todasLasRespuestasSonC = false;
                }

                $nuevoRegistro[] = [ // Aquí usamos `[]` en lugar de `$key`
                    'id_pregunta' => $nuevaIdPregunta,
                    'respuesta' => $nuevaRespuesta,
                    'observacion' => $nuevaObservacion,
                ];
            }

            // Guardar respuestas en formato JSON (Laravel lo maneja automáticamente)
            $historialRespuestas[$revisionKey] = $nuevoRegistro;
            $revisor->fill([
                'respuestas' => $historialRespuestas,
                'decision' => $todasLasRespuestasSonC ? 'positiva' : 'negativa',
            ]);

            $revisor->save();

            return response()->json(['message' => 'Respuestas y decisión registradas exitosamente.'], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al registrar las respuestas: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function pdf_bitacora_revision_personal($id)
    {

        $revisor = Revisor::findOrFail($id);

        // Decodificar el JSON correctamente
        $respuestasJson = json_decode($revisor->respuestas, true);

        // Asegurar que "Revisión 1" existe en el array
        $respuestas = collect($respuestasJson["Revision 1"] ?? []);

        $preguntas = preguntas_revision::whereIn('id_pregunta', $respuestas->pluck('id_pregunta'))->get();


        // Unir las preguntas con sus respuestas
        $preguntasConRespuestas = $preguntas->map(function ($pregunta) use ($respuestas) {
            $respuesta = $respuestas->firstWhere('id_pregunta', $pregunta->id_pregunta);
            return [
                'id_pregunta' => $pregunta->id_pregunta,
                'pregunta' => $pregunta->pregunta,
                'respuesta' => $respuesta['respuesta'] ?? null,
                'observacion' => $respuesta['observacion'] ?? null,
            ];
        });



        $id_dictamen = $revisor->certificado->dictamen->tipo_dictamen;

        $tipo_certificado = '';
        if ($revisor->tipo_certificado == 1) { //Instalaciones

            switch ($id_dictamen) {
                case 1:
                    $tipo_certificado = 'Instalaciones de productor';
                    break;
                case 2:
                    $tipo_certificado = 'Instalaciones de envasador';
                    break;
                case 3:
                    $tipo_certificado = 'Instalaciones de comercializador';
                    break;
                case 4:
                    $tipo_certificado = 'Instalaciones de almacén y bodega';
                    break;
                case 5:
                    $tipo_certificado = 'Instalaciones de área de maduración';
                    
                    break;
                default:
                    $tipo_certificado = 'Desconocido';
            }
        }
        if ($revisor->tipo_certificado == 2) { //Granel
            
            $tipo_certificado = "NOM a Granel";
        }
        if ($revisor->tipo_certificado == 3) { //Exportación
            
            $tipo_certificado = "Exportación";
        }





        $decision = $revisor->decision;
        $nameRevisor = $revisor->user->name ?? null;
        $firmaRevisor = $revisor->user->firma ?? '';
        $fecha = $revisor->updated_at;
        $id_aprobador = $revisor->aprobador->name ?? 'Sin asignar';
        $aprobacion = $revisor->aprobacion ?? 'Pendiente de aprobar';
        $fecha_aprobacion = $revisor->fecha_aprobacion;

        $razonSocial = $revisor->certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'Sin asignar';
        $numero_cliente = $revisor->certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->first()->numero_cliente ?? 'Sin asignar';

        $pdfData = [
            'num_certificado' => $revisor->certificado->num_certificado,
            'tipo_certificado' => $tipo_certificado,
            'decision' => $decision,
            'id_revisor' => $nameRevisor,
            'firmaRevisor' => $firmaRevisor,
            'razon_social' => $razonSocial,
            'fecha' => Helpers::formatearFecha($fecha),
            'numero_cliente' => $numero_cliente,
            'aprobacion' => $aprobacion,
            'id_aprobador' => $id_aprobador,
            'fecha_aprobacion' => Helpers::formatearFecha($fecha_aprobacion),
            'preguntas' => $preguntasConRespuestas
        ];

        $pdf = Pdf::loadView('pdfs.pdf_bitacora_revision_personal', $pdfData)
            ->setPaper('letter'); // Define tamaño carta

        return $pdf->stream('Bitácora de revisión documental.pdf');
    }
}//end