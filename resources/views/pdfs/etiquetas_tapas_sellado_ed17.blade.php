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


<!--etiqueta 1-->
<table style="border-collapse: collapse; " width=100%>
    <tr>
        <td colspan="5" class="verde">
            CENTRO DE INNOVACION Y DESARROLLO AGROALIMENTARIO DE MICHOACÁN - UNIDAD DE INSPECCIÓN UVNOM-129
        </td>
    </tr>

    <tr>
        <td rowspan="6" style="width: 22%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 70px; padding-left: 15px" alt="Unidad de Inspección">
        </td>
        <td colspan="3" class="verde" style="font-size: 15px;">
            ETIQUETA PARA TAPA MUESTRAS DE LOTE DE MEZCAL A GRANEL
        </td>
        <td rowspan="6" style="width: 22%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 70px; padding-left: 15px" alt="Unidad de Inspección">
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



<div style="page-break-before: always;"></div><!-- H O J A  D O S -->




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
        <td rowspan="3" style="width: 4%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 70px; padding-left: 15px" alt="Unidad de Inspección">
        </td>
        <td colspan="4" class="verde" style="font-size: 11px;">
            ETIQUETAS PARA MUESTRAS DE LOTE DE MEZCAL A GRANEL
        </td>
        <td rowspan="3" style="width: 4%;">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 70px; padding-left: 15px" alt="Unidad de Inspección">
        </td>
    </tr>

    <tr>
        <td class="verde">FECHA DEL SERVICIO:</td>
        <td>{{ Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->translatedFormat('d \d\e F \d\e Y') }}</td>
        <td class="verde">NO. DE SERVICIO:</td>
        <td>{{ $datos->num_servicio ?? 'Sin asignar' }} </td>
    </tr>
    <tr>
        <td class="verde">RAZÓN SOCIAL/PRODUCTOR:</td>
        <td>{{ $datos->solicitud->empresa->razon_social }}</td>
        <td class="verde">DOMICILIO DE INSPECCIÓN:</td>
        <td>{{ $datos->solicitud->instalaciones->direccion_completa }} </td>
    </tr>

    <tr>
        <td colspan="6" style="padding: 10px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>
