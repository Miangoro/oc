<style>
    .modal-custom-size {
        max-width: 100%;
        width: 50%;
    }

    /* Estilo para pantallas pequeñas (móviles) */
    @media (max-width: 768px) {
        .modal-custom-size {
            width: auto;
        }
    }
</style>


<div class="modal fade" id="verGuiasRegistardas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header bg-primary pb-4">
            <h5 class="modal-title text-white">Guías de traslado</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <p class="address-subtitle"></p>
        </div>

            <div class="modal-body">
                <form id="verGuiasRegistardasForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <div class="d-flex justify-content-center mb-3">
                        <a href="#" id="descargarPdfBtn" class="btn btn-primary waves-effect">Descargar PDFs</a>
                    </div>
                    
                        <div class="table-responsive px-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>folio</th>
                                        <th>Guía</th>
                                        {{-- <th>Acciones</th> --}}
                                    </tr>
                                </thead>
                                <tbody id="tablita">
                                </tbody>
                            </table>
                        </div>


                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="reset" class="btn btn-secondary waves-effect waves-light" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
