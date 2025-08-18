<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Etiqueta para lotes de mezcal a granel</title>
    <style>
        @page {
            size: 292mm 227mm;
            margin: 20px 40px 15px 40px;  /*márgenes (arriba, derecha, abajo, izquierda) */
        }
        body {
            font-family: sans-serif;
            /*font-family: 'Arial Negrita', Gadget, sans-serif; /*negrita*/
            font-size: 11px;
        }


        /*tabla*/
        td {
            border: 2px solid #000000;
            text-align: center;
            padding: 5px;
        }
        .verde {
            background-color: #3f9365;
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
        <td colspan="6" class="verde">
            CENTRO DE INNOVACION Y DESARROLLO AGROALIMENTARIO DE MICHOACÁN - UNIDAD DE INSPECCIÓN UVNOM-129
        </td>
    </tr>

    <tr>
        <td rowspan="3" style="width: 17%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 50px; padding-left: 15px" alt="Unidad de Inspección">
        </td>
        <td colspan="4" class="verde" style="font-size: 14px;">
            ETIQUETAS PARA LOTES DE MEZCAL A GRANEL
        </td>
        <td rowspan="3" style="width: 17%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 50px; padding-left: 15px" alt="Unidad de Inspección">
        </td>
    </tr>

    <tr>
        <td class="verde" style="width: 14%;">FECHA DEL SERVICIO:</td>
        <td>{{ Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->translatedFormat('d \d\e F \d\e Y') }}</td>
        <td class="verde" style="width: 14%;">NO. DE SERVICIO:</td>
        <td>{{ $datos->num_servicio ?? 'Sin asignar' }} </td>
    </tr>
    <tr>
        <td class="verde">RAZÓN SOCIAL:</td>
        <td colspan="3">{{ $datos->solicitud->empresa->razon_social }}</td>
    </tr>

    <tr>
        <td colspan="6" style="padding: 3px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>
</table>
<table class="tabla" style="border-collapse: collapse;" width=100%>
    <tr>
        <td class="verde" style="width: 17%;">No. DE LOTE A GRANEL:</td>
        <td>{{ $datos->solicitud->lote_granel->nombre_lote ?? '' }}</td>
        <td rowspan="4" style="width: 6px; border: none;"> </td><!--ESPACIO-->
        <td rowspan="2" class="verde" style="width: 14%;">ESPECIE DE AGAVE:</td>
        <td rowspan="2">@foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </td>
        <td rowspan="4" style="width: 6px; border: none;"> </td><!--ESPACIO-->
        <td rowspan="2" class="verde">ID DE TANQUE (s):</td>
        <td rowspan="2" style="width:17%;">{{ $datos->solicitud->lote_granel->volumen ?? '' }}</td>
    </tr>
    <tr>
        <td class="verde">CATEGORÍA:</td>
        <td>{{ $datos->solicitud->lote_granel->categoria->categoria ?? ''}}</td>
    </tr>
    <tr>
        <td class="verde">CLASE:</td>
        <td>{{ $datos->solicitud->lote_granel->clase->clase ?? '' }}</td>
        <td rowspan="2" class="verde">INGREDIENTES:</td>
        <td rowspan="2">{{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</td>

        <td rowspan="2" class="verde">VOLUMEN DE LOTE:</td>
        <td rowspan="2"> FALTA </td>
    </tr>
    <tr>
        <td class="verde">EDAD:</td>
        <td>{{ $datos->solicitud->lote_granel->edad ?? 'N/A' }}</td>
    </tr>

    <tr>
        <td colspan="8" style="padding: 5px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>
</table>
<table class="tabla" style="border-collapse: collapse;" width=100%>
    <tr>
        <td class="verde" style="width: 31%; padding:9px;">NO. DE ANÁLISIS FISICOQUÍMICO:</td>
        <td style="width: 19%;">R</td>
        <td style="width: 1px; border:none"></td><!--ESPACIO-->
        <td class="verde" style="width: 25%;">CERTIFICADO NOM A GRANEL:</td>
        <td style="width: 25%;">R</td>
    </tr>

    <tr>
        <td colspan="5" style="padding:5 px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>

    <tr>
        <td colspan="2" style="padding:8px;">{{ $datos->solicitud->instalaciones->responsable ?? ''}}</td>
        <td style="border: none;"></td><!--ESPACIO-->
        <td colspan="2" style="padding:8px;"></td>
    </tr>
    <tr>
        <td colspan="2" class="verde">NOMBRE Y FIRMA DEL RESPONSABLE DE INSTALACIONES</td>
        <td style="border-left: none; border-right: none; border-top: none; border-bottom: 2px solid #000;"></td><!--ESPACIO-->
        <td colspan="2" class="verde">NOMBRE Y FIRMA DEL TÉCNICO INSPECTOR</td>
    </tr>
</table>



</body>
</html>