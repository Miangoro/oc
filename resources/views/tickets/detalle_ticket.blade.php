@extends('layouts/layoutMaster')

<!-- Vendor Styles -->
@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/animate-css/animate.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
  ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/moment/moment.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/cleavejs/cleave.js',
    'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
  ])
@endsection

@section('title', 'Detalle del Ticket')

@section('content')
<div class="container mt-4">
    {{-- Encabezado institucional --}}
    <div class="mb-4 border-bottom pb-2">
        <h2 class="text-primary">Ticket #{{ $ticket->id }}</h2>
        <p class="text-muted">Asunto: <strong>{{ $ticket->asunto }}</strong></p>
        <p class="text-muted">Prioridad: <span class="badge bg-{{ $ticket->prioridad }}">{{ ucfirst($ticket->prioridad) }}</span></p>
        <p class="text-muted">Estado: <span class="badge bg-secondary">{{ ucfirst($ticket->estatus) }}</span></p>
        <p class="text-muted">Fecha de creación: {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
    </div>

    {{-- Mensajes tipo chat --}}
    <div class="mb-5">
        <h5 class="mb-3">Mensajes</h5>
        <div class="chat-box">
            @foreach($ticket->mensajes as $mensaje)
                <div class="mb-3 p-3 rounded 
                    {{ $mensaje->id_usuario === Auth::id() ? 'bg-light text-end' : 'bg-white text-start' }}">
                    <small class="text-muted d-block">{{ $mensaje->usuario->nombre }} | {{ $mensaje->created_at->format('d/m/Y H:i') }}</small>
                    <p class="mb-0">{{ $mensaje->contenido }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Evidencias adjuntas --}}
    <div class="mb-5">
        <h5 class="mb-3">Evidencias</h5>
        <div class="row">
            @foreach($ticket->evidencias as $evidencia)
                <div class="col-md-4 mb-3">
                    <a href="{{ asset('storage/' . $evidencia->evidencia_url) }}" target="_blank">
                        <img src="{{ asset('storage/' . $evidencia->evidencia_url) }}" class="img-fluid border rounded" alt="Evidencia">
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Footer institucional --}}
    <div class="text-center text-muted border-top pt-3">
        <small>Este ticket forma parte del sistema institucional de atención. Para dudas, contacta al área correspondiente.</small>
    </div>
</div>
@endsection
