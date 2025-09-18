<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Etiquetas para muestras de agave (%ART/ARD)</title>
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
            padding-top: 4px;
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


@for ($i = 0; $i < 2; $i++)
<!----------------------- ETIQUETA 1 ----------------------->
<table style="border-collapse: collapse; " width=100%>
    <tr>
        <td colspan="6" class="azul" style="background-color: #0d5295;">
            CENTRO DE INNOVACION Y DESARROLLO AGROALIMENTARIO DE MICHOACÁN - UNIDAD DE INSPECCIÓN UVNOM-129
        </td>
    </tr>

    <tr>
        <td rowspan="4" style="width: 18%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 70px; padding-left: 15px" alt="Logo UI">
        </td>
        <td colspan="4" class="azul" style="background-color: #0d5295; font-size: 13px;">
            ETIQUETAS PARA MUESTRAS DE AGAVE(%ART Y/O ARD)
        </td>
        <td rowspan="4" style="width: 18%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 70px; padding-left: 15px" alt="Logo UI">
        </td>
    </tr>

    <tr>
        <td class="azul" style="width: 14%;">FECHA DEL SERVICIO:</td>
        <td>{{ Carbon\Carbon::parse($datos->fecha_servicio)->translatedFormat('d \d\e F \d\e Y') ?? ''}}</td>
        <td class="azul" style="width: 14%;">NO. DE SERVICIO:</td>
        <td>{{ $datos->num_servicio ?? '' }}</td>
    </tr>
    <tr>
        <td class="azul">RAZÓN SOCIAL:</td>
        <td colspan="3">{{ $datos->solicitud->empresa->razon_social ?? ''}}</td>
    </tr>
    <tr>
        <td class="azul">DOMICILIO DEL SERVICIO:</td>
        <td colspan="3">{{ $datos->solicitud->instalaciones->direccion_completa ?? '' }}</td>
    </tr>

    <tr>
        <td colspan="2" class="azul">MAESTRO MEZCALERO:</td>
        <td>
    {{ $datos->solicitud->instalaciones->dictamen->certificado->maestro_mezcalero ?? '' }}
        </td>
        <td class="azul">DESTINO DE LA MUESTRA:</td>
        <td colspan="2">
            {{ $datos->solicitud->guias->pluck('domicilio')->filter()->implode(', ') }}
        </td>
    </tr>

    <tr>
        <td colspan="6" style="padding: 10px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>
</table>
<table style="border-collapse: collapse;" width=100%>
    <tr>
        <td rowspan="3" style="width: 18%; border-left: 2px solid #000; border-right: none; border-top: none; border-bottom: none;"></td><!--CUADRO BLANCO-->

        <td class="azul" style="width: 18%;">NO. DE GUÍA/NO. DE PREDIO:</td>
        <td>{{ $datos->solicitud->guias->pluck('folio')->filter()->implode(', ') }} / 
            {{ $datos->solicitud->guias->map->predios->pluck('num_predio')->filter()->implode(', ') }}</td>
        <td rowspan="3" style="width: 2px; border:none"> </td><!--ESPACIO-->
        <td class="azul" style="width: 15%;">NO. DE TAPADA:</td>
        <td>{{ $datos->solicitud->guias->pluck('no_lote_pedido')->filter()->implode(', ') }}</td>
    </tr>
    <tr>
        <td class="azul">PESO DE MAGUEY (KG):</td>
        <td>{{ $datos->solicitud->guias->pluck('kg_maguey')->filter()->implode(', ') }}</td>
        <td class="azul">EDAD DEL AGAVE:</td>
        <td>{{ $datos->solicitud->guias->pluck('edad')->filter()->implode(', ') }}</td>
    </tr>
    <tr>
        <td class="azul">NO. DE PIÑAS COMERCIALIZADAS:</td>
        <td>{{ $datos->solicitud->guias->pluck('num_comercializadas')->filter()->implode(', ') }}</td>
        <td class="azul">TIPO DE AGAVE O MAGUEY:</td>
        <td>
            {{-- {{ $datos->solicitud->guias->map->predio_plantacion->map->tipo->pluck('nombre')->filter()->implode(', ') }} --}}
            @php
                $tipos = $datos->solicitud->guias
                    ->map->predio_plantacion      // coleccion de plantaciones
                    ->map->tipo                   // coleccion de tipos
                    ->filter();                   // eliminamos null
            @endphp

            @foreach($tipos as $tipo)
                {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)
                @if (!$loop->last)
                    <br>
                @endif
            @endforeach
        </td>
    </tr>

    <tr>
        <td colspan="6" style="padding:10; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>

    <tr>
        <td class="azul">ANÁLISIS A REALIZAR:</td>
        <td colspan="2"><b>%ART:</b>______ &nbsp;&nbsp;&nbsp; <b>%ARD:</b>______ </td>
        <td style="border:none"> </td><!--ESPACIO-->
        <td class="azul">TIPO DE LA MUESTRA:</td>
        <td style="font-size: 9px"><b>MAGUEY CRUDO:</b>______ &nbsp;&nbsp;&nbsp;<b>MAGUEY COCIDO:</b>______</td>
    </tr>

    <tr>
        <td colspan="6" style="padding:8; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>

    <tr>
        <td colspan="3" style="padding:6;">{{-- {{ $datos->solicitud->instalaciones->responsable ?? ''}} --}}</td>
        <td style="border:none"></td><!--ESPACIO-->
        <td colspan="2" >{{ $datos->inspector->name ?? ''}}</td>
    </tr>

    <tr>
        <td colspan="3" class="azul">NOMBRE Y FIRMA DEL RESPONSABLE DE INSTALACIONES</td>
        <td style="border-left: none; border-right: none; border-top: none; border-bottom: 2px solid #000;"></td><!--ESPACIO-->
        <td colspan="2" class="azul">NOMBRE Y FIRMA DEL TÉCNICO INSPECTOR</td>
    </tr>
</table>

<br><br><br>@endfor



</body>
</html>
