<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Certificados;
use App\Models\Dictamen_instalaciones;
use App\Models\solicitudesModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Analytics extends Controller
{
  public function index()
  { 
    //$datos = solicitudesModel::All();
    $solicitudesSinInspeccion = solicitudesModel::doesntHave('inspeccion')->count();
    $solicitudesSinActa = solicitudesModel::doesntHave('documentacion_completa')
    ->orWhereHas('documentacion_completa', function ($query) {
        $query->where('id_documento', '!=', 69);
    })
    ->count();

    
   

    $hoy = Carbon::today(); // Solo la fecha, sin hora.
    $fechaLimite = $hoy->copy()->addDays(15); // Fecha límite en 15 días.
    
    $dictamenesPorVencer = Dictamen_instalaciones::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    $certificadosPorVencer = Certificados::whereBetween('fecha_vencimiento', [$hoy, $fechaLimite])->get();
    

    

   

    return view('content.dashboard.dashboards-analytics',compact('solicitudesSinInspeccion','solicitudesSinActa','dictamenesPorVencer','certificadosPorVencer'));
  }
}
