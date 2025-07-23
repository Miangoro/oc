@extends('layouts/blankLayout') {{-- O el layout institucional base que estés utilizando --}}

@section('title', 'Página no encontrada')

@section('content')
<div class="error-container" style="background: #3881cfff; min-height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="error-box" style="text-align: center; padding: 2rem; max-width: 500px;">
        <img src="{{ asset('assets/img/pagina404.png') }}" alt="Logo OC CIDAM" style="max-width: 350px; margin-bottom: 2rem;">
        <p style="font-family: 'Roboto', sans-serif; font-size: 1.2rem; color: #ffffff;">La página que estás buscando no existe o ha sido movida.</p>
        <a href="{{ route('login') }}" class="btn-error" style="display: inline-block; margin-top: 2rem; background-color: #2fbd1dff; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 5px; font-weight: bold;">
            Ir a la página de inicio
        </a>
    </div>
</div>
@endsection
