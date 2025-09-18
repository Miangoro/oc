<style>
  /* Aplica cuando select2 no tiene opción seleccionada */
  .select2-container--default.select2-empty .select2-selection--single {
    background-color: #fff3cd52 !important; /* fondo amarillo claro */
    border-color: #ffc107 !important; /* borde ámbar */
  }
</style>

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

          <input type="hidden" name="id_certificado" id="id_certificado">


          <!-- Personal de UI -->
          <div class="form-floating form-floating-outline mb-3">
            <select class="form-select select2" id="personalOC" name="personalOC">
                <option value="" disabled selected>Selecciona un revisor</option>
                @foreach ($inspectores as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <label for="">Personal de UI</label>
          </div>


          <!-- Observaciones -->
          <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones o indicaciones para el revisor:</label>
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
