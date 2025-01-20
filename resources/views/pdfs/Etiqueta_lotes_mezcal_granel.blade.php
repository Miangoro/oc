

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta para lotes de mezcal a granel</title>
    <style>
    @page {
            size: 292mm 227mm;
        }
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    margin-top: -20;
}

.etiqueta-table {
    width: 100%;
    margin: 10px 0;
}

.etiqueta-table td,
.etiqueta-table th {
    padding: 2px;
    font-size: 8px;
    border: 0.5px solid #595959;
    height: 17px;
}

.etiqueta-table .custom-title {
    font-size: 10px;
    font-weight: bold;
    background-color: #3C8A69;
    color: white;
    border: 0.5px solid white;
}

.etiqueta-table .custom {
    font-size: 16px;
    font-weight: bold;
    background-color: #3C8A69;
    color: white;
    border: 0.5px solid white;
}

.etiqueta-table .logo-small {
    max-width: 120px;
    height: auto;
}

.etiqueta-table .header-cell-custom {
    background: #3C8A69;
    color: white;
    text-align: center;
    border: 0.5px solid white;
}

.etiqueta-table .white-background-custom {
    background-color: white;
    color: black;
    border: 0.5px solid #3C8A69;
}

.etiqueta-table .border-green-custom {
    border: 1px solid #3C8A69;
}

.etiqueta-table .narrow-margin-custom {
    margin-top: 0;
}

table {
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #3C8A69;
        padding: 3px;
        text-align: center;
        vertical-align: middle;
    }

    th {
        background: #f0e6cc;
    }

    .even {
        background: #fbf8f0;
    }

    .odd {
        background: #fefcf9;
    }

    .top {
    margin-top: -20px;
    }
    </style>
