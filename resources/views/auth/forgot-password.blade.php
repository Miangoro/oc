@php
  use Illuminate\Support\Facades\Route;
  $configData = Helper::appClasses();
  $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Forgot Password')

@section('page-style')
  {{-- Page Css files --}}
  @vite('resources/assets/vendor/scss/pages/page-auth.scss')
@endsection

@section('content')
  <div class="authentication-wrapper authentication-cover ">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="auth-cover-brand d-flex align-items-center gap-2">
    <span class="app-brand-logo demo img-logo"><img height="100px" src="{{ asset('assets/img/branding/logo_oc.png') }}"
      alt=""></span>
    </a>
    <!-- /Logo -->
    <div class="authentication-inner row m-0">

    <!-- /Left Section -->
    <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2 min-vh-100">
      <img style="inset-block-end: 0%" src="{{ asset('assets/img/fondo_oc_cidam3.jpg') }}"
      class="authentication-image w-100 h-100 object-fit-cover" alt="mask" data-app-light-img="fondo_oc_cidam3.jpg"
      data-app-dark-img="fondo_oc_cidam3.jpg" />
    </div>

    <!-- /Left Section -->

    <!-- Forgot Password -->
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
      <div class="w-px-400 mx-auto">
      <div class="text-center logo-up mb-4">
        <a href="{{ url('/') }}" class="d-inline-block">
        <img src="{{ asset('assets/img/branding/logo_oc.png') }}" alt="Logo CIDAM" height="90">
        </a>
      </div>
      <h2 class="mb-3 text-heading">¿Olvidaste tu contraseña?</h2>
      <p class="mb-4">Escribe tu correo electrónico y recibirás instrucciones para recuperarla de forma segura.</p>


      @if (session('status'))
      <div class="alert alert-success d-flex align-items-center" role="alert">
      <i class="ri-check-line me-2 fs-5"></i> <span>{{ session('status') }}</span>
      </div>
    @endif

      <form id="formAuthentication" class="mb-5" action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="form-floating form-floating-outline mb-5">
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
          placeholder="ejemplo@.com" autofocus>
        <label for="email">Email</label>
        @error('email')
      <div class="invalid-feedback d-block text-danger">
        <i class="ri-error-warning-line me-1"></i> <strong>{{ $message }}</strong>
      </div>
      @enderror

        </div>
        <button type="submit" class="btn btn-primary w-100 shadow-sm py-2">
        <i class="ri-lock-unlock-line me-2"></i> Enviar enlace
        </button>

      </form>
      <div class="text-center mt-4">
  @if (Route::has('login'))
    <a href="{{ route('login') }}" class="btn btn-outline-secondary d-inline-flex align-items-center px-4 py-2 shadow-sm">
      <i class="ri-arrow-left-s-line ri-lg me-2"></i>
      Volver al inicio
    </a>
  @endif
</div>

      </div>
    </div>
    <!-- /Forgot Password -->
    </div>
  </div>
@endsection