@php
$configData = Helper::appClasses();
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Dashboard - Analytics')
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
  'resources/assets/vendor/libs/swiper/swiper.scss'
])
@endsection

@section('page-style')
<!-- Page -->
@vite([
  'resources/assets/vendor/scss/pages/cards-statistics.scss',
  'resources/assets/vendor/scss/pages/cards-analytics.scss'
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  'resources/assets/vendor/libs/swiper/swiper.js'
])
@endsection

@section('page-script')
@vite(['resources/assets/js/dashboards-analytics.js'])
@endsection

@section('content')
<div class="row g-6">
  <!-- Gamification Card -->
  <div class="col-md-12 col-xxl-8">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-md-6 order-2 order-md-1">
          <div class="card-body">
            <h4 class="card-title mb-4">Bienvenid@ <span class="fw-bold">@if (Auth::check())
              {{ Auth::user()->name }}
            @else
              John Doe
            @endif!</span> 🎉</h4>
            <p class="mb-0">Personal del organismo certificador cidam</p><br>
            <a href="javascript:;" class="btn btn-primary">Ver pendientes</a>
          </div>
        </div>
        <div class="col-md-6 text-center text-md-end order-1 order-md-2">
          <div class="card-body pb-0 px-0 pt-2">
            <img src="{{asset('assets/img/illustrations/illustration-john-'.$configData['style'].'.png')}}" height="186" class="scaleX-n1-rtl" alt="View Profile" data-app-light-img="illustrations/illustration-john-light.png" data-app-dark-img="illustrations/illustration-john-dark.png">
            <img  height="186" class="scaleX-n1-rtl" alt="View Profile" src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/1.png') }}" >
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Gamification Card -->

  <!-- Statistics Total Order -->
  <div class="col-xxl-2 col-sm-6">
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
  </div>
  <!--/ Statistics Total Order -->

  <!-- Sessions line chart -->
  <div class="col-xxl-2 col-sm-6">
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
  </div>
  <!--/ Sessions line chart -->



@endsection
