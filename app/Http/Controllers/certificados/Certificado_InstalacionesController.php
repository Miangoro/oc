<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificados;
use App\Models\Dictamen_instalaciones;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User; // Modelo para usuarios

class Certificado_InstalacionesController extends Controller
{
    public function UserManagement()
    {
        $dictamenes = Dictamen_instalaciones::all();
        $users = User::all(); 
        return view('certificados.certificados_instalaciones_view', compact('dictamenes', 'users'));
    }

    public function index(Request $request)
    {
        // Definir columnas y parámetros de la consulta
        $columns = [
            1 => 'num_dictamen',
            2 => 'num_certificado',
            3 => 'id_firmante',
            4 => 'maestro_mezcalero',
            5 => 'num_autorizacion',
            6 => 'fecha_vigencia',
            7 => 'fecha_vencimiento',
        ];
    
        $search = $request->input('search.value');
        $totalData = Certificados::with(['dictamen', 'firmante'])->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');
    
        $order = $columns[$orderIndex] ?? 'num_certificado';
        $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';
    
        $query = Certificados::with(['dictamen', 'firmante'])
            ->when($search, function($q, $search) {
                $q->where('num_certificado', 'LIKE', "%{$search}%")
                  ->orWhere('maestro_mezcalero', 'LIKE', "%{$search}%")
                  ->orWhereHas('firmante', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir);
    
        $certificados = $query->get();
    
        if ($search) {
            $totalFiltered = Certificados::with('dictamen')
                ->where('num_certificado', 'LIKE', "%{$search}%")
                ->orWhere('maestro_mezcalero', 'LIKE', "%{$search}%")
                ->orWhereHas('firmante', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->count();
        }
    
        $data = $certificados->map(function ($certificado) use (&$start) {
            return [
                'id_certificado' => $certificado->id_certificado,
                'fake_id' => ++$start,
                'num_certificado' => $certificado->num_certificado,
                'num_autorizacion' => $certificado->num_autorizacion ?? 'N/A',
                'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
                'fecha_vencimiento' => Helpers::formatearFecha($certificado->fecha_vencimiento),
                'maestro_mezcalero' => $certificado->maestro_mezcalero ?? 'N/A',
                'num_dictamen' => $certificado->dictamen->num_dictamen,
                'tipo_dictamen' => $certificado->dictamen->tipo_dictamen,
                'id_firmante' => $certificado->firmante->name, 
            ];
        });
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
    }    
    
    // Función para eliminar
    public function destroy($id_certificado)
    {
        $certificado = Certificados::findOrFail($id_certificado);
        $certificado->delete();

        return response()->json(['success' => 'Certificado eliminado correctamente']);
    }
    
    // Funcion agregar
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_vigencia' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'maestro_mezcalero' => 'nullable|string|max:60',
            'num_autorizacion' => 'nullable|integer',
            'id_firmante' => 'required|integer',
        ]);
    
        $certificado = Certificados::create([
            'id_dictamen' => $validatedData['id_dictamen'],
            'num_certificado' => $validatedData['num_certificado'],
            'fecha_vigencia' => $validatedData['fecha_vigencia'],
            'fecha_vencimiento' => $validatedData['fecha_vencimiento'],
            'maestro_mezcalero' => $validatedData['maestro_mezcalero'] ?: null, 
            'num_autorizacion' => $validatedData['num_autorizacion'] ?: null,
            'id_firmante' => $validatedData['id_firmante']
        ]);
    
        return response()->json([
            'message' => 'Certificado registrado exitosamente',
            'certificado' => $certificado
        ]);
    }
    
    // Funcion para cargar
    public function edit($id)
    {
        $certificado = Certificados::find($id);
    
        if ($certificado) {
            return response()->json($certificado);
        }
    
        return response()->json(['error' => 'Certificado no encontrado'], 404);
    }
 
