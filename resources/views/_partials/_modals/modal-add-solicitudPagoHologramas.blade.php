<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addPago" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Subir comprobante de pago</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addPagoForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <input type="hidden" id="pago_id_solicitud" name="id_solicitud">                   
                    <input type="hidden" id="empresa" name="empresa">
           
                    @csrf
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-4">
                            <select id="tipo_pago" name="tipo_pago" class="form-select" required>
                                <option value="1">Pago parcial</option>
                                <option value="2">Pago completo</option>
                            </select>
                            <label for="tipo_pago">Tipo de pago</label>
                        </div>
                    </div>
 
                    <div class="form-floating form-floating-outline mb-5">
                        <input class="form-control form-control-sm" type="file" name="url[]">
                        <input value="51" class="form-control" type="hidden" name="id_documento[]">
                        <input value="Comprobante de pago" class="form-control" type="hidden"
                            name="nombre_documento[]">
                        <label for="Comprobante de pago">Adjuntar Comprobante de Pago</label>
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




<script>
    
</script>
