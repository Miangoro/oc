<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta_ingreso_a_barrica</title>
    <style>
        @page {
            size: 292mm 227mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            margin-top: -10px;
        }

        .etiqueta-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            table-layout: fixed;
        }

        .etiqueta-table th,
        .etiqueta-table td {
            padding: 3px;
            border: 2px solid #3C8A69;
            text-align: center;
            vertical-align: middle;
            font-size: 13px;
            overflow: hidden;
        }

        .custom {
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-bottom: 2px solid white !important;
        }

        .customd {
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-right: 2px solid white !important;
        }

        .customx {
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
        }

        .custom-title {
            font-size: 20px !important; 
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-bottom: 2px solid white !important;
        }

        .custom-titlex {
            font-size: 17px !important; 
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-bottom: 2px solid white !important;
        }

        .footer-bar {
            position: fixed;
            bottom: -55px;
            right: 10px;
            width: calc(100% - 40px);
            height: 45px;
            font-size: 13px;
            text-align: right;
            padding: 30px 0px;
        }

        .offset-text {
            display: inline-block;
            margin-left: 150px;
        }

        .image-cell {
            width: 100px; 
            height: 100px;
            position: relative;
            text-align: center; 
            vertical-align: middle;
        }

        .image-cellx {
            width: 200px; 
            height: 100px;
            text-align: center;
            vertical-align: middle; 
        }

        .logo-small {
            max-width: 100%;
            max-height: 100%; 
            height: auto; 
            width: auto; 
        }

        .logo-smallx {
            max-width: 120%; 
            max-height: 120%; 
            height: auto; 
            width: auto; 
        }

        .bold {
            font-weight: bold;
            vertical-align: middle; 
            text-align: center; 
            padding: 5px;
        }

        .firma-container {
            text-align: center; 
            vertical-align: middle; 
        }

        .firma {
            width: 100px;
            height: auto; 
            opacity: 0.7; 
            margin-bottom: -5px; 
           }

        .firma-text {
            font-size: 12px;
            text-align: center;
        }

    </style>
</head>
<body>

<table class="etiqueta-table">
    <tbody>
        <tr>
            <td colspan="2" rowspan="5" class="image-cell">
                <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
            </td>
            <td colspan="5" class="custom-title">Etiqueta de ingreso a barricas</td>
            <td colspan="2" rowspan="5" class="image-cellx">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo-smallx">
            </td>
        </tr>
        <tr>
            <td colspan="5" class="custom-titlex">Nombre o Razón social: </td>
        </tr>
        <tr>
            <td colspan="5">GRUPO SONES S.A DE C.V</td>
        </tr>
        <tr>
            <td class="customd">No. de servicio:</td>
            <td class="customd">Fecha:</td>
            <td class="customd">Lote:</td>
            <td class="customd">Categoría:</td>
            <td class="customd">Clase:</td>
        </tr>
        <tr>
            <td>UMS- 0847/2024</td>
            <td>16/05/2024</td>
            <td>2403ESPAMD-A</td>
            <td>Mezcal Artesanal</td>
            <td>Blanco o Joven</td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2" class="custom">Fisicoquímico:</td>
            <td rowspan="2">NNMZ-44608</td>
            <td colspan="2" rowspan="2" class="customx">Grado Alcohólico: </td>
            <td rowspan="2">49.08</td>
            <td class="custom">Barrica: </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td class="customx">De:</td>
            <td colspan="2">84</td>
        </tr>
        <tr>
            <td colspan="2" class="customx">Nombre y firma del inspector: </td>
            <td colspan="3" class="bold firma-container">
                <div class="firma-text">Lidia Isabel Cabrera Vásquez</div>
                <img src="{{ public_path('img_pdf/logoumsn.png') }}" alt="Firma Lidia Isabel Cabrera Vásquez" class="firma">
            </td>
            <td class="customx">Nombre y firma del responsable:</td>
            <td colspan="3" class="bold firma-container">
                <div class="firma-text">Gabina Sánchez Sánchez</div>
                <!-- Lugar si hay firma -->
                <!-- <img src="{{ public_path('img_pdf/logoumsn.png') }}" alt="Firma Lidia Isabel Cabrera Vásquez" class="firma"> -->
            </td>
        </tr>
    </tbody>
</table>

<br>

