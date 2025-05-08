<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado como Productor de Mezcal A</title>
    <style>
        body {
            font-family: 'Calibri', sans-serif;
        }

        .watermark {
            position: absolute;
            top: 43%;
            left: 55%;
            width: 50%;
            height: auto;
            transform: translate(-50%, -50%);
            opacity: 0.3;
            z-index: -1;
        }

        .watermark-cancelado {
            font-family: Arial;
            color: red;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg) scaleY(1.2);
            opacity: 0.5;
            letter-spacing: 3px;
            font-size: 150px;
            white-space: nowrap;
            z-index: -1;
        }

        .header img {
            float: left;
            margin-left: -10px;
            margin-top: -30px;
        }

        .description1 {
            font-size: 25px;
            font-weight: bold;
            text-align: right;
        }

        .description2 {
            font-weight: bold;
            font-size: 14px;
            color: #5A5768;
            white-space: nowrap;
            position: relative;
            top: -64px;
            left: 295px;
        }

        .description3 {
            font-weight: bold;
            margin-right: 30px;
            text-align: right;
            font-size: 13px;
            position: relative;
            top: -30px;
        }

        .text {
            font-size: 12.5px;
            line-height: 1;
            text-align: justify;
            margin: 10px 20px;
        }

        .text1 {
            font-size: 12.5px;
            line-height: 1;
            text-align: justify;
            margin: -5px 20px;
        }

        .title {
            font-size: 24px;
            text-align: center;
            font-weight: bold;
            letter-spacing: 9px;
            line-height: 0.5;
        }

        .title2 {
            font-size: 24px;
            text-align: center;
            font-weight: bold;
            line-height: 0.5;
        }

        .title3 {
            font-size: 19px;
            text-align: center;
            font-weight: bold;
            color: #0C1444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
           
        }

        td {
            border: 1px solid black;
            text-align: center;
            font-size: 11px;
            padding: 1px;
        }

        th {
            background-color: #608390;
            color: white;
            text-align: center;
            font-size: 11px;
        }

        .cidam {
            color: #161c4a;
            text-align: center;
            margin-left: 0;
            margin-bottom: 20px;
        }

        .td-no-margins {
            border: none;
        }

        .td-margins {
            border-right: none;
            border-left: none;
            font-size: 11px;
        }

        .even {
            background: #fbf8f0;
        }

        .odd {
            background: #fefcf9;
        }

        .cell {
            border-right: 1px solid transparent;
            white-space: nowrap;
        }

        .cell1 {
            white-space: nowrap;
        }

        .cent {
            white-space: normal;
        }

        .signature {
            margin: 20px 10px;
            text-align: center;
            margin-top: 20px;
        }

        .signature-line {
            line-height: 10;
            border-top: 1px solid #000;
            width: 240px;
            margin: 0 auto;
            padding-top: 5px;
        }

        .signature-name {
            font-family: Arial;
            margin: 10px 0 0;
            font-size: 13px;
            font-weight: bold;
            line-height: 0.5;
        }

        .footer {
            position: fixed;
            bottom: -22px;
            width: 100%;
            text-align: center;
        }

        #tabla-principal td {
            line-height: 9px;
            overflow: hidden;
            border: solid 2.5px;
        }
    </style>
</head>

