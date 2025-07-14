<!-- Offcanvas para agregar nueva clase -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddFirma" aria-labelledby="offcanvasAddFirmaLabel">
    <div class="offcanvas-header border-bottom bg-primary mb-2">
        <h5 class="offcanvas-title text-white">Firmar bitácora</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 h-100">
        <form class="add-new-user pt-0" id="addFirma">
            @csrf
            <input type="hidden" id="bitacora_id_firma">
            <div class="form-floating form-floating-outline mb-6">
                <label for="smallSelect" class="form-label"> Persona que firmará</label>
                <select  class="form-select select2" name="PersonaFirmante">
                    <option disabled selected value="">Selecciona la persona</option>
                </select>
            </div>
            <div class="form-floating form-floating-outline mb-6">
                <input class="form-control" type="password" placeholder="password" name="password" />
                <label for="html5-password-input">Password</label>
            </div>
            <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                <button disabled class="btn btn-primary me-1 d-none" type="button" id="btnSpinner">
                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                    Registrando...
                </button>
                <button type="submit" class="btn btn-primary me-sm-3 data-submit"><i
                        class="ri-add-line me-1"></i>Registrar</button>
                <button type="reset" class="btn btn-danger" data-bs-dismiss="offcanvas"><i
                        class="ri-close-line me-1"></i>Cancelar</button>
            </div>

        </form>
    </div>
</div>
