<?php

namespace App\Http\Controllers\clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\empresa;
use App\Models\empresaContrato;
use App\Models\empresaNumCliente;
use App\Models\solicitud_informacion;
use App\Models\User;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

use App\Models\marcas;

class resumenController extends Controller
{

  public function UserManagement() {
  
    $id_empresa = 22;

    $empresa = empresa::with(['marcas', 'instalaciones', 'users'])->where('id_empresa', $id_empresa)->first();

    return view("clientes.find_resumen_clientes", ["empresa" => $empresa]);
}
  

}
