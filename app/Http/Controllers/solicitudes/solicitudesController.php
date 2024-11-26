<?php

namespace App\Http\Controllers\solicitudes;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\categorias;
use App\Models\empresa;
use App\Models\estados;
use App\Models\Instalaciones;
use App\Models\organismos;
use App\Models\LotesGranel;
use App\Models\solicitudesModel;
use App\Models\clases;
use App\Models\solicitudTipo;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\tipos;
use Illuminate\Http\Request;

class solicitudesController extends Controller
{
    public function UserManagement()
    {
        $solicitudesTipos = solicitudTipo::all();
        $instalaciones = Instalaciones::all(); // Obtener todas las instalaciones
        $empresas = empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $estados = estados::all(); // Obtener todos los estados
        $organismos = organismos::all(); // Obtener todos los estados
        $LotesGranel = LotesGranel::all();
        $categorias = categorias::all();
        $clases = clases::all();
        $tipos = tipos::all();



        $inspectores = User::where('tipo', '=', '2')->get(); // Obtener todos los organismos
        return view('solicitudes.find_solicitudes_view', compact('instalaciones', 'empresas', 'estados', 'inspectores', 'solicitudesTipos', 'organismos', 'LotesGranel', 'categorias', 'clases', 'tipos'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_solicitud',
            2 => 'folio',
            3 => 'num_servicio',
            4 => 'razon_social',
            5 => 'fecha_solicitud',
            6 => 'tipo',
            7 => 'direccion_completa',
            8 => 'fecha_visita',
            9 => 'inspector',
            10 => 'fecha_servicio',
            12 => 'estatus'
        ];

        $search = [];

        $totalData = solicitudesModel::count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        if (empty($request->input('search.value'))) {
          // Consulta sin búsqueda
          $solicitudes = solicitudesModel::with(['tipo_solicitud', 'empresa', 'instalacion'])
              ->leftJoin('empresa', 'solicitudes.id_empresa', '=', 'empresa.id_empresa')
              ->leftJoin('solicitudes_tipo', 'solicitudes.id_tipo', '=', 'solicitudes_tipo.id_tipo')
              ->leftJoin('instalaciones', 'solicitudes.id_instalacion', '=', 'instalaciones.id_instalacion')
              ->leftJoin('inspecciones', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
              ->leftJoin('users', 'inspecciones.id_inspector', '=', 'users.id')
              ->select('solicitudes.*',
                       'empresa.razon_social',
                       'solicitudes_tipo.tipo',
                       'instalaciones.direccion_completa',
                       'solicitudes.estatus',
                       'inspecciones.num_servicio',
                       'inspecciones.fecha_servicio',
                       'users.name as inspector_name')
              ->orderBy($order === 'inspector' ? 'inspector_name' : $order, $dir)
              ->offset($start)
              ->limit($limit)
              ->get();
      } else {
          // Consulta con búsqueda
          $search = $request->input('search.value');

          $solicitudes = solicitudesModel::with(['tipo_solicitud', 'empresa', 'inspeccion', 'instalacion'])
              ->leftJoin('inspecciones', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
              ->leftJoin('users', 'inspecciones.id_inspector', '=', 'users.id')
              ->leftJoin('empresa', 'solicitudes.id_empresa', '=', 'empresa.id_empresa') // Asegúrate de unir la tabla empresa aquí
              ->where(function ($query) use ($search) {
                  $query->where('solicitudes.id_solicitud', 'LIKE', "%{$search}%")
                      ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
                      ->orWhere('solicitudes.estatus', 'LIKE', "%{$search}%")
                      ->orWhereHas('empresa', function ($q) use ($search) {
                          $q->where('razon_social', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('tipo_solicitud', function ($q) use ($search) {
                          $q->where('tipo', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('instalacion', function ($q) use ($search) {
                          $q->where('direccion_completa', 'LIKE', "%{$search}%");
                      })
                      ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
                      ->orWhere('users.name', 'LIKE', "%{$search}%");
              })
              ->offset($start)
              ->limit($limit)
              ->orderBy("solicitudes.id_solicitud", $dir)
              ->get();

        $totalFiltered = solicitudesModel::with(['tipo_solicitud', 'empresa', 'inspeccion', 'instalacion'])
            ->leftJoin('inspecciones', 'solicitudes.id_solicitud', '=', 'inspecciones.id_solicitud')
            ->leftJoin('users', 'inspecciones.id_inspector', '=', 'users.id')
            ->where(function ($query) use ($search) {
                $query->where('solicitudes.id_solicitud', 'LIKE', "%{$search}%")
                    ->orWhere('solicitudes.folio', 'LIKE', "%{$search}%")
                    ->orWhere('solicitudes.estatus', 'LIKE', "%{$search}%")
                    ->orWhereHas('empresa', function ($q) use ($search) {
                        $q->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('tipo_solicitud', function ($q) use ($search) {
                        $q->where('tipo', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('instalacion', function ($q) use ($search) {
                        $q->where('direccion_completa', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('inspecciones.num_servicio', 'LIKE', "%{$search}%")
                    ->orWhere('users.name', 'LIKE', "%{$search}%");
            })
            ->count();
      }
        $data = [];

        if (!empty($solicitudes)) {
            $ids = $start;

            foreach ($solicitudes as $solicitud) {
                $nestedData['id_solicitud'] = $solicitud->id_solicitud ?? 'N/A';
                $nestedData['fake_id'] = ++$ids  ?? 'N/A';
                $nestedData['folio'] = '<b class="text-primary">' . $solicitud->folio . '</b>';
                $nestedData['num_servicio'] = $solicitud->inspeccion->num_servicio ?? '<span class="badge bg-danger">Sin asignar</apan>';
                $nestedData['razon_social'] = $solicitud->empresa->razon_social  ?? 'N/A';
                $nestedData['fecha_solicitud'] = Helpers::formatearFechaHora($solicitud->fecha_solicitud)  ?? 'N/A';
                $nestedData['tipo'] = $solicitud->tipo_solicitud->tipo  ?? 'N/A';
                $nestedData['direccion_completa'] = $solicitud->instalacion->direccion_completa ?? $solicitud->predios->ubicacion_predio ?? 'N/A';
                $nestedData['fecha_visita'] = Helpers::formatearFechaHora($solicitud->fecha_visita)  ?? '<span class="badge bg-danger">Sin asignar</apan>';
                $nestedData['inspector'] = $solicitud->inspector->name ?? '<span class="badge bg-danger">Sin asignar</apan>'; // Maneja el caso donde el organismo sea nulo
                $nestedData['foto_inspector'] = $solicitud->inspector->profile_photo_path ?? ''; // Maneja el caso donde el organismo sea nulo
                $nestedData['fecha_servicio'] = Helpers::formatearFecha(optional($solicitud->inspeccion)->fecha_servicio) ?? '<span class="badge bg-danger">Sin asignar</apan>';
                $nestedData['id_tipo'] = $solicitud->tipo_solicitud->id_tipo  ?? 'N/A';
                $nestedData['estatus'] = $solicitud->estatus ?? 'Vacío';



                $data[] = $nestedData;
            }
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
    }

    public function obtenerDatosSolicitud($id_solicitud)
    {
        // Buscar los datos necesarios en la tabla "solicitudes"
        $solicitud = solicitudesModel::find($id_solicitud);

        $instalaciones = Instalaciones::where('id_empresa', $solicitud->id_empresa)->get();

        $caracteristicas = $solicitud->caracteristicas
            ? json_decode($solicitud->caracteristicas, true)
            : null;

        if ($solicitud) {
            return response()->json([
                'success' => true,
                'data' => $solicitud,
                'caracteristicas' => $caracteristicas,
                'instalaciones' => $instalaciones,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Solicitud no encontrada.',
        ], 404);
    }

    public function store(Request $request)
    {


        // Validar los datos recibidos del formulario
        /*   $request->validate([
            'folio' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
            'id_marca' => 'required|integer',
            'cantidad_hologramas' => 'required|integer',
            'id_direccion' => 'required|integer',
            'comentarios' => 'nullable|string|max:1000',
        ]);*/



        $solicitud = new solicitudesModel();
        $solicitud->folio = Helpers::generarFolioSolicitud();
        $solicitud->id_empresa = $request->id_empresa;
        $solicitud->id_tipo = 14;
        $solicitud->fecha_visita = $request->fecha_visita;
        //Auth::user()->id;
        $solicitud->id_instalacion = $request->id_instalacion;
        $solicitud->info_adicional = $request->info_adicional;
        // Guardar el nuevo registro en la base de datos
        $solicitud->save();

        // Obtener varios usuarios (por ejemplo, todos los usuarios con cierto rol o todos los administradores)
        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

        // Notificación 1
        $data1 = [
            'title' => 'Nuevo registro de solicitud',
            'message' => $solicitud->folio . " " . $solicitud->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }


        // Retornar una respuesta JSON indicando éxito
        return response()->json(['success' => 'Solicitud registrada correctamente']);
    }


    public function storeVigilanciaProduccion(Request $request)
    {
        $VigilanciaProdu = new solicitudesModel();
        $VigilanciaProdu->folio = Helpers::generarFolioSolicitud();
        $VigilanciaProdu->id_empresa = $request->id_empresa;
        $VigilanciaProdu->id_tipo = 2;
        $VigilanciaProdu->id_predio = 0;
        $VigilanciaProdu->fecha_visita = $request->fecha_visita;
        $VigilanciaProdu->id_instalacion = $request->id_instalacion;
        $VigilanciaProdu->info_adicional = $request->info_adicional;

        $VigilanciaProdu->caracteristicas = json_encode([
            'id_lote_granel' => $request->id_lote_granel,
            'id_categoria' => $request->id_categoria,
            'id_clase' => $request->id_clase,
            'id_tipo' => $request->id_tipo,
            'analisis' => $request->analisis,
            'volumen' => $request->volumen,
            'fecha_corte' => $request->fecha_corte,
            'kg_maguey' => $request->kg_maguey,
            'cant_pinas' => $request->cant_pinas,
            'art' => $request->art,
            'etapa' => $request->etapa,
            'folio' => $request->folio,
            'nombre_predio' => $request->nombre_predio,
        ]);

        $VigilanciaProdu->save();

        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

        // Notificación 1
        $data1 = [
            'title' => 'Nuevo registro de solicitud',
            'message' => $VigilanciaProdu->folio . " " . $VigilanciaProdu->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }
        return response()->json(['message' => 'Vigilancia en producción de lote registrada exitosamente']);
    }

    public function registrarSolicitudGeoreferenciacion(Request $request)
    {

        $solicitud = new solicitudesModel();
        $solicitud->folio = Helpers::generarFolioSolicitud();
        $solicitud->id_empresa = $request->id_empresa;
        $solicitud->id_tipo = 10;
        $solicitud->fecha_visita = $request->fecha_visita;
        $solicitud->id_instalacion = $request->id_instalacion ? $request->id_instalacion : 0;
        $solicitud->id_predio = $request->id_predio;
        $solicitud->info_adicional = $request->info_adicional;
        // Preparar el JSON para la columna `caracteristicas`
        $caracteristicas = [
            'punto_reunion' => $request->punto_reunion,
        ];

        // Convertir a JSON y asignarlo
        $solicitud->caracteristicas = json_encode($caracteristicas);

        $solicitud->save();

        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios
        $data1 = [
            'title' => 'Nuevo registro de solicitud',
            'message' => $solicitud->folio . " " . $solicitud->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }
        return response()->json(['success' => 'Solicitud registrada correctamente']);
    }

    public function pdf_solicitud_servicios_070($id_solicitud)
    {
        $datos = solicitudesModel::find($id_solicitud);

        // Inicializa las variables con un valor vacío
        $muestreo_agave = '------------';
        $vigilancia_produccion = '------------';
        $muestreo_granel = '------------';
        $vigilancia_traslado = '------------';
        $inspeccion_envasado = '------------';
        $muestreo_envasado = '------------';
        $ingreso_barrica = '------------';
        $liberacion = '------------';
        $liberacion_barrica = '------------';
        $geo = '------------';
        $exportacion = '------------';
        $certificado_granel = '------------';
        $certificado_nacional = '------------';
        $dictaminacion = '------------';
        $renovacion_dictaminacion = '------------';


        // Verificar el valor de id_tipo y marcar la opción correspondiente
        if ($datos->id_tipo == 1) {
            $muestreo_agave = 'X';
        }

        if ($datos->id_tipo == 2) {
            $vigilancia_produccion = 'X';
        }

        if ($datos->id_tipo == 3) {
            $muestreo_granel = 'X';
        }

        if ($datos->id_tipo == 4) {
            $vigilancia_traslado = 'X';
        }

        if ($datos->id_tipo == 5) {
            $inspeccion_envasado = 'X';
        }

        if ($datos->id_tipo == 6) {
            $muestreo_envasado = 'X';
        }

        if ($datos->id_tipo == 7) {
            $ingreso_barrica = 'X';
        }

        if ($datos->id_tipo == 8) {
            $liberacion = 'X';
        }

        if ($datos->id_tipo == 9) {
            $liberacion_barrica = 'X';
        }

        if ($datos->id_tipo == 10) {
            $geo = 'X';
        }

        if ($datos->id_tipo == 11) {
            $exportacion = 'X';
        }

        if ($datos->id_tipo == 12) {
            $certificado_granel = 'X';
        }

        if ($datos->id_tipo == 13) {
            $certificado_nacional = 'X';
        }


        if ($datos->id_tipo == 14) {
            $dictaminacion = 'X';
        }

        if ($datos->id_tipo == 15) {
            $renovacion_dictaminacion = 'X';
        }

        $fecha_visita = Helpers::formatearFechaHora($datos->fecha_visita);

        $pdf = Pdf::loadView('pdfs.SolicitudDeServicio', compact(
            'datos',
            'muestreo_agave',
            'vigilancia_produccion',
            'dictaminacion',
            'muestreo_granel',
            'vigilancia_traslado',
            'inspeccion_envasado',
            'muestreo_envasado',
            'ingreso_barrica',
            'liberacion',
            'liberacion_barrica',
            'geo',
            'exportacion',
            'certificado_granel',
            'certificado_nacional',
            'dictaminacion',
            'renovacion_dictaminacion',
            'fecha_visita'
        ))
            ->setPaper([0, 0, 640, 880]);;
        return $pdf->stream('Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32 Ed10 VIGENTE.pdf');
    }


    public function verificarSolicitud(Request $request)
    {
        $id_predios = $request->input('id_predios');

        // Verifica si existe una solicitud asociada al id_predio
        $exists = solicitudesModel::where('id_predio', $id_predios)
            ->pluck('id_predio')->toArray();;

        return response()->json(['hasSolicitud' => $exists]);
    }

    public function actualizarSolicitudes(Request $request, $id_solicitud)
    {
        // Encuentra la solicitud por ID
        $solicitud = solicitudesModel::find($id_solicitud);

        if (!$solicitud) {
            return response()->json(['success' => false, 'message' => 'Solicitud no encontrada'], 404);
        }

        // Verifica el tipo de formulario
        $formType = $request->input('form_type');

        switch ($formType) {
            case 'vigilanciaenproduccion':
                // Validar datos para georreferenciación
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'required|string'
                ]);
                // Preparar el JSON para guardar en `caracteristicas`
                $caracteristicasJson = [
                    'id_lote_granel' => $request->id_lote_granel,
                    'id_categoria' => $request->id_categoria,
                    'id_clase' => $request->id_clase,
                    'id_tipo' => $request->id_tipo,
                    'analisis' => $request->analisis,
                    'volumen' => $request->volumen,
                    'fecha_corte' => $request->fecha_corte,
                    'kg_maguey' => $request->kg_maguey,
                    'cant_pinas' => $request->cant_pinas,
                    'art' => $request->art,
                    'etapa' => $request->etapa,
                    'folio' => $request->folio,
                    'nombre_predio' => $request->nombre_predio,
                ];

                // Convertir el array a JSON
                $jsonContent = json_encode($caracteristicasJson);

                // Actualizar datos específicos para georreferenciación
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);

                break;


            case 'georreferenciacion':
                // Validar datos para georreferenciación
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_visita' => 'required|date',
                    'id_predio' => 'required|integer|exists:predios,id_predio',
                    'punto_reunion' => 'required|string|max:255',
                    'info_adicional' => 'required|string'
                ]);
                // Preparar el JSON para guardar en `caracteristicas`
                $caracteristicasJson = [
                    'punto_reunion' => $request->punto_reunion,
                ];

                // Convertir el array a JSON
                $jsonContent = json_encode($caracteristicasJson);

                // Actualizar datos específicos para georreferenciación
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_visita' => $request->fecha_visita,
                    'id_predio' => $request->id_predio,
                    'punto_reunion' => $request->punto_reunion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);

                break;


            case 'dictaminacion':
                // Validar datos para dictaminación
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'required|string|max:5000',
                ]);

                // Actualizar datos específicos para dictaminación
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                ]);
                break;

            default:
                return response()->json(['success' => false, 'message' => 'Tipo de solicitud no reconocido'], 400);
        }

        return response()->json(['success' => true, 'message' => 'Solicitud actualizada correctamente']);
    }
}
