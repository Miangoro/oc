<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $datos->folio }}</title>
    <style>
        @page {
            margin-top: 40px;
            margin-right: 50px;
            margin-left: 50px;
            margin-bottom: 1px;
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
            padding: 3px;
            text-align: center;
        }

        th {
            background-color: #608390;
            color: white;
            padding-top: 0;
            padding-bottom: 0;
            text-align: center;
            font-size: 9px;
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

        .letra_td {
            text-align: right;
        }

        .th-color {
            background-color: #d8d8d8;
        }

        .con-negra {
            font-family: 'Century Gothic Negrita';
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td rowspan="3" colspan="3" style="padding: 0; height: auto;">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" style="width: 170px; margin: 0;" alt="Logo CIDAM">
            </td>

            <td class="con-negra" rowspan="2" colspan="5"
                style="font-size: 14px; padding-left: 5px; padding-right: 5px;">SOLICITUD DE SERVICIOS</td>
            <td colspan="5" style="text-align: right; font-size: 8px; padding-left: 0; padding-top: 0;">Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32<br>
                Edición 10 Entrada en vigor:
                20/06/2024
            </td>
        </tr>
        <tr>
            <td colspan="5" style="padding-top: 0; font-size: 9px;">
                ORGANISMO DE CERTIFICACION No. de <br> acreditación 144/18 ante la ema A.C
            </td>
        <tr>
            <td colspan="3">&nbsp;</td>
            <td class="th-color con-negra" colspan="2" style="padding-top: 5px;padding-bottom: 5px;">N° DE SOLICITUD:
            </td>
            <td style="font-size: 16px; color: red" class="con-negra" colspan="5">{{ $datos->folio }}</td>
        </tr>
        <tr>
            <th style="width:60px;">I:</th>
            <th colspan="12" style="padding-top: 2px;padding-bottom: 2px;">INFORMACIÓN DEL SOLICITANTE</th>
        </tr>
        <tr>
            <td class="con-negra" rowspan="2" colspan="2">Nombre del cliente/ o<br> Razon social:</td>
            <td rowspan="2" colspan="4">{{ $datos->empresa->razon_social }}</td>
            <td class="con-negra" colspan="3">N° de cliente:</td>
            <td colspan="4">{{ $datos->empresa->empresaNumClientes->whereNotNull('numero_cliente')->where('numero_cliente', '!=', '')->pluck('numero_cliente')->implode(', ') }}</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="3">e-mail:</td>
            <td colspan="4">{{ $datos->empresa->correo }}</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2">Fecha de solicitud:</td>
            <td colspan="4">{{ $datos->fecha_solicitud }}</td>
            <td class="con-negra" colspan="3">Teléfono:</td>
            <td colspan="4">{{ $datos->empresa->telefono }}</td>
        </tr>
        <tr>
            <td class="con-negra" style="padding-top: 0; padding-bottom: 0;" colspan="2">Responsable de las <br>
                instalaciones</td>
            <td colspan="4">
                {{ $datos->instalacion ? ($datos->instalacion->responsable ? '-----------------' : '-----------------') : '-----------------' }}
            </td>

            <td class="con-negra" colspan="3">SKU:</td>
            <td colspan="4">{{ $datos->lote_envasado->sku ?? '---------------' }}</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2" style="padding-top: 1px; padding-bottom: 1px;">Domicilio Fiscal:</td>
            <td colspan="4">{{ $datos->empresa->domicilio_fiscal }}</td>
            <td class="con-negra" rowspan="2" style="width: 90px; padding: 4px" colspan="3">
                Dirección de destino:<br><br> Empresa de destino:
            </td>
            <td colspan="4" rowspan="2">
                @if ($vigilancia_traslado === 'X')
                    {{ $datos->instalacion_destino->direccion_completa }}
                @else
                    ------------------------
                @endif <br><br>
                @if ($vigilancia_traslado === 'X')
                    {{ $datos->instalacion_destino->empresa->razon_social }}
                @else
                    ------------------------
                @endif
            </td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2">Domicilio de inspección:</td>

            <td colspan="4">
                {{ $datos->instalacion->direccion_completa ?? ($datos->predios->ubicacion_predio ?? '-----------------') }}
            </td>
        </tr>

        <tr>
            <th>II:</th>
            <th colspan="12" style="padding-top: 0;padding-bottom: 0;">
                SERVICIO SOLICITADO A LA UVEM
            </th>
        </tr>
        <tr>
            <td class="td-margins con-negra" colspan="13" style="color: red; padding: 0;">Seleccione el servicio
                solicitado colocando una X en la casilla correspondiente.</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold; padding-top: 0;padding-bottom: 0;">
                Muestreo de agave (ART)</td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;">{{ $muestreo_agave }}</td>
            <td colspan="2" class="td-no-margins letra_td"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0;">Fecha y hora de visita
                propuesta</td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($muestreo_agave === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold;padding-top: 0;padding-bottom: 0;">
                Vigilancia en producción de lote
            </td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;">{{ $vigilancia_produccion }}</td>
            <td colspan="2" class="td-no-margins letra_td"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0;">Fecha y hora de visita propuesta
            </td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($vigilancia_produccion === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>

        </tr>
        <tr>di
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0;">
                Muestreo de lote a granel</td>
            <td style="width: 50px; padding-top: 0;padding-bottom: 0;">{{ $muestreo_granel }}</td>
            <td colspan="2" class="td-no-margins letra_td"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0;">Fecha y hora de visita propuesta
            </td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($muestreo_granel === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Vigilancia en el traslado del
                lote</td>
            <td style="width: 50px;padding-top: 0;padding-bottom: 0;">{{ $vigilancia_traslado }}</td>
            <td colspan="2" class="td-no-margins letra_td"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Fecha y hora de visita
                propuesta</td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($vigilancia_traslado === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Inspección de envasado</td>
            <td style="width: 50px;padding-top: 0;padding-bottom: 0;">{{ $inspeccion_envasado }}</td>
            <td colspan="2" class="td-no-margins letra_td"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Fecha y hora de visita
                propuesta</td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($inspeccion_envasado === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Muestreo de lote envasado</td>
            <td style="width: 50px;padding-top: 0;padding-bottom: 0;">{{ $muestreo_envasado }}</td>
            <td colspan="2" class="td-no-margins letra_td"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Fecha y hora de visita
                propuesta</td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($muestreo_envasado === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Inspeccion ingreso a barrica/
                contenedor de vidrio</td>
            <td style="width: 50px;padding-top: 0;padding-bottom: 0;">{{ $ingreso_barrica }}</td>
            <td colspan="2" class="td-no-margins letra_td"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Fecha y hora de visita
                propuesta</td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($ingreso_barrica === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Liberación de producto terminado
            </td>
            <td style="width: 50px;padding-top: 0;padding-bottom: 0;">{{ $liberacion }}</td>
            <td colspan="2" class="td-no-margins letra_td"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Fecha y hora de visita
                propuesta</td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($liberacion === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Inspección de liberación a
                barrica/contenedor de vidrio</td>
            <td style="width: 50px;padding-top: 0;padding-bottom: 0;">{{ $liberacion_barrica }}</td>
            <td colspan="2" class="td-no-margins letra_td"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Fecha y hora de visita
                propuesta</td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($liberacion_barrica === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Georreferenciación</td>
            <td style="width: 50px;padding-top: 0;padding-bottom: 0;">{{ $geo }}</td>
            <td colspan="2" class=" td-no-margins letra_td"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Fecha y hora de visita
                propuesta</td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($geo === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Pedidos para exportación</td>
            <td style="width: 50px;padding-top: 0;padding-bottom: 0;">{{ $exportacion }}</td>
            <td colspan="2" class=" td-no-margins letra_td"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Fecha y hora de visita
                propuesta</td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($exportacion === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Emisión de certificado NOM a
                granel</td>
            <td style="width: 50px;padding-top: 0;padding-bottom: 0;">{{ $certificado_granel }}</td>
            <td colspan="2" class="td-no-margins letra_td"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Fecha de emisión propuesta:
            </td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($certificado_granel === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>

        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Emisión de certificado venta
                nacional</td>
            <td style="width: 50px;padding-top: 0;padding-bottom: 0;">{{ $certificado_nacional }}</td>
            <td colspan="2" class="td-no-margins letra_td"
                style="font-weight: bold;padding-top: 0;padding-bottom: 0;">Fecha de emisión propuesta:
            </td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($certificado_nacional === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Dictaminación de instalaciones:
            </td>
            <td style="width: 50px;padding-top: 0;padding-bottom: 0;">{{ $dictaminacion }}</td>
            <td class="td-no-margins " style="width: 10px; padding-top: 0;padding-bottom: 0;"></td>
            <td style="width: 50px" style="font-weight: bold; padding-top: 0;padding-bottom: 0;">Productor de <br>
                Mezcal</td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;">
                @if ($dictaminacion === 'X')
                    {{ $productor }}
                @else
                    ----
                @endif
            </td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;font-weight: bold">Envasador</td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;">
                @if ($dictaminacion === 'X')
                    {{ $envasador }}
                @else
                    ----
                @endif
            </td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0; font-weight: bold" colspan="2">
                Comercializador</td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;" colspan="2">
                @if ($dictaminacion === 'X')
                    {{ $comercializador }}
                @else
                    ----
                @endif
            </td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-barra" colspan="4"></td>
            <td colspan="2" class="td-no-margins" style="text-align: right" style="font-weight: bold">Fecha y
                hora de visita propuesta:</td>
            <td colspan="7"><span style="font-size: 14px" class="con-negra">
                    @if ($dictaminacion === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>

        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold; padding-left: 0;">Renovación de
                dictaminación de instalaciones:</td>
            <td style="width: 50px;padding-top: 0;padding-bottom: 0;">{{ $renovacion_dictaminacion }}</td>
            <td class="td-no-margins" style="width: 1px; padding-top: 0;padding-bottom: 0;"></td>
            <td style="width: 70px; padding-top: 0;padding-bottom: 0;font-weight: bold">Productor de <br> Mezcal</td>
            <td style="width: 20px; padding-top: 0;padding-bottom: 0;">
                @if ($renovacion_dictaminacion === 'X')
                    {{ $productor }}
                @else
                    ----
                @endif
            </td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;font-weight: bold">Envasador</td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;">
                @if ($renovacion_dictaminacion === 'X')
                    {{ $envasador }}
                @else
                    ----
                @endif
            </td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;font-weight: bold" colspan="2">Comercializador
            </td>
            <td style="width: 30px; padding-top: 0;padding-bottom: 0;" colspan="2">
                @if ($renovacion_dictaminacion === 'X')
                    {{ $comercializador }}
                @else
                    ----
                @endif
            </td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>

        </tr>
        <tr>
            <td class="td-barra" colspan="4" style="padding-top: 0;padding-bottom: 0;"></td>
            <td colspan="2" class="td-no-margins" style="text-align: right"
                style="font-weight: bold; padding-top: 0;padding-bottom: 0;">Fecha y
                hora de visita propuesta:</td>
            <td colspan="7" style="padding-top: 0;padding-bottom: 0;"><span style="font-size: 14px"
                    class="con-negra">
                    @if ($renovacion_dictaminacion === 'X')
                        {{ $fecha_visita }}
                    @else
                        ------------------------
                    @endif
                </span></td>
        </tr>

        <tr>
            <th>III:</th>
            <th colspan="12" style="padding-top: 0;padding-bottom: 0;">CARACTERISTICAS DEL PRODUCTO</th>
        </tr>
        <tr>
            <td class="con-negra" colspan="2" style="text-align: left">1) No. de lote granel:</td>
            <td colspan="3">{{ $datos->lote_granel->nombre_lote ?? '---------------' }}</td>
            <td class="con-negra" colspan="4" style="text-align: left">6) No. de certificado NOM de Mezcal <br> a
                granel vigente:</td>
            <td colspan="4">{{ $datos->lote_granel->folio_certificado ?? '---------------' }}</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2" style="text-align: left">2) Categoria:</td>
            <td colspan="3">
                @if (empty($datos->lote_granel->categoria->categoria) && $datos->categorias_mezcal()->pluck('categoria')->isEmpty())
                    ---------------
                @else
                    {{ $datos->lote_granel->categoria->categoria ?? '' }}
                    {{ !empty($datos->lote_granel->categoria->categoria) && !empty($datos->categorias_mezcal()->pluck('categoria')->toArray()) ? ',' : '' }}
                    {{ implode(', ', $datos->categorias_mezcal()->pluck('categoria')->toArray()) }}
                @endif
            </td>

            <td class="con-negra" colspan="4" style="text-align: left">7) Clase:</td>
            <td colspan="4">

                @if (empty($datos->lote_granel->clase->clase) && $datos->clases_agave()->pluck('clase')->isEmpty())
                    ---------------
                @else
                    {{ $datos->lote_granel->clase->clase ?? '' }}
                    {{ !empty($datos->lote_granel->clase->clase) && !empty($datos->clases_agave()->pluck('clase')->toArray()) ? ',' : '' }}
                    {{ implode(', ', $datos->clases_agave()->pluck('clase')->toArray()) }}
                @endif

            </td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2" style="text-align: left">3) No. de análisis de
                laboratorio:</td>
            <td colspan="3">{{ $datos->lote_granel->folio_fq ?? '---------------' }}</td>
            <td class="con-negra" colspan="4" style="text-align: left">8) Contenido Alcohólico:</td>
            <td colspan="4">{{ $datos->lote_granel->cont_alc ?? '---------------' }}</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2" style="text-align: left">4) Marca:</td>
            <td colspan="3">{{ $datos->lote_envasado->marca->marca ?? '---------------' }}</td>
            <td class="con-negra" colspan="4" style="text-align: left">9) No. de lote de envasado:</td>
            <td colspan="4">{{ $datos->lote_envasado->nombre ?? '---------------' }}</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2" style="text-align: left">5) Especie de Agave:</td>
            <td colspan="3">
                @if ($datos->lote_granel && $datos->lote_granel->tiposRelacionados->isNotEmpty())
                    @foreach ($datos->lote_granel->tiposRelacionados as $tipo)
                        {{ $tipo->nombre }} (<i style="font-size: 7px">{{ $tipo->cientifico }}</i>)<br>
                    @endforeach
                @else
                    ---------------
                @endif
            </td>
            <td class="con-negra" colspan="4" style="text-align: left">10) Cajas y botellas:</td>
            <td colspan="4">@php
                $caracteristicas = json_decode($datos->caracteristicas, true);
            @endphp

                @if (isset($caracteristicas['detalles']))
                    @foreach ($caracteristicas['detalles'] as $detalle)
                        <span>Cantidad de Botellas: {{ $detalle['cantidad_botellas'] ?? 'No definido' }}</span><br>
                        <span>Cantidad de Cajas: {{ $detalle['cantidad_cajas'] ?? 'No definido' }}</span><br>
                        <span>Presentación: {{ $detalle['presentacion'] ?? 'No definido' }}</span>
                    @endforeach
                @else
                    <p>---------------</< /p>
                @endif
            </td>
        </tr>
    </table>

    <br>
    <br>
    <br>
    <table>
        <tr>
            <td rowspan="3" colspan="2" style="padding: 0; ">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM"
                    style="max-width: 170px; margin: 0;">
            </td>
            <td class="con-negra" rowspan="2" colspan="4" style="font-size: 12px">SOLICITUD DE SERVICIOS</td>
            <td colspan="3" style="text-align: right; font-size: 8.5px !important;">Solicitud de servicios
                NOM-070-SCFI-2016
                F7.1-01-32 <br>
                Edición 10 Entrada en vigor:
                20/06/2024
            </td>
        </tr>
        <tr>
            <td colspan="3">
                ORGANISMO DE CERTIFICACION No. de <br> acreditación 144/18 ante la ema A.C
            </td>
        <tr>
            <td colspan="3">&nbsp;</td>
            <td class="th-color con-negra" style="width: 100px">N° DE SOLICITUD:</td>
            <td style="font-size: 16px; color: red" class="con-negra" colspan="3">{{ $datos->folio }}</td>

        </tr>
        <tr>
            <td class="con-negra" colspan="3" rowspan="3">INFORMACIÓN ADICIONAL SOBRE LA <br> ACTIVIDAD:</td>
            <td class="td-margins" colspan="6">
                @if ($vigilancia_traslado === 'X')
                    <b>Identificador de contenedor de salida:</b> {{ $caracteristicas['id_salida'] }}<br>
                    <b>Identificador de contenedor de recepción:</b> {{ $caracteristicas['id_contenedor'] }}<br>
                    <b>Sobrante en contenedor de salida:</b> {{ $caracteristicas['id_vol_res'] }}<br>
                    <b>Volumen actual del lote:</b> {{ $caracteristicas['id_vol_actual'] }}<br>
                    <b>Volumen trasladado</b> {{ $caracteristicas['id_vol_traslado'] }}<br>
                    <b>Volumen sobrante del lote:</b> {{ $caracteristicas['id_sobrante'] }}<br>
                @elseif($geo === 'X')
                    @foreach ($datos->predios->predio_plantaciones as $plantacion)
                        <b>Especie de agave:</b> {{ $plantacion->tipo->nombre }}
                        (<i>{{ $plantacion->tipo->cientifico }}</i>)<br>
                        <b>No. de Plantas:</b> {{ $plantacion->num_plantas }}<br>
                        <b>Edad de plantación:</b> {{ $plantacion->anio_plantacion }}<br>
                        <b>Tipo de plantación:</b> {{ $plantacion->tipo_plantacion }}<br>
                        <b>Dirección del punto de reunión: </b> {{ $caracteristicas['punto_reunion'] }}<br>
                        <hr>
                    @endforeach
                @elseif($ingreso_barrica === 'X')
                    <b>Tipo:</b> {{ $caracteristicas['tipoIngreso'] }}<br>
                    <b>Volumen ingresado:</b> {{ $caracteristicas['volumen_ingresado'] }}<br>
                    <b>Fecha de ingreso:</b> {{ $caracteristicas['fecha_inicio'] }}
                    {{ $caracteristicas['fecha_termino'] }}<br>
                    <b>Material de los recipientes:</b> {{ $caracteristicas['material'] }}<br>
                    <b>Capacidad de los recipientes:</b> {{ $caracteristicas['capacidad'] }}<br>
                 
                @elseif($muestreo_granel === 'X')
                <b>Tipo:</b> {{ $caracteristicas['tipo_analisis'] == 1 ? 'Análisis completo' : ($caracteristicas['tipo_analisis'] == 2 ? 'Ajuste de grado alcohólico' : '') }}
                <br>
                

                @endif
                {{ $datos->info_adicional ?? '------------------------' }}

                {!! $datos->punto_reunion ? "<br><span class='con-negra'>Punto de reunión: </span> {$datos->punto_reunion}" : '' !!}

            </td>
        </tr>
        <tr>
            <td class="td-margins" colspan="6">&nbsp;</td>

        </tr>
        <tr>
            <td class="td-margins" colspan="6">&nbsp;</td>

        </tr>
        <tr>
            <th style="width:60px;">V:</th>
            <th colspan="8" style="padding-top: 5px;padding-bottom: 5px;">ANEXOS</th>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="con-negra" colspan="8" style="text-align: center; color: red">Adjuntar a la solicitud los
                documentos que a
                continuación se enlistan:</td>
        </tr>
        <tr>
            <td style="width:70px;">&nbsp;</td>
            <td style="width:70px;">&nbsp;</td>
            <td colspan="7" style="font-size: 8px">Copia del análisis de laboratorio de cada uno de los lotes en
                cumplimiento con el
                apartado 4.3 de la NOM-070-SCFI-2016. En caso de <br>
                producto cuente con ajuste de grado alcohólico, reposado o añejo adjuntar copia de los analisis de
                laboratorio posteriores al proceso <br>
                en cumplimiento con el numeral 5 de la NOM-070-SCFI-2016.</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="9" style="font-size: 8px">La empresa se da por enterada que: la Unidad
                de Verificación
                establecerá una vigilancia
                de cumplimiento con la NOM permanente a sus instalaciones una vez que
                el Certificado NOM sea emitido. Para validar la información el OC podrá solicitar los documentos
                originales para su cotejo respectivo</td>
        </tr>
        <tr>
            <th colspan="6" style="padding-top: 5px;padding-bottom: 5px;">VIABILIDAD DEL SERVICIO</th>
            <th rowspan="2" colspan="3">Validó solicitud y verificó la
                viabilidad del servicio:</th>
        </tr>
        <tr>
            <th colspan="4" style="padding-top: 5px;padding-bottom: 5px;">DESCRIPCIÓN:</th>
            <th style="width: 90px">SI</th>
            <th>NO</th>
        </tr>

        <tr>
            <td class="sin-negrita" colspan="4">Se cuenta con todos los medios para realizar todas las actividades
                de evaluación para la <br>
                Certificación:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td rowspan="2" colspan="3">Validó solicitud y verificó la viabilidad del servicio:
            </td>
        </tr>
        <tr>
            <td class="sin-negrita" colspan="4">El organismo de Certificación tiene la competencia para realizar la
                Certificación</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td class="sin-negrita" colspan="4">El organismo de Certificación tiene la capacidad para llevar a cabo
                las actividades de <br>
                certificación</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3" rowspan="2" style="padding-top: 0; margin-top: 0; vertical-align: top">Nombre y
                firma<br></td>
        </tr>
        <td class="sin-negrita" colspan="2">Comentarios:</td>
        <td colspan="4"></td>
        </tr>
    </table>
    <table>



    </table>

</body>

</html>
