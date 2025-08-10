@extends('layouts/layoutMaster')
@section('page-script')
  <script>
    const filtroURL = "{{ route('tickets.filtrar') }}";
  </script>
  <script>
  const esAdmin = {{ auth()->user()->tipo === 2 ? 'true' : 'false' }};
</script>

@vite('resources/js/ticket_index.js')
@endsection





@section('title', 'Gestión de Tickets')


@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Gestión de Tickets</h4>

    <div class="text-end mb-3">
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNuevoTicket">
      <i class="fas fa-plus me-2"></i>+ Nuevo Ticket
    </button>
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

      <div class="col-md-12 text-end">
        <button type="submit" class="btn btn-primary">
        <i class="fas fa-search me-1"></i> Buscar
        </button>
      </div>
      </form>
    </div>
    </div>
<div class="card-datatable table-responsive">
    <!-- Tabla de tickets -->
    <table class="table table-bordered table-striped" id="ticketsTable">
    <thead class="table-dark">
      <tr>
      <th>Folio</th>
      <th>Asunto</th>
      <th>Prioridad</th>
      <th>Estado</th>
      <th>Fecha</th>
      <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($tickets as $ticket)
      <tr>
      <td>{{ $ticket->folio }}</td>
      <td>{{ $ticket->asunto }}</td>
      <td>{{ $ticket->prioridad }}</td>
      <td>{{ $ticket->estatus }}</td>
      <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
      <td>
     <button type="button"
        class="btn btn-sm btn-info"
       data-bs-toggle="modal"
        data-bs-target="#modalDetalleTicket"
        data-ticket='@json($ticket)'>
  Ver
</button>


      </td>
      </tr>
    @endforeach
    </tbody>
    </table>
    </div>

  </div>
  @include('_partials/_modals/modal_nuevo_ticket')
  @include('_partials/_modals/modal-pdfs-frames')
  @include('_partials/_modals/modalDetalleTicket')


@endsection