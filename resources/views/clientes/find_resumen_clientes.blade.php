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
                <option value="" disabled selected>Selecciona la empresa</option>
                 @foreach ($empresas as $cliente)
                  <option value="{{ $cliente->id_empresa }}">
                    {{ $cliente->empresaNumClientes[0]->numero_cliente ?? $cliente->empresaNumClientes[1]->numero_cliente }} | {{ $cliente->razon_social }}
                  </option>
                @endforeach
            </select>
        </div>

        <!--CARDS-->
        <div id="tarjetas" class="form-floating-outline m-2 row">
            {{-- <!-- TARJETA 1 -->
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
            </div> --}}

        </div><!--CARDS FIN-->
        
        
    <br>
    </form>
    </div>
    </div>
  </div>
</div>


<!----------------------->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#id_empresa').change(function() {
        var id_empresa = $(this).val();

        if(id_empresa) {
            //solicitud AJAX para obtener los datos de la empresa seleccionada
            $.ajax({
                url: '/get-datos-empresa/' + id_empresa,
                type: 'GET',
                success: function(response) {
                    // Actualizar las tarjetas con la respuesta
                    updateTarjetas(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error al obtener los datos");
                }
            });
        }
    });


    function updateTarjetas(empresa) {//Actualiza las tarjetas
    var tarjetasHTML = '';

        //INSTALACIONES
        var instalaciones = empresa.instalaciones.length > 0 
            ? empresa.instalaciones.map(function(instalacion) {
                var tipos = JSON.parse(instalacion.tipo).join(', ');//tipo de instalacion
                var dictamen = '<span class="badge rounded-pill bg-danger">Sin dictamen</span>'; //Valor por defecto
                var certificado = '<span class="badge rounded-pill bg-danger">Sin certificado</span>';
                    if (instalacion.dictamen) {
                    var fechaVigencia = new Date(instalacion.dictamen.fecha_vigencia);
                    var fechaActual = new Date();
                        if (fechaVigencia < fechaActual) {
                            dictamen = `${instalacion.dictamen.num_dictamen}<span class="badge rounded-pill bg-danger">Vencido</span>`;
                        } else {
                            dictamen = `${instalacion.dictamen.num_dictamen}`;
                        }
                    }     
                    if (instalacion.certificado) {// Verificar si existe un certificado asociado al dictamen
                    var fechaVigencia = new Date(instalacion.certificado.fecha_vencimiento);
                        if (fechaVigencia < fechaActual) {
                            certificado = `${instalacion.certificado.num_certificado} <span class="badge rounded-pill bg-danger">Vencido</span>`;
                        } else {
                            certificado = `${instalacion.certificado.num_certificado}`;
                        }   
                    }
                return `<div class="col-lg-6 mb-3" style="font-size: 14px">
                            <div class="card bg-label-primary">
                                <div class="card-body">
                                    <b class="card-title">${tipos}</b> <span class="d-block mt-1">
                                    Dirección: ${instalacion.direccion_completa} <span class="d-block mt-3">
                                    Dictamen: ${dictamen} <span class="d-block mt-3">
                                    Certificado: ${certificado}
                                </div>
                            </div>
                        </div> `;
            }).join('') : '<p>No hay instalaciones registradas para esta empresa.</p>';

        tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h5 class="accordion-header">
                                        <button class="accordion-button text-white ${empresa.instalaciones.length > 0 ? 'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                            INSTALACIONES (${empresa.instalaciones.length}) <br><br>
                                            ${empresa.instalaciones.length > 0 ? 'Despliega para ver instalaciones' : 'Sin registros'}
                                        </button>
                                    </h5>
                                    <div id="collapseOne" class="accordion-collapse collapse p-3 row">
                                        ${instalaciones}
                                    </div>
                                </div>
                            </div>
                        </div>`;

        //USUARIOS
        var usuarios = empresa.users.length > 0 
            ? empresa.users.map(function(usuario) {
                return `<div class="col-lg-6 mb-3" style="font-size: 14px">
                            <div class="card bg-label-info">
                                <div class="card-body">
                                    <b class="card-title">${usuario.name}</b> <span class="d-block mt-1">
                                        Correo: ${usuario.email} <span class="d-block mt-3">
                                        Teléfono: ${usuario.telefono || ''}
                                </div>
                            </div>
                        </div> `;
            }).join('') : '<p>No hay usuarios registrados para esta empresa.</p>';

        tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h5 class="accordion-header">
                                        <button class="accordion-button text-white ${empresa.users.length > 0 ? 'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion2">
                                            USUARIOS (${empresa.users.length}) <br><br>
                                            ${empresa.users.length > 0 ? 'Despliega para ver los usuarios' : 'Sin registros'}
                                        </button>
                                    </h5>
                                    <div id="coleccion2" class="accordion-collapse collapse p-3 row">
                                        ${usuarios}
                                    </div>
                                </div>
                            </div>
                        </div>`;

        //MARCAS
        var marcas = empresa.marcas.length > 0 
            ? empresa.marcas.map(function(marca) {
                return `<div class="col-lg-6 mb-3" style="font-size: 14px">
                            <div class="card bg-label-warning">
                                <div class="card-body">
                                    <b class="card-title">${marca.marca}</b> <span class="d-block mt-1">
                                    Folio: ${marca.folio}
                                </div>
                            </div>
                        </div> `;
            }).join('') : '<p>No hay marcas registradas para esta empresa.</p>';

        tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h5 class="accordion-header">
                                        <button class="accordion-button text-white ${empresa.marcas.length > 0 ? 'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion3">
                                            MARCAS (${empresa.marcas.length}) <br><br>
                                            ${empresa.marcas.length > 0 ? 'Despliega para ver las marcas' : 'Sin registros'}
                                        </button>
                                    </h5>
                                    <div id="coleccion3" class="accordion-collapse collapse p-3 row">
                                        ${marcas}
                                    </div>
                                </div>
                            </div>
                        </div>`;

        //LOTES GRANEL
        var lotesGranel = empresa.lotes_granel.length > 0 
            ? empresa.lotes_granel.map(function(lote) {
                return ` <div class="col-lg-6 mb-3" style="font-size: 14px">
                            <div class="card bg-label-danger">
                                <div class="card-body">
                                    <b class="card-title">${lote.nombre_lote}</b> <span class="d-block mt-1">
                                        Volumen: ${lote.volumen} 
                                </div>
                            </div>
                        </div>  `;
            }).join('') : '<p>No hay lotes granel registrados para esta empresa.</p>';

        tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h5 class="accordion-header">
                                        <button class="accordion-button text-white ${empresa.lotes_granel.length > 0 ? 'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion4">
                                            LOTES GRANEL (${empresa.lotes_granel.length}) <br><br>
                                            ${empresa.lotes_granel.length > 0 ? 'Despliega para ver los lotes granel' : 'Sin registros'}
                                        </button>
                                    </h5>
                                    <div id="coleccion4" class="accordion-collapse collapse p-3 row">
                                        ${lotesGranel}
                                    </div>
                                </div>
                            </div>
                        </div>`;

        //LOTES ENVASADOS
        var lotesEnvasado = empresa.lotes_envasado.length > 0 
            ? empresa.lotes_envasado.map(function(loteEnv) {
                return ` <div class="col-lg-6 mb-3" style="font-size: 14px">
                        <div class="card bg-label-dark">
                            <div class="card-body">
                                <b class="card-title">${loteEnv.nombre}</b> <span class="d-block mt-1">
                                    Marca: ${loteEnv.marca && loteEnv.marca.marca ? loteEnv.marca.marca : 'Sin marca'}
                            </div>
                        </div>
                    </div> `;
            }).join('') : '<p>No hay lotes envasados registrados para esta empresa.</p>';

        tarjetasHTML += `<div class="col-md-6 col-xl-4 mb-3">
                            <div class="accordion">
                                <div class="accordion-item">
                                    <h5 class="accordion-header">
                                        <button class="accordion-button text-white ${empresa.lotes_envasado.length > 0 ? 'bg-primary' : 'bg-danger'}" type="button" data-bs-toggle="collapse" data-bs-target="#coleccion5">
                                            LOTES ENVASADOS (${empresa.lotes_envasado.length}) <br><br>
                                            ${empresa.lotes_envasado.length > 0 ? 'Despliega para ver los lotes envasado' : 'Sin registros'}
                                        </button>
                                    </h5>
                                    <div id="coleccion5" class="accordion-collapse collapse p-3 row">
                                        ${lotesEnvasado}
                                    </div>
                                </div>
                            </div>
                        </div>`;


    // Insertar las tarjetas en el HTML
    $('#tarjetas').html(tarjetasHTML);
    }

});
</script>


@endsection
