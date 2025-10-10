<div class="modal fade" id="AddClientesConfirmados" tabindex="-1" aria-labelledby="AddClientesConfirmadosLabel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary pb-2">
                <h5 class="modal-title text-white" id="AddClientesConfirmadosLabel">Registro de Clientes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ClientesConfirmadosForm">
                    @csrf
                    <h6 class="mb-3">Datos Generales</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="tipo_persona" name="regimen" class="form-select" required>
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    <option value="Persona física">Persona Física</option>
                                    <option value="Persona moral">Persona Moral</option>
                                </select>
                                <label for="tipo_persona">Tipo de persona</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="nombre_razon_social" name="razon_social" class="form-control" placeholder="Nombre o Razón Social" required />
                                <label for="nombre_razon_social">Nombre / Razón Social</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="email" id="correo" name="correo" class="form-control" placeholder="ejemplo@correo.com" required />
                                <label for="correo">Correo electrónico</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="123 456 7890" required />
                                <label for="telefono">Teléfono</label>
                            </div>
                        </div>
                        <div id="campo_representante_legal" class="col-md-4" style="display: none;">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="representante_legal" name="representante_legal" class="form-control" placeholder="Nombre del representante" />
                                <label for="representante_legal">Representante Legal</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" id="domicilio_fiscal" name="domicilio_fiscal" class="form-control" placeholder="Ingresa el domicilio fiscal completo" />
                                <label for="domicilio_fiscal">Domicilio Fiscal</label>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="mb-3 mt-4">Seguimiento y Estatus</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="estado_pago" name="seguimiento[estado_pago]" class="form-select">
                                    <option value="" disabled selected>Selecciona un estatus</option>
                                    <option value="1">Pagado</option>
                                    <option value="0">No Pagado</option>
                                </select>
                                <label for="estado_pago">Comprobante de Pago</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="visita_dictaminacion" name="seguimiento[visita_dictaminacion]" class="form-select">
                                    <option value="" disabled selected>Selecciona un estatus</option>
                                    <option value="pendiente">Pendiente de agendar</option>
                                    <option value="agendada">Agendada</option>
                                  {{--   <option value="realizada">Realizada</option> --}}
                                </select>
                                <label for="visita_dictaminacion">Visita de Dictaminación</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="ri-add-line me-1"></i>Registrar Cliente
                        </button>
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i>Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script para mostrar/ocultar el campo de representante legal
    document.addEventListener('DOMContentLoaded', function() {
        const tipoPersonaSelect = document.getElementById('tipo_persona');
        const representanteCampo = document.getElementById('campo_representante_legal');

        if (tipoPersonaSelect) {
            tipoPersonaSelect.addEventListener('change', function() {
                if (this.value === 'Persona moral') {
                    representanteCampo.style.display = 'block';
                } else {
                    representanteCampo.style.display = 'none';
                }
            });
        }
    });
</script>
