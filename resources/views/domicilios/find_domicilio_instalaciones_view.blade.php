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
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const certificacionSelectAdd = document.getElementById('certificacion');
    const certificadoOtrosDivAdd = document.getElementById('certificado-otros');

    const certificacionSelectEdit = document.getElementById('edit_certificacion');
    const certificadoOtrosDivEdit = document.getElementById('edit_certificado_otros');

    const tipoSelectAdd = document.getElementById('tipo');
    const modalAddInstalacion = document.getElementById('modalAddInstalacion');

    // Función para mostrar/ocultar el menú adicional
    function toggleCertificadoOtros(selectElement, divElement) {
      if (selectElement.value === 'otro_organismo') {
        divElement.classList.remove('d-none');
      } else {
        divElement.classList.add('d-none');
      }
    }

    // Manejar el cambio en el select de tipo de certificación al agregar
    certificacionSelectAdd.addEventListener('change', function () {
      toggleCertificadoOtros(certificacionSelectAdd, certificadoOtrosDivAdd);
    });

    // Manejar el cambio en el select de tipo de certificación al editar
    certificacionSelectEdit.addEventListener('change', function () {
      toggleCertificadoOtros(certificacionSelectEdit, certificadoOtrosDivEdit);
    });

    // Reiniciar el select de tipo de instalación y ocultar los campos adicionales al cerrar el modal
    modalAddInstalacion.addEventListener('hidden.bs.modal', function () {
      tipoSelectAdd.value = ''; // Reinicia el select al valor por defecto
      $(tipoSelectAdd).trigger('change'); // Notifica a Select2 que se ha cambiado el valor

      // Ocultar los campos adicionales
      certificadoOtrosDivAdd.classList.add('d-none');
    });
  });
  </script>
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
                    <th>Fecha Emision</th>
                    <th>Fecha Vigencia</th>
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
                    <form id="addNewInstalacionForm">
                        @csrf

                        <div class="form-floating form-floating-outline mb-4">
                            <select id="id_empresa" name="id_empresa" class="select2 form-select" required>
                                <option value="" disabled selected>Selecciona la empresa</option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}</option>
                                @endforeach
                            </select>
                            <label for="id_empresa">Empresa</label>
                        </div>

                        <!-- Select de Tipo de Instalación -->
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="select2 form-select" id="tipo" name="tipo" aria-label="Tipo de Instalación" required>
                                <option value="">Seleccione un tipo de instalación</option>
                                <option value="productora">Productora</option>
                                <option value="envasadora">Envasadora</option>
                                <option value="comercializadora">Comercializadora</option>
                            </select>
                            <label for="tipo">Tipo de Instalación</label>
                        </div>

                        <!-- Input de Estado -->
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="select2 form-select" id="estado" name="estado" data-placeholder="Seleccione un estado" aria-label="Estado" required>
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

                        <!-- Select de Tipo de Certificación -->
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="form-select" id="certificacion" name="certificacion" aria-label="Tipo de Certificación" required>
                                <option value="">Seleccione el tipo de certificación</option>
                                <option value="oc_cidam">Certificación por OC CIDAM</option>
                                <option value="otro_organismo">Certificado por otro organismo</option>
                            </select>
                            <label for="certificacion">Tipo de Certificación</label>
                        </div>

                        <!-- Campos adicionales para "Certificado por otro organismo" -->
                        <div id="certificado-otros" class="d-none">
                            <div class="col-md-12 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control form-control-sm" type="file" id="file-127" name="url[]">
                                    <input value="127" class="form-control" type="hidden" name="id_documento[]">
                                    <input value="Certificado de instalaciones" class="form-control" type="hidden" name="nombre_documento[]">
                                    <label for="certificado_instalaciones">Adjuntar Certificado de instalaciones</label>
                                </div>
                            </div>

                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" id="folio" placeholder="Folio/Número del certificado" name="folio" aria-label="Folio/Número del certificado">
                                <label for="folio_certificado">Folio/Número del certificado</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-3">
                                <select class="form-select" id="id_organismo" name="id_organismo" data-placeholder="Seleccione un organismo de certificación" aria-label="Organismo de Certificación">
                                    <option value="">Seleccione un organismo de certificación</option>
                                    @foreach($organismos as $organismo)
                                        <option value="{{ $organismo->id_organismo }}">{{ $organismo->organismo }}</option>
                                    @endforeach
                                </select>
                                <label for="id_organismo">Organismo de Certificación</label>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" aria-label="Fecha de Emisión">
                                        <label for="fecha_emision">Fecha de Emisión</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" class="form-control" id="fecha_vigencia" name="fecha_vigencia" aria-label="Fecha de Vigencia">
                                        <label for="fecha_vigencia">Fecha de Vigencia</label>
                                    </div>
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

    <!-- Modal para editar instalación -->
    <div class="modal fade" id="modalEditInstalacion" tabindex="-1" aria-labelledby="modalEditInstalacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modalEditInstalacionLabel" class="modal-title">Editar Instalación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editInstalacionForm">
                        @csrf

                        <div class="form-floating form-floating-outline mb-4">
                            <select id="edit_id_empresa" name="id_empresa" class="select2 form-select" required>
                                <option value="" disabled selected>Selecciona la empresa</option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id_empresa }}">{{ $empresa->razon_social }}</option>
                                @endforeach
                            </select>
                            <label for="edit_id_empresa">Empresa</label>
                        </div>

                        <!-- Select de Tipo de Instalación -->
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="select2 form-select" id="edit_tipo" name="tipo" aria-label="Tipo de Instalación" required>
                                <option value="">Seleccione un tipo de instalación</option>
                                <option value="productora">Productora</option>
                                <option value="envasadora">Envasadora</option>
                                <option value="comercializadora">Comercializadora</option>
                            </select>
                            <label for="edit_tipo">Tipo de Instalación</label>
                        </div>

                        <!-- Input de Estado -->
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="select2 form-select" id="edit_estado" name="estado" data-placeholder="Seleccione un estado" aria-label="Estado" required>
                                <option value="">Seleccione un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                @endforeach
                            </select>
                            <label for="edit_estado">Estado</label>
                        </div>

                        <!-- Input de Dirección Completa -->
                        <div class="form-floating form-floating-outline mb-3">
                            <input type="text" class="form-control" id="edit_direccion" placeholder="Ingrese la dirección completa" name="direccion_completa" aria-label="Dirección Completa" required>
                            <label for="edit_direccion">Dirección Completa</label>
                        </div>

                        <!-- Select de Tipo de Certificación -->
                        <div class="form-floating form-floating-outline mb-3">
                            <select class="form-select" id="edit_certificacion" name="certificacion" aria-label="Tipo de Certificación" required>
                                <option value="">Seleccione el tipo de certificación</option>
                                <option value="oc_cidam">Certificación por OC CIDAM</option>
                                <option value="otro_organismo">Certificado por otro organismo</option>
                            </select>
                            <label for="edit_certificacion">Tipo de Certificación</label>
                        </div>

                        <!-- Campos adicionales para "Certificado por otro organismo" -->
                        <div id="edit_certificado_otros" class="d-none">
                            <div class="col-md-12 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control form-control-sm" type="file" id="file-127" name="url[]">
                                    <input value="127" class="form-control" type="hidden" name="id_documento[]">
                                    <input value="Certificado de instalaciones" class="form-control" type="hidden" name="nombre_documento[]">
                                    <label for="certificado_instalaciones">Adjuntar Certificado de Instalaciones</label>
                                </div>
                            </div>
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="form-control" id="edit_folio" placeholder="Folio/Número del certificado" name="folio" aria-label="Folio/Número del certificado">
                                <label for="edit_folio">Folio/Número del certificado</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-3">
                                <select class="form-select" id="edit_id_organismo" name="id_organismo" data-placeholder="Seleccione un organismo de certificación" aria-label="Organismo de Certificación">
                                    <option value="">Seleccione un organismo de certificación</option>
                                    @foreach($organismos as $organismo)
                                        <option value="{{ $organismo->id_organismo }}">{{ $organismo->organismo }}</option>
                                    @endforeach
                                </select>
                                <label for="edit_id_organismo">Organismo de Certificación</label>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" class="form-control" id="edit_fecha_emision" name="fecha_emision" aria-label="Fecha de Emisión">
                                        <label for="edit_fecha_emision">Fecha de Emisión</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" class="form-control" id="edit_fecha_vigencia" name="fecha_vigencia" aria-label="Fecha de Vigencia">
                                        <label for="edit_fecha_vigencia">Fecha de Vigencia</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary me-2">Guardar Cambios</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
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
