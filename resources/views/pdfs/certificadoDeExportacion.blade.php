<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado de Exportacion</title>
    <style>
        @page {
            margin-top: 30;
            margin-right: 20px;
            margin-left: 80px;
            margin-bottom: 1px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            padding-right: 4px;
            padding-left: 4px;
            ;
        }

        .leftLetter {
            text-align: left;
        }

        .letter-color {
            color: #161c4a;
            text-align: center;
            margin-left: 0;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #366091;
            /*             padding-top: 8px;
            padding-bottom: 8px; */
            text-align: center;
            font-size: 11px;

        }

        th {
            background-color: #608390;
            color: white;
            text-align: center;
            font-size: 11px;

        }

        .td-margins {
            border-bottom: 1px solid #366091;
            border-top: 1px solid #366091;
            border-right: none;
            border-left: none;
            font-size: 11px;
        }

        .td-margins-none {
            border-bottom: 1px solid #366091;
            border-top: none;
            border-right: none;
            border-left: none;
            font-size: 11px;
        }

        .td-no-margins {
            border: none;
        }

        .td-barra {
            border-bottom: none;
            border-top: none;
            border-right: none;
            border-left: 1px solid black;
        }

        .img-background {
            position: absolute;
            top: 250px;
            left: 100px;
            width: 530px;
            height: 444px;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/logo_fondo.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.1;
        }

        .img-background-left {
            position: absolute;
            top: 158px;
            left: -70px;
            width: 87px;
            height: 690px;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/exportacion.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .titulos {
            font-size: 15px;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }

        .titutlos-footer {
            font-size: 12px;
            text-align: center;
            font-weight: bold;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="img-background"></div>
    <div class="img-background-left"></div>


    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}"
        style="width: 300px; float: left; margin-left: -20px; margin-top: -20px;" alt="logo de CIDAM 3D">
    <div class="letter-color" style="margin-bottom: 15px">
        <b style="font-size: 16px;">CENTRO DE INNOVACIÓN Y DESARROLLO <br> AGROALIMENTARIO DE MICHOACÁN A.C.</b>
        <p style="font-size: 10px">Organismo de Certificación de producto acreditado ante la <br> entidad mexicana de
            acreditación ema A.C. con <b> No.
                144/18</b></p>
    </div>
    <div class="titulos">
        CERTIFICADO DE AUTENTICIDAD DE EXPORTACIÓN DE MEZCAL
    </div>
    <table>
        <tr>
            <td class="td-no-margins"
                style="font-weight: bold;font-size: 11.5px;padding-right: 4px;padding-left: 0; text-align: left">Número
                de Certificado:</td>
            <td class="td-no-margins"
                style="font-weight: bold;font-size: 11.5px;padding-right: 4px;padding-left: 0; text-align: left">CIDAM
                C-EXP XXX/2024</td>
            <td class="td-no-margins"
                style="font-weight: bold;font-size: 11.5px;padding-right: 4px;padding-left: 0; text-align: right">Fecha
                de <br> expedición:</td>
            <td class="td-no-margins"
                style="font-weight: bold;font-size: 11.5px;padding-right: 4px;padding-left: 0; text-align: right">
                XX/XX/2024</td>
            <td class="td-no-margins"
                style="font-weight: bold;font-size: 11.5px;padding-right: 4px;padding-left: 0; text-align: right">
                Vigencia de 90 días <br> naturales</td>
            <td class="td-no-margins"
                style="font-weight: bold;font-size: 11.5px;padding-right: 4px;padding-left: 0; text-align: right">
                XX/XX/2024</td>
        </tr>
    </table>
    <div class="titulos">
        DATOS GENERALES DEL EXPORTADOR
    </div>
    <table>
        <tr>
            <td class="td-margins"
                style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                Nombre o razón social:</td>
            <td class="td-margins" style="text-align: left">CRISTA LA SANTA S.A.P.I. DE C.V.</td>
            <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
                Número de Cliente:</td>
            <td class="td-margins" style="text-align: left">NOM-070-005C</td>
        </tr>
        <tr>
            <td class="td-margins"
                style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px; padding-top: 8px;padding-bottom: 8px;">
                Domicilio:</td>
            <td class="td-margins" style="text-align: left; padding-top: 8px;padding-bottom: 8px;" colspan="3">
                GUILLERMO GONZÁLEZ CAMARENA NO. 800 PISO 2,
                SANTA FE, ÁLVARO OBREGÓN,
                CIUDAD DE
                MÉXICO.</td>
        </tr>
        <tr>
            <td class="td-margins"
                style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px; padding-top: 10px;padding-bottom: 10px;">
                Código Postal:</td>
            <td class="td-margins" style="text-align: left">01210</td>
            <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
                Estado:</td>
            <td class="td-margins" style="text-align: left; padding-right: 4px;">CIUDAD DE MÉXICO</td>
        </tr>
        <tr>
            <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
                Registro Federal de
                Contribuyentes:</td>
            <td class="td-margins" style="text-align: left">NCO111222NV5</td>
            <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
                País:</td>
            <td class="td-margins" style="text-align: left">MÉXICO</td>
        </tr>
        <tr>
            <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
                Registro de Productor <br>
                Autorizado (Uso de la <br>
                DOM):</td>
            <td class="td-margins" style="text-align: left">&nbsp;</td>
            <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
                Número de Convenio de
                corresponsabilidad:</td>
            <td class="td-margins" style="text-align: left">1128</td>
        </tr>
    </table>
    <div class="titulos">
        DESCRIPCIÓN DEL EMBARQUE QUE AMPARA EL CERTIFICADO
    </div>
    <table>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 4px;">
                Marca:</td>
            <td style="text-align: left; padding-right: 0;padding-left: 8px;">400 CONEJOS</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 4px;">
                Categoría y Clase:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">MEZCAL ARTESANAL, BLANCO <br> O JOVEN</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 0;">Edad
                (solo aplica en Añejo):</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">1 año</td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 4px;">
                Certificado <br> NOM a <br>Granel:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">CIDAM C-GRA-103/2023</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 4px;">
                Volumen:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">750 mL</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 0;">%Alc.
                Vol.:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">38%</td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 4px;">No.
                de análisis:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">NNMZ-37724</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 4px;">No.
                lote granel:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">02423AM-EE</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 0;">
                Botellas:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">396</td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 4px;">No.
                de análisis ajuste:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">NA</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 4px;">No.
                de lote envasado:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">002-23AM</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 0;">Cajas:
            </td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">33</td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 4px;">Tipo
                de Maguey:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">Maguey Espadín(A. angustifolia)</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 4px;">
                Envasado en:</td>
            <td style="text-align: justify;padding-right: 0;padding-left: 8px;">LIBRAMIENTO 5 SEÑORES NO. 915, CARRETERA
                INTERNACIONAL, TLALIXTAC DE CABRERA,
                C.P. <br> 68270, TLALIXTAC DE CABRERA, OAXACA.</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 0;">Folio
                Hologramas:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">005C-G1617661 - 005C-G1629667</td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 4px;">
                Aduana de despacho:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">AEROPUERTO INTERNACIONAL DE LA CIUDAD DE
                MÉXICO</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 4px;">
                Fracción Arancelaria:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">2208.90.05.00</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 8px;padding-left: 0;">No.
                de <br> pedido:</td>
            <td style="text-align: left;padding-right: 0;padding-left: 8px;">/4012111</td>
        </tr>
    </table>
    <div class="titulos" style="padding-bottom: none;">
        DESTINATARIO
    </div>
    <table>
        <tr>
            <td class="td-margins-none"
                style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre:</td>
            <td class="td-margins-none" style="text-align: left">DUFRY MÉXICO, S.A. DE C.V.</td>
        </tr>
        <tr>
            <td class=" td-margins-none"
                style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
                Domicilio:</td>
            <td class="td-margins-none" style="text-align: left">VENUSTIANO CARRANZA AV. CAPITÁN CARLOS LEÓN SN 2N E,
                OF 11 C.P. 15520 PEÑÓN DE LOS BAÑOS, CIUDAD DE
                MÉXICO.</td>
        </tr>
        <tr>
            <td class="td-margins-none"
                style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
                País destino:</td>
            <td class="td-margins-none" style="text-align: left">MÉXICO</td>
        </tr>
    </table>
    <div>
        <p style="font-size: 7.5px">El presente certificado se emite para fines de exportación conforme a la norma
            oficial mexicana de mezcal
            NOM-070-SCFI-2016. Bebidas Alcohólicas-Mezcal- Especificaciones, en cumplimiento
            con lo dispuesto en la Ley Federal de Infraestructura de la Calidad. Este documento no debe ser reproducido
            en forma parcial.</p>
    </div>
    <div class="titutlos-footer">
        AUTORIZÓ
    </div>
    <div class="titutlos-footer">
        XXXXX <br> XXXX del Organismo Certificador CIDAM
    </div>
    <div style="text-align: right; font-size: 7px;">Certificado de Exportación NOM-070-SCFI-2016 F7.1-01-23 Ed 12 <br>
        Entrada en vigor: XX-XX-2024</div>
    <div>
        <center> <img src="{{ public_path('img_pdf/pie_certificado.png') }}" style="height: 50px; width: 750px;"
                alt="pie de certificado"></center>
    </div>

</body>

</html>
