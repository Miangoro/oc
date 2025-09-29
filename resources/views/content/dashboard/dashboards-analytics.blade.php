@php
    $configData = Helper::appClasses();
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Inicio')



@section('vendor-style')
    @vite(['resources/assets/vendor/libs/apex-charts/apex-charts.scss', 'resources/assets/vendor/libs/swiper/swiper.scss'])
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
    @vite(['resources/assets/vendor/scss/pages/cards-statistics.scss', 'resources/assets/vendor/scss/pages/cards-analytics.scss', 'resources/assets/vendor/scss/pages/ui-carousel.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/swiper/swiper.js', 'resources/assets/vendor/libs/swiper/swiper.js'])
@endsection

@section('page-script')
    <script>
        const revisionesMesURL = "{{ route('estadisticas.revisiones-mes') }}";
    </script>

    @vite(['resources/assets/js/dashboards-analytics.js', 'resources/assets/js/ui-carousel.js'])

@endsection




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
                                <div class="dashboard-messages d-flex justify-content-center align-items-center h-100 pe-5">
                                    <div class="w-100 pe-5">
                                        @foreach ($mensajes as $mensaje)
                                            @if ($mensaje->activo == 1 && ($mensaje->id_usuario_destino == auth()->id() || is_null($mensaje->id_usuario_destino)))
                                                <div class="message-card p-3 mb-2 rounded shadow-sm"
                                                    style="min-height: 300px; background-color: #f4f8fc; border-left: 4px solid {{ $mensaje->tipo == 'danger' ? '#dc3545' : ($mensaje->tipo == 'success' ? '#28a745' : '#053160') }};">
                                                    <div class="mb-2 py-1 px-2 text-center">
                                                        <h4
                                                            class="mb-1 {{ $mensaje->tipo_titulo != 'Normal' ? 'text-' . $mensaje->tipo_titulo : '' }}">
                                                            <strong>{{ $mensaje->titulo }}</strong>
                                                        </h4>
                                                        <h5
                                                            class="mb-0 {{ $mensaje->tipo != 'Normal' ? 'text-' . $mensaje->tipo : '' }}">
                                                            {{ $mensaje->mensaje }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>


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
        </div>







        <div class="row g-6">
            @can('Estadísticas ui')
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2" data-bs-toggle="modal"
                                data-bs-target="#modalSolicitudesSinInspector">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-primary"><i
                                            class="ri-group-fill ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $solicitudesSinInspeccion->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Pendiente de asignar inspector</h6>
                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#modalSolicitudesSinActa">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-warning"><i
                                            class="ri-file-list-fill ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $solicitudesSinActa->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Pendiente de subir acta 2025</h6>

                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#modalSolicitudesSinDictamen">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-warning"><i
                                            class="ri-file-warning-line ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $solicitudesSinDictamen->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Pendiente de crear dictamen</h6>

                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#modalSolicitudesSinActa">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-warning"><i
                                            class="ri-file-list-fill ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $lotesSinFq->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Lotes pendientes de subir FQ</h6>

                        </div>
                    </div>
                </div>
            @endcan




            @can('Estadísticas ui')
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-border-shadow-danger h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-danger"><i
                                            class="ri-close-circle-fill ri-24px"></i></span>
                                </div>
                                <h5 class="mb-0">

                                    @foreach ($dictamenesPorVencer as $dictamen)
                                        {{ $dictamen->num_dictamen }} <small
                                            class="text-muted">{{ $dictamen->fecha_vigencia }}</small> <br>
                                    @endforeach
                                </h5>
                            </div>
                            <h6 class="mb-0 fw-normal">Dictámenes por vencer</h6>
                        </div>
                    </div>
                </div>
            @endcan

            @can('Estadísticas oc')
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#modalDictamenesInstalacionesPendientes">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-danger"><i
                                            class="ri-file-warning-line ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $dictamenesInstalacionesSinCertificado->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Pendiente de crear certificado de instalaciones</h6>
                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#modalDictamenesGranelPendientes">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-danger"><i
                                            class="ri-file-warning-line ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $dictamenesGranelesSinCertificado->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Pendiente de crear certificado de graneles</h6>
                            <hr>
                            <!-- BOTÓN o DIV CLICKABLE para abrir el modal -->
                            <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#modalDictamenesExportacionPendientes">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-danger">
                                        <i class="ri-file-warning-line ri-24px"></i>
                                    </span>
                                </div>
                                <h4 class="mb-0">{{ $dictamenesExportacionSinCertificado->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Pendiente de crear certificado de exportación</h6>

                        </div>
                    </div>
                </div>
            @endcan

            @can('Estadísticas oc')
                <div class="col-sm-6 col-lg-3">
                    <div class="card card-border-shadow-info h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-danger"><i
                                            class='ri-close-circle-fill ri-24px'></i></span>
                                </div>
                                <h5 class="mb-0 text-danger">

                                    @foreach ($certificadosPorVencer as $certificado)
                                        {{ $certificado->num_certificado }} <small
                                            class="text-muted">{{ $certificado->fecha_vigencia }}</small> <small
                                            class="text-dark">{{ $certificado->dictamen->inspeccione->solicitud->empresa->razon_social }}</small>
                                        <br>
                                    @endforeach

                                </h5>
                            </div>
                            <h6 class="mb-0 fw-normal">Certificados de instalaciones por vencer</h6>
                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#modalCertificadosInstalacionesSinEscaner">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-warning"><i
                                            class="ri-file-list-fill ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $certificadoInstalacionesSinEscaneado->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Certificados de instalaciones sin escaneado</h6>
                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#modalCertificadosSinEscaner">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-warning"><i
                                            class="ri-file-list-fill ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $certificadoGranelSinEscaneado->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Certificados de graneles sin escaneado</h6>
                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#modalCertificadosExportacionSinEscaner">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-warning"><i
                                            class="ri-file-list-fill ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $certificadoExportacionSinEscaneado->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Certificados de exportación sin escaneado</h6>
                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#modalactasSinActivarHologramas">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-danger">
                                        <i class="ri-close-circle-line ri-24px"></i>
                                    </span>
                                </div>
                                <h4 class="mb-0">{{ $actasSinActivarHologramas->count() }}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Actas sin activar hologramas</h6>
                            <hr>
                            <p class="mb-0">
                                <!--<span class="me-1 fw-medium">-2.5%</span>
                                                                                                    <small class="text-muted">than last week</small>-->
                            </p>
                        </div>
                    </div>
                </div>
            @endcan
            @can('Estadísticas ui')
                <div class="col-md-6 col-xxl-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Inspecciones por inspector 2025</h5>
                            <div class="dropdown">
                                <!-- <button class="btn text-body-secondary p-0" type="button" id="meetingSchedule" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                <i class="icon-base ri ri-more-2-line"></i>
                                                                              </button>
                                                                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="meetingSchedule">
                                                                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Last 28 Days</a>
                                                                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Month</a>
                                                                                <a class="dropdown-item waves-effect" href="javascript:void(0);">Last Year</a>
                                                                              </div>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 m-0">

                                @foreach ($inspeccionesInspector as $inspector)
                                    <li class="d-flex align-items-center mb-4 pb-2">
                                        <div class="avatar flex-shrink-0 me-4">
                                            <img src="{{ asset('storage/' . $inspector['foto']) }}"
                                                alt="Foto de {{ $inspector['nombre'] }}" class="rounded-3" width="50">
                                        </div>
                                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">{{ $inspector['nombre'] }}</h6>
                                                <small class="d-flex align-items-center">
                                                    <!-- <i class="icon-base ri ri-calendar-line icon-16px"></i>
                                                                                      <span class="ms-2">21 Jul | 08:20-10:30</span>-->
                                                </small>
                                            </div>
                                            <div class="badge bg-label-primary rounded-pill">
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
                <!-- Line Chart -->
                <div class="col-8 mb-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div>
                                <h5 class="card-title mb-0">Certificados emitidos por mes</h5>
                                <div class="mb-0">
                                    <label for="selectAnio" class="form-label">Selecciona un año:</label>
                                    <select id="selectAnio" class="form-select w-auto">
                                        @for ($i = now()->year; $i >= 2022; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="lineChart"></div>
                        </div>
                    </div>
                </div>
            @endcan

            @can('Estadísticas ui')
                <!-- Line Chart
                                                    <div class="col-6 mb-6">
                                                        <div class="card">
                                                            <div class="card-header d-flex justify-content-between">
                                                                <div>
                                                                    <h5 class="card-title mb-0">Servicios realizados por mes</h5>
                                                                    <div class="mb-0">
                                                                        <label for="selectAnio2" class="form-label">Selecciona un año:</label>
                                                                        <select id="selectAnio2" class="form-select w-auto">
                                                                            @for ($i = now()->year; $i >= 2022; $i--)
        <option value="{{ $i }}">{{ $i }}</option>
        @endfor
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div id="lineChart2"></div>
                                                            </div>
                                                        </div>
                                                    </div> -->
            @endcan

            @canany(['Estadísticas consejo', 'Estadísticas oc'])
                @php
                    $tipos = [1 => 'Instalaciones', 2 => 'Granel', 3 => 'Exportación'];
                    $agrupado = $revisiones->groupBy(fn($r) => $r->user_id . '-' . $r->rol);
                @endphp


                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header pb-2">
                            <div
                                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                <div>
                                    <h5 class="mb-1">📊 Resumen de revisiones por revisor</h5>
                                    <small class="text-muted">Cantidad de revisiones realizadas por revisor y tipo de
                                        certificado.</small>
                                </div>
                                <form method="GET" class="mt-2 mt-md-0">
                                    <div class="input-group input-group-sm">
                                        <label class="input-group-text" for="mes">Mes</label>
                                        @php
                                            $mesSeleccionado = request('mes', now()->month);
                                        @endphp
                                        <select name="mes" id="mes" class="form-select form-select-sm">
                                            <option value="">Todos</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                {{-- <option value="{{ $i }}" {{ request('mes') == $i ? 'selected' : '' }}> --}}
                                                <option value="{{ $i }}"
                                                    {{ $mesSeleccionado == $i ? 'selected' : '' }}>
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
                                            <th>{{-- 👤 --}}<i class="ri-user-3-fill"></i> Revisor</th>
                                            <th class="text-center">🏗️{{-- <i class="ri-building-4-fill"> --}}</i> Instalaciones</th>
                                            <th class="text-center">🌾{{-- <i class="ri-plant-line"></i> --}} Granel</th>
                                            <th class="text-center">🚢{{-- <i class="ri-ship-line"></i> --}} Exportación</th>
                                            <th class="text-center">{{-- <i class="ri-time-line"></i> --}} Pendientes</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-revisiones">

                                        @forelse ($agrupado as $key => $grupo)
                                            @php
                                                $revisor = $usuarios[$grupo->first()->user_id] ?? null;
                                                $rol = $grupo->first()->rol;
                                                $inst = $grupo
                                                    ->where('tipo_certificado', 1)
                                                    ->where('decision', '!=', 'Pendiente')
                                                    ->sum('total');
                                                $gran = $grupo
                                                    ->where('tipo_certificado', 2)
                                                    ->where('decision', '!=', 'Pendiente')
                                                    ->sum('total');
                                                $expo = $grupo
                                                    ->where('tipo_certificado', 3)
                                                    ->where('decision', '!=', 'Pendiente')
                                                    ->sum('total');
                                                $pendientes = $grupo->where('decision', 'Pendiente')->sum('total');
                                            @endphp
                                            <tr>
                                                <td class="{{ $revisor?->id == auth()->id() ? 'bg-primary text-white fw-bold' : '' }}"
                                                    style="padding: 0.25rem 0.5rem;">
                                                    <div class="d-flex align-items-center gap-2 hover-scale"
                                                        style="background-color: #f0f0f0;  border-radius: 13px; padding: 0.10rem 0.5rem;">
                                                        <div class="avatar flex-shrink-0">
                                                            @if (!empty($revisor?->profile_photo_path))
                                                                <img src="/storage/{{ $revisor->profile_photo_path }}"
                                                                    alt="{{ $revisor->name ?? '—' }}" class="rounded-pill"
                                                                    style="width: 36px; height: 36px; object-fit: cover;">
                                                            @endif
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-0"
                                                                style="font-weight: 600; font-size: 0.9rem; color: #212529;">
                                                                {{ $revisor?->name ?? '—' }}
                                                            </h6>
                                                            <span
                                                                class="badge rounded-pill
                                                                 {{ $rol === 'Personal' ? 'bg-label-info' : ($rol === 'Consejo' ? 'bg-label-warning' : 'bg-label-secondary') }}"
                                                                style="font-size: 0.9rem; padding: 0.2em 0.5em;">
                                                                {{ $rol }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- <td
                                                    class="{{ $revisor?->id == auth()->id() ? 'bg-primary text-white fw-bold' : '' }}">
                                                    <div
                                                        class="bg-{{ $revisor?->id == auth()->id() ? 'primary text-white' : 'light' }} shadow-sm rounded-pill px-3 py-2 d-flex align-items-center gap-3">

                                                        <div class="avatar flex-shrink-0">
                                                            @if (!empty($revisor?->profile_photo_path))
                                                                <img src="/storage/{{ $revisor->profile_photo_path }}"
                                                                    alt="{{ $revisor->name ?? '—' }}" class="rounded-circle"
                                                                    style="width: 40px; height: 40px;">
                                                            @endif
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <h6 class="mb-1 fw-semibold text-dark">
                                                                {{ $revisor?->name ?? '—' }}</h6>
                                                            <span
                                                                class="badge {{ $rol === 'Personal' ? 'bg-label-info' : ($rol === 'Consejo' ? 'bg-label-warning' : 'bg-label-secondary') }} rounded-pill">
                                                                {{ $rol }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td> --}}

                                                <td class="text-end">{{ number_format($inst) }}</td>
                                                <td class="text-end">{{ number_format($gran) }}</td>
                                                <td class="text-end">{{ number_format($expo) }}</td>
                                                <td
                                                    class="text-end {{ $pendientes > 0 ? 'bg-danger text-white fw-bold' : '' }}">
                                                    {{ number_format($pendientes) }}
                                                </td>


                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No hay revisiones
                                                    registradas.</td>
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
                            <h5 class="card-title m-0 me-2">Certificados de exportación</h5>

                        </div>
                        <div class="card-body pb-1 pt-0">
                            <div class="mb-6 mt-1">

                                <p class="mt-0">Cierre por mes</p>
                            </div>
                            <div class="table-responsive text-nowrap border-top">
                                <table class="table">
                                    <tbody class="table-border-bottom-0">
                                        <th>
                                            <tr>
                                                <td class="text-end">Mes</td>
                                                <td class="text-end">Certificados</td>
                                                <td class="text-end">Reexpediciónes</td>
                                            </tr>
                                        </th>
                                        @foreach ($TotalCertificadosExportacionPorMes as $item)
                                            <tr>
                                                <td class="ps-0 pe-12 py-4">
                                                    <span class="text-heading">
                                                        {{ ucfirst(\Carbon\Carbon::createFromFormat('Y-m-d', $item->mes . '-01')->locale('es')->isoFormat('MMMM YYYY')) }}

                                                    </span>
                                                </td>
                                                <td class="text-end py-4">
                                                    <span class="text-heading fw-medium">{{ $item->total }}</span>
                                                </td>
                                                <td class="text-end pe-0 py-4">
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
            @php
                use Carbon\Carbon;
            @endphp
            @can('Estadísticas exportación clientes')
                <div class="col-md-10 col-xxl-6">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Servicios de exportación</h5>

                        </div>
                        <div class="card-body pb-1 pt-0">
                            <div class="mb-6 mt-1">

                                <p class="mt-0">Cierre por mes</p>
                            </div>
                            <div class="table-responsive text-nowrap border-top">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Año</th>
                                            <th>Mes</th>
                                            <th>Día del Servicio</th>
                                            <th>Instalación</th>
                                            <th>Servicios únicos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $agrupadoPorAnio = collect($serviciosInstalacion)
                                                ->filter(function ($_, $mes) {
                                                    return preg_match('/^\d{4}-\d{2}$/', $mes);
                                                })
                                                ->groupBy(function ($_, $mes) {
                                                    return \Carbon\Carbon::parse($mes . '-01')->format('Y');
                                                });

                                        @endphp

                                        @foreach ($agrupadoPorAnio as $anio => $meses)
                                            <tr class="table-primary fw-bold">
                                                <td colspan="5">Año: {{ $anio }}</td>
                                            </tr>

                                            @foreach ($meses as $mes => $fechas)
                                                <tr class="table-secondary">
                                                    <td></td>
                                                    @if (preg_match('/^\d{4}-\d{2}$/', $mes))
                                                <tr class="table-primary fw-bold">
                                                    <td colspan="4">
                                                        {{ \Carbon\Carbon::parse($mes . '-01')->locale('es')->isoFormat('MMMM YYYY') }}
                                                    </td>
                                                </tr>
                                            @else
                                                <tr class="table-danger fw-bold">
                                                    <td colspan="4">Mes no válido: {{ $mes }}</td>
                                                </tr>
                                            @endif

                                            </tr>

                                            @foreach ($fechas as $fecha => $instalaciones)
                                                @foreach ($instalaciones as $direccion => $cantidad)
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td>{{ \Carbon\Carbon::parse($fecha)->locale('es')->translatedFormat('d \d\e F') }}
                                                        </td>
                                                        <td>{{ $direccion }}</td>
                                                        <td>{{ $cantidad }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>



                            </div>

                        </div>
                    </div>
                </div>
            @endcan
            @can('Estadísticas hologramas clientes')
<div class="row g-4"> {{-- g-4 para buen espacio entre tarjetas --}}
    @foreach ($marcasConHologramas as $marca)
        @php
            $totalDisponibles = $marca->solicitudHolograma()
                ->where('id_empresa', $empresaId)
                ->get()
                ->sum(fn ($solicitud) => $solicitud->cantidadDisponibles());
        @endphp

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card shadow-lg border-0 h-100 rounded-4 overflow-hidden hover-card">
                <div class="card-body p-4 text-center d-flex flex-column justify-content-between">

                    {{-- Ícono grande con fondo degradado --}}
                    <div class="mx-auto mb-3 icon-wrapper">
                        <i class="ri-price-tag-3-line display-4 text-white"></i>
                    </div>

                    {{-- Cantidad de hologramas --}}
                    <h2 class="fw-bold text-primary mb-1">
                        {{ number_format($totalDisponibles, 0) }}
                    </h2>
                    <p class="text-muted mb-3">Hologramas disponibles</p>

                    {{-- Nombre de la marca --}}
                    <h5 class="fw-semibold text-dark">{{ $marca->marca }}</h5>

                </div>
            </div>
        </div>
    @endforeach
</div>
@endcan




        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalDictamenesExportacionPendientes" tabindex="-1" aria-labelledby="modalLabel"
            aria-hidden="true">
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
                                                <th><a target="_Blank"
                                                        href="/dictamen_exportacion/{{ $dictamen->id_dictamen }}"><i
                                                            class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen"></i></a>
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

        <!-- Modal -->
        <div class="modal fade" id="modalDictamenesGranelPendientes" tabindex="-1" aria-labelledby="modalLabel"
            aria-hidden="true">
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
                                                <th><a target="_Blank"
                                                        href="/dictamen_granel/{{ $dictamen->id_dictamen }}"><i
                                                            class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen"></i></a>
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

        <!-- Modal -->
        <div class="modal fade" id="modalDictamenesInstalacionesPendientes" tabindex="-1" aria-labelledby="modalLabel"
            aria-hidden="true">
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
                                                <th><a target="_Blank" href="{{ $pdf_dictamen }}"><i
                                                            class="ri-file-pdf-2-fill text-danger ri-28px cursor-pointer pdfDictamen"></i></a>
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

        <!-- Modal -->
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

        <!-- Modal -->
        <div class="modal fade" id="modalSolicitudesSinDictamen" tabindex="-1" aria-labelledby="modalDictamenLabel"
            aria-hidden="true">
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

        <!-- Modal -->
        <div class="modal fade" id="modalCertificadosSinEscaner" tabindex="-1" aria-labelledby="modalCertificadosLabel"
            aria-hidden="true">
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

        <!-- Modal -->
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

        <!-- Modal -->
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