<body>

    @if ($watermarkText)
        <div class="watermark-cancelado">
            Cancelado
        </div>
    @endif

    <img src="{{ public_path('img_pdf/logo_fondo.png') }}" alt="Fondo CIDAM" class="watermark">

    <div class="header">
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo Organismo" width="300px">
    </div>

    <div class="description1">ORGANISMO CERTIFICADOR</div>
    <div class="description2">
        Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C.
    </div>
    <div class="description3">No. CERTIFICADO: {{ $num_certificado }}</div>

    <p class="text1">
        Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C. — Acreditado como organismo de
        certificación de producto con número de acreditación 144/18 ante la Entidad Mexicana de Acreditación, A.C. —
        otorga el siguiente:
    </p>

    <p class="title">CERTIFICADO</p>
    <p class="title2">COMO COMERCIALIZADOR DE MEZCAL A</p>

    <table>
        <tbody>
            <tr>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    <strong>Razón social:</strong>
                </td>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    {{ $razon_social }}
                </td>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    <strong>No. de cliente:</strong>
                </td>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    {{ $numero_cliente }}
                </td>
            </tr>
            <tr>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    <strong>Representante legal:</strong>
                </td>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    {{ $representante_legal }}
                </td>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    <strong>RFC:</strong>
                </td>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    {{ $rfc }}
                </td>
            </tr>
            <tr>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    <strong>Domicilio Fiscal:</strong>
                </td>
                <td class="td-margins" style="text-align: left; padding-top: 8px;padding-bottom: 8px;" colspan="3">
                    {{ $domicilio_fiscal }}
                </td>
            </tr>
            <tr>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    <strong>Correo electrónico:</strong>
                </td>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    {{ $correo }}
                </td>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    <strong>Teléfono:</strong>
                </td>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    {{ $telefono }}
                </td>
            </tr>
            <tr>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    <strong>Fecha de emisión:</strong>
                </td>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    {{ $fecha_emision }}
                </td>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    <strong>Fecha de vigencia:</strong>
                </td>
                <td class="td-margins"
                    style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                    {{ $fecha_vigencia }}
                </td>
            </tr>
        </tbody>
    </table>

    <p class="text">
        El presente certificado es emitido de acuerdo con la Norma Oficial Mexicana NOM-070-SCFI-2016, Bebidas
        Alcohólicas-Mezcal-Especificaciones, mediante el esquema de certificación para los siguientes productos con
        Denominación de Origen.
    </p>
    <table>
        <tbody>
            <tr>
                <td class="td-margins" style="font-weight: bold; font-size: 12px; text-align: left; padding: 10px;">
                    <strong>Categorías:</strong>
                </td>
                <td class="td-margins" style="text-align: left; padding: 10px;">
                    {{ $categorias }}
                </td>
            </tr>
            <tr>
                <td class="td-margins" style="font-weight: bold; font-size: 12px; text-align: left; padding: 10px;">
                    <strong>Clases:</strong>
                </td>
                <td class="td-margins" style="text-align: left; padding: 10px;">
                    {{ $clases }}
                </td>
            </tr>
        </tbody>
    </table>

    <p class="text">
        Esta empresa ha demostrado que cuenta con la infraestructura, conocimientos y la práctica necesaria para
        ejecutar las etapas de comercialización de la Bebida Alcohólica Destilada Denominada Mezcal, de conformidad con
        lo establecido en la NOM-070-SCFI-2016, Bebidas Alcohólicas-Mezcal-Especificaciones.
    </p>

    <table>
    <tbody>
        <tr>
            <td class="td-margins" style="font-weight: bold; font-size: 12px; text-align: left; padding: 10px;">
                <strong>Marcas:</strong>
            </td>
            <td class="td-margins" style="text-align: left; padding: 10px;">
                {{ $marcas }}
            </td>
        </tr>
        <tr>
            <td class="td-margins" style="font-weight: bold; font-size: 12px; text-align: left; padding: 10px;">
                <strong>Domicilio de la unidad de comercialización y/o almacén:</strong>
            </td>
            <td class="td-margins" style="text-align: left; padding: 10px;">
                {{ $domicilio_unidad }}
            </td>
        </tr>
        <tr>
            <td class="td-margins" style="font-weight: bold; font-size: 12px; text-align: left; padding: 10px;">
                <strong>No. de dictamen de cumplimiento con la NOM:</strong>
            </td>
            <td class="td-margins" style="text-align: left; padding: 10px;">
                {{ $num_dictamen }}
            </td>
        </tr>
        <tr>
            <td class="td-margins" style="font-weight: bold; font-size: 12px; text-align: left; padding: 10px;">
                <strong>Convenio de corresponsabilidad:</strong>
            </td>
            <td class="td-margins" style="text-align: left; padding: 10px;">
                {{ $convenio_corresponsabilidad }}
            </td>
        </tr>
    </tbody>
</table>


    <div class="signature">
        <img src="{{ public_path('img_pdf/firmapdf.jpg') }}" alt="Firma"
            style="display: block; margin: 0 auto; height: 50px; width: auto; position: relative; top: -20px;">
        <div class="signature-line"></div>
        <div class="signature-name">{{ $nombre_firmante }}</div>
        <div class="signature-name">{{ $puesto_firmante }}</div>
    </div>

    <<div class="footer">
        <p style="text-align: right; font-size: 9px; line-height: 1; margin-bottom: 1px;">
           
            <br>Certificado como Comercializador de Mezcal NOM-070-SCFI-2016 F7.1-01-37<br>
            Edición 6 Entrada en vigor: 01/04/2025
        </p>
        <img src="{{ public_path('img_pdf/pie_certificado.png') }}" alt="pie de pagina" width="705px">
        </div>

</body>

</html>