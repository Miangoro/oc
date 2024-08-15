<?php

namespace App\Http\Controllers\inspecciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Documentacion_url;
use App\Models\Instalaciones;
use App\Models\Empresa;
use App\Models\Estados;
use App\Models\Organismos;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helpers;
use App\Models\solicitudesModel;

class inspeccionesController extends Controller
{
    public function UserManagement()
    {
        $instalaciones = Instalaciones::all(); // Obtener todas las instalaciones
        $empresas = Empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $estados = Estados::all(); // Obtener todos los estados
        $organismos = Organismos::all(); // Obtener todos los organismos
        return view('inspecciones.find_inspecciones_view', compact('instalaciones', 'empresas', 'estados', 'organismos'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_solicitud',
            2 => 'folio',
            3 => 'razon_social',
            4 => 'fecha_solicitud',
            5 => 'num_servicio',
            6 => 'tipo',
            7 => 'inspector',
            8 => 'fecha_servicio',
            9 => 'fecha_visita',
            10 => 'name',
        ];

        $search = [];

        $totalData = solicitudesModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

       

        if (empty($request->input('search.value'))) {
           

                $solicitudes = solicitudesModel::with('empresa','inspeccion','inspector')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

        } else {
            $search = $request->input('search.value');

            $query = solicitudesModel::with('empresa');
            dd($query->toSql());
            

            $solicitudes = solicitudesModel::with('empresa','inspeccion','inspector')
                ->where(function ($query) use ($search) {
                    $query->where('id_solicitud', 'LIKE', "%{$search}%")
                        ->orWhere('razon_social', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered =  solicitudesModel::with('empresa','inspeccion','inspector')
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
                $nestedData['folio'] = $solicitud->folio  ?? 'N/A';
                $nestedData['razon_social'] = $solicitud->empresa->razon_social  ?? 'N/A';
                $nestedData['fecha_solicitud'] = Helpers::formatearFechaHora($solicitud->fecha_solicitud)  ?? 'N/A';
                $nestedData['num_servicio'] = $solicitud->inspeccion->num_servicio ?? 'Sin asignar';
                $nestedData['tipo'] = $solicitud->tipo  ?? 'N/A';
                $nestedData['fecha_visita'] = Helpers::formatearFechaHora($solicitud->fecha_visita)  ?? 'Sin asignar';
                $nestedData['inspector'] = $solicitud->inspector->name ?? 'Sin asignar'; // Maneja el caso donde el organismo sea nulo
                $nestedData['fecha_servicio'] = Helpers::formatearFecha(optional($solicitud->inspeccion)->fecha_servicio) ?? 'Sin asignar';
                //$nestedData['url'] = !empty($instalacion->documentos->pluck('url')->toArray()) ? $instalacion->empresa->empresaNumClientes->pluck('numero_cliente')->first().'/'.implode(',', $instalacion->documentos->pluck('url')->toArray()) : '';
                //$nestedData['fecha_emision'] = Helpers::formatearFecha($instalacion->fecha_emision);
                //$nestedData['fecha_vigencia'] = Helpers::formatearFecha($instalacion->fecha_vigencia);
                $nestedData['actions'] = '<button class="btn btn-danger btn-sm delete-record" data-id="' . $solicitud->id_solicitud . '">Eliminar</button>';

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

    public function store(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'tipo' => 'required|string',
            'estado' => 'required|exists:estados,id',
            'direccion_completa' => 'required|string',
            'folio' => 'nullable|string', // Opcional
            'id_organismo' => 'nullable|exists:catalogo_organismos,id_organismo', // Opcional
            'fecha_emision' => 'nullable|date', // Opcional
            'fecha_vigencia' => 'nullable|date', // Opcional
            'url.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf', // Validación de archivos
            'nombre_documento.*' => 'required_with:url.*|string', // Validación de nombres de documentos
            'id_documento.*' => 'required_with:url.*|integer', // Validación de IDs de documentos

        ]);

        try {
            // Crear nueva instalación
            Instalaciones::create([
                'id_empresa' => $request->input('id_empresa'),
                'tipo' => $request->input('tipo'),
                'estado' => $request->input('estado'),
                'direccion_completa' => $request->input('direccion_completa'),
                'folio' => $request->input('folio', null), // Opcional
                'id_organismo' => $request->input('id_organismo', null), // Opcional
                'fecha_emision' => $request->input('fecha_emision', null), // Opcional
                'fecha_vigencia' => $request->input('fecha_vigencia', null), // Opcional
            ]);

            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->input('id_empresa'))->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

            $aux = $request->hasFile('url');

            $ultimaInstalacion = Instalaciones::latest()->first();

            // Almacenar nuevos documentos solo si se envían
            if ($request->hasFile('url')) {

                foreach ($request->file('url') as $index => $file) {

                    $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public'); //Aqui se guarda en la ruta definida storage/public

                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $ultimaInstalacion->id_instalacion;
                    $documentacion_url->id_documento = $request->id_documento[$index];
                    $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                    $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                    $documentacion_url->id_empresa =  $request->input('id_empresa');

                    $documentacion_url->save();
                }
            }
            return response()->json(['code' => 200, 'message' => 'Instalación registrada correctamente.', 'aux' => $aux]);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error al registrar la instalación.']);
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


    public function update(Request $request, $id)
    {
        // Validar datos de entrada
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'tipo' => 'required|string',
            'estado' => 'required|exists:estados,id',
            'direccion_completa' => 'required|string',
            'folio' => 'nullable|string',
            'id_organismo' => 'nullable|exists:catalogo_organismos,id_organismo',
            'fecha_emision' => 'nullable|date',
            'fecha_vigencia' => 'nullable|date',
            'url.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'nombre_documento.*' => 'required_with:url.*|string',
            'id_documento.*' => 'required_with:url.*|integer',
        ]);

        try {
            // Buscar la instalación existente
            $instalacion = Instalaciones::findOrFail($id);

            // Actualizar los datos de la instalación
            $instalacion->update([
                'id_empresa' => $request->input('id_empresa'),
                'tipo' => $request->input('tipo'),
                'estado' => $request->input('estado'),
                'direccion_completa' => $request->input('direccion_completa'),
                'folio' => $request->input('folio', null),
                'id_organismo' => $request->input('id_organismo', null),
                'fecha_emision' => $request->input('fecha_emision', null),
                'fecha_vigencia' => $request->input('fecha_vigencia', null),
            ]);

            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->input('id_empresa'))->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

            // Eliminar archivos antiguos
            $documentacionUrls = Documentacion_url::where('id_relacion', $id)->get();
            foreach ($documentacionUrls as $documentacionUrl) {
                $filePath = 'uploads/' . $numeroCliente . '/' . $documentacionUrl->url;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $documentacionUrl->delete();
            }

            // Almacenar nuevos documentos solo si se envían
            if ($request->hasFile('url')) {
                foreach ($request->file('url') as $index => $file) {
                    $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

                    // Crear nuevo registro de Documentacion_url
                    Documentacion_url::create([
                        'id_relacion' => $id,
                        'id_documento' => $request->id_documento[$index],
                        'nombre_documento' => $request->nombre_documento[$index],
                        'url' => $filename,
                        'id_empresa' => $request->input('id_empresa'),
                    ]);
                }
            }

            return response()->json(['code' => 200, 'message' => 'Instalación actualizada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error al actualizar la instalación.']);
        }
    }
}
