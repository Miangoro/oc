@php
    $configData = Helper::appClasses();
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Inicio')


@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/apex-charts/apex-charts.scss', 
    'resources/assets/vendor/libs/swiper/swiper.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

@section('page-style')
    <!-- Page -->
    <style>
        .hover-scale {
            transition: transform 0.2s ease-in-out;
            /* transición suave */
        }

        .hover-scale:hover {
            transform: scale(1.03);
            /* se agranda un 5% */
        }
    </style>
@vite([
    'resources/assets/vendor/scss/pages/cards-statistics.scss', 
    'resources/assets/vendor/scss/pages/cards-analytics.scss', 
    'resources/assets/vendor/scss/pages/ui-carousel.scss'
])
@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/apex-charts/apexcharts.js', 
        'resources/assets/vendor/libs/swiper/swiper.js', 
        'resources/assets/vendor/libs/swiper/swiper.js',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
    ])
@endsection


@section('page-script')
    <script>
        const revisionesMesURL = "{{ route('estadisticas.revisiones-mes') }}";

        window.puedeAsignarRevisor = @json(auth()->user()->can('Asignar revisor de acta'));
    </script>

    @vite(['resources/assets/js/dashboards-analytics.js', 'resources/assets/js/ui-carousel.js'])
@endsection


<style>
    /* Degradado en el fondo del icono */
