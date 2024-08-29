<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="editHologramas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Editar Solicitud de Hologramas</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="editHologramasForm"method="POST" enctype="multipart/form-data" onsubmit="return false">
                    
                    @csrf
                 <input type="hidden" id="editt_id_solicitud" name="id_solicitud">

                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="edit_folio" name="edit_folio" placeholder="Ingresa el folio de solicitud" aria-label="Ingrese el folio" required />
                        <label for="folio">Ingresa el folio de solicitud</label>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select onchange="editobtenerMarcas(); editobtenerDirecciones();" id="edit_id_empresa" name="edit_id_empresa" class="select2 form-select" required>
                                    <option value="">Selecciona cliente</option>
                                    @foreach ($Empresa as $cliente)
                                        <option value="{{ $cliente->id_empresa }}">{{ $cliente->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_id_empresa">Cliente</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="select2 form-select id_marca" id="edit_id_marca" name="edit_id_marca" required>
                                    <option value="" selected>Selecciona una marca</option>
                                </select>
                                <label for="edit_id_marca">Marca</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="number" id="edit_cantidad_hologramas" name="edit_cantidad_hologramas" placeholder="Número de hologramas solicitados" readonly />
                                <label for="edit_cantidad_hologramas">Número de hologramas solicitados</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating form-floating-outline mb-6">
                        <select class="select2 form-select edit_id_direccion" id="edit_id_direccion" name="edit_id_direccion" required>
                            <option value="" selected>Selecciona una dirección</option>
                        </select>
                        <label for="edit_id_direccion">Dirección a la que se enviará</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <textarea name="edit_comentarios" class="form-control h-px-100" id="edit_comentarios" placeholder="Observaciones..."></textarea>
                        <label for="edit_comentarios">Comentarios</label>
                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    function editobtenerMarcas() {
        var empresa = $("#edit_id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.marcas.length; index++) {
                    contenido = '<option value="' + response.marcas[index].id_marca + '">' + response
                        .marcas[index].marca + '</option>' + contenido;
                    // console.log(response.normas[index].norma);
                }

                if (response.marcas.length == 0) {
                    contenido = '<option value="">Sin marcas registradas</option>';
                }
                $('#edit_id_marca').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }

    function editobtenerDirecciones() {
        var empresa = $("#edit_id_empresa").val();
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                            // Filtrar las direcciones para que solo se incluyan las que tienen tipo_direccion igual a 3
            var direccionesFiltradas = response.direcciones.filter(function(direccion) {
                return direccion.tipo_direccion == 3;
            });
                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.direcciones.length; index++) {
                    contenido += '<option value="' + response.direcciones[index].id_direccion + '">' +
                        'Nombre de detinatario: ' + response.direcciones[index].nombre_recibe +
                        ' - Dirección: ' + response.direcciones[index].direccion +
                        ' - Correo: ' + response.direcciones[index].correo_recibe +
                        ' - Celular: ' + response.direcciones[index].celular_recibe +


                        '</option>';
                }
                // console.log(response.direcciones[index].norma);
                if (response.direcciones.length == 0) {
                    contenido = '<option value="">Sin lotes a granel registrados</option>';
                }
                $('.edit_id_direccion').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }


    

    //Limpia en el boton cancelar
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#addHologramas .btn-outline-secondary').addEventListener('click',
            function() {
                document.getElementById('addHologramasForm').reset();
                $('.select2').val(null).trigger('change'); // Reset select2 fields
            });
    });


    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('addHologramas');
        const form = document.getElementById('addHologramasForm');

        // Limpia los campos select2 al cerrar el modal
        modal.addEventListener('hidden.bs.modal', () => {
            // Limpia el formulario
            form.reset();

            // Limpia todos los campos select2
            $('.select2').val(null).trigger('change');
        });

        // Maneja el envío del formulario
        form.addEventListener('submit', (event) => {
            event.preventDefault(); // Evita el comportamiento predeterminado del formulario

            // Aquí puedes añadir la lógica para enviar el formulario, por ejemplo usando AJAX:
            $.ajax({
                url: form.action, // Asegúrate de que `form.action` sea la URL correcta
                method: 'POST',
                data: $(form).serialize(),
                success: (response) => {
                    // Manejar la respuesta del servidor aquí, por ejemplo, mostrar un mensaje de éxito
                    console.log('Registro exitoso:', response);

                    // Limpia el formulario y los campos select2 después de enviar
                    form.reset();
                    $('.select2').val(null).trigger('change');

                    // Cierra el modal
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    modalInstance.hide();
                },
                error: (error) => {
                    // Manejar errores aquí, por ejemplo, mostrar un mensaje de error
                    console.error('Error al registrar:', error);
                }
            });
        });
    });

</script>
