<style>
    .modal-custom-size {
        max-width: 100%;
        width: auto%;
    }

    .select2-container .select2-selection--single {
    height: 31px; /* Ajusta la altura aquí */
    font-size: 0.875rem; /* Tamaño del texto */
    line-height: 31px; /* Alineación vertical */
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    padding-left: 8px; /* Espaciado interno */
    padding-right: 8px;
    font-size: 0.875rem; /* Tamaño del texto */
    line-height: 31px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 31px; /* Ajusta el tamaño del ícono */
}

.select2-container .select2-selection--multiple {
    min-height: 31px; /* Ajusta la altura */
    font-size: 0.875rem;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    font-size: 0.875rem; /* Tamaño del texto */
}

</style>
<div class="modal fade" id="etiquetas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2"> Subir/Ver etiquetas</h4>
                    <p class="subtitulo badge bg-primary"></p>
                </div>
                <form id="etiquetasForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                    <div class="row">
                        <input type="hidden" id="etiqueta_marca" name="id_marca">
                        <input type="hidden" id="id_empresa">
                        <div class="table-responsive">
                            <table style="table-layout: fixed;" class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 100px"><button type="button" class="btn btn-primary add-row-add"> <i
                                                    class="ri-add-line"></i>
                                            </button></th>
                                        <th style="width: 20%">Destino de exportación</th>
                                        <th>SKU</th>
                                        <th>Información</th>
                                        <th>Cont. Neto</th>
                                        <th>% Alc. Vol.</th>
                                      
                                        <th>Etiqueta</th>
                                        <th>Corrugado</th>

                                    </tr>
                                </thead>
                                <tbody id="contenidoRango">
                                    
                                </tbody>
                            </table>
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
    $(document).ready(function() {
        $('#etiquetas').on('shown.bs.modal', function() {
            $('#contenidoRango .select2').select2({
                dropdownParent: $('#etiquetas')
            });
        });
        //Agregar o eliminar filas en la tabla
        var i = 0;
        $('.add-row-add').click(function() {
            obtenerDirecciones(i);
            let opciones = `
            @foreach ($tipos as $nombre)
                <option value="{{ $nombre->id_tipo }}">{{ $nombre->nombre }}</option>
            @endforeach
        `;
            let opciones2 = `
            @foreach ($clases as $clase)
                <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
            @endforeach
        `;
            let opciones3 = `
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}">{{ $categoria->categoria }}</option>
            @endforeach
        `;
        
            var newRow = `
            <tr>
                <th>
                    <button type="button" class="btn btn-danger remove-row"> <i class="ri-delete-bin-5-fill"></i> </button>
                </th>
                                                <td><select id="id_direccion_destino` + i + `" class="form-control select2 .id_direccion_destino" name="id_direccion[]"></select></td>
                <td><input type="text" class="form-control form-control-sm" name="sku[]" id="sku"></td>
                <td><select class="form-control" name="id_categoria[]">` + opciones3 + `</select>
                    <select class="form-control select2" name="id_tipo[]">` + opciones + `</select>
                    <select class="form-control select2" name="id_clase[]">` + opciones2 + `</select></td>
                <td><input type="number" class="form-control form-control-sm" name="presentacion[]" step="0.01" min="0">
                    <select class="form-control" name="unidad[]"><option value="mL">mL</option><option value="L">L</option><option value="cL">cL</option></select></td>
                <td><input type="text" class="form-control form-control-sm" name="alc_vol[]"></td>
               
                <td><input class="form-control form-control-sm" type="file" name="url[]"><input value="60" class="form-control" type="hidden" name="id_documento[]"><input value="Etiquetas" class="form-control" type="hidden" name="nombre_documento[]"></td>
                <td><input class="form-control form-control-sm" type="file" name="url[]"><input value="75" class="form-control" type="hidden" name="id_documento[]"><input value="Corrugado" class="form-control" type="hidden" name="nombre_documento[]"></td>
            </tr>`;

            $('#contenidoRango').append(newRow);
            // Reinicializa select2 en todos los selects agregados
            $('#contenidoRango .select2').select2({
                dropdownParent: $('#etiquetas')
            });
            i++;
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
    });

    function obtenerDirecciones(aux) {
        var empresa = $("#id_empresa").val();

        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response.direcciones_destino);
                var contenido = "";
            for (let index = 0; index < response.direcciones_destino.length; index++) {
                // Limpia el campo tipo usando la función limpiarTipo
               

                contenido = '<option value="' + response.direcciones_destino[index].id_direccion + '">' +
                    response.direcciones_destino[index].destinatario + ' | ' + response.direcciones_destino[index].direccion + '</option>' +
                    contenido;
            }
            if (response.direcciones_destino.length == 0) {
                contenido = '<option value="">Sin direcciones registradas</option>';
            }
            $('#id_direccion_destino'+aux).html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }
</script>
