@php
$configData = Helper::appClasses();
$isMenu = false;
$navbarHideToggle =false;
$isNavbar = false;

@endphp

@extends('layouts.layoutMaster')

@section('title', 'Solicitud de información del cliente')


<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
])


<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
])


@section('content')

<style>
  img{ 
    border-start-start-radius: 10px;
    border-start-end-radius: 10px; 
    width: 100%;
    height: 170px;
  }
  

</style>

<div class="bs-stepper wizard-icons wizard-icons-example mt-2">

  <div class="">
    <img src="\assets\img\branding\validacion_certificacion.png" alt="validacion de certificacion">
  </div>

  <div class="bs-stepper-header">
    <div class="step" data-target="#account-details">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <i class="ri-user-fill fs-2"></i>
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
          <i class="ri-ink-bottle-fill fs-2"></i>
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
          <i class="ri-map-pin-fill fs-2"></i>
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
      <form action="{{ url('/solicitud-cliente-registrar') }}" method="POST" role="form" enctype="multipart/form-data">
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
              <input maxlength="13" type="text" name="rfc" class="form-control" placeholder="Introduce el RFC" required />
              <label for="username">RFC</label>
            </div>
          </div> 
          <div style="display: none" id="representante" class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-floating form-floating-outline">
              <input id="nombreRepresentante" type="text" name="representante" class="form-control" placeholder="Introduce el nombre del representante legal"  />
              <label for="username">Representante legal</label>
            </div>
          </div> 
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-floating form-floating-outline">
              <input type="text" id="username" name="razon_social" class="form-control" placeholder="Introduce tu nombre completo" required />
              <label for="username">Nombre del cliente/empresa</label>
            </div>
          </div>      
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-floating form-floating-outline">
              <input type="email" id="email" name="correo" class="form-control" placeholder="Introduce tu correo electrónico" aria-label="john.doe" required />
              <label for="email">Correo Electrónico</label>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="form-floating form-floating-outline">
              <input type="text" id="telefono" name="telefono" class="form-control phone-number-mask" placeholder="Introduce tu numero de teléfono" required title="El teléfono debe tener 10 dígitos numéricos." />
              <label for="username">Teléfono</label>
            </div>
          </div>
          <hr>
          <!-- botones  -->
          <div class="col-12 d-flex justify-content-between">
            <button type="button" class="btn btn-outline-danger btn-prev" disabled> <i class="ri-arrow-left-line me-sm-1"></i>
              <span class="align-middle d-sm-inline-block d-none">Anterior</span>
            </button>
            <button type="button" class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span> <i class="ri-arrow-right-line"></i></button>
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
                    <i class="ri-ink-bottle-fill"></i>
                    <small>Mezcal.</small>
                  </span>
                  <input name="producto[]" value="1" class="form-check-input" type="checkbox" value="" id="customRadioIcon1" />
                </label>
              </div>
            </div>
            <div class="col-md">
              <div class="form-check custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="customRadioIcon2">
                  <span class="custom-option-body">
                    <i class="ri-ink-bottle-fill"></i>
                    <small>Bebida alcohólica preparada que contiene Mezcal</small>
                  </span>
                  <input name="producto[]" value="2" class="form-check-input" type="checkbox" value="" id="customRadioIcon2" />
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
                  <input name="producto[]" value="3" class="form-check-input" type="checkbox" value="" id="customRadioIcon3" />
                </label>
              </div>
            </div>
            <div class="col-md">
              <div class="form-check custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="customRadioIcon4">
                  <span class="custom-option-body">
                    <i class="ri-goblet-2-fill"></i>
                    <small>Licor y/o crema que contiene Mezcal</small>
                  </span>
                  <input name="producto[]" value="4" class="form-check-input" type="checkbox" value="" id="customRadioIcon4" />
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
                  <input name="norma[]" class="form-check-input" type="checkbox" value="1" id="customRadioIcon5" />
                </label>
              </div>
            </div>
            <div class="col-md">
              <div class=" custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="customRadioIcon6">
                  <span class="custom-option-body">
                    <small>NOM-251-SSA1-2009</small>
                  </span>
                  <input name="norma[]" class="form-check-input" type="checkbox" value="2" id="customRadioIcon6" />
                </label>
              </div>
            </div>
            <div class="col-md">
              <div class=" custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="customRadioIcon7">
                  <span class="custom-option-body">
                    <small>NMX-V-052-NORMEX-2016</small>
                  </span>
                  <input name="norma[]" class="form-check-input" type="checkbox" value="3" id="customRadioIcon7" />
                </label>
              </div>
            </div>
          </div>
          <hr>
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



      <!-- Address -->
      <div id="address" class="content">
        <div class="content-header mb-4">
            <h6 class="mb-0">Domicilio Fiscal</h6>
            <small>Ingrese los datos del primer domicilio fiscal</small>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="calle1" name="calle1" required placeholder="">
                    <label for="calle1">Calle</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="numero1" name="numero1" required placeholder="">
                    <label for="numero1">Número</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="colonia1" name="colonia1" required placeholder="">
                    <label for="colonia1">Colonia</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="localidad1" name="municipio1" required placeholder="">
                    <label for="localidad1">Localidad/Municipio/Ciudad/Estado</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="cp1" name="cp1"  placeholder=""  title="El codigo postal debe tener 5 dígitos numéricos.">
                    <label for="cp1">C.P.</label>
                </div>
            </div>
        </div>

        <hr>
        <div class="content-header mb-4">
            <h6 class="mb-0">Domicilio de</h6>
            <small>Ingrese los datos del domicilio</small>
        </div>
        <div class="row g-3" id="address1">
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="calle2" name="calle2" placeholder=" ">
                    <label for="calle2">Domicilio de</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="calle2" name="calle2" placeholder=" ">
                    <label for="calle2">Calle</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="numero2" name="numero2" placeholder=" ">
                    <label for="numero2">Número</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="colonia2" name="colonia2" placeholder=" ">
                    <label for="colonia2">Colonia</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="localidad2" name="localidad2" placeholder=" ">
                    <label for="localidad2">Localidad/Municipio/Ciudad/Estado</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="cp2" name="cp2" placeholder=" "  title="El codigo postal debe tener 5 dígitos numéricos.">
                    <label for="cp2">C.P.</label>
                </div>
            </div>
        </div>
        <hr>
        <!-- Aquí se clonará la dirección -->
        <div id="clonedAddresses"></div>

        <!-- Botón para agregar dirección -->
        <div class="mb-3">
            <button type="button" class="btn btn-primary" id="addAddressBtn">
                <i class="ri-add-circle-fill me-1"></i>
                Agregar otra dirección
            </button>
        </div>

        <hr>
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
                  <textarea maxlength="2000" class="form-control h-px-100" id="certification-details" name="info_procesos" required placeholder=""></textarea>
                  <label for="certification-details">Describa los procesos y productos a certificar</label>
                </div>
              </div>
            </div>
            <hr>
          <!-- botones  -->
            <div class="col-12 d-flex justify-content-between">
              <button type="button" class="btn btn-outline-danger btn-prev"> <i class="ri-arrow-left-line me-sm-1"></i>
                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
              </button>
              <button type="submit" class="btn btn-primary btn-submit">Enviar solicitud</button>
            </div>
          <!--   -->
        </div>
        
    </form>
  </div>
  
</div>
@endsection

@section('page-script')

@vite(['resources/assets/vendor/libs/cleavejs/cleave.js'])
@vite(['resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
@vite(['resources/assets/js/solicitud-cliente.js'])
