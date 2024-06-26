@extends('layouts/layoutMaster') 


@section('title', 'solicitud-cliente')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/css/custom.css'
])
@endsection
<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.js',
  'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/datepicker/datepicker.js'
])

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/solicitud-cliente.js'])

@section('content')

<div class="bs-stepper wizard-icons wizard-icons-example mt-2">
  <div class="bs-stepper-header">
    <div class="step" data-target="#account-details">
      <button type="button" class="step-trigger">
        <span class="bs-stepper-icon">
          <svg viewBox="0 0 54 54">
            <use xlink:href='assets/svg/icons/form-wizard-account.svg#wizardAccount'></use>
          </svg>
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
          <svg viewBox="0 0 54 54">
            <use xlink:href='assets/svg/icons/form-wizard-account.svg#wizardAccount'></use>
          </svg>
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
          <svg viewBox="0 0 54 54">
            <use xlink:href='assets/svg/icons/form-wizard-account.svg#wizardAccount'></use>
          </svg>
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
          <svg viewBox="0 0 58 54">
            <use xlink:href='assets/svg/icons/form-wizard-account.svg#wizardAccount'></use>
          </svg>
        </span>
        <span class="bs-stepper-label">Información del producto</span>
      </button>
    </div>

  </div>


  <div class="bs-stepper-content">
    <form onSubmit="return false">
      <!-- información del cliente -->
      <div id="account-details" class="content">
        <div class="content-header mb-4">
          <h6 class="mb-0">Informacion del cliente</h6>
          <small>información del cliente.</small>
        </div>
        <div class="row g-5">
          <div class="col-sm-6">
            <div class="form-floating form-floating-outline">
              <input type="text" id="username" class="form-control" placeholder="johndoe" />
              <label for="username">Nombre del Cliente</label>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-floating form-floating-outline">
              <input type="date" id="fechaSolicitud" class="form-control"  />
              <label for="username">Fecha de solicitud</label>
            </div>
          </div>       
          <div class="col-sm-6">
            <div class="form-floating form-floating-outline">
              <input type="email" id="email" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
              <label for="email">Correo Electrónico</label>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-floating form-floating-outline">
              <input type="tel" id="telefono" class="form-control" placeholder="4351225559" />
              <label for="username">Telefono</label>
            </div>
          </div>


          <div class="col-12 d-flex justify-content-between">
            <button class="btn btn-outline-secondary btn-prev" disabled> <i class="ri-arrow-left-line me-sm-1"></i>
              <span class="align-middle d-sm-inline-block d-none">Anterior</span>
            </button>
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span> <i class="ri-arrow-right-line"></i></button>
          </div>
        </div>
      </div>

      <!-- Address --><!-- Address -->
      <div id="address" class="content">
        <div class="content-header mb-4">
            <h6 class="mb-0">Domicilio</h6>
            <small>Ingrese los datos del primer domicilio fiscal</small>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="calle1" name="calle1" placeholder=" ">
                    <label for="calle1">Calle</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="numero1" name="numero1" placeholder=" ">
                    <label for="numero1">Número</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="colonia1" name="colonia1" placeholder=" ">
                    <label for="colonia1">Colonia</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="localidad1" name="localidad1" placeholder=" ">
                    <label for="localidad1">Localidad/Municipio/Ciudad/Estado</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="cp1" name="cp1" placeholder=" ">
                    <label for="cp1">C.P.</label>
                </div>
            </div>
        </div>

        <hr>

        <div class="content-header mb-4">
            <h6 class="mb-0">Domicilio de</h6>
            <small>Ingrese los datos del domicilio</small>
        </div>
        <div class="row g-3">
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
                    <input type="text" class="form-control" id="cp2" name="cp2" placeholder=" ">
                    <label for="cp2">C.P.</label>
                </div>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-between mt-3">
            <button class="btn btn-outline-secondary btn-prev"> <i class="ri-arrow-left-line me-sm-1"></i>
                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
            </button>
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none">Siguiente</span> <i class="ri-arrow-right-line"></i></button>
        </div>
      </div>


      <!-- Social Links -->
      <div id="social-links" class="content">
        <!-- 1. Delivery Type -->
        <h5 class="my-4">Producto(s) que se va a certificar</h5>
        <h5>Alcance del Organismo Certificador</h5>
        <div class="row gy-3">
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon1">
                        <span class="custom-option-body">
                            <small>Mezcal.</small>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon1" checked />
                    </label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon2">
                        <span class="custom-option-body">
                            <small>Bebida alcohólica preparada que contiene Mezcal</small>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon2" />
                    </label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon3">
                        <span class="custom-option-body">
                            <small>Cóctel que contiene Mezcal</small>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon3" />
                    </label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon4">
                        <span class="custom-option-body">
                            <small>Licor y/o crema que contiene Mezcal</small>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon4" />
                    </label>
                </div>
            </div>
        </div>
        <hr>
    
        <!-- 2. Delivery Type -->
        <h5 class="my-4">Documentos normativos para los cuales busca la certificación:</h5>
        <div class="row gy-3">
            <div class="col-md">
              <div class="form-check custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="customRadioIcon5">
                    <span class="custom-option-body">
                        <small>NOM-070-SCFI-2016</small>
                    </span>
                    <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon5" />
                </label>
            </div>
            </div>
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon6">
                        <span class="custom-option-body">
                            <small>NOM-251-SSA1-2009</small>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon6" />
                    </label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon7">
                        <span class="custom-option-body">
                            <small>NMX-V-052-NORMEX-2016</small>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon7" />
                    </label>
                </div>
            </div>
        </div>
        <hr>
    
        <!-- 3. Delivery Type -->
        <h5 class="my-4">Actividad del cliente NOM-070-SCFI-2016:</h5>
        <div class="row gy-3">
            <div class="col-md">
              <div class="form-check custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="customRadioIcon8">
                    <span class="custom-option-body">
                        <small>Productor de Agave</small>
                    </span>
                    <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon8" />
                </label>
            </div>
            </div>
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon9">
                        <span class="custom-option-body">
                            <small>Envasador de Mezcal</small>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon9" />
                    </label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon10">
                        <span class="custom-option-body">
                            <small>Productor de Mezcal</small>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon10" />
                    </label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon11">
                        <span class="custom-option-body">
                            <small>Comercializador de Mezcal</small>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon11" />
                    </label>
                </div>
            </div>
        </div>
        <hr>
    
        <!-- 4. Delivery Type -->
        <h5 class="my-4">Actividad del cliente NMX-V-052-NORMEX-2016:</h5>
        <div class="row gy-3">
            <div class="col-md">
              <div class="form-check custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="customRadioIcon12">
                    <span class="custom-option-body">
                        <small>Productor de bebidas alcohólicas que contienen Mezcal</small>
                    </span>
                    <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon12" />
                </label>
            </div>
            </div>
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon13">
                        <span class="custom-option-body">
                            <small>Envasador de bebidas alcohólicas que contienen Mezcal</small>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon13" />
                    </label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon14">
                        <span class="custom-option-body">
                            <small>Productor de Mezcal</small>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon14" />
                    </label>
                </div>
            </div>
            <div class="col-md">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon15">
                        <span class="custom-option-body">
                            <small>Comercializador de Mezcal</small>
                        </span>
                        <input name="customRadioIcon" class="form-check-input" type="radio" value="" id="customRadioIcon15" />
                    </label>
                </div>
            </div>
        </div>
        <hr>
    
        <div class="col-12 d-flex justify-content-between mt-4">
            <button class="btn btn-outline-secondary btn-prev">
                <i class="ri-arrow-left-line me-sm-1"></i>
                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
            </button>
            <button class="btn btn-primary btn-next">
                <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
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
                <div class="form-floating form-floating-outline">
                  <input type="text" id="certification-details" class="form-control" placeholder="Describa los procesos y productos a certificar" />
                  <label for="certification-details">Describa los procesos y productos a certificar</label>
                </div>
              </div>
            </div>
            <hr>
          <!-- NOMBRE DEL CLIENTE SOLICITANTE -->
            <div class="content-header mb-4">
                <h6 class="mb-0">NOMBRE DEL CLIENTE SOLICITANTE</h6>
            </div>
            <div class="row g-5">
              <div class="col-12">
                <div class="form-floating form-floating-outline">
                  <input type="text" id="client-name-input" class="form-control" placeholder="Nombre del Cliente Solicitante" />
                  <label for="client-name-input">Nombre del Cliente Solicitante</label>
                </div>
              </div>
            </div>
            <div class="row g-5 mb-2">
              <div class="col-12">
                <small>Quien queda enterado de todos los requisitos que debe cumplir para proseguir su proceso de certificación.</small>
              </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
              <button class="btn btn-outline-secondary btn-prev"> <i class="ri-arrow-left-line me-sm-1"></i>
                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
              </button>
              <button class="btn btn-primary btn-submit">Enviar</button>
            </div>
        </div>

    </form>
  </div>

</div>
@endsection