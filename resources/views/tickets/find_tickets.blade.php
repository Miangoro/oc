@extends('layouts.layoutMaster')

@section('title', 'Tickets')

@section('vendor-style')
    <style>
        #filtroEmpresa+.select2-container .select2-selection__rendered,
        #filtroInstalacion+.select2-container .select2-selection__rendered {
            text-overflow: ellipsis !important;
            overflow: hidden !important;
            white-space: nowrap !important;
            min-width: 280px;
            max-width: 290px !important;
            font-size: 14px !important;
        }
    </style>
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss', 'resources/assets/vendor/libs/spinkit/spinkit.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js'])
@endsection

@section('page-script')
    <script>
        window.puedeAgregarElUsuario = @json(auth()->user()->can('Registrar tickets'));
        window.puedeEliminarElUsuario = @json(auth()->user()->can('Eliminar tickets'));
        window.puedeVerElUsuario = @json(auth()->user()->can('Seguir ticket'));
    </script>
    @vite(['resources/js/tickets.js'])
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Users List Table -->

    <div class="card">
        <!-- Filtros externos al DataTable -->


        <div class="card-header pb-0 mb-1">
            <h3 class="card-title mb-0">Gestión de Tickets</h3>
            <div class="row g-2 mt-3">
        <!-- Estado -->
        <div class="col-md-4">
            <label for="estado" class="form-label">Estado</label>
            <select id="estado" class="form-select select2">
                <option value="">Todos</option>
                <option value="Abierto">Abierto</option>
                <option value="Cerrado">Cerrado</option>
            </select>
        </div>

        <!-- Prioridad -->
        <div class="col-md-4">
            <label for="prioridad" class="form-label">Prioridad</label>
            <select id="prioridad" class="form-select select2">
                <option value="">Todas</option>
                <option value="Alta">Alta</option>
                <option value="Media">Media</option>
                <option value="Baja">Baja</option>
            </select>
        </div>

        <!-- Responsable -->
{{--         <div class="col-md-4">
            <label for="responsable" class="form-label">Responsable</label>
            <select id="responsable" class="form-select select2">
                <option value="">Todos</option>
            </select>
        </div> --}}
    </div>
        </div>
        <div class="card-datatable table-responsive ">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Folio</th>
                        <th>Asunto</th>
                        <th>Solicitante</th>
                        <th>Prioridad</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>




    <!-- Modal -->

    @include('_partials/_modals/modal-pdfs-frames')
    @include('_partials/_modals/modal_add_tickets')
     @include('_partials/_modals/modal_nuevo_ticket')
    @include('_partials/_modals/modalDetalleTicket')
    {{-- @include('_partials._modals.modal-add-firma-bitacoraMezcal') --}}
    <!-- /Modal -->

@endsection
