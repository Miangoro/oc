<!-- Add New Lote Envasado Modal -->
<style>
    .modal-custom-size {
        max-width:100%;
        /* Ajusta este valor para hacerlo más grande */
        width: auto%;
        /* Ajusta según tus necesidades */
    }
</style>
<div class="modal fade" id="verGuiasRegistardas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Hologramas Activos</h4>
                    <p class="address-subtitle"></p>
                </div>
                
                <form id="verGuiasRegistardasForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <div class="row">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>id</th>
                                  <th>Plantacion</th>
                                  <th>runfoio</th>
                                  <th>folio</th>
                                  <th>empresa</th>
                                  <th>predio</th>
                                  <th>numo plantas</th>
                                  <th>num guias</th>
                                  <th>num anterior</th>
                                  <th>numo comercializadas</th>
                                  <th>mermas</th>

                                </tr>
                              </thead>
                              <tbody id="tablita">
                              </tbody>
                            </table>
                          </div>

                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