.icon-wrapper {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: linear-gradient(135deg, #4e73df 0%, #1cc88a 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

/* Efecto hover de la tarjeta */
.hover-card {
    transition: transform .2s ease, box-shadow .2s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

</style>

@section('content')

<div class="row g-6">
        <!-- Gamification Card -->
        <!-- <div class="col-md-12 col-xxl-8">
                <div class="card">
                    <div class="d-flex align-items-end row">
                    <div class="col-md-6 order-2 order-md-1">
                        <div class="card-body">
                        <h4 class="card-title mb-4">Bienvenid@ <span class="fw-bold">
@if (Auth::check())
    {{ Auth::user()->name }}
@else
    John Doe
@endif!
            </span> 🎉</h4>
                        <p class="mb-0">Personal del organismo certificador cidam</p><br>
                        <a href="javascript:;" class="btn btn-primary">Ver pendientes</a>
                        </div>
                    </div>
                    <div class="col-md-6 text-center text-md-end order-1 order-md-2">
                        <div class="card-body pb-0 px-0 pt-2">
                        <img src="{{ asset('assets/img/illustrations/illustration-john-' . $configData['style'] . '.png') }}" height="186" class="scaleX-n1-rtl" alt="View Profile" data-app-light-img="illustrations/illustration-john-light.png" data-app-dark-img="illustrations/illustration-john-dark.png">
                        <img  height="186" class="scaleX-n1-rtl" alt="View Profile" src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/1.png') }}" >
                        </div>
                    </div>
                    </div>
                </div>
                </div>-->
        <!--/ Gamification Card -->

        <!-- Statistics Total Order -->
        <!--  <div class="col-xxl-2 col-sm-6">
                <div class="card h-100">
                    <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                        <div class="avatar">
                        <div class="avatar-initial bg-label-primary rounded-3">
                            <i class="ri-shopping-cart-2-line ri-24px"></i>
                        </div>
                        </div>
                        <div class="d-flex align-items-center">
                        <p class="mb-0 text-success me-1">+22%</p>
                        <i class="ri-arrow-up-s-line text-success"></i>
                        </div>
                    </div>
                    <div class="card-info mt-5">
                        <h5 class="mb-1">50</h5>
                        <p>Certificados de exportación</p>
                        <div class="badge bg-label-secondary rounded-pill">Último mes</div>
                    </div>
                    </div>
                </div>
            </div>-->
        <!--/ Statistics Total Order -->

        <!-- Sessions line chart -->
        <!--<div class="col-xxl-2 col-sm-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                    <div class="d-flex align-items-center mb-1 flex-wrap">
                        <h5 class="mb-0 me-1">$38.5k</h5>
                        <p class="mb-0 text-success">+62%</p>
                    </div>
                    <span class="d-block card-subtitle">Sessions</span>
                    </div>
                    <div class="card-body">
                    <div id="sessions"></div>
                    </div>
                </div>
            </div>-->
        <!--/ Sessions line chart -->


    <!--CONTENEDOR INICIO-->
    <div class="row my-2">
        <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="row g-0 align-items-center">
                <!-- Texto de bienvenida -->
                <div class="col-md-3 p-3">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body text-center">
                            <h4 class="mb-3 text-primary fw-bold">
                            Bienvenido a la nueva plataforma
                            </h4>
                            <h5 class="mb-2 text-dark fw-semibold">
                                @if (Auth::check())
                                    {{ Auth::user()->name }}
                                @else
                                    <span class="text-muted">Sin usuario logeado</span>
                                @endif
                            </h5>
                            <p class="mb-3 fs-6 fw-bold text-danger">
                                @if (Auth::check() && Auth::user()->puesto)
                                    {{ Auth::user()->puesto }}
                                @elseif(Auth::check() && Auth::user()->empresa)
                                    {{ Auth::user()->empresa->razon_social }}
                                @else
                                    Miembro del consejo
                                @endif
                            </p>

                            @if($maquiladora->isNotEmpty())
                                <hr class="my-3">
                                <h6 class="fw-bold text-secondary mb-2">Maquilador de:</h6>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($maquiladora as $maquiladoras)
                                        @foreach ($maquiladoras->maquiladora as $soymaquilador)
                                            <li class="mb-1">
                                                <i class="material-icons align-middle text-primary" style="font-size:18px;"></i>
                                                {{ $soymaquilador->razon_social }}
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <!--Maquiladores-->
                <div class="col-md-4 text-center d-none d-md-block p-2">
                    <div class="row">
                        @foreach ($maquiladores as $maquilador)
                            @foreach ($maquilador->maquiladores as $m)
                                <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <div class="card text-center shadow border-0 h-100" style="font-size: 0.9rem;">

                                        <!-- Encabezado -->
                                        <div class="card-header text-white py-2"
                                            style="background-color:#053160; font-size: 0.85rem;">
                                            {{ $m->razon_social }}
                                        </div>

                                        <!-- Cuerpo -->
                                        <div class="card-body p-2">
                                            <h6 class="card-title text-success"
                                                style="color:#30a86a !important; font-size: 0.85rem;">
                                                RFC: {{ $m->rfc }}
                                            </h6>
                                            <p class="card-text mb-1" style="font-size: 0.8rem;">
                                                <strong>Domicilio:</strong> {{ $m->domicilio_fiscal }}
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @endforeach

                        <!-- Mensajes del dashboard f0f8ff-->
                        <!-- Mensajes del dashboard -->
                        <div class="dashboard-messages d-flex justify-content-center align-items-start h-100 pe-5">
                            <div class="w-100 pe-5">
                                @foreach ($mensajes as $mensaje)
                                    @if ($mensaje->activo == 1 && ($mensaje->id_usuario_destino == auth()->id() || is_null($mensaje->id_usuario_destino)))
                                        @php
                                            // Definir colores fuertes que combinen con el tipo de texto
                                            $textColor = $mensaje->tipo != 'Normal' ? match($mensaje->tipo) {
                                                'danger' => '#dc3545',
                                                'success' => '#28a745',
                                                default => '#0d6efd',
                                            } : '#0d6efd';

                                            $bgColor = $mensaje->tipo != 'Normal' ? match($mensaje->tipo) {
                                                'danger' => '#dc3545',    // rojo fuerte
                                                'success' => '#28a745',   // verde fuerte
                                                default => '#0d6efd',     // azul fuerte
                                            } : '#0d6efd';
                                        @endphp

                                        <div class="card mb-4 shadow-lg border-0 rounded-4 hover-scale"
                                            style="border-left: 8px solid {{ $textColor }};
                                                    background-color: {{ $bgColor }};
                                                    color: #fff;
                                                    transition: transform 0.3s;">
                                            <div class="card-body text-center p-4">
                                                <h4 class="card-title fw-bold">
                                                    {{ $mensaje->titulo }}
                                                </h4>
                                                <p class="card-text fs-5 mt-3">
                                                    {{ $mensaje->mensaje }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

<style>
.hover-scale:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 10px 30px rgba(0,0,0,0.25) !important;
    }
</style>

                        <!-- Mensajes del dashboard -->
                        {{-- @foreach ($mensajes as $mensaje)
                    @if ($mensaje->activo == 1)
                        @if ($mensaje->id_usuario_destino == auth()->id() || is_null($mensaje->id_usuario_destino))
                            <div class="mb-2 py-1 px-2">

                                <h4 class="mb-1 {{ $mensaje->tipo_titulo != 'Normal' ? 'text-'.$mensaje->tipo_titulo : '' }}">
                                    <strong>{{ $mensaje->titulo }}</strong>
                                </h4>

                                <h5 class="mb-0 {{ $mensaje->tipo != 'Normal' ? 'text-'.$mensaje->tipo : '' }}">
                                    {{ $mensaje->mensaje }}
                                </h5>
                            </div>
                        @endif
                    @endif
                @endforeach --}}
                    </div>
                </div>

                <!--carousel de imagenes-->
                <div class="col-md-5 text-center d-none d-md-block">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <!-- Indicadores -->
                        <div class="carousel-indicators">
                            @foreach ($imagenes as $index => $img)
                                <button type="button" data-bs-target="#carouselExample"
                                    data-bs-slide-to="{{ $index }}"
                                    class="{{ $index == 0 ? 'active' : '' }}"
                                    aria-current="{{ $index == 0 ? 'true' : '' }}"
                                    aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>

                        <!-- Slides -->
                        <div class="carousel-inner">
                            @foreach ($imagenes as $index => $img)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img class="d-block w-100" src="{{ asset($img->url) }}"
                                        alt="{{ $img->nombre }}">
                                </div>
                            @endforeach
                        </div>

                        <!-- Controles -->
                        <a class="carousel-control-prev" href="#carouselExample" role="button"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExample" role="button"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                </div>
                <!-- Imagen decorativa -->
                {{-- <div class="col-md-3 text-center d-none d-md-block">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{ asset('assets/img/carousel/1.jpg') }}"
                                    alt="First slide" />

                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{ asset('assets/img/carousel/2.jpg') }}"
                                    alt="Second slide" />
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExample" role="button"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExample" role="button"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                </div> --}}
                </div>
            </div>
        </div>

    </div><!--contenedor de estatisticas fin-->



    <!--CONTENEDOR DE ESTADISTICAS-->
   <div class="row g-4 mb-4">
    {{--
    * CAMBIOS APLICADOS:
    * 1. Se cambió 'g-6' por 'g-4' en el 'row' principal para un mejor espaciado.
    * 2. Se eliminó la clase 'h-100' de los card que tienen mucho contenido variable.
    * 3. Se mantiene la estructura 'col-sm-6 col-lg-3' para la grilla 4x12.
    * 4. Se usa 'h-100' solo en el contenedor de las 'Estadísticas Hologramas' para forzar la uniformidad visual de ese bloque.
    * 5. Se usa la clase de utilidad 'mb-4' en los 'row' principales para separar mejor las secciones.
    --}}

    @can('Estadísticas ui')
    <div class="col-sm-6 col-lg-3">
        {{-- Quitamos h-100 para evitar estiramiento y que la card se ajuste al contenido --}}
        <div class="card card-border-shadow-primary">
            <div class="card-body">
                <h5 class="card-title text-primary mb-3">Tareas Pendientes (UI)</h5>
                <div class="d-flex align-items-center mb-2" data-bs-toggle="modal"
                    data-bs-target="#modalSolicitudesSinInspector">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-primary"><i
                                class="ri-group-fill ri-24px"></i></span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $solicitudesSinInspeccion->count() }}</h4>
                        <small class="text-muted">Asignar inspector</small>
                    </div>
                </div>
                <hr class="my-2">

                <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                    data-bs-target="#modalSolicitudesSinActa">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-warning"><i
                                class="ri-file-list-fill ri-24px"></i></span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $solicitudesSinActa->count() }}</h4>
                        <small class="text-muted">Subir acta 2025</small>
                    </div>
                </div>
                <hr class="my-2">

                <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                    data-bs-target="#modalSolicitudesSinDictamen">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-warning"><i
                                class="ri-file-warning-line ri-24px"></i></span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $solicitudesSinDictamen->count() }}</h4>
                        <small class="text-muted">Crear dictamen</small>
                    </div>
                </div>
                <hr class="my-2">

                <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                    data-bs-target="#modalRevisionActa">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-warning"><i
                                class="ri-file-warning-line ri-24px"></i></span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $revisionActa->count() }}</h4>
                        <small class="text-muted">Revisión de acta</small>
                    </div>
                </div>
                <hr class="my-2">

                <div class="d-flex align-items-center cursor-pointer" data-bs-toggle="modal"
                    data-bs-target="#modalSolicitudesSinActa">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-warning"><i
                                class="ri-file-list-fill ri-24px"></i></span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $lotesSinFq->count() }}</h4>
                        <small class="text-muted">Lotes sin FQ</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan

    @can('Estadísticas ui')
    <div class="col-sm-6 col-lg-3">
        {{-- Quitamos h-100 para evitar estiramiento y que la card se ajuste al contenido --}}
        <div class="card card-border-shadow-danger">
            <div class="card-body">
                <h5 class="card-title text-danger mb-3">Dictámenes por Vencer</h5>
                <ul class="list-unstyled mb-0">
                    @forelse ($dictamenesPorVencer as $dictamen)
                    <li class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-1">
                        <h6 class="mb-0">{{ $dictamen->num_dictamen }}</h6>
                        <small class="text-muted fw-bold">{{ $dictamen->fecha_vigencia }}</small>
                    </li>
                    @empty
                    <li class="text-muted">No hay dictámenes próximos a vencer.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
    @endcan

    @can('Estadísticas oc')
    <div class="col-sm-6 col-lg-3">
        {{-- Quitamos h-100 para evitar estiramiento y que la card se ajuste al contenido --}}
        <div class="card card-border-shadow-primary">
            <div class="card-body">
                <h5 class="card-title text-primary mb-3">Pendientes de Certificado (OC)</h5>

                <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                    data-bs-target="#modalDictamenesInstalacionesPendientes">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-danger"><i
                                class="ri-file-warning-line ri-24px"></i></span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $dictamenesInstalacionesSinCertificado->count() }}</h4>
                        <small class="text-muted">Instalaciones</small>
                    </div>
                </div>
                <hr class="my-2">

                <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                    data-bs-target="#modalDictamenesGranelPendientes">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-danger"><i
                                class="ri-file-warning-line ri-24px"></i></span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $dictamenesGranelesSinCertificado->count() }}</h4>
                        <small class="text-muted">Graneles</small>
                    </div>
                </div>
                <hr class="my-2">

                <div class="d-flex align-items-center cursor-pointer" data-bs-toggle="modal"
                    data-bs-target="#modalDictamenesExportacionPendientes">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-danger">
                            <i class="ri-file-warning-line ri-24px"></i>
                        </span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $dictamenesExportacionSinCertificado->count() }}</h4>
                        <small class="text-muted">Exportación</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan

    @can('Estadísticas oc')
    <div class="col-sm-6 col-lg-3">
        {{-- Quitamos h-100 para evitar estiramiento y que la card se ajuste al contenido --}}
        <div class="card card-border-shadow-info">
            <div class="card-body">
                <h5 class="card-title text-info mb-3">Tareas Pendientes (OC)</h5>

                <div class="mb-3">
                    <h6 class="mb-0 text-danger fw-bold">Certificados por Vencer</h6>
                    <ul class="list-unstyled mb-0 ms-4">
                        @forelse ($certificadosPorVencer as $certificado)
                        <li class="text-muted">
                            {{ $certificado->num_certificado }} -
                            <small class="text-muted">{{ $certificado->fecha_vigencia }}</small>
                            ({{ $certificado->dictamen->inspeccione->solicitud->empresa->razon_social }})
                        </li>
                        @empty
                        <li class="text-muted">Ninguno.</li>
                        @endforelse
                    </ul>
                </div>
                <hr class="my-2">

                <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                    data-bs-target="#modalCertificadosInstalacionesSinEscaner">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-warning"><i
                                class="ri-file-list-fill ri-24px"></i></span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $certificadoInstalacionesSinEscaneado->count() }}</h4>
                        <small class="text-muted">Instalaciones sin escaneado</small>
                    </div>
                </div>
                <hr class="my-2">

                <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                    data-bs-target="#modalCertificadosSinEscaner">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-warning"><i
                                class="ri-file-list-fill ri-24px"></i></span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $certificadoGranelSinEscaneado->count() }}</h4>
                        <small class="text-muted">Graneles sin escaneado</small>
                    </div>
                </div>
                <hr class="my-2">

                <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                    data-bs-target="#modalCertificadosExportacionSinEscaner">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-warning"><i
                                class="ri-file-list-fill ri-24px"></i></span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $certificadoExportacionSinEscaneado->count() }}</h4>
                        <small class="text-muted">Exportación sin escaneado</small>
                    </div>
                </div>
                <hr class="my-2">

                <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                    data-bs-target="#modalactasSinActivarHologramas">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-danger">
                            <i class="ri-close-circle-line ri-24px"></i>
                        </span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $actasSinActivarHologramas->count() }}</h4>
                        <small class="text-muted">Actas sin activar hologramas</small>
                    </div>
                </div>
                <hr class="my-2">

                <div class="d-flex align-items-center cursor-pointer" data-bs-toggle="modal" data-bs-target="#">
                    <div class="avatar me-4 flex-shrink-0">
                        <span class="avatar-initial rounded-3 bg-label-danger">
                            <i class="ri-close-circle-line ri-24px"></i>
                        </span>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $solicitudesHologramasPendientes->count() }}</h4>
                        <small class="text-muted">Solicitudes de hologramas pendientes</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>

