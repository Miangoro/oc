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
@vite(['resources/js/impi.js'])
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
            <select id="id_empresa" class="form-select select2">
                {{--<option value="" disabled selected>Selecciona la empresa</option>
                 @foreach ($empresas as $cliente)
                  <option value="{{ $cliente->id_empresa ?? '' }}">
                    {{ $cliente->empresaNumClientes[0]->numero_cliente ?? $cliente->empresaNumClientes[1]->numero_cliente }} | {{ $cliente->razon_social }}
                  </option>
                @endforeach --}}
                @foreach ($empresa->empresaNumClientes as $cliente)
                    <option value="{{ $empresa->id_empresa }}">
                        {{ $cliente->numero_cliente }} | {{ $empresa->razon_social }}
                    </option>
                @endforeach
            </select>
        </div>

        <!--CARDS-->
        <div id="tarjetas" class="form-floating-outline m-2 row">
            <!-- TARJETA 1 -->
            <div class="col-md-6 col-xl-4 mb-3">
               <div class="accordion">
                  <div class="accordion-item">
                        <!-- Título -->
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white {{ $empresa && $empresa->instalaciones->count() > 0 ? 'bg-primary' : 'bg-danger' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                INSTALACIONES ({{ $empresa->instalaciones->count() }}) <br><br>
                                @if ($empresa && $empresa->instalaciones->count() > 0)
                                    Despliega para ver instalaciones
                                @else
                                    Sin registros
                                @endif
                            </button>
                        </h5>
                        <!-- Contenido que despliega -->
                        <div id="collapseOne" class="accordion-collapse collapse p-3">
                            <div class="row">
                            @if ($empresa && $empresa->instalaciones->count() > 0)
                                @foreach($empresa->instalaciones as $instalacion)
                                    <div class="col-lg-6 mb-3" style="font-size: 14px">
                                        <div class="card bg-label-primary">
                                            <div class="card-body">
                                                <p class="card-title"><b> {{ implode(', ', json_decode($instalacion->tipo, true)) }} </b></p>
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
                <div class="accordion">
                    <div class="accordion-item">
                        <!-- Título -->
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white {{ $empresa && $empresa->users->count() > 0 ? 'bg-primary' : 'bg-danger' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                USUARIOS ({{ $empresa->users->count() }}) <br><br>
                                @if($empresa && $empresa->users->count() > 0)
                                    Despliega para ver los usuarios
                                @else
                                    Sin registros
                                @endif
                            </button>
                        </h5>
                        <!-- Contenido que despliega -->
                        <div id="collapseTwo" class="accordion-collapse collapse row p-3">
                            @if($empresa && $empresa->users->count() > 0)
                                @foreach($empresa->users as $usuarios)
                                    <div class="col-lg-6 mb-3" style="font-size: 14px">
                                        <div class="card bg-label-info">
                                            <div class="card-body">
                                                <p class="card-title"><b>{{ $usuarios->name }}</b></p>
                                                <p class="card-text">
                                                    Correo: {{ $usuarios->email }} <span class="d-block mt-2">
                                                    Teléfono: {{ $usuarios->telefono ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p>No hay usuarios registrados para esta empresa.</p>
                            @endif
                        </div>
                  </div>
               </div>
            </div>

            <!-- TARJETA 3 -->
            <div class="col-md-6 col-xl-4 mb-3">
              <div class="accordion">
                  <div class="accordion-item">
                    <!-- Título -->
                    <h5 class="accordion-header">
                        <button class="accordion-button text-white {{ $empresa && $empresa->marcas->count() > 0 ? 'bg-primary' : 'bg-danger' }}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion3">
                            MARCAS ({{ $empresa->marcas->count() }})<br><br>
                            @if($empresa && $empresa->marcas->count() > 0)
                                Despliega para ver las marcas
                            @else
                                Sin registros
                            @endif
                        </button>
                    </h5>
                    <!-- Contenido que despliega -->
                    <div id="coleccion3" class="accordion-collapse collapse row p-3">
                        @if($empresa && $empresa->marcas->count() > 0)
                            @foreach($empresa->marcas as $marca)
                            <div class="col-lg-6 mb-3" style="font-size: 14px">
                                <div class="card bg-label-warning">
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
                        @else
                            <p>No hay marcas registradas para esta empresa.</p>
                        @endif
                    </div>
                  </div>
               </div>
            </div>

            <!-- TARJETA 4 -->
            <div class="col-md-6 col-xl-4 mb-3">
                <div class="accordion">
                    <div class="accordion-item">
                        <!-- Título -->
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white {{ $empresa && $empresa->lotes_granel->count() > 0 ? 'bg-primary' : 'bg-danger' }}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion4">
                                LOTES GRANEL ({{ $empresa->lotes_granel->count() }})<br><br>
                                @if($empresa && $empresa->lotes_granel->count() > 0)
                                    Despliega para ver las lotes granel
                                @else
                                    Sin registros
                                @endif
                            </button>
                        </h5>
                        <!-- Contenido que despliega -->
                        <div id="coleccion4" class="accordion-collapse collapse row p-3">
                            @if($empresa && $empresa->lotes_granel->count() > 0)
                                @foreach($empresa->lotes_granel as $LoteGranel)
                                <div class="col-lg-6 mb-3" style="font-size: 14px">
                                    <div class="card bg-label-danger">
                                        <div class="card-body">
                                            <p class="card-title"><b>{{ $LoteGranel->nombre_lote }}</b></p>
                                            <p class="card-text">
                                                Volumen: {{ $LoteGranel->volumen }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p>No hay lotes granel registrados para esta empresa.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- TARJETA 5 -->
            <div class="col-md-6 col-xl-4 mb-3">
                <div class="accordion">
                    <div class="accordion-item">
                        <!-- Título -->
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white {{ $empresa && $empresa->lotes_envasado->count() > 0 ? 'bg-primary' : 'bg-danger' }}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion5">
                                LOTES ENVASADOS ({{ $empresa->lotes_envasado->count() }})<br><br>
                                @if($empresa && $empresa->lotes_envasado->count() > 0)
                                    Despliega para ver las lotes granel
                                @else
                                    Sin registros
                                @endif
                            </button>
                        </h5>
                        <!-- Contenido que despliega -->
                        <div id="coleccion5" class="accordion-collapse collapse row p-3">
                            @if($empresa && $empresa->lotes_envasado->count() > 0)
                                @foreach($empresa->lotes_envasado as $LoteEnvasado)
                                <div class="col-lg-6 mb-3" style="font-size: 14px">
                                    <div class="card bg-label-dark">
                                        <div class="card-body">
                                            <p class="card-title"><b>{{ $LoteEnvasado->nombre }}</b></p>
                                            <p class="card-text">
                                                Marca: {{ $LoteEnvasado->marca->marca ?? 'Sin marca'}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p>No hay lotes envasados registrados para esta empresa.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- TARJETA 6 -->
            <div class="col-md-6 col-xl-4 mb-3">
                <div class="accordion">
                    <div class="accordion-item">
                        <!-- Título -->
                        <h5 class="accordion-header">
                            <button class="accordion-button text-white {{-- {{ $empresa && $empresa->marcas->count() > 0 ? 'bg-primary' : 'bg-danger' }} --}}bg-danger" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion6">
                                OTRO ( {{-- {{ $empresa->marcas->count() }} --}})<br><br>
                                {{-- @if($empresa && $empresa->marcas->count() > 0)
                                    Despliega para ver las lotes granel
                                @else --}}
                                    Sin registros
                                {{-- @endif --}}
                            </button>
                        </h5>
                        <!-- Contenido que despliega -->
                        <div id="coleccion6" class="accordion-collapse collapse row p-3">
                            {{-- @if($empresa && $empresa->marcas->count() > 0)
                                @foreach($empresa->marcas as $marca)
                                <div class="col-lg-6 mb-3" style="font-size: 14px">
                                    <div class="card bg-label-secondary"><!--success-->
                                        <div class="card-body">
                                            <p class="card-title"><b>{{ $marca->marca }}</b></p>
                                            <p class="card-text">
                                                Volumen: {{ $marca->folio }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else --}}
                                <p>No hay registros para esta empresa.</p>
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>
            </div>

        </div><!--CARDS FIN-->
        
       
        
    <br>
    </form>
    </div>
    </div>
  </div>
</div>


<!----------------------->
<script>

</script>



@endsection

