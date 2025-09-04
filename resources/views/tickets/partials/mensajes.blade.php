@extends('layouts.layoutMaster')
@section('title', 'Detalle del ticket')
@yield('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    /*     .chat-message-wrapper {
        max-width: 40%;
        min-width: 30%;
        word-wrap: break-word;
    } */

    .chat-message-wrapper {
        display: inline-block;
        /* Se ajusta al contenido */
        max-width: 50%;
        /* No más del 50% del contenedor */
        word-wrap: break-word;
        /* Rompe palabras largas */
    }
</style>
@section('content')

    <div class="container-fluid py-4">

        {{-- Detalles del ticket --}}
        {{--         <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white mb-2">
                <h4 class="mb-0 text-white">Ticket: {{ $ticket->folio }} — {{ $ticket->asunto }}</h4>
            </div>
            <div class="card-body">
                <p><strong>Solicitante:</strong> {{ $ticket->nombre }}</p>
                <p><strong>Correo:</strong> {{ $ticket->email }}</p>
                <p><strong>Prioridad:</strong> {{ ucfirst($ticket->prioridad) }}</p>
                <p><strong>Descripción:</strong> {{ $ticket->descripcion }}</p>
                <p><strong>Estatus:</strong> {{ $ticket->estatus ?? 'Pendiente' }}</p>
                @if ($ticket->evidencias->count())
                    <p><strong>Evidencias:</strong></p>
                    <ul>
                        @foreach ($ticket->evidencias as $archivo)
                            <li><a href="{{ asset('storage/' . $archivo->evidencia_url) }}"
                                    target="_blank">{{ basename($archivo->evidencia_url) }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div> --}}
        {{-- Detalles del ticket --}}
        @php
            $estatusActual = strtolower($ticket->estatus ?? 'pendiente');
            $colores = [
                'pendiente' => 'warning',
                'abierto' => 'success',
                'cerrado' => 'danger',
            ];
        @endphp

        <div class="card mb-4 shadow-sm">
            {{-- <div class="card-header bg-primary text-white mb-2">
                <h4 class="mb-0 text-white">Ticket: {{ $ticket->folio }} — {{ $ticket->asunto }}</h4>
                <a href="{{ route('tickets') }}" class="btn btn-light btn-sm text-primary">
                    Salir
                </a>
            </div> --}}

            <div class="card-header bg-primary text-white mb-2 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-white">Ticket: {{ $ticket->folio }} — {{ $ticket->asunto }}</h4>
                <a href="{{ route('tickets-servicio') }}" class="btn btn-danger text-white">
                    <i class="ri-logout-box-r-line me-1"></i> Regresar
                </a>

            </div>


            <div class="card-body">
                <p><strong>Solicitante:</strong> {{ $ticket->nombre }}</p>
                <p><strong>Correo:</strong> {{ $ticket->email }}</p>
                <p><strong>Asunto:</strong> {{ $ticket->asunto }}</p>
                <p><strong>Prioridad:</strong> {{ ucfirst($ticket->prioridad) }}</p>
                <p><strong>Descripción:</strong> {{ $ticket->descripcion }}</p>
                <p><strong>Estatus:</strong>
                    <select id="selectEstatus" class="form-select form-select-sm d-inline-block ms-2 text-white"
                        style="width:auto; background-color: {{ $estatusActual === 'pendiente' ? '#f0ad4e' : ($estatusActual === 'abierto' ? '#28a745' : '#dc3545') }};">
                        <option value="pendiente" {{ $estatusActual === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="abierto" {{ $estatusActual === 'abierto' ? 'selected' : '' }}>Abierto</option>
                        <option value="cerrado" {{ $estatusActual === 'cerrado' ? 'selected' : '' }}>Cerrado</option>
                    </select>
                    <button id="btnActualizarEstatus" class="btn btn-sm btn-primary ms-1">Actualizar</button>
                </p>


                @if ($ticket->evidencias->count())
                    <p><strong>Evidencias:</strong></p>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach ($ticket->evidencias as $archivo)
                            @php
                                $ext = pathinfo($archivo->evidencia_url, PATHINFO_EXTENSION);
                                $url = asset('storage/' . $archivo->evidencia_url);
                            @endphp

                            @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                {{-- Mostrar imagen --}}
                                <div class="card shadow-sm" style="width: 120px;">
                                    <a href="{{ $url }}" target="_blank">
                                        <img src="{{ $url }}" class="card-img-top"
                                            style="height: 100px; object-fit: cover;">
                                    </a>
                                    <div class="card-body p-2 text-center">
                                        <small>{{-- {{ basename($archivo->evidencia_url) }} --}}</small>
                                    </div>
                                </div>
                            @elseif(strtolower($ext) === 'pdf')
                                {{-- Mostrar icono PDF --}}
                                <div class="card shadow-sm text-center p-2" style="width: 120px;">
                                    <a href="{{ $url }}" target="_blank" class="d-block my-2">
                                        <i class="ri-file-pdf-line" style="font-size: 2rem; color: #E74C3C;"></i>
                                    </a>
                                    <small>{{-- {{ basename($archivo->evidencia_url) }} --}}</small>
                                </div>
                            @else
                                {{-- Otros archivos --}}
                                <div class="card shadow-sm text-center p-2" style="width: 120px;">
                                    <a href="{{ $url }}" target="_blank" class="d-block my-2">
                                        <i class="ri-file-line" style="font-size: 2rem;"></i>
                                    </a>
                                    <small>{{-- {{ basename($archivo->evidencia_url) }} --}}</small>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Chat --}}
        {{-- encabezado siempre mostrara el solicitante del ticket --}}
        {{--             <div class="chat-history-header border-bottom">
                <div class="d-flex justify-content-between align-items-center w-100">


                    <div class="d-flex overflow-hidden align-items-center">
                        <div class="flex-shrink-0 avatar avatar-online">
                            <img src="{{ $ticket->usuario?->profile_photo_url ?? asset('assets/img/avatars/4.png') }}"
                                alt="Avatar" class="rounded-circle">
                        </div>
                        <div class="chat-contact-info flex-grow-1 ms-3">
                            <h6 class="m-0 fw-bold">{{ $ticket->usuario->name ?? $ticket->nombre }}</h6>
                            <small class="user-status text-body">
                                {{ $ticket->usuario?->puesto ?? 'Sin puesto' }}
                            </small>
                        </div>
                    </div>

                    <div class="text-center flex-grow-1">
                        <span class="fw-bold">Asunto:</span>
                        <h5>{{ $ticket->asunto }}</h5>
                    </div>

                </div>
              </div> --}}
        @php
            $yo = auth()->user();
            $esAdmin = $yo->puesto === 'Desarrollador'; // o la condición que uses para admin

            if ($esAdmin) {
                // Soy admin → mostrar al solicitante
                $destinatario = $ticket->usuario;
            } else {
                // Soy usuario → mostrar al admin
                // Aquí puedes definir quién es el admin que atiende, por ejemplo el primero con puesto=Desarrollador
                $destinatario = \App\Models\User::where('puesto', 'Desarrollador')->first();
            }
        @endphp

        <div class="app-chat card overflow-hidden p-2">

            <div class="chat-history-header border-bottom p-3">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 avatar avatar-online">
                            <img src="{{ $destinatario?->profile_photo_url ?? asset('assets/img/avatars/4.png') }}"
                                alt="Avatar" class="rounded-circle">
                        </div>
                        <div class="chat-contact-info ms-3">
                            <h6 class="m-0 fw-bold">{{ $destinatario?->name ?? 'Soporte' }}</h6>
                            <small class="user-status text-body">
                                {{ $destinatario?->puesto ?? 'Usuario' }}
                            </small>
                        </div>
                    </div>

                    {{-- Asunto --}}
                    {{-- <div class="text-center flex-grow-1">
                        <span class="fw-bold">Asunto:</span>
                        <h5>{{ $ticket->asunto }}</h5>
                    </div> --}}
                </div>
            </div>


            <div class="chat-history-wrapper">
                {{-- Chat messages --}}
                <div class="chat-history-body" id="chatContainer" style="height: 680px; overflow-y: auto;">
                    <ul class="list-unstyled chat-history p-3 m-0">
                        @foreach ($ticket->mensajes as $mensaje)
                            @php $isMine = $mensaje->id_usuario == auth()->id(); @endphp
                            <li class="chat-message {{ $isMine ? 'chat-message-right' : '' }}">
                                <div class="d-flex {{ $isMine ? 'justify-content-end' : '' }} overflow-hidden">
                                    {{-- Avatar del otro usuario --}}
                                    @if (!$isMine)
                                        <div class="user-avatar flex-shrink-0 me-4">
                                            <div class="avatar avatar-sm">
                                                <img src="{{ $mensaje->usuario?->profile_photo_url ?? asset('assets/img/avatars/4.png') }}"
                                                    alt="Avatar" class="rounded-circle">
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Mensaje --}}
                                    <div class="chat-message-wrapper">
                                        <div
                                            class="chat-message-text p-2 rounded {{ $isMine ? 'bg-primary text-white' : 'bg-light text-dark' }}">

                                            {{-- Nombre del usuario siempre arriba --}}
                                            <strong
                                                class="d-block mb-1">{{ $mensaje->usuario->name ?? 'Desconocido' }}</strong>

                                            {{-- Mensaje de texto --}}
                                            @if ($mensaje->mensaje)
                                                <p class="mb-1">{{ $mensaje->mensaje }}</p>
                                            @endif

                                            {{-- Archivo adjunto debajo del texto --}}
                                            @if ($mensaje->archivo)
                                                @php
                                                    $ext = strtolower(pathinfo($mensaje->archivo, PATHINFO_EXTENSION));
                                                    $filePath = storage_path('app/public/' . $mensaje->archivo);
                                                    $fileSize = file_exists($filePath)
                                                        ? round(filesize($filePath) / 1024, 1) . ' KB'
                                                        : '';
                                                    $fileName = basename($mensaje->archivo);

                                                    $icon = match ($ext) {
                                                        'pdf' => 'ri-file-pdf-2-line text-danger',
                                                        'doc', 'docx' => 'ri-file-word-line text-primary',
                                                        'xls', 'xlsx' => 'ri-file-excel-line text-success',
                                                        'ppt', 'pptx' => 'ri-file-ppt-line text-warning',
                                                        default => 'ri-file-line text-secondary',
                                                    };
                                                @endphp


                                                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                                                    {{-- Imagen con enlace --}}
                                                    <a href="{{ asset('storage/' . $mensaje->archivo) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $mensaje->archivo) }}"
                                                            class="img-fluid rounded mt-1" style="max-width:300px;">
                                                    </a>
                                                @else
                                                    {{-- Otros archivos --}}
                                                    <div class="file-attachment mt-1 p-2 {{-- border --}} rounded bg-label-primary{{-- secondary --}} text-center"
                                                        style="max-width:300px;">
                                                        <a href="{{ asset('storage/' . $mensaje->archivo) }}"
                                                            target="_blank" class="d-flex text-decoration-none">
                                                            <i class="{{ $icon }}" style="font-size:40px;"></i>
                                                            <div class="small {{-- text-white --}} text-truncate">
                                                                {{ $fileName }}</div>
                                                            <div class="text-muted small">.{{ $ext }}
                                                                {{ $fileSize }}</div>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif

                                        </div>

                                        {{-- Fecha --}}
                                        <div class="text-muted mt-1 text-end {{ $isMine ? '' : 'text-start' }}">
                                            <small>{{ $mensaje->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </div>


                                    {{--  <div class="chat-message-wrapper">
                                        <div
                                            class="chat-message-text p-2 rounded {{ $isMine ? 'bg-primary text-white' : 'bg-light text-dark' }}">
                                            <strong>{{ $mensaje->usuario->name ?? 'Desconocido' }}</strong>
                                            <p class="mb-0">{{ $mensaje->mensaje }}</p>
                                        </div>
                                        <div class="text-muted mt-1 text-end {{ $isMine ? '' : 'text-start' }}">
                                            <small>{{ $mensaje->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </div> --}}

                                    @if ($isMine)
                                        <div class="user-avatar flex-shrink-0 ms-4">
                                            <div class="avatar avatar-sm">
                                                <img src="{{ $mensaje->usuario?->profile_photo_url ?? asset('assets/img/avatars/1.png') }}"
                                                    alt="Avatar" class="rounded-circle">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Input --}}
                <div class="chat-history-footer">
                    <div id="filePreviewContainer" class="mb-2"></div>
                    <form id="chatForm" class="form-send-message d-flex justify-content-between align-items-center mt-2"
                        enctype="multipart/form-data">
                        <input type="text" class="form-control message-input me-4 shadow-none"
                            placeholder="Escribe tu mensaje aquí..." name="mensaje" id="nuevoMensaje">
                        <div class="message-actions d-flex align-items-center">
                            <label for="attach-doc" class="form-label mb-0">
                                <i
                                    class="ri-attachment-2 ri-20px cursor-pointer btn btn-sm btn-text-secondary btn-icon rounded-pill me-2 ms-1 text-heading"></i>
                                <input type="file" id="attach-doc" hidden>
                            </label>
                            <button type="submit" class="btn btn-primary d-flex send-msg-btn">
                                <span class="align-middle">Enviar</span>
                                <i class="ri-send-plane-line ri-16px ms-md-2 ms-0"></i>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>



    </div>
@endsection
@section('page-script')
    <script>
        $('#attach-doc').on('change', function() {
            const file = this.files[0];
            const previewContainer = $('#filePreviewContainer');
            previewContainer.empty(); // Limpiar previsualización previa

            if (file) {
                const ext = file.name.split('.').pop().toLowerCase();
                let previewHtml = '';

                if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                    // Imagen
                    previewHtml = `
                <div class="file-preview mb-2 p-2 rounded bg-light d-flex align-items-center justify-content-between" style="max-width: 300px;">
                    <img src="${URL.createObjectURL(file)}" class="img-fluid rounded" style="max-width:50px; max-height:50px;">
                    <span class="ms-2 text-truncate" style="max-width:200px;">${file.name}</span>
                    <button type="button" class="btn-close btn-sm ms-2" aria-label="Close"></button>
                </div>`;
                } else {
                    // Otros archivos
                    previewHtml = `
                <div class="file-preview mb-2 p-2 rounded bg-light d-flex align-items-center justify-content-between" style="max-width: 300px;">
                    <i class="ri-file-line fs-3"></i>
                    <span class="ms-2 text-truncate" style="max-width:200px;">${file.name}</span>
                    <button type="button" class="btn-close btn-sm ms-2" aria-label="Close"></button>
                </div>`;
                }

                previewContainer.append(previewHtml);

                // Permitir eliminar archivo antes de enviar
                previewContainer.find('.btn-close').on('click', function() {
                    $('#attach-doc').val('');
                    previewContainer.empty();
                });
            }
        });


        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const chatContainer = $('#chatContainer');

            $('#chatForm').on('submit', function(e) {
                e.preventDefault();

                let mensaje = $('#nuevoMensaje').val().trim();
                let archivoInput = $('#attach-doc')[0].files[0]; // Obtener el archivo, si existe

                if (!mensaje && !archivoInput) return; // No enviar si está vacío

                let formData = new FormData();
                formData.append('mensaje', mensaje);
                if (archivoInput) {
                    formData.append('archivo', archivoInput);
                }

                $.ajax({
                    url: "{{ route('tickets.mensajes.store', $ticket->id_ticket) }}",
                    type: 'POST',
                    data: formData,
                    processData: false, // Muy importante
                    contentType: false, // Muy importante
                    success: function(res) {
                        if (res.success) {
                            // Nombre siempre arriba
                            const nombreHtml =
                                `<strong class="d-block mb-1">${res.mensaje.usuario.name}</strong>`;

                            // Mensaje de texto (solo si existe)
                            const mensajeHtml = res.mensaje.mensaje ?
                                `<p class="mb-1">${res.mensaje.mensaje}</p>` :
                                '';

                            // Archivo adjunto (imagen o enlace con detalles)
                            let archivoHtml = '';
                            if (res.mensaje.archivo) {
                                const ext = res.mensaje.archivo.split('.').pop().toLowerCase();
                                const fileName = res.mensaje.archivo.split('/').pop();

                                if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                                    archivoHtml = `
                                        <img src="/storage/${res.mensaje.archivo}"
                                            class="img-fluid rounded mt-1"
                                            style="max-width:300px;">`;
                                } else {
                                    // ícono según extensión
                                    let icon = 'ri-file-line text-secondary';
                                    if (ext === 'pdf') icon = 'ri-file-pdf-2-line text-danger';
                                    else if (['doc', 'docx'].includes(ext)) icon =
                                        'ri-file-word-line text-primary';
                                    else if (['xls', 'xlsx'].includes(ext)) icon =
                                        'ri-file-excel-line text-success';
                                    else if (['ppt', 'pptx'].includes(ext)) icon =
                                        'ri-file-ppt-line text-warning';

                                    archivoHtml = `
                                    <div class="file-attachment mt-1 p-2 rounded bg-label-primary text-center" style="max-width:300px;">
                                      <a href="/storage/${res.mensaje.archivo}" target="_blank"
                                        class="d-flex align-items-center gap-2 text-decoration-none overflow-hidden">
                                        <i class="${icon} flex-shrink-0" style="font-size:40px;"></i>

                                        <!-- Contenedor del texto: que pueda encogerse -->
                                        <div class="flex-grow-1" style="min-width:0;">
                                          <!-- Limita el ancho y aplica truncado -->
                                          <div class="small text-truncate" style="max-width: 220px;" title="${fileName}">
                                            ${fileName}
                                          </div>
                                          <div class="text-muted small">.${ext}</div>
                                        </div>
                                      </a>
                                    </div>`;

                                }
                            }

                            // plantilla final
                            const html = `
                                <li class="chat-message chat-message-right">
                                    <div class="d-flex justify-content-end overflow-hidden">
                                        <div class="chat-message-wrapper">
                                            <div class="chat-message-text p-2 rounded bg-primary text-white">
                                                ${nombreHtml}
                                                ${mensajeHtml}
                                                ${archivoHtml}
                                            </div>
                                            <div class="text-end text-muted mt-1">
                                                <small>${new Date(res.mensaje.created_at).toLocaleString()}</small>
                                            </div>
                                        </div>
                                        <div class="user-avatar flex-shrink-0 ms-4">
                                            <div class="avatar avatar-sm">
                                                <img src="${res.mensaje.usuario.profile_photo_url || '/assets/img/avatars/1.png'}" class="rounded-circle">
                                            </div>
                                        </div>
                                    </div>
                                </li>`;

                            $('#chatContainer ul').append(html);
                            $('#nuevoMensaje').val('');
                            $('#attach-doc').val(''); // Limpiar input
                            $('.message-actions').find('.file-name').remove();
                            $('#filePreviewContainer').empty();
                            chatContainer.scrollTop(chatContainer[0].scrollHeight);
                        }
                    },

                    error: function(xhr) {
                        console.error('Error al enviar mensaje:', xhr);
                    }
                });
            });


        });


        function actualizarColorSelect() {
            const select = document.getElementById('selectEstatus');
            const valor = select.value;
            let color = '#6c757d'; // secondary por defecto

            if (valor === 'pendiente') color = '#f0ad4e';
            if (valor === 'abierto') color = '#28a745';
            if (valor === 'cerrado') color = '#dc3545';

            select.style.backgroundColor = color;
            select.style.color = '#fff';
        }

        document.getElementById('selectEstatus').addEventListener('change', actualizarColorSelect);
        actualizarColorSelect(); // Inicializa con el color correcto

        $('#btnActualizarEstatus').on('click', function() {
            let nuevoEstatus = $('#selectEstatus').val();
            $.ajax({
                url: "{{ route('tickets.updateEstatus', $ticket->id_ticket) }}",
                type: "PATCH",
                data: {
                    estatus: nuevoEstatus
                },
                success: function(res) {
                    if (res.success) {
                        // Actualiza el badge de estatus
                        let color = 'secondary';
                        if (nuevoEstatus === 'pendiente') color = 'warning';
                        if (nuevoEstatus === 'abierto') color = 'success';
                        if (nuevoEstatus === 'cerrado') color = 'danger';

                        $('#estatusBadge')
                            .text(nuevoEstatus.charAt(0).toUpperCase() + nuevoEstatus.slice(1))
                            .removeClass('bg-warning bg-success bg-danger bg-secondary')
                            .addClass('bg-' + color);

                        Swal.fire('¡Éxito!', 'Estatus actualizado correctamente', 'success');
                    }
                },
                error: function(xhr) {
                    Swal.fire('¡Error!', xhr.responseJSON?.error || 'No se pudo actualizar el estatus',
                        'error');
                }
            });
        });
    </script>
@endsection
