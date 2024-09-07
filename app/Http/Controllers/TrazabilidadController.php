<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class TrazabilidadController extends Controller
{
    public function mostrarLogs($id)
    {
        $logs = Activity::where(function($query) use ($id) {
            // Filtrar los registros del modelo inspecciones con el id_solicitud en las properties
            $query->where('subject_type', 'App\Models\inspecciones')
                ->where('properties->attributes->id_solicitud', $id);
        })
        ->orWhere(function($query) use ($id) {
            // Filtrar los registros del modelo solicitudesModel con el causer_id igual al id_solicitud
            $query->where('subject_type', 'App\Models\solicitudesModel')
                ->where('subject_id', $id);
        })
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($log) {
            return [
                'description' => $log->description,
                'properties' => $log->properties,
                'created_at' => $log->created_at->toDateTimeString(),
            ];
        });
    
    return response()->json(['success' => true, 'logs' => $logs]);
    
    }
}
