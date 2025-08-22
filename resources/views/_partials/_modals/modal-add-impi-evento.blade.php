<!-- AGREGAR EVENTO IMPI MODAL -->
<div class="modal fade" id="addEvento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header bg-primary pb-4">
                <h5 class="modal-title text-white">Agregar evento <span id="folio"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="NuevoEvento">
                <input type="hidden" name="id_impi" id="id_impi">

                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-6">
                            <input type="text" class="form-control" name="evento" placeholder="Titulo">
                            <label for="">Titulo</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-6">
                            <textarea name="descripcion" class="form-control h-px-100" placeholder="Descripción"></textarea>
                            <label for="">Descripción</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-6">
                            <select id="edit_estatus" class="form-select" name="estatus">
                                <option value="1">Pendiente</option>
                                <option value="2">Trámite</option>
                                <option value="3">Trámite favorable</option>
                                <option value="4">Trámite no favorable</option>
                            </select>
                            <label for="">Estatus</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-12">
                            <input type="file" class="form-control" name="url_anexo" >
                            <label for="">Anexos</label>
                        </div>
                    </div>
                    

                    <div class="d-flex mt-6 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ri-add-line"></i>Crear</button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"><i class="ri-close-line"></i> Cancelar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



 <!-- MODAL TRAZABILIDAD IMPI-->
<div class="modal fade" id="ModalTracking" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
        
        <div class="modal-body">
          <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>

          <div class="text-center mb-4 pt-5">
            <h4 class="address-title mb-2">Trazabilidad de trámite ante el IMPI</h4>
            <p class="folio badge bg-primary"></p>
          </div>

          <div class="card pl-0"> 
            <div class="card-body pb-0">
              <ul id="ListTracking" class="timeline mb-0 pb-5">
                
              </ul>
            </div>
          </div>
            
            
          <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
            {{-- <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button> --}}
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>

        </div>
    </div>
  </div>
</div>
