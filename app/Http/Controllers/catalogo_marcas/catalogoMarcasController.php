<?php

namespace App\Http\Controllers\catalogo_marcas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\empresa;
use App\Models\catalogoMarca;

class catalogoMarcasController extends Controller
{
    //
    public function catalogoMarcas()
    {
        // Obtener empresas de tipo 2
        $clientes = empresa::where('tipo', 2)->get();

        // Obtener el catálogo de marcas
        $opciones = catalogoMarca::all();

        // Pasar los datos a la vista
        return view('catalogo.catalogo_marcas_view', compact('opciones', 'clientes'));
    }
}
