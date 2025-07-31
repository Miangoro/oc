<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisitos a evaluar</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        @page {
            margin: 100px 30px;
        }

        .header {
            position: fixed;
            top: -65px;
            left: 30px;
            width: calc(100% - 60px);
            height: 100px;
            overflow: hidden;
        }

        .logo {
            margin-left: 30px;
            width: 150px;
            display: block;
        }

        .description1,
        .description2,
        .description3 {
            position: fixed;
            right: 30px;
            text-align: right;
        }

        .description1 {
            margin-right: 30px;
            top: -50px;
            font-size: 14px;
        }

        .description2 {
            margin-right: 30px;
            top: -30px;
            font-size: 14px;
        }

        .description3 {
            margin-right: 30px;
            top: -10px;
            font-size: 14px;
            border-bottom: 1px solid black;
            padding-bottom: 5px;
            width: 63%;
            display: inline-block;
        }

        .footer {
            position: absolute;
            bottom: -50px;
            left: 60px;
            right: 60px;
            width: calc(100% - 60px);
            font-size: 11px;
            text-align: center;
        }

        .footer .page-number {
            position: absolute;
            right: -10px;
            font-size: 10px;
            top: -15px;
        }

        .page-break {
            page-break-before: always;
        }

        .content {
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 80px;
            margin-bottom: 70px;
        }

        .content2 {
            margin-left: 20px;
            margin-right: 20px;
            margin-bottom: 70px;
        }

        .title {
            margin-left: 20px;
            text-align: center;
            color: #000000ff;
            font-size: 12px;
            margin-top: -70px;
            font-weight: bold;
        }

        .title2 {
            margin-left: 38px;
            text-align: left;
            color: #000000ff;
            margin-top: 20px;
            font-weight: bold;
            font-size: 15px;
            line-height: 2;
        }

        .title3 {
            text-align: center;
            color: #1F497D;
            margin-top: 90px;
            font-weight: bold;
            font-size: 16px;
            line-height: 2;
        }

        .subtitle {
            margin-left: 5px;
            font-size: 14px;
            margin-bottom: -10px;
        }

        .subtitle2 {
            margin-left: 25px;
            font-size: 14px;
            font-weight: bold;
        }

        .subtitle3 {
            margin-top: -20px;
            margin-left: 25px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 60px;
        }

        .subtitlex {
            margin-top: 30px;
            margin-left: 25px;
            font-size: 14px;
            font-weight: bold;
        }

        .subtitle-nn {
            margin-top: 2px;
            margin-left: 25px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: -2px;
        }

        .subtitle4 {
            margin-top: -25px;
            margin-left: 25px;
            font-size: 14px;
            font-weight: bold;
        }



        table {
            width: 90%;
            border: 1px solid #000000ff;
            border-collapse: collapse;
            margin: auto;
            margin-top: -70px;
            font-size: 13px;
            line-height: 1;
            vertical-align: top;
            font-family: Arial, Helvetica, Verdana;
        }

        td,
        th {
            border: 1px solid #000000ff;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        td {
            width: 50%;
        }

        .colum-n {
            vertical-align: middle;
            text-align: center;
            
        }

        .colum-p {
            vertical-align: middle;
            text-align: center;
        }

        .colum-x {
            vertical-align: middle;
            text-align: center;
            text-align: justify;
        }

        .colum-s {
            vertical-align: middle;
            text-align: justify;
            font-weight: bold;
        }

        .bullet {
            margin-top: -10px;
            margin-left: 20px;
            margin-bottom: 20px;
            line-height: 1.5;
            font-size: 13px;
        }

        .table-container {
            display: inline-block;
            vertical-align: top;
            margin-left: 350px;
            margin-top: -70px;
        }

        .my-table {
            border: 1px solid #E36C09;
            border-collapse: collapse;
            width: 100%;
        }

        .my-table td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #E36C09;
            padding: 5px;
            text-align: center;
        }

        .table-x {
            width: 40%;
            margin-top: 60px;
            margin-left: 20px;
        }

        .nota {
            margin-left: 35px;
            font-size: 13px;
            text-align: justify;
            margin-right: 450px;
            color: #243F60;
            font-weight: bold;
            margin-top: -2px;
        }

        .nota2 {
            margin-left: 35px;
            font-size: 13px;
            text-align: justify;
            margin-right: 35px;
            color: #243F60;
            margin-top: 40px;
            font-weight: bold;
        }

        .nota3 {
            margin-left: 35px;
            font-size: 13px;
            text-align: justify;
            margin-right: 35px;
            color: #243F60;
            margin-top: 1px;
            font-weight: bold;
        }

        .img-botellas-right {
            float: right;
            margin-right: 100px;
            margin-top: -150px;
            width: 250px;
        }

        .final {
            margin-top: 70px;
        }

        .t-final {
            margin-top: 40px;
            margin-left: 40px;
            color: #E36C09;
            font-size: 14px;
        }

        .cuadro {
            text-align: justify;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM" class="logo">
    </div>

    <div class="description1">Requisitos a evaluar NOM-070-SCFI-2016 F7.1-01-09 </div>
    <div class="description2">Edición 7 Entrada en Vigor: 28/04/2025</div>
    <div class="description3"></div>

    <div class="content">
        <p class="title">NOM-070-SCFI-2016</p>
    </div>

    <table>
        <tbody>
            <tr>
                <td class="colum-n" style="background-color: #8aaef7ff;">Cliente:</td>
                <td colspan="3" class="colum-n"></td>
            </tr>
            <tr>
                <td class="colum-n" style="background-color: #8aaef7ff;">Numero del cliente:</td>
                <td class="colum-p"></td>
                <td class="colum-n" style="background-color: #8aaef7ff;">Fecha de revisión de
                    expediente:</td>
                <td class="colum-n"></td>
            </tr>
            <tr>
                <td class="colum-n" style="background-color: #8aaef7ff;">Nombre de quien realiza la revisión del
                    expediente:</td>
                <td class="colum-n"></td>
                <td class="colum-n" style="background-color: #8aaef7ff;">Firma de quien realiza la
                    revisión del expediente:</td>
                <td class="colum-n"></td>
            </tr>
        </tbody>
    </table>

    <p class="title2">
        <strong><u>I. REQUISITOS PRODUCTOR DE MAGUEY</u></strong>
    </p>
<br>
<br>
<br>
    <table>
        <tbody>
            <tr>
                <td class="colum-n" style="background-color: #8aaef7ff;">Cliente:</td>
                <td colspan="3" class="colum-n"></td>
            </tr>
        </tbody>
    </table>



        <div class="footer">
            <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y
                no puede ser distribuido
                externamente sin la autorización escrita del Director Ejecutivo
            </div>
            <div class="page-number">Página <strong>1</strong> de <strong>1</strong></div>
        </div>
</body>

</html>