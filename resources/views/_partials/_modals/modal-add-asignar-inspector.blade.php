<!-- Add New Address Modal -->
<div class="modal fade" id="asignarInspector" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-add-new-address">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0">
          <div class="text-center mb-6">
            <h4 class="address-title mb-2">Asignar inspector</h4>
            <p class="address-subtitle">Folio de solicitud</p>
          </div>
          <form id="addAsignarInspector" class="row g-5" onsubmit="return false">
            <input name="id_solicitud" type="hidden" id="id_solicitud">
  

            <div class="col-12">
              <div class="form-floating form-floating-outline">
                <select id="id_inspector" name="id_inspector" class="select2 form-select" data-allow-clear="true">
                 @foreach ($inspectores as $inspector)
                   <option value="{{$inspector->id}}">{{$inspector->name}}</option>
                 @endforeach
                </select>
                <label for="id_inspector">Inspector de la unidad de inspección</label>
              </div>
            </div>
            
            <hr class="my-2">
            <h5 class="mb-4">Información para la inspección</h5>

            <div class="col-md-6 col-sm-12">
                <div class="form-floating form-floating-outline">
                  <input type="text" id="num_servicio" name="num_servicio" class="form-control" placeholder="Número de servicio" />
                  <label for="num_servicio">Número de servicio</label>
                </div>
            </div>
  
            <div class="col-md-6 col-sm-12">
              <div class="form-floating form-floating-outline">
                <input type="date" id="fecha_servicio" name="fecha_servicio" class="form-control" placeholder="Fecha y hora de visita" />
                <label for="fecha_servicio">Fecha y hora de visita</label>
              </div>
            </div>

            <div class="form-floating form-floating-outline mb-6">
                <textarea name="observaciones" class="form-control h-px-100" id="observaciones" placeholder="Indicaciones..."></textarea>
                <label for="observaciones">Indicaciones u observaciones para la inspección</label>
              </div>
            


            
            <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
              <button type="submit" class="btn btn-primary">Registrar</button>
              <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--/ Add New Address Modal -->
  