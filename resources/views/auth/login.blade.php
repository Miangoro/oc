@php
use Illuminate\Support\Facades\Route;
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Iniciar sesión')

@section('page-style')
{{-- Page Css files --}}
@vite('resources/assets/vendor/scss/pages/page-auth.scss')
@endsection

@section('content')

<style>
  video {
          position: fixed;
          right: 0;
          bottom: 0;
          min-width: 105%;
          min-height: 100%;
          transform: translateX(calc((100% - 100vw) / 2));
          z-index: -2;
        }
</style>
<div class="authentication-wrapper authentication-cover">
  <!-- Logo -->
  <a href="{{url('/')}}" class="auth-cover-brand d-flex align-items-center gap-2">
    <span class="app-brand-logo demo"><img height="150px" src="{{ asset('assets/img/branding/logo.png')}}" alt=""></span>
    <!--<span class="app-brand-text demo text-heading fw-semibold">{{config('variables.templateName')}}</span>-->
  </a>
  <!-- /Logo -->
  <div class="authentication-inner row m-0">
    <!-- /Left Section -->
    <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
       <video  autoplay muted loop>
        <source src="{{ asset('video/fondo.mp4')}}" type="video/mp4">
         Tu navegador no soporta el formato de video
      </video>
    </div>
    <!-- /Left Section -->

    <!-- Login -->
    <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
      <div class="w-px-400 mx-auto pt-5 pt-lg-0">
        <img height="150px" src="{{ asset('assets/img/branding/logo.png')}}" alt="">
        <h4 class="mb-1">Bienvenido a {{config('variables.templateName')}} </h4>
        <p class="mb-5">Por favor, inicie sesión</p>

        @if (session('status'))
          <div class="alert alert-success mb-3" role="alert">
            <div class="alert-body">
              {{ session('status') }}
            </div>
          </div>
        @endif
        <form id="formAuthentication" class="mb-5" action="{{ route('login') }}" method="POST">
          @csrf
          <div class="form-floating form-floating-outline mb-5">
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="login-email" name="email" placeholder="john@example.com" autofocus value="{{ old('email') }}">
            <label for="login-email">Correo</label>
            @error('email')
              <span class="invalid-feedback" role="alert">
                <span class="fw-medium">{{ $message }}</span>
              </span>
            @enderror
          </div>
          <div class="mb-5">
            <div class="form-password-toggle">
              <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                <div class="form-floating form-floating-outline">
                  <input type="password" id="login-password"
                    class="form-control @error('password') is-invalid @enderror" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
                  <label for="login-password">Contraseña</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
              </div>
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <span class="fw-medium">{{ $message }}</span>
                </span>
              @enderror
            </div>
          </div>
          <div class="mb-5 d-flex justify-content-between mt-5">
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" id="remember-me">
              <label class="form-check-label" for="remember-me">
                Recuérdame
              </label>
            </div>
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="float-end mb-1 mt-2">
                <span>¿Olvidó su contraseña?</span>
              </a>
            @endif
          </div>
          <button class="btn btn-primary d-grid w-100">
           Iniciar sesión
          </button>
        </form>

        <p class="text-center">
          <span>¿Nuevo en nuestra plataforma?</span>
          @if (Route::has('register'))
            <a href="{{ route('solicitud-cliente') }}">
              <span>Llenar solicitud de información de cliente</span>
            </a>
          @endif
        </p>

        <!--<div class="divider my-5">
          <div class="divider-text">or</div>
        </div>

        <div class="d-flex justify-content-center gap-2">
          <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-facebook">
            <i class="tf-icons ri-facebook-fill"></i>
          </a>

          <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-twitter">
            <i class="tf-icons ri-twitter-fill"></i>
          </a>

          <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-github">
            <i class="tf-icons ri-github-fill"></i>
          </a>

          <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-google-plus">
            <i class="tf-icons ri-google-fill"></i>
          </a>
        </div>-->
      </div>
    </div>
    <!-- /Login -->
  </div>
</div>
@endsection