<!-- Modal para ver el documento -->
<div class="modal fade" id="modalVerDocumento" tabindex="-1" aria-labelledby="modalVerDocumentoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVerDocumentoLabel">Ver Documento FQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabla de Documentos -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tipo de Documento</th>
                            <th>Documento</th>
                        </tr>
                    </thead>
                    <tbody id="documentosTableBody">
                        <!-- Los documentos se agregarán aquí dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Mostrar PDF -->
<div class="modal fade" id="mostrarPdfDictamen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-simple">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body p-0 d-flex flex-column justify-content-center align-items-center">
          <div class="text-center mb-6">
            <h4 id="titulo_modal_Dictamen" class="address-title mb-2"></h4>
          </div>
          <div id="loading-spinner" class="text-center my-3" style="display: none; height: 70vh;">
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
  
