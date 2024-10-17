<?php

namespace App\Http\Controllers\revision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Revisor;
use App\Helpers\Helpers;
use App\Models\preguntas_revision;
use Illuminate\Support\Facades\Schema;

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

    public function registrarPreguntas(Request $request)
    {
        try {
            $request->validate([
                'id_revision' => 'required|integer',
                'respuestas' => 'nullable|array',
                'observaciones' => 'nullable|array',
            ]);
    
            // Busca el registro con id_revision
            $revisor = Revisor::where('id_revision', $request->id_revision)->first();
            if (!$revisor) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }
    
            // Decodifica las respuestas
            $respuestasGuardadas = json_decode($revisor->respuestas, true) ?? []; // Cambié 'pregunta' a 'respuestas'
    
            // Itera sobre las nuevas respuestas y observaciones
            foreach ($request->respuestas as $key => $nuevaRespuesta) {
                $nuevaObservacion = $request->observaciones[$key] ?? null;
    
                // Si ya existe una respuesta guardada y la nueva respuesta está vacía, no actualiza
                if (isset($respuestasGuardadas[$key]['respuesta']) && !empty($respuestasGuardadas[$key]['respuesta']) && empty($nuevaRespuesta)) {
                    continue; // No actualizar si ya hay una respuesta y no hay cambios
                }
    
                // Actualiza 
                $respuestasGuardadas[$key] = [
                    'respuesta' => $nuevaRespuesta,
                    'observacion' => $nuevaObservacion,
                ];
            }
    
            // Guarda el campo 'respuestas' 
            $revisor->respuestas = json_encode($respuestasGuardadas); // Cambié 'pregunta' a 'respuestas'
            $revisor->save();
    
            // Retorna mensaje 
            if (empty($revisor->respuestas)) { // Cambié 'pregunta' a 'respuestas'
                return response()->json([
                    'message' => 'Respuestas registradas exitosamente por primera vez.',
                    'revisor' => $revisor,
                ], 201);  
            } else {
                return response()->json([
                    'message' => 'Respuestas actualizadas exitosamente.',
                    'revisor' => $revisor,
                ], 200);
            }
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al registrar las respuestas: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    public function obtenerPreguntas($id_revision)
    {
        try {
            // Busca el registro con id_revision
            $revisor = Revisor::where('id_revision', $id_revision)->first();
    
            if (!$revisor) {
                return response()->json(['message' => 'El registro no fue encontrado.'], 404);
            }
    
            // Decodifica las respuestas almacenadas en la base de datos
            $respuestas = json_decode($revisor->respuestas, true); // Cambié 'pregunta' a 'respuestas'
    
            return response()->json([
                'message' => 'Datos recuperados exitosamente.',
                'respuestas' => $respuestas, // Cambié 'preguntas' a 'respuestas'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocurrió un error al cargar las respuestas: ' . $e->getMessage(),
            ], 500);
        }
    }
    
}
