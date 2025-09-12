@extends('layouts/layoutMaster')

@section('title', 'Imágenes Carrusel')

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
        window.puedeAgregarElUsuario = @json(auth()->user()->can('Registrar imagenes carousel'));
        window.puedeEditarElUsuario = @json(auth()->user()->can('Editar imagenes carousel'));
        window.puedeEliminarElUsuario = @json(auth()->user()->can('Eliminar imagenes carousel'));
    </script>
    @vite(['resources/js/mensajes.js'])
@endsection

@section('content')

    {{-- <meta name="csrf-token" content="{{ csrf_token() }}">
 --}}
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h3 class="card-title mb-0">Imágenes Carrusel</h3>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="table-dark">
                    <tr>
                        <th></th>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>mensaje</th>
                        <th>orden</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Offcanvas para agregar nueva imagen -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header border-bottom bg-primary">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title text-white">Nueva Imagen</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form class="add-new-user pt-0" id="addNewImageForm" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                        <label for="imagen">Selecciona la imagen</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="nombre_imagen" name="nombre_imagen"
                            placeholder="Opcional: renombrar imagen">
                        <label for="nombre_imagen">Nombre opcional para la imagen</label>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Subir Imagen</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
                </form>

            </div>
        </div>
        <!-- Offcanvas para editar -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="editCarousel">
            <div class="offcanvas-header border-bottom bg-primary">
                <h5 class="offcanvas-title  text-white">Editar Imagen</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                @csrf
                <form class="edit-class-form pt-0" id="editImageForm" method="POST">
                    @csrf
                    <input type="hidden" name="imagen" id="edit_carousel_id" value="">
                    <div class="mb-4">
                        <label class="form-label">Vista previa</label><br>
                        <img id="preview_edit_image" src="" alt="Vista previa" class="img-fluid rounded border">
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="edit_carousel_nombre"
                            placeholder="Nombre de la imagen" name="nombre" required>
                        <label for="edit_carousel_nombre">Nombre de la imagen</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" class="form-control" id="edit_carousel_orden" name="orden"
                            placeholder="Opcional: elegir orden">
                        <label for="nombre_imagen">Orden opcional para la imagen</label>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Actualizar</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
                </form>

            </div>
        </div>

    </div>

    <!-- Modal -->
    @include('_partials/_modals/modal-pdfs-frames')
    <!-- /Modal -->
@endsection
