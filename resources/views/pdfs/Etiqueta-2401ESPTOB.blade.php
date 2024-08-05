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
            width: 150px;
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
            <td rowspan="5"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Unidad de Inspección" class="logo"></td>
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
          <td rowspan="5"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Unidad de Inspección" class="logo"></td>
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
        <td rowspan="5"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Unidad de Inspección" class="logo"></td>
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


    <div class="page-break"></div>
    <div>
        <!-- Contenido de la segunda página -->
        <h1>Segunda Página</h1>
        <p>Contenido de la segunda página.</p>
    </div>
</body>
</html>
