@php
    $configData = Helper::appClasses();
    $isMenu = false;
    $navbarHideToggle = false;
    $isNavbar = false;

@endphp

@extends('layouts.layoutMaster')

@section('title', 'Solicitud de información del cliente')


<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/bs-stepper/bs-stepper.scss', 'resources/assets/vendor/fonts/personalizados/style.css'])


    <!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/bs-stepper/bs-stepper.js'])


@section('content')

    <style>
        body {
            background-image: url(assets/img/branding/fondo.png);
        }

        .bs-stepper-header {
            background-color: #0c1444;
            color: white;
        }

        .bs-stepper .step-trigger {
            color: white;
        }

        .light-style .bs-stepper.wizard-icons .bs-stepper-header .bs-stepper-label {
            color: white;
        }

        /* Usando la variable de Bootstrap para el color primario */
        /*         .custom-option.active {
            border: 1px solid var(--bs-primary);
           } */
        .custom-option.active {
            border: 2px solid #8eb3ae;
        }
    </style>
    <div class="card">
        <img alt="Organismo de certificación" src="{{ asset('assets/img/branding/Banner solicitud_información.png') }}"
            alt="timeline-image" class="card-img-top " style="object-fit: cover;">
        <div class="bs-stepper wizard-icons wizard-icons-example">


            <div class="bs-stepper-header">
                <div class="step" data-target="#account-details">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                            <i class="ri-user-fill fs-1"></i>
                        </span>
                        <span class="bs-stepper-label">Información del cliente</span>
                    </button>
                </div>
                <div class="line">
                    <i class="ri-arrow-right-s-line"></i>
                </div>
                <div class="step" data-target="#social-links">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                            <i class="icon-produto-certificado fs-1"></i>
                        </span>
                        <span class="bs-stepper-label">Producto a certificar</span>
                    </button>
                </div>
                <div class="line">
                    <i class="ri-arrow-right-s-line"></i>
                </div>
                <div class="step" data-target="#address">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                            <i class="ri-map-pin-fill fs-1"></i>
                        </span>
                        <span class="bs-stepper-label">Dirección</span>
                    </button>
                </div>
                <div class="line">
                    <i class="ri-arrow-right-s-line"></i>
                </div>
                <div class="step" data-target="#personal-info-icon">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-icon">
                            <i class="ri-information-2-fill fs-2"></i>
                        </span>
                        <span class="bs-stepper-label">Información del producto</span>
                    </button>
                </div>
            </div>


            <div class="bs-stepper-content">
                <form action="{{ url('/solicitud-cliente-registrar') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <!-- información del cliente -->
                    <div id="account-details" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Información del cliente</h6>
                            <small>información del cliente.</small>
                        </div>
                        <div class="row g-5">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control" name="regimen" id="regimen">
                                        <option value="Persona física">Persona física</option>
                                        <option value="Persona moral">Persona moral</option>
                                    </select>
                                    <label for="username">Régimen fiscal</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-floating form-floating-outline">
                                    <input maxlength="13" type="text" name="rfc" class="form-control"
                                        placeholder="Introduce el RFC" required />
                                    <label for="username">RFC</label>
                                </div>
                            </div>
                            <div style="display: none" id="representante" class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-floating form-floating-outline">
                                    <input id="nombreRepresentante" type="text" name="representante" class="form-control"
                                        placeholder="Introduce el nombre del representante legal" />
                                    <label for="username">Representante legal</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="username" name="razon_social" class="form-control"
                                        placeholder="Introduce tu nombre completo" required />
                                    <label for="username">Nombre del cliente/empresa</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="email" id="email" name="correo" class="form-control"
                                        placeholder="Introduce tu correo electrónico" aria-label="john.doe" required />
                                    <label for="email">Correo Electrónico</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="telefono" name="telefono"
                                        class="form-control phone-number-mask"
                                        placeholder="Introduce tu numero de teléfono" required
                                        title="El teléfono debe tener 10 dígitos numéricos." />
                                    <label for="username">Teléfono</label>
                                </div>
                            </div>
                            <hr>
                            <!-- botones  -->
                            <div class="col-12 d-flex justify-content-between">
                                <button type="button" class="btn btn-outline-danger btn-prev" disabled> <i
                                        class="ri-arrow-left-line me-sm-1"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-next"> <span
                                        class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span> <i
                                        class="ri-arrow-right-line"></i></button>
                            </div>
                        </div>

                    </div>

                    <!-- Social Links -->
                    <div id="social-links" class="content">
                        <!-- 1. Delivery Type -->
                        <h6>Producto(s) que se va a certificar</h6>
                        <div class="row gy-3 align-items-start">
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon1">
                                        <span class="custom-option-body">
                                            <i class="icon-mezcal fs-1"></i>
                                            <small>Mezcal.</small>
                                        </span>
                                        <input name="producto[]" value="1" class="form-check-input" type="checkbox"
                                            value="" id="customRadioIcon1" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon2">
                                        <span class="custom-option-body">
                                            <i class="icon-bebida-mezcal"></i>
                                            <small>Bebida preparada con Mezcal</small>
                                        </span>
                                        <input name="producto[]" value="2" class="form-check-input" type="checkbox"
                                            value="" id="customRadioIcon2" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon3">
                                        <span class="custom-option-body">
                                            <i class="ri-goblet-fill"></i>
                                            <small>Cóctel que contiene Mezcal</small>
                                        </span>
                                        <input name="producto[]" value="3" class="form-check-input" type="checkbox"
                                            value="" id="customRadioIcon3" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon4">
                                        <span class="custom-option-body">
                                            <i class="icon-licor"></i>
                                            <small>Licor y/o crema que contiene Mezcal</small>
                                        </span>
                                        <input name="producto[]" value="4" class="form-check-input" type="checkbox"
                                            value="" id="customRadioIcon4" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- 2. Delivery Type -->
                        <h6 class="my-4">Documentos normativos para los cuales busca la certificación:</h6>
                        <div class="row gy-3 align-items-start">
                            <div class="col-md">
                                <div class=" custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon5">
                                        <span class="custom-option-body">
                                            <small>NOM-070-SCFI-2016</small>
                                        </span>
                                        <input name="norma[]" class="form-check-input" type="checkbox" value="1"
                                            id="customRadioIcon5" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class=" custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon6">
                                        <span class="custom-option-body">
                                            <small>NOM-251-SSA1-2009</small>
                                        </span>
                                        <input name="norma[]" class="form-check-input" type="checkbox" value="2"
                                            id="customRadioIcon6" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class=" custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioIcon7">
                                        <span class="custom-option-body">
                                            <small>NMX-V-052-NORMEX-2016</small>
                                        </span>
                                        <input name="norma[]" class="form-check-input" type="checkbox" value="3"
                                            id="customRadioIcon7" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        {{-- secciones ocultas --}}
                        <div id="nom070-section" style="display: none;">
                            <h6 class="my-4">Actividad del cliente NOM-070-SCFI-2016:</h6>
                            <div class="row gy-3 align-items-start">
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon8">
                                            <span class="custom-option-body">
                                                <i class="icon-agave"></i>
                                                <small>Productor de Agave</small>
                                            </span>
                                            <input name="actividad[]" class="form-check-input" type="checkbox"
                                                value="1" id="customRadioIcon8" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon9">
                                            <span class="custom-option-body">
                                                <i class="icon-envasador"></i>
                                                <small>Envasador de Mezcal</small>
                                            </span>
                                            <input name="actividad[]" class="form-check-input" type="checkbox"
                                                value="2" id="customRadioIcon9" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon10">
                                            <span class="custom-option-body">
                                                <i class="icon-productor-tequila"></i>
                                                <small>Productor de Mezcal</small>
                                            </span>
                                            <input name="actividad[]" class="form-check-input" type="checkbox"
                                                value="3" id="customRadioIcon10" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-check custom-option custom-option-icon">
                                        <label class="form-check-label custom-option-content" for="customRadioIcon11">
                                            <span class="custom-option-body">
                                                <i class="icon-comercializador"></i>
                                                <small>Comercializador de Mezcal</small>
                                            </span>
                                            <input name="actividad[]" class="form-check-input" type="checkbox"
                                                value="4" id="customRadioIcon11" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>




                        {{-- fin de la secciones ocultas --}}
                        <div class="col-12 d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-outline-danger btn-prev">
                                <i class="ri-arrow-left-line me-sm-1"></i>
                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                            </button>
                            <button type="button" class="btn btn-primary btn-next">
                                <span class="align-middle d-sm-inline-block d-none">Siguiente</span>
                                <i class="ri-arrow-right-line"></i>
                            </button>
                        </div>
                    </div>


                    {{-- direccion --}}
                    <div id="address" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Domicilio Fiscal</h6>
                            <small>Ingrese los datos del primer domicilio fiscal</small>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="localidad1" name="localidad1"
                                        required placeholder=" ">
                                    <label for="localidad1">Domicilio completo</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control custom-select" name="estado" id="estado" required>
                                        <option disabled selected>selecciona un estado</option>
                                        @foreach ($estados as $estado)
                                            <option value="{{ $estado }}">{{ $estado }}</option>
                                        @endforeach
                                    </select>
                                    <label for="estado">Estado</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 offset-md-6 d-flex justify-content-end align-items-center flex-column">
                                <div class="text-light small fw-medium mb-2">Seleccionar</div>
                                <label class="switch">
                                    <input type="checkbox" class="switch-input" />
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"></span>
                                        <span class="switch-off"></span>
                                    </span>
                                    <span class="switch-label">Usar la misma dirección fiscal</span>
                                </label>
                            </div>
                        </div>
                        <hr>
                        {{-- se generan las direcciones --}}

                        <div id="domiProductAgace" style="display: none;">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Domicilio de Productor de Agave:</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="localidad2" name="localidad2"
                                            required placeholder=" ">
                                        <label for="localidad2">Domicilio completo</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control custom-select" name="estado2" id="estado2"
                                            required>
                                            <option disabled selected>selecciona un estado</option>
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado }}">{{ $estado }}</option>
                                            @endforeach
                                        </select>
                                        <label for="estado2">Estado</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>


                        <div id="domiEnvasaMezcal" style="display: none;">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Domicilio de Envasador de Mezcal:</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="localidad3" name="localidad3"
                                            required placeholder=" ">
                                        <label for="localidad3">Domicilio completo</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control custom-select" name="estado3" id="estado3"
                                            required>
                                            <option disabled selected>selecciona un estado</option>
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado }}">{{ $estado }}</option>
                                            @endforeach
                                        </select>
                                        <label for="estado3">Estado</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>


                        <div id="domiProductMezcal" style="display: none;">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Domicilio de Productor de Mezcal:</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="localidad4" name="localidad4"
                                            required placeholder=" ">
                                        <label for="localidad4">Domicilio completo</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control custom-select" name="estado4" id="estado4"
                                            required>
                                            <option disabled selected>selecciona un estado</option>
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado }}">{{ $estado }}</option>
                                            @endforeach
                                        </select>
                                        <label for="estado4">Estado</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                        <div id="domiComerMezcal" style="display: none;">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Domicilio de Comercializador de Mezcal:</h6>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="localidad5" name="localidad5"
                                            required placeholder=" ">
                                        <label for="localidad5">Domicilio completo</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-control custom-select" name="estado5" id="estado5"
                                            required>
                                            <option disabled selected>selecciona un estado</option>
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado }}">{{ $estado }}</option>
                                            @endforeach
                                        </select>
                                        <label for="estado5">Estado</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>


                        {{--  --}}

                        <div class="col-12 d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-outline-danger btn-prev">
                                <i class="ri-arrow-left-line me-sm-1"></i>
                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                            </button>
                            <button type="button" class="btn btn-primary btn-next">
                                <span class="align-middle d-sm-inline-block d-none">Siguiente</span>
                                <i class="ri-arrow-right-line"></i>
                            </button>
                        </div>
                    </div>


                    <!-- Información sobre los Procesos y productos a certificar por el cliente -->
                    <div id="personal-info-icon" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Información sobre los Procesos y productos a certificar por el cliente</h6>
                        </div>
                        <div class="row g-5">
                            <div class="col-12">
                                <div class="form-floating form-floating-outline mb-6">
                                    <textarea maxlength="2000" class="form-control h-px-100" id="certification-details" name="info_procesos" required
                                        placeholder=""></textarea>
                                    <label for="certification-details">Describa los procesos y productos a
                                        certificar</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- botones  -->
                        <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-danger btn-prev"> <i
                                    class="ri-arrow-left-line me-sm-1"></i>
                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                            </button>
                            <button type="submit" class="btn btn-primary btn-submit">Enviar solicitud</button>
                        </div>
                        <!--   -->
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection

@section('page-script')

    @vite(['resources/assets/vendor/libs/cleavejs/cleave.js'])
    @vite(['resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
    @vite(['resources/assets/js/solicitud-cliente.js'])
