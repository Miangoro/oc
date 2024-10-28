import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import html from '@rollup/plugin-html';
import { glob } from 'glob';

/**
 * Get Files from a directory
 * @param {string} query
 * @returns array
 */
function GetFilesArray(query) {
  return glob.sync(query);
}
/**
 * Js Files
 */
// Page JS Files
const pageJsFiles = GetFilesArray('resources/assets/js/*.js');

// Processing Vendor JS Files
const vendorJsFiles = GetFilesArray('resources/assets/vendor/js/*.js');

// Processing Libs JS Files
const LibsJsFiles = GetFilesArray('resources/assets/vendor/libs/**/*.js');

/**
 * Scss Files
 */
// Processing Core, Themes & Pages Scss Files
const CoreScssFiles = GetFilesArray('resources/assets/vendor/scss/**/!(_)*.scss');

// Processing Libs Scss & Css Files
const LibsScssFiles = GetFilesArray('resources/assets/vendor/libs/**/!(_)*.scss');
const LibsCssFiles = GetFilesArray('resources/assets/vendor/libs/**/*.css');

// Processing Fonts Scss Files
const FontsScssFiles = GetFilesArray('resources/assets/vendor/fonts/**/!(_)*.scss');

// Processing Window Assignment for Libs like jKanban, pdfMake
function libsWindowAssignment() {
  return {
    name: 'libsWindowAssignment',

    transform(src, id) {
      if (id.includes('jkanban.js')) {
        return src.replace('this.jKanban', 'window.jKanban');
      } else if (id.includes('vfs_fonts')) {
        return src.replaceAll('this.pdfMake', 'window.pdfMake');
      }
    }
  };
}

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/assets/css/demo.css',
        'resources/js/app.js',
        ...pageJsFiles,
        ...vendorJsFiles,
        ...LibsJsFiles,
        'resources/js/laravel-user-management.js', // Processing Laravel User Management CRUD JS File
        ...CoreScssFiles,
        ...LibsScssFiles,
        ...LibsCssFiles,
        ...FontsScssFiles,
        'resources/assets/vendor/libs/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js',
        'resources/js/usuarios-personal.js',
        'resources/js/catalogo_clases.js',
        'resources/js/catalogo_lotes.js',
        'resources/js/catalogo_marcas.js',
        'resources/js/categorias.js',
        'resources/js/certificados_instalaciones.js',
        'resources/js/certificados_personal.js',
        'resources/js/clientes_confirmados.js',
        'resources/js/clientes_prospecto.js',
        'resources/js/dictamenes_granel.js',
        'resources/js/dictamenes_instalaciones.js',
        'resources/js/documentos.js',
        'resources/js/domicilio_predios.js',
        'resources/js/domicilios_destinos.js',
        'resources/js/equipos.js',
        'resources/js/guias_maguey_agave.js',
        'resources/js/inspecciones.js',
        'resources/js/instalaciones.js',
        'resources/js/lotes_envasado.js',
        'resources/js/solicitud_hologramas.js',
        'resources/js/solicitudes.js',
        'resources/js/solicitudes-tipo.js',
        'resources/js/tipos.js',
        'resources/js/usuarios-clientes.js',
        'resources/js/usuarios-consejo.js',
        'resources/js/usuarios-inspectores.js',
        'resources/js/usuarios-personal.js'
      ],
      refresh: true
    }),
    html(),
    libsWindowAssignment()
  ],
/*        server: {
    host: '0.0.0.0', // Esto hace que Vite escuche en todas las interfaces de red
    port: 5173,       // Asegúrate de que este puerto esté disponible
    strictPort: true, // Utiliza estrictamente este puerto
    hmr: {
      host: '10.1.30.224', // IP de la máquina del servidor
      port: 5173,
    },
  },  */
});
