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
                                <select id="tipo_solicitud" class="form-select" name="tipo_solicitud">
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
                                <select id="id_empresa_solicitud_exportacion"
                                    onchange="cargarDatosCliente(); cargarMarcas();" name="id_empresa"
                                    class="select2 form-select">
                                    <option value="" disabled selected>Selecciona cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">
                                            {{ isset($empresa->empresaNumClientes[0])
                                                ? $empresa->empresaNumClientes[0]->numero_cliente
                                                : (isset($empresa->empresaNumClientes[1])
                                                    ? $empresa->empresaNumClientes[1]->numero_cliente
                                                    : 'Sin número') }}
                                            | {{ $empresa->razon_social }}
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
                                    aria-label="id_instalacion">
                                    <option value="" selected>Lista de instalaciones</option>
                                    <!-- Aquí se llenarán las opciones con instalaciones del cliente -->
                                </select>

                                <a href="../domicilios/instalaciones" target="_blank" class="btn btn-primary">
                                    <i class="ri-add-line"></i> Agregar nueva instalación
                                </a>

                            </div>
                        </div>
                    </div>
                    <!-- Sección: Pedidos para exportación -->
                    <div class="card" id="pedidos_Ex">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select" name="direccion_destinatario"
                                            id="direccion_destinatario_ex">
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
                                      <input type="file" class="form-control" id="factura_proforma" name="factura_proforma">
                                      <input type="hidden" name="id_documento_factura" value="55">
                                      <input type="hidden" name="nombre_documento_factura" value="Factura proforma">
                                      <label for="factura_proforma">Adjuntar Factura/Proforma</label>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-floating form-floating-outline mb-4">
                                      <input type="file" class="form-control" id="factura_proforma_cont" name="factura_proforma_cont">
                                      <input type="hidden" name="id_documento_factura_cont" value="55">
                                      <input type="hidden" name="nombre_documento_factura_cont" value="Factura proforma (Continuación)">
                                      <label for="factura_proforma_cont">Adjuntar Factura/Proforma (Continuación)</label>
                                  </div>
                              </div>

                            </div>
                        </div>
                    </div>
                    <div id="sections-container">
                        <!-- Sección original: Características del Producto -->
                        <div class="card mt-4" id="caracteristicas_Ex">
                            <div class="card-body">
                                <h5>Características del Producto</h5>
                                <div class="row caracteristicas-row">
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select name="lote_envasado[0]"
                                                class="select2 form-select evasado_export">
                                                <option value="" disabled selected>Selecciona un lote envasado
                                                </option>
                                                <!-- Opciones dinámicas -->
                                            </select>
                                            <label for="lote_envasado">Selecciona el lote envasado</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select name="lote_granel[0]"
                                                class="select2 form-select lotes_granel_export">
                                                <option value="" disabled selected>Selecciona un lote a granel
                                                </option>
                                                <!-- Opciones dinámicas -->
                                            </select>
                                            <label for="lote_granel">Selecciona el lote a granel</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="number" class="form-control" name="cantidad_botellas[0]"
                                                placeholder="Cantidad de botellas">
                                            <label for="cantidad_botellas">Cantidad de botellas</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="number" class="form-control" name="cantidad_cajas[0]"
                                                placeholder="Cantidad de cajas">
                                            <label for="cantidad_cajas">Cantidad de cajas</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="text" class="form-control" name="presentacion[0]"
                                                placeholder="Ej. 750ml">
                                            <label for="presentacion">Presentación</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Botones -->
                    <div id="botones_characteristics" class="d-none">
                        <button type="button" id="add-characteristics" class="btn btn-primary btn-sm mt-1">
                            <i class="ri-add-line"></i> Agregar Tabla
                        </button>
                        <button type="button" id="delete-characteristics"
                            class="btn btn-danger btn-sm mt-1 float-end">
                            <i class="ri-delete-bin-6-fill"></i> Eliminar tabla
                        </button>
                    </div>

                    <!-- Sección: Elegir Etiquetas y Corrugados -->
                    <div class="card mt-4" id="etiquetas_Ex">
                      <div class="card-body table-responsive text-nowrap">
                          <h5>Elegir Etiquetas y Corrugados</h5>
                          <table class="table table-striped" id="tabla_marcas">
                              <thead>
                                  <tr>
                                      <th>Seleccionar</th>
                                      <th>dirección</th>
                                      <th>SKU</th>
                                      <th>Tipo</th>
                                      <th>Presentación</th>
                                      <th>Clase</th>
                                      <th>Categoría</th>
                                      <th>Etiqueta</th>
                                      <th>Corrugado</th>
                                  </tr>
                              </thead>
                              <tbody class="table-border-bottom-0">
                                  {{-- aqui seria el foreach --}}
                              </tbody>
                          </table>
                      </div>
                  </div>

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
                // Instalaciones
                var contenidoInstalaciones = "";
                for (let index = 0; index < response.instalaciones.length; index++) {
                    // Limpia el campo tipo usando la función limpiarTipo
                    var tipoLimpio = limpiarTipo(response.instalaciones[index].tipo);

                    contenidoInstalaciones += '<option value="' + response.instalaciones[index]
                        .id_instalacion + '">' +
                        tipoLimpio + ' | ' + response.instalaciones[index].direccion_completa + '</option>';
                }
                if (response.instalaciones.length == 0) {
                    contenidoInstalaciones =
                        '<option value="" disabled selected>Sin instalaciones registradas</option>';
                }
                $('#id_instalacion_exportacion').html(contenidoInstalaciones);
                // Direcciones
                var contenidoDirecciones = "";
                for (let index = 0; index < response.direcciones.length; index++) {
                    // Filtrar direcciones con tipo_direccion igual a 1
                    if (response.direcciones[index].tipo_direccion === 1) {
                        contenidoDirecciones += `
                            <option value="${response.direcciones[index].id_direccion}">
                                ${response.direcciones[index].direccion}
                            </option>`;
                    }
                }
                if (contenidoDirecciones === "") {
                    contenidoDirecciones = '<option value="" disabled selected>Sin direcciones registradas</option>';
                }
                $('#direccion_destinatario_ex').html(contenidoDirecciones);

                var contenidoLotes = "";
                var marcas = response.marcas;
                for (let index = 0; index < response.lotes_envasado.length; index++) {

                    var skuLimpio = limpiarSku(response.lotes_envasado[index].sku);
                    var marcaEncontrada = marcas.find(function(marca) {
                        return marca.id_marca === response.lotes_envasado[index].id_marca;
                    });
                    var nombreMarca = marcaEncontrada ? marcaEncontrada.marca : "Sin marca";
                    contenidoLotes += '<option value="' + response.lotes_envasado[index].id_lote_envasado + '">' +
                        skuLimpio + ' | ' + response.lotes_envasado[index].nombre + ' | ' + nombreMarca + '</option>';
                }
                if (response.lotes_envasado.length == 0) {
                    contenidoLotes = '<option value="" disabled selected>Sin lotes envasados registrados</option>';
                }
                $('.evasado_export').html(contenidoLotes);
                // Lotes graneles
                var contenidoLotesGraneles = "";
                for (let index = 0; index < response.lotes_granel.length; index++) {
                    contenidoLotesGraneles += '<option value="' + response.lotes_granel[index]
                        .id_lote_granel + '">' +
                        response.lotes_granel[index].nombre_lote + '</option>';
                }
                if (response.lotes_granel.length == 0) {
                    contenidoLotesGraneles =
                        '<option value="" disabled selected>Sin lotes granel registrados</option>';
                }
                $('.lotes_granel_export').html(contenidoLotesGraneles);

            },
            error: function() {
                console.error('Error al cargar los datos.');
            }
        });
    }
    // Función para limpiar el campo tipo
    function limpiarTipo(tipo) {
        try {
            // Convierte el JSON string a un array y únelos en una cadena limpia
            return JSON.parse(tipo).join(', ');
        } catch (e) {
            // Si no es JSON válido, regresa el valor original
            return tipo;
        }
    }

    function limpiarSku(sku) {
        console.log("Valor original de SKU:", sku); // Agrega un log para verificar el valor recibido

        try {
            // Intenta parsear el SKU como JSON
            let parsedSku = JSON.parse(sku);
            console.log("SKU parseado:", parsedSku); // Verifica qué devuelve el parseo

            // Verifica si parsedSku tiene la propiedad 'inicial'
            if (parsedSku && parsedSku.inicial) {
                return parsedSku.inicial; // Regresa el valor de 'inicial'
            } else {
                return sku; // Si no tiene la propiedad 'inicial', regresa el SKU tal como está
            }
        } catch (e) {
            // Si no es un JSON válido, simplemente retorna el valor original
            console.warn("Error al parsear SKU:", e); // Registra el error de parseo
            return sku;
        }
    }



    function cargarMarcas() {
        var id_empresa = $('#id_empresa_solicitud_exportacion').val();

        if (id_empresa) {
            $.ajax({
                url: '/marcas/' + id_empresa,
                method: 'GET',
                success: function(marcas) {
                    var tbody = '';

                    marcas.forEach(function(marca) {
                        // Verifica que 'etiquetado' sea un objeto válido
                        if (marca.etiquetado && typeof marca.etiquetado === 'object') {
                            // Iterar sobre los SKU en 'etiquetado'
                            for (var i = 0; i < marca.etiquetado.sku.length; i++) {
                                tbody += '<tr>';
                                tbody += `
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="marcaSeleccionada" id="radio_${marca.etiquetado.sku[i]}" value="${marca.etiquetado.sku[i]}" />
                                    </div>
                                </td>
                            `;
                            tbody += `<td>${(marca.direccion_nombre && marca.direccion_nombre[i]) || 'N/A'}</td>`; // Dirección
                                tbody += `<td>${marca.etiquetado.sku[i] || 'N/A'}</td>`; // SKU
                                tbody +=
                                `<td>${marca.tipo_nombre[i] || 'N/A'}</td>`; // Nombre del Tipo
                                tbody +=
                                `<td>${marca.etiquetado.presentacion[i] || 'N/A'}</td>`; // Presentación
                                tbody +=
                                `<td>${marca.clase_nombre[i] || 'N/A'}</td>`; // Nombre de la Clase
                                tbody +=
                                `<td>${marca.categoria_nombre[i] || 'N/A'}</td>`; // Nombre de la Categoría
                                tbody += '</tr>';
                            }
                        } else {
                            tbody +=
                                '<tr><td colspan="6" class="text-center">Datos de etiquetado no disponibles.</td></tr>';
                        }
                    });

                    // Si no hay filas, mostrar mensaje
                    if (!tbody) {
                        tbody =
                            '<tr><td colspan="6" class="text-center">No hay datos disponibles.</td></tr>';
                    }

                    // Agregar las filas a la tabla
                    $('#tabla_marcas tbody').html(tbody);
                },
                error: function(xhr) {
                    console.error('Error al obtener marcas:', xhr);
                    $('#tabla_marcas tbody').html(
                    '<tr><td colspan="6">Error al cargar los datos</td></tr>');
                }
            });
        } else {
            $('#tabla_marcas tbody').html('<tr><td colspan="6">Seleccione una empresa para ver los datos</td></tr>');
        }
    }
</script>
