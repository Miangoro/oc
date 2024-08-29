@extends('layouts.layoutMaster')

@section('title', 'Certificados Instalaciones')

@section('vendor-style')
@vite([
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    'resources/assets/vendor/libs/animate-css/animate.scss',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    'resources\assets\vendor\libs\bootstrap-datepicker\bootstrap-datepicker.scss'
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
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
    'resources/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js'
])
@endsection

@section('page-script')
@vite(['resources/js/certificados_instalaciones.js'])
@endsection


@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Users List Table -->
<div class="card">
    <div class="card-header pb-0">
        <h3 class="card-title mb-0">Certificados Instalaciones</h3>
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-dark">
                <tr>
                  <th></th>
                    <th>ID</th>
                    <th>No. Dictamen</th>
                    <th>No. Certificado</th>
                    <th>Maestro Mezcalero</th>
                    <th>No. Autorizacion</th>
                    <th>Fecha de Vigencia</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Certificado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- Modal para agregar nuevo certificado -->
<div class="modal fade" id="addCertificadoModal" tabindex="-1" aria-labelledby="addCertificadoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCertificadoModalLabel">Agregar Certificado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCertificadoForm">
                    @csrf
                    <!-- Campos del formulario aquí -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select select2" id="id_dictamen" name="id_dictamen" aria-label="No. Dictamen" required>
                            <option value="" disabled selected>Seleccione un dictamen</option>
                            @foreach($dictamenes as $dictamen)
                                <option value="{{ $dictamen->id_dictamen }}" data-tipo-dictamen="{{ $dictamen->tipo_dictamen }}">{{ $dictamen->num_dictamen }}</option>
                            @endforeach
                        </select>
                        <label for="id_dictamen">No. Dictamen</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="numero_certificado" placeholder="No. de Certificado" name="num_certificado" aria-label="No. de Certificado" required>
                        <label for="numero_certificado">No. de Certificado</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-3" id="maestroMezcaleroContainer" style="display: none;">
                        <input type="text" class="form-control" id="maestro_mezcalero" placeholder="Maestro Mezcalero" name="maestro_mezcalero" aria-label="Maestro Mezcalero">
                        <label for="maestro_mezcalero">Maestro Mezcalero</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="no_autorizacion" placeholder="No. de Autorización" name="num_autorizacion" aria-label="No. de Autorización" required>
                        <label for="no_autorizacion">No. de Autorización</label>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="form-floating form-floating-outline flex-fill me-2">
                            <input class="form-control datepicker" id="fecha_vigencia"  placeholder="yyyy-mm-dd" name="fecha_vigencia" aria-label="Fecha de Vigencia" required>
                            <label for="fecha_vigencia">Fecha de Inicio Vigencia</label>
                        </div>
                        <div class="form-floating form-floating-outline flex-fill ms-2">
                            <input class="form-control datepicker" id="fecha_vencimiento"  placeholder="yyyy-mm-dd" name="fecha_vencimiento" aria-label="Fecha de Vencimiento" required>
                            <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">Registrar</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="editCertificadoModal" tabindex="-1" aria-labelledby="editCertificadoModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCertificadoModalLabel">Editar Certificado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCertificadoForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id_certificado" name="id_certificado">
                    
                    <!-- Campo para Dictamen -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select select2" id="edit_id_dictamen" name="id_dictamen" aria-label="No. Dictamen" required>
                            <option value="" disabled selected>Seleccione un dictamen</option>
                            @foreach($dictamenes as $dictamen)
                                <option value="{{ $dictamen->id_dictamen }}" data-tipo-dictamen="{{ $dictamen->tipo_dictamen }}">{{ $dictamen->num_dictamen }}</option>
                            @endforeach
                        </select>
                        <label for="edit_id_dictamen">No. Dictamen</label>
                    </div>

                    <!-- Campo para Número de Certificado -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="edit_numero_certificado" placeholder="No. de Certificado" name="num_certificado" aria-label="No. de Certificado" required>
                        <label for="edit_numero_certificado">No. de Certificado</label>
                    </div>

                    <!-- Campo para Maestro Mezcalero -->
                    <div id="edit_maestroMezcaleroContainer" class="form-floating form-floating-outline mb-3">
                        <input type="text" class="form-control" id="edit_maestro_mezcalero" placeholder="Maestro Mezcalero" name="maestro_mezcalero" aria-label="Maestro Mezcalero">
                        <label for="edit_maestro_mezcalero">Maestro Mezcalero</label>
                    </div>

                    <!-- Campo para Número de Autorización -->
                    <div class="form-floating form-floating-outline mb-3">
                         <input type="text" class="form-control" id="edit_no_autorizacion" placeholder="No. de Autorización" name="num_autorizacion" aria-label="No. de Autorización" required>
                         <label for="edit_no_autorizacion">No. de Autorización</label>
                    </div>

                    <!-- Campos para Fechas -->
                    <div class="d-flex justify-content-between mb-3">
                        <div class="form-floating form-floating-outline flex-fill me-2">
                            <input type="text" class="form-control datepicker" id="edit_fecha_vigencia" placeholder="yyyy-mm-dd" name="fecha_vigencia" aria-label="Fecha de Vigencia" required>
                            <label for="edit_fecha_vigencia">Fecha de Inicio Vigencia</label>
                        </div>
                        <div class="form-floating form-floating-outline flex-fill ms-2">
                            <input type="text" class="form-control datepicker" id="edit_fecha_vencimiento" placeholder="yyyy-mm-dd" name="fecha_vencimiento" aria-label="Fecha de Vencimiento" required>
                            <label for="edit_fecha_vencimiento">Fecha de Vencimiento</label>
                        </div>
                    </div>

                    <!-- Botones del Formulario -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">Actualizar</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</div>

<!-- Modal -->
@include('_partials/_modals/modal-pdfs-frames')
<!-- /Modal -->

@endsection

