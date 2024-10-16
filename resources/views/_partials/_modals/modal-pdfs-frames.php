<!-- Add New Address Modal -->
<div class="modal fade" id="mostrarPdf" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-simple">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0">
        <div class="text-center mb-6">
          <h4 id="titulo_modal" class="address-title mb-2"></h4>
          <p id="subtitulo_modal" class="address-subtitle"></p>
        </div>
        <div class="row">
        <iframe src="" id="pdfViewer"  width="100%" height="800px" style="border: none;"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>


<!--/  Modal para dictamenes grnel-->
<div class="modal fade" id="mostrarPdfDictamen" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-simple">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0 d-flex flex-column justify-content-center align-items-center">
        <div class="text-center mb-6">
          <h4 id="titulo_modal_Dictamen" class="address-title mb-2"></h4>
          <p id="subtitulo_modal_Dictamen" class="address-subtitle"></p>
        </div>
        
        <div id="loading-spinner" class="text-center my-3" style="display: flex; height: 70vh;   justify-content: center;  align-items: center;">
          <div class="sk-circle-fade sk-primary" style="width: 4rem; height: 4rem;">
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
          </div>
        </div>

        <iframe src="" id="pdfViewerDictamen" width="100%" height="800px" style="border: none;"></iframe>
      </div>
    </div>
  </div>
</div>



<!-- Modal para dictamenes guias -->
<div class="modal fade" id="mostrarPdfGUias" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-simple">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body p-0 d-flex flex-column justify-content-center align-items-center">
        <div class="text-center mb-6">
          <h4 id="titulo_modal_GUIAS" class="address-title mb-2"></h4>
          <p id="subtitulo_modal_GUIAS" class="address-subtitle"></p>
        </div>

        <div id="loading-spinner-chelo" class="text-center my-3" style="display: flex; height: 70vh;   justify-content: center;  align-items: center;">
          <div class="sk-circle-fade sk-primary" style="width: 4rem; height: 4rem;">
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
            <div class="sk-circle-fade-dot"></div>
          </div>
        </div>
        <!-- Botón para descargar el PDF -->
        <a href="#" id="descargarPdfBtn" class="btn btn-primary position-absolute waves-effect" style="top: 0; right: 0; margin: 15px;">Descargar PDF</a>
          <iframe src="" id="pdfViewerGuias" width="100%" height="800px" style="border: none;"></iframe>

      </div>
    </div>
  </div>
</div>





