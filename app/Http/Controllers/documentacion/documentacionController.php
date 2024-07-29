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
    public function index(){

        $documentos = Documentacion ::where('subtipo', '=', 'Todas')->get();
        $productor_agave = Documentacion ::where('subtipo', '=', 'Generales Productor')->get();

        $empresas = empresa::where('tipo', '=', 2)->get();
        $instalaciones = Instalaciones::where('tipo', '=', 2)->get();

        return view("documentacion.documentacion_view", ["documentos"=>$documentos, "productor_agave"=>$productor_agave, "empresas"=>$empresas]);
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

        foreach ($normas as $index => $norma) {
            $tabId = 'norma-' . $norma->id_norma;
            $activeClass = $index == 0 ? 'active' : '';
            $norma =  $norma->nombre;
            $tabsNormas = $tabsNormas.' <li class="nav-item">
                  <button type="button" class="nav-link '.$activeClass.'" role="tab" data-bs-toggle="tab" data-bs-target="#'.$tabId.'" aria-controls="'.$tabId.'" aria-selected="true">'.$norma.'</button>
                </li>';

            $contenido = $contenido.'
            <div class="tab-pane fade show '.$activeClass.'" id="'.$tabId.'" role="tabpanel">
                  <div class="row">                     
  <!-- Top Referral Source Mobile  -->
  <div class="col-xxl-12">
    <div class="card"> 
      <img src="' .asset('assets/img/branding/validacion_certificacion.png'). '" alt="timeline-image" class="card-img-top h-px-200" style="object-fit: cover;">
      <div class="card-header d-flex justify-content-between">
        <div>
          <h5 class="card-title mb-1">NOM-070-001C MEZCALMICH S.P.R. DE R.L.</h5>
          
        </div>
        
      </div>
      <div class="card-body pb-0">
        <ul class="nav nav-tabs nav-tabs-widget pb-6 gap-4 mx-1 d-flex flex-nowrap align-items-center" role="tablist">
          <li class="nav-item">
            <a style="width: 100% !important;" href="javascript:void(0);" class="nav-link btn active d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-1" aria-controls="navs-orders-id-1" aria-selected="true">
              <div>
                <img src="' .asset('assets/img/products/apple-iMac-3k.png').'" alt="Mobile" class="img-fluid">
              </div>
              Documentación general
            </a>
          </li>
          <li class="nav-item">
            <a style="width: 100% !important;" href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-2" aria-controls="navs-orders-id-2" aria-selected="false">
              <div>
                <img src="' .asset('assets/img/products/apple-iMac-3k.png').'" alt="Apple iMac 3k" class="img-fluid">
              </div>
              Productor de agave
            </a>
          </li>
          <li class="nav-item">
            <a style="width: 100% !important;" href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-3" aria-controls="navs-orders-id-3" aria-selected="false">
              <div>
                <img src="' .asset('assets/img/products/gaming-remote.png').'" alt="Gaming Remote" class="img-fluid">
              </div>
              Productor de mezcal
            </a>
          </li>
          <li class="nav-item">
            <a href="javascript:void(0);" class="nav-link btn d-flex align-items-center justify-content-center disabled" role="tab" data-bs-toggle="tab" aria-selected="false">
              <div class="avatar avatar-sm">
                <div class="avatar-initial bg-label-secondary text-body rounded">
                  <i class="ri-add-line ri-22px"></i>
                </div>
              </div>
            </a>
          </li>
        </ul>
      </div>
      <div class="tab-content p-0">
        <div class="tab-pane fade show active" id="navs-orders-id-1" role="tabpanel">
          <div class="table-responsive text-nowrap col-xs-12">
            <table class="table border-top">
              <thead>
                <tr>
                  <th class="bg-transparent border-bottom">#</th>
                  <th class="bg-transparent border-bottom">Descripción del documento</th>
                  <th class="text-end bg-transparent border-bottom">Subir archivo</th>
                  <th class="text-end bg-transparent border-bottom">Documento</th>
                  <th class="text-end bg-transparent border-bottom">Validar</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($documentos as $index => $documento)
                <tr>
                  <td>{{$index + 1}}</td>
                  <td class="text-wrap text-break"><b> {{$documento->nombre}}</b></td>
                  <td class="text-end">
                      <input class="form-control form-control-sm" type="file" id="formFile">
                  </td>
                  <td class="text-end fw-medium">--</td>
                  <td class="text-success fw-medium text-end">--</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-orders-id-2" role="tabpanel">
          <div class="row">
            <div class="col-md-6">
              <div class="card m-5">
                <div class="row g-0">
                  <div class="col-md-12">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h4 class="card-title m-0 me-2">Instalación 1</h4>
                    </div>
                    <div class="card-body">
                      
                      <div class="table-responsive text-nowrap col-xs-12">
                        <table class="table border-top">
                          <thead>
                            <tr>
                              <th class="bg-transparent border-bottom">#</th>
                              <th class="bg-transparent border-bottom">Descripción del documento</th>
                              <th class="text-end bg-transparent border-bottom">Subir archivo</th>
                              <th class="text-end bg-transparent border-bottom">Documento</th>
                              <th class="text-end bg-transparent border-bottom">Validar</th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            @foreach ($productor_agave as $index => $documento)
                            <tr>
                              <td>{{$index + 1}}</td>
                              <td class="text-wrap text-break"><b> {{$documento->nombre}}</b></td>
                              <td class="text-end">
                                  <input class="form-control form-control-sm" type="file" id="formFile">
                              </td>
                              <td class="text-end fw-medium">--</td>
                              <td class="text-success fw-medium text-end">--</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card m-5">
                <div class="row g-0">
                  <div class="col-md-12">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h4 class="card-title m-0 me-2">Instalación 2</h4>
                    </div>
                    <div class="card-body">
                      
                      <div class="table-responsive text-nowrap col-xs-12">
                        <table class="table border-top">
                          <thead>
                            <tr>
                              <th class="bg-transparent border-bottom">#</th>
                              <th class="bg-transparent border-bottom">Descripción del documento</th>
                              <th class="text-end bg-transparent border-bottom">Subir archivo</th>
                              <th class="text-end bg-transparent border-bottom">Documento</th>
                              <th class="text-end bg-transparent border-bottom">Validar</th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0">
                            @foreach ($productor_agave as $index => $documento)
                            <tr>
                              <td>{{$index + 1}}</td>
                              <td class="text-wrap text-break"><b> {{$documento->nombre}}</b></td>
                              <td class="text-end">
                                  <input class="form-control form-control-sm" type="file" id="formFile">
                              </td>
                              <td class="text-end fw-medium">--</td>
                              <td class="text-success fw-medium text-end">--</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="navs-orders-id-3" role="tabpanel">
          <div class="table-responsive text-nowrap">
            <table class="table border-top">
              <thead>
                <tr>
                  <th class="bg-transparent border-bottom">Image</th>
                  <th class="bg-transparent border-bottom">Name</th>
                  <th class="text-end bg-transparent border-bottom">Status</th>
                  <th class="text-end bg-transparent border-bottom">Revenue</th>
                  <th class="text-end bg-transparent border-bottom">Profit</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <tr>
                  <td>
                    <img src="' .asset('assets/img/products/sony-play-station-5.png').'" alt="Mobile" width="34" height="34" class="rounded">
                  </td>
                  <td>Sony Play Station 5</td>
                  <td class="text-end">
                    <div class="badge bg-label-info rounded-pill">In Draft</div>
                  </td>
                  <td class="text-end fw-medium">$5</td>
                  <td class="text-success fw-medium text-end">+5%</td>
                </tr>
                <tr>
                  <td>
                    <img src="' .asset('assets/img/products/xbox-series-x.png').'" alt="Mobile" width="34" height="34" class="rounded">
                  </td>
                  <td>XBOX Series X</td>
                  <td class="text-end">
                    <div class="badge bg-label-primary rounded-pill">Out of Stock</div>
                  </td>
                  <td class="text-end fw-medium">$5,576</td>
                  <td class="text-danger fw-medium text-end">-24%</td>
                </tr>
                <tr>
                  <td>
                    <img src="' .asset('assets/img/products/nintendo-switch.png').'" alt="Mobile" width="34" height="34" class="rounded">
                  </td>
                  <td>Nintendo Switch</td>
                  <td class="text-end">
                    <div class="badge bg-label-warning rounded-pill">Upcoming</div>
                  </td>
                  <td class="text-end fw-medium">$2,857</td>
                  <td class="text-success fw-medium text-end">+5%</td>
                </tr>
                <tr>
                  <td>
                    <img src="' .asset('assets/img/products/sup-game-box-400.png').'" alt="Mobile" width="34" height="34" class="rounded">
                  </td>
                  <td>SUP Game Box 400</td>
                  <td class="text-end">
                    <div class="badge bg-label-success rounded-pill">In Stock</div>
                  </td>
                  <td class="text-end fw-medium">$850</td>
                  <td class="text-danger fw-medium text-end">-12%</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Top Referral Source Mobile -->

 

  </div>
                            Fin del contenido 1
                </div>';
            
        }

        $tabs = '<div class="nav-align-top">
              <ul class="nav nav-tabs nav-fill" role="tablist">
                  '.$tabsNormas.'
              </ul>
              <div class="tab-content border-0 pb-0 px-6 mx-1">
                  '.$contenido.'
                
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