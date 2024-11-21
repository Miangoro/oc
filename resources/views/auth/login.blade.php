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
        /* Video responsive */
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
            width: 20px;
            /* Ancho predeterminado */
            max-width: 37px;
            /* No más de 20px */
        }

        /* animacion de vuelo */
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
                width: 20px !important;
                /* Asegúrate de que no exceda 20px */
                max-width: 37px !important;
                /* No más de 20px */
            }
        }

        /*navidad*/
        .snowflake {
            position: fixed;
            top: -10px;
            font-size: 1.5rem;
            color: #ffffff;
            opacity: 0.8;
            animation: fall linear infinite;
            z-index: -1;
        }

        @keyframes fall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.8;
            }

            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /*Celular responsive*/
        @media (max-width: 768px) {
            video {
                display: none;
            }

            .authentication-inner {
                padding: 1rem;
            }

            .form-floating {
                margin-bottom: 1rem;
            }

            .btn {
                padding: 0.75rem;
            }
        }
    </style>

    <div id="desktop-view" class="d-none">
        <div class="authentication-wrapper authentication-cover">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="auth-cover-brand d-flex align-items-center gap-2">
                <span class="app-brand-logo demo"><img height="150px" src="{{ asset('assets/img/branding/logo_oc.png') }}"
                        alt=""></span>
                <!--<span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>-->
            </a>
            <!-- /Logo -->
            <div class="authentication-inner row m-0">
                <!-- /Left Section -->
                <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
                    <video autoplay muted loop>
                        <source src="{{ asset('video/fondo.mp4') }}" type="video/mp4">
                        Tu navegador no soporta el formato de video
                    </video>
                </div>
                <!-- /Left Section -->
    
                <!-- Login -->
                <div
                    class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-sm-12 px-12 py-6">
                    <div class="w-px-400 mx-auto pt-5 pt-lg-0">
                        <img height="150px" src="{{ asset('assets/img/branding/logo.png') }}" alt="">
                        <h4 class="mb-1">Bienvenido a {{ config('variables.templateName') }} </h4>
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
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="login-email"
                                    name="email" placeholder="john@example.com" autofocus value="{{ old('email') }}">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vista movil -->
    <div id="mobile-view" class="d-none">
        <div class="authentication-wrapper authentication-cover">
            <a href="{{ url('/') }}"
                class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
                <span class="app-brand-logo demo"><img height="150px" src="{{ asset('assets/img/branding/logo_oc.png') }}"
                        alt=""></span>
                <!--<span class="app-brand-text demo text-heading fw-semibold">{{ config('variables.templateName') }}</span>-->
            </a>
            <div class="authentication-inner row m-0">
                <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center justify-content-center p-12 pb-2">
                    <video autoplay muted loop style="max-width: 100%; height: 100%;">
                        <source src="{{ asset('video/fondo.mp4') }}" type="video/mp4">
                        Tu navegador no soporta el formato de video
                    </video>
                </div>

                <div
                    class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg position-relative py-6 px-4">
                    <div class="w-100 mx-auto">
                        <img class="d-block mx-auto mb-3" height="100px" src="{{ asset('assets/img/branding/logo.png') }}"
                            alt="">
                        <h4 class="text-center mb-1">Bienvenido a {{ config('variables.templateName') }} </h4>
                        <p class="text-center mb-4">Por favor, inicie sesión</p>

                        @if (session('status'))
                            <div class="alert alert-success mb-3" role="alert">
                                <div class="alert-body">
                                    {{ session('status') }}
                                </div>
                            </div>
                        @endif

                        <form id="formAuthentication-mobile" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="login-email-mobile" name="email" placeholder="john@example.com" autofocus
                                    value="{{ old('email') }}">
                                <label for="login-email-mobile">Correo</label>
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
                                            <input type="password" id="login-password-mobile"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password" />
                                            <label for="login-password-mobile">Contraseña</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer" style=" height: 48px;">
                                            <i class="ri-eye-off-line"></i>
                                        </span>                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <span class="fw-medium">{{ $message }}</span>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me-mobile">
                                    <label class="form-check-label" for="remember-me-mobile">Recuérdame</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-end">¿Olvidó su contraseña?</a>
                                @endif
                            </div>
                            <button class="btn btn-primary w-100 mb-3">Iniciar sesión</button>
                        </form>

                        <p class="text-center">
                            <span>¿No estás certificado?</span>
                            @if (Route::has('register'))
                                <a href="{{ route('solicitud-cliente') }}" class="text-info">¡Quiero certificarme!</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


<script>
    //metodo para cambiar de escritorio a celular
    document.addEventListener('DOMContentLoaded', function() {
        function toggleView() {
            const mobileView = document.getElementById('mobile-view');
            const desktopView = document.getElementById('desktop-view');

            if (window.innerWidth <= 768) {
                // Mostrar vista móvil
                mobileView.classList.remove('d-none');
                desktopView.classList.add('d-none');
            } else {
                // Mostrar vista escritorio
                desktopView.classList.remove('d-none');
                mobileView.classList.add('d-none');
            }
        }

        // Llamar a la función al cargar la página y al cambiar el tamaño de la ventana
        toggleView();
        window.addEventListener('resize', toggleView);
    });


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
        if (batCount < maxBats && window.innerWidth >
            maxWidth) { // Limita el número de murciélagos visibles y se asegura de que no sea en pantallas pequeñas
            const bat = document.createElement("img");
            // Selecciona aleatoriamente entre las tres imágenes
            const batImages = [
                "{{ asset('assets/img/branding/murcielago.png') }}",
                "{{ asset('assets/img/branding/calabazin.png') }}",
                "{{ asset('assets/img/branding/fantasma.png') }}"
            ];
            bat.src = batImages[Math.floor(Math.random() * batImages.length)];
            bat.classList.add("bat");
            bat.style.left = Math.random() * 90 + "vw";
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

    //vavidad
    function isChristmasSeason() {
        const today = new Date();
        const month = today.getMonth(); // Obtiene el mes actual (0 = enero, 10 = noviembre)
        return month === 11; // Solo retorna true si el mes es noviembre (10)
    }

    function createSnowflake() {
        const snowflake = document.createElement("span");
        snowflake.classList.add("snowflake");
        snowflake.textContent = "❄"; // Puedes cambiar el símbolo del copo de nieve aquí
        snowflake.style.left = Math.random() * 100 + "vw";
        snowflake.style.animationDuration = Math.random() * 3 + 2 + "s"; // Duración de caída de 2 a 5 segundos
        snowflake.style.fontSize = Math.random() * 10 + 10 + "px"; // Tamaño entre 10px y 20px

        document.body.appendChild(snowflake);

        snowflake.addEventListener("animationend", () => {
            snowflake.remove();
        });
    }

    // Activar el efecto de nieve solo en noviembre
    if (isChristmasSeason()) {
        // Crear un copo de nieve cada 500 milisegundos
        setInterval(createSnowflake, 500);
    }
</script>
