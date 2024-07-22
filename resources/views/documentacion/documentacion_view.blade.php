@extends('layouts/layoutMaster')

@section('title', 'Cards Advance- UI elements')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js'
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/cards-advance.js',
  'resources/assets/js/modal-add-new-cc.js'
])
@endsection

@section('content')
<div class="row g-6">

    <div class="col-md-12 col-xxl-12">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <div class="card-title mb-0">
              <h2 class="m-0 me-2">Requisitos documentales</h2>
              
            </div>
            <div class="dropdown">
              <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button" id="ordersCountries" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ri-more-2-line ri-20px"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="ordersCountries">
                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                <a class="dropdown-item" href="javascript:void(0);">Share</a>
              </div>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="nav-align-top">
              <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                  <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-new" aria-controls="navs-justified-new" aria-selected="true">NOM-070-SCFI-2016</button>
                </li>
                <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-link-preparing" aria-controls="navs-justified-link-preparing" aria-selected="false">NMX-V-052-NORMEX-2016</button>
                </li>
                <li class="nav-item">
                  <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-justified-link-shipping" aria-controls="navs-justified-link-shipping" aria-selected="false">NOM-199-SCFI-2017</button>
                </li>
              </ul>
              <div class="tab-content border-0 pb-0 px-6 mx-1">
                <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                  <div class="row">                     
  <!-- Top Referral Source Mobile  -->
  <div class="col-xxl-6">
    <div class="card">
      <img src="{{asset('assets/img/branding/validacion_certificacion.png')}}" alt="timeline-image" class="card-img-top h-px-200" style="object-fit: cover;">
      <div class="card-header d-flex justify-content-between">
        <div>
          <h5 class="card-title mb-1">Documentos generales</h5>
          
        </div>
        <div class="dropdown">
          <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button" id="earningReportsMobileTabsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ri-more-2-line ri-20px"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsMobileTabsId">
            <a class="dropdown-item" href="javascript:void(0);">View More</a>
            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
          </div>
        </div>
      </div>
      <div class="card-body pb-0">
        <ul class="nav nav-tabs nav-tabs-widget pb-6 gap-4 mx-1 d-flex flex-nowrap align-items-center" role="tablist">
          <li class="nav-item">
            <a href="javascript:void(0);" class="nav-link btn active d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-1" aria-controls="navs-orders-id-1" aria-selected="true">
              <div>
                <img src="https://www.diariodemexico.com/sites/default/files/styles/facebook/public/d7/field/image/Sin-t_tulo-1.jpg?itok=CI0c_a63" alt="Mobile" class="img-fluid">
              </div>
            </a>
          </li>
          <li class="nav-item">
            <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-2" aria-controls="navs-orders-id-2" aria-selected="false">
              <div>
                <img src="{{asset('assets/img/products/apple-iMac-3k.png')}}" alt="Apple iMac 3k" class="img-fluid">
              </div>
            </a>
          </li>
          <li class="nav-item">
            <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-3" aria-controls="navs-orders-id-3" aria-selected="false">
              <div>
                <img src="{{asset('assets/img/products/gaming-remote.png')}}" alt="Gaming Remote" class="img-fluid">
              </div>
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
                    <img src="{{asset('assets/img/products/apple-mac-mini.png')}}" alt="Mobile" width="34" height="34" class="rounded">
                  </td>
                  <td>Apple Mac Mini</td>
                  <td class="text-end">
                    <div class="badge bg-label-primary rounded-pill">Out of Stock</div>
                  </td>
                  <td class="text-end fw-medium">$5,576</td>
                  <td class="text-danger fw-medium text-end">-24%</td>
                </tr>
                <tr>
                  <td>
                    <img src="{{asset('assets/img/products/hp-envy-x360.png')}}" alt="Mobile" width="34" height="34" class="rounded">
                  </td>
                  <td>Newest HP Envy x360</td>
                  <td class="text-end">
                    <div class="badge bg-label-info rounded-pill">In Draft</div>
                  </td>
                  <td class="text-end fw-medium">$5</td>
                  <td class="text-success fw-medium text-end">+5%</td>
                </tr>
                <tr>
                  <td>
                    <img src="{{asset('assets/img/products/dell-inspiron-3000.png')}}" alt="Mobile" width="34" height="34" class="rounded">
                  </td>
                  <td>Dell Inspiron 3000</td>
                  <td class="text-end">
                    <div class="badge bg-label-success rounded-pill">In Stock</div>
                  </td>
                  <td class="text-end fw-medium">$850</td>
                  <td class="text-danger fw-medium text-end">-12%</td>
                </tr>
                <tr>
                  <td>
                    <img src="{{asset('assets/img/products/apple-iMac-4k.png')}}" alt="Mobile" width="34" height="34" class="rounded">
                  </td>
                  <td>Apple iMac 4k</td>
                  <td class="text-end">
                    <div class="badge bg-label-danger rounded-pill">warning</div>
                  </td>
                  <td class="text-end fw-medium">$857</td>
                  <td class="text-danger fw-medium text-end">-5%</td>
                </tr>
              </tbody>
            </table>
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
                    <img src="{{asset('assets/img/products/sony-play-station-5.png')}}" alt="Mobile" width="34" height="34" class="rounded">
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
                    <img src="{{asset('assets/img/products/xbox-series-x.png')}}" alt="Mobile" width="34" height="34" class="rounded">
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
                    <img src="{{asset('assets/img/products/nintendo-switch.png')}}" alt="Mobile" width="34" height="34" class="rounded">
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
                    <img src="{{asset('assets/img/products/sup-game-box-400.png')}}" alt="Mobile" width="34" height="34" class="rounded">
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

   <!-- Top Referral Source Mobile  -->
   <div class="col-xxl-6">
    <div class="card">
      <img src="{{asset('assets/img/branding/validacion_certificacion.png')}}" alt="timeline-image" class="card-img-top h-px-200" style="object-fit: cover;">
      <div class="card-header d-flex justify-content-between">
        <div>
          <h5 class="card-title mb-1">Documentos generales</h5>
          
        </div>
        <div class="dropdown">
          <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button" id="earningReportsMobileTabsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ri-more-2-line ri-20px"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsMobileTabsId">
            <a class="dropdown-item" href="javascript:void(0);">View More</a>
            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
          </div>
        </div>
      </div>
      <div class="card-body pb-0">
        <ul class="nav nav-tabs nav-tabs-widget pb-6 gap-4 mx-1 d-flex flex-nowrap align-items-center" role="tablist">
          <li class="nav-item">
            <a href="javascript:void(0);" class="nav-link btn active d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-1" aria-controls="navs-orders-id-1" aria-selected="true">
              <div>
                <img src="https://www.diariodemexico.com/sites/default/files/styles/facebook/public/d7/field/image/Sin-t_tulo-1.jpg?itok=CI0c_a63" alt="Mobile" class="img-fluid">
              </div>
            </a>
          </li>
          <li class="nav-item">
            <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-2" aria-controls="navs-orders-id-2" aria-selected="false">
              <div>
                <img src="{{asset('assets/img/products/apple-iMac-3k.png')}}" alt="Apple iMac 3k" class="img-fluid">
              </div>
            </a>
          </li>
          <li class="nav-item">
            <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id-3" aria-controls="navs-orders-id-3" aria-selected="false">
              <div>
                <img src="{{asset('assets/img/products/gaming-remote.png')}}" alt="Gaming Remote" class="img-fluid">
              </div>
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
                    <img src="{{asset('assets/img/products/apple-mac-mini.png')}}" alt="Mobile" width="34" height="34" class="rounded">
                  </td>
                  <td>Apple Mac Mini</td>
                  <td class="text-end">
                    <div class="badge bg-label-primary rounded-pill">Out of Stock</div>
                  </td>
                  <td class="text-end fw-medium">$5,576</td>
                  <td class="text-danger fw-medium text-end">-24%</td>
                </tr>
                <tr>
                  <td>
                    <img src="{{asset('assets/img/products/hp-envy-x360.png')}}" alt="Mobile" width="34" height="34" class="rounded">
                  </td>
                  <td>Newest HP Envy x360</td>
                  <td class="text-end">
                    <div class="badge bg-label-info rounded-pill">In Draft</div>
                  </td>
                  <td class="text-end fw-medium">$5</td>
                  <td class="text-success fw-medium text-end">+5%</td>
                </tr>
                <tr>
                  <td>
                    <img src="{{asset('assets/img/products/dell-inspiron-3000.png')}}" alt="Mobile" width="34" height="34" class="rounded">
                  </td>
                  <td>Dell Inspiron 3000</td>
                  <td class="text-end">
                    <div class="badge bg-label-success rounded-pill">In Stock</div>
                  </td>
                  <td class="text-end fw-medium">$850</td>
                  <td class="text-danger fw-medium text-end">-12%</td>
                </tr>
                <tr>
                  <td>
                    <img src="{{asset('assets/img/products/apple-iMac-4k.png')}}" alt="Mobile" width="34" height="34" class="rounded">
                  </td>
                  <td>Apple iMac 4k</td>
                  <td class="text-end">
                    <div class="badge bg-label-danger rounded-pill">warning</div>
                  </td>
                  <td class="text-end fw-medium">$857</td>
                  <td class="text-danger fw-medium text-end">-5%</td>
                </tr>
              </tbody>
            </table>
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
                    <img src="{{asset('assets/img/products/sony-play-station-5.png')}}" alt="Mobile" width="34" height="34" class="rounded">
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
                    <img src="{{asset('assets/img/products/xbox-series-x.png')}}" alt="Mobile" width="34" height="34" class="rounded">
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
                    <img src="{{asset('assets/img/products/nintendo-switch.png')}}" alt="Mobile" width="34" height="34" class="rounded">
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
                    <img src="{{asset('assets/img/products/sup-game-box-400.png')}}" alt="Mobile" width="34" height="34" class="rounded">
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
                </div>
                <div class="tab-pane fade" id="navs-justified-link-preparing" role="tabpanel">
                     Contenido aqui
                </div>
                <div class="tab-pane fade" id="navs-justified-link-shipping" role="tabpanel">
                    Contenido 2 aqui
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/ Orders by Countries -->
</div>

@include('_partials/_modals/modal-add-new-cc')
@include('_partials/_modals/modal-upgrade-plan')
<!-- /Modal -->
<script type="module">
// Check selected custom option
window.Helpers.initCustomOptionCheck();
</script>

@endsection
