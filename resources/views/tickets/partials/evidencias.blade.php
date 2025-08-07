@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">📎 Evidencias del Ticket #{{ $ticket->id }}</h4>

    {{-- Formulario para subir evidencia --}}
    @include('partials.evidencia-form', ['ticket' => $ticket])

    {{-- Lista de evidencias --}}
    <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
            <tr>
                <th>Archivo</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ticket->evidencias as $evidencia)
                <tr>
                    <td>{{ $evidencia->archivo }}</td>
                    <td>{{ $evidencia->descripcion }}</td>
                    <td>{{ $evidencia->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('evidencias.download', $evidencia->id) }}" class="btn btn-sm btn-primary">Descargar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
