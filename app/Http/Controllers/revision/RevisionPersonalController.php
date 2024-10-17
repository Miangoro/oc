<?php

namespace App\Http\Controllers\revision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Revisor;
use App\Models\Certificados;
use App\Helpers\Helpers;
use App\Models\preguntas_revision;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;

class RevisionPersonalController extends Controller
{

    public function userManagement()
    {
        $revisores = Revisor::with('certificado')->get(); 
        $preguntas = preguntas_revision::where('tipo_revisor','=','1')->orwhere('tipo_certificado','=','1')->get(); //Solo preguntas para miemros del personal y certificvado de instalaciones
        return view('revision.revision_certificados-personal_view', compact('revisores','preguntas'));
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
            7 => 'created_at'
        ];
    
        $search = $request->input('search.value');
        $userId = auth()->id(); // Obtener el ID del usuario autenticado
    
        // Contar todos los registros, aplicando el filtro solo si el usuario no es el de ID 8
        $totalData = Revisor::with(['certificado.dictamen']);
    
        // Si el usuario es el admin (ID 8), contar todos los registros
        if ($userId == 8) {
            $totalData = $totalData->count();
        } else {
            // De lo contrario, contar solo los registros del usuario
            $totalData = $totalData->where('id_revisor', $userId)->count();
        }
    
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');
    
        $order = $columns[$orderIndex] ?? 'id_revisor';
        $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';
    
        // Crear la consulta base
        $query = Revisor::with(['certificado.dictamen']);
    
        // Aplicar filtro basado en el usuario
        if ($userId != 8) {
            $query->where('id_revisor', $userId);
        }
    
        // Aplicar búsqueda
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
    
        // Filtrar resultados de búsqueda
        if ($search) {
            $filteredQuery = Revisor::with('certificado.dictamen');
    
            if ($userId == 8) {
                // Si el usuario es el admin, no aplicar filtro de ID
                $totalFiltered = $filteredQuery->where('id_revisor', 'LIKE', "%{$search}%")
                    ->orWhereHas('certificado', function ($q) use ($search) {
                        $q->where('num_certificado', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('observaciones', 'LIKE', "%{$search}%")
                    ->orWhere('tipo_revision', 'LIKE', "%{$search}%")
                    ->count();
            } else {
                // Si el usuario no es admin, aplicar filtro de ID
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
            ]);
    
            $revisor = Revisor::where('id_revision', $request->id_revision)->first();
            if (!$revisor) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }
    
            $respuestasGuardadas = json_decode($revisor->respuestas, true) ?? []; 
            foreach ($request->respuestas as $key => $nuevaRespuesta) {
                $nuevaObservacion = $request->observaciones[$key] ?? null;
                if (isset($respuestasGuardadas[$key]['respuesta']) && !empty($respuestasGuardadas[$key]['respuesta']) && empty($nuevaRespuesta)) {
                    continue; 
                }
    
                $respuestasGuardadas[$key] = [
                    'respuesta' => $nuevaRespuesta,
                    'observacion' => $nuevaObservacion,
                ];
            }
    
            $revisor->respuestas = json_encode($respuestasGuardadas); 
            $revisor->save();
    
            return response()->json(['message' => 'Respuestas registradas exitosamente.'], 201);
            
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
                $respuestas = json_decode($revisor->respuestas, true); 
    
            return response()->json([
                'message' => 'Datos recuperados exitosamente.',
                'respuestas' => $respuestas, 
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
        if ($id_dictamen == 1) {
            $tipo_certificado = 'Productor';
        } elseif ($id_dictamen == 2) {
            $tipo_certificado = 'Envasador';
        } elseif ($id_dictamen == 3) {
            $tipo_certificado = 'Comercializador';
        } elseif ($id_dictamen == 4) {
            $tipo_certificado = 'Almacén y bodega';
        } elseif ($id_dictamen == 5) {
            $tipo_certificado = 'Área de maduración';
        } else {
            $tipo_certificado = 'Desconocido';
        }
    
        $respuestas = Revisor::where('id_certificado', $id)->pluck('respuestas')->first();
        $respuestas_decoded = json_decode($respuestas, true);
    
        $pdfData = [
            'num_certificado' => $datos_revisor->num_certificado,
            'tipo_certificado' => $tipo_certificado, 
            'respuestas' => $respuestas_decoded 
        ];
    
        $pdf = Pdf::loadView('pdfs.bitacora_revicionPersonalOCCIDAM', $pdfData);
        return $pdf->stream('Bitácora de revisión documental.pdf');
    }
//end
}