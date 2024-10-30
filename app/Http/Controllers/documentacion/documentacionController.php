<?php

namespace App\Http\Controllers\documentacion;

use App\Http\Controllers\Controller;
use App\Models\Documentacion;
use App\Models\Documentacion_url;
use App\Models\empresa;
use App\Models\Instalaciones;
use App\Models\marcas;
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
            JOIN empresa_num_cliente e ON n.id_norma = e.id_norma 
            WHERE e.id_empresa = ?
        ", [$id_empresa]);



    $tabs = '';
    $contents = '';
    $tabsNormas = '';
    $contenido = '';
    $documentosActividad = '';
    $contenidoInstalaciones = '';
    $contenidoInstalacionesGenerales = '';



    foreach ($normas as $index => $norma) {
      $tabsActividades = '';
      $tabsGenerales = '';
      $contenidoActividades = '';
      $contenidoGenerales = '';


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
        $contenidoDocumentosGenerales = "";
        $contenidoDocumentosMarcas = "";
        $contenidoInstalaciones = '';
        $contenidoInstalacionesGenerales = '';
        $act_instalacion = '';

        $tabsGenerales = '
            <li class="nav-item">
                <a style="width: 100% !important;" href="javascript:void(0);" class="nav-link btn active d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-0" aria-controls="navs-orders-id-0" aria-selected="true">
                  <div>
                    <img src="' . asset('assets/img/products/apple-iMac-3k.png') . '" alt="Mobile" class="img-fluid">
                  </div>
                  Documentos Generales
                </a>
              </li>';


        $tabsActividades = $tabsActividades . '
            <li class="nav-item">
                <a style="width: 100% !important;" href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-' . $actividad->id_actividad . '" aria-controls="navs-orders-id-' . $actividad->id_actividad . '" aria-selected="true">
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
          $act_instalacion = "Productora";
        }

        if ($actividad->id_actividad == 3) {
          $documentosActividad = "Generales Envasador";
          $act_instalacion = "Envasadora";
        }

        if ($actividad->id_actividad == 4) {
          $documentosActividad = "Generales Comercializador";
          $act_instalacion = "Comercializadora";
          
            $marcas = marcas::where('id_empresa', '=', $id_empresa)->get();
            $contenidoMarcas ='';




            foreach ($marcas as $indexII => $marca) {
              $contenidoMarcas =  $contenidoMarcas . '

            <div class="table-responsive text-nowrap col-md-6 mb-5 ">
                  <table class="table table-sm table-bordered">
                    <thead class="bg-secondary text-white">
                      <tr>
                        <th colspan="5" class="bg-transparent border-bottom bg-info text-center text-white fs-3">Marca: <b>' . $marca->marca . '</b></th>
                      </tr>
                      <tr>
                        <th class="bg-transparent border-bottom">#</th>
                        <th class="bg-transparent border-bottom">Descripción del documento</th>
                        <th class="text-end bg-transparent border-bottom">Subir archivo</th>
                        <th class="text-end bg-transparent border-bottom">Documento</th>
                        <th class="text-end bg-transparent border-bottom">Validar</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" style="font-size:12px">
                        ' . $contenidoDocumentosMarcas . '
                    </tbody>
                  </table>
                </div>';
            }





        }

        if ($actividad->id_actividad == 6) {
          $documentosActividad = "Generales Envasador Mezcal";
        }

        if ($actividad->id_actividad == 7) {
          $documentosActividad = "Generales Comercializador Mezcal";
          $documentosActividadMarca =  "->orWhere('subtipo', 'Marcas')";
        }



        $documentos2 = Documentacion::where('subtipo', 'Todas')
          ->with('documentacionUrls') // Eager loading de la relación
          ->get();

          $empresa = empresa::with('empresaNumClientes')->where('id_empresa', $id_empresa)->first();
          $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
          $razonSocial = $empresa->razon_social;
          
          

          foreach ($documentos2 as $indexD => $documento) {

            $urlPrimera = $documento->documentacionUrls->first();

          $url = '';

          if(!empty($urlPrimera)){
            $url = $urlPrimera->url;
          }


            if(!empty($url)){
              $mostrarDocumento = '<i onclick="abrirModal(\'files/' . $numeroCliente . '/' . $url . '\')" style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="" data-registro=""></i>';
            }else{
              $mostrarDocumento = '---';
            }
    

        $contenidoDocumentosGenerales = $contenidoDocumentosGenerales.'<tr>
                      <td>' . ($indexD + 1) . '</td>
                      <td class="text-wrap text-break"><b>' . $documento->nombre . '</b></td>
                      <td class="text-end p-1">
                          <input class="form-control form-control-sm" type="file" id="file'.$documento->id_documento.'" data-id="'.$documento->id_documento.'" name="url[]">
                                <input value="'. $documento->id_documento .'" class="form-control" type="hidden" name="id_documento[]">
                                <input value="'. $documento->nombre .'" class="form-control" type="hidden" name="nombre_documento[]">
                      </td>
                      <td class="text-end fw-medium">   
                      
                         '.$mostrarDocumento.'
                      
                     </td>
                      <td class="text-success fw-medium text-end">----</td>
                    </tr>';
          }

          $documentos3 = Documentacion::where('tipo', 'Marcas')
          ->with('documentacionUrls') // Eager loading de la relación
          ->get();

          $empresa = empresa::with('empresaNumClientes')->where('id_empresa', $id_empresa)->first();
          $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
          $razonSocial = $empresa->razon_social;
          
          

          foreach ($documentos3 as $indexD => $documento) {

            $urlPrimera = $documento->documentacionUrls->first();

          $url = '';

          if(!empty($urlPrimera)){
            $url = $urlPrimera->url;
          }


            if(!empty($url)){
              $mostrarDocumento = '<i onclick="abrirModal(\'files/' . $numeroCliente . '/' . $url . '\')" style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="" data-registro=""></i>';
            }else{
              $mostrarDocumento = '---';
            }
    

        $contenidoDocumentosMarcas = $contenidoDocumentosMarcas.'<tr>
                      <td>' . ($indexD + 1) . '</td>
                      <td class="text-wrap text-break"><b>' . $documento->nombre . '</b></td>
                      <td class="text-end">
                          <input class="form-control form-control-sm" type="file" id="file'.$documento->id_documento.'" data-id="'.$documento->id_documento.'" name="url[]">
                                <input value="'. $documento->id_documento .'" class="form-control" type="hidden" name="id_documento[]">
                                <input value="'. $documento->nombre .'" class="form-control" type="hidden" name="nombre_documento[]">
                      </td>
                      <td class="text-end fw-medium">   
                      
                         '.$mostrarDocumento.'
                      
                     </td>
                      <td class="text-success fw-medium text-end">----</td>
                    </tr>';
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

      
        if(!empty($url)){
          $mostrarDocumento = '<i onclick="abrirModal(\'files/' . $numeroCliente . '/' . $url . '\')" style class="ri-file-pdf-2-fill text-danger ri-40px pdf cursor-pointer" data-bs-target="#mostrarPdf" data-bs-toggle="modal" data-bs-dismiss="modal" data-id="" data-registro=""></i>';
        }else{
          $mostrarDocumento = '---';
        }

        

          $contenidoDocumentos = $contenidoDocumentos . '
                    <tr>
                      <td>' . ($indexD + 1) . '</td>
                      <td class="text-wrap text-break"><b>' . $documento->nombre . '</b></td>
                      <td class="text-end">
                          <input class="form-control form-control-sm" type="file" id="file'.$documento->id_documento.'" data-id="'.$documento->id_documento.'" name="url[]">
                                <input value="'. $documento->id_documento .'" class="form-control" type="hidden" name="id_documento[]">
                                <input value="'. $documento->nombre .'" class="form-control" type="hidden" name="nombre_documento[]">
                      </td>
                      <td class="text-end fw-medium">   
                      
                        '.$mostrarDocumento.'
                      
                     </td>
                      <td class="text-success fw-medium text-end">----</td>
                    </tr>
                    ';
        }

        

        $instalaciones = Instalaciones::where('id_empresa', '=', $id_empresa)->where('tipo', '=', $act_instalacion)->get();

        $contenidoInstalacionesGenerales = '
       
        <div class="table-responsive text-nowrap col-md-12 mb-5 ">
              <table class="table table-sm table-bordered">
                <thead class="bg-secondary text-white">
                  <tr>
                    <th colspan="5" class="bg-transparent border-bottom bg-info text-center text-white fs-3"><b>Documentación general</b></th>
                  </tr>
                  <tr>
                    <th class="bg-transparent border-bottom">#</th>
                    <th class="bg-transparent border-bottom">Descripción del documento</th>
                    <th class="text-end bg-transparent border-bottom">Subir archivo</th>
                    <th class="text-end bg-transparent border-bottom">Documento</th>
                    <th class="text-end bg-transparent border-bottom">Validar</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0" style="font-size:12px">
                    ' . $contenidoDocumentosGenerales . '
                </tbody>
              </table>
            </div>';


            

            

            
 }

      foreach ($instalaciones as $indexI => $instalacion) {
        $contenidoInstalaciones = $contenidoInstalaciones . '
     
      <div class="table-responsive text-nowrap col-md-6 mb-5 ">
            <table class="table table-sm table-bordered">
              <thead class="bg-secondary text-white">
                <tr>
                  <th colspan="5" class="bg-transparent border-bottom bg-info text-center text-white fs-4"><span class="fs-6">Instalación:</span><br> <b class="badge bg-primary">' . $instalacion->direccion_completa . '</b></th>
                </tr>
                <tr>
                  <th class="bg-transparent border-bottom">#</th>
                  <th class="bg-transparent border-bottom">Descripción del documento</th>
                  <th class="text-end bg-transparent border-bottom">Subir archivo</th>
                  <th class="text-end bg-transparent border-bottom">Documento</th>
                  <th class="text-end bg-transparent border-bottom">Validar</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0" style="font-size:12px">
                  ' . $contenidoDocumentos . '
              </tbody>
            </table>
          </div>';
      }

      $contenidoGenerales =  '<div class="tab-pane fade show active" id="navs-orders-id-0" role="tabpanel">
      <div class="row p-5"> 
       ' . $contenidoInstalacionesGenerales . '
     </div> 
     </div>';

      $contenidoActividades = $contenidoActividades . '
        <div class="tab-pane fade" id="navs-orders-id-' . $actividad->id_actividad . '" role="tabpanel">
         <div class="row p-5">
          ' . $contenidoInstalaciones . '
          ' . $contenidoMarcas . '
        </div> 
        </div>';

     



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
      <img src="' . asset('assets/img/branding/banner_documentos.png') . '" alt="timeline-image" class="card-img-top h-px-100" style="object-fit: cover;">
      <div class="card-header d-flex justify-content-between">
        <div>
          <h5 class="card-title mb-1">' . $numeroCliente . ' ' . $razonSocial . ' (' . $norma . ')</h5>

          <input name="numCliente" type="hidden" value="' . $numeroCliente . '">
          
        </div>
        
      </div>
      <div class="card-body pb-0">
        <ul class="nav nav-tabs nav-tabs-widget pb-6 gap-4 mx-1 d-flex flex-nowrap align-items-center" role="tablist">
         ' . $tabsGenerales . '  ' . $tabsActividades . '
        </ul>
      </div>
      <div class="tab-content p-0">
       ' . $contenidoGenerales . '  ' . $contenidoActividades . '
        
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

  public function upload(Request $request)
    {
      
      if ($request->hasFile('url')) {
        $numeroCliente = $request->numCliente;
        foreach ($request->file('url') as $index => $file) {
            $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

            $documentacion_url = new Documentacion_url ();
            $documentacion_url->id_relacion = 0;
            $documentacion_url->id_documento = $request->id_documento[$index];
            $documentacion_url->nombre_documento = $request->nombre_documento[$index];
            $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
            $documentacion_url->id_empresa = $request->id_empresa;
            $documentacion_url->fecha_vigencia = $request->fecha_vigencia[$index] ?? null; // Usa null si no hay fecha
            $documentacion_url->save();
        }
    }
        

        return response()->json(['success' => 'Files uploaded successfully!']);
    }
}
