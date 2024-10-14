<?php

namespace App\Http\Controllers\revision;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Revisor;

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
            6 => 'num_certificado' // Asegúrate de tener esto
        ];
    
        $search = $request->input('search.value');
        $totalData = Revisor::with(['certificado.dictamen'])->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');
    
        $order = $columns[$orderIndex] ?? 'id_revisor';
        $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';
    
        $query = Revisor::with(['certificado.dictamen'])
            ->when($search, function ($q, $search) {
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
            $totalFiltered = Revisor::with('certificado.dictamen')
                ->where('id_revisor', 'LIKE', "%{$search}%")
                ->orWhereHas('certificado', function ($q) use ($search) {
                    $q->where('num_certificado', 'LIKE', "%{$search}%");
                })
                ->orWhere('observaciones', 'LIKE', "%{$search}%")
                ->orWhere('tipo_revision', 'LIKE', "%{$search}%")
                ->count();
        }
    
        // Mapeando los resultados
        $data = $revisores->map(function ($revisor) use (&$start) {
            $nameRevisor = $revisor->user->name ?? null;
            $tipoDictamen = $revisor->certificado && $revisor->certificado->dictamen ? $revisor->certificado->dictamen->tipo_dictamen : null;
    
            // Asegúrate de acceder correctamente a num_dictamen
            $numDictamen = $revisor->certificado && $revisor->certificado->dictamen ? $revisor->certificado->dictamen->num_dictamen : null;
    
            // Agregar las fechas correctas
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
                'num_dictamen' => $numDictamen, // Añadir num_dictamen al resultado
                'fecha_vigencia' => $fechaVigencia, // Añadir fecha de vigencia
                'fecha_vencimiento' => $fechaVencimiento, // Añadir fecha de vencimiento
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
