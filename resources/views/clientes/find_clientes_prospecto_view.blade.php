@extends('layouts/layoutMaster')

@section('title', 'Clientes prospecto')

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
@vite(['resources/js/clientes_prospecto.js'])
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
          <div class="form-floating-outline m-2 row">
            
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

          </div><!--FIN CARDS-->




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
                            <div class="accordion-body">
                              @php
                                  $counter = 1;  
                              @endphp
                                @if($empresa && $empresa->instalaciones->count() > 0)
                                    @foreach($empresa->instalaciones as $instalacion)
                                        {{ $counter }}. {{ $instalacion->direccion_completa }}<br><br>
                                      @php
                                          $counter++;
                                      @endphp
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
                                <div class="row mt-4">
                                    <!-- Tarjeta para cada marca dentro del contenido desplegable -->
                                    @foreach($empresa->marcas as $marca)
                                        <div class="col-md-6 col-xl-4 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <p class="card-title" style="font-size: 15px"><b>{{ $marca->marca }}</b></p>
                                                    <p class="card-text">Folio: {{ $marca->folio }}</p>
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
        </div>
        
       
          



        <br>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection




<!-- Users List Table 
<div class="card">
  <div class="card-header pb-0y">
    <h3 class="card-title mb-0">Clientes prospecto</h3>
  </div>
  <div class="card-datatable table-responsive">
    <table class="datatables-users table">
      <thead class="table-dark">
        <tr>
          <th></th>
          <th>Id</th>
          <th>Cliente</th>
          <th>Domicilio fiscal</th>
          <th>Régimen</th>
          <th>Norma</th>
          <th>Formato de solicitud</th>
          <th>Acciones</th>
        </tr>
      </thead>
    </table>
  </div>
-->

  <!-- Offcanvas to add new user
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasValidarSolicitud" aria-labelledby="offcanvasValidarSolicitudLabel">
    <div class="offcanvas-header border-bottom">
      <h5 id="offcanvasValidarSolicitudLabel" class="offcanvas-title">Validar solicitud</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 h-100">
      <form class="add-new-user pt-0" id="addNewUserForm">
        <input type="hidden" name="id_empresa" id="empresa_id">
        <div class="row">

                      <div class="col-md-12">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <span class="card-title">Se cuenta con todos los medios para realizar todas las actividades de evaluación para la
                                      Certificación</span>
                                    <p>
                                        <label>
                                            <input name="medios" type="radio" value="Si" />
                                            <span><strong>Sí</strong></span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input name="medios" type="radio" value="No" />
                                            <span><strong>No</strong></span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 pt-5">
                          <div class="card mb-5">
                              <div class="card-body">
                                  <span class="card-title">El organismo de Certificación tiene la competencia para realizar la Certificación:</span>
                                  <p>
                                      <label>
                                          <input name="competencia" type="radio" value="Si" />
                                          <span><strong>Sí</strong></span>
                                      </label>
                                  </p>
                                  <p>
                                      <label>
                                          <input name="competencia" type="radio" value="No" />
                                          <span><strong>No</strong></span>
                                      </label>
                                  </p>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-12 pt-5">
                        <div class="card mb-5">
                            <div class="card-body">
                                <span class="card-title">El organismo de Certificación tiene la capacidad para llevar a cabo las actividades de
                                  certificación.</span>
                                <p>
                                    <label>
                                        <input name="capacidad" type="radio" value="Si" />
                                        <span><strong>Sí</strong></span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input name="capacidad" type="radio" value="So" />
                                        <span><strong>No</strong></span>
                                    </label>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating form-floating-outline mb-6 mt-5">
                      <textarea name="comentarios" class="form-control h-px-100" id="exampleFormControlTextarea1" placeholder="Comentarios aquí..."></textarea>
                      <label for="exampleFormControlTextarea1">Comentarios</label>
                    </div>


        </div>
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Valiar</button>
        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
      </form>
    </div>
  </div>

</div>-->


<!-- Modal -->
{{-- @include('_partials/_modals/modal-pdfs-frames')
@include('_partials/_modals/modal-add-aceptar-cliente') 
@include('_partials/_modals/modal-edit-cliente-prospecto') 
<!-- /Modal -->
@endsection--}}


<!--
<script>
    function abrirModal(id_empresa) {
    // Hacer una petición AJAX para obtener los detalles de la empresa
    $.ajax({
        url: '/lista_empresas/' + id_empresa,
        method: 'GET',
        success: function(response) {
            // Cargar los detalles en el modal
            var contenido = "";

          for (let index = 0; index < response.normas.length; index++) {
            contenido = '<input value="'+response.normas[index].id_norma+'" type="hidden" name="id_norma[]"/><div class="col-12 col-md-12 col-sm-12"><div class="form-floating form-floating-outline"><input type="text" id="numero_cliente'+response.normas[index].id_norma+'" name="numero_cliente[]" class="form-control" placeholder="Introducir el número de cliente" /><label for="modalAddressFirstName">Número de cliente para la norma '+response.normas[index].norma+'</label></div></div><br>' + contenido;
            console.log(response.normas[index].norma);
          }


            $('.contenido').html(contenido);

            // Abrir el modal
            $('#aceptarCliente').modal('show');
        },
        error: function() {
            alert('Error al cargar los detalles de la empresa.');
        }
    });
  }
</script>
-->