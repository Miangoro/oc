<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\lotesGranel;
use App\Models\empresa;
use App\Models\categorias;
use App\Models\clases;
use App\Models\Tipo;
use App\Models\Organismo;


class lotesGranelController extends Controller
{
    public function UserManagement(Request $request)
    {
       
    
        return view('catalogo.lotes_granel');
    }
    
}
    