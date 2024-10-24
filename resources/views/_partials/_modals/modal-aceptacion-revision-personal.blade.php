<!-- Modal -->
<div class="modal fade" id="modalAprobacion" tabindex="-1" aria-labelledby="modalAprobacionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAprobacionLabel">Aprobación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formAprobacion">
          <div class="mb-3">
            <label for="nombre-aprobador" class="form-label">Nombre de quien aprueba</label>
            <select id="nombre-aprobador" class="form-select">
              <option value="" disabled selected>Seleccionar...</option>
              <option value="1">Nombre 1</option>
              <option value="2">Nombre 2</option>
              <option value="3">Nombre 3</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="respuesta-aprobacion" class="form-label">Respuesta</label>
            <select id="respuesta-aprobacion" class="form-select">
              <option value="" disabled selected>Seleccionar...</option>
              <option value="aprobado">Aprobado</option>
              <option value="no-aprobado">No Aprobado</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="fecha-aprobacion" class="form-label">Fecha de Aprobación</label>
            <input type="date" id="fecha-aprobacion" class="form-control">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnRegistrar">Registrar</button>
      </div>
    </div>
  </div>
</div>
