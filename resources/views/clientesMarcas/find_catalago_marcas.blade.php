@extends('layouts/layoutMaster')

@section('title', 'Marcas')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Page Scripts -->
@section('page-script')
    @vite(['resources/js/catalogo_marcas.js'])
@endsection

@section('content')


    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Marcas</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <!-- tablas a visualizar -->

                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Folio</th>
                        <th>Marca</th>
                        <th>Clientes</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- Offcanvas to add new user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form class="add-new-user pt-0" id="addNewUserForm">
                    <input type="hidden" name="id" id="user_id">
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="add-user-fullname" placeholder="A-B-C-D..."
                            name="name" aria-label="John Doe" />
                        <label for="add-user-fullname">Folio</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" id="add-user-email" class="form-control" placeholder="Ingrese la marca"
                            aria-label="john.doe@example.com" name="email" />
                        <label for="add-user-email">Marca</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <select id="user-plan" class="form-select">
                            <option value="">Selecciona un cliente</option>
                        </select>
                        <label for="user-plan">Selecciona un cliente</label>
                    </div>


                    <!-- Boton para el modal del pdf y datepicker -->
                    <div class="text-center mb-5 mt-5">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#uploadModal">Subir Archivos</button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadModalLabel">Subir Archivos</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" enctype="multipart/form-data">
                                        @csrf
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="file{{ $i }}" class="form-label">Subir archivo
                                                        *</label>
                                                    <input class="form-control" type="file" id="file{{ $i }}"
                                                        name="files[]">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="date{{ $i }}" class="form-label">Fecha de
                                                        vigencia *</label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control datepicker"
                                                            id="date{{ $i }}" name="dates[]">
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Subir</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Registrar</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('_partials/_modals/modal-pdfs-frames')
    <!-- /Modal -->
@endsection
