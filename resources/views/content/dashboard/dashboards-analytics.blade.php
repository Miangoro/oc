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
    @vite(['resources/assets/vendor/scss/pages/cards-statistics.scss', 'resources/assets/vendor/scss/pages/cards-analytics.scss', 'resources/assets/vendor/scss/pages/ui-carousel.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/apex-charts/apexcharts.js', 'resources/assets/vendor/libs/swiper/swiper.js', 'resources/assets/vendor/libs/swiper/swiper.js'])
@endsection

@section('page-script')
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
                        <div class="col-md-4 p-4">
                            <div class="card-body">
                                <h4 class="card-title mb-3">
                                    👋 Bienvenido a la nueva Plataforma
                                </h4>
                                <h5 class="fw-bold text-primary mb-2">
                                    @if (Auth::check())
                                        {{ Auth::user()->name }}
                                    @else
                                        Sin usuario logeado
                                    @endif
                                </h5>
                                <p class="text-muted fs-5">
                                    @if (Auth::check() && Auth::user()->puesto)
                                        {{ Auth::user()->puesto }}
                                    @elseif(Auth::user()->empresa)
                                        {{ Auth::user()->empresa->razon_social }}
                                    @else
                                        Miembro del consejo
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Imagen decorativa -->
                        <div class="col-md-8 text-center d-none d-md-block">
                            <div class="swiper text-white" id="swiper-with-arrows">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide"
                                        style="background-image:url({{ asset('assets/img/pages/header3.png') }})"></div>
                                    <div class="swiper-slide"
                                        style="background-image:url({{ asset('assets/img/elements/1.jpg') }})">Slide 2</div>
                                </div>
                                <div class="swiper-button-next swiper-button-white custom-icon">
                                </div>
                                <div class="swiper-button-prev swiper-button-white custom-icon">
                                </div>
                            </div>
                        </div>
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
                            <h6 class="mb-0 fw-normal">Pendiente de subir acta</h6>

                            <hr>
                            <div class="d-flex align-items-center mb-2 cursor-pointer" data-bs-toggle="modal"
                                data-bs-target="#modalSolicitudesSinDictamen">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-warning"><i class="ri-file-warning-line ri-24px"></i></span>
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
                                            class="text-dark">{{ $certificado->dictamen->inspeccione->solicitud->empresa->razon_social }}</small> <br>
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
                            <p class="mb-0">
                                <!--<span class="me-1 fw-medium">-2.5%</span>
                                                            <small class="text-muted">than last week</small>-->
                            </p>
                        </div>
                    </div>
                </div>
            @endcan
            @can('Estadísticas ui')
                <div class="col-md-6 col-xxl-3">
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
                <div class="col-6 mb-6">
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
            <div class="row">
            @can('Estadísticas ui')
                <!-- Line Chart -->
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
                </div>
            @endcan

@canany(['Estadísticas consejo', 'Estadísticas oc'])
    @php
        $tipos = [1 => 'Instalaciones', 2 => 'Granel', 3 => 'Exportación'];
        $agrupado = $revisiones->groupBy(fn($r) => $r->user_id . '-' . $r->rol);
    @endphp

 
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header pb-2">
                    <h5 class="mb-1">📊 Resumen de revisiones por revisor</h5>
                    <small class="text-muted">Cantidad de revisiones realizadas por revisor y tipo de certificado.</small>
                </div>

                <div class="card-body pt-2">
                    <div class="table-responsive border-top">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>👤 Revisor</th>
                                    <th class="text-center">🏗️ Instalaciones</th>
                                    <th class="text-center">🌾 Granel</th>
                                    <th class="text-center">🚢 Exportación</th>
                                    <th class="text-center">Pendientes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($agrupado as $key => $grupo)
                                    @php
                                        $revisor = $usuarios[$grupo->first()->user_id] ?? null;
                                        $rol = $grupo->first()->rol;
                                        $inst = $grupo->firstWhere('tipo_certificado', 1)?->total ?? 0;
                                        $gran = $grupo->firstWhere('tipo_certificado', 2)?->total ?? 0;
                                        $expo = $grupo->firstWhere('tipo_certificado', 3)?->total ?? 0;
                                         $pendientes = $grupo->where('decision', 'Pendiente')->sum('total');
                                    @endphp
                                    <tr>
                                       <td @class([
                                                'bg-primary text-white fw-bold' => $revisor?->id == auth()->id()
                                            ])>

                                            <li class="d-flex align-items-center mb-6">
                                                <div class="avatar flex-shrink-0 me-4">
                                               @if (!empty($revisor?->profile_photo_path))
                                                    <img 
                                                        src="/storage/{{ $revisor->profile_photo_path }}" 
                                                        alt="{{ $revisor->name ?? '—' }}" 
                                                        class="rounded-3" 
                                                        style="width: 40px; height: 40px;">
                                                @endif


                                                </div>
                                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <h6 class="mb-0"> {{ $revisor?->name ?? '—' }}</h6>
                                               
                                                </div>
                                               <div class="badge 
                                                    {{ $rol === 'Personal' ? 'bg-label-info' : ($rol === 'Consejo' ? 'bg-label-warning' : 'bg-label-secondary') }} 
                                                    rounded-pill">
                                                    {{ $rol }}
                                                </div>

                                                </div>
                                            </li>
                                           </td>
                                        <td class="text-end">{{ number_format($inst) }}</td>
                                        <td class="text-end">{{ number_format($gran) }}</td>
                                        <td class="text-end">{{ number_format($expo) }}</td>
                                       <td class="text-end {{ $pendientes > 0 ? 'bg-danger text-white fw-bold' : '' }}">
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

    </div>




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
                                                        {{ ucfirst(\Carbon\Carbon::parse($item->mes . '-01')->locale('es')->isoFormat('MMMM YYYY')) }}
                                                    </span>
                                                </td>
                                                <td class="text-end py-4">
                                                    <span class="text-heading fw-medium">{{ $item->total }}</span>
                                                </td>
                                                <td class="text-end pe-0 py-4">
                                                    <span class="text-heading fw-medium"> {{ $item->certificado_reexpedido ? 1 : 0 }}</span>
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
                                                        <td>{{ \Carbon\Carbon::parse($fecha)->locale('es')->translatedFormat('d \d\e F') }}</td>
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
            @foreach ($marcasConHologramas as $marca)
                @php
                    $totalDisponibles = $marca->solicitudHolograma->sum(function ($solicitud) {
                        return $solicitud->cantidadDisponibles();
                    });
                @endphp

                <div class="col-sm-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center flex-wrap">
                                <div class="avatar me-4">
                                    <div class="avatar-initial bg-label-primary rounded-3">
                                        <i class="ri-price-tag-3-line ri-24px"></i>
                                    </div>
                                </div>
                                <div class="card-info">
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-0 me-2">{{ number_format($totalDisponibles, 0) }}</h5>
                                        <i class="ri-arrow-down-s-line text-danger ri-20px"></i>
                                        <small class="text-danger">Hologramas disponibles</small>
                                    </div>
                                    <p class="mb-0">{{ $marca->marca }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

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
                                        <td>{{ $solicitud->tipo_solicitud->tipo ?? '—' }}</td>
                                        <td>{{ $solicitud->empresa->razon_social ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->translatedFormat('d \d\e F \d\e Y') }}</td>
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
                                        <td>{{ $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y') }}</td>
                                     
                                 
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
<div class="modal fade" id="modalCertificadosExportacionSinEscaner" tabindex="-1" aria-labelledby="modalCertificadosLabel" aria-hidden="true">
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
                                        <td>{{ $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y') }}</td>
                                     
                                 
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




        

    @endsection
