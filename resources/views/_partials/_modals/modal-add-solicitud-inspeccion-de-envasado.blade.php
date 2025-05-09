<div class="modal fade" id="addInspeccionEnvasado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar solicitud de inspección de envasado</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addInspeccionEnvasadoForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_empresa_inspeccion"
                                    onchange="obtenerInstalacionesInspecciones(); obtenerEnvasadosInspecciones(this.value);"
                                    name="id_empresa" class="id_empresa_inspeccion select2 form-select" required>
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
                                <select class=" form-select" id="id_instalacion_inspeccion" name="id_instalacion"
                                    aria-label="id_instalacion" required>
                                    <option value="" selected>Lista de instalaciones</option>
                                </select>
                                <button type="button" class="btn btn-primary" id="modalMuestreoInspeccion"><i
                                        class="ri-add-line"></i> Agregar nueva instalación</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-4">
                            <select onchange="obtenerDatosGranelesInspecciones();" id="id_lote_envasado_inspeccion"
                                name="id_lote_envasado_inspeccion" class="select2 form-select">
                                <option value="" disabled selected>Selecciona lote envasado</option>
                            </select>
                            <label for="id_lote_envasado_inspeccion">Lote envasado</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="id_categoria_inspeccion" name="id_categoria_inspeccion" placeholder="Categoría"
                                    readonly style="pointer-events: none;" />
                                <label for="id_categoria_inspeccion">Categoría</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="id_clase_inspeccion"
                                    name="id_clase_inspeccion" placeholder="Ingresa una Clase" readonly
                                    style="pointer-events: none;" />
                                <label for="id_clase_inspeccion">Clase</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted"
                                    id="id_tipo_maguey_inspeccion" name="id_tipo_maguey_inspeccion"
                                    placeholder="Ingresa un tipo de Maguey" readonly style="pointer-events: none;" />
                                <label for="id_tipo_maguey_inspeccion">Tipo de Maguey</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="id_marca"
                                    name="id_marca" placeholder="Ingresa una Categoria" readonly
                                    style="pointer-events: none;" />
                                <label for="id_marca">Marca</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control bg-light text-muted" id="volumen_inspeccion"
                                    name="volumen_inspeccion" placeholder="Ingresa el volumen" readonly/>
                                <label for="volumen_inspeccion">%Alc. Vol.</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control bg-light text-muted" id="analisis_inspeccion"
                                    name="analisis_inspeccion" placeholder="Ingresa Análisis fisicoquímico" readonly/>
                                <label for="analisis_inspeccion">Análisis fisicoquímico</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select id="id_tipo_inspeccion" name="id_tipo_inspeccion" class="form-select">
                                    <option value="" disabled selected>Selecciona un tipo</option>
                                    <option value="Con etiqueta">Con etiqueta</option>
                                    <option value="Sin etiqueta">Sin etiqueta</option>
                                </select>
                                <label for="id_tipo_inspeccion">Tipo</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="id_cantidad_bote"
                                    name="id_cantidad_bote" placeholder="Cantidad de botellas" />
                                <label for="id_cantidad_bote">Cantidad de botellas</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="number" class="form-control" id="id_cantidad_caja"
                                    name="id_cantidad_caja" placeholder="Cantidad de cajas" />
                                <label for="id_cantidad_caja">Cantidad de cajas</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="date" class="form-control " id="id_inicio_envasado"
                                    name="id_inicio_envasado" placeholder="Inicio de envasado" />
                                <label for="id_inicio_envasado">Inicio de envasado</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="date" class="form-control " id="id_previsto" name="id_previsto"
                                    placeholder="Termino previsto del envasado" />
                                <label for="id_previsto">Término previsto del envasado</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" class="form-control" id="id_certificado_inspeccion"
                                    name="id_certificado_inspeccion"
                                    placeholder="Ingresa el Certificado de NOM a granel" />
                                <label for="id_certificado_inspeccion">Certificado de NOM a granel</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea name="info_adicional" class="form-control h-px-100" id="info_adicional" placeholder="Observaciones..."></textarea>
                            <label for="info_adicional">Información adicional sobre la actividad (NO. DE GARRAFAS Y
                                CONTENEDORES):</label>
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
    function obtenerInstalacionesInspecciones() {
        var empresa = $("#id_empresa_inspeccion").val();
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    var contenido = "";
                    for (let index = 0; index < response.instalaciones.length; index++) {
                        // Limpia el campo tipo usando la función limpiarTipo
                        var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);

                        contenido = '<option value="' + response.instalaciones[index].id_instalacion +
                            '">' +
                            tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa +
                            '</option>' +
                            contenido;
                    }
                    if (response.instalaciones.length == 0) {
                        contenido = '<option value="">Sin instalaciones registradas</option>';
                    }
                    $('#id_instalacion_inspeccion').html(contenido);
                },
                error: function() {}
            });
        }
    }

    function obtenerEnvasadosInspecciones(empresa) {
        if (empresa !== "" && empresa !== null && empresa !== undefined) {
            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    var contenido = "";
                    for (let index = 0; index < response.lotes_envasado.length; index++) {
                        contenido = '<option value="' + response.lotes_envasado[index].id_lote_envasado +
                            '">' +
                            response
                            .lotes_envasado[index].nombre + ' | GRANEL: ' + response.lotes_envasado[index].lotes_envasado_granel[0].lotes_granel[0].nombre_lote + '</option>' + contenido;
                    }
                    if (response.lotes_envasado.length == 0) {
                        contenido = '<option value="">Sin lotes registrados</option>';
                    } else {}
                    $('#id_lote_envasado_inspeccion').html(contenido);
                    obtenerDatosGranelesInspecciones();
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

    function obtenerDatosGranelesInspecciones() { 
        var lote_envasado_id = $("#id_lote_envasado_inspeccion").val();
        if (lote_envasado_id !== "" && lote_envasado_id !== null && lote_envasado_id !== undefined) { 
            
            $.ajax({
                url: '/getDatosLoteEnvasado/' + lote_envasado_id,
                method: 'GET',
                success: function(response) {
                    $('#id_categoria_inspeccion').val(response.primer_lote_granel ? response.primer_lote_granel.id_categoria :'');
                    $('#id_clase_inspeccion').val(response.primer_lote_granel ? response.primer_lote_granel.id_clase : '');
                    $('#id_tipo_maguey_inspeccion').val(response.primer_lote_granel ? response.primer_lote_granel.tipos_ids : '');
                    $('#id_marca').val(response.lotes_envasado.marca.marca || '');
                    $('#analisis_inspeccion').val(response.primer_lote_granel.folio_fq || '');
                    $('#volumen_inspeccion').val(response.primer_lote_granel.cont_alc || '');
                    $('#id_certificado_inspeccion').val(response.primer_lote_granel.folio_certificado || '');
                    $('#id_cantidad_bote').val(response.lotes_envasado.cant_botellas || '');
                    $('#id_tipo_inspeccion').val(response.lotes_envasado.tipo || '');
                    $('#id_instalacion_inspeccion').val(response.lotes_envasado.lugar_envasado || '').triger('change');
                    

                },
                error: function() {
                    console.error('Error al obtener los datos del lote granel.');
                }
            });
        }else{
            $('#id_categoria_inspeccion, #id_clase_inspeccion, #id_tipo_maguey_inspeccion, #id_marca, #analisis_inspeccion, #volumen_inspeccion, #id_certificado_inspeccion, #id_cantidad_bote, #id_tipo_inspeccion, #id_instalacion_inspeccion').val('').trigger('change');
        }
    }

    /* Limpiar campos al cerrar el modal
    $('#addInspeccionEnvasado').on('hidden.bs.modal', function() {
        $('#id_empresa_inspeccion').val('');
        $('#id_instalacion_inspeccion').html('<option value="" selected>Lista de instalaciones</option>');
        $('#fecha_visita').val('');
        $('#id_lote_granel_inspeccion').val('');
        $('#id_categoria_inspeccion').val('').prop('readonly', true);
        $('#id_clase_inspeccion').val('').prop('readonly', true);
        $('#id_tipo_maguey_inspeccion').val('').prop('readonly', true);
        $('#id_marca').val('').prop('readonly', true);
        $('#volumen_inspeccion').val('');
        $('#analisis_inspeccion').val('');
        $('#id_tipo_inspeccion').val('');
        $('#id_cantidad_bote').val('');
        $('#id_cantidad_caja').val('');
        $('#id_inicio_envasado').val('');
        $('#id_previsto').val('');
        $('#id_certificado_inspeccion').val('');
        $('#info_adicional').val('');
        var formValidator = $('#addInspeccionEnvasadoForm').validate();
        formValidator.resetForm(true);
    });*/
</script>
