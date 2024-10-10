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
    ];

    $search = $request->input('search.value');
    $totalData = Revisor::with(['certificado'])->count();
    $totalFiltered = $totalData;
    $limit = $request->input('length');
    $start = $request->input('start');
    $orderIndex = $request->input('order.0.column');
    $orderDir = $request->input('order.0.dir');

    $order = $columns[$orderIndex] ?? 'id_revisor';
    $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';

    // Crear la consulta base
    $query = Revisor::with(['certificado'])
        ->when($search, function ($q, $search) {
            // Filtros para id_revisor y num_certificado
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
        $totalFiltered = Revisor::with('certificado')
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
        $nameRevisor = $revisor->user->name ?? null; // Obtener el nombre del revisor, si existe
        return [
            'id_revision' => $revisor->id_revision,
            'fake_id' => ++$start,
            'id_revisor' => $nameRevisor ? $nameRevisor : null, // Asignar null si no hay nombre
            'id_revisor2' => $revisor->id_revisor2,
            'observaciones' => $revisor->observaciones,
            'tipo_revision' => $revisor->tipo_revision,
            'num_certificado' => $revisor->certificado ? $revisor->certificado->num_certificado : null
        ];
    })->filter(function ($item) {
        // Filtrar los resultados para que no incluya los que tienen id_revisor null
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
