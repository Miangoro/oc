<?php

namespace App\Http\Controllers\mensajes;

use App\Http\Controllers\Controller;
use App\Models\mensajes_dashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MensajesController extends Controller
{

    // Mostrar la vista de administración
    public function UserManagement()
    {
        return view('mensajes.find_mensajes_dashboard_view');
    }

    // Obtener los mensajes activos para el dashboard del usuario
    public function index()
    {
        $userId = Auth::id();

        $mensajes = mensajes_dashboard::where('activo', 1)
            ->where(function($query) use ($userId) {
                $query->whereNull('id_usuario_destino') // globales
                      ->orWhere('id_usuario_destino', $userId); // personalizados
            })
            ->orderBy('orden')
            ->get();

        return view('dashboard.mensajes', compact('mensajes'));
    }

    // Para editar un mensaje
    public function edit($id)
    {
        $mensaje = mensajes_dashboard::findOrFail($id);
        return response()->json($mensaje);
    }

    // Para actualizar un mensaje
    public function update(Request $request, $id)
    {
        $request->validate([
            'mensaje' => 'required|string|max:255',
            'orden' => 'nullable|integer',
        ]);

        $mensaje = mensajes_dashboard::findOrFail($id);
        $mensaje->mensaje = $request->mensaje;
        $mensaje->orden = $request->orden ?? $mensaje->orden;
        $mensaje->save();

        return response()->json(['success' => true, 'message' => 'Mensaje actualizado correctamente']);
    }

    // Para eliminar un mensaje
    public function destroy($id)
    {
        $mensaje = mensajes_dashboard::findOrFail($id);
        $mensaje->delete();

        return response()->json(['success' => true, 'message' => 'Mensaje eliminado correctamente']);
    }
}
