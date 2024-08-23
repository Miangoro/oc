        <!-- Modal para agregar nuevo predio -->
        <div class="modal fade" id="modalAddDestino" tabindex="-1" aria-labelledby="modalAddDestinoLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modalAddDestinoLabel" class="modal-title">Nueva direccion de destino</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addNewDestinoForm" method="POST">
                            @csrf
                            <!-- Tipo de Dirección -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select id="tipo_direccion" name="tipo_direccion" class="form-select"
                                            onchange="handleDireccionChange()">
                                            <option value="" disabled selected>Selecciona el tipo de dirección
                                            </option>
                                            <option value="1">Para exportación</option>
                                            <option value="2">Para venta nacional</option>
                                            <option value="3">Para envío de hologramas</option>
                                        </select>
                                        <label for="tipo_direccion">Tipo de Dirección</label>
                                    </div>
                                </div>

                                <!-- Select de Empresa Cliente -->
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select id="id_empresa" name="id_empresa" class="select2 form-select">
                                            <option value="" disabled selected>Selecciona la empresa cliente
                                            </option>
                                            @foreach ($empresas as $empresa)
                                                @if ($empresa->tipo == 2)
                                                    <option value="{{ $empresa->id_empresa }}">
                                                        {{ $empresa->razon_social }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <label for="id_empresa">Empresa Cliente</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Domicilio Completo -->
                            <div class="form-floating form-floating-outline mb-4">
                                <textarea class="form-control" id="direccion" name="direccion" placeholder="Domicilio completo"></textarea>
                                <label for="direccion">Domicilio Completo</label>
                            </div>
                            <!-- Campos adicionales para exportación -->
                            <div id="exportacionFields" style="display: none;">
                                <div class="row mb-4">
                                    <!-- Nombre del Destinatario -->
                                    <div class="col-md-12">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="destinatario"
                                                name="destinatario" placeholder="Nombre del destinatario">
                                            <label for="destinatario">Nombre del Destinatario</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <!-- Aduana de Despacho -->
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="aduana" name="aduana"
                                                placeholder="Aduana de despacho">
                                            <label for="aduana">Aduana de Despacho</label>
                                        </div>
                                    </div>
                                    <!-- País de Destino -->
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="pais_destino"
                                                name="pais_destino" placeholder="País de destino">
                                            <label for="pais_destino">País de Destino</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Campos adicionales para envío de hologramas -->
                            <div id="hologramasFields" style="display: none;">
                                <div class="row mb-4">

                                    <!-- Correo -->
                                    <div class="col-md-12">
                                        <div class="form-floating form-floating-outline">
                                            <input type="email" class="form-control" id="correo_recibe"
                                                name="correo_recibe" placeholder="Correo electrónico">
                                            <label for="correo_recibe">Correo Electrónico</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <!-- Nombre Completo del Recibe Hologramas -->
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="nombre_recibe"
                                                name="nombre_recibe"
                                                placeholder="Nombre completo del receptor de hologramas">
                                            <label for="nombre_recibe">Nombre Completo del Recibe Hologramas</label>
                                        </div>
                                    </div><!-- Celular -->
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="tel" class="form-control" id="celular_recibe"
                                                name="celular_recibe" placeholder="Número de teléfono ">
                                            <label for="celular_recibe">Celular</label>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary me-2">Registrar</button>
                                <button type="reset" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
function handleDireccionChange() {
    var tipoDireccion = document.getElementById('tipo_direccion').value;
    var exportacionFields = document.getElementById('exportacionFields');
    var hologramasFields = document.getElementById('hologramasFields');

    // Ocultar ambos conjuntos de campos por defecto
    exportacionFields.style.display = 'none';
    hologramasFields.style.display = 'none';

    // Mostrar los campos según el tipo de dirección seleccionado
    if (tipoDireccion === '1') { // Exportación
        exportacionFields.style.display = 'block';
        hologramasFields.style.display = 'none';
        updateValidation(['destinatario', 'aduana', 'pais_destino']);
    } else if (tipoDireccion === '3') { // Envío de hologramas
        hologramasFields.style.display = 'block';
        exportacionFields.style.display = 'none';
        updateValidation(['correo_recibe', 'nombre_recibe', 'celular_recibe']);
    } else if (tipoDireccion === '2') { // Venta Nacional
        exportacionFields.style.display = 'none';
        hologramasFields.style.display = 'none';
        updateValidation([]);
    }
}

function updateValidation(fieldsToValidate) {
    const allFields = ['destinatario', 'aduana', 'pais_destino', 'correo_recibe', 'nombre_recibe', 'celular_recibe'];
    const fieldsToRemove = allFields.filter(field => !fieldsToValidate.includes(field));
    
    fieldsToValidate.forEach(field => fv.addField(field));
    fieldsToRemove.forEach(field => fv.removeField(field));
}

        </script>
