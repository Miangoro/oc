@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">💬 Mensajes del Ticket #{{ $ticket->id }}</h4>

    <div class="card mb-4">
        <div class="card-body">
            @foreach($ticket->mensajes as $mensaje)
                <div class="mb-3">
                    <strong class="{{ $mensaje->es_admin ? 'text-primary' : 'text-success' }}">
                        {{ $mensaje->usuario->nombre }}:
                    </strong>
                    <p class="mb-1">{{ $mensaje->contenido }}</p>
                    <small class="text-muted">{{ $mensaje->created_at->format('d/m/Y H:i') }}</small>
                </div>
                <hr>
            @endforeach
        </div>
    </div>

    {{-- Formulario para nuevo mensaje --}}
    @include('partials.mensaje-form', ['ticket' => $ticket])
</div>
@endsection
