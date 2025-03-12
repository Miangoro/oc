<?php

namespace App\Http\Controllers\clientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\empresa;
use App\Models\empresaNumCliente;
use App\Models\User;
use App\Models\LotesGranel;
use App\Models\lotes_envasado;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class resumenController extends Controller
{

  public function UserManagement() {
      // Obtener todas las empresas
      //$empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get();
    $id_empresa = 4;
    $empresa = empresa::with(['marcas', 'instalaciones', 'users'])->where('id_empresa', $id_empresa)->first();

    //cargar los lotes manualmente
    $empresa->lotes_granel = LotesGranel::where('id_empresa', $id_empresa)->get();
    $empresa->lotes_envasado = lotes_envasado::where('id_empresa', $id_empresa)->get();

      return view("clientes.find_resumen_clientes", ['empresa' => $empresa]);
  }

 
  

}
