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
                                <select id="id_empresa_solicitud_exportacion" onchange="cargarDatosCliente();"
                                    name="id_empresa" class="select2 form-select">
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
                                <input placeholder="YYYY-MM-DD" class="form-control" type="datetime-local"
                                    name="fecha_visita" />
                                <label for="num_anterior">Fecha y hora sugerida para la inspección</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline mb-5">
                                <select class="select2 form-select" id="id_instalacion_exportacion"
                                    name="id_instalacion" aria-label="id_instalacion" required>
                                    <option value="" selected>Lista de instalaciones</option>
                                </select>
                                <label for="id_predio">Domicilio de inspección</label>
                            </div>
                        </div>

                    </div>
                    <!-- Sección: Pedidos para exportación -->
                    <div class="card" id="pedidos_Ex">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="direccion_destinatario"
                                            id="direccion_destinatario_ex">
                                            <option value="" disabled selected>Seleccione una dirección</option>
                                        </select>
                                        <label for="direccion_destinatario">Domicilio del destinatario</label>
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
                                        <input type="file" class="form-control" id="factura_proforma"
                                            name="factura_proforma">
                                        <input type="hidden" name="id_documento_factura" value="55">
                                        <input type="hidden" name="nombre_documento_factura" value="Factura proforma">
                                        <label for="factura_proforma">Adjuntar Factura/Proforma</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="file" class="form-control" id="factura_proforma_cont"
                                            name="factura_proforma_cont">
                                        <input type="hidden" name="id_documento_factura_cont" value="55">
                                        <input type="hidden" name="nombre_documento_factura_cont"
                                            value="Factura proforma (Continuación)">
                                        <label for="factura_proforma_cont">Adjuntar Factura/Proforma
                                            (Continuación)</label>
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
                                            <input type="text" disabled name="lote_granel[0]"
                                                class="form-control lotes_granel_export">
                                            </input>
                                            <label for="lote_granel">Lote a granel</label>
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

                    <div class="card mt-4">
                        <div class="card-body">
                            <h5>Información del lote envasado</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-2">
                                        <select class="select2 form-select" id="id_instalacion_envasado"
                                            name="id_instalacion_envasado" aria-label="id_instalacion_envasado"
                                            required>
                                            <option value="" selected>Lista de instalaciones</option>
                                        </select>
                                        <label for="id_predio">Domicilio de envasado</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Sección: Elegir Etiquetas y Corrugados -->
                    <div class="card mt-4" id="etiquetas_Ex">
                        <div class="card-body table-responsive text-nowrap">
                            <h6 id="encabezado_etiquetas">Elegir Etiquetas y Corrugados</h6>
                            <table class="table table-striped small table-sm" id="tabla_marcas">
                                <thead>
                                    <tr>
                                        <th>Seleccionar</th>

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
        if (empresa !== "" && empresa !== null && empresa !== undefined) {

            $.ajax({
                url: '/getDatos/' + empresa,
                method: 'GET',
                success: function(response) {
                    cargarInstalaciones(response.instalaciones_comercializadora);
                    cargarInstalacionesEnvasado(response.instalaciones_envasadora);
                    cargarDirecciones(response.direcciones);
                    cargarLotesEnvasado(response.lotes_envasado, response.marcas);
                    cargarLotesGranel(response.lotes_granel);
                },
                error: function() {
                    console.error('Error al cargar los datos.');
                }
            });
        }
    }

    // Función para cargar instalaciones
    function cargarInstalaciones(instalaciones) {
        if (instalaciones !== "" && instalaciones !== null && instalaciones !== undefined) {
            var contenidoInstalaciones = "";
            for (let index = 0; index < instalaciones.length; index++) {
                var tipoLimpio = limpiarTipo(instalaciones[index].tipo);
                contenidoInstalaciones += `
            <option value="${instalaciones[index].id_instalacion}">
                ${tipoLimpio} | ${instalaciones[index].direccion_completa}
            </option>`;
            }
            if (instalaciones.length === 0) {
                contenidoInstalaciones = '<option value="" disabled selected>Sin instalaciones registradas</option>';
            }
            $('#id_instalacion_exportacion').html(contenidoInstalaciones);
        }
    }

    function cargarInstalacionesEnvasado(instalaciones) {
        if (instalaciones !== "" && instalaciones !== null && instalaciones !== undefined) {
            var contenidoInstalaciones = "";
            for (let index = 0; index < instalaciones.length; index++) {
                var tipoLimpio = limpiarTipo(instalaciones[index].tipo);
                contenidoInstalaciones += `
            <option value="${instalaciones[index].id_instalacion}">
                ${tipoLimpio} | ${instalaciones[index].direccion_completa}
            </option>`;
            }
            if (instalaciones.length === 0) {
                contenidoInstalaciones = '<option value="" disabled selected>Sin instalaciones registradas</option>';
            }
            $('#id_instalacion_envasado').html(contenidoInstalaciones);
        }
    }

    // Función para cargar direcciones
    function cargarDirecciones(direcciones) {
        if (direcciones !== "" && direcciones !== null && direcciones !== undefined) {
            var contenidoDirecciones = "";
            for (let index = 0; index < direcciones.length; index++) {
                let destinatario = direcciones[index].destinatario || "Sin destinatario";
                contenidoDirecciones += `
            <option value="${direcciones[index].id_direccion}">
                ${destinatario} | ${direcciones[index].direccion}
            </option>`;
            }
            if (direcciones.length === 0) {
                contenidoDirecciones = '<option value="" disabled selected>Sin direcciones registradas</option>';
            }
            $('#direccion_destinatario_ex').html(contenidoDirecciones);
            //cargarMarcas();
        }
    }

    // Función para cargar lotes envasados
    // Función para cargar lotes envasados
    function cargarLotesEnvasado(lotesEnvasado, marcas) {
        var contenidoLotes = "";
        for (let index = 0; index < lotesEnvasado.length; index++) {
            var skuLimpio = limpiarSku(lotesEnvasado[index].sku);
            var marcaEncontrada = marcas.find(marca => marca.id_marca === lotesEnvasado[index].id_marca);
            var nombreMarca = marcaEncontrada ? marcaEncontrada.marca : "Sin marca";

            contenidoLotes += `
            <option data-id-marca="${marcaEncontrada ? marcaEncontrada.id_marca : ''}" value="${lotesEnvasado[index].id_lote_envasado}">
                ${skuLimpio} | ${lotesEnvasado[index].nombre} | ${nombreMarca}
            </option>`;
        }
        if (lotesEnvasado.length === 0) {
            contenidoLotes = '<option value="" disabled selected>Sin lotes envasados registrados</option>';
        }
        $('.evasado_export').html(contenidoLotes);

        cargarMarcas();

        // Añadir evento change a los select de lotes envasados
        $('.evasado_export').on('change', function() {
            var idLoteEnvasado = $(this).val(); // Obtén el id seleccionado
            cargarDetallesLoteEnvasado(idLoteEnvasado); // Llamar a la función con el id seleccionado

            cargarMarcas();
        });
    }

    // Función para cargar lotes a granel
    function cargarLotesGranel(lotesGranel) {
        if (lotesGranel !== "" && lotesGranel !== null && lotesGranel !== undefined) {
            var contenidoLotesGraneles = "";
            for (let index = 0; index < lotesGranel.length; index++) {
                contenidoLotesGraneles += `
            <option value="${lotesGranel[index].id_lote_granel}">
                ${lotesGranel[index].nombre_lote}
            </option>`;
            }
            if (lotesGranel.length === 0) {
                contenidoLotesGraneles = '<option value="" disabled selected>Sin lotes granel registrados</option>';
            }
            $('.lotes_granel_export').html(contenidoLotesGraneles);
        }
    }

    function cargarDetallesLoteEnvasado(idLoteEnvasado) {
        if (idLoteEnvasado !== "" && idLoteEnvasado !== null && idLoteEnvasado !== undefined) {
            $.ajax({
                url: '/getDetalleLoteEnvasado/' + idLoteEnvasado,
                method: 'GET',
                success: function(response) {
                    console.log(response); // Verifica la respuesta que recibes
                    if (response.detalle) {
                        // Si hay detalles, convierte el array en una cadena separada por comas
                        $('.lotes_granel_export').val(response.detalle.join(
                        ', ')); // Une los nombres de los lotes con coma y espacio
                    } else {
                        $('.lotes_granel_export').val(''); // Si no hay detalles, limpia el campo
                    }
                },
                error: function() {
                    console.error('Error al cargar el detalle del lote envasado.');
                }
            });
        }
    }



    // Función para limpiar el campo tipo
    function limpiarTipo(tipo) {
        try {
            return JSON.parse(tipo).join(', ');
        } catch (e) {
            return tipo;
        }
    }

    // Función para limpiar SKU
    function limpiarSku(sku) {
        try {
            let parsedSku = JSON.parse(sku);
            return parsedSku && parsedSku.inicial ? parsedSku.inicial : sku;
        } catch (e) {
            return sku;
        }
    }



    function cargarMarcas() {
        var id_empresa = $('#id_empresa_solicitud_exportacion').val();
        var id_marca = $('.evasado_export').find(':selected').data('id-marca');

        var id_direccion = $('#direccion_destinatario_ex').val();



        if (id_empresa) {
            $.ajax({
                url: '/marcas/' + id_marca + '/' + id_direccion,
                method: 'GET',
                success: function(marcas) {
                    var tbody = '';
                    if (marcas.length > 0 &&
                        marcas[0].direccion_nombre &&
                        marcas[0].direccion_nombre[0] !== undefined &&
                        marcas[0].direccion_nombre[0] !== "") {
                        $("#encabezado_etiquetas").text(marcas[0].direccion_nombre[0]);
                    }


                    marcas.forEach(function(marca) {
                        // Verifica que 'etiquetado' sea un objeto válido
                        if (marca.etiquetado && typeof marca.etiquetado === 'object') {
                            // Iterar sobre los SKU en 'etiquetado'
                            for (var i = 0; i < marca.etiquetado.sku.length; i++) {
                                tbody += '<tr>';

                                // Radio button
                                tbody += `
                <td>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="marcaSeleccionada" id="radio_${marca.etiquetado.sku[i]}" value="${marca.etiquetado.sku[i]}" />
                    </div>
                </td>
            `;

                                // SKU
                                tbody += `<td>${marca.etiquetado.sku[i] || 'N/A'}</td>`;

                                // Nombre del Tipo (considerando que `tipo_nombre` es un array de un solo elemento)
                                tbody += `<td>${marca.tipo_nombre[0] || 'N/A'}</td>`;

                                // Presentación
                                tbody += `<td>${marca.etiquetado.presentacion[i] || 'N/A'}</td>`;

                                // Nombre de la Clase (también un array de un solo elemento)
                                tbody += `<td>${marca.clase_nombre[0] || 'N/A'}</td>`;

                                // Nombre de la Categoría (también un array de un solo elemento)
                                tbody += `<td>${marca.categoria_nombre[0] || 'N/A'}</td>`;

                                // Función para generar enlace a archivos
                                function generarEnlaceArchivo(marca, idUnico, tipoDocumento) {
                                    if (marca.documentacion_url && Array.isArray(marca
                                            .documentacion_url)) {
                                        let documento = marca.documentacion_url.find(doc => doc
                                            .id_doc === idUnico && doc.nombre_documento ===
                                            tipoDocumento);
                                        if (documento) {
                                            let url =
                                                `/files/${marca.empresa.empresa_num_clientes[0].numero_cliente}/${documento.url}`;
                                            return `<td><a href="${url}" target="_blank"> <i class="ri-file-pdf-2-line ri-20px" aria-hidden="true"></i></a></td>`;
                                        }
                                    }
                                    // Retorna una celda vacía si no hay archivo
                                    return `<td>--</td>`;
                                }

                                // Generar enlaces
                                tbody += generarEnlaceArchivo(marca, marca.etiquetado.id_unico[i],
                                    'Etiquetas');
                                tbody += generarEnlaceArchivo(marca, marca.etiquetado.id_unico[i],
                                    'Corrugado');

                                tbody += '</tr>';
                            }
                        }
                    });


                    // Si no hay filas, mostrar mensaje
                    if (!tbody) {
                        tbody =
                            '<tr><td colspan="8" class="text-center">No hay datos disponibles.</td></tr>';
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
