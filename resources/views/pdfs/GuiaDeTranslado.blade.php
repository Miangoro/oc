<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>539G005_Guia_de_traslado_de_maguey_o_agave</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 15px;
            color: #000000;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .colorRed {
            color: red;
            font-size: bold;
        }

        .tituloLetter {
            font-size: 16px;
        }

        .leftLetter{
            text-align: left;
        }
        .rightLetter {
            text-align: right;
        }

        .bigLetter {
            font-size: 31px;
        }

        .text_marge {
            margin: 25px;
        }

        .header img {
            width: 250px;
            float: left;

        }

        .header h1 {
            font-size: 18px;
            margin: 0;
        }

        .header h2 {
            font-size: 14px;
            margin: 0;
            font-weight: normal;
        }

        .header h6 {
            font-size: 10px;
            margin: 0;
        }

        .section {
            margin-top: 20px;
            margin-bottom: 3rem;
        }

        .section p {
            margin: 0px 5px;
        }

        .text_al {
            text-align: right;
            margin: 0;
            padding: 0;
            font-size: 12px;


        }

        .text_c {
            color: rgb(4, 57, 78);
            margin: 2px 0;
            /* Ajusta el margen según sea necesario */

        }

        .content {
            margin-left: 20rem;
            /* Adjust this value as needed to ensure enough space on the right */
        }



        /*Tablas*/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }

        th {
            background-color: #608390;
            color: white;
            text-align: center;
            font-size: 11px;
            font-family: Arial, sans-serif;

        }

        .td-margins {
            border-bottom: none;
            border-top: none;
            border-right: 1px solid black;
            border-left: 1px solid black;
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

        .letra_td {
            text-align: right;
        }

        .th-color {
            background-color: #d8d8d8;
        }

        .con-negra {
            font-weight: bold;
        }
        .marca-agua {
            position: absolute;
            top: -120px; /* Ajusta aquí la posición hacia arriba */
            left:-45px;
            margin-top: 70px; /* Desplaza la imagen hacia abajo */
            width: 800px;
            height: 1200px;
            z-index: -1;
            pointer-events: none; /* La marca de agua no es clickeable */
            background-image: url('{{ public_path('img_pdf/membratado_guias.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
</head>

<body>
    <div class="marca-agua"></div>
    <div class="header" style="margin-top: 8%">
        <p class="text_al left">F-UV-21-04 Versión 4</p>

    </div>

    <div class="section">
        <center>
            <b class="tituloLetter" >Folio de Guía No. : <b class="colorRed"> {{ $datos[0]->folio }}</b> No. de predio: {{ $datos[0]->num_predio }} <br>
                Nombre del predio: {{ $datos[0]->nombre_predio }} <br>
                Nombre de la empresa/productor: {{ $datos[0]->razon_social }} <br>
                No. del cliente: NOM-070-005C
            <div  style="margin-top: 3%">
                <b class="bigLetter">Guía de traslado de maguey o agave</b>
            </div>
        </center>
    </div>
    <table>
        <tr>
            <td style=" text-align: left" colspan="2"> Fecha de corte:</td>
            <td class="leftLetter" colspan="2">N° de cliente:</td>
        </tr>
        <tr>
            <td class="leftLetter" colspan="2"> Tipo de maguey (Tipo de agave):</td>
            <td class="leftLetter" colspan="2">N° de cliente:</td>
        </tr>
        <tr>
            <td class="leftLetter" colspan="2"> Edad:</td>
            <td class="leftLetter" colspan="2">Maguey Espadín (A. angustifolia)</td>
        </tr>
        <tr>
            <td class="leftLetter" colspan="2"> No. de lote o No. de tapada:</td>
            <td class="leftLetter" colspan="2">N° de cliente:</td>
        </tr>
        <tr>
            <td class="leftLetter" colspan="2"> No. de piñas comercializadas:</td>
            <td class="leftLetter" colspan="2">N° de cliente:</td>
        </tr>
        <tr>
            <td class="leftLetter" colspan="2"> No. de piñas anterior:</td>
            <td class="leftLetter" colspan="2">N° de cliente:</td>
        </tr>
        <tr>
            <td class="leftLetter" colspan="2"> No. de piñas actual:</td>
            <td class="leftLetter" colspan="2">N° de cliente:</td>
        </tr>
        <tr>
             <td class="leftLetter"> Kg de maguey: </td>
             <td class="leftLetter">&nbsp;</td>
             <td class="leftLetter"> %ART</td>
             <td class="leftLetter">&nbsp;</td>
        </tr>
    </table>

    <b class="tituloLetter"><br>I. &nbsp; &nbsp;  &nbsp; Datos del comprador</b>


    <table style="margin-bottom: 30px">
        <br>
        <tr>
            <td class="leftLetter">Nombre del cliente:</td>
            <td class="leftLetter">Yucli Emmanuel Baza Ortuño</td>
            <td class="leftLetter">No. de cliente:</td>
            <td class="leftLetter">124342432</td>
        </tr>
        <tr>
            <td class="leftLetter">Fecha de ingreso a
                fábrica:</td>
            <td class="leftLetter"colspan="3">123123123</td>
        </tr>
        <tr>
            <td class="leftLetter">Domicilio de 
                entrega:
            </td>
            <td class="leftLetter" colspan="3">Jose Inicente lugo</td>
        </tr>
    </table>

    <table style="margin-bottom: 32px">
        <br>
        <tr style="font-size: 18px;">
            <td colspan="2" class="td-no-margins leftLetter"> &nbsp; &nbsp;  &nbsp; &nbsp;Firma del vendedor</td>
            <td colspan="2" class="td-no-margins rightLetter">Firma del comprador &nbsp; &nbsp;  &nbsp; &nbsp;</td>
        </tr>
    </table>
    <div style="margin-bottom: 1px; text-align: center">
        <img style="display: block; margin: 0 auto;" height="60px" src="{{ storage_path('app/public/firmas/firma_erik.png') }}">
        <p style="font-size: 18px">B.T.G. Erick antonio Mejía Vaca <br>
            Gerente Técnico Sustituto de la Unidad de Inspección</p>
    </div>

    </div>
    <table>
        <tr>
            <td colspan="2" class="td-no-margins leftLetter" style="font-size: 11px">C.c.p Expediente de la Unidad de Verificación del UMSNH<br> <div style="margin-left: 20%">___________________________</div></td>
            <td colspan="2" class="td-no-margins rightLetter" style="font-size: 11px">Entrada en vigor: 28-05-2022</td>
        </tr>
    </table>



</body>

</html>
