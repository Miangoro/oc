<?php

namespace App\Http\Controllers\usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsuariosInspectoresController extends Controller
{
       /**
   * Redirecciona a la vista de usuarios inspectores.
   *
   */
  public function inspectores()
  {
   

    return view('usuarios.find_usuarios_inspectores_view');
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
        $pdf = Pdf::loadView('pdfs.AsignacionUsuario',['datos'=>$res,'dia'=>$dia,'mes'=>$mes,'anio'=>$anio]);
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

    ];

    $search = [];

    $users_temp = User::where("tipo",2)->get();
    $totalData = $users_temp->count();

    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    if (empty($request->input('search.value'))) {
      $users = User::where("tipo",2)->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();
    } else {
      $search = $request->input('search.value');

      $users = User::where('id', 'LIKE', "%{$search}%")
        ->where("tipo",3)
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        
        ->offset($start)
        ->limit($limit)
        ->orderBy($order, $dir)
        ->get();

      $totalFiltered = User::where('id', 'LIKE', "%{$search}%")
        ->where("tipo",2)
        ->orWhere('name', 'LIKE', "%{$search}%")
        ->orWhere('email', 'LIKE', "%{$search}%")
        
        ->count();
    }

    $data = [];

    if (!empty($users)) {
      // providing a dummy id instead of database ids
      $ids = $start;

      foreach ($users as $user) {
        $nestedData['id'] = $user->id;
        $nestedData['fake_id'] = ++$ids;
        $nestedData['name'] = $user->name;
        $nestedData['email'] = $user->email ;
        $nestedData['password_original'] = $user->password_original ;
        $nestedData['razon_social'] = 'No aplica';
        $nestedData['foto_usuario'] = $user->profile_photo_path ?? '';

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
        ['name' => $request->name, 'email' => $request->email]
      );

      // user updated
      return response()->json('Modificado');
    } else {
      // create new one if email is unique
      $userEmail = User::where('email', $request->email)->first();

      $pass = Str::random(10);

      if (empty($userEmail)) {
        $users = User::updateOrCreate(
          ['id' => $userID],
          ['name' => $request->name, 'email' => $request->email, 'password_original' => $pass, 'password' => bcrypt($pass),'tipo'=>2]
        );

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
    $user = User::findOrFail($id);
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
}
