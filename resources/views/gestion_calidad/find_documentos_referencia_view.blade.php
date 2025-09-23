@extends('layouts/layoutMaster')

@section('title', 'Documentos de referencia')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/spinkit/spinkit.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js',
  'resources/assets/vendor/libs/flatpickr/l10n/es.js'])
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
    @include('_partials/_modals/modal_add_documentos_referencia')
    @include('_partials/_modals/modal_edit_documentos_referencia')
    <!-- /Modal -->
@endsection
