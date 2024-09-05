<?php

namespace App\Http\Controllers\Solicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SolicitudTipo;

class SolicitudesTipoController extends Controller
{
    public function UserManagement()
    {
        $solicitudesTipos = SolicitudTipo::all();
        return view('solicitudes.solicitudes_view', compact('solicitudesTipos'));
    }

    public function getSolicitudesTipos()
    {
        try {
            $solicitudesTipos = SolicitudTipo::all();
            return response()->json($solicitudesTipos);
        } catch (\Exception $e) {
            \Log::error('Error al obtener tipos de solicitud: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener los tipos de solicitud.'], 500);
        }
    }

}