<table class="etiqueta-table">
    <tbody>
        <tr>
            <td colspan="2" rowspan="5" class="image-cell">
                <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
            </td>
            <td colspan="5" class="custom-title">Etiqueta de ingreso a barricas</td>
            <td colspan="2" rowspan="5" class="image-cellx">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo-smallx">
            </td>
        </tr>
        <tr>
            <td colspan="5" class="custom-titlex">Nombre o Razón social: </td>
        </tr>
        <tr>
            <td colspan="5">GRUPO SONES S.A DE C.V</td>
        </tr>
        <tr>
            <td class="customd">No. de servicio:</td>
            <td class="customd">Fecha:</td>
            <td class="customd">Lote:</td>
            <td class="customd">Categoría:</td>
            <td class="customd">Clase:</td>
        </tr>
        <tr>
            <td>UMS- 0847/2024</td>
            <td>16/05/2024</td>
            <td>2403ESPAMD-A</td>
            <td>Mezcal Artesanal</td>
            <td>Blanco o Joven</td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2" class="custom">Fisicoquímico:</td>
            <td rowspan="2">NNMZ-44608</td>
            <td colspan="2" rowspan="2" class="customx">Grado Alcohólico: </td>
            <td rowspan="2">49.08</td>
            <td class="custom">Barrica: </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td class="customx">De:</td>
            <td colspan="2">84</td>
        </tr>
        <tr>
            <td colspan="2" class="customx">Nombre y firma del inspector: </td>
            <td colspan="3" class="bold firma-container">
                <div class="firma-text">Lidia Isabel Cabrera Vásquez</div>
                <img src="{{ public_path('img_pdf/logoumsn.png') }}" alt="Firma Lidia Isabel Cabrera Vásquez" class="firma">
            </td>
            <td class="customx">Nombre y firma del responsable:</td>
            <td colspan="3" class="bold firma-container">
                <div class="firma-text">Gabina Sánchez Sánchez</div>
                <!-- Lugar si hay firma -->
                <!-- <img src="{{ public_path('img_pdf/logoumsn.png') }}" alt="Firma Lidia Isabel Cabrera Vásquez" class="firma"> -->
            </td>
        </tr>
    </tbody>
</table>

<br>

<table class="etiqueta-table">
    <tbody>
        <tr>
            <td colspan="2" rowspan="5" class="image-cell">
                <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
            </td>
            <td colspan="5" class="custom-title">Etiqueta de ingreso a barricas</td>
            <td colspan="2" rowspan="5" class="image-cellx">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo-smallx">
            </td>
        </tr>
        <tr>
            <td colspan="5" class="custom-titlex">Nombre o Razón social: </td>
        </tr>
        <tr>
            <td colspan="5">GRUPO SONES S.A DE C.V</td>
        </tr>
        <tr>
            <td class="customd">No. de servicio:</td>
            <td class="customd">Fecha:</td>
            <td class="customd">Lote:</td>
            <td class="customd">Categoría:</td>
            <td class="customd">Clase:</td>
        </tr>
        <tr>
            <td>UMS- 0847/2024</td>
            <td>16/05/2024</td>
            <td>2403ESPAMD-A</td>
            <td>Mezcal Artesanal</td>
            <td>Blanco o Joven</td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2" class="custom">Fisicoquímico:</td>
            <td rowspan="2">NNMZ-44608</td>
            <td colspan="2" rowspan="2" class="customx">Grado Alcohólico: </td>
            <td rowspan="2">49.08</td>
            <td class="custom">Barrica: </td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td class="customx">De:</td>
            <td colspan="2">84</td>
        </tr>
        <tr>
            <td colspan="2" class="customx">Nombre y firma del inspector: </td>
            <td colspan="3" class="bold firma-container">
                <div class="firma-text">Lidia Isabel Cabrera Vásquez</div>
                <img src="{{ public_path('img_pdf/logoumsn.png') }}" alt="Firma Lidia Isabel Cabrera Vásquez" class="firma">
            </td>
            <td class="customx">Nombre y firma del responsable:</td>
            <td colspan="3" class="bold firma-container">
                <div class="firma-text">Gabina Sánchez Sánchez</div>
                <!-- Lugar si hay firma -->
                <!-- <img src="{{ public_path('img_pdf/logoumsn.png') }}" alt="Firma Lidia Isabel Cabrera Vásquez" class="firma"> -->
            </td>
        </tr>
    </tbody>
</table>

<div class="footer-bar">
    <p>Entrada en vigor el 15 de julio del 2024<br>Página 1 /1 F-UV-04-04 Versión 16</p>
</div>
</body>
</html>