<div class="row g-4 mb-4">
    @can('Estadísticas ui')
    <div class="col-md-6 col-xxl-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Inspecciones por Inspector 2025 🧑‍💼</h5>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0 list-unstyled">
                    @foreach ($inspeccionesInspector as $inspector)
                    <li class="d-flex align-items-center mb-4 pb-2 border-bottom">
                        <div class="avatar flex-shrink-0 me-4">
                            <img src="{{ asset('storage/' . $inspector['foto']) }}"
                                alt="Foto de {{ $inspector['nombre'] }}" class="rounded-circle" width="50"
                                height="50" style="object-fit: cover;">
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0 fw-semibold">{{ $inspector['nombre'] }}</h6>
                            </div>
                            <div class="badge bg-label-primary rounded-pill fw-bold fs-6">
                                {{ $inspector['total_inspecciones'] }}</div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endcan

    @can('Estadísticas oc')
    {{-- Aumentamos el tamaño a col-md-6 para la gráfica si es un tamaño intermedio --}}
    <div class="col-md-6 col-xxl-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between flex-column flex-md-row">
                <div>
                    <h5 class="card-title mb-1">Certificados Emitidos por Mes 📈</h5>
                    <p class="text-muted mb-0">Selecciona el año y el cliente para filtrar.</p>
                </div>
                <div class="d-flex gap-3 mt-3 mt-md-0">
                    <div>
                        <label for="selectAnio" class="form-label mb-0 small">Año:</label>
                        <select id="selectAnio" class="form-select form-select-sm w-auto">
                            @for ($i = now()->year; $i >= 2022; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="selectCliente" class="form-label mb-0 small">Cliente:</label>
                        <select id="selectCliente" class="form-select form-select-sm w-auto">
                            <option value="0">Todos los clientes</option>
                            @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id_empresa }}">{{ $cliente->razon_social }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="lineChart" style="min-height: 300px;"></div>
                
            </div>
        </div>
    </div>
    @endcan
