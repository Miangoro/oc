@extends('layouts.layoutMaster')

@section('title', 'Catálogo Instalaciones')

@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/animate-css/animate.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

@section('vendor-script')
@vite([
    'resources/assets/vendor/libs/moment/moment.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    'resources/assets/vendor/libs/cleavejs/cleave.js',
    'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

@section('page-script')
@vite(['resources/js/instalaciones.js'])
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Users List Table -->
<div class="card">
    <div class="card-header pb-0">
        <h3 class="card-title mb-0">Instalaciones</h3>
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Dirección</th>
                    <th>Folio</th>
                    <th>Organismo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Modal para agregar nueva instalación -->
    <div class="modal fade" id="modalAddInstalacion" tabindex="-1" aria-labelledby="modalAddInstalacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalAddInstalacionLabel" class="modal-title">Nueva Instalación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="add-new-user pt-0" id="addNewInstalacionForm" enctype="multipart/form-data">
                        @csrf

                        <!-- Select de Clientes -->
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="form-select" id="cliente" name="id_empresa" aria-label="Cliente" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->razon_social }}</option>
                                @endforeach
                            </select>
                            <label for="cliente">Cliente</label>
                        </div>

                        <!-- Select de Tipo de Instalación -->
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="form-select" id="tipo" name="tipo" aria-label="Tipo de Instalación" required>
                                <option value="">Seleccione un tipo de instalación</option>
                                <option value="productora">Productora</option>
                                <option value="envasadora">Envasadora</option>
                                <option value="comercializadora">Comercializadora</option>
                            </select>
                            <label for="tipo">Tipo de Instalación</label>
                        </div>

                        <!-- Input de Estado -->
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="form-select" id="estado" name="estado" aria-label="Estado" required>
                                <option value="">Seleccione un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                            <label for="estado">Estado</label>
                        </div>

                        <!-- Input de Dirección Completa -->
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="direccion" placeholder="Ingrese la dirección completa" name="direccion_completa" aria-label="Dirección Completa" required>
                            <label for="direccion">Dirección Completa</label>
                        </div>

                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Registrar</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('_partials._modals.modal-pdfs-frames')
    <!-- /Modal -->

</div>
@endsection
