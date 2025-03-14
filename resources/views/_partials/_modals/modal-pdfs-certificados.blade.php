<!-- Modal Certificados Intslaciones -->
<div class="modal fade" id="PdfDictamenIntalaciones" tabindex="-1">
  <div class="modal-dialog modal-xl modal-simple">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-header d-flex align-items-center justify-content-center position-relative">
        <div class="text-center">
          <h4 id="titulo_modal_Dictamen" class="address-title mb-2"></h4>
          <p id="subtitulo_modal_Dictamen" class="address-subtitle"></p>
        </div>
        <a id="openPdfBtnDictamen" href="#" target="_blank" class="btn btn-primary position-absolute end-0 me-3" style="display: none;">Abrir PDF en nueva pestaña</a>
      </div>
      <div class="modal-body p-0 d-flex flex-column justify-content-center align-items-center">
        <div id="loading-spinner" class="text-center my-3" style="display: flex; height: 70vh; justify-content: center; align-items: center;">
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

<!-- Modal para ver el documento -->
<div class="modal fade" id="modalVerDocumento" tabindex="-1" aria-labelledby="modalVerDocumentoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content text-center">
          <div class="modal-header">
              <h5 class="modal-title" id="modalVerDocumentoLabel">Certificados de Instalaciones</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <table class="table table-striped">
                  <thead>
                      <tr>
                          <th style="text-align: left;"><b>Nombre</b></th>
                          <th><b>Certificado</b></th>
                      </tr>
                  </thead>
                  <tbody id="documentosTableBody">
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>