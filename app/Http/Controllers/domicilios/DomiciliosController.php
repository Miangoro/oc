<?php

namespace App\Http\Controllers\domicilios;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Documentacion_url;
use App\Models\Instalaciones;
use App\Models\empresa;
use App\Models\estados;
use App\Models\organismos;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DomiciliosController extends Controller
{
    public function UserManagement()
    {
        $instalaciones = Instalaciones::all(); // Obtener todas las instalaciones
        $empresas = empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $estados = estados::all(); // Obtener todos los estados
        $organismos = organismos::all(); // Obtener todos los organismos
       
        return view('domicilios.find_domicilio_instalaciones_view', compact('instalaciones', 'empresas', 'estados', 'organismos'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_instalacion',
            2 => 'direccion_completa',
            3 => 'estado',
            4 => 'folio',
            5 => 'tipo',
            6 => 'certificacion',
            7 => 'url',
            8 => 'fecha_emision',
            9 => 'fecha_vigencia',
            10 => 'responsable'
        ];

        $search = [];

        $totalData = Instalaciones::whereHas('empresa', function ($query) {
            $query->where('tipo', 2);
        })->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $instalaciones = Instalaciones::with('empresa', 'estados', 'organismos', 'documentos')
                ->whereHas('empresa', function ($query) {
                    $query->where('tipo', 2);
                })->where(function ($query) {
                    $query->whereHas('documentos', function ($query) {
                        $query->whereIn('id_documento', [127, 128, 129]);
                    })
                        ->orWhereDoesntHave('documentos');
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $instalaciones = Instalaciones::with('empresa', 'estados', 'organismos', 'documentos')
                ->whereHas('empresa', function ($query) {
                    $query->where('tipo', 2);
                })->where(function ($query) {
                    $query->whereHas('documentos', function ($query) {
                        $query->whereIn('id_documento', [127, 128, 129]);
                    })
                        ->orWhereDoesntHave('documentos');
                })
                ->where(function ($query) use ($search) {
                    $query->where('id_instalacion', 'LIKE', "%{$search}%")
                        ->orWhere('direccion_completa', 'LIKE', "%{$search}%")
                        ->orWhere('estado', 'LIKE', "%{$search}%")
                        ->orWhere('folio', 'LIKE', "%{$search}%")
                        ->orWhere('tipo', 'LIKE', "%{$search}%")
                        ->orWhere('id_organismo', 'LIKE', "%{$search}%")
                        ->orWhere('fecha_emision', 'LIKE', "%{$search}%")
                        ->orWhere('fecha_vigencia', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Instalaciones::with('empresa', 'estados', 'organismos', 'documentos')
                ->whereHas('empresa', function ($query) {
                    $query->where('tipo', 2);
                })->where(function ($query) {
                    $query->whereHas('documentos', function ($query) {
                        $query->whereIn('id_documento', [127, 128, 129]);
                    })
                        ->orWhereDoesntHave('documentos');
                })
                ->where(function ($query) use ($search) {
                    $query->where('id_instalacion', 'LIKE', "%{$search}%")
                        ->orWhere('direccion_completa', 'LIKE', "%{$search}%")
                        ->orWhere('estado', 'LIKE', "%{$search}%")
                        ->orWhere('folio', 'LIKE', "%{$search}%")
                        ->orWhere('tipo', 'LIKE', "%{$search}%")
                        ->orWhere('id_organismo', 'LIKE', "%{$search}%")
                        ->orWhere('fecha_emision', 'LIKE', "%{$search}%")
                        ->orWhere('fecha_vigencia', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = [];

        if (!empty($instalaciones)) {
            $ids = $start;

            foreach ($instalaciones as $instalacion) {
                $nestedData['id_instalacion'] = $instalacion->id_instalacion ?? 'N/A';
                $nestedData['fake_id'] = ++$ids  ?? 'N/A';
                $nestedData['razon_social'] = $instalacion->empresa->razon_social  ?? 'N/A';
                $tipo = json_decode($instalacion->tipo, true); if (!is_array($tipo)) { $tipo = [];}
                $nestedData['tipo'] = !empty($tipo) ? implode(', ', array_map('htmlspecialchars', $tipo)) : 'N/A';
                $nestedData['responsable'] = $instalacion->responsable ?? 'N/A';
                $nestedData['estado'] = $instalacion->estados->nombre  ?? 'N/A';
                $nestedData['direccion_completa'] = $instalacion->direccion_completa  ?? 'N/A';
                $nestedData['folio'] =
                    '<b>Certificadora:</b>' . ($instalacion->organismos->organismo ?? 'OC CIDAM') . '<br>' .
                    '<b>Número de certificado:</b>' . ($instalacion->folio ?? 'N/A') . '<br>' .
                    '<b>Fecha de emisión:</b>' . (Helpers::formatearFecha($instalacion->fecha_emision)) . '<br>' .
                    '<b>Fecha de vigencia:</b>' . (Helpers::formatearFecha($instalacion->fecha_vigencia)) . '<br>';
                $nestedData['organismo'] = $instalacion->organismos->organismo ?? 'OC CIDAM'; 
                $nestedData['url'] = !empty($instalacion->documentos->pluck('url')->toArray()) ? $instalacion->empresa->empresaNumClientes->pluck('numero_cliente')->first() . '/' . implode(',', $instalacion->documentos->pluck('url')->toArray()) : '';
                $nestedData['fecha_emision'] = Helpers::formatearFecha($instalacion->fecha_emision);
                $nestedData['fecha_vigencia'] = Helpers::formatearFecha($instalacion->fecha_vigencia);
                $nestedData['actions'] = '<button class="btn btn-danger btn-sm delete-record" data-id="' . $instalacion->id_instalacion . '">Eliminar</button>';

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
            $documentos = Documentacion_url::where('id_relacion', $id_instalacion)->get();
    
            if ($documentos->isNotEmpty()) {
                $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $instalacion->id_empresa)->first();
                $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
    
                foreach ($documentos as $documento) {
                    $filePath = 'uploads/' . $numeroCliente . '/' . $documento->url;
                        if (Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                }
                Documentacion_url::where('id_relacion', $id_instalacion)->delete();
            }
            $instalacion->delete();

            return response()->json(['success' => 'Instalación y documentos eliminados correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al eliminar la instalación y los registros: ' . $e->getMessage()], 500);
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'tipo' => 'required|array', 
            'estado' => 'required|exists:estados,id',
            'direccion_completa' => 'required|string',
            'responsable' => 'required|string', 
            'folio' => 'nullable|string',
            'id_organismo' => 'nullable|exists:catalogo_organismos,id_organismo',
            'fecha_emision' => 'nullable|date',
            'fecha_vigencia' => 'nullable|date',
            'certificacion' => 'nullable|string',
            'url.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'nombre_documento.*' => 'nullable|string', 
            'id_documento.*' => 'nullable|integer', 
        ]);
    
        try {
            Instalaciones::create([
                'id_empresa' => $request->input('id_empresa'),
                'tipo' => json_encode($request->input('tipo')), 
                'estado' => $request->input('estado'),
                'direccion_completa' => $request->input('direccion_completa'),
                'responsable' => $request->input('responsable'),
                'folio' => $request->input('folio', null),
                'id_organismo' => $request->input('id_organismo', null),
                'fecha_emision' => $request->input('fecha_emision', null),
                'fecha_vigencia' => $request->input('fecha_vigencia', null),
                'certificacion' => $request->input('certificacion', null),
            ]);
    
            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->input('id_empresa'))->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
            $aux = $request->hasFile('url');            
            $ultimaInstalacion = Instalaciones::latest()->first();
    
            if ($request->hasFile('url')) {
                $directory = 'uploads/' . $numeroCliente;
    
                $path = storage_path('app/public/' . $directory);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true); 
                }
    
                foreach ($request->file('url') as $index => $file) {
                    $filename = $request->nombre_documento[$index] ?? 'documento_' . time(); 
                    $filename .= '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');
    
                    if ($request->nombre_documento[$index] || $file) {
                        $documentacion_url = new Documentacion_url();
                        $documentacion_url->id_relacion = $ultimaInstalacion->id_instalacion;
                        $documentacion_url->id_documento = $request->id_documento[$index] ?? null;
                        $documentacion_url->nombre_documento = $request->nombre_documento[$index] ?? null;
                        $documentacion_url->url = $filename;
                        $documentacion_url->id_empresa = $request->input('id_empresa');
                        $documentacion_url->save();
                    }
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
            $instalacion = Instalaciones::findOrFail($id_instalacion);
            $documentacion_urls = Documentacion_url::where('id_relacion', $id_instalacion)->get();
            $archivo_url = $documentacion_urls->isNotEmpty() ? $documentacion_urls->first()->url : '';

            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $instalacion->id_empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

            return response()->json([
                'success' => true,
                'instalacion' => $instalacion,
                'archivo_url' => $archivo_url,
                'numeroCliente' => $numeroCliente
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false], 404);
        }
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'edit_id_empresa' => 'required|exists:empresa,id_empresa',
            'edit_tipo' => 'required|array', 
            'edit_estado' => 'required|exists:estados,id',
            'edit_direccion' => 'required|string',
            'edit_folio' => 'nullable|string',
            'edit_id_organismo' => 'nullable|exists:catalogo_organismos,id_organismo',
            'edit_fecha_emision' => 'nullable|date',
            'edit_fecha_vigencia' => 'nullable|date',
            'edit_certificacion' => 'nullable|string',
            'edit_url.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'edit_nombre_documento.*' => 'nullable:edit_url.*|string',
            'edit_id_documento.*' => 'nullable:edit_url.*|integer',
        ]);
    
        try {
            $instalacion = Instalaciones::findOrFail($id);
    
            $instalacion->update([
                'id_empresa' => $request->input('edit_id_empresa'),
                'tipo' => $request->input('edit_tipo'),
                'estado' => $request->input('edit_estado'),
                'direccion_completa' => $request->input('edit_direccion'),
                'folio' => $request->input('edit_folio', null),
                'id_organismo' => $request->input('edit_id_organismo', null),
                'fecha_emision' => $request->input('edit_fecha_emision', null),
                'fecha_vigencia' => $request->input('edit_fecha_vigencia', null),
                'certificacion' => $request->input('edit_certificacion'),
            ]);
    
            $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $request->input('edit_id_empresa'))->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
    
            // Eliminar documentos antiguos relacionados
            $documentacionUrls = Documentacion_url::where('id_relacion', $id)->get();
            foreach ($documentacionUrls as $documentacionUrl) {
                $filePath = 'uploads/' . $numeroCliente . '/' . $documentacionUrl->url;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $documentacionUrl->delete();
            }
    
            // Subir y guardar nuevos documentos
            if ($request->hasFile('edit_url')) {
                foreach ($request->file('edit_url') as $index => $file) {
                    $documentoId = $request->edit_id_documento[$index];
                    $documentoNombre = $request->edit_nombre_documento[$index];
    
                    // Crear el nombre de archivo y la ruta con el número de cliente
                    $filename = $documentoNombre . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $directoryPath = 'uploads/' . $numeroCliente;
    
                    // Subir el archivo al subdirectorio correcto
                    $filePath = $file->storeAs($directoryPath, $filename, 'public');
    
                    Documentacion_url::create([
                        'id_relacion' => $id,
                        'id_documento' => $documentoId,
                        'nombre_documento' => $documentoNombre,
                        'url' => $filename,
                        'id_empresa' => $request->input('edit_id_empresa'),
                    ]);
                }
            }
    
            return response()->json(['code' => 200, 'message' => 'Instalación actualizada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error al actualizar la instalación.']);
        }
    }
    
//end
}
