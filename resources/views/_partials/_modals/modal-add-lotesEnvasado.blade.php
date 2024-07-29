<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="addlostesEnvasado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Registrar nuevo lote envasado</h4>
                    <p class="address-subtitle"></p>
                </div>
                <form id="addNewLoteForm">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-floating form-floating-outline mb-5">
                                <select onchange="obtenerGraneles()" id="id_empresa" name="id_empresa" class="select2 form-select" required>
                                    <option value="">Selecciona cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id_empresa }}">{{ $cliente->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="cliente">Cliente</label>
                            </div>
                        </div>
                
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="tipo_lote" name="tipo_lote" class="form-select" required onchange="toggleFields()">
                                    <option value="1">Por un solo lote a granel</option>
                                    <option value="2">Por más de un lote a granel</option>
                                </select>
                                <label for="tipo_lote">Conformado por</label>
                            </div>
                        </div>
                
                        <div  id="datosOpcion1"  class="col-md-4">
                            <div class="form-floating form-floating-outline mb-6">
                                <select class="select2 form-select lotesGra" id="lotesGra" name="id_lote_granel[]"  aria-label="Default select example">
                                  
                                   
                                </select>
                                <label for="lotesGra">No de lote granel:</label>
                            </div>
                        </div>
                    </div>
                
                    <div  class="opcion-datos" >
                        <!-- Datos a mostrar para la opción 1 -->
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text" class="form-control" id="name" placeholder="Introduce el nombre del lote" name="nombre_lote" aria-label="Nombre del lote" required />
                            <label for="name">Nombre del lote</label>
                        </div>
                
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-5">
                                    <input type="text" id="sku" class="form-control" placeholder="No. de pedido/SKU" aria-label="No. de pedido/SKU" name="sku" />
                                    <label for="sku">No. de pedido/SKU</label>
                                </div>
                            </div>
                            <divclass="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <select class="select2 form-select" id="marca" name="id_marca" aria-label="Marca">
                                        <option value="" selected>Selecciona una marca</option>
                                        @foreach ($marcas as $marca)
                                            <option value="{{ $marca->id_marca }}">{{ $marca->marca }}</option>
                                        @endforeach
                                    </select>
                                    <label for="marca">Marca</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="text" placeholder="Destino lote" id="destino_lote" name="destino_lote" />
                                    <label for="destino_lote">Destino lote</label>
                                </div>
                            </div>
                        </div>
                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="number" placeholder="Ingrese un valor" id="cantidad_botellas" name="cant_botellas" />
                                    <label for="cantidad_botellas">Cantidad de botellas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="text" placeholder="Presentación de la botella" id="presentacion" name="presentacion" />
                                    <label for="presentacion">Presentación de la botella</label>
                                </div>
                            </div>
                        </div>
                
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <select class="select2 form-select" id="unidad" name="unidad" aria-label="Unidad">
                                        <option value="Litros">Litros</option>
                                        <option value="Mililitros">Mililitros</option>
                                        <option value="Centrilitros">Centrilitros</option>
                                    </select>
                                    <label for="unidad">Unidad</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input class="form-control" type="number" step="0.01" placeholder="Volumen total" id="volumen_total" name="volumen_total" />
                                    <label for="volumen_total">Volumen total</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-6">
                                    <select class="select2 form-select" id="id_instalacion" name="lugar_envasado" aria-label="Default select example">
                                        <option value="" selected>Lote Granel</option>
                                        @foreach ($Instalaciones as $Instalaciones)
                                            <option value="{{ $Instalaciones->id_instalacion }}">{{ $Instalaciones->direccion_completa }}</option>
                                        @endforeach
                                    </select>
                                    <label for="lotesGra">Lugar de envasado</label>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div id="datosOpcion2">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><button type="button" class="btn btn-primary"> <i class="ri-add-line"></i> </button></th>
                                    <th>Lote a granel</th>
                                    <th>Volumen parcial</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <th>
                                            <button type="button" class="btn btn-danger"> <i class="ri-delete-bin-5-fill"></i> </button>
                                        </th>
                                        <td>
                                            <select class="lotesGra form-control select2" name="id_lote_granel[]" id="">

                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm"  name="volumen_parcial">
                                        </td>
                                    </tr>
                               
                            </tbody>
                        </table>
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


<script></script>


<!--/ Add New Address Modal -->
<!--  <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Cancelar</button>
                </div>-->

<script>


    function obtenerGraneles() {

        var empresa = $("#id_empresa").val();
        //alert(empresa);
    // Hacer una petición AJAX para obtener los detalles de la empresa
    $.ajax({
        url: '/getDatos/' + empresa,
        method: 'GET',
        success: function(response) {
            // Cargar los detalles en el modal
            var contenido = "";


          for (let index = 0; index < response.lotes_granel.length; index++) {
            contenido = '<option value="'+response.lotes_granel[index].id_lote_granel+'">'+response.lotes_granel[index].nombre_lote+'</option>' + contenido;
           // console.log(response.normas[index].norma);
          }

          if(response.lotes_granel.length == 0){
            contenido = '<option value="">Sin lotes a granel registrados</option>';
          }
           

            $('.lotesGra').html(contenido);
         
          
        },
        error: function() {
            //alert('Error al cargar los lotes a granel.');
        }
    });
  }

</script>