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
<table class="tabla" style="border-collapse: collapse; " width=100%>
    <tr>
        <td colspan="6" class="verde">
            CENTRO DE INNOVACION Y DESARROLLO AGROALIMENTARIO DE MICHOACÁN - UNIDAD DE INSPECCIÓN UVNOM-129
        </td>
    </tr>

    <tr>
        <td rowspan="3" style="width: 17%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 50px; padding-left: 15px" alt="Logo UI">
        </td>
        <td colspan="4" class="verde" style="padding:2px; font-size: 14px;">
            ETIQUETAS PARA LOTES DE MEZCAL A GRANEL
        </td>
        <td rowspan="3" style="width: 17%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 50px; padding-left: 15px" alt="Logo UI">
        </td>
    </tr>

    <tr>
        <td class="verde" style="width: 14%;">FECHA DEL SERVICIO:</td>
        <td>{{ $fecha_servicio }}</td>
        <td class="verde" style="width: 14%;">NO. DE SERVICIO:</td>
        <td>{{ $num_servicio }}</td>
    </tr>
    <tr>
        <td class="verde">RAZÓN SOCIAL:</td>
        <td colspan="3">{{ $razon_social }}</td>
    </tr>

    <tr>
        <td colspan="6" style="padding: 3px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>
</table>
<table class="tabla" style="border-collapse: collapse;" width=100%>
    <tr>
        <td class="verde" style="width: 17%;">No. DE LOTE A GRANEL:</td>
        <td>{{ $nombre_lote }}</td>
        <td rowspan="4" style="width: 6px; border: none;"> </td><!--ESPACIO-->
        <td rowspan="2" class="verde" style="width: 14%;">ESPECIE DE AGAVE:</td>
        <td rowspan="2">
            {{-- @forelse ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)
                @if (!$loop->last)
                    <br>
                @endif
            @empty
                {{-- si está vacío no muestra nada (en blanco) --}
            @endforelse --}}
            {!! $tipo_agave !!}
        </td>
        <td rowspan="4" style="width: 6px; border: none;"> </td><!--ESPACIO-->
        <td rowspan="2" class="verde">ID DE TANQUE (s):</td>
        <td rowspan="2" style="width:17%;">{{ $tanque }}</td>
    </tr>
    <tr>
        <td class="verde">CATEGORÍA:</td>
        <td>{{ $categoria }}</td>
    </tr>
    <tr>
        <td class="verde">CLASE:</td>
        <td>{{ $clase }}</td>
        <td rowspan="2" class="verde">INGREDIENTES:</td>
        <td rowspan="2">{{ $ingredientes }}</td>

        <td rowspan="2" class="verde">VOLUMEN DE LOTE:</td>
        <td rowspan="2">
            {{ $volumen }} L</td>
    </tr>
    <tr>
        <td class="verde">EDAD:</td>
        <td>{{ $edad }}</td>
    </tr>

    <tr>
        <td colspan="8" style="padding: 5px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>
</table>
<table class="tabla" style="border-collapse: collapse;" width=100%>
    <tr>
        <td class="verde" style="width: 31%; padding:9px;">NO. DE ANÁLISIS FISICOQUÍMICO:</td>
        <td style="width: 19%;">{{ $folio_fq }}</td>
        <td style="width: 1px; border:none"></td><!--ESPACIO-->
        <td class="verde" style="width: 25%;">CERTIFICADO NOM A GRANEL:</td>
        <td style="width: 25%;">
            {{ $num_certificado }}
        </td>
    </tr>

    <tr>
        <td colspan="5" style="padding:5 px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>

    <tr>
        <td colspan="2" style="padding:8px;">{{ $responsable  }}</td>
        <td style="border: none;"></td><!--ESPACIO-->
        <td colspan="2" style="padding:8px;">{{ $inspector }}</td>
    </tr>
    <tr>
        <td colspan="2" class="verde">NOMBRE Y FIRMA DEL RESPONSABLE DE INSTALACIONES</td>
        <td style="border-left: none; border-right: none; border-top: none; border-bottom: 2px solid #000;"></td><!--ESPACIO-->
        <td colspan="2" class="verde">NOMBRE Y FIRMA DEL TÉCNICO INSPECTOR</td>
    </tr>
</table>


<br><br><br>
@endfor


