
<!-- Modal Asignar Revisor -->
<div class="modal fade" id="asignarRevisorModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary pb-4">
        <h5 class="modal-title text-white">Asignar revisor<span id="folio"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form id="asignarRevisorForm">

          <input type="hidden" name="id_inspeccion" id="id_inspeccion">


          <!-- Personal de UI -->
          <div class="form-floating form-floating-outline mb-3">
            <select class="form-select select2" name="personal" required>
                <option value="" disabled selected>Selecciona un revisor</option>
                @foreach ($inspectores as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <label for="">Personal de UI</label>
          </div>


          <!-- Observaciones -->
          <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones para el revisor:</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
          </div>


          <!-- Agregar mas CERTIFICADOS -->
          {{-- <div class="form-floating form-floating-outline mb-3 select2-primary">
              <select name="certificados[]" multiple class="form-control select2">
                @foreach ($certificados as $cert)
                    <option value="{{ $cert->id_certificado }}">{{ $cert->num_certificado }}</option>
                @endforeach
              </select>
            <label>Asignar a certificados</label>
          </div> --}}


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
