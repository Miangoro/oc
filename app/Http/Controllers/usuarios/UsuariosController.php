<?php

namespace App\Http\Controllers\usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\empresa;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\instalaciones;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Exports\UsuariosExport;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class UsuariosController extends Controller
{


    /**
   *Redirecciona a la vista de usuarios clientes.
   *
   */
  public function UserManagement()
  {
    $empresas = empresa::where('tipo', 2)->get();
    // dd('UserManagement');
    //$usuarios = User::where("tipo",1)->get();
    $usuarios = User::where('tipo', 1)
        ->where('id', '!=', 1)
        ->where('estatus', '!=', 'Inactivo')
        ->get();
    $users = User::where('tipo', 3)->get();
    $userCount = $users->count();
    $verified = User::whereNotNull('email_verified_at')->get()->count();
    $notVerified = User::whereNull('email_verified_at')->get()->count();
    $usersUnique = $users->unique(['email']);
    $userDuplicates = $users->diff($usersUnique)->count();
    //$roles = Role::All();
    $roles = Role::where('id', '!=', 1)->get();

    return view('usuarios.find_usuarios_clientes_view', [
      'totalUser' => $userCount,
      'verified' => $verified,
      'notVerified' => $notVerified,
      'userDuplicates' => $userDuplicates,
      'empresas' => $empresas,
      'users' => $users,
      'usuarios' => $usuarios,
      'roles' => $roles
    ]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

   public function pdfAsignacionUsuario($id)
    {     Carbon::setLocale('es'); // Establece la localización a español
        $currentDate = Carbon::now();

    // Obtener el día
    $dia = $currentDate->day;
    $mes = $currentDate->translatedFormat('F');
    $anio = $currentDate->year;
        $res = User::with('empresa')->where('id', $id)->first();
        $id_contacto = $res->id_contacto ?? '0';
        $contacto = User::find($id_contacto);

        $pdf = Pdf::loadView('pdfs.AsignacionUsuario',[
          'datos'=>$res,
          'contacto'=>$contacto ?? null,
          'dia'=>$dia,
          'mes'=>$mes,
          'anio'=>$anio,
        ]);
        return $pdf->stream('F7.1-01-46 Carta de asignación de usuario y contraseña para plataforma del OC Ed. 0, Vigente.pdf');
    }


  public function index(Request $request)
  {
    $columns = [
      1 => 'id',
      2 => 'name',
      3 => 'email',
      4 => 'email_verified_at',
      5 => 'razon_social',
      6 => 'rol',
      7 => 'rol',

    ];

    $search = [];

    $users_temp = User::with('empresa')->where("tipo",3)->get();
    $totalData = $users_temp->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = User::with('empresa.empresaNumClientes')
      ->where("tipo", 3)
      ->whereHas('empresa.empresaNumClientes', function ($query) {
          $query->orderByRaw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(numero_cliente, '-', -2), 'C', 1) AS UNSIGNED) DESC");
      })
      ->orderByRaw("CASE WHEN estatus = 'Activo' THEN 0 ELSE 1 END") // Activos primero
      ->offset($start)
      ->limit($limit)

      ->get();


    } else {
      $search = $request->input('search.value');

      $users = User::with('empresa.empresaNumClientes','roles')
      ->where(function ($query) use ($search) {
          $query->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhereHas('empresa', function ($subQuery) use ($search) {
                  $subQuery->where('razon_social', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('empresa.empresaNumClientes', function ($subQuery) use ($search) {
                $subQuery->where('numero_cliente', 'LIKE', "%{$search}%");
            });
      })
      ->where('tipo', 3) // Asegura que 'tipo' sea siempre 3
      ->offset($start)
      ->limit($limit)
      ->orderBy($order, $dir)
      ->get();


      $totalFiltered = User::with('empresa')->where('id', 'LIKE', "%{$search}%")
        ->where("tipo",3)
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        ->orWhereHas('empresa', function ($query) use ($search) {
            $query->where('razon_social', 'LIKE', "%{$search}%");
        })
        ->orWhereHas('empresa.empresaNumClientes', function ($subQuery) use ($search) {
          $subQuery->where('numero_cliente', 'LIKE', "%{$search}%");
        })
        ->count();
    }

    $data = [];

    if (!empty($users)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($users as $user) {
        $instalacionesTexto = 'Sin instalación';
        if (!empty($user->id_instalacion) && is_array($user->id_instalacion)) {
          $instalaciones = instalaciones::whereIn('id_instalacion', $user->id_instalacion)->get();
$instalacionesTexto = '<table class="table table-sm mb-0">';
foreach ($instalaciones as $inst) {
    $instalacionesTexto .= "<tr>
        <td>{$inst->direccion_completa}</td>
    </tr>";
}
$instalacionesTexto .= '</table>';

        }

        $nestedData['instalacionesTexto'] = $instalacionesTexto;
        $nestedData['id'] = $user->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $user->name;
        $nestedData['contacto'] = optional(User::find($user->id_contacto))->name ?? '';
        $nestedData['email'] = $user->email ;
        $nestedData['telefono'] = $user->telefono;
        $nestedData['password_original'] = $user->password_original ;
        $nestedData['rol'] = $user->roles[0]->name ?? '';
        $empresa = $user->empresa;
          $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
          ? $empresa->empresaNumClientes
              ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
          : 'N/A';
        $nestedData['numero_cliente'] = $numero_cliente;
         $nestedData['estatus'] = $user->estatus;
        $nestedData['razon_social'] = $user->empresa->razon_social ;

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

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */


  public function store(Request $request)
  {
    $userID = $request->id;

    if ($userID) {
        // update the value
        $users = User::updateOrCreate(
          ['id' => $userID],
          ['name' => $request->name, 'email' => $request->email,
          'telefono' => $request->telefono, 'id_contacto' => $request->id_contacto,
          'id_empresa' => $request->id_empresa,
          'estatus' => $request->estatus,
          'id_instalacion' => $request->id_instalacion, ]
        );
        $users->syncRoles($request->rol_id);
        // user updated
        return response()->json('Modificado');
    } else {
        // create new one if email is unique
        $userEmail = User::where('email', $request->email)->first();

        $pass = Str::random(10);

        if (empty($userEmail)) {
          $users = User::updateOrCreate(
            ['id' => $userID],
            ['name' => $request->name, 'email' => $request->email,
            'telefono' => $request->telefono, 'id_contacto' => $request->id_contacto,
            'estatus' => $request->estatus,
            'password_original' => $pass, 'password' => bcrypt($pass), 'id_empresa' => $request->id_empresa,'tipo'=>3,
            'id_instalacion' => $request->id_instalacion, ]
          );

          $users->syncRoles($request->rol_id);

          // user created
          return response()->json('Registrado');
        } else {
          // user already exist
          return response()->json(['message' => "ya existe"], 422);
        }
    }
  }



  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
public function edit($id): JsonResponse
{
    $user = User::with('roles')->findOrFail($id);
    return response()->json($user);
}

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $users = User::where('id', $id)->delete();
  }


    public function exportar(Request $request)
    {
        $filtros = $request->all();
        return Excel::download(new UsuariosExport($filtros), 'usuarios.xlsx');
    }


}
