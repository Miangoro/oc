<?php

namespace App\Http\Controllers\clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\empresa;
use App\Models\empresaContrato;
use App\Models\empresaNumCliente;
use App\Models\solicitud_informacion;
use App\Models\User;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\marcas;

class clientesProspectoController extends Controller
{

  public function UserManagement() {
    // dd('UserManagement');
    $usuarios = User::where("tipo",1)->get();
    // $userCount = $empresas->count();
    $empresas = empresa::with('normas')->get();
    $verified = 5;
    $notVerified = 10;
    // $usersUnique = $empresas->unique(['estado']);
    $userDuplicates = 40;
    return view('clientes.find_clientes_prospecto_view', [
      'verified' => $verified,
      'notVerified' => $notVerified,
      'userDuplicates' => $userDuplicates,
      'usuarios' => $usuarios,
      'empresas' => $empresas,
    ]);

  }


/*   public function aceptarCliente(Request $request) {

      for ($i = 0; $i < count($request->numero_cliente); $i++) {
          $cliente = empresaNumCliente::where('id_empresa', $request->id_empresa)
              ->where('id_norma', $request->id_norma[$i])
              ->first();

          if ($cliente) {
              // Actualiza
              $cliente->numero_cliente = $request->numero_cliente[$i];
              $cliente->save();
          } else {
              // Crea nuevo
              $nuevo = new empresaNumCliente();
              $nuevo->id_empresa = $request->id_empresa;
              $nuevo->id_norma = $request->id_norma[$i];
              $nuevo->numero_cliente = $request->numero_cliente[$i];
              $nuevo->save();
          }
      }

        $contrato = new empresaContrato();
        $contrato->id_empresa = $request->id_empresa;
        $contrato->fecha_cedula = $request->fecha_cedula;
        $contrato->idcif = $request->idcif;
        $contrato->clave_ine = $request->clave_ine;
        $contrato->sociedad_mercantil = $request->sociedad_mercantil;
        $contrato->num_instrumento = $request->	num_instrumento;
        $contrato->vol_instrumento = $request->vol_instrumento;
        $contrato->fecha_instrumento = $request->fecha_instrumento;
        $contrato->num_notario = $request->num_notario;
        $contrato->num_permiso = $request->num_permiso;
        $contrato->nombre_notario = $request->nombre_notario;
        $contrato->estado_notario = $request->estado_notario;
        $contrato->save();

        $empresa = empresa::find($request->id_empresa);
        $empresa->tipo = 2;
        $empresa->id_contacto = $request->id_contacto;
        $empresa->update();

      return response()->json('Validada');
  }
 */

public function aceptarCliente(Request $request) {
    DB::transaction(function() use ($request) {
        for ($i = 0; $i < count($request->numero_cliente); $i++) {
            $cliente = empresaNumCliente::where('id_empresa', $request->id_empresa)
                ->where('id_norma', $request->id_norma[$i])
                ->first();

            if ($cliente) {
                // Actualiza
                $cliente->numero_cliente = $request->numero_cliente[$i];
                $cliente->save();
            } else {
                // Crea nuevo
                empresaNumCliente::create([
                    'id_empresa' => $request->id_empresa,
                    'id_norma' => $request->id_norma[$i],
                    'numero_cliente' => $request->numero_cliente[$i],
                ]);
            }
        }

        empresaContrato::updateOrCreate(
            ['id_empresa' => $request->id_empresa],
            [
                'fecha_cedula' => $request->fecha_cedula,
                'idcif' => $request->idcif,
                'clave_ine' => $request->clave_ine,
                'sociedad_mercantil' => $request->sociedad_mercantil,
                'num_instrumento' => $request->num_instrumento,
                'vol_instrumento' => $request->vol_instrumento,
                'fecha_instrumento' => $request->fecha_instrumento,
                'num_notario' => $request->num_notario,
                'num_permiso' => $request->num_permiso,
                'nombre_notario' => $request->nombre_notario,
                'estado_notario' => $request->estado_notario,
            ]
        );

        $empresa = empresa::find($request->id_empresa);
        $empresa->tipo = 2;
        $empresa->id_contacto = $request->id_contacto;
        $empresa->save();
    });

    return response()->json('Validada');
}

