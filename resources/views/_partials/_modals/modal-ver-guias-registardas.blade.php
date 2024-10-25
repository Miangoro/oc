<!-- Add New Lote Envasado Modal -->
<style>
    .modal-custom-size {
    max-width: 100%;
    width: 50%; /* Ancho por defecto para pantallas grandes */
}

/* Estilo para pantallas pequeñas (móviles) */
@media (max-width: 768px) { /* Ajusta el valor según tu diseño */
    .modal-custom-size {
        width: auto; /* Ancho automático para dispositivos móviles */
    }
}

</style>
<div class="modal fade" id="verGuiasRegistardas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Guias de traslado</h4>
                    <p class="address-subtitle"></p>
                </div>
                
                <form id="verGuiasRegistardasForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <a href="#" id="descargarPdfBtn" class="btn btn-primary position-absolute waves-effect" style="top: 0; right: 0; margin: 15px;">Descargar PDF</a>
{{--                     <iframe src="" id="pdfViewerGuias" width="100%" height="800px" style="border: none;"></iframe>
 --}}                    <div class="row">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>folio</th>
                                  <th>Guia</th>


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

