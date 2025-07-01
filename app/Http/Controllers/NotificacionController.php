<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
        public function marcarNotificacionLeida($id)
        {
            $notification =Auth::user()->unreadNotifications->where('id', $id)->first();

            if ($notification) {
                $notification->markAsRead();
                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Notificación no encontrada.'], 404);

        }

        public function marcarTodasComoLeidas()
        {
            $user = Auth::user();

            if ($user) {
                $user->unreadNotifications->markAsRead();
                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Usuario no autenticado.'], 401);
        }

}
