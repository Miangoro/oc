<?php

namespace App\Http\Controllers\solicitudes;

use App\Helpers\Helpers;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Models\categorias;
use App\Models\empresa;
use App\Models\estados;
use App\Models\Instalaciones;
use App\Models\organismos;
use App\Models\LotesGranel;
use App\Models\lotes_envasado;
use App\Models\solicitudesModel;
use App\Models\clases;
use App\Models\solicitudTipo;
use App\Models\Documentacion_url;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\tipos;
use App\Models\marcas;
use App\Models\Destinos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class solicitudesController extends Controller
{
    public function UserManagement()
    {
        $solicitudesTipos = solicitudTipo::all();
        $instalaciones = Instalaciones::all(); // Obtener todas las instalaciones
        $estados = estados::all(); // Obtener todos los estados
        $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $organismos = organismos::all(); // Obtener todos los estados
        $LotesGranel = LotesGranel::all();
        $categorias = categorias::all();
        $clases = clases::all();
        $tipos = tipos::all();
        $marcas = marcas::all();


        $inspectores = User::where('tipo', '=', '2')->get(); // Obtener todos los organismos
        return view('solicitudes.find_solicitudes_view', compact('instalaciones', 'empresas', 'estados', 'inspectores', 'solicitudesTipos', 'organismos', 'LotesGranel', 'categorias', 'clases', 'tipos', 'marcas'));
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
                ->select(
                    'solicitudes.*',
                    'empresa.razon_social',
                    'solicitudes_tipo.tipo',
                    'instalaciones.direccion_completa',
                    'solicitudes.estatus',
                    'inspecciones.num_servicio',
                    'inspecciones.fecha_servicio',
                    'users.name as inspector_name'
                )
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
                $nestedData['fake_id'] = ++$ids ?? 'N/A';
                $nestedData['folio'] = '<b class="text-primary">' . $solicitud->folio . '</b>';
                $nestedData['num_servicio'] = $solicitud->inspeccion->num_servicio ?? '<span class="badge bg-danger">Sin asignar</span>';
                $nestedData['razon_social'] = $solicitud->empresa->razon_social ?? 'N/A';
                $nestedData['fecha_solicitud'] = Helpers::formatearFechaHora($solicitud->fecha_solicitud) ?? 'N/A';
                $nestedData['tipo'] = $solicitud->tipo_solicitud->tipo ?? 'N/A';
                $nestedData['direccion_completa'] = $solicitud->instalacion->direccion_completa ?? $solicitud->predios->ubicacion_predio ?? 'N/A';
                $nestedData['fecha_visita'] = Helpers::formatearFechaHora($solicitud->fecha_visita) ?? '<span class="badge bg-danger">Sin asignar</span>';
                $nestedData['inspector'] = $solicitud->inspector->name ?? '<span class="badge bg-danger">Sin asignar</span>';
                $nestedData['foto_inspector'] = $solicitud->inspector->profile_photo_path ?? '';
                $nestedData['fecha_servicio'] = Helpers::formatearFecha(optional($solicitud->inspeccion)->fecha_servicio) ?? '<span class="badge bg-danger">Sin asignar</span>';
                $nestedData['id_tipo'] = $solicitud->tipo_solicitud->id_tipo ?? 'N/A';
                $nestedData['estatus'] = $solicitud->estatus ?? 'Vacío';
                $nestedData['info_adicional'] = $solicitud->info_adicional ?? 'Vacío';

                // Decodificar JSON y extraer datos específicos
                $caracteristicas = json_decode($solicitud->caracteristicas, true);
                //case 2
                $idLoteGranel = $caracteristicas['id_lote_granel'] ?? null;
                if ($idLoteGranel) {
                    $loteGranel = LotesGranel::find($idLoteGranel); // Busca el lote a granel
                    $nestedData['id_lote_granel'] = $idLoteGranel;
                    $nestedData['nombre_lote'] = $loteGranel ? $loteGranel->nombre_lote : 'N/A';
                } else {
                    $nestedData['id_lote_granel'] = 'N/A';
                    $nestedData['nombre_lote'] = 'N/A';
                }
                $nestedData['nombre_predio'] = $caracteristicas['nombre_predio'] ?? 'N/A';
                $nestedData['art'] = $caracteristicas['art'] ?? 'N/A';
                $nestedData['analisis'] = $caracteristicas['analisis'] ?? 'N/A';
                $nestedData['folio_caracteristicas'] = $caracteristicas['folio'] ?? 'N/A';
                $nestedData['etapa'] = $caracteristicas['etapa'] ?? 'N/A';
                $nestedData['fecha_corte'] = isset($caracteristicas['fecha_corte'])
                    ? Carbon::parse($caracteristicas['fecha_corte'])->format('d/m/Y H:i')
                    : 'N/A';
                //case 3
                $idLoteGranelDestino = $caracteristicas['id_lote_granel'] ?? null;
                if ($idLoteGranelDestino) {
                    $loteGranel = LotesGranel::find($idLoteGranelDestino); // Busca el lote a granel
                    $nestedData['id_lote_granel_muestreo'] = $idLoteGranelDestino;
                    $nestedData['nombre_lote_muestreo'] = $loteGranel ? $loteGranel->nombre_lote : 'N/A';
                } else {
                    $nestedData['id_lote_granel_muestreo'] = 'N/A';
                    $nestedData['nombre_lote_muestreo'] = 'N/A';
                }
                $nestedData['destino_lote'] = $caracteristicas['destino_lote'] ?? 'N/A';
                $nestedData['id_categoria_muestreo'] = $caracteristicas['id_categoria_muestreo'] ?? 'N/A';
                $nestedData['id_clase_muestreo'] = $caracteristicas['id_clase_muestreo'] ?? 'N/A';
                $nestedData['analisis_muestreo'] = $caracteristicas['analisis_muestreo'] ?? 'N/A';
                $nestedData['volumen_muestreo'] = $caracteristicas['volumen_muestreo'] ?? 'N/A';
                $nestedData['id_certificado_muestreo'] = $caracteristicas['id_certificado_muestreo'] ?? 'N/A';
                //case 4
                $idLoteGranelTraslado = $caracteristicas['id_lote_granel'] ?? null;
                if ($idLoteGranelTraslado) {
                    $loteGranel = LotesGranel::find($idLoteGranelTraslado); // Busca el lote a granel
                    $nestedData['id_lote_granel_traslado'] = $idLoteGranelTraslado;
                    $nestedData['nombre_lote_traslado'] = $loteGranel ? $loteGranel->nombre_lote : 'N/A';
                } else {
                    $nestedData['id_lote_granel_traslado'] = 'N/A';
                    $nestedData['nombre_lote_traslado'] = 'N/A';
                }
                $nestedData['id_categoria_traslado'] = $caracteristicas['id_categoria_traslado'] ?? 'N/A';
                $nestedData['id_clase_traslado'] = $caracteristicas['id_clase_traslado'] ?? 'N/A';
                $nestedData['id_tipo_maguey_traslado'] = $caracteristicas['id_tipo_maguey_traslado'] ?? 'N/A';
                $nestedData['id_vol_actual'] = $caracteristicas['id_vol_actual'] ?? 'N/A';
                $nestedData['id_vol_res'] = $caracteristicas['id_vol_res'] ?? 'N/A';
                $nestedData['analisis_traslado'] = $caracteristicas['analisis_traslado'] ?? 'N/A';
                //case 5
                $idLoteGranelInpeccion = $caracteristicas['id_lote_granel'] ?? null;
                if ($idLoteGranelInpeccion) {
                    $loteGranel = LotesGranel::find($idLoteGranelInpeccion); // Busca el lote a granel
                    $nestedData['id_lote_granel_inspeccion'] = $idLoteGranelInpeccion;
                    $nestedData['nombre_lote_inspeccion'] = $loteGranel ? $loteGranel->nombre_lote : 'N/A';
                } else {
                    $nestedData['id_lote_granel_inspeccion'] = 'N/A';
                    $nestedData['nombre_lote_inspeccion'] = 'N/A';
                }
                $nestedData['id_categoria_inspeccion'] = $caracteristicas['id_categoria_inspeccion'] ?? 'N/A';
                $nestedData['id_clase_inspeccion'] = $caracteristicas['id_clase_inspeccion'] ?? 'N/A';
                $nestedData['id_tipo_maguey_inspeccion'] = $caracteristicas['id_tipo_maguey_inspeccion'] ?? 'N/A';
                $nestedData['id_marca'] = $caracteristicas['id_marca'] ?? 'N/A';
                $nestedData['volumen_inspeccion'] = $caracteristicas['volumen_inspeccion'] ?? 'N/A';
                $nestedData['analisis_inspeccion'] = $caracteristicas['analisis_inspeccion'] ?? 'N/A';
                //case 7
                $idLoteGranelBarricada = $caracteristicas['id_lote_granel'] ?? null;
                if ($idLoteGranelBarricada) {
                    $loteGranel = LotesGranel::find($idLoteGranelBarricada); // Busca el lote a granel
                    $nestedData['id_lote_granel_barricada'] = $idLoteGranelBarricada;
                    $nestedData['nombre_lote_barricada'] = $loteGranel ? $loteGranel->nombre_lote : 'N/A';
                } else {
                    $nestedData['id_lote_granel_barricada'] = 'N/A';
                    $nestedData['nombre_lote_barricada'] = 'N/A';
                }
                $nestedData['id_categoria_barricada'] = $caracteristicas['id_categoria_barricada'] ?? 'N/A';
                $nestedData['id_clase_barricada'] = $caracteristicas['id_clase_barricada'] ?? 'N/A';
                $nestedData['id_tipo_maguey_barricada'] = $caracteristicas['id_tipo_maguey_barricada'] ?? 'N/A';
                $nestedData['analisis_barricada'] = $caracteristicas['analisis_barricada'] ?? 'N/A';
                $nestedData['tipo_lote'] = $caracteristicas['tipo_lote'] ?? 'N/A';
                $nestedData['fecha_inicio'] = isset($caracteristicas['fecha_inicio'])
                    ? Carbon::parse($caracteristicas['fecha_inicio'])->format('d/m/Y')
                    : 'N/A';
                $nestedData['fecha_termino'] = isset($caracteristicas['fecha_termino'])
                    ? Carbon::parse($caracteristicas['fecha_termino'])->format('d/m/Y')
                    : 'N/A';

                //case 9
                $idLoteGranelLiberacion = $caracteristicas['id_lote_granel'] ?? null;
                if ($idLoteGranelInpeccion) {
                    $loteGranel = LotesGranel::find($idLoteGranelLiberacion); // Busca el lote a granel
                    $nestedData['id_lote_granel_liberacion'] = $idLoteGranelLiberacion;
                    $nestedData['nombre_lote_liberacion'] = $loteGranel ? $loteGranel->nombre_lote : 'N/A';
                } else {
                    $nestedData['id_lote_granel_liberacion'] = 'N/A';
                    $nestedData['nombre_lote_liberacion'] = 'N/A';
                }
                $nestedData['id_categoria_liberacion'] = $caracteristicas['id_categoria_liberacion'] ?? 'N/A';
                $nestedData['id_clase_liberacion'] = $caracteristicas['id_clase_liberacion'] ?? 'N/A';
                $nestedData['id_tipo_maguey_liberacion'] = $caracteristicas['id_tipo_maguey_liberacion'] ?? 'N/A';
                $nestedData['analisis_liberacion'] = $caracteristicas['analisis_liberacion'] ?? 'N/A';
                $nestedData['tipo_lote_lib'] = $caracteristicas['tipo_lote_lib'] ?? 'N/A';
                $nestedData['fecha_inicio_lib'] = isset($caracteristicas['fecha_inicio_lib'])
                    ? Carbon::parse($caracteristicas['fecha_inicio_lib'])->format('d/m/Y')
                    : 'N/A';
                $nestedData['fecha_termino_lib'] = isset($caracteristicas['fecha_termino_lib'])
                    ? Carbon::parse($caracteristicas['fecha_inicio_lib'])->format('d/m/Y')
                    : 'N/A';
                //case 10
                $nestedData['punto_reunion'] = $caracteristicas['punto_reunion'] ?? 'N/A';
                //case 14
                $nestedData['clase'] = $caracteristicas['clase'] ?? 'N/A';
                $nestedData['categorias'] = $caracteristicas['categorias'] ?? 'N/A';
                $nestedData['renovacion'] = $caracteristicas['renovacion'] ?? 'N/A';


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

        if (!$solicitud) {
            return response()->json([
                'success' => false,
                'message' => 'Solicitud no encontrada.',
            ], 404);
        }

        // Obtener instalaciones relacionadas con la empresa de la solicitud
        $instalaciones = Instalaciones::where('id_empresa', $solicitud->id_empresa)->get();

        // Obtener las características decodificadas (si existen)
        $caracteristicas = $solicitud->caracteristicas
            ? json_decode($solicitud->caracteristicas, true)
            : null;

        return response()->json([
            'success' => true,
            'data' => $solicitud,
            'caracteristicas' => $caracteristicas,
            'instalaciones' => $instalaciones,
        ]);
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
            'id_tipo_maguey' => $request->id_tipo_maguey,
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
            'title' => 'Nuevo registro de solicitud Vigilancia en producción',
            'message' => $VigilanciaProdu->folio . " " . $VigilanciaProdu->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }
        return response()->json(['message' => 'Vigilancia en producción de lote registrada exitosamente']);
    }

    public function storeMuestreoLote(Request $request)
    {
        $MuestreoLote = new solicitudesModel();
        $MuestreoLote->folio = Helpers::generarFolioSolicitud();
        $MuestreoLote->id_empresa = $request->id_empresa;
        $MuestreoLote->id_tipo = 3;
        $MuestreoLote->id_predio = 0;
        $MuestreoLote->fecha_visita = $request->fecha_visita;
        $MuestreoLote->id_instalacion = $request->id_instalacion;
        $MuestreoLote->info_adicional = $request->info_adicional;


        $MuestreoLote->caracteristicas = json_encode([
            'id_lote_granel' => $request->id_lote_granel_muestreo,
            'tipo_analisis' => $request->tipo_analisis,
            'id_categoria_muestreo' => $request->id_categoria_muestreo,
            'id_clase_muestreo' => $request->id_clase_muestreo,
            'id_tipo_maguey_muestreo' => $request->id_tipo_maguey_muestreo,
            'analisis_muestreo' => $request->analisis_muestreo,
            'volumen_muestreo' => $request->volumen_muestreo,
            'id_certificado_muestreo' => $request->id_certificado_muestreo,

        ]);

        $MuestreoLote->save();

        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

        // Notificación 1
        $data1 = [
            'title' => 'Nuevo registro de solicitud Muestreo de lote',
            'message' => $MuestreoLote->folio . " " . $MuestreoLote->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }
        return response()->json(['message' => 'Muestreo de lote registrada exitosamente']);
    }


    public function storeVigilanciaTraslado(Request $request)
    {
        $VigilanciaTras = new solicitudesModel();
        $VigilanciaTras->folio = Helpers::generarFolioSolicitud();
        $VigilanciaTras->id_empresa = $request->id_empresa;
        $VigilanciaTras->id_tipo = 4;
        $VigilanciaTras->id_predio = 0;
        $VigilanciaTras->fecha_visita = $request->fecha_visita;
        $VigilanciaTras->id_instalacion = $request->id_instalacion;
        $VigilanciaTras->info_adicional = $request->info_adicional;


        $VigilanciaTras->caracteristicas = json_encode([
            'instalacion_vigilancia' => $request->instalacion_vigilancia,
            'id_lote_granel' => $request->id_lote_granel_traslado,
            'id_categoria_traslado' => $request->id_categoria_traslado,
            'id_clase_traslado' => $request->id_clase_traslado,
            'id_tipo_maguey_traslado' => $request->id_tipo_maguey_traslado,
            'id_salida' => $request->id_salida,
            'id_contenedor' => $request->id_contenedor,
            'id_sobrante' => $request->id_sobrante,
            'id_vol_actual' => $request->id_vol_actual,
            'id_vol_traslado' => $request->id_vol_traslado,
            'id_vol_res' => $request->id_vol_res,
            'analisis_traslado' => $request->analisis_traslado,
            'volumen_traslado' => $request->volumen_traslado,
            'id_certificado_traslado' => $request->id_certificado_traslado,


        ]);

        $VigilanciaTras->save();

        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

        // Notificación 1
        $data1 = [
            'title' => 'Nuevo registro de solicitud Vigilancia en traslado',
            'message' => $VigilanciaTras->folio . " " . $VigilanciaTras->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }
        return response()->json(['message' => 'Vigilancia en traslado de lote registrada exitosamente']);
    }

    public function storeInspeccionEnvasado(Request $request)
    {
        $InspeccionEnva = new solicitudesModel();
        $InspeccionEnva->folio = Helpers::generarFolioSolicitud();
        $InspeccionEnva->id_empresa = $request->id_empresa;
        $InspeccionEnva->id_tipo = 5;
        $InspeccionEnva->id_predio = 0;
        $InspeccionEnva->fecha_visita = $request->fecha_visita;
        $InspeccionEnva->id_instalacion = $request->id_instalacion;
        $InspeccionEnva->info_adicional = $request->info_adicional;

        $InspeccionEnva->caracteristicas = json_encode([
            'id_lote_granel' => $request->id_lote_granel_inspeccion,
            'id_categoria_inspeccion' => $request->id_categoria_inspeccion,
            'id_clase_inspeccion' => $request->id_clase_inspeccion,
            'id_tipo_maguey_inspeccion' => $request->id_tipo_maguey_inspeccion,
            'id_marca' => $request->id_marca,
            'volumen_inspeccion' => $request->volumen_inspeccion,
            'analisis_inspeccion' => $request->analisis_inspeccion,
            'id_tipo_inspeccion' => $request->id_tipo_inspeccion,
            'id_cantidad_bote' => $request->id_cantidad_bote,
            'id_cantidad_caja' => $request->id_cantidad_caja,
            'id_inicio_envasado' => $request->id_inicio_envasado,
            'id_previsto' => $request->id_previsto,
            'id_certificado_inspeccion' => $request->id_certificado_inspeccion,
        ]);

        $InspeccionEnva->save();

        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

        // Notificación 1
        $data1 = [
            'title' => 'Nuevo registro de solicitud Inpeccion de envasado',
            'message' => $InspeccionEnva->folio . " " . $InspeccionEnva->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }
        return response()->json(['message' => 'Inpeccion de envasado de lote registrada exitosamente']);
    }

    public function storeInspeccionBarricada(Request $request)
    {
        $InspeccionBarri = new solicitudesModel();
        $InspeccionBarri->folio = Helpers::generarFolioSolicitud();
        $InspeccionBarri->id_empresa = $request->id_empresa;
        $InspeccionBarri->id_tipo = 7;
        $InspeccionBarri->id_predio = 0;
        $InspeccionBarri->fecha_visita = $request->fecha_visita;
        $InspeccionBarri->id_instalacion = $request->id_instalacion;
        $InspeccionBarri->info_adicional = $request->info_adicional;

        $InspeccionBarri->caracteristicas = json_encode([
            'id_lote_granel' => $request->id_lote_granel_barricada,
            'id_categoria_barricada' => $request->id_categoria_barricada,
            'id_clase_barricada' => $request->id_clase_barricada,
            'id_tipo_maguey_barricada' => $request->id_tipo_maguey_barricada,
            'id_edad' => $request->id_edad,
            'analisis_barricada' => $request->analisis_barricada,
            'volumen_barricada' => $request->volumen_barricada,
            'tipo_lote' => $request->tipo_lote,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_termino' => $request->fecha_termino,
            'material' => $request->material,
            'capacidad' => $request->capacidad,
            'num_recipientes' => $request->num_recipientes,
            'tiempo_dura' => $request->tiempo_dura,
            'id_certificado_barricada' => $request->id_certificado_barricada,
        ]);

        $InspeccionBarri->save();

        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

        // Notificación 1
        $data1 = [
            'title' => 'Nuevo registro de solicitud Inspeccion ingreso a barricada',
            'message' => $InspeccionBarri->folio . " " . $InspeccionBarri->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }
        return response()->json(['message' => 'Inspeccion ingreso a barricada de lote registrada exitosamente']);
    }

    public function storeInspeccionBarricadaLiberacion(Request $request)
    {
        $BarricadaLib = new solicitudesModel();
        $BarricadaLib->folio = Helpers::generarFolioSolicitud();
        $BarricadaLib->id_empresa = $request->id_empresa;
        $BarricadaLib->id_tipo = 9;
        $BarricadaLib->id_predio = 0;
        $BarricadaLib->fecha_visita = $request->fecha_visita;
        $BarricadaLib->id_instalacion = $request->id_instalacion;
        $BarricadaLib->info_adicional = $request->info_adicional;

        $BarricadaLib->caracteristicas = json_encode([
            'id_lote_granel' => $request->id_lote_granel_liberacion,
            'id_categoria_liberacion' => $request->id_categoria_liberacion,
            'id_clase_liberacion' => $request->id_clase_liberacion,
            'id_tipo_maguey_liberacion' => $request->id_tipo_maguey_liberacion,
            'id_edad_liberacion' => $request->id_edad_liberacion,
            'analisis_liberacion' => $request->analisis_liberacion,
            'volumen_liberacion' => $request->volumen_liberacion,
            'tipo_lote_lib' => $request->tipo_lote_lib,
            'fecha_inicio_lib' => $request->fecha_inicio_lib,
            'fecha_termino_lib' => $request->fecha_termino_lib,
            'material_liberacion' => $request->material_liberacion,
            'capacidad_liberacion' => $request->capacidad_liberacion,
            'num_recipientes_lib' => $request->num_recipientes_lib,
            'tiempo_dura_lib' => $request->tiempo_dura_lib,
            'id_certificado_liberacion' => $request->id_certificado_liberacion,
        ]);

        $BarricadaLib->save();

        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

        // Notificación 1
        $data1 = [
            'title' => 'Nuevo registro de solicitud Inspeccion liberacion a barricada',
            'message' => $BarricadaLib->folio . " " . $BarricadaLib->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }
        return response()->json(['message' => 'Inspeccion liberacion a barricada de lote registrada exitosamente']);
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

    public function registrarSolicitudMuestreoAgave(Request $request)
    {

        $solicitud = new solicitudesModel();
        $solicitud->folio = Helpers::generarFolioSolicitud();
        $solicitud->id_empresa = $request->id_empresa;
        $solicitud->id_tipo = 1;
        $solicitud->fecha_visita = $request->fecha_visita;
        $solicitud->id_instalacion = $request->id_instalacion ? $request->id_instalacion : 0;
        $solicitud->info_adicional = $request->info_adicional;
        // Preparar el JSON para la columna `caracteristicas`

        if(!empty($request->id_guia)){
            $caracteristicas = [
                'id_guia' => $request->id_guia,
            ];

                    // Convertir a JSON y asignarlo
            $solicitud->caracteristicas = json_encode($caracteristicas);
        }
        



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

    public function store(Request $request)
    {
        $solicitud = new solicitudesModel();
        $solicitud->folio = Helpers::generarFolioSolicitud();
        $solicitud->id_empresa = $request->id_empresa;
        $solicitud->id_tipo = 14;
        $solicitud->fecha_visita = $request->fecha_visita;
        //Auth::user()->id;
        $solicitud->id_instalacion = $request->id_instalacion;
        $solicitud->info_adicional = $request->info_adicional;
        // Guardar el nuevo registro en la base de datos

        // Verificar si los campos tienen valores
        $clases = $request->input('clases', []);
        $categorias = $request->input('categorias', []);
        $renovacion = $request->input('renovacion', null);

        if (!empty($clases) || !empty($categorias) || $renovacion !== null) {
            $caracteristicas = [
                'clases' => $clases,
                'categorias' => $categorias,
                'renovacion' => $renovacion,
            ];
            // Convertir el array a JSON y guardarlo en la columna 'caracteristicas'
            $solicitud->caracteristicas = json_encode($caracteristicas);
        }

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
            ->setPaper([0, 0, 640, 910]);;
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
                    'info_adicional' => 'nullable|string'
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

            case 'muestreoloteagranel':
                // Validar datos para georreferenciación
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string'
                ]);
                // Preparar el JSON para guardar en `caracteristicas`
                $caracteristicasJson = [
                    'id_lote_granel_muestreo' => $request->id_lote_granel_muestreo,
                    'destino_lote' => $request->destino_lote,
                    'id_categoria_muestreo' => $request->id_categoria_muestreo,
                    'id_clase_muestreo' => $request->id_clase_muestreo,
                    'id_tipo_maguey_muestreo' => $request->id_tipo_maguey_muestreo,
                    'analisis_muestreo' => $request->analisis_muestreo,
                    'volumen_muestreo' => $request->volumen_muestreo,
                    'id_certificado_muestreo' => $request->id_certificado_muestreo,
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

            case 'vigilanciatraslado':
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string'
                ]);
                $caracteristicasJson = [
                    'instalacion_vigilancia' => $request->instalacion_vigilancia,
                    'id_lote_granel' => $request->id_lote_granel_traslado,
                    'id_categoria_traslado' => $request->id_categoria_traslado,
                    'id_clase_traslado' => $request->id_clase_traslado,
                    'id_tipo_maguey_traslado' => $request->id_tipo_maguey_traslado,
                    'id_salida' => $request->id_salida,
                    'id_contenedor' => $request->id_contenedor,
                    'id_sobrante' => $request->id_sobrante,
                    'id_vol_actual' => $request->id_vol_actual,
                    'id_vol_traslado' => $request->id_vol_traslado,
                    'id_vol_res' => $request->id_vol_res,
                    'analisis_traslado' => $request->analisis_traslado,
                    'volumen_traslado' => $request->volumen_traslado,
                    'id_certificado_traslado' => $request->id_certificado_traslado,

                ];
                $jsonContent = json_encode($caracteristicasJson);
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);
                break;

                case 'inspeccionenvasado':
                    $request->validate([
                        'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                        'fecha_visita' => 'required|date',
                        'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                        'info_adicional' => 'nullable|string'
                    ]);
                    $caracteristicasJson = [
                        'id_lote_granel_inspeccion' => $request->id_lote_granel_inspeccion,
                        'id_categoria_inspeccion' => $request->id_categoria_inspeccion,
                        'id_clase_inspeccion' => $request->id_clase_inspeccion,
                        'id_tipo_maguey_inspeccion' => $request->id_tipo_maguey_inspeccion,
                        'id_marca' => $request->id_marca,
                        'volumen_inspeccion' => $request->volumen_inspeccion,
                        'analisis_inspeccion' => $request->analisis_inspeccion,
                        'id_tipo_inspeccion' => $request->id_tipo_inspeccion,
                        'id_cantidad_bote' => $request->id_cantidad_bote,
                        'id_cantidad_caja' => $request->id_cantidad_caja,
                        'id_inicio_envasado' => $request->id_inicio_envasado,
                        'id_previsto' => $request->id_previsto,
                        'id_certificado_inspeccion' => $request->id_certificado_inspeccion,
    
                    ];
                    $jsonContent = json_encode($caracteristicasJson);
                    $solicitud->update([
                        'id_empresa' => $request->id_empresa,
                        'fecha_visita' => $request->fecha_visita,
                        'id_instalacion' => $request->id_instalacion,
                        'info_adicional' => $request->info_adicional,
                        'caracteristicas' => $jsonContent,
                    ]);
                    break;

            case 'muestreobarricada':
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string'
                ]);
                $caracteristicasJson = [
                    'id_lote_granel_barricada' => $request->id_lote_granel_barricada,
                    'id_categoria_barricada' => $request->id_categoria_barricada,
                    'id_clase_barricada' => $request->id_clase_barricada,
                    'id_tipo_maguey_barricada' => $request->id_tipo_maguey_barricada,
                    'id_edad' => $request->id_edad,
                    'analisis_barricada' => $request->analisis_barricada,
                    'volumen_barricada' => $request->volumen_barricada,
                    'tipo_lote' => $request->tipo_lote,
                    'fecha_inicio' => $request->fecha_inicio,
                    'fecha_termino' => $request->fecha_termino,
                    'material' => $request->material,
                    'capacidad' => $request->capacidad,
                    'num_recipientes' => $request->num_recipientes,
                    'tiempo_dura' => $request->tiempo_dura,
                    'id_certificado_barricada' => $request->id_certificado_barricada,
                ];
                $jsonContent = json_encode($caracteristicasJson);
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);
                break;

            case 'muestreobarricadaliberacion':
                $request->validate([
                    'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                    'fecha_visita' => 'required|date',
                    'id_instalacion' => 'required|integer|exists:instalaciones,id_instalacion',
                    'info_adicional' => 'nullable|string'
                ]);
                $caracteristicasJson = [
                    'id_lote_granel_liberacion' => $request->id_lote_granel_liberacion,
                    'id_categoria_liberacion' => $request->id_categoria_liberacion,
                    'id_clase_liberacion' => $request->id_clase_liberacion,
                    'id_tipo_maguey_liberacion' => $request->id_tipo_maguey_liberacion,
                    'id_edad_liberacion' => $request->id_edad_liberacion,
                    'analisis_liberacion' => $request->analisis_liberacion,
                    'volumen_liberacion' => $request->volumen_liberacion,
                    'tipo_lote_lib' => $request->tipo_lote_lib,
                    'fecha_inicio_lib' => $request->fecha_inicio_lib,
                    'fecha_termino_lib' => $request->fecha_termino_lib,
                    'material_liberacion' => $request->material_liberacion,
                    'capacidad_liberacion' => $request->capacidad_liberacion,
                    'num_recipientes_lib' => $request->num_recipientes_lib,
                    'tiempo_dura_lib' => $request->tiempo_dura_lib,
                    'id_certificado_liberacion' => $request->id_certificado_liberacion,
                ];
                $jsonContent = json_encode($caracteristicasJson);
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
                    'info_adicional' => 'nullable|string'
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
                    'info_adicional' => 'nullable|string|max:5000',
                ]);
                // Preparar el JSON para guardar en `caracteristicas`
                $caracteristicasJson = [
                    'clases' => $request->clases,
                    'categorias' => $request->categorias,
                    'renovacion' => $request->renovacion,
                ];

                // Convertir el array a JSON
                $jsonContent = json_encode($caracteristicasJson);
                // Actualizar datos específicos para dictaminación
                $solicitud->update([
                    'id_empresa' => $request->id_empresa,
                    'fecha_visita' => $request->fecha_visita,
                    'id_instalacion' => $request->id_instalacion,
                    'info_adicional' => $request->info_adicional,
                    'caracteristicas' => $jsonContent,
                ]);
                break;

            default:
                return response()->json(['success' => false, 'message' => 'Tipo de solicitud no reconocido'], 400);
        }

        return response()->json(['success' => true, 'message' => 'Solicitud actualizada correctamente']);
    }

    public function obtenerMarcasPorEmpresa($id_marca, $id_direccion)
    {
        
        $marcas = marcas::with('empresa.empresaNumClientes','documentacion_url')->whereJsonContains('etiquetado->id_direccion', $id_direccion)
        ->where('id_marca', $id_marca)
        ->get();

        foreach ($marcas as $marca) {
            // Decodificar el campo 'etiquetado'
            $etiquetado = is_string($marca->etiquetado) ? json_decode($marca->etiquetado, true) : $marca->etiquetado;

            // Si el campo etiquetado no es válido o no puede ser decodificado
            if (is_null($etiquetado) || !is_array($etiquetado)) {
                $marca->tipo_nombre = [];
                $marca->clase_nombre = [];
                $marca->categoria_nombre = [];
                $marca->direccion_nombre = [];
                $marca->etiquetado = [];
                continue;
            }

            // Verificar la existencia de claves antes de procesar las relaciones
            $tipos = isset($etiquetado['id_tipo']) ? tipos::whereIn('id_tipo', $etiquetado['id_tipo'])->pluck('nombre')->toArray() : [];
            $clases = isset($etiquetado['id_clase']) ? clases::whereIn('id_clase', $etiquetado['id_clase'])->pluck('clase')->toArray() : [];
            $categorias = isset($etiquetado['id_categoria']) ? categorias::whereIn('id_categoria', $etiquetado['id_categoria'])->pluck('categoria')->toArray() : [];

            // Procesar direcciones individualmente
            $direcciones = [];
            if (isset($etiquetado['id_direccion']) && is_array($etiquetado['id_direccion'])) {
                foreach ($etiquetado['id_direccion'] as $id_direccion) {
                    $direccion = Destinos::where('id_direccion', $id_direccion)->value('direccion');
                    $direcciones[] = $direccion ?? 'N/A'; // Si no se encuentra, asignar 'N/A'
                }
            }

            // Agregar los datos procesados al resultado
            $marca->tipo_nombre = $tipos;
            $marca->clase_nombre = $clases;
            $marca->categoria_nombre = $categorias;
            $marca->direccion_nombre = $direcciones;
            $marca->etiquetado = $etiquetado; // Incluye el JSON decodificado para referencia
        }

        // Retornar las marcas como respuesta JSON
        return response()->json($marcas);
    }

    public function storePedidoExportacion(Request $request)
    {
        // Validación de datos del formulario
        $validated = $request->validate([
            'id_empresa' => 'required|integer',
            'fecha_visita' => 'required|date',
            'id_instalacion' => 'required|integer',
            'direccion_destinatario' => 'required|integer',
            'aduana_salida' => 'required|string|max:255',
            'no_pedido' => 'required|string|max:255',
            'info_adicional' => 'nullable|string|max:500',
            'factura_proforma' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'factura_proforma_cont' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            /*  */
            'lote_envasado' => 'array',  // Asegurarse de que los lotes sean arrays
            'cantidad_botellas' => 'array',  // Asegurarse de que las cantidades sean arrays
            'cantidad_cajas' => 'array',  // Asegurarse de que las cantidades sean arrays
            'presentacion' => 'array',  // Asegurarse de que las presentaciones sean arrays
        ]);

        // Procesar características
        $data = json_decode($request->input('caracteristicas'), true);

        // Incluir los demás campos dentro del JSON de 'caracteristicas'
        $data['tipo_solicitud'] = $validated['tipo_solicitud'] ?? $data['tipo_solicitud'];  // Solo si es enviado
        $data['no_pedido'] = $validated['no_pedido'];  // Solo si es enviado
        $data['aduana_salida'] = $validated['aduana_salida'];  // Solo si es enviado
        $data['direccion_destinatario'] = $validated['direccion_destinatario'];  // Solo si es enviado
        // Preparar los detalles
        $detalles = [];
        $totalLotes = count($validated['lote_envasado']);  // Suponiendo que todos los arrays tienen el mismo tamaño

        for ($i = 0; $i < $totalLotes; $i++) {
            // Crear el detalle para cada conjunto de datos de lote
            $detalles[] = [
                'id_lote_envasado' => (int)$validated['lote_envasado'][$i],
                //'lote_granel' => (int)$validated['lote_granel'][$i],
                'cantidad_botellas' => (int)$validated['cantidad_botellas'][$i],
                'cantidad_cajas' => (int)$validated['cantidad_cajas'][$i],
                'presentacion' => (int)$validated['presentacion'][$i],
            ];
        }

        // Incluir los detalles dentro de las características
        $data['detalles'] = $detalles;

        // Guardar la solicitud
        $pedido = new solicitudesModel();
        $pedido->folio = Helpers::generarFolioSolicitud();
        $pedido->id_empresa = $validated['id_empresa'];
        $pedido->fecha_visita = $validated['fecha_visita'];
        $pedido->id_tipo = 11;
        $pedido->id_instalacion = $validated['id_instalacion'];
        $pedido->info_adicional = $validated['info_adicional'];
        $pedido->caracteristicas = json_encode($data);  // Guardar el JSON completo con las características (incluyendo facturas)
        $pedido->save();

        // Obtener el número del cliente desde la tabla empresa_num_cliente
        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $validated['id_empresa'])->first();
        $empresaNumCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        // Almacenar archivos si se enviaron
        if ($request->hasFile('factura_proforma')) {
            $file = $request->file('factura_proforma');
            $uniqueId = uniqid();
            $filename = 'FacturaProforma_' . $uniqueId . '.' . $file->getClientOriginalExtension();
            $directory = $empresaNumCliente;
            $path = storage_path('app/public/uploads/' . $directory);

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $filePath = $file->storeAs($directory, $filename, 'public_uploads');
            Documentacion_url::create([
                'id_empresa' => $validated['id_empresa'],
                'url' => basename($filePath),
                'id_relacion' => $pedido->id_solicitud,
                'id_documento' => 55, // ID de factura
                'nombre_documento' => 'Factura Proforma',
            ]);
        }

        if ($request->hasFile('factura_proforma_cont')) {
            $file = $request->file('factura_proforma_cont');
            $uniqueId = uniqid();
            $filename = 'FacturaProformaCont_' . $uniqueId . '.' . $file->getClientOriginalExtension();
            $directory = $empresaNumCliente;
            $path = storage_path('app/public/uploads/' . $directory);

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $filePath = $file->storeAs($directory, $filename, 'public_uploads');
            Documentacion_url::create([
                'id_empresa' => $validated['id_empresa'],
                'url' => basename($filePath),
                'id_relacion' => $pedido->id_solicitud,
                'id_documento' => 55, // ID de factura
                'nombre_documento' => 'Factura Proforma (Continuación)',
            ]);
        }


        // Obtener varios usuarios (por ejemplo, todos los usuarios con cierto rol o todos los administradores)
        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

        // Notificación 1
        $data1 = [
            'title' => 'Nuevo registro de solicitud',
            'message' => $pedido->folio . " " . $pedido->tipo_solicitud->tipo,
            'url' => 'solicitudes-historial',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }

        return response()->json(['success' => true, 'message' => 'Pedido registrado.']);
    }

    public function getDetalleLoteEnvasado($id_lote_envasado)
    {
        $lote = lotes_envasado::find($id_lote_envasado);
        if (!$lote) {
            return response()->json(['error' => 'Lote no encontrado'], 404);
        }
        // Usando la relación 'lotesGranel' para obtener los lotes a granel asociados
        $lotesGranel = $lote->lotesGranel; // Esto devuelve los lotes a granel asociados
        // Si no hay lotes a granel asociados, puedes devolver un mensaje o array vacío
        if ($lotesGranel->isEmpty()) {
            return response()->json(['detalle' => null], 200);
        }
        // Si hay lotes a granel, devolverlos en el formato adecuado
        return response()->json([
            'detalle' => $lotesGranel->pluck('nombre_lote') // Puedes cambiar 'nombre_lote' por cualquier campo relevante de LotesGranel
        ]);
    }


    public function getDetalleLoteTipo($id_lote_granel)
    {
        $lote = LotesGranel::find($id_lote_granel);
        if (!$lote) {
            return response()->json(['error' => 'Lote no encontrado'], 404);
        }
        // Usando la relación 'lotesGranel' para obtener los lotes a granel asociados
        $lotesGranel = $lote->lotesGranel; // Esto devuelve los lotes a granel asociados
        // Si no hay lotes a granel asociados, puedes devolver un mensaje o array vacío
        if ($lotesGranel->isEmpty()) {
            return response()->json(['detalle' => null], 200);
        }
        // Si hay lotes a granel, devolverlos en el formato adecuado
        return response()->json([
            'detalle' => $lotesGranel->pluck('nombre_lote') // Puedes cambiar 'nombre_lote' por cualquier campo relevante de LotesGranel
        ]);
    }
}
