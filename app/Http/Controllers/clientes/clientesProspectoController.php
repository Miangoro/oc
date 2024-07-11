<?php

namespace App\Http\Controllers\clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\empresa;
use App\Models\solicitud_informacion;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class clientesProspectoController extends Controller
{
    public function UserManagement()
  {
    // dd('UserManagement');
    $empresas = empresa::all();
    $userCount = $empresas->count();
    $verified = 5;
    $notVerified = 10;
    $usersUnique = $empresas->unique(['estado']);
    $userDuplicates = 40;

    return view('clientes.find_clientes_prospecto_view', [
      'totalUser' => $userCount,
      'verified' => $verified,
      'notVerified' => $notVerified,
      'userDuplicates' => $userDuplicates,
    ]);
  }

  public function info($id)
    {   
      $res = DB::select('SELECT s.medios, s.competencia, s.capacidad, s.comentarios, e.representante, e.razon_social, fecha_registro, info_procesos, s.fecha_registro, e.correo, e.telefono, p.id_producto, n.id_norma, a.id_actividad,
      e.calle, e.num, e.colonia, e.municipio, e.estado, e.cp
      FROM empresa e 
      JOIN solicitud_informacion s ON (e.id_empresa = s.id_empresa) 
      JOIN empresa_producto_certificar p ON (p.id_empresa = e.id_empresa)
      JOIN empresa_norma_certificar n ON (n.id_empresa = e.id_empresa)
      JOIN empresa_actividad_cliente a ON (a.id_empresa = e.id_empresa)
      WHERE e.id_empresa='.$id);
        $pdf = Pdf::loadView('pdfs.SolicitudInfoCliente',['datos'=>$res]);
        return $pdf->stream('F7.1-01-02  Solicitud de Información del Cliente NOM-070-SCFI-2016 y NMX-V-052-NORMEX-2016 Ed.pdf');
    }

  public function registrarValidacion(Request $request){
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
      2 => 'razon_social',
      3 => 'domicilio_fiscal',
      4 => 'regimen',
    ];

    $search = [];

    $totalData = empresa::count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = empresa::offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $users = empresa::where('id_empresa', 'LIKE', "%{$search}%")
        ->orWhere('razon_social', 'LIKE', "%{$search}%")
        ->orWhere('domicilio_fiscal', 'LIKE', "%{$search}%")
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = empresa::where('id_empresa', 'LIKE', "%{$search}%")
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
}
