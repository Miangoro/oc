<?php

namespace App\Http\Controllers\dashboard;

use App\Exports\CertificadosExport;
use App\Http\Controllers\Controller;
use App\Models\Certificado_Exportacion;
use App\Models\Certificados;
use App\Models\CertificadosGranel;
use App\Models\Dictamen_Envasado;
use App\Models\Dictamen_Exportacion;
use App\Models\Dictamen_Granel;
use App\Models\Dictamen_instalaciones;
use App\Models\inspecciones;
use App\Models\LotesGranel;
use App\Models\maquiladores_model;
use App\Models\marcas;
use App\Models\Revisor;
use App\Models\solicitudesModel;
use App\Models\solicitudTipo;
use App\Models\User;
use App\Models\carousel;
use App\Models\mensajes_dashboard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Analytics extends Controller
{
  public function index()
  {
    //$datos = solicitudesModel::All();
    /* $solicitudesSinInspeccion = solicitudesModel::doesntHave('inspeccion')->where('fecha_solicitud','>','2024-12-31')->count(); */
    $solicitudesSinInspeccion = solicitudesModel::doesntHave('inspeccion')
    ->where('fecha_solicitud', '>', '2024-12-31')
    ->where('habilitado', 1)
    ->whereNotIn('id_tipo', [12, 13, 15])
    ->orderByDesc('fecha_solicitud')
    ->get();
    $solicitudesSinActa = solicitudesModel::whereNotIn('id_tipo', [12, 13, 15])
    ->where('fecha_solicitud', '>=', '2025-01-01')
     ->where('fecha_solicitud', '<=', '2025-12-31')
    ->where('habilitado', 1)
    ->where(function ($query) {
        $query->doesntHave('documentacion_completa')
              ->orWhereDoesntHave('documentacion_completa', function ($q) {
                  $q->where('id_documento', 69);
              });
    })->orderByDesc('fecha_solicitud')
    ->get();

 $actasSinActivarHologramas = solicitudesModel::where('id_tipo',5)->where('estatus_activado','0')->where('fecha_solicitud','>','2024-12-31')->orderByDesc('fecha_solicitud')->get();

$solicitudesSinDictamen = solicitudesModel::where('fecha_solicitud', '>', '2024-12-31')
 ->where('habilitado', 1)
    ->where(function ($query) {
        $query
            ->where(function ($q) {
                $q->where('id_tipo', 14)
                  ->whereDoesntHave('inspeccion.dictamen');
            })
            ->orWhere(function ($q) {
                $q->where('id_tipo', 3)
                  ->whereDoesntHave('inspeccion.dictamenGranel');
            })
            ->orWhere(function ($q) {
                $q->where('id_tipo', 5)
                  ->whereDoesntHave('inspeccion.dictamenEnvasado');
            })
            ->orWhere(function ($q) {
                $q->where('id_tipo', 11)
                  ->whereDoesntHave('inspeccion.dictamenExportacion');
            });
    })->orderByDesc('fecha_solicitud')
    ->get();


$mes = request('mes', now()->month); // 👈 Usa el mes actual si no se envió ninguno


$revisiones = Revisor::select(
        'id_revisor as user_id',
        DB::raw("CASE
                    WHEN tipo_revision = 1 THEN 'Personal'
                    WHEN tipo_revision = 2 THEN 'Consejo'
                    ELSE 'Desconocido'
                END as rol"),
        'tipo_certificado',
        'decision', // 👈 Agrupas también por esto
        DB::raw('COUNT(*) as total')
    )
    ->whereNotNull('id_revisor')
    ->whereMonth('created_at', $mes)
    /* ->when($mes, function ($query) use ($mes) {
        $query->whereMonth('created_at', $mes);
    }) */
    ->groupBy('id_revisor', 'tipo_revision', 'tipo_certificado', 'decision')
    ->get();


// 2. Obtener usuarios
$userIds = $revisiones->pluck('user_id')->unique();
$usuarios = User::whereIn('id', $userIds)->get()->keyBy('id');





    $hoy = Carbon::today(); // Solo la fecha, sin hora.
    $fechaLimite = $hoy->copy()->addDays(5); // Fecha límite en 5 días.


    $dictamenesInstalacion = Dictamen_instalaciones::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    $dictamenesGranel = Dictamen_granel::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    //$dictamenesEnvasado = Dictamen_Envasado::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    $dictamenesExportacion = Dictamen_Exportacion::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    $dictamenesPorVencer = $dictamenesInstalacion
      ->merge($dictamenesGranel)
      //->merge($dictamenesEnvasado)
      ->merge($dictamenesExportacion);

    $certificadosInstalacion = Certificados::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    $certificadosGranel = CertificadosGranel::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    $certificadosExportacion = Certificado_Exportacion::whereBetween('fecha_vigencia', [$hoy, $fechaLimite])->get();
    //$certificadosPorVencer = $certificadosInstalacion
    //  ->merge($certificadosGranel)
    //  ->merge($certificadosExportacion);
    $certificadosPorVencer = $certificadosInstalacion;

    $dictamenesInstalacionesSinCertificado = Dictamen_instalaciones::whereDoesntHave('certificado')->where('fecha_emision','>','2024-12-31')->get();
    $dictamenesGranelesSinCertificado = Dictamen_Granel::whereDoesntHave('certificado')->where('fecha_emision','>','2024-12-31')->get();
    $dictamenesExportacionSinCertificado  = Dictamen_Exportacion::whereDoesntHave('certificado')->where('fecha_emision','>','2024-12-31')->get();

    $lotesSinFq = LotesGranel::whereDoesntHave('fqs')->get();

    $certificadoGranelSinEscaneado = CertificadosGranel::whereDoesntHave('certificadoEscaneado')->orderByDesc('fecha_emision')->get();
    $certificadoExportacionSinEscaneado = Certificado_Exportacion::whereDoesntHave('certificadoEscaneado')->orderByDesc('fecha_emision')->get();
    $certificadoInstalacionesSinEscaneado = Certificados::whereDoesntHave('certificadoEscaneado')->orderByDesc('fecha_emision')->get();



    $empresaId = Auth::user()?->empresa?->id_empresa;

$TotalCertificadosExportacionPorMes = Certificado_Exportacion::with('dictamen.inspeccione.solicitud')
    ->whereHas('dictamen.inspeccione.solicitud.empresa', function ($query) use ($empresaId) {
        $query->where('id_empresa', $empresaId);
    })
    ->whereHas('dictamen.inspeccione.solicitud', function ($query) {
        $query->where('fecha_visita', '>', '2024-12-31');
    })
    ->get()
    ->groupBy(function ($item) {
        return \Carbon\Carbon::parse($item->dictamen->inspeccione->solicitud->fecha_visita)->format('Y-m');
    })
    ->map(function ($group) {
        return (object) [
            'mes' => $group->first()->dictamen->inspeccione->solicitud->fecha_visita
                        ? \Carbon\Carbon::parse($group->first()->dictamen->inspeccione->solicitud->fecha_visita)->format('Y-m')
                        : null,
            'total' => $group->count(),
            'certificado_reexpedido' => $group->where('certificado_reexpedido', true)->count() > 0,
        ];
    })
    ->sortBy(function ($item) {
        return \Carbon\Carbon::createFromFormat('Y-m', $item->mes); // 🔑 Ordena como fecha real
    })
    ->values();






// Traer las inspecciones futuras con su inspector
$inspecciones = inspecciones::with('inspector')
    ->whereHas('inspector') // asegura que tenga inspector
    ->where('fecha_servicio', '>', Carbon::parse('2024-12-31'))
    ->get()
    ->unique('num_servicio') // <-- omite duplicados por num_servicio
    ->groupBy(function ($inspeccion) {
        return $inspeccion->inspector->id; // agrupamos por ID del inspector
    });

// Preparar el resultado
$inspeccionesInspector = $inspecciones->map(function ($grupo) {
    $inspector = $grupo->first()->inspector;
    return [
        'nombre' => $inspector->name,
        'foto' => $inspector->profile_photo_path,
        'total_inspecciones' => $grupo->count(),
    ];
})->sortByDesc('total_inspecciones');

$marcasConHologramas = marcas::with('solicitudHolograma')
    ->where('id_empresa', $empresaId) // <-- filtro en la tabla marcas
    ->whereHas('solicitudHolograma', function ($q) use ($empresaId) {
        $q->where('id_empresa', $empresaId); // <-- filtro en la tabla de la relación
    })
    ->get();




$serviciosInstalacion = SolicitudesModel::with(['inspeccion', 'instalacion'])
    ->whereHas('instalacion')
    ->whereHas('inspeccion') // <-- IMPORTANTE: filtra solo con inspección asociada
    ->where('id_empresa', $empresaId)
    ->where('id_tipo', 11)
    ->where('fecha_solicitud', '>', '2025-05-30')
    ->get()
    ->groupBy(function ($item) {
        return optional($item->inspeccion)->fecha_servicio
            ? Carbon::parse($item->inspeccion->fecha_servicio)->format('Y-m')
            : 'Sin fecha';
    })
    ->map(function ($items) {
        return $items->groupBy(function ($item) {
            return optional($item->inspeccion)->fecha_servicio
                ? Carbon::parse($item->inspeccion->fecha_servicio)->format('Y-m-d')
                : 'Sin fecha';
        })->map(function ($porFecha) {
            return $porFecha->groupBy(function ($item) {
                return $item->instalacion->direccion_completa ?? 'Sin dirección';
            })->map(function ($porInstalacion) {
                return $porInstalacion
                    ->pluck('inspeccion.num_servicio')
                    ->filter()
                    ->unique()
                    ->count();
            });
        });
    });


$pendientesRevisarCertificadosConsejo = Revisor::where('decision', 'Pendiente')
    ->where('id_revisor', auth()->id())
    ->get();


    $maquiladores = maquiladores_model::with('maquiladores')->where('id_maquiladora',$empresaId)->get();
    $maquiladora = maquiladores_model::with('maquiladora')->where('id_maquilador',$empresaId)->get();
    $imagenes = carousel::orderBy('orden')->get();
    $mensajes = mensajes_dashboard::where(function($query) {
    $query->where('id_usuario_destino', auth()->id())
              ->orWhereNull('id_usuario_destino'); // globales
    })->where('activo', 1)
      ->orderBy('orden')
      ->get();
    return view('content.dashboard.dashboards-analytics', compact('actasSinActivarHologramas','maquiladora','maquiladores','certificadoInstalacionesSinEscaneado','certificadoExportacionSinEscaneado','pendientesRevisarCertificadosConsejo','serviciosInstalacion','revisiones','usuarios','marcasConHologramas','TotalCertificadosExportacionPorMes','certificadoGranelSinEscaneado','lotesSinFq','inspeccionesInspector','solicitudesSinInspeccion', 'solicitudesSinActa','solicitudesSinDictamen' , 'dictamenesPorVencer', 'certificadosPorVencer', 'dictamenesInstalacionesSinCertificado', 'dictamenesGranelesSinCertificado','dictamenesExportacionSinCertificado', 'imagenes', 'mensajes'));
  }

public function revisionesPorMes(Request $request)
{
    $mes = $request->mes;

    $revisiones = Revisor::select(
        'id_revisor as user_id',
        DB::raw("CASE WHEN tipo_revision = 1 THEN 'Personal'
                      WHEN tipo_revision = 2 THEN 'Consejo'
                      ELSE 'Desconocido' END as rol"),
        'tipo_certificado',
        'decision',
        DB::raw('COUNT(*) as total')
    )
    ->whereNotNull('id_revisor')
    ->when($mes, fn($q) => $q->whereMonth('created_at', $mes))
    ->groupBy('id_revisor', 'tipo_revision', 'tipo_certificado', 'decision')
    ->get();

    $agrupado = $revisiones->groupBy(fn($r) => $r->user_id . '-' . $r->rol);

    $usuarios = User::whereIn('id', $revisiones->pluck('user_id'))->get()->keyBy('id');

    // Renderizar el contenido de <tbody> como HTML
  $html = '';
    foreach ($agrupado as $key => $grupo) {
        $revisor = $usuarios[$grupo->first()->user_id] ?? null;
        $rol = $grupo->first()->rol;
        $inst = $grupo->where('tipo_certificado', 1)->where('decision', '!=', 'Pendiente')->sum('total');
        $gran = $grupo->where('tipo_certificado', 2)->where('decision', '!=', 'Pendiente')->sum('total');
        $expo = $grupo->where('tipo_certificado', 3)->where('decision', '!=', 'Pendiente')->sum('total');
        $pendientes = $grupo->where('decision', 'Pendiente')->sum('total');

        $classTd = $revisor?->id == auth()->id() ? 'bg-primary text-white fw-bold' : '';

        $rolBadge = match ($rol) {
            'Personal' => 'bg-label-info',
            'Consejo' => 'bg-label-warning',
            default => 'bg-label-secondary',
        };

          $html .= '
          <tr>
              <td class="' . $classTd . '" style="padding: 0.25rem 0.5rem;">
                  <div class="d-flex align-items-center gap-2 hover-scale" style="background-color: #f0f0f0; border-radius: 13px; padding: 0.10rem 0.5rem;">
                      <div class="avatar flex-shrink-0">';
          if (!empty($revisor?->profile_photo_path)) {
              $html .= '<img src="/storage/' . $revisor->profile_photo_path . '" alt="' . htmlspecialchars($revisor->name) . '" class="rounded-pill" style="width: 36px; height: 36px; object-fit: cover;">';
          }
          $html .= '</div>
                      <div class="d-flex flex-column">
                          <h6 class="mb-0" style="font-weight: 600; font-size: 0.9rem; color: #212529;">
                              ' . htmlspecialchars($revisor?->name ?? '—') . '
                          </h6>
                          <span class="badge rounded-pill ' . $rolBadge . '" style="font-size: 0.9rem; padding: 0.2em 0.5em;">
                              ' . $rol . '
                          </span>
                      </div>
                  </div>
              </td>
              <td class="text-end">' . number_format($inst) . '</td>
              <td class="text-end">' . number_format($gran) . '</td>
              <td class="text-end">' . number_format($expo) . '</td>
              <td class="text-end ' . ($pendientes > 0 ? 'bg-danger text-white fw-bold' : '') . '">' . number_format($pendientes) . '</td>
          </tr>';
      }

      if ($agrupado->isEmpty()) {
          $html = '<tr><td colspan="5" class="text-center text-muted">No hay revisiones registradas.</td></tr>';
      }

    return response()->json(['html' => $html]);
}


  public function estadisticasCertificados(Request $request)
  {
    $year = $request->input('year', now()->year);

    // Helper para contar por mes
    $contarPorMes = function ($query) use ($year) {
      return $query->whereYear('fecha_emision', $year)
        ->selectRaw('MONTH(fecha_emision) as mes, COUNT(*) as total')
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

  public function estadisticasServicios(Request $request)
  {
      $year = $request->input('year', now()->year);

      // Trae todos los tipos de servicio con su ID y nombre
      $tipos = solicitudTipo::pluck('tipo', 'id_tipo'); // [1 => 'Instalaciones', 2 => 'Granel', ...]

      $formatearDatos = function ($datos) {
          $meses = array_fill(1, 12, 0);
          foreach ($datos as $mes => $total) {
              $meses[$mes] = $total;
          }
          return array_values($meses);
      };

      $inspecciones = [];

      foreach ($tipos as $id => $nombre) {
          $datos = inspecciones::whereHas('solicitud', function ($query) use ($id) {
                  $query->where('id_tipo', $id);
              })
              ->whereYear('fecha_servicio', $year)
              ->selectRaw('MONTH(fecha_servicio) as mes, COUNT(*) as total')
              ->groupBy('mes')
              ->pluck('total', 'mes')
              ->toArray();

          $inspecciones[$nombre] = $formatearDatos($datos);
      }

      return response()->json([
          'inspecciones' => $inspecciones
      ]);
  }




}
