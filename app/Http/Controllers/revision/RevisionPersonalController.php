<?php

namespace App\Http\Controllers\revision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Revisor;
use App\Helpers\Helpers;

class RevisionPersonalController extends Controller
{

    public function userManagement()
    {
        $revisores = Revisor::all();
        return view('revision.revision_certificados-personal_view', compact('revisores'));
    }   

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_revisor',
            2 => 'id_revisor2',
            3 => 'observaciones',
            4 => 'tipo_revision',
            5 => 'id_certificado',
            6 => 'num_certificado'
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
    
    
    
    
    
    

    
}
