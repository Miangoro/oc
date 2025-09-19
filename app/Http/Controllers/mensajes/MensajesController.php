<?php

namespace App\Http\Controllers\mensajes;

use App\Http\Controllers\Controller;
use App\Models\mensajes_dashboard;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class MensajesController extends Controller
{

  // Mostrar la vista de administración
public function UserManagement()
{
    $user = Auth::user();
    $userId = $user->id;

    $mensajes = mensajes_dashboard::where('activo', 1)
        ->where(function($query) use ($userId) {
            $query->whereNull('id_usuario_destino') // globales
                  ->orWhere('id_usuario_destino', $userId); // personalizados
        })
        ->orderBy('orden')
        ->get();

    // Usuarios disponibles (excluyendo tipo 3)
    $usuarios = User::where('tipo', '!=', 3)->get();

    return view('mensajes.find_mensajes_dashboard_view', [
        'mensajes' => $mensajes,
        'tipo_usuario' => $user->tipo,
        'usuarios' => $usuarios
    ]);
}



    // Obtener los mensajes activos para el dashboard del usuario
    public function index(Request $request)
    {
        $columns = [
            1 => 'id',
            2 => 'id_usuario_destino',
            3 => 'id_usuario_registro',
            4 => 'titulo',
            5 => 'tipo_titulo',
            6 => 'mensaje',
            7 => 'tipo',
            8 => 'orden',
            9 => 'activo',
        ];
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
        $search = $request->input('search.value');

        // 👇 Filtro según si es admin o usuario normal
        if (auth()->id() == 1) {
            $query = mensajes_dashboard::query(); // Admin ve todos
        } else {
            $query = mensajes_dashboard::where(function ($q) {
                $q->where('id_usuario_destino', auth()->id())
                  ->orWhereNull('id_usuario_destino') // mensajes globales
                  ->orWhere('id_usuario_destino', 0);
            });
        }

        $totalData = $query->count();
        $totalFiltered = $totalData;

        // Si hay búsqueda
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('mensaje', 'LIKE', "%{$search}%")
                  ->orWhere('titulo', 'LIKE', "%{$search}%")
                  ->orWhereHas('usuarioDestino', function ($sub) use ($search) {
                      $sub->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('usuarioRegistro', function ($sub) use ($search) {
                      $sub->where('name', 'LIKE', "%{$search}%");
                  });
            });

            $totalFiltered = $query->count();
        }

        $users = $query->offset($start)
                      ->limit($limit)
                      ->orderBy($order, $dir)
                      ->get();

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id'] = $user->id; // Ajusta el nombre de la columna según tu base de datos
                $nestedData['fake_id'] = ++$ids;
                $nestedData['usuario_registro'] = $user->usuarioRegistro->name ? $user->usuarioRegistro->name  : 'Global'; // Ajusta el nombre de la columna según tu base de datos
                $nestedData['usuario_destino'] = $user->usuarioDestino->name ? $user->usuarioDestino->name  : 'Global';
                $nestedData['titulo'] = $user->titulo; // Ajusta el nombre de la columna según tu base de datos
                $nestedData['tipo_titulo'] = $user->tipo_titulo; // Ajust
                $nestedData['mensaje'] = $user->mensaje; // Ajusta el nombre de la columna según tu base de datos
                $nestedData['tipo'] = $user->tipo; // Ajusta el nombre de la columna según tu base de datos
                $nestedData['orden'] = $user->orden; // Ajusta el nombre de la columna según tu base de datos
                /* $nestedData['estatus'] = $user->activo; */ // Ajusta el nombre de la columna según tu base de datos
                $nestedData['estatus'] = $user->activo == 1 ? 'Activo' : 'Desactivado';
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

      public function store(Request $request)
  {
      // Validar los datos
      $request->validate([
          'id_usuario_destino' => 'nullable|exists:users,id', // puede ser null = global
          'titulo'            => 'nullable|string|max:250',
          'tipo_titulo'               => 'required|string|max:50',
          'mensaje'            => 'required|string|max:500',
          'tipo'               => 'required|string|max:50',
          'orden'              => 'nullable|integer',
      ]);

      try {
          $mensaje = new mensajes_dashboard();
          $mensaje->id_usuario_destino = $request->id_usuario_destino ?: null; // null = global
          $mensaje->titulo             = $request->titulo;
          $mensaje->tipo_titulo        = $request->tipo_titulo;
          $mensaje->mensaje            = $request->mensaje;
          $mensaje->tipo               = $request->tipo;
          $mensaje->activo             = 1; // por defecto activo
          $mensaje->orden              = $request->orden ?: 0;
          $mensaje->id_usuario_registro = Auth::id(); // el usuario que lo registró
          $mensaje->save();

          return response()->json([
              'success' => true,
              'message' => 'Mensaje creado correctamente',
              'data'    => $mensaje
          ]);
      } catch (\Exception $e) {
          return response()->json([
              'success' => false,
              'message' => 'Error al guardar el mensaje',
              'error'   => $e->getMessage()
          ], 500);
      }
  }


    // Para editar un mensaje
    public function edit($id)
    {
        $mensaje = mensajes_dashboard::findOrFail($id);
        return response()->json($mensaje);
    }

public function update(Request $request, $id)
{
    $request->validate([
        'id_usuario_destino' => 'nullable|exists:users,id', // puede ser null = global
        'titulo'            => 'nullable|string|max:250',
        'tipo_titulo'               => 'required|string|max:50',
        'mensaje'            => 'required|string|max:500',
        'tipo'               => 'required|string|max:50',
        'orden'              => 'nullable|integer',
    ]);

    $mensaje = mensajes_dashboard::findOrFail($id);
    $mensaje->id_usuario_destino = $request->id_usuario_destino ?: null;
    $mensaje->titulo             = $request->titulo;
    $mensaje->tipo_titulo        = $request->tipo_titulo;
    $mensaje->mensaje            = $request->mensaje;
    $mensaje->tipo               = $request->tipo;
    $mensaje->activo             = $request->has('activo') && $request->activo ? 1 : 0;
    $mensaje->orden              = $request->orden;
    $mensaje->id_usuario_registro = Auth::id();
    $mensaje->save();

    return response()->json([
        'success' => true,
        'message' => 'Mensaje actualizado correctamente',
        'mensaje' => $mensaje
    ]);
}

    // Para eliminar un mensaje
    public function destroy($id)
    {
        $mensaje = mensajes_dashboard::findOrFail($id);
        $mensaje->delete();

        return response()->json(['success' => true, 'message' => 'Mensaje eliminado correctamente']);
    }
}
