<?php

namespace App\Http\Controllers\solicitudCliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class solicitudClienteController extends Controller
{
    public function index()
    {
      return view('solicitudes.solicitudCliente');
    }

    public function RegistroExitoso(){
      return view('solicitudes.Registro_exitoso');
    }
}



