<?php

namespace App\Http\Controllers\documentacion;

use App\Http\Controllers\Controller;
use App\Models\Documentacion;
use App\Models\empresa;
use App\Models\Instalaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class documentacionController extends Controller
{
  public function index()
  {

    $documentos = Documentacion::where('subtipo', '=', 'Todas')->get();
    $productor_agave = Documentacion::where('subtipo', '=', 'Generales Productor')->get();

    $empresas = empresa::where('tipo', '=', 2)->get();
    $instalaciones = Instalaciones::where('tipo', '=', 2)->get();

    return view("documentacion.documentacion_view", ["documentos" => $documentos, "productor_agave" => $productor_agave, "empresas" => $empresas]);
  }

  public function getNormas(Request $request)
  {
    $id_empresa = $request->input('cliente_id');

    if (!$id_empresa) {
      return response()->json(['tabs' => '', 'contents' => '']);
    }

    $normas = DB::select("
            SELECT n.id_norma, n.norma AS nombre
            FROM catalogo_norma_certificar n 
            JOIN empresa_norma_certificar e ON n.id_norma = e.id_norma 
            WHERE e.id_empresa = ?
        ", [$id_empresa]);



    $tabs = '';
    $contents = '';
    $tabsNormas = '';
    $contenido = '';
    $documentosActividad = '';
    $contenidoInstalaciones = '';



    foreach ($normas as $index => $norma) {
      $tabsActividades = '';
      $contenidoActividades = '';


      $actividades = DB::select("
      SELECT a.id_actividad, a.actividad  
      FROM catalogo_actividad_cliente a 
      JOIN empresa_actividad_cliente na 
      ON a.id_actividad = na.id_actividad 
      WHERE a.id_norma = ? AND na.id_empresa = ?
    ", [$norma->id_norma, $id_empresa]);

      foreach ($actividades as $indexA => $actividad) {

        $activeClassA = $indexA == 0 ? 'active' : '';
        $showClassA = $indexA == 0 ? 'show' : '';
        $contenidoDocumentos = "";
        $contenidoInstalaciones = '';
        $act_instalacion = '';


        $tabsActividades = $tabsActividades . '
            <li class="nav-item">
                <a style="width: 100% !important;" href="javascript:void(0);" class="nav-link btn ' . $activeClassA . ' d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-' . $actividad->id_actividad . '" aria-controls="navs-orders-id-' . $actividad->id_actividad . '" aria-selected="true">
                  <div>
                    <img src="' . asset('assets/img/products/apple-iMac-3k.png') . '" alt="Mobile" class="img-fluid">
                  </div>
                  ' . $actividad->actividad . '
                </a>
              </li>';

        if ($actividad->id_actividad == 1) {
          $documentosActividad = "Generales Productor";
        }

        if ($actividad->id_actividad == 2) {
          $documentosActividad = "Generales Productor Mezcal";
          $act_instalacion = "productora";
        }

        if ($actividad->id_actividad == 3) {
          $documentosActividad = "Generales Envasador";
          $act_instalacion = "envasadora";
        }

        if ($actividad->id_actividad == 4) {
          $documentosActividad = "Generales Comercializador";
          $act_instalacion = "comercializadora";
        }

        if ($actividad->id_actividad == 6) {
          $documentosActividad = "Generales Envasador Mezcal";
        }

        if ($actividad->id_actividad == 7) {
          $documentosActividad = "Generales Comercializador Mezcal";
        }



        $documentos = Documentacion::where('subtipo', $documentosActividad)
          ->with('documentacionUrls') // Eager loading de la relación
          ->get();

      

        foreach ($documentos as $indexD => $documento) {

          $urlPrimera = $documento->documentacionUrls->first();

          $url = '';

          if(!empty($urlPrimera)){
            $url = $urlPrimera->url;
          }

         /* foreach ($documento->documentacionUrls as $url) {
            "URL: " . $url->url . "<br>";
        }*/

        $empresa = Empresa::with('empresaNumClientes')->where('id_empresa', $id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
        $razonSocial = $empresa->razon_social;
        

        if(!empty($url)){
          $mostrarDocumento = '<i onclick="abrirModal(\'files/' . $numeroCliente . '/' . $url . '\')" style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="" data-registro=""></i>';
        }else{
          $mostrarDocumento = '---';
        }

          $contenidoDocumentos = $contenidoDocumentos . '
                    <tr>
                      <td>' . ($indexD + 1) . '</td>
                      <td class="text-wrap text-break"><b>' . $documento->id_documento . ' ' . $documento->nombre . '</b></td>
                      <td class="text-end">
                          <input class="form-control form-control-sm" type="file" id="formFile">
                      </td>
                      <td class="text-end fw-medium">   
                      
                        '.$mostrarDocumento.'
                      
                     </td>
                      <td class="text-success fw-medium text-end">----</td>
                    </tr>
                    ';
        }

        

        $instalaciones = Instalaciones::where('id_empresa', '=', $id_empresa)->where('tipo', '=', $act_instalacion)->get();

        foreach ($instalaciones as $indexI => $instalacion) {
          $contenidoInstalaciones = $contenidoInstalaciones . '
       
        <div class="table-responsive text-nowrap col-md-6 mb-5 ">
              <table class="table  table-bordered">
                <thead class="bg-secondary text-white">
                  <tr>
                    <th colspan="5" class="bg-transparent border-bottom bg-info text-center text-white fs-3">Instalación: <b>' . $instalacion->direccion_completa . '</b></th>
                  </tr>
                  <tr>
                    <th class="bg-transparent border-bottom">#</th>
                    <th class="bg-transparent border-bottom">Descripción del documento</th>
                    <th class="text-end bg-transparent border-bottom">Subir archivo</th>
                    <th class="text-end bg-transparent border-bottom">Documento</th>
                    <th class="text-end bg-transparent border-bottom">Validar</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    ' . $contenidoDocumentos . '
                </tbody>
              </table>
            </div>';
        }

        $contenidoActividades = $contenidoActividades . '
          <div class="tab-pane fade ' . $showClassA . ' ' . $activeClassA . '" id="navs-orders-id-' . $actividad->id_actividad . '" role="tabpanel">
           <div class="row p-5">
            ' . $contenidoInstalaciones . '
          </div> 
          </div>';
      }

     



      $tabId = 'norma-' . $norma->id_norma;
      $activeClass = $index == 0 ? 'active' : '';
      $showClass = $index == 0 ? 'show' : '';
      $norma =  $norma->nombre;
      $tabsNormas = $tabsNormas . ' <li class="nav-item">
                  <button type="button" class="nav-link ' . $activeClass . '" role="tab" data-bs-toggle="tab" data-bs-target="#' . $tabId . '" aria-controls="' . $tabId . '" aria-selected="true">' . $norma . '</button>
                </li>';

      $contenido = $contenido . '
            <div class="tab-pane fade ' . $showClass . ' ' . $activeClass . '" id="' . $tabId . '" role="tabpanel">
                  <div class="row">                     
  <!-- Top Referral Source Mobile  -->
  <div class="col-xxl-12">
    <div class="card"> 
      <img src="' . asset('assets/img/branding/banner_documentos.png') . '" alt="timeline-image" class="card-img-top h-px-300" style="object-fit: cover;">
      <div class="card-header d-flex justify-content-between">
        <div>
          <h5 class="card-title mb-1">' . $numeroCliente . ' ' . $razonSocial . ' (' . $norma . ')</h5>
          
        </div>
        
      </div>
      <div class="card-body pb-0">
        <ul class="nav nav-tabs nav-tabs-widget pb-6 gap-4 mx-1 d-flex flex-nowrap align-items-center" role="tablist">
          ' . $tabsActividades . '
        </ul>
      </div>
      <div class="tab-content p-0">
        ' . $contenidoActividades . '
        
      </div>
    </div>
  </div>
  <!--/ Top Referral Source Mobile -->

 

  </div>
                           
                </div>';
    }

    $tabs = '<div class="nav-align-top">
              <ul class="nav nav-tabs nav-fill" role="tablist">
                  ' . $tabsNormas . '
              </ul>
              <div class="tab-content border-0 pb-0 px-6 mx-1">
                  ' . $contenido . '
                
              </div>
            </div>';

    return response()->json(['tabs' => $tabs, 'contents' => $contents]);
  }


  /* public function getNormas(Request $request)
    {
        $id_empresa = $request->input('cliente_id');
        $normas = DB::select("SELECT n.id_norma,norma FROM catalogo_norma_certificar n JOIN empresa_norma_certificar e ON (n.id_norma = e.id_norma) WHERE id_empresa = ?",[$id_empresa]);
        return response()->json($normas);
    }*/

  public function getActividades(Request $request)
  {
    $id_empresa = $request->input('cliente_id');
    $id_norma = $request->input('norma_id');

    if (!$id_empresa || !$id_norma) {
      return response()->json([]);
    }

    $actividades = DB::select("
            SELECT a.id_actividad, a.actividad  
            FROM catalogo_actividad_cliente a 
            JOIN empresa_actividad_cliente na 
            ON a.id_actividad = na.id_actividad 
            WHERE a.id_norma = ? AND na.id_empresa = ?
        ", [$id_norma, $id_empresa]);

    return response()->json($actividades);
  }
}