    // Funcion Actualizar
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_vigencia' => 'required|date_format:Y-m-d',
            'fecha_vencimiento' => 'nullable|date_format:Y-m-d',
            'maestro_mezcalero' => 'nullable|string|max:60',
            'num_autorizacion' => 'nullable|integer',
            'id_firmante' => 'required|integer',
        ]);
    
        try {
            $certificado = Certificados::findOrFail($id);
    
            $certificado->id_dictamen = $validatedData['id_dictamen'];
            $certificado->num_certificado = $validatedData['num_certificado'];
            $certificado->fecha_vigencia = $validatedData['fecha_vigencia'];
            $certificado->fecha_vencimiento = $validatedData['fecha_vencimiento'];
            $certificado->maestro_mezcalero = $validatedData['maestro_mezcalero'] ?: null;
            $certificado->num_autorizacion = $validatedData['num_autorizacion'] ?: null;
            $certificado->id_firmante = $validatedData['id_firmante']; 
    
            $certificado->save();
    
            return response()->json([
                'message' => 'Certificado actualizado correctamente.',
                'certificado' => $certificado
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar el certificado. Por favor, intente de nuevo.'
            ], 500);
        }
    }
    
    public function pdf_certificado_productor($id_certificado)
    {
        $datos = Certificados::with(['dictamen.inspeccione.solicitud.empresa.empresaNumClientes','dictamen.instalaciones','dictamen.inspeccione.inspector','firmante'])->findOrFail($id_certificado);
    
        $empresa = $datos->dictamen->inspeccione->solicitud->empresa;
        $numero_cliente = $empresa->empresaNumClientes->firstWhere('empresa_id', $empresa->id)->numero_cliente;
    
        $pdfData = [
            'datos' => $datos,'num_certificado' => $datos->num_certificado,'num_autorizacion' => $datos->num_autorizacion,'num_dictamen' => $datos->dictamen->num_dictamen,'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),'fecha_vencimiento' => Helpers::formatearFecha($datos->fecha_vencimiento),'domicilio_fiscal' => $empresa->domicilio_fiscal,'rfc' => $empresa->rfc,
            'telefono' => $empresa->telefono,'correo' => $empresa->correo,'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa,
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------','numero_cliente' => $numero_cliente,'nombre_firmante' => $datos->firmante->name
        ];
        
        $pdf = Pdf::loadView('pdfs.Certificado_productor_mezcal', $pdfData);    
        return $pdf->stream('Certificado de productor de mezcal.pdf');
    }
    
    
    public function pdf_certificado_envasador($id_certificado)
    {
        $datos = Certificados::with(['dictamen.inspeccione.solicitud.empresa.empresaNumClientes','dictamen.instalaciones','dictamen.inspeccione.inspector','firmante' ])->findOrFail($id_certificado);
    
        $empresa = $datos->dictamen->inspeccione->solicitud->empresa;
        $numero_cliente = $empresa->empresaNumClientes->firstWhere('empresa_id', $empresa->id)->numero_cliente;
    
        $pdfData = [
            'datos' => $datos,'num_certificado' => $datos->num_certificado,'num_autorizacion' => $datos->num_autorizacion,'num_dictamen' => $datos->dictamen->num_dictamen,
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),'fecha_vencimiento' => Helpers::formatearFecha($datos->fecha_vencimiento),
            'domicilio_fiscal' => $empresa->domicilio_fiscal,'rfc' => $empresa->rfc,'telefono' => $empresa->telefono,'correo' => $empresa->correo,'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa,
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------','numero_cliente' => $numero_cliente,'nombre_firmante' => $datos->firmante->name
        ];
    
        $pdf = Pdf::loadView('pdfs.Certificado_envasador_mezcal', $pdfData);    
        return $pdf->stream('Certificado de envasador de mezcal.pdf');
    }

    public function pdf_certificado_comercializador($id_certificado)
    {
        $datos = Certificados::with(['dictamen.inspeccione.solicitud.empresa.empresaNumClientes','dictamen.instalaciones','dictamen.inspeccione.inspector','firmante'])->findOrFail($id_certificado);

        $empresa = $datos->dictamen->inspeccione->solicitud->empresa;
        $numero_cliente = $empresa->empresaNumClientes->firstWhere('empresa_id', $empresa->id)->numero_cliente;

         $pdfData = [
            'datos' => $datos,'num_certificado' => $datos->num_certificado,'num_autorizacion' => $datos->num_autorizacion,'num_dictamen' => $datos->dictamen->num_dictamen,'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),'fecha_vencimiento' => Helpers::formatearFecha($datos->fecha_vencimiento),'domicilio_fiscal' => $empresa->domicilio_fiscal,'rfc' => $empresa->rfc,
            'telefono' => $empresa->telefono,'correo' => $empresa->correo,'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa,'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------',
            'numero_cliente' => $numero_cliente,'nombre_firmante' => $datos->firmante->name ?? 'Nombre del firmante no disponible'
    ];

    $pdf = Pdf::loadView('pdfs.Certificado_comercializador', $pdfData);
    return $pdf->stream('Certificado de comercializador.pdf');
}

//end
}
