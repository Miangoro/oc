<!-- Add New Lote Envasado Modal -->
<div class="modal fade" id="ActaUnidades" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple modal-add-new-address">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-0">
                <div class="text-center mb-6">
                    <h4 class="address-title mb-2">Acta circunstanciada para Unidades de producción</h4>
                </div>
            </div>
            <form id="ActaUnidadesForm" method="POST" enctype="multipart/form-data" onsubmit="return false">
                <input type="hidden" class="id_inspeccion" name="id_inspeccion">
                <input type="hidden" class="id_empresa" name="acta_id_empresa">
                {{--                 <input type="text" class="fecha_visita" name="fecha_visita">
 --}}
                @csrf
                <div class="row">
                    <div class="col-md-5 mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="num_acta" name="num_acta"
                                placeholder="Ingresa el No. de acta" aria-label="Ingresa el No. guia" />
                            <label for="num_acta">Acta número:</label>
                        </div>
                    </div>


                    <div class="col-md-5">
                        <div class="form-floating form-floating-outline mb-4">
                            <select id="categoria_acta" name="categoria_acta" class="form-select" required>
                                <option value="1">Unidad de producción de Agave </option>
                                <option value="2">Unidad de producción de Mezca</option>
                                <option value="3">Planta de Envasado</option>
                                <option value="4">Comercializadora</option>
                                <option value="5">Almacén</option>

                            </select>
                            <label for="categoria_acta">En la categoría de:</label>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-floating form-floating-outline mb-4">
                            <select id="testigos" name="testigos" class="form-select" required>
                                <option value="1">Si</option>
                                <option value="2">No</option>
                            </select>
                            <label for="testigos">Testigos:</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control Inspector" id="encargado" name="encargado"
                                placeholder="Ingresa el nombre del encargado" aria-label="Ingresa el No. guia" />
                            <label for="encargado">Encargado</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="num_credencial_encargado"
                                name="num_credencial_encargado" placeholder="Ingresa el No. de la credencial"
                                aria-label="Ingresa el No. guia" />
                            <label for="num_credencial_encargado">Credencial vigente número</label>
                        </div>
                    </div>
                </div>

                <div class="form-floating form-floating-outline mb-5">
                    <input type="text" class="form-control direccion_completa" id="lugar_inspeccion"
                        name="lugar_inspeccion" placeholder="Lugar de inspeccion:" aria-label="Ingresa el No. guia" />
                    <label for="lugar_inspeccion">Lugar de inspeccion:</label>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="datetime-local" class="form-control " id="fecha_inicio" name="fecha_inicio"
                                aria-label="Fecha de Emisión">
                            <label for="fecha_inicio">Fecha de inicio</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-5">
                        <div class="form-floating form-floating-outline">
                            <input type="datetime-local" class="form-control" id="fecha_fin" name="fecha_fin"
                                aria-label="Fecha de Emisión">
                            <label for="fecha_fin">Fecha de final</label>
                        </div>
                    </div>
                </div>

                <p class="address-subtitle"><b style="color: red">Designacion: </b>De testigos</b></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <button type="button" class="btn btn-primary add-row" data-target="#testigoss"
                                    data-name-prefix="nombre_testigo[]" data-name-suffix="domicilio[]">
                                    <i class="ri-add-line"></i>
                                </button>
                            </th>
                            <th>Nombre del testigo</th>
                            <th>Domicilio</th>
                        </tr>
                    </thead>
                    <tbody id="testigoss">
                        <tr>
                            <th>
                                <button type="button" class="btn btn-danger remove-row" disabled>
                                    <i class="ri-delete-bin-5-fill"></i>
                                </button>
                            </th>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="nombre_testigo[]"
                                    id="nombre_testigo" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="domicilio[]"
                                    id="domicilio" />
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- tabla de produccion --}}

                <div style="padding: 10px"></div>
                <p class="address-subtitle"><b style="color: red">Unidad: </b>De producción</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><button type="button" class="btn btn-primary add-row-produccion"> <i
                                        class="ri-add-line"></i>
                                </button></th>
                            <th>Nombre del Predio/Plantación</th>
                            <th>Plagas en el cultivo</th>
                        </tr>
                    </thead>
                    <tbody id="unidadProduccion">
                        <tr>
                            <th>
                                <button type="button" class="btn btn-danger remove-row" disabled>
                                    <i class="ri-delete-bin-5-fill"></i>
                                </button>
                            </th>
                            <td><select class="form-control select2 plantacion" name="id_empresa[]">
                                    <!-- Opciones -->
                                </select>
                            </td>
                            <td><input type="text" class="form-control form-control-sm" name="plagas[]"></td>
                        </tr>
                    </tbody>
                </table>

                {{-- Tabla de produccion mezcal o instalaciones --}}
                <div style="padding: 10px"></div>
                <p class="address-subtitle"><b style="color: red">Unidad: </b>De producción de Mezcal</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <button type="button" class="btn btn-primary add-row">
                                    <i class="ri-add-line"></i>
                                </button>
                            </th>
                            <th>Recepción (materia prima)</th>
                            <th>Área de pesado</th>
                            <th>Área de cocción</th>
                            <th>Área de maguey cocido</th>
                            <th>Área de molienda</th>
                            <th>Área de fermentación</th>
                            <th>Área de destilación</th>
                            <th>Almacén a graneles</th>
                        </tr>
                    </thead>
                    <tbody id="unidadMezcal">
                        <tr>
                            <th>
                                <button type="button" class="btn btn-danger remove-row" disabled>
                                    <i class="ri-delete-bin-5-fill"></i>
                                </button>
                            </th>
                            <!-- Indexado por fila (0) y columna (áreas) -->
                            <td>
                                <select class="form-control select2" name="respuesta[0][0]">
                                    <option value="C">C</option>
                                    <option value="NC">NC</option>
                                    <option value="NA">NA</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control select2" name="respuesta[0][1]">
                                    <option value="C">C</option>
                                    <option value="NC">NC</option>
                                    <option value="NA">NA</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control select2" name="respuesta[0][2]">
                                    <option value="C">C</option>
                                    <option value="NC">NC</option>
                                    <option value="NA">NA</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control select2" name="respuesta[0][3]">
                                    <option value="C">C</option>
                                    <option value="NC">NC</option>
                                    <option value="NA">NA</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control select2" name="respuesta[0][4]">
                                    <option value="C">C</option>
                                    <option value="NC">NC</option>
                                    <option value="NA">NA</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control select2" name="respuesta[0][5]">
                                    <option value="C">C</option>
                                    <option value="NC">NC</option>
                                    <option value="NA">NA</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control select2" name="respuesta[0][6]">
                                    <option value="C">C</option>
                                    <option value="NC">NC</option>
                                    <option value="NA">NA</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control select2" name="respuesta[0][7]">
                                    <option value="C">C</option>
                                    <option value="NC">NC</option>
                                    <option value="NA">NA</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- tabla de equipos mezcal --}}
                <div style="padding: 10px"></div>
                <p class="address-subtitle"><b style="color: red">Unidad: </b>Equipo de Mezcal</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <button type="button" class="btn btn-primary add-row-equipoMezcal">
                                    <i class="ri-add-line"></i>
                                </button>
                            </th>
                            <th >Equipo</th>
                            <th>Cantidad</th>
                            <th>Capacidad</th>
                            <th>Tipo de material</th>
                        </tr>
                    </thead>
                    <tbody id="equipoMezcal">
                        <tr>
                            <th>
                                <button type="button" class="btn btn-danger remove-row" disabled>
                                    <i class="ri-delete-bin-5-fill"></i>
                                </button>
                            </th>
                            <td>
                                <select class="form-control select2 equipo" name="equipo[]">
                                    <option value="" disabled selected>Selecciona equipo</option>
                                    @foreach ($equipos as $equipo)
                                        <option value="{{ $equipo->equipo }}">{{ $equipo->equipo }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="cantidad[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="capacidad[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="tipo_material[]" />
                        </tr>
                    </tbody>
                </table>



                {{-- UNIDAD ENVASADSO --}}
{{--                 <div style="padding: 20px"></div>
                <p class="address-subtitle"><b style="color: red">Unidad: </b>De Envasado</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <button type="button" class="btn btn-primary add-row"
                                    data-target="#unidadProduccion" data-name-prefix="nombre_predio[]"
                                    data-name-superficie="superficie[]" data-name-madurez="madurez[]"
                                    data-name-plagas="plagas[]" data-name-plantas="cantidad_plantas[]">
                                    <i class="ri-add-line"></i>
                                </button>
                            </th>
                            <th>Almacén de
                                insumos</th>
                            <th>Almacén a
                                gráneles
                            </th>
                            <th>Sistema
                                de
                                filtrado</th>
                            <th>Área de
                                envasado</th>
                            <th>Área de
                                tiquetado</th>
                            <th>Almacén de
                                producto
                                terminado</th>
                            <th>Área de
                                aseo personal</th>
                        </tr>
                    </thead>
                    <tbody id="unidadProduccion">
                        <tr>
                            <th>
                                <button type="button" class="btn btn-danger remove-row" disabled>
                                    <i class="ri-delete-bin-5-fill"></i>
                                </button>
                            </th>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="nombre_predio[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="superficie[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="madurez[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="plagas[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm"
                                    name="cantidad_plantas[]" />
                            </td>

                            <td>
                                <input type="text" class="form-control form-control-sm" name="coordenadas[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="coordenadas[]" />
                            </td>
                        </tr>
                    </tbody>
                </table> --}}

                {{-- UNIDAD EQUIPO ENVASADO --}}
                 <div style="padding: 20px"></div>
                <p class="address-subtitle"><b style="color: red">Unidad: </b>Equipo de Envasado</p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <button type="button" class="btn btn-primary add-row-equipoEnvasado">
                                    <i class="ri-add-line"></i>
                                </button>
                            </th>
                            <th>Equipo</th>
                            <th>Cantidad</th>
                            <th>Capacidad</th>
                            <th>Tipo de material</th>
                        </tr>
                    </thead>
                    <tbody id="equipoEnvasado">
                        <tr>
                            <th>
                                <button type="button" class="btn btn-danger remove-row" disabled>
                                    <i class="ri-delete-bin-5-fill"></i>
                                </button>
                            </th>
                            <td>
                                <select class="form-control select2 " name="equipo_envasado[]">
                                    <option value="" disabled selected>Selecciona equipo</option>
                                    @foreach ($equipos as $equipoEnva)
                                        <option value="{{ $equipoEnva->equipo }}">{{ $equipoEnva->equipo }}</option>
                                    @endforeach
                                </select>
                                
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="cantidad_envasado[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="capacidad_envasado[]" />
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="tipo_material_envasado[]" />
                        </tr>
                    </tbody>
                </table> 



                <div style="text-align: center; color: black; font-size: 20px; padding: 20px"><b
                        style="color: red">Anote: </b>No conformidades identificadas en la inspección</div>
                <div class="form-floating form-floating-outline mb-5">
                    <textarea name="no_conf_infraestructura" class="form-control h-px-100" id="no_conf_infraestructura"
                        placeholder="Observaciones..."></textarea>
                    <label for="no_conf_infraestructura">Infraestructura</label>
                </div>

                <div class="form-floating form-floating-outline mb-5">
                    <textarea name="no_conf_equipo" class="form-control h-px-100" id="no_conf_equipo" placeholder="Observaciones..."></textarea>
                    <label for="no_conf_equipo">Equipo</label>
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


    });

    function obtenerNombrePredio() {
        var empresa = $(".id_empresa").val();

        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/getDatos/' + empresa,
            method: 'GET',
            success: function(response) {
                console.log(response);

                // Cargar los detalles en el modal
                var contenido = "";
                for (let index = 0; index < response.predio_plantacion.length; index++) {
                    contenido =
                        '<option value="' + response.predio_plantacion[index].id_plantacion + '">' +
                        response.predio_plantacion[index].nombre_predio + ' | ' +
                        response.predio_plantacion[index].nombre + ' | Superficie: ' +
                        response.predio_plantacion[index].superficie + ' | Año: ' +
                        response.predio_plantacion[index].anio_plantacion + ' | ' +
                        response.predio_plantacion[index].num_plantas +
                        ' Plantas</option>' +

                        contenido;
                    // console.log(response.normas[index].norma);
                }

                if (response.predio_plantacion.length == 0) {
                    contenido = '<option value="">Sin predios registrados</option>';
                }
                $('.plantacion').html(contenido);
            },
            error: function() {
                //alert('Error al cargar los lotes a granel.');
            }
        });
    }
</script>
