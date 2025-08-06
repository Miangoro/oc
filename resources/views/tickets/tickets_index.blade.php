@extends('layouts/layoutMaster')

@section('page-script')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const btnNuevo = document.getElementById('btnNuevoTicket');
    const btnCancelar = document.getElementById('btnCancelarTicket');
    const formulario = document.getElementById('formularioTicket');

    btnNuevo?.addEventListener('click', () => {
      formulario?.classList.remove('d-none');
      btnNuevo.classList.add('d-none');
    });

    btnCancelar?.addEventListener('click', () => {
      formulario?.classList.add('d-none');
      btnNuevo.classList.remove('d-none');
    });
  });
</script>
@endsection


@section('title', 'Gestión de Tickets')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4">Gestión de Tickets</h4>

  <div class="text-end mb-3">
  <button class="btn btn-success" id="btnNuevoTicket">
    <i class="fas fa-plus me-2"></i> + Nuevo Ticket
  </button>
</div>

<div id="formularioTicket" class="card p-4 mb-4 d-none">
  <h5 class="mb-3">Crear nuevo ticket</h5>
  <form id="formCrearTicket" enctype="multipart/form-data">
    <div class="row mb-3">
      <div class="col-md-6">
        <label>Nombre</label>
        <input type="text" class="form-control" name="nombre" required>
      </div>
      <div class="col-md-6">
        <label>Email</label>
        <input type="email" class="form-control" name="email" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>Asunto del ticket</label>
        <input type="text" class="form-control" name="asunto" required>
      </div>
      <div class="col-md-6">
        <label>Prioridad</label>
        <select class="form-select" name="prioridad" required>
          <option value="">Selecciona</option>
          <option value="Alta">Alta</option>
          <option value="Media">Media</option>
          <option value="Baja">Baja</option>
        </select>
      </div>
    </div>

    <div class="mb-3">
      <label>Descripción detallada</label>
      <textarea class="form-control" name="descripcion" rows="4" required></textarea>
    </div>

    <div class="mb-3">
      <label>Adjuntar evidencias (PDF, JPG, PNG)</label>
      <input type="file" class="form-control" name="evidencias[]" multiple accept=".pdf,.jpg,.jpeg,.png">
    </div>

    <div class="text-end">
      <button type="submit" class="btn btn-primary">Registrar</button>
      <button type="button" class="btn btn-danger" id="btnCancelarTicket">Cancelar</button>
    </div>
  </form>
</div>


  <!-- Filtros -->
  <div class="card mb-4">
    <div class="card-body">
      <form id="ticketFilterForm" class="row g-3">
        <div class="col-md-4">
          <label for="estado" class="form-label">Estado</label>
          <select id="estado" class="form-select select2">
            <option value="">Todos</option>
            <option value="abierto">Abierto</option>
            <option value="cerrado">Cerrado</option>
          </select>
        </div>
        <div class="col-md-4">
          <label for="prioridad" class="form-label">Prioridad</label>
          <select id="prioridad" class="form-select select2">
            <option value="">Todas</option>
            <option value="alta">Alta</option>
            <option value="media">Media</option>
            <option value="baja">Baja</option>
          </select>
        </div>
        <div class="col-md-4">
          <label for="responsable" class="form-label">Responsable</label>
          <select id="responsable" class="form-select select2">
            <option value="">Todos</option>
            {{-- Aquí puedes iterar responsables --}}
          </select>
        </div>
      </form>
    </div>
  </div>

  <!-- Tabla de tickets -->
  <div class="card">
    <div class="card-body">
      <table class="table table-bordered table-striped" id="ticketsTable">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Asunto</th>
            <th>Estado</th>
            <th>Prioridad</th>
            <th>Fecha</th>
            <th>Responsable</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {{-- Aquí iteras los tickets --}}
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
