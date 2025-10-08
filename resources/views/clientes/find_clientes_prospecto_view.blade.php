@extends('layouts/layoutMaster')

@section('title', 'Clientes prospecto')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/spinkit/spinkit.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
    <style>
        .opaco {
            /*     opacity: 0.5;
        transition: opacity 0.3s ease; */
            opacity: 0.5;
            cursor: pointer;
        }
    </style>
@endsection

<!-- Page Scripts -->
@section('page-script')
    <script>
        window.puedeAgregarUsuario = @json(auth()->user()->can('Registrar clientes'));
        window.puedeEditarUsuario = @json(auth()->user()->can('Editar clientes'));
        window.puedeEliminarUsuario = @json(auth()->user()->can('Eliminar clientes'));
    </script>
    @vite(['resources/js/clientes_prospecto.js'])
@endsection


@section('content')


    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0y">
            <h3 class="card-title mb-0">Clientes prospecto</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Cliente</th>
                        <th>Domicilio fiscal</th>
                        <th>Régimen</th>
                        <th>Norma</th>
                        <th>Formato de solicitud</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>


        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasValidarSolicitud"
            aria-labelledby="offcanvasValidarSolicitudLabel">
            <div class="offcanvas-header border-bottom bg-primary pb-4">
                <h5 id="offcanvasValidarSolicitudLabel" class="offcanvas-title text-white">Validar solicitud</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form class="add-new-user pt-0" id="addNewUserForm">
                    <input type="hidden" name="id_empresa" id="empresa_id">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <span class="card-title">Se cuenta con todos los medios para realizar todas las
                                        actividades de evaluación para la
                                        Certificación</span>
                                    <p>
                                        <label>
                                            <input name="medios" type="radio" value="Si" />
                                            <span><strong>Sí</strong></span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input name="medios" type="radio" value="No" />
                                            <span><strong>No</strong></span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 pt-5">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <span class="card-title">El organismo de Certificación tiene la competencia para
                                        realizar la Certificación:</span>
                                    <p>
                                        <label>
                                            <input name="competencia" type="radio" value="Si" />
                                            <span><strong>Sí</strong></span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input name="competencia" type="radio" value="No" />
                                            <span><strong>No</strong></span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 pt-5">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <span class="card-title">El organismo de Certificación tiene la capacidad para llevar a
                                        cabo las actividades de
                                        certificación.</span>
                                    <p>
                                        <label>
                                            <input name="capacidad" type="radio" value="Si" />
                                            <span><strong>Sí</strong></span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                            <input name="capacidad" type="radio" value="So" />
                                            <span><strong>No</strong></span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating form-floating-outline mb-6 mt-5">
                            <textarea name="comentarios" class="form-control h-px-100" id="exampleFormControlTextarea1"
                                placeholder="Comentarios aquí..."></textarea>
                            <label for="exampleFormControlTextarea1">Comentarios</label>
                        </div>


                    </div>
                    <div class="col-12 mt-6 d-flex flex-wrap justify-content-center gap-4 row-gap-4">
                        <button disabled class="btn btn-primary me-1 d-none" type="button"
                            id="btnSpinnerV">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Validando...
                        </button>
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit" id="btnAddV"><i
                                class="ri-search-eye-line me-1"></i>Valiar</button>
                        {{-- <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button> --}}
                        <button type="reset" class="btn btn-danger " data-bs-dismiss="offcanvas" aria-label="Close"><i
                                class="ri-close-line me-1"></i> Cancelar</button>
                    </div>

                </form>
            </div>
        </div>

    </div>




    <!-- Modal -->
    @include('_partials/_modals/modal-pdfs-frames')
    @include('_partials/_modals/modal-add-aceptar-cliente')
    @include('_partials/_modals/modal_add_clientes_prospectos')
    @include('_partials/_modals/modal-edit-cliente-prospecto')
    @include('_partials._modals.modal_add_documentacion_clientes_prospectos')
    <!-- /Modal -->
@endsection



<script>
    function abrirModal(id_empresa) {
        // Hacer una petición AJAX para obtener los detalles de la empresa
        $.ajax({
            url: '/lista_empresas/' + id_empresa,
            method: 'GET',
            success: function(response) {
                // Cargar los detalles en el modal
                var contenido = "";

                for (let index = 0; index < response.normas.length; index++) {
                    contenido = '<input value="' + response.normas[index].id_norma +
                        '" type="hidden" name="id_norma[]"/><div class="col-12 col-md-12 col-sm-12"><div class="form-floating form-floating-outline"><input type="text" id="numero_cliente' +
                        response.normas[index].id_norma +
                        '" name="numero_cliente[]" class="form-control" placeholder="Introducir el número de cliente" /><label for="modalAddressFirstName">Número de cliente para la norma ' +
                        response.normas[index].norma + '</label></div></div><br>' + contenido;
                }


                $('.contenido').html(contenido);
                // Abrir el modal
                $('#aceptarCliente').modal('show');
            },
            error: function() {
                alert('Error al cargar los detalles de la empresa.');
            }
        });
    }
</script>
