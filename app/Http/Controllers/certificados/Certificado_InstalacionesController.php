<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificados;
use App\Models\Dictamen_instalaciones;
use Barryvdh\DomPDF\Facade\Pdf;

class Certificado_InstalacionesController extends Controller
{
    public function UserManagement()
    {
        $dictamenes = Dictamen_instalaciones::all();
        return view('certificados.certificados_instalaciones_view', compact('dictamenes'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'num_dictamen',
            2 => 'num_certificado',
            3 => 'maestro_mezcalero',
            4 => 'num_autorizacion', // Cambio aquí
            5 => 'fecha_vigencia',
            6 => 'fecha_vencimiento',
           /*  7 => 'tipo_dictamen' */
        ];
    
        $search = $request->input('search.value');
    
        // Obtener el total de registros sin filtrar
        $totalData = Certificados::with('dictamen')->count();
    
        // Inicializar totalFiltered con el total de datos
        $totalFiltered = $totalData;
    
        // Obtener los datos para paginación y ordenación
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');
    
        // Establecer el orden
        $order = isset($columns[$orderIndex]) ? $columns[$orderIndex] : 'num_certificado';
        $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';
    
        // Consultar certificados con paginación, ordenación y filtrado
        $query = Certificados::with('dictamen')
            ->when($search, function($q, $search) {
                $q->where('num_certificado', 'LIKE', "%{$search}%")
                  ->orWhere('maestro_mezcalero', 'LIKE', "%{$search}%");
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir);
    
        // Obtener los datos filtrados
        $certificados = $query->get();
    
        // Actualizar totalFiltered si hay un término de búsqueda
        if ($search) {
            $totalFiltered = Certificados::with('dictamen')
                ->where('num_certificado', 'LIKE', "%{$search}%")
                ->orWhere('maestro_mezcalero', 'LIKE', "%{$search}%")
                ->count();
        }
    
        $data = [];
    
        // Formatear los datos para la respuesta
        foreach ($certificados as $certificado) {
            $nestedData['id_certificado'] = $certificado->id_certificado;
            $nestedData['fake_id'] = ++$start;
            $nestedData['num_certificado'] = $certificado->num_certificado;
            $nestedData['num_autorizacion'] = $certificado->num_autorizacion ?? 'N/A';
            $nestedData['fecha_vigencia'] = Helpers::formatearFecha($certificado->fecha_vigencia);
            $nestedData['fecha_vencimiento'] = Helpers::formatearFecha($certificado->fecha_vencimiento);
            $nestedData['maestro_mezcalero'] = $certificado->maestro_mezcalero;
            $nestedData['num_dictamen'] = $certificado->dictamen->num_dictamen ?? 'N/A';
            $nestedData['tipo_dictamen'] = $certificado->dictamen->tipo_dictamen;    
            $data[] = $nestedData;
        }
    
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
    
    public function store(Request $request)
    {
        // Validación de datos del formulario
        $validatedData = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_vigencia' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'maestro_mezcalero' => 'nullable|string|max:60',
            'num_autorizacion' => 'nullable|integer',
        ]);
    
        $certificado = Certificados::create([
            'id_dictamen' => $validatedData['id_dictamen'],
            'num_certificado' => $validatedData['num_certificado'],
            'fecha_vigencia' => $validatedData['fecha_vigencia'],
            'fecha_vencimiento' => $validatedData['fecha_vencimiento'],
            'maestro_mezcalero' => $validatedData['maestro_mezcalero'] ?: null, 
            'num_autorizacion' => $validatedData['num_autorizacion'] ?: null 
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
    ]);

    try {
        $certificado = Certificados::findOrFail($id);

        $certificado->id_dictamen = $validatedData['id_dictamen'];
        $certificado->num_certificado = $validatedData['num_certificado'];
        $certificado->fecha_vigencia = $validatedData['fecha_vigencia'];
        $certificado->fecha_vencimiento = $validatedData['fecha_vencimiento'];
        $certificado->maestro_mezcalero = $validatedData['maestro_mezcalero'] ?: null;
        $certificado->num_autorizacion = $validatedData['num_autorizacion'] ?: null; 

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
    $datos = Certificados::with(['dictamen.inspeccione.solicitud.empresa',  'dictamen.instalaciones', 'dictamen.inspeccione.inspector'])->findOrFail($id_certificado);

    // Obtener los datos de la empresa
    $empresa = $datos->dictamen->inspeccione->solicitud->empresa;
    $domicilio_fiscal = $empresa->domicilio_fiscal;
    $rfc = $empresa->rfc;
    $telefono = $empresa->telefono;
    $correo = $empresa->correo;
    $numero_cliente = $empresa->empresaNumClientes->where('empresa_id', $empresa->id)->first()->numero_cliente;
    $maestro_mezcalero = $datos->maestro_mezcalero ?? '------------------------------';
    $direccion_completa = $datos->dictamen->instalaciones->direccion_completa;
    $num_autorizacion = $datos->num_autorizacion;
    $num_dictamen = $datos->dictamen->num_dictamen;
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    $fecha_vencimiento = Helpers::formatearFecha($datos->fecha_vencimiento);

    $pdf = Pdf::loadView('pdfs.Certificado_productor_mezcal', [ 'datos' => $datos,'num_certificado' => $datos->num_certificado, 'num_autorizacion' => $num_autorizacion, 'num_dictamen' => $num_dictamen, 'fecha_emision' => $fecha_emision,'fecha_vigencia' => $fecha_vigencia,'fecha_vencimiento' => $fecha_vencimiento,'domicilio_fiscal' => $domicilio_fiscal, 
        'rfc' => $rfc, 'telefono' => $telefono, 'correo' => $correo, 'direccion_completa' => $direccion_completa,'maestro_mezcalero' => $maestro_mezcalero,'numero_cliente' => $numero_cliente
    ]);

    return $pdf->stream('Certificado de productor de mezcal.pdf');
}

public function pdf_certificado_envasador($id_certificado)
{
    $datos = Certificados::with(['dictamen.inspeccione.solicitud.empresa.empresaNumClientes','dictamen.instalaciones','dictamen.inspeccione.inspector'])->findOrFail($id_certificado);

    $empresa = $datos->dictamen->inspeccione->solicitud->empresa;
    $domicilio_fiscal = $empresa->domicilio_fiscal;
    $rfc = $empresa->rfc;
    $telefono = $empresa->telefono;
    $correo = $empresa->correo;
    $numero_cliente = $empresa->empresaNumClientes->firstWhere('empresa_id', $empresa->id)->numero_cliente;
    $maestro_mezcalero = $datos->maestro_mezcalero ?? '------------------------------';
    $direccion_completa = $datos->dictamen->instalaciones->direccion_completa;
    $num_autorizacion = $datos->num_autorizacion;
    $num_dictamen = $datos->dictamen->num_dictamen; 
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    $fecha_vencimiento = Helpers::formatearFecha($datos->fecha_vencimiento);

    $pdf = Pdf::loadView('pdfs.Certificado_envasador_mezcal', [
        'datos' => $datos,'num_certificado' => $datos->num_certificado,'num_autorizacion' => $num_autorizacion,'num_dictamen' => $num_dictamen,'fecha_emision' => $fecha_emision,'fecha_vigencia' => $fecha_vigencia,'fecha_vencimiento' => $fecha_vencimiento,
        'domicilio_fiscal' => $domicilio_fiscal,'rfc' => $rfc,'telefono' => $telefono, 'correo' => $correo,'direccion_completa' => $direccion_completa, 'maestro_mezcalero' => $maestro_mezcalero,'numero_cliente' => $numero_cliente
    ]);

    return $pdf->stream('Certificado de envasador de mezcal.pdf');
}


   
public function pdf_certificado_comercializador($id_certificado)
{
    // Obtener el certificado con las relaciones necesarias
    $datos = Certificados::with([
        'dictamen.inspeccione.solicitud.empresa.empresaNumClientes',
        'dictamen.instalaciones',
        'dictamen.inspeccione.inspector'
    ])->findOrFail($id_certificado);

    // Obtener los datos de la empresa
    $empresa = $datos->dictamen->inspeccione->solicitud->empresa;
    $domicilio_fiscal = $empresa->domicilio_fiscal;
    $rfc = $empresa->rfc;
    $telefono = $empresa->telefono;
    $correo = $empresa->correo;
    $numero_cliente = $empresa->empresaNumClientes->firstWhere('empresa_id', $empresa->id)->numero_cliente ?? 'No disponible';
    $maestro_mezcalero = $datos->maestro_mezcalero ?? '------------------------------';
    $direccion_completa = $datos->dictamen->instalaciones->direccion_completa ?? 'No disponible';
    $num_autorizacion = $datos->num_autorizacion;
    $num_dictamen = $datos->dictamen->num_dictamen ?? 'No disponible';
    $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    $fecha_vencimiento = Helpers::formatearFecha($datos->fecha_vencimiento);

    // Generar el PDF con los datos necesarios
    $pdf = Pdf::loadView('pdfs.Certificado_comercializador', [
        'datos' => $datos,'num_certificado' => $datos->num_certificado,'num_autorizacion' => $num_autorizacion,'num_dictamen' => $num_dictamen,'fecha_emision' => $fecha_emision,'fecha_vigencia' => $fecha_vigencia,'fecha_vencimiento' => $fecha_vencimiento,'domicilio_fiscal' => $domicilio_fiscal,
        'rfc' => $rfc,'telefono' => $telefono,'correo' => $correo,'direccion_completa' => $direccion_completa,'maestro_mezcalero' => $maestro_mezcalero,'numero_cliente' => $numero_cliente
    ]);
    return $pdf->stream('Certificado de comercializador.pdf');
}

    
}
