@extends('layouts/layoutMaster')

@section('title', 'Lotes a granel')

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
    @vite(['resources/js/catalogo_lotes.js'])
@endsection


@section('content')



    <!-- Users List Table -->
    <div class="card">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Lotes a granel</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>no. clientes</th>
                        <th>Nombre de lote</th>
                        <th>tipo lote</th>
                        <th>folio</th>
                        <th>volumen de lote</th>
                        <th>Contenido alcoholico</th>
                        <th>Categoria</th>
                        <th>Clase</th>
                        <th>Tipo de maguey</th>
                        <th>ingredientes</th>
                        <th>edad</th>
                        <th>guia</th>
                        <th>folio certificado</th>
                        <th>organismo</th>
                        <th>fecha emision</th>
                        <th>fecha vigencia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Modal para agregar nuevo lote -->
        <div class="modal fade" id="offcanvasAddLote" tabindex="-1" aria-labelledby="offcanvasAddLoteLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="offcanvasAddLoteLabel" class="modal-title">Registro de Lote a Granel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                     {{--  --}}
                        <form id="loteForm" method="POST" action="{{ route('lotes-register.store') }}">
                            @csrf
                            <!-- Nombre del lote -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" id="nombre_lote" name="nombre_lote" class="form-control"
                                            placeholder="Nombre del lote" required />
                                        <label for="nombre_lote">Nombre del Lote</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Empresa y Tipo de Lote -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="id_empresa" name="id_empresa" class=" form-select" required >
                                            <option value="" disabled selected>Selecciona la empresa</option>
                                            @foreach ($empresas as $empresa)
                                                <option value="{{ $empresa->id_empresa}}">{{ $empresa->razon_social }}</option>
                                            @endforeach
                                        </select>
                                        <label for="id_empresa">Empresa</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="tipo_lote" name="tipo_lote" class="select2 form-select" required
                                            onchange="toggleFields()">
                                            <option value="" disabled selected>Selecciona el tipo de lote</option>
                                            <option value="1">Certificación por OC CIDAM</option>
                                            <option value="2">Certificado por otro organismo</option>
                                        </select>
                                        <label for="tipo_lote">Tipo de Lote</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos para "Certificación por OC CIDAM" -->
                            <div id="oc_cidam_fields" class="d-none">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select id="id_guia" name="id_guia" class="form-control">
                                                <option value="">Seleccione una guía</option>
                                                @foreach ($guias as $guia)
                                                    <option value="{{ $guia->id_guia }}">{{ $guia->Folio }}</option>
                                                @endforeach
                                            </select>
                                            <label for="id_guia">Folio de guía de translado</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="text" id="no_analisis" name="no_analisis" class="form-control"
                                                placeholder="No. de Análisis Fisicoquímico" />
                                            <label for="no_analisis">No. de Análisis Fisicoquímico</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="file" id="analisis_fisicoquimico" name="analisis_fisicoquimico"
                                                class="form-control" />
                                            <label for="analisis_fisicoquimico">Adjuntar Análisis Fisicoquímico</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="number" step="0.01" id="volumen_lote" name="volumen_lote"
                                                class="form-control" placeholder="Volumen de Lote Inicial (litros)" />
                                            <label for="volumen_lote">Volumen de Lote Inicial (litros)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="number" step="0.01" id="contenido_alcoholico"
                                                name="contenido_alcoholico" class="form-control"
                                                placeholder="Contenido Alcohólico" />
                                            <label for="contenido_alcoholico">Contenido Alcohólico</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select id="categoria_agave" name="categoria_agave"
                                                class="select2 form-select" >
                                                <option value="" disabled selected>Selecciona la categoría de agave
                                                </option>
                                                @foreach ($categorias as $categoria)
                                                    <option value="{{ $categoria->id_categoria }}">
                                                        {{ $categoria->categoria }}</option>
                                                @endforeach
                                            </select>
                                            <label for="categoria_agave">Categoría de Agave</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select id="clase_agave" name="clase_agave" class="select2 form-select"
                                                >
                                                <option value="" disabled selected>Selecciona la clase de agave
                                                </option>
                                                @foreach ($clases as $clase)
                                                    <option value="{{ $clase->id_clase }}">{{ $clase->clase }}</option>
                                                @endforeach
                                            </select>
                                            <label for="clase_agave">Clase de Agave</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select id="tipo_agave" name="tipo_agave" class="select2 form-select"
                                                >
                                                <option value="" disabled selected>Selecciona el tipo de agave
                                                </option>
                                                @foreach ($tipos as $tipo)
                                                    <option value="{{ $tipo->id_tipo }}">{{ $tipo->nombre }}</option>
                                                @endforeach
                                            </select>
                                            <label for="tipo_agave">Tipo de Agave</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="text" id="ingredientes" name="ingredientes"
                                                class="form-control" placeholder="Ingredientes" />
                                            <label for="ingredientes">Ingredientes</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="text" id="edad" name="edad" class="form-control"
                                                placeholder="Edad" />
                                            <label for="edad">Edad</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos para "Certificado por otro organismo" -->
                            <div id="otro_organismo_fields" class="d-none">
                                <div class="row">
                                    <!-- Campo de archivo ocupando toda la fila -->
                                    <div class="col-md-12 mb-4">
                                        <div class="form-floating form-floating-outline">
                                            <input type="file" id="certificado_lote" name="certificado_lote"
                                                class="form-control" />
                                            <label for="certificado_lote">Adjuntar Certificado de Lote a Granel</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Campos en filas de dos -->
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" id="folio_certificado" name="folio_certificado"
                                                class="form-control" placeholder="Folio/Número de Certificado" />
                                            <label for="folio_certificado">Folio/Número de Certificado</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating form-floating-outline">
                                            <select id="organismo_certificacion" name="organismo_certificacion"
                                                class="select2 form-select">
                                                <option value="" disabled selected>Selecciona el organismo de
                                                    certificación</option>
                                                @foreach ($organismos as $organismo)
                                                    <option value="{{ $organismo->id }}">{{ $organismo->organismo }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="organismo_certificacion">Organismo de Certificación</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating form-floating-outline">
                                            <input type="date" id="fecha_emision" name="fecha_emision"
                                                class="form-control datepicker" placeholder="Fecha de Emisión" />
                                            <label for="fecha_emision">Fecha de Emisión</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-floating form-floating-outline">
                                            <input type="date" id="fecha_vigencia" name="fecha_vigencia"
                                                class="form-control datepicker" placeholder="Fecha de Vigencia" />
                                            <label for="fecha_vigencia">Fecha de Vigencia</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Botones -->
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-primary me-2">Registrar</button>
                                <button type="reset" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
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