</table>
<table class="tabla2" style="border-collapse: collapse;" width=100%>
    <tr>
        <td class="verde">No. DE LOTE A GRANEL:</td>
        <td>{{ $datos->solicitud->lote_granel->nombre_lote ?? '' }}</td>
        <td rowspan="4" style="border: none;"> </td><!--ESPACIO-->
        <td rowspan="3" class="verde">INGREDIENTES:</td>
        <td rowspan="3">{{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</td>
        <td rowspan="4" style="border: none;"> </td><!--ESPACIO-->
        <td rowspan="2" class="verde">ESTADO DEL PRODUCTOR:</td>
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
        <td colspan="8" style="padding: 10px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>

    <tr>
        <td rowspan="2" class="verde">LOTES DE PROCEDENCIA:</td>
        <td rowspan="2" colspan="2">
            {{ !empty($lotes_procedencia) ? implode(', ', $lotes_procedencia) : 'N/A' }} 
        </td>
        <td rowspan="2" class="verde">NO. DE FISICOQUÍMICO:</td>
        <td rowspan="2">{{ $datos->solicitud->lote_granel->folio_fq ?? ''}}</td>
        <td colspan="3" class="verde">TIPO DE ANÁLISIS:</td>
    </tr>
    <tr>
        <td class="verde">Análisis Completo</td>
        <td class="verde">Ajuste de Grado</td>
        <td class="verde">Otros (indique):</td>
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
        <td colspan="8" style="padding: 10px; border-left: 2px solid #000; border-right: 2px solid #000; border-top: none; border-bottom: none;"></td><!--LINEAAAA-->
    </tr>

    <tr>
        <td colspan="2" class="verde">NOMBRE Y FIRMA DEL RESPONSABLE DE INSTALACIONES</td>
        <td colspan="2">{{ $datos->solicitud->instalaciones->responsable ?? ''}}</td>
        <td colspan="2" class="verde">NOMBRE Y FIRMA DEL TÉCNICO INSPECTOR</td>
        <td colspan="2">{{ $datos->inspector->name ?? ''}}</td>
    </tr>

</table>




</body>
</html>




{{-- 
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            margin-top: -20;
        }

        .etiqueta-table {
            width: 100%;
            margin: 10px 0;
        }

        .etiqueta-table td,
        .etiqueta-table th {
            padding: 2px;
            font-size: 8px;
            border: 0.5px solid #595959;
            height: 17px;
        }

        .etiqueta-table .custom-title {
            font-size: 10px;
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border: 0.5px solid white;
        }

        .etiqueta-table .custom {
            font-size: 16px;
            font-weight: bold;
            background-color: #3C8A69;
            color: white;
            border: 0.5px solid white;
        }

        .etiqueta-table .logo-small {
            max-width: 120px;
            height: auto;
        }

        .etiqueta-table .header-cell-custom {
            background: #3C8A69;
            color: white;
            text-align: center;
            border: 0.5px solid white;
        }

        .etiqueta-table .white-background-custom {
            background-color: white;
            color: black;
            border: 0.5px solid #3C8A69;
        }

        .etiqueta-table .border-green-custom {
            border: 1px solid #3C8A69;
        }

        .etiqueta-table .narrow-margin-custom {
            margin-top: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #3C8A69;
            padding: 3px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background: #f0e6cc;
        }

        .even {
            background: #fbf8f0;
        }

        .odd {
            background: #fefcf9;
        }

        .top {
            margin-top: -20px;
        }
    </style>
</head>

<body>

    <!-- Primera tabla -->
    <table class="etiqueta-table">
        <tbody>
            <tr>
                <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/UVEM_logo.png') }}"
                        alt="Unidad de Inspección" class="logo-small"></td>
                <td colspan="6" class="custom">Etiqueta para muestra</td>
                <td rowspan="3" class="border-green-custom"><img src="{{ public_path('img_pdf/logo_oc_3d.png') }}"
                        alt="Organismo Certificador" class="logo-small"></td>
            </tr>
            <tr>
                <td class="custom-title">Fecha:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->translatedFormat('d \d\e F \d\e Y') }}</strong>
                </td>
                <td class="custom-title">Folio / No. de servicio:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->inspeccion->num_servicio }}</strong></td>
            </tr>
            <tr>
                <td class="custom-title">No. de lote:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->nombre_lote }}</strong></td>
                <td class="custom-title">Volumen del lote:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->volumen }} L</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Maguey Empleado:</td>
                <td colspan="3" class="white-background-custom">
                    <strong>
                        @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                            {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </strong>
                </td>
                {{--                 <td colspan="3" class="white-background-custom"><strong>{{$datos->solicitud->lote_granel->tipos->nombre}} Maguey Espadín, Maguey Tobalá (A. angustifolia), (A. potatorum)</strong></td> 
                --}
                <td colspan="2" class="custom-title">Categoría y clase de mezcal:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->categoria->categoria }},
                        {{ $datos->solicitud->lote_granel->clase->clase }}</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Edad:</td>
                <td class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->edad ?? 'N/A' }}</strong></td>
                <td class="custom-title">Ingredientes:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</strong></td>
                <td class="custom-title">Estado del productor</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->instalaciones->estados->nombre }}</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="custom-title" style="text-align: left;">Marca:</td>
                <td colspan="3" class="white-background-custom"><strong>Por definir</strong></td>
                <td colspan="2" class="custom-title">Destino de la muestra:</td>
                <td colspan="2" class="white-background-custom"><strong>Laboratorio</strong></td>
            </tr>
            <tr>
                <td class="custom-title" style="text-align: left;">Lote de procedencia:</td>
                <td class="white-background-custom">
                    <strong>{{ !empty($lotes_procedencia) ? implode(', ', $lotes_procedencia) : 'N/A' }}</strong>
                  </td>
                <td class="custom-title">No. de Fisicoquímico:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->lote_granel->folio_fq }}</strong></td>
                <td colspan="3" class="custom-title">Tipo de análisis:</td>
            </tr>
            <tr>
                <td rowspan="2" class="custom-title" style="text-align: left;">Razón Social/ Productor:</td>
                <td rowspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->empresa->razon_social }}</strong></td>
                <td rowspan="2" class="custom-title">Domicilio:</td>
                <td colspan="2" rowspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->instalaciones->direccion_completa }}</strong></td>
                <td class="custom-title">Análisis Completo:</td>
                <td class="custom-title">Ajuste de Grado:</td>
                <td class="custom-title">Otros (indique):</td>
            </tr>
            @php
            $tipo = $datos->solicitud->tipo_analisis;
            @endphp
            <tr>
              <td class="white-background-custom"><strong>{{ $tipo == 1 ? 'x' : '' }}</strong></td>
              <td class="white-background-custom"><strong>{{ $tipo == 2 ? 'x' : '' }}</strong></td>
              <td class="white-background-custom"><strong>{{ !in_array($tipo, [1, 2]) ? 'x' : '' }}</strong></td>
          </tr>
            <tr>
                <td colspan="2" class="custom-title">Nombre y firma del inspector:</td>
                <td colspan="2" class="white-background-custom"><strong>{{ $datos->inspector->name }}</strong>
                </td>
                <td colspan="2" class="custom-title">Nombre y firma del responsable:</td>
                <td colspan="2" class="white-background-custom">
                    <strong>{{ $datos->solicitud->instalaciones->responsable }}</strong></td>
            </tr>
        </tbody>
    </table>

