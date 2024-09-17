<?php

namespace App\Http\Controllers\inspecciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Documentacion_url;
use App\Models\Instalaciones;
use App\Models\empresa;
use App\Models\estados;
use App\Models\actas_inspeccion;
use App\Models\actas_testigo;
use App\Models\Organismos;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helpers;
use App\Models\inspecciones;
use App\Models\solicitudesModel;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Barryvdh\DomPDF\Facade\Pdf;

class inspeccionesController extends Controller
{
    public function UserManagement()
    {
        $instalaciones = Instalaciones::all(); // Obtener todas las instalaciones
        $empresas = empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $estados = estados::all(); // Obtener todos los estados

        $inspectores = User::where('tipo', '=', '2')->get(); // Obtener todos los organismos
        return view('inspecciones.find_inspecciones_view', compact('instalaciones', 'empresas', 'estados', 'inspectores'));
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
            11 => 'name',
            12 => 'id_inspeccion',
        ];

        $search = [];

        $totalData = solicitudesModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        if (empty($request->input('search.value'))) {


            $solicitudes = solicitudesModel::with('tipo_solicitud', 'empresa', 'inspeccion', 'inspector', 'instalacion')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $query = solicitudesModel::with('empresa');
            dd($query->toSql());


            $solicitudes = solicitudesModel::with('tipo_solicitud', 'empresa', 'inspeccion', 'inspector', 'instalacion')
                ->where(function ($query) use ($search) {
                    $query->where('id_solicitud', 'LIKE', "%{$search}%")
                        ->orWhere('razon_social', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered =  solicitudesModel::with('tipo_solicitud', 'empresa', 'inspeccion', 'inspector', 'instalacion')
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
                $nestedData['id_inspeccion'] = $solicitud->inspeccion->id_inspeccion ?? '0';
                $nestedData['id_solicitud'] = $solicitud->id_solicitud ?? 'N/A';
                $nestedData['fake_id'] = ++$ids  ?? 'N/A';
                $nestedData['folio'] = '<b class="text-primary">' . $solicitud->folio . '</b>';
                $nestedData['num_servicio'] = $solicitud->inspeccion->num_servicio ?? '<span class="badge bg-danger">Sin asignar</apan>';
                $nestedData['razon_social'] = $solicitud->empresa->razon_social  ?? 'N/A';
                $nestedData['fecha_solicitud'] = Helpers::formatearFechaHora($solicitud->fecha_solicitud)  ?? 'N/A';
                $nestedData['tipo'] = $solicitud->tipo_solicitud->tipo  ?? 'N/A';
                $nestedData['direccion_completa'] = $solicitud->instalacion->direccion_completa  ?? 'N/A';
                $nestedData['fecha_visita'] = Helpers::formatearFechaHora($solicitud->fecha_visita)  ?? '<span class="badge bg-danger">Sin asignar</span>';
                $nestedData['inspector'] = $solicitud->inspector->name ?? '<span class="badge bg-danger">Sin asignar</span>'; // Maneja el caso donde el organismo sea nulo
                $nestedData['fecha_servicio'] = Helpers::formatearFecha(optional($solicitud->inspeccion)->fecha_servicio) ?? '<span class="badge bg-danger">Sin asignar</span>';



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

    public function destroy($id_instalacion)
    {
        try {
            $instalacion = Instalaciones::findOrFail($id_instalacion);
            $instalacion->delete();

            return response()->json(['success' => 'Instalación eliminada correctamente']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Instalación no encontrada'], 404);
        }
    }


    public function edit($id_instalacion)
    {
        try {
            // Obtener la instalación y sus documentos asociados
            $instalacion = Instalaciones::findOrFail($id_instalacion);

            // Obtener los documentos asociados
            $documentacion_urls = Documentacion_url::where('id_relacion', $id_instalacion)->get();

            // Extraer la URL del primer documento, si existe
            $archivo_url = $documentacion_urls->isNotEmpty() ? $documentacion_urls->first()->url : '';

            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $instalacion->id_empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

            return response()->json([
                'success' => true,
                'instalacion' => $instalacion,
                'archivo_url' => $archivo_url, // Incluir la URL del archivo
                'numeroCliente' => $numeroCliente
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false], 404);
        }
    }

    public function asignarInspector(Request $request)
    {

        // Asignar o actualizar la inspección
        $asignar = inspecciones::updateOrCreate(
            [
                'id_solicitud' => $request->id_solicitud,
            ],
            [
                'id_inspector' => $request->id_inspector,
                'num_servicio' => $request->num_servicio,
                'fecha_servicio' => $request->fecha_servicio,
                'estatus_inspeccion' => 1, // Es pendiente
                'observaciones' => $request->observaciones ?? '',
            ]
        );
    }



    //Pdfs de inspecciones

    public function pdf_oficio_comision($id_inspeccion)
    {

        $datos = inspecciones::with(['inspector', 'solicitud.instalacion', 'solicitud.tipo_solicitud'])->find($id_inspeccion);

        $fecha_servicio = Helpers::formatearFecha($datos->fecha_servicio);
        $pdf = Pdf::loadView('pdfs.oficioDeComision', ['datos' => $datos, 'fecha_servicio' => $fecha_servicio]);
        return $pdf->stream('F-UV-02-09 Oficio de Comisión Ed.5, Vigente.pdf');
    }

    public function pdf_orden_servicio($id_inspeccion)
    {
        $datos = inspecciones::with(['inspector', 'solicitud.instalacion', 'solicitud.empresa.empresaNumClientes'])->find($id_inspeccion);

        $fecha_servicio = Helpers::formatearFecha($datos->fecha_servicio);
        $pdf = Pdf::loadView('pdfs.ordenDeServicio', ['datos' => $datos, 'fecha_servicio' => $fecha_servicio]);
        return $pdf->stream('F-UV-02-01 Orden de servicio Ed. 5, Vigente.pdf');
    }


    public function agregarResultados(Request $request)
    {

        $sol = solicitudesModel::find($request->id_solicitud);
        $numeroCliente = $sol->empresa->empresaNumClientes->pluck('numero_cliente')->first();
        $mensaje = "";
        // Almacenar nuevos documentos solo si se envían
        if ($request->hasFile('url')) {
            foreach ($request->file('url') as $index => $file) {
                $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

                $documentacion_url = new Documentacion_url();
                $documentacion_url->id_relacion = $request->id_solicitud;
                $documentacion_url->id_documento = $request->id_documento[$index];
                $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                $documentacion_url->id_empresa = $sol->id_empresa;
                $documentacion_url->fecha_vigencia = $request->fecha_vigencia[$index] ?? null; // Usa null si no hay fecha
                $documentacion_url->save();

                $mensaje = $request->nombre_documento[$index] . ", " . $mensaje;
            }
        }

        // Obtener varios usuarios (por ejemplo, todos los usuarios con cierto rol o todos los administradores)
        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

        // Notificación 1
        $data1 = [
            'title' => 'Adjuntó resultados de inspección',
            'message' => $mensaje,
            'url' => 'inspecciones',
        ];

        // Iterar sobre cada usuario y enviar la notificación
        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }
    }


    //agregar inspeccionespdf
    // Método para insertar el formulario de Acta de Inspección
    public function store(Request $request)
    {
        
        try {

            // Crear un nuevo registro en la tabla `actas_inspeccion`
            $acta = new actas_inspeccion();
            $acta->id_inspeccion = $request->id_inspeccion;
            $acta->id_empresa = $request->acta_id_empresa;
            $acta->num_acta = $request->num_acta;
            $acta->categoria_acta = $request->categoria_acta;
            $acta->testigos = $request->testigos;
            $acta->encargado = $request->encargado;
            $acta->num_credencial_encargado = $request->num_credencial_encargado;
            $acta->lugar_inspeccion = $request->lugar_inspeccion;
            $acta->fecha_inicio = $request->fecha_inicio;
            $acta->fecha_fin = $request->fecha_fin;
            $acta->no_conf_infraestructura = $request->no_conf_infraestructura;
            $acta->no_conf_equipo = $request->no_conf_equipo;

            // Guardar el registro en la base de datos
            $acta->save();


            for ($i = 0; $i < count($request->nombre_testigo); $i++) {
                $testigo = new actas_testigo();
                $testigo->id_acta = $acta->id;  // Relacionar con la acta creada
                $testigo->nombre_testigo = $request->nombre_testigo[$i];
                $testigo->domicilio = $request->domicilio[$i];
                $testigo->save();
            }
            return response()->json(['success' => 'Lote registrado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
