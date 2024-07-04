@extends('layouts/layoutMaster')

@section('title', 'Catalogo Marcas')

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
    @vite(['resources/js/control_marcas.js'])
@endsection

@section('content')

    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Control de Marcas</h3>
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
                        <th>Formato de solicitud</th>
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
                    <!-- muestra clientes tipo2 -->
                    <div class="form-floating form-floating-outline mb-5">
                        <select id="cliente" name="cliente" class="select2 form-select">
                            <option value="">Selecciona cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id_empresa }}">{{ $cliente->razon_social }}</option>
                            @endforeach
                        </select>
                        <label for="cliente">Cliente</label>
                    </div>

                    

                    <!-- nombre marcas -->
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" id="add-user-company" name="company" class="form-control"
                            placeholder="Web Developer" aria-label="jdoe1" />
                        <label for="add-user-company">Nombre de la marca</label>
                    </div>
                    
                    <!-- muestra nombre marcas -->
                    <div class="form-floating form-floating-outline mb-5">
                        <select id="marca-nombre" name="marca" class="select2 form-select">
                            <option value="">Nombre de la marca</option>
                            @foreach ($opciones as $opcion)
                                <option value="{{ $opcion->id_marca }}">{{ $opcion->marca }}</option>
                            @endforeach
                        </select>
                        <label for="marca-nombre">Marca</label>
                    </div>
               <!-- folio -->
               <div class="form-floating form-floating-outline mb-5">
                <input type="text" id="add-user-company" name="company" class="form-control"
                    placeholder="Web Developer" aria-label="jdoe1" />
                <label for="add-user-company">Folio</label>
            </div>

                    <!-- Campo para subir PDF -->
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="file" id="formato_pdf" name="formato_pdf" class="form-control"
                            aria-label="PDF Formato">
                        <label for="formato_pdf">Formato de solicitud (PDF)</label>
                    </div>
                    <!-- Campo para seleccionar fecha de vigencia -->
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" id="vigencia" name="vigencia" class="form-control" placeholder="YYYY-MM-DD"
                            aria-label="Fecha de Vigencia" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                        <label for="vigencia">Fecha de vigencia</label>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>


                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('_partials/_modals/modal-pdfs-frames')
    <!-- /Modal -->
@endsection
