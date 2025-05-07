<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta para agave (%ART)</title>
    <style>
        @page {
            size: 292mm 227mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .etiqueta-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        .etiqueta-table th,
        .etiqueta-table td {
            padding: 4px;
            border: 2px solid #3C8A69;
            text-align: center;
            vertical-align: middle;
            height: 17px;
            font-size: 14px;
        }

        .custom {
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-bottom: 2px solid white !important;
        }

        .customx {
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
        }

        .custom-title {
            font-size: 23px !important;
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-bottom: 2px solid white !important;
        }

        .logo-small {
            width: 170px;
            height: auto;
        }

        .logo-smallx {
            width: 200px;
            height: auto;
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

        .footer-bar-left {
            position: fixed;
            bottom: -55px;
            left: 10px;
            right: 10px;
            width: calc(100% - 20px);
            height: 45px;
            font-size: 14px;
            text-align: left;
            padding: 30px 0px;
        }

        .offset-text {
            display: inline-block;
            margin-left: 150px;
        }

        .image-cell {
            width: 200px;
            height: 120px;
        }

        .logo-small {
            max-width: 100%;
            max-height: 100%;
            height: auto;
            width: auto;
        }

        .logo-smallx {
            max-width: 120%;
            max-height: 100%;
            height: auto;
            width: auto;
        }
    </style>
</head>
<body>
    <table class="etiqueta-table">
        <tbody>
            <tr>
                <td colspan="2" rowspan="3" class="border-green-custom image-cell">
                    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
                </td>
                <td colspan="4" class="custom-title">Etiqueta para agave (%ART)</td>
                <td colspan="2" rowspan="3" class="border-green-custom image-cell">
                    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo-smallx">
                </td>
            </tr>
            <tr>
                <td class="custom">Fecha de muestreo:</td>
                <td>10/06/2024</td>
                <td class="custom">Folio / No. de servicio:</td>
                <td>{{ $datos->num_servicio ?? 'NA'}} </td>
            </tr>
            <tr>
                <td class="customx">No. de lote o tapada:</td>
                <td>TAP-AMT-71CLS</td>
                <td class="custom">Peso total del maguey:</td>
                <td>20090</td>
            </tr>
            <tr>
                <td colspan="2" class="custom">Razón Social / Productor:</td>
                <td colspan="2">{{ $datos->empresa_num_cliente ?? 'xd'}}</td>
                <td class="custom">No. de piñas anterior:</td>
                <td colspan="3">3012</td>
            </tr>
            <tr>
                <td colspan="2" rowspan="4" class="custom">Domicilio:</td>
                <td colspan="2" rowspan="4">Paraje Salina Grande S/N Tlacolula de Matamoros, Oaxaca C.P. 70403</td>
                <td class="custom">No. de piñas comercializadas:</td>
                <td colspan="3">930</td>
            </tr>
            <tr>
                <td class="custom">No. de piñas actual:</td>
                <td colspan="3">2082</td>
            </tr>
            <tr>
                <td class="custom">No. de guías del maguey:</td>
                <td colspan="3">525G005</td>
            </tr>
            <tr>
                <td class="custom">Especie o tipo de agave:</td>
                <td colspan="3">Maguey Espadín (A. angustifolia)</td>
            </tr>
            <tr>
                <td colspan="2" class="custom">Maestro mezcalero:</td>
                <td colspan="2">Hugo César García González</td>
                <td class="custom">Edad del agave:</td>
                <td colspan="3">5 años</td>
            </tr>
            <tr>
                <td colspan="2" class="customx">Nombre y firma del responsable:</td>
                <td colspan="2">Ismael Ortega Lopez</td>
                <td class="customx">Nombre y firma del inspector:</td>
                <td colspan="3">Lidia Isabel Cabrera Vásquez</td>
            </tr>
        </tbody>
    </table>

<br>


<table class="etiqueta-table">
        <tbody>
            <tr>
                <td colspan="2" rowspan="3" class="border-green-custom image-cell">
                    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
                </td>
                <td colspan="4" class="custom-title">Etiqueta para agave (%ART)</td>
                <td colspan="2" rowspan="3" class="border-green-custom image-cell">
                    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo-smallx">
                </td>
            </tr>
            <tr>
                <td class="custom">Fecha de muestreo:</td>
                <td>10/06/2024</td>
                <td class="custom">Folio / No. de servicio:</td>
                <td>UMS-01002/2024</td>
            </tr>
            <tr>
                <td class="customx">No. de lote o tapada:</td>
                <td>TAP-AMT-71CLS</td>
                <td class="custom">Peso total del maguey:</td>
                <td>20090</td>
            </tr>
            <tr>
                <td colspan="2" class="custom">Razón Social / Productor:</td>
                <td colspan="2">Amantes del Mezcal S.A. de C.V.</td>
                <td class="custom">No. de piñas anterior:</td>
                <td colspan="3">3012</td>
            </tr>
            <tr>
                <td colspan="2" rowspan="4" class="custom">Domicilio:</td>
                <td colspan="2" rowspan="4">Paraje Salina Grande S/N Tlacolula de Matamoros, Oaxaca C.P. 70403</td>
                <td class="custom">No. de piñas comercializadas:</td>
                <td colspan="3">930</td>
            </tr>
            <tr>
                <td class="custom">No. de piñas actual:</td>
                <td colspan="3">2082</td>
            </tr>
            <tr>
                <td class="custom">No. de guías del maguey:</td>
                <td colspan="3">525G005</td>
            </tr>
            <tr>
                <td class="custom">Especie o tipo de agave:</td>
                <td colspan="3">Maguey Espadín (A. angustifolia)</td>
            </tr>
            <tr>
                <td colspan="2" class="custom">Maestro mezcalero:</td>
                <td colspan="2">Hugo César García González</td>
                <td class="custom">Edad del agave:</td>
                <td colspan="3">5 años</td>
            </tr>
            <tr>
                <td colspan="2" class="customx">Nombre y firma del responsable:</td>
                <td colspan="2">Ismael Ortega Lopez</td>
                <td class="customx">Nombre y firma del inspector:</td>
                <td colspan="3">Lidia Isabel Cabrera Vásquez</td>
            </tr>
        </tbody>
    </table>
    <div class="footer-bar">
        <p>F-UV-04-04 <br> Edición 16, 15/07/2024</p>
    </div>

    <div class="footer-bar-left">
    <p class="text-center vertical-center" style="bottom: 4px;">
        Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michpacán A.C. y no puede ser
        <br>
        <span class="offset-text">distribuido externamente sin la autorización escrita del Director Ejecutivo.</span>
    </p>
</div>

</body>
</html>
