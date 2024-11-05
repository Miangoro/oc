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
    @vite(['resources/assets/vendor/libs/bs-stepper/bs-stepper.scss', 'resources/assets/vendor/fonts/personalizados/style.css', 'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss', 'resources/assets/vendor/libs/spinkit/spinkit.scss'])

    <!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/jquery/jquery.js', 'resources/assets/vendor/libs/bootstrap/bootstrap.js', 'resources/assets/vendor/libs/bs-stepper/bs-stepper.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js'])
@section('content')

  
    <div class="card">

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



        </div>
    </div>
@endsection

