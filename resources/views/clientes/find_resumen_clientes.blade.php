@extends('layouts/layoutMaster')

@section('title', 'Resumen de datos')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
   'resources/assets/vendor/libs/spinkit/spinkit.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js' 
])
@endsection

<!-- Page Scripts -->
@section('page-script')
{{-- @vite(['resources/js/clientes_prospecto.js']) --}}
@endsection


@section('content')


<div class="row g-6">
  <div class="col-md-12 col-xxl-12">
    <div class="card h-100">

        {{-- <img src="{{ asset('assets/img/branding/banner_documentos.png') }}" alt="timeline-image" class="card-img-top img-fluid" style="object-fit: cover;"> --}}
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="m-0 me-2">Resumen de informacion del cliente</h2>
        </div>

      <div class="card-body p-0">
        <form id="uploadForm" enctype="multipart/form-data">

          <div class="form-floating form-floating-outline m-5 col-md-6">
            <select name="id_empresa" id="id_empresa" class="select2 form-select">
              @foreach ($empresa->empresaNumClientes as $cliente)
                  <option value="{{ $cliente->id_empresa }}">
                      {{ $cliente->numero_cliente }} | {{ $empresa->razon_social }}
                  </option>
              @endforeach
            </select>
          </div>

          <!-- CARDS-->
          {{-- <div class="form-floating-outline m-2 row">
            
            <div class="col-md-6 col-xl-4">
              <div class="card bg-primary text-white">
                <div class="card-body">
                  <h5 class="card-title text-white">INSTALACIÓN</h5>
                  <p class="card-text">
                    <a href="http://localhost:8000/domicilios/instalaciones" class="text-white text-decoration-underline hover-text-primary">Ver Instalaciones</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-4">
              <div class="card bg-danger text-white">
                <div class="card-body">
                  <h5 class="card-title text-white">MARCAS</h5>
                  <p class="card-text">
                    Sin registros
                  </p>
                </div>
              </div>
            </div>

          </div> --}}<!--FIN CARDS-->




          <!--CUARTO 2.2-->
          <div class="form-floating-outline m-2 row">
            <!-- TARJETA 1 -->
            <div class="col-md-6 col-xl-4 mb-3">
                <div class="accordion" id="accordionCard1">
                    <div class="accordion-item">
                        <!-- Título de la tarjeta como el encabezado del acordeón -->
                        <h5 class="accordion-header" id="headingOne">
                            <button class="accordion-button text-white {{ $empresa && $empresa->instalaciones->count() > 0 ? 'bg-primary' : 'bg-danger' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                INSTALACIÓN ({{ $empresa->instalaciones->count() }})<br><br>
                                @if($empresa && $empresa->instalaciones->count() > 0)
                                    Despliega para ver instalaciones
                                @else
                                    Sin registros
                                @endif
                            </button>
                        </h5>
                        
                        <!-- Contenido que se despliega -->
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionCard1">
                            {{-- <div class="accordion-body">
                                @if($empresa && $empresa->instalaciones->count() > 0)
                                    @foreach($empresa->instalaciones as $instalacion)
                                      {{ $instalacion->direccion_completa }}<br><br>
                                    @endforeach
                                @else
                                    <p>No hay instalaciones registradas para esta empresa.</p>
                                @endif
                            </div> --}}

                            @if($empresa && $empresa->instalaciones->count() > 0)
                                <div class="row mt-3">
                                    <!-- Tarjeta para cada marca dentro del contenido desplegable -->
                                    @foreach($empresa->instalaciones as $instalacion)
                                        <div class="col-lg-6 mb-5" style="font-size: 14px">
                                            <div class="card bg-label-primary">
                                                <div class="card-body">
                                                    <p class="card-title"><b>

                                                    @php
                                                      $tipos = json_decode($instalacion->tipo, true); // Decodifica el JSON a un array
                                                    @endphp
                                                    @if(!empty($tipos))
                                                        {{ implode(', ', $tipos) }}  {{-- Une todos los tipos con una coma y un espacio --}}
                                                    @else
                                                        Sin Tipo
                                                    @endif
                                                    
                                                    </b></p>
                                                    <p class="card-text">
                                                      Direccion: {{ $instalacion->direccion_completa }} <span class="d-block mt-2">
                                                      </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                  @else
                                      <p>No hay instalaciones registradas para esta empresa.</p>
                                  @endif
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- TARJETA 2 -->
            <div class="col-md-6 col-xl-4 mb-3">
                <div class="accordion" id="accordionCard2">
                    <div class="accordion-item">
                        <!-- Título de la tarjeta como el encabezado del acordeón -->
                        <h5 class="accordion-header" id="headingTwo">
                            <button class="accordion-button text-white {{ $empresa && $empresa->marcas->count() > 0 ? 'bg-primary' : 'bg-danger' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                MARCAS ({{ $empresa->marcas->count() }})<br><br>
                                @if($empresa && $empresa->marcas->count() > 0)
                                    Despliega para ver las marcas
                                @else
                                    Sin registros
                                @endif
                            </button>
                        </h5>
                        
                        <!-- Contenido que se despliega -->
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionCard2">
                            {{-- <div class="accordion-body">
                                @if($empresa && $empresa->marcas->count() > 0)
                                    @foreach($empresa->marcas as $marca)
                                        <li>{{ $marca->marca }}</li><br>
                                    @endforeach
                                @else
                                    <p>No hay marcas registradas para esta empresa.</p>
                                @endif
                            </div> --}}
        
                            <!-- Añadir tarjetas dentro del contenido desplegable de marcas -->
                            @if($empresa && $empresa->marcas->count() > 0)
                                <div class="row mt-3">
                                    <!-- Tarjeta para cada marca dentro del contenido desplegable -->
                                    @foreach($empresa->marcas as $marca)
                                        <div class="col-lg-6 mb-5" style="font-size: 14px">
                                            <div class="card bg-label-primary">
                                                <div class="card-body">
                                                    <p class="card-title"><b>{{ $marca->marca }}</b></p>
                                                    <p class="card-text">
                                                      Folio: {{ $marca->folio }} <span class="d-block mt-2">
                                                      Norma: {{ $marca->catalogo_norma_certificar->norma }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- TARJETA 3 -->
            <div class="col-md-6 col-xl-4 mb-3">
              <div class="accordion" id="accordionCard3">
                  <div class="accordion-item">
                      <!-- Título de la tarjeta como el encabezado del acordeón -->
                      <h5 class="accordion-header" id="titulo3">
                          <button class="accordion-button text-white {{ $empresa && $empresa->marcas->count() > 0 ? 'bg-primary' : 'bg-danger' }}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion3" aria-expanded="false" aria-controls="coleccion3">
                              MARCAS ({{ $empresa->marcas->count() }})<br><br>
                              @if($empresa && $empresa->marcas->count() > 0)
                                  Despliega para ver las marcas
                              @else
                                  Sin registros
                              @endif
                          </button>
                      </h5>
                      <!-- Contenido que se despliega -->
                      <div id="coleccion3" class="accordion-collapse collapse" aria-labelledby="titulo3" data-bs-parent="#accordionCard3">
                          <!-- Añadir tarjetas dentro del contenido desplegable de marcas -->
                          @if($empresa && $empresa->marcas->count() > 0)
                              <div class="row mt-3">
                                  <!-- Tarjeta para cada marca dentro del contenido desplegable -->
                                  @foreach($empresa->marcas as $marca)
                                    <div class="col-lg-6 mb-5" style="font-size: 14px">
                                        <div class="card bg-label-primary">
                                            <div class="card-body">
                                                <p class="card-title"><b>{{ $marca->marca }}</b></p>
                                                <p class="card-text">
                                                  Folio: {{ $marca->folio }} <span class="d-block mt-2">
                                                  Norma: {{ $marca->catalogo_norma_certificar->norma }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                  @endforeach
                              </div>
                          @endif
                      </div>
                  </div>
              </div>
          </div>
        </div><!--FIN-->
        
       
          



        <br>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection


