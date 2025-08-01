@extends('layouts/blankLayout')

@section('title', 'Servicio no disponible')

@section('content')
<div class="error-container" style="background: #3881cf url('{{ asset('assets/img/textura-error.png') }}') no-repeat center center / cover; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="error-box" style="text-align: center; padding: 2rem; max-width: 500px;">
        <img src="{{ asset('assets/img/error503.png') }}" alt="Error 503" style="max-width: 350px; margin-bottom: 2rem;">
        <p style="font-family: 'Roboto', sans-serif; font-size: 1.2rem; color: #ffffff;">
            El servicio no está disponible temporalmente. Por favor, vuelve a intentarlo más tarde.
        </p>
        <a href="{{ route('login') }}" class="btn-error" style="display: inline-block; margin-top: 2rem; background-color: #2fbd1dff; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Volver al inicio
        </a>
    </div>
</div>
@endsection