</body>

</html>





<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        table.unique-final-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        table.unique-final-table td,
        table.unique-final-table th {
            border: 1px solid #3C8A69;
            padding: 1px;
            text-align: center;
            vertical-align: middle;
            min-height: 10px;
            line-height: 1;
        }

        table.unique-final-table th {
            background: #f0e6cc;
        }

        table.unique-final-table .even {
            background: #fbf8f0;
        }

        table.unique-final-table .odd {
            background: #fefcf9;
        }

        table.unique-final-table .header-cell {
            background-color: #3C8A69;
            color: white;
            font-weight: bold;
            border: 1px solid white;
        }

        table.unique-final-table .logo-cell {
            background-color: white;
            border: 1px solid #3C8A69;
        }

        table.unique-final-table .logo-cell img {
            max-width: 140px;
            height: auto;
        }

        table.unique-final-table td.title-white-border {
            border-bottom: 1px solid #FFFFFF;
        }

        .custom-logo {
            max-width: 120px !important;
            height: auto;
        }
    </style>
</head>

<body>

    <!-- Tabla 7 -->
    <table class="unique-final-table top">
        <tbody>
            <tr>
                <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo" class="custom-logo">
                </td>
                <td colspan="6" class="title title-white-border">Etiqueta para sellado de tanques</td>
                <td rowspan="3" class="logo-cell" style="font-size: 12px;">
                    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo">
                </td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px;">Fecha:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ \Carbon\Carbon::parse($datos->solicitud->fecha_solicitud)->translatedFormat('d \d\e F \d\e Y') }}</strong>
                </td>
                <td class="header-cell" style="font-size: 10px;">Folio / No. de servicio:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->inspeccion->num_servicio }}</strong></td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px;">No. de lote:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->lote_granel->nombre_lote }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">Volumen del lote:</td>
                <td colspan="2" style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->volumen }}
                        L</strong></td>
            </tr>
            <tr>
                <td colspan="1" class="header-cell" style="font-size: 10px;">Razón Social / Productor:</td>
                <td colspan="3" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->empresa->razon_social }}</strong></td>
                <td colspan="2" class="header-cell" style="font-size: 10px;">Nombre de la marca:</td>
                <td colspan="2" style="font-size: 10px;"><strong>Por definir</strong></td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px; text-align: left;">Categoría y clase:</td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->categoria->categoria }},
                        {{ $datos->solicitud->lote_granel->clase->clase }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">Especie de agave:</td>
                <td style="font-size: 10px;"><strong>
                        @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                            {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </strong></td>
                <td class="header-cell" style="font-size: 10px;">Edad:</td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->edad ?? 'N/A' }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">Ingredientes:</td>
                <td style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->lote_granel->ingredientes ?? 'N/A' }}</strong></td>
            </tr>
            <tr>
                <td class="header-cell" style="font-size: 10px; text-align: left;">No. de Análisis Fisicoquímicos:
                </td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->folio_fq }}</strong></td>
                <td class="header-cell" style="font-size: 10px;">ID del tanque:</td>
                <td style="font-size: 10px;"><strong>{{ $datos->solicitud->lote_granel->id_tanque ?? 'N/A' }}</strong>
                </td>
                <td colspan="2" class="header-cell" style="font-size: 10px;">No. de certificado NOM:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>
                        {{$datos->solicitud?->lote_granel?->certificadoGranel?->num_certificado
                            ?? $datos->solicitud?->lote_granel?->folio_certificado
                            ?? 'No encontrado'}}
                    </strong>
                </td>
            </tr>
            <tr>
                <td colspan="1" class="header-cell" style="font-size: 10px; text-align: left;">Nombre y firma del
                    inspector:</td>
                <td colspan="3" style="font-size: 10px;"><strong>{{ $datos->inspector->name }}</strong></td>
                <td colspan="2" class="header-cell" style="font-size: 10px;">Nombre y firma del responsable:</td>
                <td colspan="2" style="font-size: 10px;">
                    <strong>{{ $datos->solicitud->instalaciones->responsable }}</strong></td>
            </tr>
        </tbody>
    </table>


</body>

</html>
 --}}