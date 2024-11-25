<!-- Add New Lote Envasado Modal -->
<style>
  #caracteristicas_Ex .btn-danger {
  position: absolute;
  top: 10px;
  right: 15px;
  z-index: 1;
}


</style>

<div class="modal fade" id="addPedidoExportacion" tabindex="-1">
  <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
      <div class="modal-content">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="modal-body p-0">
              <div class="text-center mb-6">
                  <h4 class="address-title mb-2">Pedidos para exportación</h4>
                  <p class="address-subtitle"></p>
              </div>
              <form id="addPedidoExportacionForm">
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline mb-6">
                          <select id="tipo_solicitud" class="form-select" name="tipo_solicitud" required>
                              <option value="" disabled selected>Seleccione un tipo</option>
                              <option value="1">Inspección y certificado de exportación</option>
                              <option value="2">Inspección</option>
                              <option value="3">Inspección y certificado de exportación (combinado)</option>
                              <option value="4">Certificado de exportación</option>
                              <option value="5">Certificado de exportación (combinado)</option>
                          </select>
                          <label for="tipo_solicitud">Tipo de solicitud</label>
                      </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-floating form-floating-outline mb-6">
                              <select id="id_empresa_solicitud_exportacion" onchange="cargarDatosCliente();"
                                  name="id_empresa" class="select2 form-select" required>
                                  <option value="" disabled selected>Selecciona cliente</option>
                                  @foreach ($empresas as $empresa)
                                      <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}
                                      </option>
                                  @endforeach
                              </select>
                              <label for="id_empresa">Cliente</label>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-floating form-floating-outline mb-5">
                              <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text"
                                  name="fecha_visita" />
                              <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                          </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-floating form-floating-outline mb-6 input-group ">
                            <select class="form-select" id="id_instalacion_exportacion" name="id_instalacion"
                                aria-label="id_instalacion" required>
                                <option value="" selected>Lista de instalaciones</option>
                                <!-- Aquí se llenarán las opciones con instalaciones del cliente -->
                            </select>

                            <button type="button" class="btn btn-primary" id="abrirModalInstalaciones"><i
                                    class="ri-add-line"></i> Agregar nueva instalación</button>

                        </div>
                    </div>
                  </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline mb-4">
                                <input placeholder="YYYY-MM-DD" class="form-control flatpickr-datetime" type="text" name="fecha_estimada_visita" />
                                <label for="num_anterior">Fecha y hora estimada de visita (en caso de que aplique)</label>
                            </div>
                        </div>
                    </div>
                  <!-- Sección: Pedidos para exportación -->
                  <div class="card" id="pedidos_Ex">
                      <div class="card-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-floating form-floating-outline mb-4">
                                  <select class="form-select" name="direccion_destinatario" id="direccion_destinatario_ex" required>
                                      <option value="" disabled selected>Seleccione una dirección</option>
                                  </select>
                                  <label for="direccion_destinatario">Dirección del destinatario</label>
                              </div>
                          </div>
                              <div class="col-md-6">
                                  <div class="form-floating form-floating-outline mb-4">
                                      <input type="text" class="form-control" name="aduana_salida"
                                          placeholder="Ej. Aduana de salida">
                                      <label for="aduana_salida">Aduana de salida</label>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-floating form-floating-outline mb-4">
                                      <input type="text" class="form-control" name="no_pedido"
                                          placeholder="Ej. Número de pedido">
                                      <label for="no_pedido">No. de pedido</label>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-floating form-floating-outline mb-4">
                                      <input type="file" class="form-control" name="factura_proforma">
                                      <label for="factura_proforma">Adjuntar Factura/Proforma</label>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-floating form-floating-outline mb-4">
                                      <input type="file" class="form-control" name="factura_proforma_cont">
                                      <label for="factura_proforma_cont">Adjuntar Factura/Proforma
                                          (Continuación)</label>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <!-- Sección: Elegir Etiquetas y Corrugados -->
                  <div class="card mt-4" id="etiquetas_Ex">
                      <div class="card-body">
                          <h5>Elegir Etiquetas y Corrugados</h5>

                      </div>
                  </div>

                  <div id="contenedor-caracteristicas">
                    <!-- Sección original: Características del Producto -->
                    <div class="card mt-4" id="caracteristicas_Ex">
                        <div class="card-body">
                            <h5>Características del Producto</h5>
                            <div class="row caracteristicas-row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="evasado_export" name="lote_envasado[]" class="select2 form-select">
                                            <option value="" disabled selected>Selecciona un lote envasado</option>
                                            <!-- Opciones dinámicas -->
                                        </select>
                                        <label for="lote_envasado">Selecciona el lote envasado</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="lotes_granel_export" name="lote_granel[]" class="select2 form-select">
                                            <option value="" disabled selected>Selecciona un lote a granel</option>
                                            <!-- Opciones dinámicas -->
                                        </select>
                                        <label for="lote_granel">Selecciona el lote a granel</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="number" class="form-control" name="cantidad_botellas[]" placeholder="Cantidad de botellas">
                                        <label for="cantidad_botellas">Cantidad de botellas</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="number" class="form-control" name="cantidad_cajas[]" placeholder="Cantidad de cajas">
                                        <label for="cantidad_cajas">Cantidad de cajas</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="presentacion[]" placeholder="Ej. 750ml">
                                        <label for="presentacion">Presentación</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Botón -->
                <button id="add-characteristics" class="btn btn-primary mt-1">
                    <i class="ri-add-line"></i> Agregar Tabla
                </button>


                  <div class="row">
                      <div class="form-floating form-floating-outline mb-5 mt-4">
                          <textarea name="info_adicional" class="form-control h-px-150" id="comentarios"
                              placeholder="Información adicional sobre la actividad..."></textarea>
                          <label for="comentarios">Información adicional sobre la actividad</label>
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

