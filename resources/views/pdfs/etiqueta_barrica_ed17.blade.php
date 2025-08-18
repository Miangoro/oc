<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Etiqueta para ingreso a maduración</title>
    <style>
        @page {
            size: 292mm 227mm;
            margin: 20px 40px 15px 40px;  /*márgenes (arriba, derecha, abajo, izquierda) */
        }
        body {
            font-family: sans-serif;
            /*font-family: 'Arial Negrita', Gadget, sans-serif; /*negrita*/
            font-size: 10px;
        }

        /*tabla*/
        td {
            border: 2px solid #000000;
            text-align: center;
            padding: 5px;
        }
        .azul {
            background-color: #3f84c7;
            color: white;
            font-weight: bold;
        }


        .footer {
            /* border: 2px solid blue; */
            position: fixed;
            width: 100%;
            bottom: 0;
            height: 50px;
            font-family: 'Lucida Sans Unicode';
            font-size: 14px;
            line-height: 0.8;
        }
        .left {
            position: absolute;
            left: 0;
            text-align: center;
        }
        .right {
            position: absolute;
            right: 0px;
            top: -25px;
            text-align: right;
        }
    </style>
</head>

<body>

<div class="footer">
    <p class="left">
        Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser<br>distribuido externamente sin la autorización escrita del Director Ejecutivo.
    </p>
    <p class="right">
        F-UV-04-04<br>Edición 17, 07/08/2025
    </p>
</div>


<!----------------------- ETIQUETA 1 ----------------------->
<table class="tabla" style="border-collapse: collapse; " width=100%>
    <tr>
        <td colspan="6" class="azul" style="background-color: #0d5295;">
            CENTRO DE INNOVACION Y DESARROLLO AGROALIMENTARIO DE MICHOACÁN - UNIDAD DE INSPECCIÓN UVNOM-129
        </td>
    </tr>

    <tr>
        <td rowspan="3" style="width:12%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 95px; height: 50px; padding-left: 10px" alt="Unidad de Inspección">
        </td>
        <td colspan="4" class="azul" style="background-color: #0d5295; font-size: 13px;">
            ETIQUETAS PARA INGRESO A MADURACIÓN
        </td>
        <td rowspan="3" style="width:12%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 95px; height: 50px; padding-left: 10" alt="Unidad de Inspección">
        </td>
    </tr>

    <tr>
        <td class="azul" style="width:15%;">FECHA DEL SERVICIO:</td>
        <td>{{ Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->translatedFormat('d \d\e F \d\e Y') }}</td>
        <td class="azul" style="width:15%;">NO. DE SERVICIO:</td>
        <td>{{ $datos->num_servicio ?? 'Sin asignar' }} </td>
    </tr>
    <tr>
        <td class="azul">RAZÓN SOCIAL:</td>
        <td colspan="3">{{ $datos->solicitud->empresa->razon_social }}</td>
    </tr>

    <tr>
        <td colspan="6" style="background-color: #5b9bd5; border-bottom: none; padding-top: 2px; padding-bottom: 2px; font-size: 12px"><b>I.Información del lote a ingresar</b></td>
    </tr>
</table>
<table class="tabla" style="border-collapse: collapse;" width=100%>
    <tr>
        <td class="azul" style="width:12%;">No. DE LOTE A GRANEL:</td>
        <td>{{ $datos->solicitud->lote_granel->nombre_lote ?? '' }}</td>
        <td class="azul" style="width:12%;">TIPO DE MAGUEY O AGAVE:</td>
        <td>{{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</td>
        <td rowspan="3" style="width: 2px; border: none; border-top: 2px solid #000;"> </td><!--ESPACIO-->

        <td colspan="2" class="azul" style="width:12%;">NO. DE ANÁLISIS FISIFCOQUÍMICOS:</td>
        <td colspan="2">{{ $datos->solicitud->lote_granel->estados->nombre ?? '' }}</td>
    </tr>
    <tr>
        <td class="azul">CATEGORÍA:</td>
        <td>{{ $datos->solicitud->lote_granel->categoria->categoria ?? ''}},
            {{ $datos->solicitud->lote_granel->clase->clase ?? '' }}
        </td>
        <td rowspan="2" class="azul">VOLUMEN TOTAL DEL LOTE:</td>
        <td rowspan="2"> R </td>
        <td colspan="2" class="azul" style="width:12%;">NO. DE CERTIFICADO NOM A GRANEL:</td>
        <td colspan="2">R</td>
    </tr>
    <tr>
        <td class="azul">CLASE:</td>
        <td>{{ $datos->solicitud->lote_granel->edad ?? 'N/A' }}</td>
        <td colspan="2" class="azul">% ALC. VOL. :</td>
        <td colspan="2"> R </td>
    </tr>

    <tr>
        <td colspan="9" style="padding: 3px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>
    <tr>
        <td colspan="9" style="background-color: #5b9bd5; padding-top: 2px; padding-bottom: 2px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: 2px solid #000; border-bottom: none; font-size: 12px"><b>II.Información del ingreso</b></td>
    </tr>

    <tr>
        <td rowspan="2" class="azul" style="width:12%;">MADURACIÓN:</td>
        <td>BARRICAS:_____ </td>
        <td style="width:12%;">TIPO DE MADERA: </td>
        <td>{{ $datos->solicitud->lote_granel->folio_fq ?? ''}}</td>
        <td rowspan="2" style="width: 2px; border: none; border-top: 2px solid #000;"> </td><!--ESPACIO-->
        <td class="azul">No DE RECIPIENTES:</td>
        <td>r</td>
        <td class="azul">CAPACIDAD DE LOS RECIPIENTES:</td>
        <td>r</td>
    </tr>
    <tr>
        <td>VIDRIO:_____</td>
        <td>TIPO DE RECIPIENTE:</td>
        <td>R</td>
        <td colspan="2" class="azul">VOLUMEN INGRESADO:</td>
        <td colspan="2">r</td>
    </tr>

    <tr>
        <td colspan="9" style="padding: 3px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>

    <tr>
        <td colspan="4">{{ $datos->solicitud->instalaciones->responsable ?? ''}}</td>
        <td rowspan="2" style="width: 2px; border-left: none; border-right: none; border-top: none; border-bottom: 2px solid #000;"> </td><!--ESPACIO-->
        <td colspan="4">{{ $datos->inspector->name ?? ''}}</td>
    </tr>
    <tr>
        <td colspan="4" class="azul">NOMBRE Y FIRMA DEL RESPONSABLE DE INSTALACIONES</td>
        <td colspan="4" class="azul">NOMBRE Y FIRMA DEL TÉCNICO INSPECTOR</td>
    </tr>
</table>



</body>
</html>