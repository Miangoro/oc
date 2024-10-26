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
  /* Video adjustments */
  video {
    position: fixed;
    right: 0;
    bottom: 0;
    min-width: 100%;
    min-height: 100%;
    transform: translateX(calc((100% - 100vw) / 2));
    z-index: -2;
  }

  /* Murciélago */
  .bat {
    position: absolute;
    top: -50px;
    opacity: 0;
    animation: flyDown 3s ease-out forwards;
    pointer-events: none;
    width: 20px; /* Ancho predeterminado */
    max-width: 37px; /* No más de 20px */
  }

  /* Fly-down animation for the bats */
  @keyframes flyDown {
    0% {
      opacity: 0;
      transform: translateY(0) scale(0.3);
    }
    50% {
      opacity: 1;
    }
    100% {
      opacity: 0;
      transform: translateY(100vh) scale(1.5);
    }
  }

  /* Responsive adjustments for smaller screens */
  @media (max-width: 768px) {
    video {
      min-width: 150%;
    }
    
    /* Reduce bat size on smaller screens */
    .bat {
      width: 20px !important; /* Asegúrate de que no exceda 20px */
      max-width: 37px !important; /* No más de 20px */
    }
  }
</style>


<div class="authentication-wrapper authentication-cover">
  <!-- Logo -->
  <a href="{{url('/')}}" class="auth-cover-brand d-flex align-items-center gap-2">
    <span class="app-brand-logo demo"><img height="150px" src="{{ asset('assets/img/branding/logo_oc.png')}}" alt=""></span>
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
          <span>¿No estás certificado?</span>
          @if (Route::has('register'))
            <a href="{{ route('solicitud-cliente') }}">
              <span class="text-info">¡Quiero certificarme!</span>
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


<script>
  let batCount = 0; // Contador de murciélagos en pantalla
  const maxBats = 10; // Máximo número de murciélagos
  const maxWidth = 768; // Ancho máximo para considerar el diseño responsive

  // Función para verificar si la fecha actual está dentro del rango deseado
  function isHalloweenSeason() {
    const today = new Date();
    const startDate = new Date(today.getFullYear(), 9, 1); // 1 de octubre
    const endDate = new Date(today.getFullYear(), 10, 2); // 2 de noviembre
    return today >= startDate && today <= endDate;
  }

  function createBat() {
    if (batCount < maxBats && window.innerWidth > maxWidth) { // Limita el número de murciélagos visibles y se asegura de que no sea en pantallas pequeñas
      const bat = document.createElement("img");
      // Selecciona aleatoriamente entre las tres imágenes
      const batImages = [
        "{{ asset('assets/img/branding/murcielago.png') }}",
        "{{ asset('assets/img/branding/calabazin.png') }}",
        "{{ asset('assets/img/branding/fantasma.png') }}"
      ];
      bat.src = batImages[Math.floor(Math.random() * batImages.length)];
      bat.classList.add("bat");
      bat.style.left = Math.random() * 100 + "vw";
      bat.style.width = Math.random() * 30 + 20 + "px"; // Tamaño entre 20px y 50px
      document.body.appendChild(bat);
      batCount++;

      bat.addEventListener("animationend", () => {
        bat.remove();
        batCount--; // Reduce el contador al terminar la animación
      });
    }
  }

  // Ejecutar el intervalo solo si estamos en la temporada de Halloween
  if (isHalloweenSeason()) {
    // Intervalo para crear murciélagos cada segundo
    setInterval(createBat, 1000);
  }
</script>


