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
use App\Models\Dictamen_instalaciones;
use App\Models\Certificados;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class resumenController extends Controller {

  public function UserManagement() {
    // Obtener todas las empresas con sus clientes
    $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get();
    
  // Pasar las empresas a la vista
  return view('clientes.find_resumen_clientes', compact('empresas'));
  }



  // FUNCION CARGAR DATOS DE EMPRESA
  public function DatosEmpresa($id_empresa) {
    //relacion (marcas, instalaciones, usuarios)
    $empresa = empresa::with(['marcas', 'instalaciones', 'users'])
                      ->where('id_empresa', $id_empresa)
                      ->first();

    // Cargar los lotes manualmente
    $empresa->lotes_granel = LotesGranel::where('id_empresa', $id_empresa)->get();
    $empresa->lotes_envasado = lotes_envasado::where('id_empresa', $id_empresa)->get();
    // Cargar las marcas asociadas a cada lote_envasado
    foreach ($empresa->lotes_envasado as $lote) {
      $lote->marca = marcas::find($lote->id_marca); //Asignamos la marca al lote
    }

    // Cargar el dictamen más reciente para cada instalación
    foreach ($empresa->instalaciones as $instalacion) {
      // Obtener el dictamen más reciente que esté vigente
      $dictamen = Dictamen_instalaciones::where('id_instalacion', $instalacion->id_instalacion)
          ->where('fecha_emision', '<=', now()) // Fecha emisión menor o igual al día actual
          ->where('fecha_vigencia', '>=', now()) // Fecha vigencia mayor o igual al día actual
          ->orderByDesc('id_dictamen')
          ->first(); // Obtener el primer dictamen (el más reciente)
      $instalacion->dictamen = $dictamen; //Asignar el dictamen a la instalación

      
      if ($dictamen) {
        // Cargar el certificado relacionado con el dictamen
        $certificado = Certificados::where('id_dictamen', $dictamen->id_dictamen)->first();
        $instalacion->certificado = $certificado; // Asignamos el certificado al dictamen
      }
    }


  // Retornar los datos en formato JSON
  return response()->json($empresa);
  }
 
  


}//end-Controller
