<div class="modal fade" id="editClientesProspectos" tabindex="-1" aria-labelledby="modalEditClientesProspectosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header bg-primary pb-4">
              <h5 id="modalEditClientesProspectosLabel" class="modal-title text-white">Editar Cliente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-8">
              <form id="editClienteForm">
                  @csrf
                  <input type="hidden" id="edit_id_cliente" name="id_cliente" value="">

                  <div class="row mb-4">
                      <div class="col-md-6 mb-4">
                          <div class="form-floating form-floating-outline">
                              <input type="text" id="edit_nombre_cliente" class="form-control" name="nombre_cliente" placeholder="Cliente" autocomplete="off">
                              <label for="edit_nombre_cliente">Nombre del cliente</label>
                          </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <select id="edit_regimen" class="form-select" name="regimen">
                              <option value="" disabled selected>Selecciona el régimen</option>
                              <option value="Persona física">Persona física</option>
                              <option value="Persona moral">Persona moral</option>
                          </select>
                          <label for="edit_regimen">Régimen</label>
                      </div>
                      </div>
                  </div>
                  <div class="row mb-4">
                      <div class="col">
                          <div class="form-floating form-floating-outline">
                              <input type="text" id="edit_domicilio_fiscal" class="form-control" name="domicilio_fiscal" placeholder="Domicilio fiscal" autocomplete="off">
                              <label for="edit_domicilio_fiscal">Domicilio fiscal</label>
                          </div>
                      </div>
                  </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button disabled class="btn btn-primary me-1 d-none" type="button" id="loading">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Actualizando...
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnEdit"><i class="ri-pencil-fill me-1"></i>
                            Editar</button>
                        <button type="reset" class="btn btn-danger " data-bs-dismiss="modal" aria-label="Close"><i
                                class="ri-close-line me-1"></i> Cancelar</button>
                    </div>

              </form>
          </div>
      </div>
  </div>
</div>
