@extends('layouts/layoutMaster')

@section('title', 'Documentos de referencia')

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
    <script>
        window.puedeAgregarElUsuario = @json(auth()->user()->can('Registrar clases de mezcal'));
        window.puedeEditarElUsuario = @json(auth()->user()->can('Editar clases de mezcal'));
        window.puedeEliminarElUsuario = @json(auth()->user()->can('Eliminar clases de mezcal'));
    </script>
    @vite(['resources/js/documentos_calidad.js'])
@endsection

@section('content')

    {{-- <meta name="csrf-token" content="{{ csrf_token() }}">
 --}}
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Documentos de referencia</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Archivo</th>
                        <th>Identificación</th>
                        <th>Nombre del documento</th>
                        <th>Estatus</th>
                        <th>Versiones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Modal Registrar Documento -->
        <div class="modal fade" id="modalAddDoc" tabindex="-1" aria-labelledby="modalAddDocLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header bg-primary pb-4">
                        <h5 class="modal-title text-white" id="modalAddDocLabel">Registrar Documentos de referencia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body py-8">
                        <form id="formAddDoc" enctype="multipart/form-data">
                            @csrf

                            {{-- <div class="card mb-4 border rounded">
            <div class="badge rounded-2 bg-label-primary fw-bold fs-6 px-4 py-4 mb-5">
              DATOS DEL DOCUMENTO
            </div> --}}
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Nombre -->
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="doc_nombre" name="nombre"
                                                placeholder="Sistema de gestión" required>
                                            <label for="doc_nombre">Nombre del documento</label>
                                        </div>
                                    </div>

                                    <!-- Identificación -->
                                    <div class="col-md-3">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="doc_identificacion"
                                                name="identificacion" placeholder="SGC-01" required>
                                            <label for="doc_identificacion">Identificación</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-floating form-floating-outline">
                                            <select class="form-select" id="area" name="area">
                                                <option value="">Seleccione el tipo</option>
                                                <option value="1">UI</option>
                                                <option value="2">OC</option>
                                            </select>
                                            <label for="Area">Area</label>
                                        </div>
                                    </div>

                                    <!-- Edición -->
                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="doc_edicion" name="edicion"
                                                placeholder="0" required>
                                            <label for="doc_edicion">Edición</label>
                                        </div>
                                    </div>

                                    <!-- Fecha -->
                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline">
                                            <input type="date" class="form-control" id="doc_fecha" name="fecha_edicion"
                                                required>
                                            <label for="doc_fecha">Fecha de edición</label>
                                        </div>
                                    </div>

                                    <!-- Estatus -->
                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline">
                                            <select class="form-select" id="doc_estatus" name="estatus">
                                                <option value="">Seleccione</option>
                                                <option value="Vigente">Vigente</option>
                                                <option value="Obsoleto">Obsoleto</option>
                                                <option value="Descontinuado">Descontinuado</option>
                                            </select>
                                            <label for="doc_estatus">Estatus</label>
                                        </div>
                                    </div>


                                    <!-- Archivo -->
                                    <div class="col-md-12">
                                        <div class="form-floating form-floating-outline">

                                            <input class="form-control" type="file" id="doc_archivo" name="archivo"
                                                required>
                                            <label for="doc_archivo">Archivo</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="doc_modifico" name="modifico"
                                                placeholder="Administrador CIDAM" value="{{ $tipo_usuario }}" readonly>
                                            <label for="doc_modifico">Modificó</label>
                                        </div>
                                    </div>

                                    <!-- Revisó -->
                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline">
                                            <select class="select2 form-select" id="doc_reviso" name="reviso" required>
                                                <option value="">Seleccione un usuario</option>
                                                @foreach ($usuarios as $usuario)
                                                    <option value="{{ $usuario->id }}">
                                                        {{ $usuario->name }} ({{ $usuario->puesto }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="doc_reviso">Revisó</label>
                                        </div>
                                    </div>

                                    <!-- Aprobó -->
                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline">
                                            <select class="select2 form-select" id="doc_aprobo" name="aprobo" required>
                                                <option value="">Seleccione un usuario</option>
                                                @foreach ($usuarios as $usuario)
                                                    <option value="{{ $usuario->id }}">
                                                        {{ $usuario->name }} ({{ $usuario->puesto }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="doc_aprobo">Aprobó</label>
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-center">
                                <button disabled class="btn btn-primary me-2 d-none" type="button" id="loadingDoc">
                                    <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                                    Registrando...
                                </button>
                                <button type="submit" class="btn btn-primary me-2" id="btnRegistrarDoc">
                                    <i class="ri-add-line me-1"></i> Registrar
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    <i class="ri-close-line me-1"></i> Cancelar
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <!-- Offcanvas para editar -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="editClase">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title">Editar Clase</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                @csrf
                <form class="edit-class-form pt-0" id="editClassForm" method="POST">
                    <input type="hidden" name="id_clase" id="edit_clase_id" value="">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="edit_clase_nombre"
                            placeholder="Nombre de la clase" name="edit_clase" aria-label="clase" required>
                        <label for="edit_clase_nombre">Nombre de la clase</label>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Confirmar</button>
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="offcanvas">Cancelar</button>
                </form>
            </div>
        </div>




    </div>

    <!-- Modal -->
    @include('_partials/_modals/modal-pdfs-frames')
    <!-- /Modal -->
@endsection