function cargarDatosCliente() {
    var empresa = $("#id_empresa_solicitud_exportacion").val();
    $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function(response) {
            console.log(response);
            //instalaciones
            var contenidoInstalaciones = "";
            for (let index = 0; index < response.instalaciones.length; index++) {
                contenidoInstalaciones += '<option value="' + response.instalaciones[index].id_instalacion + '">' +
                    response.instalaciones[index].tipo + ' | ' + response.instalaciones[index].direccion_completa + '</option>';
            }
            if (response.instalaciones.length == 0) {
                contenidoInstalaciones = '<option value="" disabled selected>Sin instalaciones registradas</option>';
            }
            $('#id_instalacion_exportacion').html(contenidoInstalaciones);
            //direcciones
            var contenidoDirecciones = "";
            for (let index = 0; index < response.direcciones.length; index++) {
                contenidoDirecciones += '<option value="' + response.direcciones[index].id_direccion + '">' +
                    response.direcciones[index].direccion + '</option>';
            }
            if (response.direcciones.length == 0) {
                contenidoDirecciones = '<option value="" disabled selected>Sin direcciones registradas</option>';
            }
            $('#direccion_destinatario_ex').html(contenidoDirecciones);
            //lotes
            var contenidoLotes = "";
            for (let index = 0; index < response.lotes_envasado.length; index++) {
                contenidoLotes += '<option value="' + response.lotes_envasado[index].id_lote_envasado + '">' +
                    response.lotes_envasado[index].nombre_lote + '</option>';
            }
            if (response.lotes_envasado.length == 0) {
                contenidoLotes = '<option value="" disabled selected>Sin lotes envasados registrados</option>';
            }
            $('#evasado_export').html(contenidoLotes);
        },
        error: function() {
            // Manejar el error
            console.error('Error al cargar los datos.');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
        // Obtener el select y las secciones
        var tipoSolicitud = document.getElementById('tipo_solicitud');
        var pedidosEx = document.getElementById('pedidos_Ex');
        var etiquetasEx = document.getElementById('etiquetas_Ex');


        // Manejar el evento de cambio
        tipoSolicitud.addEventListener('change', function() {
            var valorSeleccionado = tipoSolicitud.value;
            if (valorSeleccionado === '2') {
                // Ocultar secciones
                pedidosEx.style.display = 'none';
                etiquetasEx.style.display = 'none';
            } else {
                // Mostrar secciones
                pedidosEx.style.display = 'block';
                etiquetasEx.style.display = 'block';
            }
        });
    });

// Clonar toda la sección de Características del Producto
document.getElementById('add-characteristics').addEventListener('click', function (e) {
    e.preventDefault();

    // Seleccionar la sección original
    const original = document.querySelector('#caracteristicas_Ex');
    if (!original) return; // Si no hay una sección inicial, salir

    // Clonar toda la sección
    const clon = original.cloneNode(true);

    // Resetear los valores del clon
    const selects = clon.querySelectorAll('select');
    selects.forEach(select => select.value = '');

    const inputs = clon.querySelectorAll('input');
    inputs.forEach(input => input.value = '');

    // Crear un botón de eliminar para la nueva sección
    const btnDelete = document.createElement('button');
    btnDelete.className = 'btn btn-danger mt-2'; // Estilos
    btnDelete.textContent = 'Eliminar Características';
    btnDelete.addEventListener('click', function () {
        // Eliminar la sección y su separador
        const hr = clon.previousElementSibling; // El separador `<hr>`
        if (hr && hr.tagName === 'HR') hr.remove(); // Eliminar el separador si existe
        clon.remove(); // Eliminar la sección
    });

    // Insertar el botón de eliminar al final de la sección clonada
    clon.appendChild(btnDelete);

    // Insertar el clon y un separador después de la última sección
    const hrElement = document.createElement('hr'); // Separador
    const parentElement = original.parentNode;
    parentElement.appendChild(hrElement); // Agregar separador
    parentElement.appendChild(clon); // Agregar la sección clonada

    // Reaplicar select2 a los nuevos selects (si estás usando select2)
    selects.forEach(select => {
        if (typeof Select2 !== 'undefined') {
            $(select).select2(); // Esto requiere que uses Select2
        }
    });
});




</script>
