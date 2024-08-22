<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitud de Hologramas</title>
    <style>

        body{
            font-weight: 12px;
        }
        @page {
            margin-left: 43px;
            margin-right: 43px;
            margin-top: 30px;
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

        .negrita{
          
            font-family:  'Century Gothic Negrita';
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
            padding-bottom: 10px;
            padding-top: 0;
        }

        .rightLetter {
            text-align: right;
            vertical-align: top;
            padding-bottom: 10px;
            padding-top: 0;
        }

        .no-margin-top {
            margin-top: 0;
        }

        .no-padding{
            padding: 0;
        }

        .letra-fondo{
            color: white;
            
            font-size: 19px;
            background-color: #006fc0;
            padding-bottom: 21px;
            text-align: center;
        }

        .letra-up{
            vertical-align: top;
            padding-bottom: 10px;
            padding-top: 0;

        }

    </style>
</head>
<body>
    <table border="1">
        <tr>
          <td rowspan="3" >
            <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM"
            style="max-width: 125px; padding: 0;">
        </td>
          <td rowspan="3" class="title"> Solicitud de hologramas</td>
          <td colspan="2" class="leftLetter" style="width: 180px"> <b>Identificación:</b> P7.1-01-05</td>
        </tr>
        <tr>
          <td colspan="2" class="leftLetter"> <b>Edición:</b> 3</td>
        </tr>
        <tr>
          <td colspan="2" class="leftLetter" style="padding-bottom: 15px"> <b>Inicio de Vigencia:</b> <br>
            15/08/2024</td>
        </tr>

      </table>

    <br>

    <table>
        <tr>
            <td colspan="2" class="td-no-border" style="width: 380px">&nbsp;</td>
            <td class="no-padding"> <b>Folio de solicitud:</b> </td>
            <td class="no-padding"> INV-423/2024</td>
        </tr>
    </table>

    <br>
    <table>
        <tr>
            <td colspan="2" class="letra-fondo negrita">Solicita</td>
        </tr>
        <tr>
            <td class="rightLetter negrita" style="width: 250px">Nombre:</td>
            <td class="letra-up"> MAYTE ERÉNDIRA ENRÍQUEZ ROJAS</td>
        </tr>
        <tr>
            <td class="rightLetter"><b>Puesto:</b> </td>
            <td class="letra-up">representante legal</td>
        </tr>
        <tr>
            <td class="rightLetter"><b>Email:</b> </td>
            <td class="letra-up">mezcaldesanluis@gmail.com</td>
        </tr>
        <tr>
            <td style="border-bottom: 0;" colspan="2" class="letra-fondo"> Dirección de envío</td>
        </tr>
    </table>

    <table>
<tr>
    <td colspan="4"> <br> Calle Olmo, No. 6 Col. Lomas de Sierra Juárez 2a Sección, C.P. 68288, San Andrés Huayapam, Oaxaca <br><br>
    </td>
</tr>
<tr>
    <td colspan="4" class="letra-fondo"> INFORMACIÓN DE QUIEN RECIBE EL PAQUETE DE HOLOGRAMAS
    </td>
</tr>
<tr>
    <td class="rightLetter" style="width: 110px"><b>Nombre Completo: </b> </td>
    <td colspan="3" class="letra-up">Nazareth Camacho</td>
</tr>
<tr>
    <td class="rightLetter"><b>Email./Cel./Tel.:</b> </td>
    <td colspan="3" class="letra-up"> mezcaldesanluis@gmail.com | 9512432784</td>
</tr>

<tr>
    <td class="rightLetter"><b>Fecha de envío:</b></td>
    <td class="letra-up">2024 de Agosto del 12</td>
    <td class="rightLetter"> <b>Fecha de recibido:</b></td>
    <td></td>
</tr>
<tr>
    <td class="rightLetter"><b>Folio inicial:</b></td>
    <td class="letra-up">NOM-070-054CB000000</td>
    <td class="rightLetter"><b>Folio final:</b></td>
    <td class="letra-up">NOM-070-054CB000000</td>
</tr>
<tr>
    <td class="rightLetter" ><b>Total de hologramas <br>
        enviados:</b></td>
    <td colspan="3" class="letra-up">5,000 Hologramas</td>
</tr>
<tr >
    <td class="rightLetter" style="height: 70px"><b>Comentarios</b></td>
    <td colspan="3"></td>
</tr>
<tr>
    <td colspan="4">NOTA: Se solicita reenviar vía electrónica este acuse firmado para confirmar la llegada de hologramas. <div style="height: 50px"></div>
        _____________________________________________ <br>
        <b>Nazareth Camacho </b>
        <div style="height: 10px"></div>
    </td>
</tr>
    </table>
    <div style="margin-bottom: 15px">
        <p style="font-size: 12px; margin-top: 120px; text-align: center">Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la
            autorización escrita del Director Ejecutivo.</p>
    </div>

</body>
</html>