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
                return response()->json(['success' => true], 200, ['Content-Type' => 'application/json']);
            }

            return response()->json(['success' => true], 200, ['Content-Type' => 'application/json']);

        }

}