{{-- PENDIENTE DE AUTORIZAR
<div style="page-break-before: always;"></div><!-- H O J A  2 -->



<!----------------------- ETIQUETA 2 ----------------------->
<style>
    .tabla3 td {
        font-size: 9px;
        padding: 4px;
    }
</style>
@for ($i = 0; $i < 3; $i++)
<table class="tabla3" style="border-collapse: collapse; " width=100%>
    <tr>
        <td colspan="6" class="verde">
            CENTRO DE INNOVACION Y DESARROLLO AGROALIMENTARIO DE MICHOACÁN - UNIDAD DE INSPECCIÓN UVNOM-129
        </td>
    </tr>

    <tr>
        <td rowspan="3" style="width: 17%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 50px; padding-left: 15px" alt="Logo UI">
        </td>
        <td colspan="4" class="verde" style="padding:1px; font-size: 12px;">
            ETIQUETAS PARA SELLOS DE TANQUES
        </td>
        <td rowspan="3" style="width: 17%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 50px; padding-left: 15px" alt="Logo UI">
        </td>
    </tr>

    <tr>
        <td class="verde" style="width: 14%;">FECHA DEL SERVICIO:</td>
        <td>{{ Carbon\Carbon::parse($datos->fecha_servicio)->translatedFormat('d \d\e F \d\e Y') ?? ''}}</td>
        <td class="verde" style="width: 14%;">NO. DE SERVICIO:</td>
        <td>{{ $datos->num_servicio ?? '' }} </td>
    </tr>
    <tr>
        <td class="verde">RAZÓN SOCIAL:</td>
        <td colspan="3">{{ $datos->solicitud->empresa->razon_social ?? '' }}</td>
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
        <td rowspan="2">{{ $datos->solicitud->lote_granel->id_tanque ?? '' }}</td>
        <td rowspan="4" style="width: 6px; border: none;"> </td><!--ESPACIO-->
        <td rowspan="2" class="verde">VOLUMEN DE LOTE:</td>
        <td rowspan="2" style="width:17%;">{{-- {{ $datos->solicitud->lote_granel->volumen ?? '' }} L -}}</td>
    </tr>
    <tr>
        <td class="verde">CATEGORÍA Y CLASE:</td>
        <td>{{ $datos->solicitud->lote_granel->categoria->categoria ?? ''}}, 
            {{ $datos->solicitud->lote_granel->clase->clase ?? '' }}
        </td>
    </tr>
    <tr>
        <td class="verde">EDAD:</td>
        <td>{{ $datos->solicitud->lote_granel->edad ?? '' }}</td>
        <td rowspan="2" class="verde">ESPECIE DE AGAVE:</td>
        <td rowspan="2">
            @forelse ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)
                @if (!$loop->last)
                    <br>
                @endif
            @empty
                {{-- si está vacío no muestra nada (en blanco) -}}
            @endforelse
        </td>

        <td rowspan="2" class="verde">INGREDIENTES</td>
        <td rowspan="2">{{ $datos->solicitud->lote_granel->ingredientes ?? '' }}</td>
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
        <td>
            {{ $lotesOriginales->map(function($lote) {
                return $lote->folio_fq;
            })->implode(', ') }}
        </td>
        <td style="width: 2px; border:none"></td><!--ESPACIO-->
        <td class="verde" style="width: 17%;">CERTIFICADO NOM A GRANEL:</td>
        <td>
            {{ $lotesOriginales->map(function($lote) {
                return $lote->certificadoGranel?->num_certificado ?? $lote->folio_certificado ?? '';
            })->filter()->implode(', ') }}
        </td>
    </tr>

    <tr>
        <td colspan="5" style="padding:5px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>

    <tr>
        <td colspan="2">{{ $datos->solicitud->instalaciones->responsable ?? ''}}</td>
        <td style="border: none;"></td><!--ESPACIO-->
        <td colspan="2">{{ $datos->inspector->name ?? ''}}</td>
    </tr>
    <tr>
        <td colspan="2" class="verde">NOMBRE Y FIRMA DEL RESPONSABLE DE INSTALACIONES</td>
        <td style="border-left: none; border-right: none; border-top: none; border-bottom: 2px solid #000;"></td><!--ESPACIO-->
        <td colspan="2" class="verde">NOMBRE Y FIRMA DEL TÉCNICO INSPECTOR</td>
    </tr>
</table>

<br>
@endfor --}}


</body>
</html>