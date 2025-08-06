<div class="modal fade" id="modalNuevoTicket" tabindex="-1" aria-labelledby="modalNuevoTicketLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalNuevoTicketLabel">Crear nuevo ticket</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form id="formCrearTicket" method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="row mb-3">
            <div class="col-md-6">
              <label>Nombre</label>
              <input type="text" class="form-control" name="nombre" value="{{ Auth::user()->name }}" readonly>
            </div>
            <div class="col-md-6">
              <label>Email</label>
              <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" readonly>
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
        </form>
      </div>

      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" form="formCrearTicket" class="btn btn-primary">Registrar</button>
      </div>
    </div>
  </div>
</div>
