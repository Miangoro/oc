<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addEnvio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Enviar</h4>

                    <p class="address-subtitle"><b style="color: red">Nota: </b>Se tiene que comprobar, por parte del
                        personal
                        de la OC, que los hologramas han sido enviados y poner la fecha correcta de envío. </b></p>
                </div>
            </div>
            <form id="addEnvioForm" >

                @csrf
                <div class="row">
                    <div class="col-md-6 mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="fecha_envio" name="fecha_envio"
                                aria-label="Fecha de Emisión">
                            <label for="fecha_envio">Fecha de Envio</label>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                            <input class="form-control" type="text" step="0.01" placeholder="Costo de envio"
                                id="no_guia" name="no_guia" />
                            <label for="no_guia">Costo de envío</label>
                        </div>
                    </div>

                </div>

                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" class="form-control" id="folio" name="folio"
                        placeholder="Ingresa el folio de solicitud" aria-label="Ingrese el folio" required />
                    <label for="folio">No. De guía</label>
                </div>

                <div class="form-floating form-floating-outline mb-5">
                    <input class="form-control form-control-sm" type="file" name="url[]">
                    <input value="52" class="form-control" type="hidden" name="id_documento[]">
                    <input value="Documento de No. de guía" class="form-control" type="hidden" name="nombre_documento[]">
                    <label for="Documento de No. de guía">Adjuntar Comprobante de Pago</label>
                </div>

                <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Cancelar</button>
                </div>
            </form>

        </div>
    </div>
</div>
</div>




<script></script>