<!-- Add New Lote Envasado Modal -->
<style>
    .modal-custom-size {
        max-width: 90%;
        /* Ajusta este valor para hacerlo más grande */
        width: 90%;
        /* Ajusta según tus necesidades */
    }
</style>
<div class="modal fade" id="activosHologramas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Hologramas Activos</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="activosHologramasForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <div class="row">
                        
                   

                        <table class="table table-bordered">
                            <thead>
                                <tr>
    
                                        <th>id</th>
                                        <th>id_inspeccion</th>
                                        <th>Numero lote agranel</th>
                                        <th>Categorria</th>
                                        <th>Análisis de laboratorio</th>
                                        <th>Contenido neto</th>
                                        <th>Unidad</th>
                                        <th>Clase</th>
                                        <th>Contenido Alcohólico</th>
                                        <th>No. de lote de envasado</th>
                                        <th>Categoría</th>
                                        <th>Lugar de producción</th>
                                        <th>Lugar de envasado</th>
                                    <th>Rango inicial</th>
                                    <th>Rango final</th>
                                </tr>
                            </thead>
                            <tbody id="tablita">
                            </tbody>
                        </table>




                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

