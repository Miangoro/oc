<?php

namespace App\Http\Controllers\domicilios;

use App\Http\Controllers\Controller;
use App\Models\Documentacion_url;
use App\Models\Instalaciones;
use App\Models\Empresa;
use App\Models\Estados;
use App\Models\Organismos;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DomiciliosController extends Controller
{
    public function UserManagement()
    {
        $instalaciones = Instalaciones::all(); // Obtener todas las instalaciones
        $empresas = Empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $estados = Estados::all(); // Obtener todos los estados
        $organismos = Organismos::all(); // Obtener todos los organismos
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
            6 => 'id_organismo',
            7 => 'fecha_emision',
            8 => 'fecha_vigencia'
        ];

        $search = [];

        $totalData = Instalaciones::whereHas('empresa', function($query) {
            $query->where('tipo', 2);
        })->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $instalaciones = Instalaciones::with('empresa', 'estados', 'organismos')
                ->whereHas('empresa', function($query) {
                    $query->where('tipo', 2);
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $instalaciones = Instalaciones::with('empresa', 'estados', 'organismos')
                ->whereHas('empresa', function($query) {
                    $query->where('tipo', 2);
                })
                ->where(function($query) use ($search) {
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

            $totalFiltered = Instalaciones::with('empresa', 'estados', 'organismos')
                ->whereHas('empresa', function($query) {
                    $query->where('tipo', 2);
                })
                ->where(function($query) use ($search) {
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
                $nestedData['tipo'] = $instalacion->tipo  ?? 'N/A';
                $nestedData['estado'] = $instalacion->estados->nombre  ?? 'N/A';
                $nestedData['direccion_completa'] = $instalacion->direccion_completa  ?? 'N/A';
                $nestedData['folio'] = $instalacion->folio ?? 'N/A'; // Corregido 'folion' a 'folio'
                $nestedData['organismo'] = $instalacion->organismos->organismo ?? 'N/A'; // Maneja el caso donde el organismo sea nulo
                $nestedData['fecha_emision'] = $instalacion->fecha_emision;
                $nestedData['fecha_vigencia'] = $instalacion->fecha_vigencia;
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

            
        // Almacenar nuevos documentos solo si se envían
        if ($request->hasFile('url')) {
            foreach ($request->file('url') as $index => $file) {

              

                $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public'); //Aqui se guarda en la ruta definida storage/public

                $documentacion_url = new Documentacion_url ();
                $documentacion_url->id_relacion = 15253;
                $documentacion_url->id_documento = $request->id_documento[$index];
                $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                $documentacion_url->id_empresa =  $request->input('id_empresa');

                $documentacion_url->save();
            }
        }


            return response()->json(['code' => 200, 'message' => 'Instalación registrada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['code' => 500, 'message' => 'Error al registrar la instalación.']);
        }
    }

    public function edit($id_instalacion)
    {
        try {
            $instalacion = Instalaciones::findOrFail($id_instalacion);
            return response()->json(['success' => true, 'instalacion' => $instalacion]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'tipo' => 'required|string',
            'estado' => 'required|string',
            'direccion_completa' => 'required|string',
            'folio' => 'nullable|string',
            'id_organismo' => 'nullable|exists:catalogo_organismos,id_organismo',
            'fecha_emision' => 'nullable|date',
            'fecha_vigencia' => 'nullable|date',
        ]);

        try {
            $instalacion = Instalaciones::findOrFail($id);
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

            return response()->json(['success' => 'Instalacion actualizada correctamente']);
          } catch (\Exception $e) {
              return response()->json(['error' => 'Error al actualizar la Instalacion'], 500);
          }
      }


//end
}
