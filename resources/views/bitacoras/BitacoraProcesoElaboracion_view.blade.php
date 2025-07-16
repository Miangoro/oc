@extends('layouts.layoutMaster')

@section('title', 'Bitácora Proceso de Elaboracion')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.scss', 'resources/assets/vendor/libs/spinkit/spinkit.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js'])
@endsection

@section('page-script')
    <script>
        window.puedeAgregarElUsuario = @json(auth()->user()->can('Registrar bitácoras'));
        window.puedeEditarElUsuario = @json(auth()->user()->can('Editar bitácoras'));
        window.puedeEliminarElUsuario = @json(auth()->user()->can('Eliminar bitácoras'));
        window.puedeFirmarElUsuario = @json(auth()->user()->can('Firmar bitácoras'));
        window.tipoUsuario = {{ auth()->user()->tipo }};
        const opcionesEmpresas = `{!! collect($empresas)->map(function ($e) {
                $num = $e->empresaNumClientes[0]->numero_cliente ?? ($e->empresaNumClientes[1]->numero_cliente ?? '');
                return "<option value='{$e->id_empresa}'>{$num} | {$e->razon_social}</option>";
            })->implode('') !!}`;
    </script>
    @vite(['resources/js/bitacora_proceso_elaboracion.js'])
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Proceso de Elaboración de mezcal (Productor artesanal)</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th></th> {{-- Responsive control --}}
                        <th>#</th>
                        <th>Fecha ingreso</th>
                        <th>Cliente</th>
                        <th>N° Tapada</th>
                        <th>Lote Granel</th>
                        <th>N° Guía</th>
                        <th>Tipo Maguey</th>
                        <th>N° Piñas</th>
                        <th>Kg Maguey</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
    </div>


    <!-- Modal -->
    @include('_partials/_modals/modal-pdfs-frames')
    @include('_partials/_modals/modal-add-bitacoraProcesoElaboracion')
    @include('_partials._modals.modal-edit-bitacoraProcesoElaboracion')
    <!-- /Modal -->

@endsection
