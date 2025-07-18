<!-- Modal Asignar Revisor -->
<div class="modal fade" id="asignarRevisorModal" tabindex="-1" aria-labelledby="asignarRevisorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary pb-4">
        <h5 class="modal-title text-white" id="asignarRevisorModalLabel">Asignar revisor <span id="folio_certificado"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="asignarRevisorForm">

          <!-- Número de revisión -->
          <div class="form-floating form-floating-outline mb-3">
            <select class="form-select" id="numeroRevision" name="numeroRevision" required>
              <option value="" disabled selected>Seleccione una opción</option>
              <option value="1">Primera revisión</option>
              <option value="2">Segunda revisión</option>
            </select>
            <label for="numeroRevision">Número de revisión</label>
          </div>

          <!-- Personal del OC -->
          <div class="form-floating form-floating-outline mb-3">
            <select class="form-select select2" id="personalOC" name="personalOC">
              <option value="" disabled selected>Seleccione personal OC</option>
            </select>
            <label for="personalOC">Personal del organismo certificador</label>
          </div>

          <!-- Miembro del Consejo -->
          <div class="form-floating form-floating-outline mb-3">
            <select class="form-select select2" id="miembroConsejo" name="miembroConsejo">
              <option value="" disabled selected>Seleccione miembro del consejo</option>
            </select>
            <label for="miembroConsejo">Miembro del consejo</label>
          </div>

          <!-- Corrección -->
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="esCorreccion" name="esCorreccion">
            <label class="form-check-label" for="esCorreccion">¿Es una corrección?</label>
          </div>

          <!-- Observaciones -->
          <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones o indicaciones para el revisor:</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
          </div>

          

          <!-- Documento -->
          <div class="form-floating form-floating-outline mb-3">
            <input type="text" class="form-control form-control-sm" id="nombre_documento" name="nombre_documento" placeholder="Nombre del documento">
            <label for="nombre_documento">Nombre del documento</label>
          </div>

          <div class="form-floating form-floating-outline mb-3">
            <input type="file" class="form-control form-control-sm" id="archivo_documento" name="url" placeholder="Archivo">
            <label for="archivo_documento">Archivo</label>
          </div>



          {{-- <div class="form-floating form-floating-outline mb-3 select2-primary">
              <select name="certificados[]" multiple class="form-control select2">
                @foreach ($certificados as $cert)
                    <option value="{{ $cert->id_certificado }}">{{ $cert->num_certificado }}</option>
                @endforeach
              </select>
            <label>Asignar a certificados</label>
          </div> --}}




          <!-- Documento existente (se inserta dinámicamente desde JS) -->
          <div id="documentoRevision" class="mt-2"></div>

          <input type="hidden" name="id_documento" value="133">
          <input type="hidden" name="id_certificado" id="id_certificado">


          <!-- Botones -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="ri-user-add-line"></i> Asignar revisor</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
