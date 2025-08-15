<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Etiqueta para tapa de la muestra</title>
    <style>
        @page {
            size: 292mm 227mm;
            margin: 20px 40px 15px 40px;  /*márgenes (arriba, derecha, abajo, izquierda) */
        }
        body {
            font-family: sans-serif;
            /*font-family: 'Arial Negrita', Gadget, sans-serif; /*negrita*/
            font-size: 12px;
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
<table style="border-collapse: collapse; " width=100%>
    <tr>
        <td colspan="5" class="verde">
            CENTRO DE INNOVACION Y DESARROLLO AGROALIMENTARIO DE MICHOACÁN - UNIDAD DE INSPECCIÓN UVNOM-129
        </td>
    </tr>

    <tr>
        <td rowspan="6" style="width: 22%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 180px; height: 95px; padding-left: 17px; padding-top: 17px" alt="Unidad de Inspección">
        </td>
        <td colspan="3" class="verde" style="font-size: 15px;">
            ETIQUETA PARA TAPA MUESTRAS DE LOTE DE MEZCAL A GRANEL
        </td>
        <td rowspan="6" style="width: 22%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 180px; height: 95px; padding-left: 17px; padding-top: 17px" alt="Unidad de Inspección">
        </td>
    </tr>

    <tr>
        <td colspan="3" style="padding: 10px; border: none;"></td><!--LINEAAAA-->
    </tr>

    <tr>
        <td class="verde">FECHA DEL SERVICIO:</td>
        <td rowspan="4" style="width: 25px; border-left: none; border-right: none; border-top: none; border-bottom: 2px solid #000;"> </td>
        <td class="verde">NO. DE SERVICIO:</td>
    </tr>
    <tr>
        <td>{{ Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->translatedFormat('d \d\e F \d\e Y') }}</td>
        <td>{{ $datos->solicitud->inspeccion->num_servicio }}</td>
    </tr>
    <tr>
        <td class="verde">No. DE LOTE A GRANEL:</td>
        <td class="verde">PRODUCTO:</td>
    </tr>

    <tr>
        <td>{{ $datos->solicitud->lote_granel->nombre_lote }}</td>
        <td></td>
    </tr>
</table>



<div style="page-break-before: always;"></div><!-- H O J A  2 -->



<!----------------------- ETIQUETA 2 ----------------------->
<style>
    .tabla2 td {
        font-size: 8px;
        padding: 2px;
    }
</style>
<table class="tabla2" style="border-collapse: collapse; " width=100%>
    <tr>
        <td colspan="6" class="verde">
            CENTRO DE INNOVACION Y DESARROLLO AGROALIMENTARIO DE MICHOACÁN - UNIDAD DE INSPECCIÓN UVNOM-129
        </td>
    </tr>

    <tr>
        <td rowspan="3" style="width:12%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 95px; height: 50px; padding-left: 10px" alt="Unidad de Inspección">
        </td>
        <td colspan="4" class="verde" style="font-size: 11px;">
            ETIQUETAS PARA MUESTRAS DE LOTE DE MEZCAL A GRANEL
        </td>
        <td rowspan="3" style="width:12%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 95px; height: 50px; padding-left: 10" alt="Unidad de Inspección">
        </td>
    </tr>

    <tr>
        <td class="verde" style="width:15%;">FECHA DEL SERVICIO:</td>
        <td>{{ Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->translatedFormat('d \d\e F \d\e Y') }}</td>
        <td class="verde" style="width:15%;">NO. DE SERVICIO:</td>
        <td>{{ $datos->num_servicio ?? 'Sin asignar' }} </td>
    </tr>
    <tr>
        <td class="verde">RAZÓN SOCIAL/PRODUCTOR:</td>
        <td>{{ $datos->solicitud->empresa->razon_social }}</td>
        <td class="verde">DOMICILIO DE INSPECCIÓN:</td>
        <td>{{ $datos->solicitud->instalaciones->direccion_completa }} </td>
    </tr>

    <tr>
        <td colspan="6" style="padding: 2px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>
</table>
<table class="tabla2" style="border-collapse: collapse;" width=100%>
    <tr>
        <td class="verde" style="width:12%;">No. DE LOTE A GRANEL:</td>
        <td>{{ $datos->solicitud->lote_granel->nombre_lote ?? '' }}</td>
        <td rowspan="4" style="width: 6px; border: none;"> </td><!--ESPACIO-->
        <td rowspan="3" class="verde" style="width:12%;">INGREDIENTES:</td>
        <td rowspan="3">{{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</td>
        <td rowspan="4" style="width: 6px; border: none;"> </td><!--ESPACIO-->
        <td rowspan="2" class="verde" style="width:12%;">ESTADO DEL PRODUCTOR:</td>
        <td rowspan="2">{{ $datos->solicitud->lote_granel->estados->nombre ?? '' }}</td>
    </tr>
    <tr>
        <td class="verde">CATEGORÍA Y CLASE:</td>
        <td>{{ $datos->solicitud->lote_granel->categoria->categoria ?? ''}},
            {{ $datos->solicitud->lote_granel->clase->clase ?? '' }}
        </td>
    </tr>
    <tr>
        <td class="verde">EDAD:</td>
        <td>{{ $datos->solicitud->lote_granel->edad ?? 'N/A' }}</td>
        <td rowspan="2" class="verde">DESTINO DE LA MUESTRA:</td>
        <td rowspan="2"> FALTA </td>
    </tr>
    <tr>
        <td class="verde">ESPECIE DE MAGUEY/AGAVE:</td>
        <td>
             @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </td>
        <td class="verde">VOLUMEN DE LOTE:</td>
        <td> {{ $datos->solicitud->lote_granel->volumen ?? '' }} </td>
    </tr>


    <tr>
        <td colspan="8" style="padding: 2px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>
</table>
<table class="tabla2" style="border-collapse: collapse;" width=100%>
    <tr>
        <td rowspan="2" class="verde" style="width:12%;">LOTES DE PROCEDENCIA:</td>
        <td rowspan="2" colspan="2">
            {{ !empty($lotes_procedencia) ? implode(', ', $lotes_procedencia) : 'N/A' }} 
        </td>
        <td rowspan="2" class="verde" style="width:12%;">NO. DE FISICOQUÍMICO:</td>
        <td rowspan="2">{{ $datos->solicitud->lote_granel->folio_fq ?? ''}}</td>
        <td colspan="3" class="verde">TIPO DE ANÁLISIS:</td>
    </tr>
    <tr>
        <td class="verde" >Análisis Completo</td>
        <td class="verde" >Ajuste de Grado</td>
        <td class="verde" >Otros (indique):</td>
    </tr>
@php
    $tipo = $datos->solicitud->tipo_analisis;
@endphp
    <tr>
        <td colspan="5" style="padding: 10px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"> </td>
        <td>{{ $tipo == 1 ? 'x' : '' }}</td>
        <td>{{ $tipo == 2 ? 'x' : '' }}</td>
        <td>{{ !in_array($tipo, [1, 2]) ? 'x' : '' }}</td>
    </tr>

    <tr>
        <td colspan="8" style="padding: 2px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>

    <tr>
        <td colspan="2" class="verde">NOMBRE Y FIRMA DEL RESPONSABLE DE INSTALACIONES</td>
        <td colspan="2">{{ $datos->solicitud->instalaciones->responsable ?? ''}}</td>
        <td colspan="2" class="verde">NOMBRE Y FIRMA DEL TÉCNICO INSPECTOR</td>
        <td colspan="2">{{ $datos->inspector->name ?? ''}}</td>
    </tr>
</table>



<div style="page-break-before: always;"></div><!-- H O J A  3 -->



<!----------------------- ETIQUETA 3 ----------------------->
<style>
    .tabla3 td {
        font-size: 9px;
        padding: 4px;
    }
</style>
<table class="tabla3" style="border-collapse: collapse; " width=100%>
    <tr>
        <td colspan="6" class="verde">
            CENTRO DE INNOVACION Y DESARROLLO AGROALIMENTARIO DE MICHOACÁN - UNIDAD DE INSPECCIÓN UVNOM-129
        </td>
    </tr>

    <tr>
        <td rowspan="3" style="width: 17%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 50px; padding-left: 15px" alt="Unidad de Inspección">
        </td>
        <td colspan="4" class="verde" style="font-size: 12px;">
            ETIQUETAS PARA SELLOS DE TANQUES
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
        <td colspan="6" style="padding: 2px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>
</table>
<table class="tabla3" style="border-collapse: collapse;" width=100%>
    <tr>
        <td class="verde" style="width: 17%;">No. DE LOTE A GRANEL:</td>
        <td>{{ $datos->solicitud->lote_granel->nombre_lote ?? '' }}</td>
        <td rowspan="4" style="width: 6px; border: none;"> </td><!--ESPACIO-->
        <td rowspan="2" class="verde" style="width: 14%;">ID DEL LOTE:</td>
        <td rowspan="2">{{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</td>
        <td rowspan="4" style="width: 6px; border: none;"> </td><!--ESPACIO-->
        <td rowspan="2" class="verde">VOLUMEN DE LOTE:</td>
        <td rowspan="2" style="width:17%;">{{ $datos->solicitud->lote_granel->volumen ?? '' }}</td>
    </tr>
    <tr>
        <td class="verde">CATEGORÍA Y CLASE:</td>
        <td>{{ $datos->solicitud->lote_granel->categoria->categoria ?? ''}},
            {{ $datos->solicitud->lote_granel->clase->clase ?? '' }}
        </td>
    </tr>
    <tr>
        <td class="verde">EDAD:</td>
        <td>{{ $datos->solicitud->lote_granel->edad ?? 'N/A' }}</td>
        <td rowspan="2" class="verde">ESPECIE DE AGAVE:</td>
        <td rowspan="2">
             @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </td>

        <td rowspan="2" class="verde">INGREDIENTES</td>
        <td rowspan="2"> FALTA </td>
    </tr>
    <tr>
        <td colspan="2" style="border-left: 2px solid #000; border-right: none; border-top: none; border-bottom: none;"></td>
    </tr>

    <tr>
        <td colspan="8" style="padding: 2px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>
</table>
<table class="tabla3" style="border-collapse: collapse;" width=100%>
    <tr>
        <td class="verde" style="width: 17%;">NO. DE ANÁLISIS FISICOQUÍMICO:</td>
        <td>R</td>
        <td style="width: 2px; border:none"></td><!--ESPACIO-->
        <td class="verde" style="width: 17%;">CERTIFICADO NOM A GRANEL:</td>
        <td>R</td>
    </tr>

    <tr>
        <td colspan="5" style="padding:5; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>

    <tr>
        <td colspan="2">{{ $datos->solicitud->instalaciones->responsable ?? ''}}</td>
        <td style="border: none;"></td><!--ESPACIO-->
        <td colspan="2"></td>
    </tr>
    <tr>
        <td colspan="2" class="verde">NOMBRE Y FIRMA DEL RESPONSABLE DE INSTALACIONES</td>
        <td style="border-left: none; border-right: none; border-top: none; border-bottom: 2px solid #000;"></td><!--ESPACIO-->
        <td colspan="2" class="verde">NOMBRE Y FIRMA DEL TÉCNICO INSPECTOR</td>
    </tr>
</table>



</body>
</html>