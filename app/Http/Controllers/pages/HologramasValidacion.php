<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HologramasValidacion extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.pages.pages-hologramas-validacion', ['pageConfigs' => $pageConfigs]);
  }

  public function validar_dictamen()
  {
    
    return view('content.pages.visualizador_dictamen_qr');
  }
}
