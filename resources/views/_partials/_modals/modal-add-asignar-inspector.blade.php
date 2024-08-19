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
          <form id="addNewCliente" class="row g-5" onsubmit="return false">
            <input name="id_empresa" type="hidden" id="empresaID">
  

            <div class="col-12">
              <div class="form-floating form-floating-outline">
                <select id="id_contacto" name="id_contacto" class="select2 form-select" data-allow-clear="true">
                 @foreach ($inspectores as $inspector)
                   <option value="{{$inspector->id}}">{{$inspector->name}}</option>
                 @endforeach
                </select>
                <label for="id_contacto">Inspector de la unidad de inspección</label>
              </div>
            </div>
            
            <hr class="my-2">
            <h5 class="mb-4">Información para la inspección</h5>

            <div class="col-md-6 col-sm-12">
                <div class="form-floating form-floating-outline">
                  <input type="text" id="modalAddressAddress2" name="idcif" class="form-control" placeholder="Número de servicio" />
                  <label for="modalAddressAddress2">Número de servicio</label>
                </div>
            </div>
  
            <div class="col-md-6 col-sm-12">
              <div class="form-floating form-floating-outline">
                <input type="date" id="modalAddressAddress1" name="fecha_cedula" class="form-control" placeholder="Fecha y hora de visita" />
                <label for="modalAddressAddress1">Fecha y hora de visita</label>
              </div>
            </div>

            <div class="form-floating form-floating-outline mb-6">
                <textarea class="form-control h-px-100" id="exampleFormControlTextarea1" placeholder="Indicaciones..."></textarea>
                <label for="exampleFormControlTextarea1">Indicaciones u observaciones para la inspección</label>
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
  