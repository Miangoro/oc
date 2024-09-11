<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page {
            margin-top: 40px;
            margin-right: 50px;
            margin-left: 50px;
            margin-bottom: 1px;
        }

        @font-face {
            font-family: 'Century Gothic';
            src: url('fonts/CenturyGothic.ttf') format('truetype');

        }

        @font-face {
            font-family: 'Century Gothic Negrita';
            src: url('fonts/GOTHICB.TTF') format('truetype');
        }

        body {
            font-family: 'Century Gothic', sans-serif;
            font-size: 10px;

        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1.5px solid black;
            padding: 1px;
            text-align: center;
        }

        th {
            background-color: #608390;
            color: white;
            padding-top: 0;
            padding-bottom: 0;
            text-align: center;
            font-size: 11px;
        }

        .td-margins {
            border-bottom: none;
            border-top: none;
            border-right: 0.5px solid black;
            border-left: 0.5px solid black;

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

        .letra_right {
            text-align: right;
        }

        .th-color {
            background-color: #d8d8d8;
        }

        .con-negra {
            font-family: 'Century Gothic Negrita';
        }

        .no-borde-top {
            border-top: none;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td rowspan="2" colspan="3" style="padding: 0; height: auto;">
                <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" style="width: 170px; margin: 0;"
                    alt="Logo CIDAM">
            </td>
            <td class="con-negra"
                style="font-size: 14px; padding-left: 16px; padding-right: 16px;padding-top: 7px; padding-bottom: 7px">
                CENTRO DE INNOVACION Y DESARROLLO <br>
                AGROALIMENTARIO DE MICHOACAN A.C.</td>
            <td style="text-align: right; font-size: 8.5px; padding-left: 0; padding-top: 0; width: 160px">ORGANISMO DE
                CERTIFICACION No. de
                acreditación 144/18 ante la ema A.C.
            </td>
        </tr>
        <tr>
            <td class="con-negra" style="font-size: 14px" colspan="2">SOLICITUD DE SERVICIOS NMX-V-052-NORMEX-2016
            </td>
        </tr>

    </table>
    <table>
        <tr>
            <th class="no-borde-top" style="width:60px;">I:</th>
            <th class="no-borde-top" colspan="12" style="padding-top: 2px;padding-bottom: 2px;">INFORMACIÓN DEL
                SOLICITANTE</th>
        </tr>

    </table>

    <table>
        <tr>
            <td class="con-negra no-borde-top " style="width: 90px" rowspan="3" colspan="2">Nombre del cliente/
                o<br> Razon social:</td>
            <td class="no-borde-top" style="width: 100px" rowspan="3" colspan="4">&nbsp;</td>
            <td class="con-negra no-borde-top" style="width: 50px" colspan="3">N° de cliente:</td>
            <td class="no-borde-top" style="width: 120px" colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="3">e-mail:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="3">Teléfono:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2">Fecha de solicitud:</td>
            <td colspan="7">&nbsp;</td>
            <td class="con-negra" colspan="1">No. de Inventario:</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2">Responsable de las <br>
                instalaciones:</td>
            <td colspan="7">&nbsp;</td>
            <td class="con-negra" colspan="1">SKU:</td>
            <td colspan="3"></td>
        </tr>


    </table>
    <table>
        <tr>
            <td class="con-negra no-borde-top " style="width: 81px" colspan="2">Domicilio Fiscal:</td>
            <td class="con-negra no-borde-top " style="width: 84px" colspan="4">&nbsp;</td>
            <td class="con-negra no-borde-top " style="width: 70px"  colspan="3">Domicilio de Instalaciones</td>
            <td class="con-negra no-borde-top " style="width: 120px" colspan="4"></td>
        </tr>
    </table>
    <table>
        <tr>
            <th class="no-borde-top" style="width:60px;">II:</th>
            <th class="no-borde-top" colspan="12" style="padding-top: 2px;padding-bottom: 2px;">SERVICIO SOLICITADO A LA UVEM</th>
        </tr>
    </table>
    <table>
        <tr>
            <td class="td-margins con-negra" colspan="13" style="color: red; padding: 0;">Seleccione el servicio solicitado colocando una X en la casilla correspondiente</td>
        </tr>
        <tr>
            <td class="td-margins letra_right" colspan="3" style="font-weight: bold; padding-top: 0;padding-bottom: 0;">
                Vigilancia en proceso de producción (familia):</td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;"></td>
            <td class="td-no-margins"><u>---------</u></td>
            <td colspan="2" class="td-no-margins letra_right"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0; text-align: left">Fecha y hora de visita <br> propuesta:</td>
            <td colspan="6" style="width: 230px"></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>
        <tr>
            <td class="td-margins letra_right" colspan="3" style="font-weight: bold; padding-top: 0;padding-bottom: 0;">
                Toma de muestra:</td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;"></td>
            <td class="td-no-margins"><u>---------</u></td>
            <td colspan="2" class="td-no-margins letra_right"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0; text-align: left">Fecha y hora de visita <br> propuesta:</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>
        <tr>
            <td class="td-margins letra_right" colspan="3" style="font-weight: bold; padding-top: 0;padding-bottom: 0;">
                Liberación de producto terminado:</td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;"></td>
            <td class="td-no-margins"><u>---------</u></td>
            <td colspan="2" class="td-no-margins letra_right"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0; text-align: left">Fecha y hora de visita <br> propuesta:</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>
        <tr>
            <td class="td-margins letra_right" colspan="3" style="font-weight: bold; padding-top: 0;padding-bottom: 0;">
                Emisión de certificado de cumplimiento de la bebida:</td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;"></td>
            <td class="td-no-margins"><u>---------</u></td>
            <td colspan="2" class="td-no-margins letra_right"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0; text-align: left">Fecha y hora de visita <br> propuesta:</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>        
    </table>
    <table>
        <tr>
            <td class="td-margins letra_right" colspan="3" style="font-weight:  bold; padding-top: 0;padding-bottom: 0; /* width: 210px */">Dictaminación de instalaciones:
            </td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;"></td>
            <td class="td-no-margins"><u>---------</u></td>
            <td class="td-no-margins " style="width: 10px; padding-top: 0;padding-bottom: 0;"></td>
            <td style="width: 50px" style="font-weight: bold; padding-top: 0;padding-bottom: 0; font-size: 8px">Productor de bebidas <br> alcohólicas que <br>
                contienen Mezcal
                </td>
            <td style="width: 25px; padding-top: 0;padding-bottom: 0;"></td>
            <td style="width: 90px; padding-top: 0;padding-bottom: 0;font-weight: bold; font-size:8px">Envasador de bebidas <br> alcohólicas que <br>
                contienen Mezcal</td>
            <td style="width: 25px; padding-top: 0;padding-bottom: 0;"></td>
            <td style="width: 90px; padding-top: 0;padding-bottom: 0; font-weight: bold; font-size: 8px" colspan="2">Comercializador de bebidas <br> alcohólicas que <br>
                contienen Mezcal</td>
            <td style="width: 25px; padding-top: 0;padding-bottom: 0;" colspan="1"></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
{{--         <tr>
            <td class="td-barra" colspan="4"></td>
            <td colspan="2" class="td-no-margins" style="text-align: right" style="font-weight: bold">Fecha y
                hora de visita propuesta:</td>
            <td colspan="7"></td>
        </tr>

        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr> --}}
    </table>

</body>

</html>
