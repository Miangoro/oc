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

@section('content')
<div class="container">
  <h2 class="mb-4">Crear nuevo ticket</h2>

  <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" class="ticket-form">
    @csrf
{{-- Datos del solicitante --}}
<div class="row mb-4">
  <div class="col-md-6">
    <label for="nombre">Nombre del solicitante</label>
    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $usuario->name }}" readonly>
  </div>
  <div class="col-md-6">
    <label for="email">Correo institucional</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ $usuario->email }}" readonly>
  </div>
</div>

    {{-- Asunto --}}
    <div class="form-group mb-3">
      <label for="asunto">Asunto del ticket</label>
      <input type="text" name="asunto" id="asunto" class="form-control" required>
    </div>

    {{-- Descripción --}}
    <div class="form-group mb-3">
      <label for="descripcion">Descripción detallada</label>
      <textarea name="descripcion" id="descripcion" rows="5" class="form-control" required></textarea>
    </div>

    {{-- Prioridad --}}
    <div class="form-group mb-3">
      <label for="prioridad">Prioridad</label>
      <select name="prioridad" id="prioridad" class="form-select" required>
        <option value="">Seleccione</option>
        <option value="alta">Alta</option>
        <option value="media">Media</option>
        <option value="baja">Baja</option>
      </select>
    </div>

    {{-- Evidencias --}}
    <div class="form-group mb-4">
      <label for="evidencias">Adjuntar evidencias (PDF, JPG, PNG)</label>
      <input type="file" name="evidencias[]" id="evidencias" class="form-control" multiple accept=".pdf,.jpg,.jpeg,.png">
    </div>

    {{-- Botón --}}
    <button type="submit" class="btn btn-primary">
      Registrar ticket
    </button>

    
  </form>
</div>
@include('tickets.modal_nuevo_ticket')
@include('tickets.modal_nuevo_ticket', ['usuario' => $usuario])

@endsection
