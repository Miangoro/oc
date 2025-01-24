<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
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

    $hoy = Carbon::now();
    $fechaLimite = $hoy->addDays(15);
    
    $dictamenesPorVencer = Dictamen_instalaciones::whereDate('fecha_vigencia', '>=', $hoy)
        ->whereDate('fecha_vigencia', '<=', $fechaLimite)
        ->get();


  



  
  

    return view('content.dashboard.dashboards-analytics',compact('solicitudesSinInspeccion','solicitudesSinActa','dictamenesPorVencer'));
  }
}
