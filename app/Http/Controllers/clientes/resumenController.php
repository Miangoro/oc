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
use App\Models\marcas;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class resumenController extends Controller
{
  /*
  public function UserManagement() {
    //$empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get();
    $id_empresa = 4;
    $empresa = empresa::with(['marcas', 'instalaciones', 'users'])->where('id_empresa', $id_empresa)->first();

    //cargar los lotes manualmente
    $empresa->lotes_granel = LotesGranel::where('id_empresa', $id_empresa)->get();
    $empresa->lotes_envasado = lotes_envasado::where('id_empresa', $id_empresa)->get();

    return view("clientes.find_resumen_clientes", ['empresa' => $empresa]);
  }
  */

  public function UserManagement() {
    // Obtener todas las empresas con sus clientes
    $empresas = Empresa::with('empresaNumClientes')->where('tipo', 2)->get();
    
    // Pasar las empresas a la vista
    return view('clientes.find_resumen_clientes', compact('empresas'));
  }

  // Método para cargar los datos de una empresa
  public function DatosEmpresa($id_empresa) {
    // Obtener la empresa con las relaciones (marcas, instalaciones, usuarios)
    $empresa = Empresa::with(['marcas', 'instalaciones', 'users'])
                      ->where('id_empresa', $id_empresa)
                      ->first();

    // Cargar los lotes manualmente
    $empresa->lotes_granel = LotesGranel::where('id_empresa', $id_empresa)->get();
    $empresa->lotes_envasado = lotes_envasado::where('id_empresa', $id_empresa)->get();

    // Cargar las marcas asociadas a cada lote_envasado
    foreach ($empresa->lotes_envasado as $lote) {
      $lote->marca = marcas::find($lote->id_marca); // Asignamos la marca correspondiente al lote
    }

    // Retornar los datos de la empresa en formato JSON
    return response()->json($empresa);
  }
 
  

}