  //funcion para el pdf de la solicitud de información del cliente
public function info($id) {
    $res = DB::select('
    SELECT
        p.id_producto,
        nc.id_norma,
        a.id_actividad,
        s.medios,
        s.competencia,
        s.capacidad,
        s.id_revisor,
        u.name AS nombre_revisor,
        u.puesto AS puesto_revisor,
        u.firma AS firma_revisor,
        s.comentarios,
        e.representante,
        e.razon_social,
        e.cp,
        e.domicilio_fiscal,
        s.fecha_registro,
        s.info_procesos,
        e.correo,
        e.telefono,
        i.direccion_completa
    FROM empresa e
    LEFT JOIN solicitud_informacion s
        ON e.id_empresa = s.id_empresa
    LEFT JOIN users u
        ON u.id = s.id_revisor
    LEFT JOIN empresa_producto_certificar p
        ON p.id_empresa = e.id_empresa
    LEFT JOIN empresa_num_cliente nc
        ON nc.id_empresa = e.id_empresa
    LEFT JOIN catalogo_norma_certificar n
        ON n.id_norma = nc.id_norma
    LEFT JOIN empresa_actividad_cliente a
        ON a.id_empresa = e.id_empresa
        LEFT JOIN instalaciones i
        ON i.id_empresa = e.id_empresa
    WHERE e.id_empresa = ?

', [$id]);

    $pdf = Pdf::loadView('pdfs.SolicitudInfoCliente', ['datos' => $res]);
  return $pdf->stream('F7.1-01-02  Solicitud de Información del Cliente NOM-070-SCFI-2016 y NMX-V-052-NORMEX-2016 Ed.pdf');
  }


  public function registrarValidacion(Request $request) {
    $solicitud = solicitud_informacion::find($request->id_solicitud);
    $solicitud->medios = $request->medios;
    $solicitud->competencia = $request->competencia;
    $solicitud->capacidad =  $request->capacidad;
    $solicitud->comentarios =  $request->comentarios;

    $solicitud->update();
  }


  public function store(Request $request)  {

    $solicitud = solicitud_informacion::where('id_empresa', $request->id_empresa)->first();
    $solicitud->medios = $request->medios;
    $solicitud->competencia = $request->competencia;
    $solicitud->capacidad =  $request->capacidad;
    $solicitud->comentarios =  $request->comentarios;
    $solicitud->id_revisor = Auth::id();
    $solicitud->update();
    // user created
    return response()->json('Validada');
  }

  public function index(Request $request) {
    $columns = [
    1 => 'id_empresa',
    2 => 'razon_social',
    3 => 'domicilio_fiscal',
    4 => 'regimen',
    ];

    $search = [];

    $totalData = empresa::where('tipo', 1)->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = empresa::with('normas')->where('tipo', 1)->offset($start)
      ->limit($limit)
      ->orderBy($order, $dir)
      ->get();
    } else {
      $search = $request->input('search.value');

      $users = empresa::where('tipo', 1)->where('id_empresa', 'LIKE', "%{$search}%")
      ->orWhere('razon_social', 'LIKE', "%{$search}%")
      ->orWhere('domicilio_fiscal', 'LIKE', "%{$search}%")
      ->offset($start)
      ->limit($limit)
      ->orderBy($order, $dir)
      ->get();

      $totalFiltered = empresa::where('tipo', 1)->where('id_empresa', 'LIKE', "%{$search}%")
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
       /*  $nestedData['normas'] = $user->normas; */ // Agrega las normas a los datos
      $nestedData['normas'] = $user->normas->map(function ($norma) {
    return ['norma' => $norma->norma];
})->values();



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


  public function edit($id) {
    try {
      $prospectos = empresa::findOrFail($id);
      return response()->json($prospectos);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al obtener el cliente'], 500);
    }
  }


  public function update(Request $request, $id) {
    // Validar los datos del formulario
    $request->validate([
    'nombre_cliente' => 'required|string|max:255',
    'regimen' => 'required|string',
    'domicilio_fiscal' => 'required|string|max:255',
    ]);
    try {
      // Buscar el cliente por ID
      $empresa = empresa::findOrFail($id);
      // Actualizar los datos del cliente
      $empresa->razon_social = $request->nombre_cliente;
      $empresa->regimen = $request->regimen;
      $empresa->domicilio_fiscal = $request->domicilio_fiscal;
      // Guardar los cambios
      $empresa->save();
      return response()->json(['message' => 'Cliente actualizado con éxito']);
    } catch (\Exception $e) {
      return response()->json(['error' => 'Error al actualizar el cliente'], 500);
    }
  }


/*   public function pdfNOM199($id) {
    $pdf = Pdf::loadView('pdfs.solicitudInfoClienteNOM-199');
    return $pdf->stream('solicitud_Info_ClienteNOM-199.pdf');
  } */
 public function pdfNOM199($id)
{
    // Traer la empresa (o solicitud) con sus datos
    $empresa = empresa::findOrFail($id);

    $pdf = Pdf::loadView('pdfs.solicitudInfoClienteNOM-199', [
        'empresa' => $empresa
    ]);

    return $pdf->stream('solicitud_Info_ClienteNOM-199.pdf');
}


public function registrarClientes(Request $request)
{
    $validated = $request->validate([
        'regimen'             => 'required|string|max:100',
        'razon_social'        => 'required|string|max:255',
        'correo'              => 'nullable|email|max:255',
        'telefono'            => 'nullable|string|max:20',
        'representante_legal' => 'nullable|string|max:255',
        'domicilio_fiscal'    => 'required|string|max:255',
    ]);

    try {
        $empresa = new empresa();
        $empresa->razon_social     = $validated['razon_social'];
        $empresa->regimen          = $validated['regimen'];
        $empresa->correo           = $validated['correo'] ?? null;
        $empresa->telefono         = $validated['telefono'] ?? null;
        $empresa->representante    = $validated['representante_legal'] ?? 'No aplica';
        $empresa->domicilio_fiscal = $validated['domicilio_fiscal'];
        $empresa->tipo             = 1; // 1 = Prospecto
        $empresa->estatus          = 1; // opcional si tienes campo estatus
        $empresa->save();

        return response()->json([
            'success' => true,
            'message' => 'Cliente prospecto registrado correctamente',
            'data' => $empresa
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al registrar el cliente prospecto',
            'error'   => $e->getMessage()
        ], 500);
    }
}


public function registrarDocumentos(Request $request, $id)
    {
        $prospecto = empresa::findOrFail($id);
        $documentos = $request->allFiles();

        foreach ($documentos as $inputName => $file) {
            if ($request->hasFile($inputName)) {
                // Generar un nombre único para el archivo
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Definir la ruta de almacenamiento específica para el prospecto
                $path = $file->storeAs('documentos_prospectos/' . $prospecto->id_empresa, $fileName, 'public');

                // Aquí necesitarás una tabla para guardar la referencia de los documentos.
                // Por ejemplo, una tabla `empresa_documentos` con `id_empresa`, `tipo_documento`, `ruta_archivo`.
                // DB::table('empresa_documentos')->insert([
                //     'id_empresa' => $prospecto->id_empresa,
                //     'tipo_documento' => $inputName, // ej: 'doc_acta_constitutiva'
                //     'ruta_archivo' => $path,
                //     'created_at' => now(),
                //     'updated_at' => now(),
                // ]);
            }
        }

        return response()->json(['message' => 'Documentos subidos con éxito'], 200);
    }


}
