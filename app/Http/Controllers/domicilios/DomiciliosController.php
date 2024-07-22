<?php

namespace App\Http\Controllers\domicilios;

use App\Http\Controllers\Controller;
use App\Models\Instalaciones;
use App\Models\Empresa;
use Illuminate\Http\Request;

class DomiciliosController extends Controller
{

  public function UserManagement()
  {
      $instalaciones = Instalaciones::all(); // Obtener todas las instalaciones

      return view('domicilios.find_domicilio_instalaciones_view', compact('instalaciones'));
  }
}
