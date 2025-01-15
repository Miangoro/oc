<div class="modal fade" id="addInspeccionIngresoBarricada" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar inspección ingreso a barrica/ contenedor de vidrio</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addInspeccionIngresoBarricadaForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_empresa_barricada"
                                    onchange="obtenerInstalacionesBarricada(); obtenerGranelesBarricada(this.value);"
                                    name="id_empresa" class="id_empresa_barricada select2 form-select" required>
                                    <option value="" disabled selected>Selecciona cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">
                                            {{ $empresa->empresaNumClientes[0]->numero_cliente ?? $empresa->empresaNumClientes[1]->numero_cliente }}
                                            | {{ $empresa->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                    id="fecha_visita" name="fecha_visita" />
                                <label for="fecha_visita">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6 input-group ">
                                <select class=" form-select" id="id_instalacion_barricada" name="id_instalacion"
                                    aria-label="id_instalacion" required>
                                    <option value="" selected>Lista de instalaciones</option>
                                </select>
                                <button type="button" class="btn btn-primary" id="modalVigilanciaBarricada"><i
                                        class="ri-add-line"></i> Agregar nueva instalación</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="obtenerDatosGranelesBarricada();" id="id_lote_granel_barricada"
                                    name="id_lote_granel_barricada" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona lote a granel</option>
                                </select>
                                <label for="id_lote_granel_barricada">Lote a granel</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="volumen_ingresado"
                                    name="volumen_ingresado" placeholder="Volumen ingresado" />
                                <label for="Volumen ingresado">Volumen ingresado</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="id_categoria_barricada" name="id_categoria_barricada"
                                    placeholder="Ingresa una Categoria" readonly style="pointer-events: none;" />
                                <label for="id_categoria_barricada">Categoría de mezcal</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="id_clase_barricada"
                                    name="id_clase_barricada" placeholder="Ingresa una Clase" readonly
                                    style="pointer-events: none;" />
                                <label for="id_clase_barricada">Clase</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="id_tipo_maguey_barricada"
                                    name="id_tipo_maguey_barricada" placeholder="Ingresa un tipo de Maguey" readonly
                                    style="pointer-events: none;" />
                                <label for="id_tipo_maguey_barricada">Tipo de Maguey</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="id_certificado_barricada"
                                    name="id_certificado_barricada" placeholder="Certificado de NOM a granel" />
                                <label for="id_certificado_barricada">Certificado de NOM a granel </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="analisis_barricada"
                                    name="analisis_barricada" placeholder="Ingresa Análisis fisicoquímico" />
                                <label for="analisis_barricada">Análisis fisicoquímico</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="alc_vol_barrica"
                                    name="alc_vol_barrica" placeholder="Ingresa el volumen" />
                                <label for="alc_vol_barrica">%Alc. Vol.</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="tipo_lote" name="tipo_lote" class="form-select">
                                    <option value="" disabled selected>Selecciona un tipo</option>
                                    <option value="Ingreso de producto en barrica">Ingreso de producto en barrica</option>
                                    <option value="Ingreso de producto en contenedor de vidrio">Ingreso de producto en contenedor de vidrio</option>
                                </select>
                                <label for="tipo_lote">Tipo</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control datepicker" type="date"
                                    id="fecha_inicio" name="fecha_inicio" readonly />
                                <label for="fecha_inicio">Fecha de inicio del ingreso</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control datepicker" type="date"
                                    id="fecha_termino" name="fecha_termino" readonly />
                                <label for="fecha_termino">Fecha de término del ingreso
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="material" name="material"
                                    placeholder="Material de los recipientes" />
                                <label for="material">Material de los recipientes</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="capacidad" name="capacidad"
                                    placeholder="Capacidad de recipientes" />
                                <label for="capacidad">Capacidad de recipientes</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="num_recipientes"
                                    name="num_recipientes" placeholder="Número de recipientes" />
                                <label for="num_recipientes">Número de recipientes</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-100" id="info_adicional" placeholder="Observaciones..."></textarea>
                            <label for="info_adicional">Información adicional sobre la actividad:</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary btnCancelar" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function obtenerInstalacionesBarricada() {
        var empresa = $("#id_empresa_barricada").val();
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    var contenido = "";
                    for (let index = 0; index < response.instalaciones.length; index++) {
                        var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);
                        contenido = '<option value="' + response.instalaciones[index].id_instalacion + '">' +
                            tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                            '</option>' +
                            contenido;
                    }
                    if (response.instalaciones.length == 0) {
                        contenido = '<option value="">Sin instalaciones registradas</option>';
                    }
                    $('#id_instalacion_barricada').html(contenido);
                },
                error: function() {}
            });
        }
    }

    function obtenerGranelesBarricada(empresa) {
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    var contenido = "";
                    for (let index = 0; index < response.lotes_granel.length; index++) {
                        contenido = '<option value="' + response.lotes_granel[index].id_lote_granel + '">' +
                            response
                            .lotes_granel[index].nombre_lote + '</option>' + contenido;
                    }
                    if (response.lotes_granel.length == 0) {
                        contenido = '<option value="">Sin lotes registrados</option>';
                    } else {}
                    $('#id_lote_granel_barricada').html(contenido);
                    obtenerDatosGranelesBarricada();
                },
                error: function() {}
            });
        }
    }

    function limpiarTipo(tipo) {
        try {
            return JSON.parse(tipo).join(', ');
        } catch (e) {
            return tipo;
        }
    }

    function obtenerDatosGranelesBarricada() {
        var lote_granel_id = $("#id_lote_granel_barricada").val();
        if (lote_granel_id !== "" && lote_granel_id !== null && lote_granel_id !== undefined) {
            $.ajax({
                url: '/getDatos2/' + lote_granel_id,
                method: 'GET',
                success: function(response) {
                    $('#id_categoria_barricada').val(response.categoria ? response.categoria.categoria : '');
                    $('#id_clase_barricada').val(response.clase ? response.clase.clase : '');
                    if (response.tipo && response.tipo.length > 0) {
                        var tiposConcatenados = response.tipo.map(function(tipo) {
                            return tipo.nombre + ' (' + tipo.cientifico + ')';
                        }).join(', '); // Unir con coma
                        $('#id_tipo_maguey_barricada').val(tiposConcatenados);
                    } else {
                        $('#id_tipo_maguey_barricada').val('');
                    }
                    $('#id_edad').val(response.lotes_granel.edad);
                    $('#analisis_barricada').val(response.lotes_granel.folio_fq);
                    $('#alc_vol_barrica').val(response.lotes_granel.cont_alc);
                    $('#volumen_ingresado').val(response.lotes_granel.volumen_restante);
                },
                error: function() {
                    console.error('Error al obtener los datos del lote granel.');
                }
            });
        }
    }

    // Limpiar campos al cerrar el modal de Inspección Ingreso Barricada
    $('#addInspeccionIngresoBarricada').on('hidden.bs.modal', function() {
        $('#id_empresa_barricada').val('');
        $('#id_instalacion_barricada').html(
            '<option value="" selected>Lista de instalaciones</option>');
        $('#id_lote_granel_barricada').val('');
        $('#id_categoria_barricada').val('');
        $('#id_clase_barricada').val('');
        $('#id_edad').val('');
        $('#id_tipo_maguey_barricada').val('');
        $('#analisis_barricada').val('');
        $('#alc_vol_barrica').val('');
        $('#tipo_lote').val('');
        $('#fecha_inicio').val('');
        $('#fecha_termino').val('');
        $('#material').val('');
        $('#capacidad').val('');
        $('#num_recipientes').val('');
        $('#tiempo_dura').val('');
        $('#id_certificado_barricada').val('');
        $('#info_adicional').val('');
        formValidator.resetForm(true);
    });
</script>
