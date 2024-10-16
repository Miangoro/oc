<!-- Edit Lote Envasado Modal -->
<div class="modal fade" id="reclasificacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-edit-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2"> Reclasificacion</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="reclasificacionForm">

                    <input type="hidden" id="edit_id_lote_envasado" name="id">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="edit_obtenerDirecciones(); edit_obtenerMarcas(); edit_obtenerGraneles();"
                                    id="edit_cliente" name="id_empresa" class="select2 form-select" required>
                                    <option value="">Selecciona cliente</option>

                                </select>
                                <label for="edit_cliente">Cliente</label>
                            </div>
                        </div>

                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><button type="button" class="btn btn-primary add-row-edit"> <i class="ri-add-line"></i> </button></th>
                                    <th>Lote a granel</th>
                                    <th>Volumen parcial</th>
                                </tr>
                            </thead>
                            <tbody id="edit_contenidoGraneles">
                                <tr>
                                    <th>
                                        <button type="button" class="btn btn-danger remove-row" > <i class="ri-delete-bin-5-fill"></i> </button>
                                    </th>
                                    <td>
                                        <select class="edit_lote_granel form-control select2" name="id_lote_granel[]" id="id_lote_granel" >
                                            <!-- Opciones -->
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="volumen_parcial[]">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        


                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
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
