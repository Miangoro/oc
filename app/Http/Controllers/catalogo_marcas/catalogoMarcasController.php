<?php

namespace App\Http\Controllers\catalogo_marcas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\empresa;
use App\Models\catalogoMarca;
use App\Models\catalogoMarcas;

class catalogoMarcasController extends Controller
{
    //
    public function catalogoMarcas()
    {
        $opciones = catalogoMarca::all();

      return view('catalogo.catalogo_marcas_view', compact('opciones'));
    }



}
