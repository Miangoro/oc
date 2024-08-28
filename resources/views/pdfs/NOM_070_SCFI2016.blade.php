<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de Información del Cliente</title>
    <style>
        body {
            font-weight: 12px;
        }

        @page {
            margin-left: 70px;
            margin-right: 70px;
            margin-top: 40px;
            margin-bottom: 40px;

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
            border: 1.5px solid black;
            padding: 4px;
            font-size: 11.5px;
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
            vertical-align: top;
            padding-bottom: 8px;
            padding-top: 0;
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
            margin-top: -30px;
            margin-left: -30px;


        }
    </style>


    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        <div> Bitácora de revisión de certificados de Instalaciones NOM-070-SCFI-2016<br> F7.1-01-40 <br>Ed 6 Entrada en
            vigor 27/05/2024<br>__________________________________________________________</div>
    </div>
</head>

<body>
    <table>
        <tr>
            <td class="letra-fondo" style="text-align: left" colspan="2">Razón social del cliente:</td>
            <td colspan="2">ALBERTO FRANCO MORGADO</td>
        </tr>
        <tr>
            <td class="letra-fondo" style="text-align: left">No. Cliente:</td>
            <td>NOM-070-270C</td>
            <td class="letra-fondo" style="text-align: left">Fecha de revisión:</td>
            <td>2024-07-25 11:35:43</td>
        </tr>
        <tr>
            <td class="letra-fondo" style="text-align: left">No. De certificado:</td>
            <td>CIDAM C-INS-088/2024</td>
            <td class="td-no-border"></td>
            <td class="td-no-border"></td>
        </tr>
    </table>

    <table>

        
    </table>

</body>

</html>
