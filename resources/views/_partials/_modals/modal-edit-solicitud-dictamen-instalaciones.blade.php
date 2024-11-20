<div class="modal fade" id="editSolicitudDictamen" tabindex="-1">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Editar solicitud de dictamen de instalaciones</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addEditSolicitud">
                  @csrf

                    <div class="row">
                        <input type="hidden" name="id_solicitud" id="edit_id_solicitud">
                        <input type="hidden" name="form_type" value="dictaminacion">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                              <select onchange="obtenerDatosEmpresaEdicion()" id="edit_id_empresa" name="id_empresa"
                              class="select2 form-select"
                              data-error-message="por favor selecciona la empresa">
                              <option value="" disabled selected>Selecciona la empresa</option>
                              @foreach ($empresas as $empresa)
                                  <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}
                                  </option>
                              @endforeach
                          </select>
                                <label for="id_empresa">Cliente</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-5">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                    id="edit_fecha_visita" name="fecha_visita" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-6 input-group ">
                                <select class=" form-select" id="edit_id_instalacion" name="id_instalacion" aria-label="id_instalacion" required>
                                    <option value="" selected>Lista de instalaciones</option>
                                    <!-- Aquí se llenarán las opciones con instalaciones del cliente -->
                                </select>

                                <button type="button" class="btn btn-primary" id="abrirModalInstalaciones"><i
                                        class="ri-add-line"></i> Agregar nueva instalación</button>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea id="edit_info_adicional" name="info_adicional" class="form-control h-px-150"
                                placeholder="Información adicional sobre la actividad..."></textarea>
                            <label for="comentarios">Información adicional sobre la actividad</label>
                        </div>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
function obtenerDatosEmpresaEdicion() {
    var empresa = $("#edit_id_empresa").val();
    console.log("select empresa seleccionado:" + empresa);

    // Verifica si el valor de empresa es válido
    if (!empresa) {
      console.log("El valor de empresa es inválido");
        return; // No hacer la petición si el valor es inválido
    }
    // Hacer una petición AJAX para obtener los detalles de la empresa
    $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function(response) {
            console.log('Datos de la respuesta:', response);  // Verifica qué datos se están recibiendo
            var $selectInstalaciones = $('#edit_id_instalacion');
            $selectInstalaciones.empty();

            if (response.instalaciones && response.instalaciones.length > 0) {
                response.instalaciones.forEach(function(instalacion) {
                    $selectInstalaciones.append(
                        `<option value="${instalacion.id_instalacion}">${instalacion.nombre_instalacion}</option>`
                    );
                });
            } else {
                $selectInstalaciones.append(
                    '<option value="" disabled selected>Sin instalaciones registradas</option>'
                );
                console.log("Sin instalaciones registradas");
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los datos de la empresa:', error);
            alert('Error al cargar los datos. Por favor, intenta nuevamente.');
        }
    });
}

// Llamar a obtenerDatosEmpresaEdicion cuando se selecciona la empresa
$('#edit_id_empresa').change(function() {
    obtenerDatosEmpresaEdicion();
});

</script>
