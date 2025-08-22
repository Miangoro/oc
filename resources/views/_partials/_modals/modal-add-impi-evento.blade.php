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
                    
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-6">
                            <input type="text" class="form-control" placeholder="Titulo"
                                name="evento" aria-label="Nombre">
                            <label for="">Titulo</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-6">
                            <textarea name="descripcion" class="form-control h-px-100" 
                                    placeholder="Descripción"></textarea>
                            <label for="">Descripción</label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-6">
                            <select id="" class="form-select" name="estatus"
                                aria-label="Default select example">
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
                            <input type="file" class="form-control" id="" placeholder="Titulo"
                                name="anexo" >
                            <label for="">Anexos</label>

                            <div id="documentoActual">sin documento</div>
                            <div id="botonEliminarDocumento" class="mt-2">botno eliminar</div>
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
