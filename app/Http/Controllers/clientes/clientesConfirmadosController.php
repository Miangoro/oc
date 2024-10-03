<?php

namespace App\Http\Controllers\clientes;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\empresa;
use App\Models\empresaContrato;
use App\Models\empresaNumCliente;
use App\Models\solicitud_informacion;
use App\Models\User;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class clientesConfirmadosController extends Controller
{
    public function UserManagement()
    {

        $empresas = empresa::where('tipo', 2)->count();
        $fisicas = empresa::where('tipo', 2)->where('regimen', 'Persona física')->count();
        $morales = empresa::where('tipo', 2)->where('regimen', 'Persona moral')->count();
        //$usuarios = User::all();
        $usuarios = User::where("tipo",1)->get();
        // $userCount = $empresas->count();
        $verified = 5;
        $notVerified = 10;
        // $usersUnique = $empresas->unique(['estado']);
        $userDuplicates = 40;

        return view('clientes.find_clientes_confirmados_view', [


            'empresas' => $empresas,
            'fisicas' => $fisicas,
            'morales' => $morales,
            'usuarios' => $usuarios,

        ]);
    }

    public function aceptarCliente(Request $request)
    {

        for ($i = 0; $i < count($request->numero_cliente); $i++) {
            $cliente = new empresaNumCliente();
            $cliente->numero_cliente = $request->numero_cliente[$i];
            $cliente->id_norma = $request->id_norma[$i];
            $cliente->save();
        }


        $contrato = new empresaContrato();
        $contrato->id_empresa = $request->id_empresa;
        $contrato->fecha_cedula = $request->fecha_cedula;
        $contrato->idcif = $request->idcif;
        $contrato->clave_ine = $request->clave_ine;
        $contrato->sociedad_mercantil = $request->sociedad_mercantil;
        $contrato->num_instrumento = $request->num_instrumento;
        $contrato->vol_instrumento = $request->vol_instrumento;
        $contrato->fecha_instrumento = $request->fecha_instrumento;
        $contrato->num_notario = $request->num_notario;
        $contrato->num_permiso = $request->num_permiso;
        $contrato->save();

        $contrato = empresa::find($request->id_empresa);
        $contrato->tipo = 2;
        $contrato->update();


        // Hash::make($input['password']

        return response()->json('Validada');
    }

    //Editar cliente
    //funcion para llenar el campo del formulario
public function editarCliente($id)
{
    try {
        $var1 = empresaNumCliente::findOrFail($id);
        return response()->json($var1);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener la clase'], 500);
    }
}

// Función para EDITAR una clase existente
    public function update_cliente(Request $request, $id)
{
    $request->validate([
        'id_empresa' => 'required|integer',
        'num_cliente' => 'required|string|max:255',
        'id_norma' => 'required|integer',
    ]);

    try {
        $var2 = empresaNumCliente::findOrFail($id);
        $var2->id_empresa = $request->numero_cliente;
        $var2->num_cliente = $request->num_cliente;
        $var2->id_norma = $request->id_norma;
        $var2->save();

        return response()->json(['success' => 'Editado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al editar'], 500);
    }
}
//Aqui termina editar cliente
    public function pdfCartaAsignacion($id)
    {
        $res = DB::select('SELECT ac.actividad, nc.numero_cliente, s.medios, s.competencia, s.capacidad, s.comentarios, e.representante, e.razon_social, fecha_registro, info_procesos, s.fecha_registro, e.correo, e.telefono, p.id_producto, n.id_norma, a.id_actividad,
       e.estado 
      FROM empresa e 
      JOIN solicitud_informacion s ON (e.id_empresa = s.id_empresa) 
      JOIN empresa_producto_certificar p ON (p.id_empresa = e.id_empresa)
      JOIN empresa_norma_certificar n ON (n.id_empresa = e.id_empresa)
      JOIN empresa_actividad_cliente a ON (a.id_empresa = e.id_empresa)
      JOIN catalogo_actividad_cliente ac ON (a.id_actividad = ac.id_actividad)
      JOIN empresa_num_cliente nc ON (nc.id_empresa = e.id_empresa)
      WHERE nc.numero_cliente="' . $id . '"');
        $pdf = Pdf::loadView('pdfs.CartaAsignacion', ['datos' => $res]);
        return $pdf->stream('Carta de asignación de número de cliente.pdf');
    }

    public function pdfCartaAsignacion052($id)
    {
        $res = DB::select('SELECT ac.actividad, nc.numero_cliente, s.medios, s.competencia, s.capacidad, s.comentarios, e.representante, e.razon_social, fecha_registro, info_procesos, s.fecha_registro, e.correo, e.telefono, p.id_producto, n.id_norma, a.id_actividad,
       e.estado 
      FROM empresa e 
      JOIN solicitud_informacion s ON (e.id_empresa = s.id_empresa) 
      JOIN empresa_producto_certificar p ON (p.id_empresa = e.id_empresa)
      JOIN empresa_norma_certificar n ON (n.id_empresa = e.id_empresa)
      JOIN empresa_actividad_cliente a ON (a.id_empresa = e.id_empresa)
      JOIN catalogo_actividad_cliente ac ON (a.id_actividad = ac.id_actividad)
      JOIN empresa_num_cliente nc ON (nc.id_empresa = e.id_empresa)
      WHERE nc.numero_cliente="' . $id . '"');
        $pdf = Pdf::loadView('pdfs.CartaAsignacion052', ['datos' => $res]);
        return $pdf->stream('Carta de asignación de número de cliente.pdf');
    }

    public function pdfServicioPersonaFisica070($id)
    {
        $res = DB::select('SELECT c.fecha_vigencia, e.domicilio_fiscal, e.rfc, c.nombre_notario, c.estado_notario, c.fecha_cedula, c.idcif, c.clave_ine, c.sociedad_mercantil, c.num_instrumento, c.vol_instrumento, c.fecha_instrumento, c.num_notario, c.num_permiso,  s.medios, s.competencia, s.capacidad, s.comentarios, e.representante, e.razon_social, fecha_registro, info_procesos, s.fecha_registro, e.correo, e.telefono, p.id_producto, n.id_norma, a.id_actividad,
      e.estado
      FROM empresa e 
      JOIN solicitud_informacion s ON (e.id_empresa = s.id_empresa) 
      JOIN empresa_producto_certificar p ON (p.id_empresa = e.id_empresa)
      JOIN empresa_norma_certificar n ON (n.id_empresa = e.id_empresa)
      JOIN empresa_actividad_cliente a ON (a.id_empresa = e.id_empresa)
      JOIN empresa_contrato c ON (c.id_empresa = e.id_empresa)
      WHERE e.id_empresa=' . $id);
        $pdf = Pdf::loadView('pdfs.prestacion_servicio_fisica', ['datos' => $res]);
        return $pdf->stream('F4.1-01-01 Contrato de prestación de servicios NOM 070 Ed 4 persona fisica VIGENTE.pdf');
    }

    public function pdfServicioPersonaMoral070($id)
    {
        $res = DB::select('SELECT c.fecha_vigencia, e.domicilio_fiscal, e.rfc, c.nombre_notario, c.estado_notario, c.fecha_cedula, c.idcif, c.clave_ine, c.sociedad_mercantil, c.num_instrumento, c.vol_instrumento, c.fecha_instrumento, c.num_notario, c.num_permiso,  s.medios, s.competencia, s.capacidad, s.comentarios, e.representante, e.razon_social, fecha_registro, info_procesos, s.fecha_registro, e.correo, e.telefono, p.id_producto, n.id_norma, a.id_actividad,
        e.estado
        FROM empresa e 
        JOIN solicitud_informacion s ON (e.id_empresa = s.id_empresa) 
        JOIN empresa_producto_certificar p ON (p.id_empresa = e.id_empresa)
        JOIN empresa_norma_certificar n ON (n.id_empresa = e.id_empresa)
        JOIN empresa_actividad_cliente a ON (a.id_empresa = e.id_empresa)
        JOIN empresa_contrato c ON (c.id_empresa = e.id_empresa)
        WHERE e.id_empresa=' . $id);
        
        $fecha_cedula = Helpers::formatearFecha($res[0]->fecha_cedula);
        $fecha_vigencia = Helpers::formatearFecha($res[0]->fecha_vigencia);
      $pdf = Pdf::loadView('pdfs.prestacion_servicios_vigente', ['datos' => $res,'fecha_cedula'=>$fecha_cedula,'fecha_vigencia'=>$fecha_vigencia]);
    return $pdf->stream('F4.1-01-01 Contrato de prestación de servicios NOM 070 Ed 4 VIGENTE.pdf');
    }

    public function registrarValidacion(Request $request)
    {
        $solicitud = solicitud_informacion::find($request->id_solicitud);
        $solicitud->medios = $request->medios;
        $solicitud->competencia = $request->competencia;
        $solicitud->capacidad =  $request->capacidad;
        $solicitud->comentarios =  $request->comentarios;

        $solicitud->update();
    }

    public function store(Request $request)
    {


        $solicitud = solicitud_informacion::where('id_empresa', $request->id_empresa)->first();
        $solicitud->medios = $request->medios;
        $solicitud->competencia = $request->competencia;
        $solicitud->capacidad =  $request->capacidad;
        $solicitud->comentarios =  $request->comentarios;

        $solicitud->update();

        // user created
        return response()->json('Validada');
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_empresa',
            2 => 'numero_cliente',
            3 => 'razon_social',
            4 => 'domicilio_fiscal',
            5 => 'regimen',
        ];

        $search = [];

        $totalData = empresa::where('tipo', 2)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = empresa::join('empresa_num_cliente AS n', 'empresa.id_empresa', '=', 'n.id_empresa')
                ->select('empresa.razon_social', 'empresa.id_empresa', 'empresa.rfc', 'empresa.domicilio_fiscal', 'empresa.representante', 'empresa.regimen', DB::raw('GROUP_CONCAT(distinct CONCAT(n.numero_cliente, ",", n.id_norma) SEPARATOR "<br>") as numero_cliente'))
                ->where('tipo', 2)->offset($start)
                ->groupBy('empresa.id_empresa', 'empresa.razon_social',  'empresa.rfc', 'empresa.regimen', 'empresa.domicilio_fiscal', 'empresa.representante')
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = empresa::join('empresa_num_cliente AS n', 'empresa.id_empresa', '=', 'n.id_empresa')
                ->select('empresa.razon_social', 'empresa.id_empresa', 'empresa.rfc', 'empresa.domicilio_fiscal', 'empresa.representante', 'empresa.regimen', DB::raw('GROUP_CONCAT(distinct CONCAT(n.numero_cliente, ",", n.id_norma) SEPARATOR "<br>") as numero_cliente'))
                ->where('tipo', 2)->where('id_empresa', 'LIKE', "%{$search}%")
                ->orWhere('razon_social', 'LIKE', "%{$search}%")
                ->orWhere('domicilio_fiscal', 'LIKE', "%{$search}%")
                ->offset($start)
                ->groupBy('empresa.id_empresa', 'empresa.razon_social',  'empresa.rfc', 'empresa.regimen', 'empresa.domicilio_fiscal', 'empresa.representante')
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = empresa::where('tipo', 2)->where('id_empresa', 'LIKE', "%{$search}%")
                ->orWhere('razon_social', 'LIKE', "%{$search}%")
                ->orWhere('domicilio_fiscal', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($users)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id_empresa'] = $user->id_empresa;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['numero_cliente'] = $user->numero_cliente;
                $nestedData['razon_social'] = $user->razon_social;
                $nestedData['domicilio_fiscal'] = $user->domicilio_fiscal;
                $nestedData['regimen'] = $user->regimen;

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



    
    public function obtenerContratosPorEmpresa($id_empresa)
    {
        // Intenta obtener los contratos relacionados con la empresa
        try {
            $contratos = EmpresaContrato::where('id_empresa', $id_empresa)->get();
    
            // Verifica si se encontraron contratos
            if ($contratos->isEmpty()) {
                return response()->json(['error' => 'No se encontraron contratos para esta empresa.'], 404);
            }
    
            // Retornar los contratos como respuesta JSON
            return response()->json($contratos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los contratos: ' . $e->getMessage()], 500);
        }
    }
    
    public function obtenerNumeroCliente($id_empresa)
{
    try {
        // Suponiendo que tienes un modelo EmpresaNumCliente
        $numero_cliente = EmpresaNumCliente::where('id_empresa', $id_empresa)->first();
        
        // Verifica si se encontró el número de cliente
        if (!$numero_cliente) {
            return response()->json(['error' => 'No se encontró el número de cliente para esta empresa.'], 404);
        }

        return response()->json($numero_cliente);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener el número de cliente: ' . $e->getMessage()], 500);
    }
}


// -- Funciones para actualizar Cientes Confirmados -- //
public function actualizarRegistros(Request $request)
{
    $request->validate([
        'id_empresa' => 'required|exists:empresa,id_empresa', 
        'fecha_cedula' => 'required|date',
        'idcif' => 'required|string|max:255',
        'clave_ine' => 'required|string|max:255',
        'sociedad_mercantil' => 'required|string|max:255',
        'num_instrumento' => 'required|string|max:255',
        'vol_instrumento' => 'required|string|max:255',
        'fecha_instrumento' => 'required|date',
        'nombre_notario' => 'required|string|max:255',
        'num_notario' => 'required|string|max:255',
        'estado_notario' => 'required|string|max:255',
        'num_permiso' => 'required|string|max:255',
        'numero_cliente' => 'required|string|max:255', 
    ]);

    try {
        $contrato = EmpresaContrato::where('id_empresa', $request->id_empresa)->first();

        if (!$contrato) {
            return response()->json(['error' => 'Contrato no encontrado.'], 404);
        }

        $contrato->fecha_cedula = $request->fecha_cedula;
        $contrato->idcif = $request->idcif;
        $contrato->clave_ine = $request->clave_ine;
        $contrato->sociedad_mercantil = $request->sociedad_mercantil;
        $contrato->num_instrumento = $request->num_instrumento;
        $contrato->vol_instrumento = $request->vol_instrumento;
        $contrato->fecha_instrumento = $request->fecha_instrumento;
        $contrato->nombre_notario = $request->nombre_notario;
        $contrato->num_notario = $request->num_notario;
        $contrato->estado_notario = $request->estado_notario;
        $contrato->num_permiso = $request->num_permiso;
        $contrato->save();

        $numeroCliente = EmpresaNumCliente::where('id_empresa', $request->id_empresa)->first();
        if ($numeroCliente) {
            $numeroCliente->numero_cliente = $request->numero_cliente;
            $numeroCliente->save();
        }

        return response()->json(['success' => 'Cliente confirmado actualizado con éxito.']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al actualizar los registros: ' . $e->getMessage()], 500);
    }
}

}
