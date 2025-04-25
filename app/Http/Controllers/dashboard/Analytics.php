<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Certificado_Exportacion;
use App\Models\Certificados;
use App\Models\CertificadosGranel;
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

  public function estadisticasCertificados()
  {
      $year = now()->year;
  
      // Helper para contar por mes
      $contarPorMes = function ($query) use ($year) {
          return $query->whereYear('fecha_vigencia', $year)
              ->selectRaw('MONTH(fecha_vigencia) as mes, COUNT(*) as total')
              ->groupBy('mes')
              ->pluck('total', 'mes')
              ->toArray();
      };
  
      $instalaciones = $contarPorMes(Certificados::query());
      $granel = $contarPorMes(CertificadosGranel::query());
      $exportacion = $contarPorMes(Certificado_Exportacion::query());
  
      // Asegura que haya un valor para cada mes (1-12), aunque sea 0
      $formatearDatos = function ($datos) {
          $meses = array_fill(1, 12, 0); // meses del 1 al 12
          foreach ($datos as $mes => $total) {
              $meses[$mes] = $total;
          }
          return array_values($meses); // ordenados por mes
      };
  
      return response()->json([
          'instalaciones' => $formatearDatos($instalaciones),
          'granel' => $formatearDatos($granel),
          'exportacion' => $formatearDatos($exportacion),
      ]);
  }

}
