<!-- Modal Asignar Revisor -->
<div class="modal fade" id="asignarRevisorModal" tabindex="-1" aria-labelledby="asignarRevisorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="asignarRevisorModalLabel">Asignar Revisor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="asignarRevisorForm">
          
          <!-- Revisión por parte de -->
          <div class="mb-3">
            <label for="tipoRevisor" class="form-label">Revisión por parte de:</label>
            <select class="form-select" id="tipoRevisor" name="tipoRevisor" required>
              <option value="">Seleccione una opción</option>
              <option value="organismo">Personal del organismo certificador</option>
              <option value="consejo">Miembro del consejo para la decisión de la certificación</option>
            </select>
          </div>

          <!-- Selecciona el nombre del revisor -->
          <div class="mb-3">
            <label for="nombreRevisor" class="form-label">Selecciona el nombre del revisor:</label>
            <select class="form-select" id="nombreRevisor" name="nombreRevisor" required>
              <!-- Este select se llenará dinámicamente según el tipo de revisor seleccionado -->
              <option value="">Seleccione un nombre</option>
            </select>
          </div>

          <!-- Selecciona el número de revisión -->
          <div class="mb-3">
            <label for="numeroRevision" class="form-label">Selecciona el número de revisión:</label>
            <select class="form-select" id="numeroRevision" name="numeroRevision" required>
              <option value="">Seleccione una opción</option>
              <option value="primera">Primera revisión</option>
              <option value="segunda">Segunda revisión</option>
            </select>
          </div>

          <!-- ¿Es una corrección? -->
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="esCorreccion" name="esCorreccion">
            <label class="form-check-label" for="esCorreccion">¿Es una corrección?</label>
          </div>

          <!-- Observaciones o indicaciones -->
          <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones o indicaciones que le ayuden al revisor:</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Escribe observaciones o indicaciones (opcional)"></textarea>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Asignar Revisor</button>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
