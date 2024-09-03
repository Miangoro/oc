<!-- Modal para dictámenes generales -->
<div class="modal fade" id="mostrarPdfDictamen" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-simple">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <div class="modal-header-content flex-grow-1 text-center">
          <h5 id="titulo_modal_Dictamen" class="modal-title"></h5>
          <p id="subtitulo_modal_Dictamen" class="modal-subtitle"></p>
        </div>
        <!-- Botón para abrir el PDF en una nueva pestaña -->
        <a id="openPdfBtnDictamen" href="#" target="_blank" class="btn btn-primary ms-3" style="display: none;">Abrir PDF en nueva pestaña</a>
        <!-- Botón para cerrar el modal -->
        <button type="button" class="btn-close ms-3" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0 d-flex flex-column justify-content-center align-items-center">
        <!-- Spinner de carga Swing -->
        <div id="loading-spinner" class="text-center my-3" style="height: 70vh; display: flex; justify-content: center; align-items: center;">
          <div class="sk-swing sk-primary">
            <div class="sk-swing-dot"></div>
            <div class="sk-swing-dot"></div>
          </div>
        </div>
        <!-- Visor de PDF -->
        <iframe src="" id="pdfViewerDictamen" width="100%" height="800px" style="border: none; display: none;"></iframe>
      </div>
    </div>
  </div>
</div>


<style>
  #mostrarPdfDictamen .modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem;
  border-bottom: 1px solid #dee2e6;
}

#mostrarPdfDictamen .modal-header-content {
  flex: 1;
  text-align: center;
}

#mostrarPdfDictamen .modal-header .btn-close {
  margin-left: 1rem;
}

#mostrarPdfDictamen .modal-header .btn-primary {
  margin-left: 2rem; /* Ajuste para mover el botón más a la derecha */
}

#mostrarPdfDictamen .modal-title,
#mostrarPdfDictamen .modal-subtitle {
  margin-bottom: 0;
}

#mostrarPdfDictamen .modal-title {
  font-size: 1.5rem; /* Aumenta el tamaño del título */
  font-weight: 500;
  margin-left: 200px;
}

#mostrarPdfDictamen .modal-subtitle {
  font-size: 1.25rem; /* Aumenta el tamaño del subtítulo */
  color: #6c757d;
  margin-left: 200px;
}

/* Estilos específicos para el spinner Swing */
#mostrarPdfDictamen .sk-swing {
  position: relative;
  width: 40px;
  height: 40px;
}

#mostrarPdfDictamen .sk-swing-dot {
  position: absolute;
  width: 10px;
  height: 10px;
  background-color: #6c757d; /* Color gris */
  border-radius: 50%;
  animation: sk-swing-rotate 1.5s infinite linear;
}

#mostrarPdfDictamen .sk-swing-dot:first-child {
  top: 0;
  left: 50%;
  transform-origin: bottom center;
}

#mostrarPdfDictamen .sk-swing-dot:last-child {
  bottom: 0;
  left: 50%;
  transform-origin: top center;
}

@keyframes sk-swing-rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>