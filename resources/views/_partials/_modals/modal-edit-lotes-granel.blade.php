<!-- Modal para editar un lote -->
<div class="modal fade" id="offcanvasEditLote" tabindex="-1" aria-labelledby="offcanvasEditLoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="offcanvasEditLoteLabel" class="modal-title">Editar el Lote a Granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="loteFormEdit">
                    @csrf
                    <input type="hidden" id="edit_lote_id" name="edit_lote_id">
                    <!-- Resto del formulario -->
                    <div class="section">
                        <h6>Datos Básicos</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="edit_nombre_lote" name="nombre_lote" class="form-control"
                                        placeholder="Nombre del lote" autocomplete="off" />
                                    <label for="edit_nombre_lote">Nombre del Lote</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select onchange="obtenerGuias1()" id="edit_id_empresa" name="id_empresa"
                                        class="select2 form-select">
                                        <option value="" disabled selected>Selecciona la empresa</option>
                                        @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="id_empresa">Empresa</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="edit_tipo_lote" name="tipo_lote" class="form-select">
                                        <option value="" disabled selected>Selecciona el tipo de lote</option>
                                        <option value="1">Certificación por OC CIDAM</option>
                                        <option value="2">Certificado por otro organismo</option>
                                    </select>
                                    <label for="tipo_lote">Tipo de Lote</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Información Adicional -->
                    <div class="section">
                        <h6>Información Adicional</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="edit_id_guia" name="id_guia[]" class="select2 form-select" multiple>
                                        {{--  <option value="" disabled selected>Seleccione una guía</option> --}}
                                        @foreach ($guias as $guia)
                                            <option value="{{ $guia->id_guia }}">{{ $guia->Folio }}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_guia">Folio de guía de translado</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" step="0.01" id="edit_volumen" name="volumen"
                                        class="form-control" placeholder="Volumen de Lote Inicial (litros)"
                                        autocomplete="off" />
                                    <label for="volumen">Volumen de Lote Inicial (litros)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" step="0.01" id="edit_cont_alc" name="cont_alc"
                                        class="form-control" placeholder="Contenido Alcohólico" autocomplete="off" />
                                    <label for="cont_alc">Contenido Alcohólico</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="edit_id_categoria" name="id_categoria" class="form-select">
                                        <option value="" disabled selected>Selecciona la categoría de agave
                                        </option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id_categoria }}">
                                                {{ $categoria->categoria }}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_categoria">Categoría de Agave</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="edit_clase_agave" name="id_clase" class="form-select">
                                        <option value="" disabled selected>Selecciona la clase de agave</option>
                                        @foreach ($clases as $clase)
                                            <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                        @endforeach
                                    </select>
                                    <label for="clase_agave">Clase de Agave</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="edit_tipo_agave" name="id_tipo" class="select2 form-select">
                                        <option value="" disabled selected>Selecciona el tipo de agave</option>
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="tipo_agave">Tipo de Agave</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campos Condicionales -->
                    <div id="edit_oc_cidam_fields" class="section d-none">
                        <h6>Certificación por OC CIDAM</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="edit_ingredientes" name="ingredientes"
                                        class="form-control" placeholder="Ingredientes" autocomplete="off" />
                                    <label for="ngredientes">Ingredientes</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="edit_edad" name="edad" class="form-control"
                                        placeholder="Edad" autocomplete="off" />
                                    <label for="edad">Edad</label>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tipo de análisis</th>
                                    <th>No. de Análisis Fisicoquímico</th>
                                    <th>Documento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documentos as $documento)
                                    <!-- Primer bloque para Análisis completo -->
                                    <tr id="documento-row-{{ $documento->id_documento }}">
                                        <td>
                                            <input readonly value="Análisis completo" type="text"
                                                class="form-control form-control-sm"
                                                id="tipo_analisis_{{ $documento->id_documento }}"
                                                name="tipo_analisis[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                id="folio_fq_completo_{{ $documento->id_documento }}"
                                                name="folio_fq_completo"
                                                value="{{ $documento->folio_fq_completo ?? '' }}">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="file"
                                                id="file_completo_{{ $documento->id_documento }}" name="url[]">
                                            <input value="{{ $documento->id_documento }}" class="form-control"
                                                type="hidden" name="id_documento[]">
                                            <input value="{{ $documento->nombre }}" class="form-control"
                                                type="hidden" name="nombre_documento[]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"
                                            id="archivo_url_display_completo_{{ $documento->id_documento }}">
                                            <!-- La URL del documento completo se mostrará aquí -->
                                        </td>
                                    </tr>

                                    <!-- Segundo bloque para Ajuste de grado -->
                                    <tr id="documento-row-{{ $documento->id_documento }}-2">
                                        <td>
                                            <input readonly value="Ajuste de grado" type="text"
                                                class="form-control form-control-sm"
                                                id="tipo_analisis_{{ $documento->id_documento }}-2"
                                                name="tipo_analisis[]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"
                                                id="folio_fq_ajuste_{{ $documento->id_documento }}"
                                                name="folio_fq_ajuste"
                                                value="{{ $documento->folio_fq_ajuste ?? '' }}">
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm" type="file"
                                                id="file_ajuste_{{ $documento->id_documento }}" name="url[]">
                                            <input value="{{ $documento->id_documento }}" class="form-control"
                                                type="hidden" name="id_documento[]">
                                            <input value="{{ $documento->nombre }}" class="form-control"
                                                type="hidden" name="nombre_documento[]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"
                                            id="archivo_url_display_ajuste_{{ $documento->id_documento }}">
                                            <!-- La URL del documento de ajuste se mostrará aquí -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>




                    </div>

                    <div id="edit_otro_organismo_fields" class="section d-none">
                        <h6>Certificado por otro organismo</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="file" id="edit_certificado_lote" name="url[]"
                                        class="form-control" />
                                    <label for="certificado_lote">Adjuntar certificado de lote a granel</label>
                                </div>
                                <div id="archivo_url_display_otro_organismo" class="mb-4"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="edit_folio_certificado" name="folio_certificado"
                                        class="form-control" placeholder="Folio/Número de Certificado"
                                        autocomplete="off" />
                                    <label for="folio_certificado">Folio/Número de Certificado</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="edit_organismo_certificacion" name="id_organismo"
                                        class=" form-select">
                                        <option value="" disabled selected>Selecciona el organismo de
                                            certificación</option>
                                        @foreach ($organismos as $organismo)
                                            <option value="{{ $organismo->id }}">{{ $organismo->organismo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="organismo_certificacion">Organismo de Certificación</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="edit_fecha_emision" name="fecha_emision"
                                        class="form-control datepicker" autocomplete="off" />
                                    <label for="echa_emision">Fecha de Emisión</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="edit_fecha_vigencia" name="fecha_vigencia"
                                        class="form-control datepicker" autocomplete="off" />
                                    <label for="fecha_vigencia">Fecha de Vigencia</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                        <button type="reset" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function obtenerGuias1() {
        var empresa = $("#edit_id_empresa").val();
        // Verifica si el valor de empresa es válido
        if (!empresa) {
            return; // No hacer la petición si el valor es inválido
        }

        // Guardar los valores seleccionados previamente
        var selectedValues = $('#edit_id_guia').val();

        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                var $select = $('#edit_id_guia');

                // Limpiar completamente el select antes de agregar las nuevas opciones
                $select.empty();

                if (response.guias.length > 0) {
                    // Añadir nuevas opciones con las guías obtenidas
                    response.guias.forEach(function(guia) {
                        $select.append(new Option(guia.folio, guia.id_guia, false, selectedValues &&
                            selectedValues.includes(guia.id_guia.toString())));
                    });

                    // Restaurar los valores seleccionados previamente si siguen siendo válidos
                    if (selectedValues) {
                        var validSelectedValues = selectedValues.filter(function(value) {
                            return response.guias.some(function(guia) {
                                return guia.id_guia == value;
                            });
                        });

                        if (validSelectedValues.length > 0) {
                            $select.val(validSelectedValues).trigger('change');
                        }
                    }
                } else {
                    // Mostrar opción "Sin guías registradas" si no hay guías
                    $select.append('<option value="" disabled selected>Sin guías registradas</option>');
                }

                // Asegurarse de que select2 esté inicializado
                if (!$select.hasClass('select2-hidden-accessible')) {
                    $select.select2(); // Re-inicializar Select2 si no está inicializado
                } else {
                    $select.trigger('change'); // Forzar el cambio si ya está inicializado
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar las guías:', error);
                alert('Error al cargar las guías. Por favor, intenta nuevamente.');
            }
        });
    }
</script>