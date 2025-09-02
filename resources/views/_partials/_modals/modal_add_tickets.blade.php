{{-- resources/views/tickets/modal_nuevo_ticket.blade.php --}}

<div class="modal fade" id="RegistrarTicket" tabindex="-1" aria-labelledby="RegistrarTicketLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{-- Header --}}
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title mb-2 text-white" id="RegistrarTicketLabel">Crear nuevo ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body">
                <form id="ticketForm" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Datos del solicitante --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre del solicitante</label>
                            <input type="text" name="nombre" id="nombre" class="form-control"
                                value="{{ $usuario->name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ $usuario->email }}" readonly>
                        </div>
                    </div>

                    {{-- Asunto --}}
                    <div class="mb-3">
                        <label for="asunto" class="form-label">Asunto del ticket</label>
                        <input type="text" name="asunto" id="asunto" class="form-control" required>
                    </div>

                    {{-- Descripción --}}
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción detallada</label>
                        <textarea name="descripcion" id="descripcion" rows="4" class="form-control" required></textarea>
                    </div>

                    {{-- Prioridad --}}
                    <div class="mb-3">
                        <label for="prioridad" class="form-label">Prioridad</label>
                        <select name="prioridad" id="prioridad" class="form-select" required>
                            <option value="">Seleccione</option>
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>

                    {{-- Evidencias --}}
                    <div class="mb-3" id="evidencias-container">
                        <label class="form-label">Adjuntar evidencias (PDF, JPG, PNG)</label>

                        <div class="input-group mb-2">
                            <input type="file" name="evidencias[]" class="form-control"
                                accept=".pdf,.jpg,.jpeg,.png">
                            <button type="button" class="btn btn-outline-primary" id="add-evidencia"><i
                                    class="ri-add-line"></i></button>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary me-2"><i class="ri-add-line me-1"></i>
                            Registrar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i
                                class="ri-close-line me-1"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('evidencias-container');
        const addBtn = document.getElementById('add-evidencia');

        addBtn.addEventListener('click', function() {
            const div = document.createElement('div');
            div.classList.add('input-group', 'mb-2');
            div.innerHTML = `
                <input type="file" name="evidencias[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                <button type="button" class="btn btn-outline-danger remove-evidencia"><i class="ri-close-circle-fill"></i></button>
            `;
            container.appendChild(div);
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-evidencia')) {
                e.target.closest('.input-group').remove();
            }
        });
    });
</script>
 --}}