</div>

<div class="row g-4 mb-4">
    @canany(['Estadísticas consejo', 'Estadísticas oc'])
    @php
    $tipos = [1 => 'Instalaciones', 2 => 'Granel', 3 => 'Exportación'];
    $agrupado = $revisiones->groupBy(fn($r) => $r->user_id . '-' . $r->rol);
    @endphp

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header pb-2">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div>
                        <h5 class="mb-1">📊 Resumen de Revisiones por Revisor</h5>
                        <small class="text-muted">Revisiones realizadas por tipo de certificado.</small>
                    </div>
                    <form method="GET" class="mt-2 mt-md-0">
                        <div class="input-group input-group-sm">
                            <label class="input-group-text" for="mes">Mes</label>
                            @php $mesSeleccionado = request('mes', now()->month); @endphp
                            <select name="mes" id="mes" class="form-select form-select-sm">
                                <option value="">Todos</option>
                                @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $mesSeleccionado == $i ? 'selected' : '' }}>
                                    {{ ucfirst(\Carbon\Carbon::create()->month($i)->translatedFormat('F')) }}
                                </option>
                                @endfor
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body pt-2">
                <div class="table-responsive border-top">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th><i class="ri-user-3-fill"></i> Revisor</th>
                                <th class="text-center">🏗️ Inst.</th>
                                <th class="text-center">🌾 Granel</th>
                                <th class="text-center">🚢 Export.</th>
                                <th class="text-center"><i class="ri-time-line"></i> Pendientes</th>
                            </tr>
                        </thead>

                        <tbody id="tbody-revisiones">
                            @forelse ($agrupado as $key => $grupo)
                            @php
                            $revisor = $usuarios[$grupo->first()->user_id] ?? null;
                            $rol = $grupo->first()->rol;
                            $inst = $grupo->where('tipo_certificado', 1)->where('decision', '!=', 'Pendiente')->sum('total');
                            $gran = $grupo->where('tipo_certificado', 2)->where('decision', '!=', 'Pendiente')->sum('total');
                            $expo = $grupo->where('tipo_certificado', 3)->where('decision', '!=', 'Pendiente')->sum('total');
                            $pendientes = $grupo->where('decision', 'Pendiente')->sum('total');
                            @endphp
                            <tr>
                                <td class="{{ $revisor?->id == auth()->id() ? 'bg-primary text-white fw-bold' : '' }}"
                                    style="padding: 0.25rem 0.5rem;">
                                    <div class="d-flex align-items-center gap-2" style="border-radius: 13px;">
                                        <div class="avatar flex-shrink-0">
                                            @if (!empty($revisor?->profile_photo_path))
                                            <img src="/storage/{{ $revisor->profile_photo_path }}"
                                                alt="{{ $revisor->name ?? '—' }}" class="rounded-circle"
                                                style="width: 36px; height: 36px; object-fit: cover;">
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-0" style="font-weight: 600; font-size: 0.9rem;">
                                                {{ $revisor?->name ?? '—' }}
                                            </h6>
                                            <span
                                                class="badge rounded-pill {{ $rol === 'Personal' ? 'bg-label-info' : ($rol === 'Consejo' ? 'bg-label-warning' : 'bg-label-secondary') }}"
                                                style="font-size: 0.75rem; padding: 0.2em 0.5em;">
                                                {{ $rol }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end fw-medium">{{ number_format($inst) }}</td>
                                <td class="text-end fw-medium">{{ number_format($gran) }}</td>
                                <td class="text-end fw-medium">{{ number_format($expo) }}</td>
                                <td
                                    class="text-end {{ $pendientes > 0 ? 'bg-danger text-white fw-bold' : '' }}">
                                    {{ number_format($pendientes) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No hay revisiones registradas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endcanany

    @can('Estadísticas exportación clientes')
    <div class="col-md-6 col-xxl-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Certificados de Exportación 🚢</h5>
            </div>
            <div class="card-body pb-1 pt-0">
                <p class="mt-0 fw-medium text-muted">Resumen de cierre por mes:</p>
                <div class="table-responsive text-nowrap border-top">
                    <table class="table table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Mes</th>
                                <th class="text-end">Certificados</th>
                                <th class="text-end">Reexpediciónes</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($TotalCertificadosExportacionPorMes as $item)
                            <tr>
                                <td class="ps-3 py-2">
                                    <span class="text-heading fw-semibold">
                                        {{ ucfirst(\Carbon\Carbon::createFromFormat('Y-m-d', $item->mes . '-01')->locale('es')->isoFormat('MMMM YYYY')) }}
                                    </span>
                                </td>
                                <td class="text-end py-2">
                                    <span class="text-heading fw-medium">{{ $item->total }}</span>
                                </td>
                                <td class="text-end py-2">
                                    <span class="text-heading fw-medium">
                                        {{ $item->certificado_reexpedido ? 1 : 0 }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>

<div class="row g-4 mb-4">
    @can('Estadísticas hologramas clientes')
    <div class="col-12">
        <h4 class="mb-3">Resumen de Hologramas por Marca 🏷️</h4>
        <div class="row g-4">
            {{-- Usamos row g-4 para un buen espacio, y h-100 en la card para uniformidad visual ya que tienen contenido simple --}}
            @foreach ($marcasConHologramas as $marca)
            @php
            $totalDisponibles = $marca->solicitudHolograma()
            ->where('id_empresa', $empresaId)
            ->get()
            ->sum(fn ($solicitud) => $solicitud->cantidadDisponibles());
            @endphp
            {{-- col-12 en sm, col-md-6, col-lg-3 para mejor responsividad --}}
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow-sm border-0 **h-100** rounded-4 overflow-hidden hover-card">
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-between">
                        {{-- Icono grande con estilo --}}
                        <div class="mx-auto mb-3"
                            style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(45deg, #007bff, #00b4d8); display: flex; align-items: center; justify-content: center;">
                            <i class="ri-price-tag-3-line display-6 text-white"></i>
                        </div>
                        {{-- Cantidad de hologramas --}}
                        <h2 class="fw-bold text-primary mb-1">
                            {{ number_format($totalDisponibles, 0) }}
                        </h2>
                        <p class="text-muted mb-3 small">Hologramas sin activar</p>

                        {{-- Nombre de la marca --}}
                        <h5 class="fw-semibold text-dark">{{ $marca->marca }}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endcan
</div><!--contenedor de estatisticas fin-->



    <!------ MODALES ------>
    <!-- Modal OC-->
    <div class="modal fade" id="modalDictamenesExportacionPendientes" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Dictámenes sin certificado de exportación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                @if ($dictamenesExportacionSinCertificado->count())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Inspector</th>
                                <th>Dictamen</th>
                                <!--<th>Acciones</th>-->
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($dictamenesExportacionSinCertificado as $dictamen)
                            <tr>
                                <td>{{ $dictamen->num_dictamen }}</td>
                                <td>{{ $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($dictamen->fecha_emision)->format('d/m/Y') }}
                                </td>
                                <td>{{ $dictamen->firmante->name ?? 'N/A' }}</td>
                                <th>
                                    <a target="_Blank"
                                        href="/dictamen_exportacion/{{ $dictamen->id_dictamen }}"><i
                                            class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen"></i>
                                    </a>
                                </th>
                                <!--<td>
                                    <a href="" class="btn btn-sm btn-primary" target="_blank">
                                        Ver
                                    </a>
                                </td>-->
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <p>No hay dictámenes pendientes.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal OC-->
    <div class="modal fade" id="modalDictamenesGranelPendientes" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Dictámenes sin certificado de Granel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                @if ($dictamenesGranelesSinCertificado->count())
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Inspector</th>
                                    <th>Dictamen</th>
                                    <!--<th>Acciones</th>-->
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($dictamenesGranelesSinCertificado as $dictamen)
                                <tr>
                                    <td>{{ $dictamen->num_dictamen }}</td>
                                    <td>{{ $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($dictamen->fecha_emision)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $dictamen->inspeccione->inspector->name ?? 'N/A' }}</td>
                                    <th>
                                        <a target="_Blank" 
                                        href="/dictamen_granel/{{ $dictamen->id_dictamen }}"><i class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen"></i></a>
                                    </th>
                                    <!--<td>
                                        <a href="" class="btn btn-sm btn-primary" target="_blank">
                                            Ver
                                        </a>
                                    </td>-->
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No hay dictámenes pendientes.</p>
                @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal OC-->
    <div class="modal fade" id="modalDictamenesInstalacionesPendientes" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Dictámenes sin certificado de Instalaciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                @if ($dictamenesInstalacionesSinCertificado->count())
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Inspector</th>
                                    <th>Dictamen</th>
                                    <!--<th>Acciones</th>-->
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($dictamenesInstalacionesSinCertificado as $dictamen)
                                <tr>
                                    <td>{{ $dictamen->num_dictamen }}</td>
                                    <td>{{ $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($dictamen->fecha_emision)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $dictamen->inspeccione->inspector->name ?? 'N/A' }}</td>
                                    @php
                                        if ($dictamen->tipo_dictamen == 1) {
                                            $pdf_dictamen = '/dictamen_productor/' . $dictamen->id_dictamen;
                                        }

                                        if ($dictamen->tipo_dictamen == 2) {
                                            $pdf_dictamen = '/dictamen_envasador/' . $dictamen->id_dictamen;
                                        }

                                        if ($dictamen->tipo_dictamen == 3) {
                                            $pdf_dictamen =
                                                '/dictamen_comercializador/' . $dictamen->id_dictamen;
                                        }

                                        if ($dictamen->tipo_dictamen == 4) {
                                            $pdf_dictamen = '/dictamen_almacen/' . $dictamen->id_dictamen;
                                        }
                                    @endphp
                                    <th>
                                        <a target="_Blank" href="{{ $pdf_dictamen }}"><i class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen"></i></a>
                                    </th>
                                    <!--<td>
                                        <a href="" class="btn btn-sm btn-primary" target="_blank">
                                            Ver
                                        </a>
                                    </td>-->
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No hay dictámenes pendientes.</p>
                @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal UI-->
    <div class="modal fade" id="modalSolicitudesSinActa" tabindex="-1" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Solicitudes pendientes de subir acta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
            @if ($solicitudesSinActa->count())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Servicio</th>
                                <th>Tipo</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Inspector</th>
                                <!--<th>Acciones</th>-->
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($solicitudesSinActa as $solicitud)
                            <tr>
                                <td>{{ $solicitud->folio }}</td>
                                <td>{!! $solicitud->inspeccion->num_servicio ?? "<span class='badge bg-danger'>Sin asignar</span>" !!}</td>

                                <td>{{ $solicitud->tipo_solicitud->tipo }}</td>
                                <td>{{ $solicitud->empresa->razon_social ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y') }}
                                </td>
                                <td>{{ $solicitud->inspeccion->inspector->name ?? 'Sin asignar' }}</td>
                                <!--<td>
                                    <a href="" class="btn btn-sm btn-primary" target="_blank">
                                        Ver
                                    </a>
                                </td>-->
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No hay dictámenes pendientes.</p>
            @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal UI-->
    <div class="modal fade" id="modalSolicitudesSinInspector" tabindex="-1" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Solicitudes pendientes de asignar inspector</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
            @if ($solicitudesSinInspeccion->count())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Tipo</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Inspector</th>
                                <!--<th>Acciones</th>-->
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($solicitudesSinInspeccion as $solicitud)
                            <tr>
                                <td>{{ $solicitud->folio }}</td>
                                <td>{{ $solicitud->tipo_solicitud->tipo }}</td>
                                <td>{{ $solicitud->empresa->razon_social ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y') }}
                                </td>
                                <td>{{ $solicitud->inspeccion->inspector->name ?? 'Sin asignar' }}</td>
                                <!--<td>
                                    <a href="" class="btn btn-sm btn-primary" target="_blank">
                                        Ver
                                    </a>
                                </td>-->
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No hay dictámenes pendientes.</p>
            @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal UI-->
    <div class="modal fade" id="modalSolicitudesSinDictamen" tabindex="-1" aria-labelledby="modalDictamenLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-label-warning">
                <h5 class="modal-title" id="modalDictamenLabel">
                    <i class="ri-file-warning-fill me-2"></i>Solicitudes pendientes de generar dictamen
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
            @if ($solicitudesSinDictamen->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Folio</th>
                                <th>Servicio</th>
                                <th>Tipo</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Inspector</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($solicitudesSinDictamen as $solicitud)
                            <tr>
                                <td><strong>{{ $solicitud->folio }}</strong></td>
                                <td>{!! $solicitud->inspeccion->num_servicio ?? "<span class='badge bg-danger'>Sin asignar</span>" !!}</td>
                                <td>{{ $solicitud->tipo_solicitud->tipo ?? '—' }}</td>
                                <td>{{ $solicitud->empresa->razon_social ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->translatedFormat('d \d\e F \d\e Y') }}
                                </td>
                                <td>{{ $solicitud->inspeccion->inspector->name ?? 'Sin asignar' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">No hay solicitudes pendientes de generar dictamen.</div>
            @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal UI-->
    <div class="modal fade" id="modalRevisionActa" tabindex="-1" aria-labelledby="modalDictamenLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDictamenLabel">
                    Inspecciones pendientes de asignar revision del acta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
            @if ($revisionActa->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Folio</th>
                                <th>Servicio</th>
                                <th>Tipo</th>
                                <th>Revisor</th>
                                <th>estatus</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($revisionActa as $inspeccion)
                            <tr>
                                <td><strong>{{ $inspeccion->solicitud->folio }}</strong></td>
                                <td>{!! $inspeccion->num_servicio ?? "<span class='badge bg-danger'>Sin asignar</span>" !!}</td>
                                <td>{{ $inspeccion->solicitud->tipo_solicitud->tipo ?? '—' }}</td>
                                <td>{{ $inspeccion->ultima_revision['usuario'] ?? 'Sin revisión' }}</td>
                                <td>
                                    {{ $inspeccion->ultima_revision['decision'] ?? 'Sin revisión' }}
                                </td>
                                <td>
                                @can('Asignar revisor de acta')
                                    @if ($inspeccion->id_inspeccion 
                                    && $inspeccion->url_acta != 'Sin subir'
                                    && (!$inspeccion->ultima_revision || $inspeccion->ultima_revision['decision'] === 'Pendiente'))
                                        <div class="d-flex align-items-center gap-50">
                                            <button class="btn btn-sm btn-info dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri-settings-5-fill"></i>&nbsp;Opciones <i class="ri-arrow-down-s-fill ri-20px"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end m-0">
                                                <a data-id="{{ $inspeccion->id_inspeccion }}" 
                                                data-folio="{{ $inspeccion->num_servicio }}"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#asignarRevisorModal"
                                                class="dropdown-item waves-effect text-dark">
                                                <i class="text-warning ri-user-search-fill"></i>
                                                    Asignar revisor acta
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        Asigna un servicio y sube un acta
                                    @endif
                                @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">No hay revision de actas pendientes</div>
            @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </div>
    <!--Modal UI asignar revisor de acta-->
    <div class="modal fade" id="asignarRevisorModal" tabindex="-1"
        aria-labelledby="asignarRevisorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white" id="asignarRevisorModalLabel">Asignar revisor <span id="folio_servicio"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="asignarRevisorForm">
                @csrf
                    <input type="hidden" name="id_inspeccion" id="id_inspeccion">

                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select select2" id="id_revisor" name="id_revisor">
                            <option value="" disabled selected>Selecciona un revisor</option>
                        </select>
                        <label>Personal de la UI</label>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="ri-user-add-line"></i> Asignar revisor</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal OC-->
    <div class="modal fade" id="modalCertificadosSinEscaner" tabindex="-1" aria-labelledby="modalCertificadosLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCertificadosLabel">Certificados de granel sin escaneo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                @if ($certificadoGranelSinEscaneado->count())
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Certificado</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($certificadoGranelSinEscaneado as $certificado)
                                <tr>
                                    <td>{{ $certificado->num_certificado }}</td>
                                    <td>{{ $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No hay certificados sin escanear.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal oc-->
    <div class="modal fade" id="modalCertificadosExportacionSinEscaner" tabindex="-1"
        aria-labelledby="modalCertificadosLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCertificadosLabel">Certificados de exportación sin escaneo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                @if ($certificadoExportacionSinEscaneado->count())
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Certificado</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($certificadoExportacionSinEscaneado as $certificado)
                                <tr>
                                    <td>{{ $certificado->num_certificado }}</td>
                                    <td>{{ $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y') }}
                                    </td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No hay certificados sin escanear.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal OC-->
    <div class="modal fade" id="modalactasSinActivarHologramas" tabindex="-1"
        aria-labelledby="modalCertificadosLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCertificadosLabel">Actas sin activar hologramas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                @if ($actasSinActivarHologramas->count())
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>No. servicio</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($actasSinActivarHologramas as $solicitud)
                                <tr>
                                    <td>{{ $solicitud->folio ?? 'N/A' }}</td>
                                    <td>{!! $solicitud->inspeccion->num_servicio ?? "<span class='badge bg-danger'>Sin asignar</span>" !!}</td>
                                    <td>{{ $solicitud->empresa->razon_social ?? 'N/A' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y') }}
                                    </td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No hay actas pendientes de activar hologramas.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </div>




@endsection
