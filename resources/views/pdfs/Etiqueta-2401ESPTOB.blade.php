<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta para tapa de la muestra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid #3C8A69;
            margin: 20px 0;
            table-layout: fixed;
        }
        th, td {
            border: 2px solid #3C8A69;
            padding: 6px;
            text-align: center;
            font-size: 12px;
            word-wrap: break-word;
        }
        .header {
            background-color: #3C8A69;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }
        .section-title {
            background-color: #3C8A69;
            color: white;
            font-weight: bold;
        }
        .logo {
            width: 200px;
            height: auto;
        }
        .highlight {
            font-size: 10px; /* Tamaño de texto específico */
        }
        .border-bottom-white {
            border-bottom: 2px solid #FFFFFF; /* Borde inferior blanco */
        }
        .border-right-white {
            border-right: 2px solid #FFFFFF; /* Borde derecho blanco */
        }
        .border-left-white {
            border-left: 2px solid #FFFFFF; /* Borde izquierdo blanco */
        }
        .border-green {
            border-color: #3C8A69 !important; /* Borde verde */
        }
        .footer {
            width: 100%;
            border-top: 2px solid #3C8A69;
            margin-top: 20px;
            border-color: white !important; /* Borde verde */

        }
        .footer-content {
            display: table;
            width: 100%;
            border-collapse: collapse;
            border-color: white !important; /* Borde verde */

        }
        .footer-content td {
            padding: 10px;
            font-size: 10px;
            border-color: white !important; /* Borde verde */

        }
        .footer-left {
            width: 70%; /* Aumentar ancho para el texto largo */
            text-align: center; /* Centrar texto */
            border-right: 2px solid #FFFFFF; /* Borde derecho blanco */
        }
        .footer-right {
            width: 30%; /* Mantener ancho para el texto corto */
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <table>
        <tr>
            <td rowspan="5"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo"></td>
            <td colspan="2" class="header border-bottom-white">Etiqueta para tapa de la <br> muestra</td>
            <td rowspan="5"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo"></td>
        </tr>
        <tr>
            <td class="section-title border-right-white">Fecha:</td>
            <td class="section-title border-left-white">Producto:</td>
        </tr>
        <tr>
            <td class="highlight border-right-white">01/08/2024</td>
            <td class="highlight border-left-white">Mezcal Artesanal - Blanco o Joven</td>
        </tr>
        <tr>
            <td class="section-title border-right-white">No. de lote:</td>
            <td class="section-title border-left-white">Folio o No.</td>
        </tr>
        <tr>
            <td class="highlight border-right-white border-green">2401ESPTOB</td>
            <td class="highlight border-left-white border-green">UMS-1300/2024</td>
        </tr>
    </table>
    <br>
    <table>
      <tr>
          <td rowspan="5"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo"></td>
          <td colspan="2" class="header border-bottom-white">Etiqueta para tapa de la <br> muestra</td>
          <td rowspan="5"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo"></td>
      </tr>
      <tr>
          <td class="section-title border-right-white">Fecha:</td>
          <td class="section-title border-left-white">Producto:</td>
      </tr>
      <tr>
          <td class="highlight border-right-white">01/08/2024</td>
          <td class="highlight border-left-white">Mezcal Artesanal - Blanco o Joven</td>
      </tr>
      <tr>
          <td class="section-title border-right-white">No. de lote:</td>
          <td class="section-title border-left-white">Folio o No.</td>
      </tr>
      <tr>
          <td class="highlight border-right-white border-green">2401ESPTOB</td>
          <td class="highlight border-left-white border-green">UMS-1300/2024</td>
      </tr>
  </table>
  <br>
  <table>
    <tr>
        <td rowspan="5"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo"></td>
        <td colspan="2" class="header border-bottom-white">Etiqueta para tapa de la <br> muestra</td>
        <td rowspan="5"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo"></td>
    </tr>
    <tr>
        <td class="section-title border-right-white">Fecha:</td>
        <td class="section-title border-left-white">Producto:</td>
    </tr>
    <tr>
        <td class="highlight border-right-white">01/08/2024</td>
        <td class="highlight border-left-white">Mezcal Artesanal - Blanco o Joven</td>
    </tr>
    <tr>
        <td class="section-title border-right-white">No. de lote:</td>
        <td class="section-title border-left-white">Folio o No.</td>
    </tr>
    <tr>
        <td class="highlight border-right-white border-green">2401ESPTOB</td>
        <td class="highlight border-left-white border-green">UMS-1300/2024</td>
    </tr>
</table>
    <div class="footer">
        <table class="footer-content">
            <tr>
                <td class="footer-left">
                    Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michpacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.
                </td>
                <td class="footer-right">
                    F-UV-04-04 <br>
                    Edición 16, 15/07/2024
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta para sellado de tanques</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%; /* Ajusta el tamaño de la tabla según sea necesario */
        }
        td, th {
            border: 1px solid #3C8A69; /* Borde verde para celdas generales */
            padding: 3px;
            text-align: center;
            vertical-align: middle; /* Alinea verticalmente al centro */
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
        .header-cell {
            background-color: #3C8A69; /* Fondo verde para celdas con texto diferente a LOGO */
            color: white;
            font-weight: bold;
            border: 1px solid white; /* Borde blanco para las celdas internas de la tabla */
        }
        .logo-cell {
            background-color: white; /* Fondo blanco solo para celdas con LOGO */
            border: 1px solid #3C8A69; /* Borde verde para las celdas con LOGO */
        }
        .logo-cell img {
            max-width: 100px; /* Ajusta el tamaño del logo según sea necesario */
            height: auto;
        }
    </style>
</head>
<body>

    <table>
        <tbody>
            <tr>
                <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo">
                </td>
                <td colspan="6" class="header-cell" style="text-align: center; font-size: 16px;">Etiqueta para sellado de tanques</td>
                <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo">
                </td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 12px;">Fecha:</td>
                <td colspan="2" style="font-size: 10px;">01/08/2024</td>
                <td class="header-cell" style="font-size: 12px;">Folio / No. de servicio:</td>
                <td colspan="2" style="font-size: 10px;">UMS-1300/2024</td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 12px;">No. de lote:</td>
                <td colspan="2" style="font-size: 10px;">2401ESPTOB</td>
                <td class="header-cell" style="font-size: 12px;">Volumen del lote:</td>
                <td colspan="2" style="font-size: 10px;">25363 L</td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell" style="font-size: 12px;">Razón Social / Productor:</td>
                <td colspan="2" style="font-size: 10px;">AMANTES DEL MEZCAL S.A. DE C.V.</td>
                <td colspan="2" class="header-cell" style="font-size: 12px;">Nombre de la marca:</td>
                <td colspan="2" style="font-size: 10px;">Por definir</td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 12px;">Categoría y clase:</td>
                <td style="font-size: 10px;">Mezcal Artesanal, Blanco o Joven</td>
                <td class="header-cell" style="font-size: 12px;">Especie de agave:</td>
                <td style="font-size: 10px;">A. Angustifolia- A. Potatorum</td>
                <td class="header-cell" style="font-size: 12px;">Edad:</td>
                <td style="font-size: 10px;">NA</td>
                <td class="header-cell" style="font-size: 12px;">Ingredientes:</td>
                <td style="font-size: 10px;">NA</td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 12px;">No. de Análisis Fisicoquímicos:</td>
                <td style="font-size: 10px;">NNMZ-46335-S1</td>
                <td class="header-cell" style="font-size: 12px;">ID del tanque:</td>
                <td style="font-size: 10px;">REMOLQUE 204</td>
                <td colspan="2" class="header-cell" style="font-size: 12px;">No. de certificado NOM:</td>
                <td colspan="2" style="font-size: 10px;">CIDAM C-GRA-180/2024</td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell" style="font-size: 12px;">Nombre y firma del inspector:</td>
                <td colspan="2" style="font-size: 10px;">Idalia González Zarate</td>
                <td colspan="2" class="header-cell" style="font-size: 12px;">Nombre y firma del responsable:</td>
                <td colspan="2" style="font-size: 10px;">Juan Carlos López Hernández</td>
            </tr>
        </tbody>
    </table>

    <table>
      <tbody>
          <tr>
              <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                  <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo">
              </td>
              <td colspan="6" class="header-cell" style="text-align: center; font-size: 16px;">Etiqueta para sellado de tanques</td>
              <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                  <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo">
              </td>
          </tr>
          <tr>
              <td class="header-cell" style="font-size: 12px;">Fecha:</td>
              <td colspan="2" style="font-size: 10px;">01/08/2024</td>
              <td class="header-cell" style="font-size: 12px;">Folio / No. de servicio:</td>
              <td colspan="2" style="font-size: 10px;">UMS-1300/2024</td>
          </tr>
          <tr>
              <td class="header-cell" style="font-size: 12px;">No. de lote:</td>
              <td colspan="2" style="font-size: 10px;">2401ESPTOB</td>
              <td class="header-cell" style="font-size: 12px;">Volumen del lote:</td>
              <td colspan="2" style="font-size: 10px;">25363 L</td>
          </tr>
          <tr>
              <td colspan="2" class="header-cell" style="font-size: 12px;">Razón Social / Productor:</td>
              <td colspan="2" style="font-size: 10px;">AMANTES DEL MEZCAL S.A. DE C.V.</td>
              <td colspan="2" class="header-cell" style="font-size: 12px;">Nombre de la marca:</td>
              <td colspan="2" style="font-size: 10px;">Por definir</td>
          </tr>
          <tr>
              <td class="header-cell" style="font-size: 12px;">Categoría y clase:</td>
              <td style="font-size: 10px;">Mezcal Artesanal, Blanco o Joven</td>
              <td class="header-cell" style="font-size: 12px;">Especie de agave:</td>
              <td style="font-size: 10px;">A. Angustifolia- A. Potatorum</td>
              <td class="header-cell" style="font-size: 12px;">Edad:</td>
              <td style="font-size: 10px;">NA</td>
              <td class="header-cell" style="font-size: 12px;">Ingredientes:</td>
              <td style="font-size: 10px;">NA</td>
          </tr>
          <tr>
              <td class="header-cell" style="font-size: 12px;">No. de Análisis Fisicoquímicos:</td>
              <td style="font-size: 10px;">NNMZ-46335-S1</td>
              <td class="header-cell" style="font-size: 12px;">ID del tanque:</td>
              <td style="font-size: 10px;">REMOLQUE 204</td>
              <td colspan="2" class="header-cell" style="font-size: 12px;">No. de certificado NOM:</td>
              <td colspan="2" style="font-size: 10px;">CIDAM C-GRA-180/2024</td>
          </tr>
          <tr>
              <td colspan="2" class="header-cell" style="font-size: 12px;">Nombre y firma del inspector:</td>
              <td colspan="2" style="font-size: 10px;">Idalia González Zarate</td>
              <td colspan="2" class="header-cell" style="font-size: 12px;">Nombre y firma del responsable:</td>
              <td colspan="2" style="font-size: 10px;">Juan Carlos López Hernández</td>
          </tr>
      </tbody>
  </table>

  <table>
    <tbody>
        <tr>
            <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo">
            </td>
            <td colspan="6" class="header-cell" style="text-align: center; font-size: 16px;">Etiqueta para sellado de tanques</td>
            <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo">
            </td>
        </tr>
        <tr>
            <td class="header-cell" style="font-size: 12px;">Fecha:</td>
            <td colspan="2" style="font-size: 10px;">01/08/2024</td>
            <td class="header-cell" style="font-size: 12px;">Folio / No. de servicio:</td>
            <td colspan="2" style="font-size: 10px;">UMS-1300/2024</td>
        </tr>
        <tr>
            <td class="header-cell" style="font-size: 12px;">No. de lote:</td>
            <td colspan="2" style="font-size: 10px;">2401ESPTOB</td>
            <td class="header-cell" style="font-size: 12px;">Volumen del lote:</td>
            <td colspan="2" style="font-size: 10px;">25363 L</td>
        </tr>
        <tr>
            <td colspan="2" class="header-cell" style="font-size: 12px;">Razón Social / Productor:</td>
            <td colspan="2" style="font-size: 10px;">AMANTES DEL MEZCAL S.A. DE C.V.</td>
            <td colspan="2" class="header-cell" style="font-size: 12px;">Nombre de la marca:</td>
            <td colspan="2" style="font-size: 10px;">Por definir</td>
        </tr>
        <tr>
            <td class="header-cell" style="font-size: 12px;">Categoría y clase:</td>
            <td style="font-size: 10px;">Mezcal Artesanal, Blanco o Joven</td>
            <td class="header-cell" style="font-size: 12px;">Especie de agave:</td>
            <td style="font-size: 10px;">A. Angustifolia- A. Potatorum</td>
            <td class="header-cell" style="font-size: 12px;">Edad:</td>
            <td style="font-size: 10px;">NA</td>
            <td class="header-cell" style="font-size: 12px;">Ingredientes:</td>
            <td style="font-size: 10px;">NA</td>
        </tr>
        <tr>
            <td class="header-cell" style="font-size: 12px;">No. de Análisis Fisicoquímicos:</td>
            <td style="font-size: 10px;">NNMZ-46335-S1</td>
            <td class="header-cell" style="font-size: 12px;">ID del tanque:</td>
            <td style="font-size: 10px;">REMOLQUE 204</td>
            <td colspan="2" class="header-cell" style="font-size: 12px;">No. de certificado NOM:</td>
            <td colspan="2" style="font-size: 10px;">CIDAM C-GRA-180/2024</td>
        </tr>
        <tr>
            <td colspan="2" class="header-cell" style="font-size: 12px;">Nombre y firma del inspector:</td>
            <td colspan="2" style="font-size: 10px;">Idalia González Zarate</td>
            <td colspan="2" class="header-cell" style="font-size: 12px;">Nombre y firma del responsable:</td>
            <td colspan="2" style="font-size: 10px;">Juan Carlos López Hernández</td>
        </tr>
    </tbody>
</table>
<div class="footer">
  <table class="footer-content">
      <tr>
          <td class="footer-left">
              Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michpacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.
          </td>
          <td class="footer-right">
              F-UV-04-04 <br>
              Edición 16, 15/07/2024
          </td>
      </tr>
  </table>
</div>

</body>
</html>
