<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiqueta para tapa de la muestra</title>
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
            padding: 2px;
            border: 2px solid #3C8A69;
            text-align: center;
            vertical-align: middle;
            height: 17px;
        }

        .custom {
            font-size: 13px;
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
        }

        .custom-title {
            font-size: 20px;
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border-bottom: 2px solid white !important;
        }

        .logo-small {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
    <table class="etiqueta-table">
        <tbody>
            <tr>
                <td colspan="2" rowspan="3" class="border-green-custom">
                    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
                </td>
                <td colspan="4" class="custom-title">Etiqueta para agave (%ART)</td>
                <td colspan="2" rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Organismo Certificador" class="logo-small"></td>
            </tr>
            <tr>
                <td class="custom">Fecha de muestreo:</td>
                <td>10/06/2024</td>
                <td class="custom">Folio / No. de servicio:</td>
                <td>UMS-01002/2024</td>
            </tr>
            <tr>
                <td>No. de lote o tapada:</td>
                <td>TAP-AMT-71CLS</td>
                <td>Peso total del maguey:</td>
                <td>20090</td>
            </tr>
            <tr>
                <td colspan="2">Razón Social / Productor:</td>
                <td colspan="2">Amantes del Mezcal S.A. de C.V.</td>
                <td>No. de piñas anterior:</td>
                <td colspan="3">3012</td>
            </tr>
            <tr>
                <td colspan="2" rowspan="4">Domicilio:</td>
                <td colspan="2" rowspan="4">Paraje Salina Grande S/N Tlacolula de Matamoros, Oaxaca C.P. 70403</td>
                <td>No. de piñas comercializadas:</td>
                <td colspan="3">930</td>
            </tr>
            <tr>
                <td>No. de piñas actual:</td>
                <td colspan="3">2082</td>
            </tr>
            <tr>
                <td>No. de guías del maguey:</td>
                <td colspan="3">525G005</td>
            </tr>
            <tr>
                <td>Especie o tipo de agave:</td>
                <td colspan="3">Maguey Espadín (A. angustifolia)</td>
            </tr>
            <tr>
                <td colspan="2">Maestro mezcalero:</td>
                <td colspan="2">Hugo César García González</td>
                <td>Edad del agave:</td>
                <td colspan="3">5 años</td>
            </tr>
            <tr>
                <td colspan="2">Nombre y firma del responsable:</td>
                <td colspan="2">Ismael Ortega Lopez</td>
                <td>Nombre y firma del inspector:</td>
                <td colspan="3">Lidia Isabel Cabrera Vásquez</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
