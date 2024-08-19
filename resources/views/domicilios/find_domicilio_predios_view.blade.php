@extends('layouts/layoutMaster')

@section('title', 'Domicilio Predios')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/js/domicilio_predios.js'])
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Predios</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Nombre Productor</th>
                        <th>Nombre Predio</th>
                        <th>Ubicación Predio</th>
                        <th>Tipo Predio</th>
                        <th>Puntos Referencia</th>
                        <th>Cuenta con Coordenadas</th>
                        <th>Superficie</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Modal para agregar nuevo predio -->
        <div class="modal fade" id="modalAddPredio" tabindex="-1" aria-labelledby="modalAddPredioLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modalAddPredioLabel" class="modal-title">Nuevo Predio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addNewPredioForm" method="POST">
                            @csrf
                            <!-- Select de Empresa Cliente -->
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="id_empresa" name="id_empresa" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona la empresa cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Empresa Cliente</label>
                            </div>

                            <!-- Nombre del Productor -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="nombre_productor"
                                            name="nombre_productor" placeholder="Nombre del productor">
                                        <label for="nombre_productor">Nombre del Productor</label>
                                    </div>
                                </div>

                                <!-- Nombre del Predio -->
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="nombre_predio" name="nombre_predio"
                                            placeholder="Nombre del predio">
                                        <label for="nombre_predio">Nombre del Predio</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Ubicación del Predio -->
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" id="ubicacion_predio" name="ubicacion_predio"
                                    placeholder="Ubicación del predio"></input>
                                <label for="ubicacion_predio">Ubicación del Predio</label>
                            </div>

                            <!-- Tipo de Predio y Puntos de Referencia -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" id="tipo_predio" name="tipo_predio"
                                            aria-label="Tipo de Predio">
                                            <option value="" disabled selected>Seleccione un tipo de predio</option>
                                            <option value="Comunal">Comunal</option>
                                            <option value="Ejidal">Ejidal</option>
                                            <option value="Propiedad privada">Propiedad privada</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                        <label for="tipo_predio">Tipo de Predio</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="puntos_referencia"
                                            name="puntos_referencia" placeholder="Puntos de referencia"></input>
                                        <label for="puntos_referencia">Puntos de Referencia</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Coordenadas -->
                            <div class="row mb-3">
                                <!-- ¿Cuenta con Coordenadas? -->
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" id="tiene_coordenadas" name="tiene_coordenadas"
                                            aria-label="¿Cuenta con coordenadas?" >
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                        <label for="tiene_coordenadas">¿Cuenta con Coordenadas?</label>
                                    </div>
                                </div>
                                <!-- Superficie del Predio -->
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" class="form-control" id="superficie" name="superficie"
                                            placeholder="Superficie del predio (Ha)" step="0.01">
                                        <label for="superficie">Superficie del Predio (Ha)</label>
                                    </div>
                                </div>
                            </div>

                            <div id="coordenadas" class="d-none mb-3">
                                <div class="card">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><button type="button" class="btn btn-primary add-row-cordenadas"><i
                                                            class="ri-add-line"></i></button></th>
                                                <th colspan="2">Coordenadas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-danger remove-row-cordenadas" disabled><i class="ri-delete-bin-5-fill"></i></button>
                                                </td>
                                                <td>
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="text" class="form-control" id="latitud"
                                                            name="latitud[]" placeholder="Latitud">
                                                        <label for="latitud">Latitud</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="text" class="form-control" id="longitud"
                                                            name="longitud[]" placeholder="Longitud">
                                                        <label for="longitud">Longitud</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="informacionAgave mb-3">
                                <!-- Información sobre el Agave/Maguey y Plantación combinada -->
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped mb-3" >
                                            <tr>
                                                <th><button type="button" class="btn btn-primary add-row-plantacion"><i class="ri-add-line"></i></button></th>
                                               <th colspan="2"><h5 class="card-title mb-0 text-center">Información del Agave/Maguey y Plantación</h5></th> 
                                            </tr>                                                       
                                        <tbody class="contenidoPlantacion">
                                            <tr>
                                                <td rowspan="4">
                                                    <!-- El botón de eliminar estará en cada fila que se agregue -->
                                                    <button type="button"
                                                        class="btn btn-danger remove-row-plantacion" disabled><i
                                                            class="ri-delete-bin-5-fill"></i></button>
                                                </td>
                                                <td>
                                                    <b>Nombre y Especie de Agave/Maguey</b>
                                                </td>
                                                <td>
                                                    <div class="form-floating form-floating-outline mb-3">
                                                        <select name="id_tipo[]" class="select2 form-select tipo_agave">
                                                            <option value="" disabled selected>Tipo de agave</option>
                                                            @foreach ($tipos as $tipo)
                                                                <option value="{{ $tipo->id_tipo }}">
                                                                    {{ $tipo->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                        <label for="especie_agave">Nombre y Especie de
                                                            Agave/Maguey</label>
                                                    </div>
                                                </td>
                                            </tr >
                                            <tr>
                                                <td>
                                                    <b>Número de Plantas</b>
                                                </td>
                                                <td>
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="number" class="form-control"
                                                            name="numero_plantas[]" placeholder="Número de plantas"
                                                            step="1">
                                                        <label for="numero_plantas">Número de Plantas</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Edad de la Plantación</b>
                                                </td>
                                                    <td>
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="number" class="form-control"
                                                            name="edad_plantacion[]"
                                                            placeholder="Edad de la plantación (años)" step="1">
                                                        <label for="edad_plantacion">Edad de la Plantación</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Tipo de Plantación</p>
                                                </td>
                                                <td>
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="text" class="form-control"
                                                            name="tipo_plantacion[]" placeholder="Tipo de plantación">
                                                        <label for="tipo_plantacion">Tipo de Plantación</label>
                                                    </div>
                                                </td>
                                            </tr>

                                            
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary me-2">Registrar</button>
                                <button type="reset" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


{{--  modal de edicion equisde --}}
        <!-- Modal para agregar nuevo predio -->
        <div class="modal fade" id="modalEditPredio" tabindex="-1" aria-labelledby="modalAddPredioLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modalAddPredioLabel" class="modal-title">Editar Predio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addEditPredioForm">
                            @csrf
                            <input type="hidden" id="edit_id_predio" name="id_predio" value="">
                            <!-- Select de Empresa Cliente -->
                            <div class="form-floating form-floating-outline mb-4">
                                <select id="edit_id_empresa" name="id_empresa" class="select2 form-select">
                                    <option value="" disabled selected>Selecciona la empresa cliente</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}</option>
                                    @endforeach
                                </select>
                                <label for="id_empresa">Empresa Cliente</label>
                            </div>

                            <!-- Nombre del Productor -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="edit_nombre_productor"
                                            name="nombre_productor" placeholder="Nombre del productor" >
                                        <label for="nombre_productor">Nombre del Productor</label>
                                    </div>
                                </div>

                                <!-- Nombre del Predio -->
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="edit_nombre_predio" name="nombre_predio"
                                            placeholder="Nombre del predio" >
                                        <label for="nombre_predio">Nombre del Predio</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Ubicación del Predio -->
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" id="edit_ubicacion_predio" name="ubicacion_predio"
                                    placeholder="Ubicación del predio" ></input>
                                <label for="ubicacion_predio">Ubicación del Predio</label>
                            </div>
                            <!-- Tipo de Predio y Puntos de Referencia -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" id="edit_tipo_predio" name="tipo_predio"
                                            aria-label="Tipo de Predio">
                                            <option value="" disabled selected>Seleccione un tipo de predio</option>
                                            <option value="Comunal">Comunal</option>
                                            <option value="Ejidal">Ejidal</option>
                                            <option value="Propiedad privada">Propiedad privada</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                        <label for="tipo_predio">Tipo de Predio</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="edit_puntos_referencia"
                                            name="puntos_referencia" placeholder="Puntos de referencia"></input>
                                        <label for="puntos_referencia">Puntos de Referencia</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Coordenadas -->
                            <div class="row mb-3">
                                <!-- ¿Cuenta con Coordenadas? -->
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" id="edit_tiene_coordenadas" name="tiene_coordenadas"
                                            aria-label="¿Cuenta con coordenadas?">
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                        <label for="tiene_coordenadas">¿Cuenta con Coordenadas?</label>
                                    </div>
                                </div>
                                <!-- Superficie del Predio -->
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="number" class="form-control" id="edit_superficie" name="superficie"
                                            placeholder="Superficie del predio (Ha)" step="0.01">
                                        <label for="superficie">Superficie del Predio (Ha)</label>
                                    </div>
                                </div>
                            </div>

                            <div id="edit_coordenadas" class="d-none mb-3">
                                <div class="card">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th><button type="button" class="btn btn-primary add-row-cordenadas"><i
                                                            class="ri-add-line"></i></button></th>
                                                <th colspan="2">Coordenadas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-danger remove-row-cordenadas" disabled><i class="ri-delete-bin-5-fill"></i></button>
                                                </td>
                                                <td>
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="text" class="form-control" id="edit_latitud"
                                                            name="latitud[]" placeholder="Latitud">
                                                        <label for="latitud">Latitud</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="text" class="form-control" id="edit_longitud"
                                                            name="longitud[]" placeholder="Longitud">
                                                        <label for="longitud">Longitud</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="edit_InformacionAgave mb-3">
                                <!-- Información sobre el Agave/Maguey y Plantación combinada -->
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped mb-3" >
                                            <tr>
                                                <th><button type="button" class="btn btn-primary add-row-plantacion"><i class="ri-add-line"></i></button></th>
                                               <th colspan="2"><h5 class="card-title mb-0 text-center">Información del Agave/Maguey y Plantación</h5></th> 
                                            </tr>                                                       
                                        <tbody class="edit_ContenidoPlantacion">
                                            <tr>
                                                <td rowspan="4">
                                                    <!-- El botón de eliminar estará en cada fila que se agregue -->
                                                    <button type="button"
                                                        class="btn btn-danger remove-row-plantacion" disabled><i
                                                            class="ri-delete-bin-5-fill"></i></button>
                                                </td>
                                                <td>
                                                    <b>Nombre y Especie de Agave/Maguey</b>
                                                </td>
                                                <td>
                                                    <div class="form-floating form-floating-outline mb-3">
                                                        <select id="edit_id_tipo" name="id_tipo[]" class="select2 form-select tipo_agave">
                                                            <option value="" disabled selected>Tipo de agave</option>
                                                            @foreach ($tipos as $tipo)
                                                                <option value="{{ $tipo->id_tipo }}">
                                                                    {{ $tipo->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                        <label for="especie_agave">Nombre y Especie de
                                                            Agave/Maguey</label>
                                                    </div>
                                                </td>
                                            </tr >
                                            <tr>
                                                <td>
                                                    <b>Número de Plantas</b>
                                                </td>
                                                <td>
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="number" class="form-control" id="edit_numero_plantas"
                                                            name="numero_plantas[]" placeholder="Número de plantas"
                                                            step="1">
                                                        <label for="numero_plantas">Número de Plantas</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <b>Edad de la Plantación</b>
                                                </td>
                                                    <td>
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="number" class="form-control" id="edit_edad_plantacion"
                                                            name="edad_plantacion[]"
                                                            placeholder="Edad de la plantación (años)" step="1">
                                                        <label for="edad_plantacion">Edad de la Plantación</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Tipo de Plantación</p>
                                                </td>
                                                <td>
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="text" class="form-control" id="edit_tipo_plantacion"
                                                            name="tipo_plantacion[]" placeholder="Tipo de plantación">
                                                        <label for="tipo_plantacion">Tipo de Plantación</label>
                                                    </div>
                                                </td>
                                            </tr>               
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                                <button type="reset" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- Convertir tipos en una variable JavaScript -->
    <script>
        var tiposAgave = @json($tipos);
    </script>
    <!-- Modal -->
    @include('_partials/_modals/modal-pdfs-frames')
    <!-- /Modal -->
@endsection
