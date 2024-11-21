<?php

namespace App\Http\Controllers\solicitudes;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\empresa;
use App\Models\estados;
use App\Models\Instalaciones;
use App\Models\organismos;
use App\Models\solicitudesModel;
use App\Models\solicitudTipo;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class solicitudesController extends Controller
{
    public function UserManagement()
    {   $solicitudesTipos = solicitudTipo::all();
        $instalaciones = Instalaciones::all(); // Obtener todas las instalaciones
        $empresas = empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $estados = estados::all(); // Obtener todos los estados
        $organismos = organismos::all(); // Obtener todos los estados

        $inspectores = User::where('tipo','=','2')->get(); // Obtener todos los organismos
        return view('solicitudes.find_solicitudes_view', compact('instalaciones', 'empresas', 'estados', 'inspectores','solicitudesTipos','organismos'));
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
            8 => 'inspector',
            9 => 'fecha_servicio',
            10 => 'fecha_visita',

            11 => 'estatus'
        ];

        $search = [];

        $totalData = solicitudesModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        if (empty($request->input('search.value'))) {


                $solicitudes = solicitudesModel::with('tipo_solicitud','empresa','inspeccion','inspector', 'instalacion')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

        } else {
            $search = $request->input('search.value');




            $solicitudes = solicitudesModel::with('tipo_solicitud','empresa','inspeccion','inspector', 'instalacion')
                ->where(function ($query) use ($search) {
                    $query->where('id_solicitud', 'LIKE', "%{$search}%")
                        ->orWhere('razon_social', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered =  solicitudesModel::with('tipo_solicitud','empresa','inspeccion','inspector', 'instalacion')
                ->where(function ($query) use ($search) {
                    $query->where('id_solicitud', 'LIKE', "%{$search}%")
                        ->orWhere('razon_social', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = [];

        if (!empty($solicitudes)) {
            $ids = $start;

            foreach ($solicitudes as $solicitud) {
                $nestedData['id_solicitud'] = $solicitud->id_solicitud ?? 'N/A';
                $nestedData['fake_id'] = ++$ids  ?? 'N/A';
                $nestedData['folio'] = '<b class="text-primary">'.$solicitud->folio.'</b>';
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

    public function obtenerDatosSolicitud($id_solicitud){
        // Buscar los datos necesarios en la tabla "solicitudes"
        $solicitud = solicitudesModel::find($id_solicitud);

        $instalaciones = Instalaciones::where('id_empresa',$solicitud->id_empresa)->get();

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
            'message' => $solicitud->folio." ".$solicitud->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }


        // Retornar una respuesta JSON indicando éxito
        return response()->json(['success' => 'Solicitud registrada correctamente']);
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
        /* $solicitud->punto_reunion = $request->punto_reunion; */
        $solicitud->save();

        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios
        $data1 = [
            'title' => 'Nuevo registro de solicitud',
            'message' => $solicitud->folio." ".$solicitud->tipo_solicitud->tipo,
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
    $muestreo_granel= '------------';
    $vigilancia_traslado= '------------';
    $inspeccion_envasado= '------------';
    $muestreo_envasado= '------------';
    $ingreso_barrica= '------------';
    $liberacion= '------------';
    $liberacion_barrica= '------------';
    $geo= '------------';
    $exportacion= '------------';
    $certificado_granel= '------------';
    $certificado_nacional= '------------';
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
        $muestreo_granel= 'X';
    }

    if ($datos->id_tipo == 4) {
        $vigilancia_traslado= 'X';
    }

    if ($datos->id_tipo == 5) {
        $inspeccion_envasado= 'X';
    }

    if ($datos->id_tipo == 6) {
        $muestreo_envasado= 'X';
    }

    if ($datos->id_tipo == 7) {
        $ingreso_barrica= 'X';
    }

    if ($datos->id_tipo == 8) {
        $liberacion= 'X';
    }

    if ($datos->id_tipo == 9) {
        $liberacion_barrica= 'X';
    }

    if ($datos->id_tipo == 10) {
        $geo= 'X';
    }

    if ($datos->id_tipo == 11) {
        $exportacion= 'X';
    }

    if ($datos->id_tipo == 12) {
        $certificado_granel= 'X';
    }

    if ($datos->id_tipo == 13) {
        $certificado_nacional= 'X';
    }


    if ($datos->id_tipo == 14) {
        $dictaminacion = 'X';
    }

    if ($datos->id_tipo == 15) {
        $renovacion_dictaminacion = 'X';
    }

    $fecha_visita = Helpers::formatearFechaHora($datos->fecha_visita);

        $pdf = Pdf::loadView('pdfs.SolicitudDeServicio', compact('datos','muestreo_agave','vigilancia_produccion','dictaminacion','muestreo_granel',
        'vigilancia_traslado','inspeccion_envasado','muestreo_envasado','ingreso_barrica','liberacion','liberacion_barrica','geo','exportacion','certificado_granel','certificado_nacional','dictaminacion','renovacion_dictaminacion','fecha_visita'))
        ->setPaper([0, 0, 640, 880]); ;
        return $pdf->stream('Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32 Ed10 VIGENTE.pdf');
    }


    public function verificarSolicitud(Request $request)
{
    $id_predios = $request->input('id_predios');

    // Verifica si existe una solicitud asociada al id_predio
    $exists = solicitudesModel::where('id_predio', $id_predios)
    ->pluck ('id_predio') ->toArray();
    ;

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
