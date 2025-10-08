<!-- Modal para agregar nuevo cliente -->
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
                    <!-- Sección de Datos Generales -->
                    <!-- Sección de Datos Generales -->
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
                         <!-- Campo de Representante Legal (Oculto por defecto) -->
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


                    <!-- Botones -->
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary me-2"> <i
                                class="ri-add-line me-1"></i>Registrar Cliente</button>
                        <button type="reset" class="btn btn-danger"
                            data-bs-dismiss="modal"> <i class="ri-close-line me-1"></i>Cancelar</button>
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

{{--

<hr class="my-4">

                    <!-- Sección de Documentación General -->
                    <h6 class="mb-3">Documentación General</h6>
                    <div class="row">
                        <!-- Columna 1 de Documentos -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="doc_acta_constitutiva" class="form-label">1. Acta constitutiva (Copia simple)</label>
                                <input class="form-control" type="file" id="doc_acta_constitutiva" name="doc_acta_constitutiva">
                            </div>
                            <div class="mb-3">
                                <label for="doc_poder_notarial" class="form-label">2. Poder notarial del representante legal</label>
                                <input class="form-control" type="file" id="doc_poder_notarial" name="doc_poder_notarial">
                            </div>
                            <div class="mb-3">
                                <label for="doc_identificacion_oficial" class="form-label">3. Copia de identificacion oficial del Titular o Representante</label>
                                <input class="form-control" type="file" id="doc_identificacion_oficial" name="doc_identificacion_oficial">
                            </div>
                             <div class="mb-3">
                                <label for="doc_domicilio_fiscal" class="form-label">4. Comprobante del domicilio fiscal</label>
                                <input class="form-control" type="file" id="doc_domicilio_fiscal" name="doc_domicilio_fiscal">
                            </div>
                             <div class="mb-3">
                                <label for="doc_contrato_servicios" class="form-label">5. Contrato de prestación de servicios</label>
                                <input class="form-control" type="file" id="doc_contrato_servicios" name="doc_contrato_servicios">
                            </div>
                            <div class="mb-3">
                                <label for="doc_carta_designacion" class="form-label">6. Carta de designación de persona autorizada</label>
                                <input class="form-control" type="file" id="doc_carta_designacion" name="doc_carta_designacion">
                            </div>
                        </div>
                        <!-- Columna 2 de Documentos -->
                        <div class="col-md-6">
                           <div class="mb-3">
                                <label for="doc_situacion_fiscal" class="form-label">7. Constancia de situación fiscal</label>
                                <input class="form-control" type="file" id="doc_situacion_fiscal" name="doc_situacion_fiscal">
                            </div>
                            <div class="mb-3">
                                <label for="doc_asignacion_cliente" class="form-label">8. Carta de asignación de número de cliente</label>
                                <input class="form-control" type="file" id="doc_asignacion_cliente" name="doc_asignacion_cliente">
                            </div>
                             <div class="mb-3">
                                <label for="doc_solicitud_informacion" class="form-label">9. Solicitud de información al cliente</label>
                                <input class="form-control" type="file" id="doc_solicitud_informacion" name="doc_solicitud_informacion">
                            </div>
                             <div class="mb-3">
                                <label for="doc_identificacion_autorizada" class="form-label">10. Copia de identificación oficial vigente de la persona autorizada</label>
                                <input class="form-control" type="file" id="doc_identificacion_autorizada" name="doc_identificacion_autorizada">
                            </div>
                             <div class="mb-3">
                                <label for="doc_convenio_corresponsabilidad" class="form-label">11. Convenio de corresponsabilidad inscrito ante el IMPI</label>
                                <input class="form-control" type="file" id="doc_convenio_corresponsabilidad" name="doc_convenio_corresponsabilidad">
                            </div>
                             <div class="mb-3">
                                <label for="doc_requisitos_nom" class="form-label">12. Requisitos a evaluar NOM-070-SCFI-2016</label>
                                <input class="form-control" type="file" id="doc_requisitos_nom" name="doc_requisitos_nom">
                            </div>
                        </div>
                    </div>
                    --}}
