@extends('layouts.layoutMaster')
@section('title', 'Detalle del ticket')
@yield('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
            <div class="card-header bg-primary text-white mb-2">
                <h4 class="mb-0 text-white">Ticket: {{ $ticket->folio }} — {{ $ticket->asunto }}</h4>
            </div>

            <div class="card-body">
                <p><strong>Solicitante:</strong> {{ $ticket->nombre }}</p>
                <p><strong>Correo:</strong> {{ $ticket->email }}</p>
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
        <div class="app-chat card overflow-hidden p-2">
            <div class="chat-history-wrapper">
                {{-- Chat messages --}}
                <div class="chat-history-body" id="chatContainer" style="height: 700px; overflow-y: auto;">
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
                                    <div class="chat-message-wrapper flex-grow-1" style="max-width: 30%;">
                                        <div
                                            class="chat-message-text p-2 rounded {{ $isMine ? 'bg-primary text-white' : 'bg-light text-dark' }}">
                                            <strong>{{ $mensaje->usuario->name ?? 'Desconocido' }}</strong>
                                            <p class="mb-0">{{ $mensaje->mensaje }}</p>
                                        </div>
                                        <div class="text-muted mt-1 text-end {{ $isMine ? '' : 'text-start' }}">
                                            <small>{{ $mensaje->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </div>

                                    {{-- Mi avatar --}}
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
                    <form id="chatForm" class="form-send-message d-flex justify-content-between align-items-center">
                        <input type="text" class="form-control message-input me-4 shadow-none"
                            placeholder="Type your message here..." name="mensaje" id="nuevoMensaje">
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
                if (!mensaje) return;

                $.post("{{ route('tickets.mensajes.store', $ticket->id_ticket) }}", {
                    mensaje
                }, function(res) {
                    if (res.success) {
                        const html = `
                        <li class="chat-message chat-message-right">
                            <div class="d-flex justify-content-end overflow-hidden">
                                <div class="chat-message-wrapper flex-grow-1" style="max-width: 70%;">
                                    <div class="chat-message-text p-2 rounded bg-primary text-white">
                                        <strong>${res.mensaje.usuario.name}</strong>
                                        <p class="mb-0">${res.mensaje.mensaje}</p>
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
                        chatContainer.find('ul').append(html);
                        $('#nuevoMensaje').val('');
                        chatContainer.scrollTop(chatContainer[0].scrollHeight);
                    }
                });
            });
        });


function actualizarColorSelect() {
    const select = document.getElementById('selectEstatus');
    const valor = select.value;
    let color = '#6c757d'; // secondary por defecto

    if(valor === 'pendiente') color = '#f0ad4e';
    if(valor === 'abierto') color = '#28a745';
    if(valor === 'cerrado') color = '#dc3545';

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
