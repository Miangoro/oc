@extends('layouts/layoutMaster')

@section('title', 'Mensajes personalizados')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/animate-css/animate.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    <style>
        .img-preview:hover {
            filter: brightness(0.9);
            transform: scale(1.02);
            transition: all 0.2s ease-in-out;
        }
    </style>
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    <script>
        window.puedeAgregarElUsuario = @json(auth()->user()->can('Registrar mensajes'));
        window.puedeEditarElUsuario = @json(auth()->user()->can('Editar mensajes'));
        window.puedeEliminarElUsuario = @json(auth()->user()->can('Eliminar mensajes'));
    </script>
    @vite(['resources/js/mensajes.js'])
@endsection

@section('content')

    {{-- <meta name="csrf-token" content="{{ csrf_token() }}">
 --}}
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Mensajes personalizados</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th></th> <!-- checkbox/selector -->
                        <th>#</th> <!-- consecutivo -->
                        <th>Usuario (Emisor)</th> <!-- nombre del usuario que envió el mensaje -->
                        <th>Usuairo (Receptor)</th> <!-- nombre del usuario destino (o Global) -->
                        <th>Titulo</th>
                        <th>Tipo titulo</th>
                        <th>Mensaje</th> <!-- el texto del mensaje -->
                        <th>Tipo</th> <!-- tipo de mensaje (Normal, Info, Alerta, etc.) -->
                        <th>Orden</th> <!-- orden de aparición -->
                        <th>Estatus</th> <!-- activo o desactivado -->
                        <th>Acciones</th> <!-- botones editar/eliminar -->
                    </tr>

                    {{--                     <tr>
                        <th></th> <!-- checkbox/selector -->
                        <th>#</th> <!-- consecutivo -->
                        <th>Nombre usuario</th> <!-- probablemente el usuario destino -->
                        <th>mensaje</th> <!-- el texto del mensaje -->
                        <th>Tipo de texto</th>
                        <th>orden</th> <!-- orden de aparición -->
                        <th>Estatus</th>
                        <th>Acciones</th> <!-- botones editar/eliminar -->

                    </tr> --}}
                </thead>
            </table>
        </div>

        <!-- Offcanvas para agregar nuevo mensaje -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddMensaje" aria-labelledby="offcanvasAddMensajeLabel">
            <div class="offcanvas-header border-bottom bg-primary">
                <h5 id="offcanvasAddMensajeLabel" class="offcanvas-title text-white">Nuevo Mensaje</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form class="pt-0" id="addNewMensajeForm" method="POST">
                    @csrf

                    <!-- Usuario destino (puede ser null para global) -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="select2 form-select" id="id_usuario_destino" name="id_usuario_destino">
                            {{-- <option value="">Global (todos los usuarios)</option> --}}
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">
                                    {{ $usuario->name }} (Puesto: {{ $usuario->puesto }})
                                </option>
                            @endforeach
                        </select>
                        <label for="id_usuario_destino">Usuario destino</label>
                    </div>
                    <!-- Titulo -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" id="titulo" name="titulo" placeholder="Escribe el titulo"></input>
                        <label for="mensaje">Titulo</label>
                    </div>
                    <!-- Tipo titulo -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select" id="tipo_titulo" name="tipo_titulo">
                            <option value="Normal">Normal</option>
                            <option value="primary">Primary</option>
                            <option value="secondary">Secondary (Gris)</option>
                            <option value="success">Success (Verde)</option>
                            <option value="danger">Danger (Rojo)</option>
                            <option value="warning">Warning (Amarillo)</option>
                            <option value="info">Info (Celeste)</option>
                            <option value="dark">Dark (Negro)</option>
                        </select>
                        <label for="tipo">Tipo de titulo</label>
                    </div>

                    <!-- Mensaje -->
                    <div class="form-floating form-floating-outline mb-3">
                        <textarea class="form-control" id="mensaje" name="mensaje" placeholder="Escribe el mensaje" style="height: 100px"></textarea>
                        <label for="mensaje">Mensaje</label>
                    </div>
                    <!-- Tipo -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select" id="tipo" name="tipo">
                            <option value="Normal">Normal</option>
                            <option value="primary">Primary</option>
                            <option value="secondary">Secondary (Gris)</option>
                            <option value="success">Success (Verde)</option>
                            <option value="danger">Danger (Rojo)</option>
                            <option value="warning">Warning (Amarillo)</option>
                            <option value="info">Info (Celeste)</option>
                            <option value="dark">Dark (Negro)</option>
                        </select>
                        <label for="tipo">Tipo de mensaje</label>
                    </div>
                    <!-- Orden -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="number" class="form-control" id="orden" name="orden"
                            placeholder="Orden de aparición (ej. 1)">
                        <label for="orden">Orden</label>
                    </div>
                    <!-- Activo -->
                    {{-- <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="activo" name="activo" checked>
                        <label class="form-check-label" for="activo">Activo</label>
                    </div> --}}
                    <div class="d-flex justify-content-center">
                      <button disabled class="btn btn-primary me-2 d-none" type="button" id="loading">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Registrando...
                        </button>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1" id="btnAdd"><i class="ri-add-line me-1"></i>
                        Registrar</button>
                    <button type="reset" class="btn btn-danger" data-bs-dismiss="offcanvas"><i
                            class="ri-close-line me-1"></i> Cancelar</button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Offcanvas para editar mensaje -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEditMensaje">
            <div class="offcanvas-header border-bottom bg-primary">
                <h5 class="offcanvas-title text-white">Editar Mensaje</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form id="editMensajeForm" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="edit_mensaje_id">

                    <!-- Usuario destino -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select select2" id="edit_id_usuario_destino" name="id_usuario_destino">
                            {{-- <option value="">Global (todos los usuarios)</option> --}}
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}">
                                    {{ $usuario->name }} (Puesto: {{ $usuario->puesto }})
                                </option>
                            @endforeach
                        </select>
                        <label for="edit_id_usuario_destino">Usuario destino</label>
                    </div>
                    <!-- Titulo -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" id="edit_titulo" name="titulo"
                            placeholder="Escribe el titulo"></input>
                        <label for="mensaje">Titulo</label>
                    </div>
                    <!-- Tipo titulo -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select" id="edit_tipo_titulo" name="tipo_titulo">
                            <option value="Normal">Normal</option>
                            <option value="primary">Primary</option>
                            <option value="secondary">Secondary (Gris)</option>
                            <option value="success">Success (Verde)</option>
                            <option value="danger">Danger (Rojo)</option>
                            <option value="warning">Warning (Amarillo)</option>
                            <option value="info">Info (Celeste)</option>
                            <option value="dark">Dark (Negro)</option>
                        </select>
                        <label for="tipo">Tipo de titulo</label>
                    </div>

                    <!-- Mensaje -->
                    <div class="form-floating form-floating-outline mb-3">
                        <textarea class="form-control" id="edit_mensaje" name="mensaje" placeholder="Escribe el mensaje"
                            style="height: 100px" required></textarea>
                        <label for="edit_mensaje">Mensaje</label>
                    </div>

                    <!-- Tipo -->
                    <div class="form-floating form-floating-outline mb-3">
                        <select class="form-select" id="edit_tipo" name="tipo" required>
                            <option value="Normal">Normal</option>
                            <option value="primary">Primary</option>
                            <option value="secondary">Secondary (Gris)</option>
                            <option value="success">Success (Verde)</option>
                            <option value="danger">Danger (Rojo)</option>
                            <option value="warning">Warning (Amarillo)</option>
                            <option value="info">Info (Celeste)</option>
                            <option value="dark">Dark (Negro)</option>
                        </select>
                        <label for="edit_tipo">Tipo de mensaje</label>
                    </div>

                    <!-- Orden -->
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="number" class="form-control" id="edit_orden" name="orden">
                        <label for="edit_orden">Orden</label>
                    </div>

                    <!-- Activo -->
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="edit_activo" name="activo">
                        <label class="form-check-label" for="edit_activo">Activo</label>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button disabled class="btn btn-primary me-2 d-none" type="button" id="updating">
                            <span class="spinner-border me-1" role="status" aria-hidden="true"></span>
                            Actualizando...
                        </button>
                        <button type="submit" class="btn btn-primary me-sm-3 me-1" id="btnEdit"><i class="ri-pencil-fill me-1"></i>
                            Editar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas"><i
                                class="ri-close-line me-1"></i> Cancelar</button>
                    </div>


                </form>
            </div>
        </div>


    </div>

    <!-- Modal -->
    @include('_partials/_modals/modal-pdfs-frames')
    <!-- /Modal -->
@endsection
