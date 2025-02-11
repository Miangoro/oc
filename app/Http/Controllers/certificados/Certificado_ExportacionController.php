<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificado_Exportacion;
use App\Models\Dictamen_Exportacion; 
use App\Models\User;
use App\Models\empresa; 
use Barryvdh\DomPDF\Facade\Pdf;


class Certificado_ExportacionController extends Controller
{

  public function UserManagement()
    {
        $certificado = Certificado_Exportacion::all(); // Obtener todos los datos
        $dictamen = Dictamen_Exportacion::all();
        $users = User::where('tipo',1)->get(); //Solo inspectores 
        //$empresa = empresa::all();

        return view('certificados.certificado_exportacion', compact('certificado', 'dictamen', 'users'));
    }


public function index(Request $request)
{
    $columns = [
    //CAMPOS PARA ORDENAR LA TABLA DE INICIO "thead"
        1 => 'num_certificado',
        2 => 'id_dictamen',
        //3 => 'razon_social',
        4 => 'fecha_emision',
    ];

        $search = [];
        
        $totalData = Certificado_Exportacion::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if (empty($request->input('search.value'))) {
            // ORDENAR EL BUSCADOR "thead"
            $users = Certificado_Exportacion::where('id_dictamen', 'LIKE', "%{$request->input('search.value')}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        } else {
            // BUSCADOR
            $search = $request->input('search.value');
        
            // Consulta con filtros
        $query = Certificado_Exportacion::where('id_dictamen', 'LIKE', "%{$search}%")
        ->where("id_dictamen", 1)
        ->orWhere('num_certificado', 'LIKE', "%{$search}%");

        $users = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
  
        $totalFiltered = Certificado_Exportacion::where('id_dictamen', 'LIKE', "%{$search}%")
          ->where("id_dictamen", 1)
          ->orWhere('num_certificado', 'LIKE', "%{$search}%")
          ->count();
        }
        

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
            //MANDA LOS DATOS AL JS
                $nestedData['id_certificado'] = $user->id_certificado;
                $nestedData['id_dictamen'] = $user->id_dictamen;
                $nestedData['num_certificado'] = $user->num_certificado;
                /*$nestedData['id_inspeccion'] = $user->inspeccione->num_servicio;
                ///numero y nombre empresa
                $empresa = $user->inspeccione->solicitud->empresa;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes
                    ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
                : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['razon_social'] = $user->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';
                */
                $fecha_emision = Helpers::formatearFecha($user->fecha_emision);
                $fecha_vigencia = Helpers::formatearFecha($user->fecha_vigencia);
                $nestedData['fechas'] = '<b>Fecha Emisión: </b>' .$fecha_emision. '<br> <b>Fecha Vigencia: </b>' .$fecha_vigencia;
                
                $data[] = $nestedData;
            }
        }

        if ($data) {
            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'code' => 200,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'message' => 'Internal Server Error',
                'code' => 500,
                'data' => [],
            ]);
        }
}



//FUNCION PARA REGISTRAR
public function store(Request $request)
{
    try {
        // Crear y guardar
        $var = new Certificado_Exportacion();
        $var->num_certificado = $request->num_certificado;
        $var->id_dictamen = $request->id_dictamen;
        $var->fecha_emision = $request->fecha_emision;
        $var->fecha_vigencia = $request->fecha_vigencia;
        $var->id_firmante = $request->id_firmante;
        $var->save(); // Guardar en BD

        return response()->json(['success' => 'Registro agregado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Ocurrió un error al agregar'], 500);
    }
}



//FUNCION PARA ELIMINAR
public function destroy($id_certificado)
{
    try {
        $eliminar = Certificado_Exportacion::findOrFail($id_certificado);
        $eliminar->delete();

        return response()->json(['success' => 'Eliminado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar'], 500);
    }
}



//FUNCION PARA LLENAR EL FORMULARIO
public function edit($id_certificado)
{
    try {
        $var1 = Certificado_Exportacion::findOrFail($id_certificado);

        return response()->json([
            'id_certificado' => $var1->id_certificado,
            'id_dictamen' => $var1->id_dictamen,
            'num_certificado' => $var1->num_certificado,
            'fecha_emision' => $var1->fecha_emision,
            'fecha_vigencia' => $var1->fecha_vigencia,
            'id_firmante' => $var1->id_firmante,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener'], 500);
    }
}

//FUNCION PARA EDITAR
public function update(Request $request, $id_certificado) 
{
    $request->validate([
        'num_certificado' => 'required|string|max:255',
        'id_dictamen' => 'required|integer',
        'fecha_emision' => 'nullable|date',
        'fecha_vigencia' => 'nullable|date',
        'id_firmante' => 'required|integer',
    ]);

    try {
        $var2 = Certificado_Exportacion::findOrFail($id_certificado);
        $var2->num_certificado = $request->num_certificado;
        $var2->id_dictamen = $request->id_dictamen;
        $var2->fecha_emision = $request->fecha_emision;
        $var2->fecha_vigencia = $request->fecha_vigencia;
        $var2->id_firmante = $request->id_firmante;
        $var2->save();

        return response()->json(['success' => 'Registro editado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al editar'], 500);
    }
}



///FUNCION PDF DICTAMEN EXPORTACION
public function MostrarCertificadoExportacion($id_certificado) 
{
    // Obtener los datos del dictamen específico
    //$datos = Dictamen_Exportacion::with(['inspeccione.solicitud.empresa.empresaNumClientes', 'instalaciones', 'inspeccione.inspector'])->find($id_dictamen);    
    $data = Certificado_Exportacion::find($id_certificado);

    if (!$data) {
        return abort(404, 'Certificado no encontrado');
    }

    // Verifica qué valor tiene esta variable
    $fecha_emision2 = Helpers::formatearFecha($data->fecha_emision);
    $fecha_vigencia = Helpers::formatearFecha($data->fecha_vigencia);
    $fecha_servicio = Helpers::formatearFecha($data->fecha_servicio);

    // Determinar si la marca de agua debe ser visible
    $watermarkText = $data->estatus === 'Cancelado';

    $pdf = Pdf::loadView('pdfs.certificado_exportacion_ed12', [//formato del PDF
        'data' => $data,//declara todo = {{ $data->inspeccione->num_servicio }}
        /*'empresa' => $data->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado',
        'domicilio' => $data->inspeccione->solicitud->instalacion->direccion_completa ?? 'No encontrada',
        'rfc' => $data->inspeccione->solicitud->empresa->rfc ?? 'No encontrado',
        'no_dictamen' => $data->num_dictamen,
        'fecha_servicio' => $fecha_servicio,
        'fecha_emision' => $fecha_emision2,
        'fecha_vigencia' => $fecha_vigencia,*/
        'watermarkText' => $watermarkText,
    ]);
    //nombre al descarga
    return $pdf->stream('F-UV-04-18 Ver 2. Dictamen de Cumplimiento para Producto de Exportación.pdf');
}








}