</head>
<body>

    <!-- primera tabla -->
    <table class="etiqueta-table">
    <tbody>
            <tr>
                <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small"></td>
                <td colspan="6" class="custom">Etiqueta para lotes de mezcal a granel</td>
                <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo-small"></td>
            </tr>
            <tr>
                <td class="custom-title">Fecha:</td>
                <td colspan="2" class="white-background-custom"><strong>01/08/2024</strong></td>
                <td class="custom-title">Folio / No. de servicio:</td>
                <td colspan="2" class="white-background-custom"><strong>UMS-1300/2024</strong></td>
            </tr>
            <tr>
                <td class="custom-title">No. de lote:</td>
                <td colspan="2" class="white-background-custom"><strong>2401ESPTOB</strong></td>
                <td class="custom-title">Volumen del lote:</td>
                <td colspan="2" class="white-background-custom"><strong>25363 L</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Razón Social / Productor:</td>
                <td colspan="3" class="white-background-custom"><strong>Maguey Espadín, Maguey Tobalá (A. angustifolia), (A. potatorum)</strong></td>
                <td colspan="2" class="custom-title">Nombre de la marca:</td>
                <td colspan="2" class="white-background-custom"><strong>Mezcal Artesanal, Blanco o Joven</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="custom-title"  style="text-align: left;">Categoría y clase:</td>
                <td colspan="3" class="white-background-custom"><strong>Por definir</strong></td>
                <td colspan="2" class="custom-title">Especie de agave: </td>
                <td colspan="2" class="white-background-custom"><strong>Laboratorio</strong></td>
            </tr>
            <tr>
              <td class="custom-title"  style="text-align: left;">No. de Análisis Fisicoquímicos:</td>
              <td class="white-background-custom"><strong>1998</strong></td>
              <td class="custom-title">ID del tanque: </td>
              <td colspan="2" class="white-background-custom"><strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</strong></td>
              <td class="custom-title">No. de certificado NOM:</td>
              <td colspan="2" class="white-background-custom"><strong>Oaxaca</strong></td>
          </tr>
            <tr>
                <td colspan="2" class="custom-title">Nombre y firma del inspector:</td>
                <td colspan="2" class="white-background-custom"><strong>Idalia González Zarate</strong></td>
                <td colspan="2" class="custom-title">Nombre y firma del responsable:</td>
                <td colspan="2" class="white-background-custom"><strong>Juan Carlos López Hernández</strong></td>
            </tr>
        </tbody>
    </table>
{{-- segunda tabla --}}
    <table class="etiqueta-table">
      <tbody>
              <tr>
                  <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small"></td>
                  <td colspan="6" class="custom">Etiqueta para lotes de mezcal a granel</td>
                  <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo-small"></td>
              </tr>
              <tr>
                  <td class="custom-title">Fecha:</td>
                  <td colspan="2" class="white-background-custom"><strong>01/08/2024</strong></td>
                  <td class="custom-title">Folio / No. de servicio:</td>
                  <td colspan="2" class="white-background-custom"><strong>UMS-1300/2024</strong></td>
              </tr>
              <tr>
                  <td class="custom-title">No. de lote:</td>
                  <td colspan="2" class="white-background-custom"><strong>2401ESPTOB</strong></td>
                  <td class="custom-title">Volumen del lote:</td>
                  <td colspan="2" class="white-background-custom"><strong>25363 L</strong></td>
              </tr>
              <tr>
                  <td class="custom-title" style="text-align: left;">Razón Social / Productor:</td>
                  <td colspan="3" class="white-background-custom"><strong>Maguey Espadín, Maguey Tobalá (A. angustifolia), (A. potatorum)</strong></td>
                  <td colspan="2" class="custom-title">Nombre de la marca:</td>
                  <td colspan="2" class="white-background-custom"><strong>Mezcal Artesanal, Blanco o Joven</strong></td>
              </tr>
              <tr>
                  <td colspan="1" class="custom-title"  style="text-align: left;">Categoría y clase:</td>
                  <td colspan="3" class="white-background-custom"><strong>Por definir</strong></td>
                  <td colspan="2" class="custom-title">Especie de agave: </td>
                  <td colspan="2" class="white-background-custom"><strong>Laboratorio</strong></td>
              </tr>
              <tr>
                <td class="custom-title"  style="text-align: left;">No. de Análisis Fisicoquímicos:</td>
                <td class="white-background-custom"><strong>1998</strong></td>
                <td class="custom-title">ID del tanque: </td>
                <td colspan="2" class="white-background-custom"><strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</strong></td>
                <td class="custom-title">No. de certificado NOM:</td>
                <td colspan="2" class="white-background-custom"><strong>Oaxaca</strong></td>
            </tr>
              <tr>
                  <td colspan="2" class="custom-title">Nombre y firma del inspector:</td>
                  <td colspan="2" class="white-background-custom"><strong>Idalia González Zarate</strong></td>
                  <td colspan="2" class="custom-title">Nombre y firma del responsable:</td>
                  <td colspan="2" class="white-background-custom"><strong>Juan Carlos López Hernández</strong></td>
              </tr>
          </tbody>
      </table>
     {{-- segunda tabla --}}
      <table class="etiqueta-table">
        <tbody>
                <tr>
                    <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small"></td>
                    <td colspan="6" class="custom">Etiqueta para lotes de mezcal a granel</td>
                    <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo-small"></td>
                </tr>
                <tr>
                    <td class="custom-title">Fecha:</td>
                    <td colspan="2" class="white-background-custom"><strong>01/08/2024</strong></td>
                    <td class="custom-title">Folio / No. de servicio:</td>
                    <td colspan="2" class="white-background-custom"><strong>UMS-1300/2024</strong></td>
                </tr>
                <tr>
                    <td class="custom-title">No. de lote:</td>
                    <td colspan="2" class="white-background-custom"><strong>2401ESPTOB</strong></td>
                    <td class="custom-title">Volumen del lote:</td>
                    <td colspan="2" class="white-background-custom"><strong>25363 L</strong></td>
                </tr>
                <tr>
                    <td class="custom-title" style="text-align: left;">Razón Social / Productor:</td>
                    <td colspan="3" class="white-background-custom"><strong>Maguey Espadín, Maguey Tobalá (A. angustifolia), (A. potatorum)</strong></td>
                    <td colspan="2" class="custom-title">Nombre de la marca:</td>
                    <td colspan="2" class="white-background-custom"><strong>Mezcal Artesanal, Blanco o Joven</strong></td>
                </tr>
                <tr>
                    <td colspan="1" class="custom-title"  style="text-align: left;">Categoría y clase:</td>
                    <td colspan="3" class="white-background-custom"><strong>Por definir</strong></td>
                    <td colspan="2" class="custom-title">Especie de agave: </td>
                    <td colspan="2" class="white-background-custom"><strong>Laboratorio</strong></td>
                </tr>
                <tr>
                  <td class="custom-title"  style="text-align: left;">No. de Análisis Fisicoquímicos:</td>
                  <td class="white-background-custom"><strong>1998</strong></td>
                  <td class="custom-title">ID del tanque: </td>
                  <td colspan="2" class="white-background-custom"><strong>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</strong></td>
                  <td class="custom-title">No. de certificado NOM:</td>
                  <td colspan="2" class="white-background-custom"><strong>Oaxaca</strong></td>
              </tr>
                <tr>
                    <td colspan="2" class="custom-title">Nombre y firma del inspector:</td>
                    <td colspan="2" class="white-background-custom"><strong>Idalia González Zarate</strong></td>
                    <td colspan="2" class="custom-title">Nombre y firma del responsable:</td>
                    <td colspan="2" class="white-background-custom"><strong>Juan Carlos López Hernández</strong></td>
                </tr>
            </tbody>
        </table>


        <!-- Footer sin tablas -->
        <div class="footer">
        <div class="footer-left">
            <p>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michpacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.</p>
        </div>
        <div class="footer-right">
            <p>F-UV-04-04 <br> Edición 16, 15/07/2024</p>
        </div>
    </div>
</body>
</html>
