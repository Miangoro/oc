<!-- Modal para agregar nuevo lote -->
<div class="modal fade" id="offcanvasAddLote" tabindex="-1" aria-labelledby="offcanvasAddLoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="offcanvasAddLoteLabel" class="modal-title">Registro de Lote a Granel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{--  --}}
                <form id="loteForm" method="POST" action="{{ route('lotes-register.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Nombre del lote -->
                    <div class="form-section mb-4 p-3 border rounded">
                        <h6 class="mb-3">Información del Lote</h6>
                        <!-- Campo para seleccionar lote original -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="es_creado_a_partir" name="es_creado_a_partir" class="form-select">
                                        <option value=""disabled selected>¿Creado a partir de otro lote?</option>
                                        <option value="no">No</option>
                                        <option value="si">Si</option>
                                    </select>
                                    <label for="es_creado_a_partir" class="form-label">¿Creado a partir de otro
                                        lote?</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="lote_original_id" name="lote_original_id" class="form-select" disabled>
                                        <option value="" disabled selected>Seleccionar lote a granel</option>
                                        @foreach ($lotes as $lote)
                                            <option value="{{ $lote->id_lote_granel }}">{{ $lote->nombre_lote }}</option>
                                        @endforeach
                                    </select>
                                    <label for="lote_original_id" class="form-label">Lote Original</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-section mb-4 p-3 border rounded">
                        <!-- Sección para información del lote -->
                        <h6 class="mb-3">Detalles del Lote</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" id="nombre_lote" name="nombre_lote" class="form-control"
                                        autocomplete="off" placeholder="Nombre del lote"
                                        data-error-message="por favor selecciona el lote" />
                                    <label for="nombre_lote">Nombre del Lote</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select onchange="obtenerGuias()" id="id_empresa" name="id_empresa"
                                        class="select2 form-select"
                                        data-error-message="por favor selecciona la empresa">
                                        <option value="" disabled selected>Selecciona la empresa</option>
                                        @foreach ($empresas as $empresa)
                                            <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <!-- Empresa y Tipo de Lote -->
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="tipo_lote" name="tipo_lote" class=" form-select"
                                        data-error-message="Por favor selecciona el tipo de lote">
                                        <option value="" disabled selected>Selecciona el tipo de lote</option>
                                        <option value="1">Certificación por OC CIDAM</option>
                                        <option value="2">Certificado por otro organismo</option>
                                    </select>
                                    <label for="tipo_lote">Tipo de Lote</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="id_guia" name="id_guia[]" class="select2 form-select" multiple
                                        data-error-message="Por favor selecciona una guia">
                                        {{--  <option value="" disabled selected>Seleccione una guía</option> --}}
                                    </select>
                                    <label for="id_guia">Folio de guía de translado</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" step="0.01" id="volumen" name="volumen"
                                        class="form-control" placeholder="Volumen de Lote Inicial (litros)"
                                        autocomplete="off" data-error-message="Por favor selecciona el volumen" />
                                    <label for="volumen">Volumen de Lote Inicial (litros)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" step="0.01" id="cont_alc" name="cont_alc"
                                        class="form-control" placeholder="Contenido Alcohólico" autocomplete="off"
                                        data-error-message="Por favor seleccione el contenido alcoholico" />
                                    <label for="cont_alc">Contenido Alcohólico</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="id_categoria" name="id_categoria" class=" form-select">
                                        <option value="" disabled selected
                                            data-error-message="Por favor seleccione una categoria">Selecciona la
                                            categoría
                                            de agave
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
                                    <select id="clase_agave" name="id_clase" class=" form-select"
                                        data-error-message="Por favor selecciona una clase">
                                        <option value="" disabled selected>Selecciona la clase de agave
                                        </option>
                                        @foreach ($clases as $clase)
                                            <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                        @endforeach
                                    </select>
                                    <label for="clase_agave">Clase de Agave</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="tipo_agave" name="id_tipo" class="select2 form-select">
                                        <option value="" disabled selected>Selecciona el tipo de agave
                                        </option>
                                        @foreach ($tipos as $tipo)
                                            <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="tipo_agave">Tipo de Agave</label>
                                </div>
                            </div>
                        </div>

                        <!-- Campos para "Certificación por OC CIDAM" -->
                        <div id="oc_cidam_fields" class="d-none">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" id="ingredientes" name="ingredientes"
                                            class="form-control" placeholder="Ingredientes" autocomplete="off" />
                                        <label for="ingredientes">Ingredientes</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" id="edad" name="edad" class="form-control"
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
                                        <!-- Primer bloque -->
                                        <tr>
                                            <td>
                                                <input readonly value="Análisis completo" type="text"
                                                    class="form-control form-control-sm"
                                                    id="date{{ $documento->id_documento }}" name="tipo_analisis[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="date{{ $documento->id_documento }}" name="folio_fq_completo">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="file"
                                                    id="file{{ $documento->id_documento }}" name="url[]">
                                                <input value="{{ $documento->id_documento }}" class="form-control"
                                                    type="hidden" name="id_documento[]">
                                                <input value="{{ $documento->nombre }}" class="form-control"
                                                    type="hidden" name="nombre_documento[]">
                                            </td>
                                        </tr>

                                        <!-- Segundo bloque -->
                                        <tr>
                                            <td>
                                                <input readonly value="Ajuste de grado" type="text"
                                                    class="form-control form-control-sm"
                                                    id="date{{ $documento->id_documento }}" name="tipo_analisis[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="date{{ $documento->id_documento }}-2" name="folio_fq_ajuste">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="file"
                                                    id="file{{ $documento->id_documento }}-2" name="url[]">
                                                <input value="{{ $documento->id_documento }}" class="form-control"
                                                    type="hidden" name="id_documento[]">
                                                <input value="{{ $documento->nombre }}" class="form-control"
                                                    type="hidden" name="nombre_documento[]">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <!-- Campos para "Certificado por otro organismo" -->
                        <div id="otro_organismo_fields" class="d-none">
                            <div class="row">
                                <!-- Campo de archivo ocupando toda la fila -->
                                <div class="col-md-12 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control form-control-sm" type="file" id="file-59"
                                            name="url[]">
                                        <input value="59" class="form-control" type="hidden"
                                            name="id_documento[]">
                                        <input value="Certificado de lote a granel" class="form-control"
                                            type="hidden" name="nombre_documento[]">
                                        <label for="certificado_lote">Adjuntar Certificado de Lote a Granel</label>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <!-- Campos en filas de dos -->
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="folio_certificado" name="folio_certificado"
                                            class="form-control" placeholder="Folio/Número de Certificado"
                                            autocomplete="off" />
                                        <label for="folio_certificado">Folio/Número de Certificado</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <select id="id_organismo" name="id_organismo" class="select2 form-select">
                                            <option value="" disabled selected>Selecciona el organismo de
                                                certificación</option>
                                            @foreach ($organismos as $organismo)
                                                <option value="{{ $organismo->id_organismo }}">
                                                    {{ $organismo->organismo }}</option>
                                            @endforeach
                                        </select>
                                        <label for="id_organismo">Organismo de Certificación</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="fecha_emision" name="fecha_emision"
                                            autocomplete="off" class="form-control datepicker"
                                            placeholder="Fecha de Emisión" readonly />
                                        <label for="fecha_emision">Fecha de Emisión</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="fecha_vigencia" name="fecha_vigencia"
                                            autocomplete="off" class="form-control datepicker"
                                            placeholder="Fecha de Vigencia" readonly />
                                        <label for="fecha_vigencia">Fecha de Vigencia</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Botones -->
                    <div class="d-flex justify-content-center mt-3">
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
    function obtenerGuias() {
        var empresa = $("#id_empresa").val();
        // Verifica si el valor de empresa es válido
        if (!empresa) {
            /* console.error('El valor de la empresa es inválido.'); */
            return; // No hacer la petición si el valor es inválido
        }
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                // Limpiar el contenido previo del select
                var $select = $('#id_guia');
                $select.empty();

                if (response.guias.length > 0) {
                    // Recorrer las guías y añadirlas al select
                    response.guias.forEach(function(guia) {
                        $select.append(`<option value="${guia.id_guia}">${guia.folio}</option>`);
                    });
                } else {
                    // Mostrar opción "Sin guías registradas" si no hay guías
                    $select.append('<option value="" disabled selected>Sin guías registradas</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar las guías:', error);
                alert('Error al cargar las guías. Por favor, intenta nuevamente.');
            }
        });
    }
</script>
