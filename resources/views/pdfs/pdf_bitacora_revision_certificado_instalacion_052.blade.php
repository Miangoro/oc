<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bitácora de revisión de certificados de Instalaciones NOM-070-SCFI-2016 F7.1-01-40 </title>
    <style>
        body {
            font-weight: 12px;
        }

        @page {
            margin-left: 70px;
            margin-right: 70px;
            margin-top: 40px;
            margin-bottom: 10px;

        }

        @font-face {
            font-family: 'Century Gothic';
            src: url('fonts/CenturyGothic.ttf') format('truetype');

        }

        @font-face {
            font-family: 'Century Gothic Negrita';
            src: url('fonts/GOTHICB.TTF') format('truetype');
        }

        .negrita {

            font-family: 'Century Gothic Negrita';
        }


        .header {
            font-family: 'Century Gothic';
            text-align: right;
            font-size: 12px;
            margin-right: -30px;

        }

        .title {
            text-align: center;
            font-size: 17px;
        }

        .footer {
            position: absolute;
            transform: translate(0px, 180px);
            /* Mueve el elemento 50px en X y 50px en Y */
            text-align: center;
            font-size: 11px;
        }

        /*Tablas*/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 3px;
            font-size: 10.5px;
            text-align: center;
            font-family: 'Century Gothic';



        }

        th {
            background-color: black;
            color: white;
            text-align: center;

        }

        .td-border {
            border-bottom: none;
            border-top: none;
            border-right: 1px solid black;
            border-left: 1px solid black;

        }

        .td-no-border {
            border: none;
        }

        .td-barra {
            border-bottom: none;
            border-top: none;
            border-right: none;
            border-left: 1px solid black;
        }

        .letra_td {
            text-align: right;
        }

        .th-color {
            background-color: #d8d8d8;
        }

        .leftLetter {
            text-align: left;

        }

        .rightLetter {
            text-align: right;
            vertical-align: top;
            padding-bottom: 8px;
            padding-top: 0;
        }

        .no-margin-top {
            margin-top: 0;
        }

        .no-padding {
            padding: 0;
        }

        .letra-fondo {
            /* font-weight: 300; */
            font-family: 'Century Gothic negrita';
            color: black;
            font-size: 12px;
            background-color: #8eaadb;
            text-align: center;

        }

        .letra-up {
            vertical-align: top;
            padding-bottom: 10px;
            padding-top: 0;

        }

        .header {
            padding: 10px;
            text-align: right;
        }

        .header img {
            float: left;
            max-width: 165px;
            padding: 0;
            margin-top: -40px;
            margin-left: -30px;


        }

        /* Estilo para el texto de fondo */
        .background-text {
            font-family: 'Century Gothic';
            position: absolute;
            top: 450px;
            left: 412px;
            z-index: -1;
            color: #000000;
            font-size: 12px;
            /* line-height: 1.4; */
            white-space: nowrap;
            text-align: left;
        }

        .negrita {
            font-family: 'Century Gothic negrita';
        }

        .espacio_letras td {
            padding-top: 1px;
            padding-bottom: 1px;
            text-align: left;
        }

        .underline {
            text-decoration: underline;
        }
    </style>


    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        <div> Bitácora de revisión de certificado de Instalaciones<br> NMX-V-052-NORMEX-2016 F7.1-04-11 Ed 1<br>Entrada
            en vigor 28/11/2022<br>
            <span style="display:inline-block; width:650px; border-bottom:1.5px solid black;"></span>
        </div>
    </div>
</head>

<body>
    <div class="background-text">
        <span class="negrita">Nota:</span> Para el llenado de la bitácora colocar <br> <span class="negrita">C</span>=
        Cumple, <span class="negrita">NC</span>= No Cumple, <span class="negrita">NA</span>= No Aplica o <br> bien una X
        en
        el recuadro correspondiente en <br>cada uno de los requisitos y datos que estipula <br> la bitácora.
    </div>
    <table>
        <tr>
            <td class="letra-fondo" style="text-align: left" colspan="4">Razón social del cliente:</td>
            <td class="leftLetter" colspan="2"></td>
        </tr>
        <tr>
            <td class="letra-fondo" style="text-align: left" colspan="2">No. Cliente:</td>
            <td colspan="2"></td>
            <td class="letra-fondo" style="text-align: left">Fecha de revisión:</td>
            <td></td>
        </tr>
        <tr>
            <td class="letra-fondo" style="text-align: left" colspan="2">No. de Certificado:</td>
            <td colspan="2"></td>
            <td class="letra-fondo">No. de certificado:</td>
            <td style="width: 100px;"></td>
        </tr>

    </table>
    <br>

    <table style="width: 395px;" class="espacio_letras">
        <tr>
            <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 250px;">Requisitos documentales
                <br>
                para certificación
            </td>
            <td class="letra-fondo" style="width: 45px">C </td>
            <td class="letra-fondo">N/C </td>
            <td class="letra-fondo">N/A</td>
        </tr>
        <tr>
            <td>
                Solicitud de información al cliente y viabilidad del servicio.
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Solicitud del servicio para emisión del certificado</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Cotización de servicio.
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Contrato de prestación de servicios.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Carta de asignación número de cliente.
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Check-list de Requisitos a evaluar NMX-V-052-NORMEX-2016.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

        <tr>
            <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 200px; height: 30px">Datos del
                certificado</td>
            <td class="letra-fondo">C </td>
            <td class="letra-fondo">N/C </td>
            <td class="letra-fondo">N/A</td>
        </tr>
        <tr>
            <td>Nombre de la empresa o persona física y RFC.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Domicilio fiscal y de las
                instalaciones.
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Fecha de vigencia y vencimiento.
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Alcance de la certificación.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Número de dictamen emitido por la
                UVEM.
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>No. de Convenio de
                corresponsabilidad para el uso de la
                Denominación de Origen Mezcal.
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Nombre y puesto del responsable de
                la emisión del Certificado.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>No. De Autorización para el uso de la
                Denominación de Origen Mezcal.</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Nombre y dirección del organismo
                certificador CIDAM.
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

    </table>
    <br>
    <table>
        <tr>
            <td style="text-align: left; height: 100px; padding: 10px; font-size: 12px; font-family: 'Century Gothic';">
                Derivado de la revisión minuciosa y con la documentación completa entregada de manera
                digital por personal del OC CIDAM se revisa que el certificado cumple con cada uno de los
                requisitos mencionados en este documento, por consiguiente, se toma la decisión para (otorgar o denegar)
                la certificación de producto. <br> <span class="negrita">Responsable de Revisión (Nombre, Puesto, firma):</span>
                <div style="padding: 30px"></div>

            </td>
        </tr>
    </table>
    <div style="position: fixed; bottom: 25px; left: 0; width: 100%; padding: 5px 0; z-index: 1000;">
    <p style="font-size: 11px; text-align: center; font-family: 'Century Gothic'; margin: 0;">
          Este documento
            es propiedad del Centro de
            Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser <br>
            distribuido externamente sin la autorización escrita del Director Ejecutivo.</p>
    </div>

</body>

</html>
