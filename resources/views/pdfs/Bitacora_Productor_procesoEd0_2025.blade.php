<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>F-7.1-01-57 Bitácora para proceso de elaboración de Mezcal Ed 0, vigente.</title>
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid;
        padding: 0;
        text-align: center;
        font-size: 10px;
        word-wrap: break-word;
        width: auto;
        font-family: 'calibri';
    }

    img {
        display: flex;
        margin-bottom: 10px;
    }

    .img .logo-small {
        height: 70px;
        width: auto;
    }

    .text {
        text-align: center;
        margin-top: -50px;
        font-family: 'calibri-bold';
        font-size: 18px;
    }

    tr.text-title td,
    tr.text-title th {
        padding: 0px;
        text-align: center;
        font-size: 12px;
        word-break: break-word;
        height: auto;
        width: auto;
        vertical-align: middle;
        background: #D0CECE;
        font-family: 'calibri-bold';
    }

    .num {
        margin-top: 3rem;
        text-align: right;
        margin-right: 50px;
        font-family: 'calibri-bold';
        font-size: 18px;
    }



    .subtitle {
        text-align: center;
        margin-top: -20px;
        margin-bottom: 1px;
        font-family: 'calibri-bold';
        font-size: 15px;
    }

    .no-border {
        border: none;
        padding: 0;
        font-family: 'calibri';
        font-size: 14px;
        background: white;
    }

    table .no-border {
        background: white;
    }

    .inspector {
        font-family: 'calibri';
        margin-left: 20%;
        margin-top: 2;
        /* margin-bottom: -10px; */
    }

    /* .inspector {
        text-align: right;
        font-family: 'calibri-bold';
        font-size: 15px;
        right: 70px;
        margin-bottom: -40px;
        margin-right: 170px;
    } */

    /* .segunda {
        width: 50%;
        border-collapse: collapse;
    }

    .tercera {
        width: 50%;
        border-collapse: collapse;
        margin-left: auto;

    } */
    /*     .segunda {
        width: 50%;
        float: left;
        border-collapse: collapse;
    }

    .tercera {
        width: 50%;
        float: right;
        border-collapse: collapse;
    } */

    .contenedor-tablas::after {
        content: "";
        display: table;
        clear: both;
    }

    /*  .contenedor-tablas {
        display: flex;
        vertical-align: top;
    }

    .contenedor-tablas table {
        width: 49%;
        border-collapse: collapse;
    } */
    .observaciones-table2 {
        width: 30%;
        border-collapse: collapse;
        margin-left: 0;
    }

    .observaciones-table2 td {
        padding: 2px;
        text-align: center;
        font-size: 12px;
        word-break: break-word;
        height: auto;
        width: auto;
        vertical-align: top;
        background: #D0CECE;
        font-family: 'calibri-bold';
    }

    .observaciones-box {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .observaciones-table td {
        padding: 0 4px;
        /* un poco de padding horizontal para que no quede pegado al borde */
        text-align: left;
        font-size: 12px;
        word-break: break-word;
        height: 24px;
        /* para que la altura sea fija y consistente con min-height */
        vertical-align: bottom;
        /* para que la línea quede justo debajo del texto */
        font-family: 'Calibri', sans-serif;
        border: none;
    }

    .linea {
        text-decoration: underline;
        padding-bottom: 6px;
        /* opcional para algo de espacio */
        min-height: 24px;
        font-family: 'calibri';
        font-size: 12px;
    }

    .text-title-destilacion {
        border: none;
        padding: 0;
        /* font-family: 'calibri'; */
        /* font-size: 14px; */
        background: white;
        text-align: center;
        /* margin-top: -50px; */
        font-size: 14px;
        font-family: 'calibri-bold';
    }

    @page {
        margin: 145px 105px 80px 105px;
    }
</style>

<body>


    {{--     <div class="img">
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Unidad de Inspección" class="logo-small">
    </div>

    <div>
        <p class="text">PROCESO DE ELABORACIÓN DE MEZCAL</p>
    </div>
 --}}

    <div style="width: 100%; position: fixed; overflow: hidden; margin-top: -130px;">
        {{-- Logo Unidad de Inspección --}}
        <div style="width: 25%; float: left; text-align: left;">
            <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Unidad de Inspección"
                style="height: 100px; width: auto;">
        </div>
        {{-- Título y Cliente --}}
        <div style="width: 45%; float: left; text-align: center;">
            <p style="font-size: 30px; margin: 0; font-family: 'calibri-bold';">
                PROCESO DE ELABORACIÓN DE MEZCAL {{-- {{ $title }} --}}
            </p>
            {{--   @php
                $razon = $empresaSeleccionada->razon_social ?? 'Sin razón social';
                $numeroCliente = 'Sin número cliente';

                if ($empresaSeleccionada && $empresaSeleccionada->empresaNumClientes->isNotEmpty()) {
                    foreach ($empresaSeleccionada->empresaNumClientes as $cliente) {
                        if (!empty($cliente->numero_cliente)) {
                            $numeroCliente = $cliente->numero_cliente;
                            break;
                        }
                    }
                }
            @endphp --}}
            <p style="font-size: 20px; margin-top: 5px; font-family: 'calibri-bold';">
                <span style="color: red;">&nbsp; {{-- {{ $numeroCliente }} - {{ $razon }}  --}}</span>
            </p>
        </div>
        {{-- Logo OC (comentado) --}}
        <div style="width: 25%; float: right; text-align: right;">
            {{-- <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo OC" style="height: 100px; width:auto;"> --}}
            {{--  <p class="num">NÚM. TAPADA: {{ $bitacora->numero_tapada ?? '____________' }}</p> --}}
            <p class="num">
                NÚM. TAPADA:
                <span
                    style="
                    font-family: 'calibri-bold';
                    display: inline-block;
                    font-size: 20px;
                    color: red;
                    border-bottom: 1.5px solid black;
                    min-width: 100px;
                    padding-bottom: 1px;
                    text-align: center;">
                    {{ $bitacora->numero_tapada ?? '____________' }}
                </span>
            </p>


        </div>
        {{-- Limpiar floats --}}
        <div style="clear: both;"></div>

    </div>



    <div>
        <p class="subtitle">INGRESO E IDENTIFICACIÓN DEL AGAVE</p>
    </div>
    @php use Carbon\Carbon; @endphp
    <table>
        <tbody>
            <tr class="text-title">
                <td class="no-border"></td>
                <td>FECHA DE INGRESO</td>
                <td>NÚM. DE GUÍA</td>
                <td>TIPO DE MAGUEY</td>
                <td>NÚM. PIÑAS</td>
                <td>KG DE MAGUEY</td>
                <td>% DE ART</td>
            </tr>
            <tr>
                <td class="no-border">1</td>
                <td>{{ Carbon::parse($bitacora->fecha_ingreso)->translatedFormat('d \d\e F \d\e Y') }}</td>

                <td>{{ $bitacora->numero_guia ?? '' }}</td>
                @php
                    use App\Models\tipos;

                    $tipos = tipos::whereIn('id_tipo', $bitacora->id_tipo_maguey_array)->get();
                @endphp

                <td>
                    @foreach ($tipos as $tipo)
                        {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                </td>

                {{-- <td>{{ $bitacora->id_tipo_maguey ?? '' }}</td> --}}
                <td>{{ $bitacora->numero_pinas ?? '' }}</td>
                <td>{{ $bitacora->kg_maguey ?? '' }}</td>
                <td>{{ $bitacora->porcentaje_azucar ?? '' }}</td>
            </tr>
            {{-- <tr>
                <td class="no-border">1</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">2</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">3</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr> --}}
        </tbody>
    </table>
    <p class="inspector" style="font-family: 'calibri';">
        NOMBRE Y FIRMA DEL INSPECTOR&nbsp;&nbsp;

        @if ($userEntradaMaguey && $userEntradaMaguey->firma)
            @php
                $firma = $userEntradaMaguey->firma;
                $rutaFirma = public_path('storage/firmas/' . $firma);
            @endphp

            @if (!empty($firma) && file_exists($rutaFirma))
                <span style="display: inline-block; text-align: center; min-width: 150px;">
                    <img src="{{ $rutaFirma }}" alt="Firma"
                        style="height: 50px; margin-bottom: -35px; margin-top: 10px;">
                    <br>
                    <span
                        style="border-bottom: 1.2px solid #000; display: inline-block; min-width: 405px; margin-top:18px;">
                        {{ $userEntradaMaguey->name }}
                    </span>
                </span>
            @else
                <span style="border-bottom: 1.5px solid #000; min-width: 300px; display: inline-block;">
                    Firma no encontrada
                </span>
            @endif
        @else
            <span style="border-bottom: 1.5px solid #000; min-width: 300px; display: inline-block;">
                Sin firma
            </span>
        @endif
    </p>
    {{--  <div> --}}
    {{-- <p class="datos"></p> --}}
    {{-- <p class="inspector">NOMBRE Y FIRMA DEL INSPECTOR
        ____________________________________________________________________</p> --}}
    {{-- </div> --}}

    <br>

    <div>
        <p class="subtitle">COCCIÓN DE AGAVE</p>
    </div>

    <table>
        <tbody>
            <tr class="text-title">
                <td class="no-border"></td>
                <td>Kg A COCCIÓN </td>
                <td>TIPO DE MAGUEY</td>
                <td>FECHA DE INICIO</td>
                <td>FECHA DE TÉRMINO</td>
            </tr>
            <tr>
                <td class="no-border">1</td>
                <td>{{ $bitacora->kg_coccion ?? '' }}</td>

                <td>
                    @foreach ($tipos as $tipo)
                        {{ $tipo->nombre }} (<em>{{ $tipo->cientifico }}</em>)@if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                </td>
                <td>{{ Carbon::parse($bitacora->fecha_inicio_coccion)->translatedFormat('d \d\e F \d\e Y') }}</td>
                <td>{{ Carbon::parse($bitacora->fecha_fin_coccion)->translatedFormat('d \d\e F \d\e Y') }}</td>
            </tr>
            {{--  <tr>
                <td class="no-border">2</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">3</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr> --}}
        </tbody>
    </table>

    {{-- font-family: 'calibri';
        margin-left: 20%;
        margin-top: 2; --}}


    {{--
    <p class="inspector">NOMBRE Y FIRMA DEL INSPECTOR  ____________________________________________________</p>
 --}}
    <p class="inspector" style="font-family: 'calibri';">
        NOMBRE Y FIRMA DEL INSPECTOR&nbsp;&nbsp;

        @if ($userCoccion && $userCoccion->firma)
            @php
                $firmaC = $userCoccion->firma;
                $rutaFirmaC = public_path('storage/firmas/' . $firmaC);
            @endphp

            @if (!empty($firmaC) && file_exists($rutaFirmaC))
                <span style="display: inline-block; text-align: center; min-width: 150px;">
                    <img src="{{ $rutaFirmaC }}" alt="Firma"
                        style="height: 50px; margin-bottom: -35px; margin-top: 10px;">
                    <br>
                    <span
                        style="border-bottom: 1.2px solid #000; display: inline-block; min-width: 405px; margin-top:20px;">
                        {{ $userCoccion->name }}
                    </span>
                </span>
            @else
                <span style="border-bottom: 1.5px solid #000; min-width: 300px; display: inline-block;">
                    Firma no encontrada
                </span>
            @endif
        @else
            <span style="border-bottom: 1.5px solid #000; min-width: 300px; display: inline-block;">
                Sin firma
            </span>
        @endif
    </p>

    <br>
    <div>
        <p class="subtitle">MOLIENDA, FORMULACIÓN Y PRIMERA DESTILACIÓN</p>
    </div>

    <table>
        <tbody>
            <tr class="text-title">
                <td class="no-border"></td>
                <td rowspan="2">FECHA DE MOLIENDA</td>
                <td rowspan="2">NÚM. DE TINA</td>
                <td rowspan="2">FECHA DE FORMULACIÓN</td>
                <td rowspan="2">VOLUMEN FORMULADO</td>
                <td rowspan="2">FECHA DE DESTILACIÓN</td>
                <td colspan="2">FLOR</td>
                <td colspan="2">ORDINARIO</td>
                <td colspan="2">COLAS</td>
            </tr>
            <tr class="text-title">
                <td class="no-border"></td>
                <td>Volumen</td>
                <td>%Alc.Vol.</td>
                <td>Volumen</td>
                <td>%Alc.Vol.</td>
                <td>Volumen</td>
                <td>%Alc.Vol.</td>
            </tr>
            @php
                $total_puntas_volumen = 0;
                $total_mezcal_volumen = 0;
                $total_colas_volumen = 0;

                /* $total_puntas_porcentaje = 0; */
                /* $total_mezcal_porcentaje = 0; */
                /* $total_colas_porcentaje = 0; */

            @endphp

            @foreach ($bitacora->molienda as $index => $molienda)
                @php
                    $total_puntas_volumen += $molienda->puntas_volumen ?? 0;
                    $total_mezcal_volumen += $molienda->mezcal_volumen ?? 0;
                    $total_colas_volumen += $molienda->colas_volumen ?? 0;

                    /* $total_puntas_porcentaje += $molienda->puntas_porcentaje ?? 0; */
                    /*  $total_mezcal_porcentaje += $molienda->mezcal_porcentaje ?? 0; */
                    /*  $total_colas_porcentaje += $molienda->colas_porcentaje ?? 0; */

                @endphp
                <tr>
                    <td class="no-border">{{ $index + 1 }}</td>
                    <td>
                        {{ $molienda->fecha_molienda ? \Carbon\Carbon::parse($molienda->fecha_molienda)->translatedFormat('d \d\e F \d\e Y') : '' }}
                    </td>
                    <td>{{ $molienda->numero_tina ?? '' }}</td>
                    <td>
                        {{ $molienda->fecha_formulacion ? \Carbon\Carbon::parse($molienda->fecha_formulacion)->translatedFormat('d \d\e F \d\e Y') : '' }}
                    </td>
                    <td>{{ $molienda->volumen_formulacion !== null ? number_format($molienda->volumen_formulacion, 2) : '' }}
                    </td>
                    <td>
                        {{ $molienda->fecha_destilacion ? \Carbon\Carbon::parse($molienda->fecha_destilacion)->translatedFormat('d \d\e F \d\e Y') : '' }}
                    </td>
                    <td>{{ $molienda->puntas_volumen !== null ? number_format($molienda->puntas_volumen, 2) : '' }}
                    </td>
                    <td>{{ $molienda->puntas_porcentaje !== null ? number_format($molienda->puntas_porcentaje, 2) . '%' : '' }}
                    </td>
                    <td>{{ $molienda->mezcal_volumen !== null ? number_format($molienda->mezcal_volumen, 2) : '' }}
                    </td>
                    <td>{{ $molienda->mezcal_porcentaje !== null ? number_format($molienda->mezcal_porcentaje, 2) . '%' : '' }}
                    </td>
                    <td>{{ $molienda->colas_volumen !== null ? number_format($molienda->colas_volumen, 2) : '' }}</td>
                    <td>{{ $molienda->colas_porcentaje !== null ? number_format($molienda->colas_porcentaje, 2) . '%' : '' }}
                    </td>
                </tr>
            @endforeach

            <tr>
                <td class="no-border"></td>
                <td class="no-border"></td>
                <td class="no-border"></td>
                <td>VOLUMEN TOTAL</td>
                <td>{{ $bitacora->molienda_total_formulado }}</td>
                <td>VOLUMEN TOTAL</td>
                <td>{{ number_format($total_puntas_volumen, 2) }}</td>
                <td>{{$bitacora->total_puntas_porcentaje}}%</td> {{-- % total --}}
                <td>{{ number_format($total_mezcal_volumen, 2) }}</td>
                <td>{{$bitacora->total_mezcal_porcentaje}}%</td>{{-- % total --}}
                <td>{{ number_format($total_colas_volumen, 2) }}</td>
                <td>{{$bitacora->total_colas_porcentaje}}%</td> {{-- % total --}}
            </tr>
        </tbody>
    </table>
    <p class="inspector" style="font-family: 'calibri';">
        NOMBRE Y FIRMA DEL INSPECTOR&nbsp;&nbsp;

        @if ($userMolienda && $userMolienda->firma)
            @php
                $firmaM = $userMolienda->firma;
                $rutaFirmaM = public_path('storage/firmas/' . $firmaM);
            @endphp

            @if (!empty($firmaM) && file_exists($rutaFirmaM))
                <span style="display: inline-block; text-align: center; min-width: 150px;">
                    <img src="{{ $rutaFirmaM }}" alt="Firma"
                        style="height: 50px; margin-bottom: -35px; margin-top: 10px;">
                    <br>
                    <span
                        style="border-bottom: 1.2px solid #000; display: inline-block; min-width: 405px; margin-top:18px;">
                        {{ $userMolienda->name }}
                    </span>
                </span>
            @else
                <span style="border-bottom: 1.5px solid #000; min-width: 300px; display: inline-block;">
                    Firma no encontrada
                </span>
            @endif
        @else
            <span style="border-bottom: 1.5px solid #000; min-width: 300px; display: inline-block;">
                Sin firma
            </span>
        @endif
    </p>
    {{--   <div> --}}
    {{-- <p class="datos"></p> --}}
    {{--  <p class="inspector">NOMBRE Y FIRMA DEL INSPECTOR
        ____________________________________________________________________</p> --}}
    {{--   </div> --}}

    <table width="100%" style="border: none;">
        <tr style="border: none;">
            <td style="vertical-align: top; width: 50%; border: none;">
                <table class="segunda" style="width: 100%;">
                    <!-- tabla de segunda destilación -->
                    <tbody>
                        <tr>
                            <td class="text-title-destilacion" {{-- style="vertical-align: bottom; font-weight: bold; font-family: 'calibri-bold'; " --}} colspan="8">SEGUNDA DESTILACIÓN
                            </td>
                        </tr>

                        <tr class="text-title">
                            <td class="no-border"></td>
                            <td rowspan="2">FECHA DE DESTILACIÓN</td>
                            <td colspan="2">FLOR</td>
                            <td colspan="2">MEZCAL</td>
                            <td colspan="2">COLAS</td>
                        </tr>
                        <tr class="text-title">
                            <td class="no-border"></td>
                            <td>Volumen</td>
                            <td>%Alc.Vol.</td>
                            <td>Volumen</td>
                            <td>%Alc.Vol.</td>
                            <td>Volumen</td>
                            <td>%Alc.Vol.</td>
                        </tr>
                        @foreach ($bitacora->segundaDestilacion as $index => $destilacion)
                            <tr>
                                <td class="no-border">{{ $index + 1 }}</td>
                                <td>{{ $destilacion->fecha_destilacion ? \Carbon\Carbon::parse($destilacion->fecha_destilacion)->translatedFormat('d \d\e F \d\e Y') : '' }}
                                </td>
                                <td>{{ $destilacion->puntas_volumen !== null ? number_format($destilacion->puntas_volumen, 2) : '' }}
                                </td>
                                <td>{{ $destilacion->puntas_porcentaje !== null ? number_format($destilacion->puntas_porcentaje, 2) . '%' : '' }}
                                </td>
                                <td>{{ $destilacion->mezcal_volumen !== null ? number_format($destilacion->mezcal_volumen, 2) : '' }}
                                </td>
                                <td>{{ $destilacion->mezcal_porcentaje !== null ? number_format($destilacion->mezcal_porcentaje, 2) . '%' : '' }}
                                </td>
                                <td>{{ $destilacion->colas_volumen !== null ? number_format($destilacion->colas_volumen, 2) : '' }}
                                </td>
                                <td>{{ $destilacion->colas_porcentaje !== null ? number_format($destilacion->colas_porcentaje, 2) . '%' : '' }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="no-border"></td>
                            <td>VOLUMEN TOTAL</td>
                            <td>{{ $bitacora->total_puntas_volumen ?? '' }}</td>
                            <td>{{ $bitacora->total_puntas_porcentaje ? $bitacora->total_puntas_porcentaje . '%' : '' }}
                            </td>

                            <td>{{ $bitacora->total_mezcal_volumen ?? '' }}</td>
                            <td>{{ $bitacora->total_mezcal_porcentaje ? $bitacora->total_mezcal_porcentaje . '%' : '' }}
                            </td>

                            <td>{{ $bitacora->total_colas_volumen ?? '' }}</td>
                            <td>{{ $bitacora->total_colas_porcentaje ? $bitacora->total_colas_porcentaje . '%' : '' }}
                            </td>

                            {{-- <td>{{ $bitacora->total_puntas_volumen ?? '' }}</td>
                    <td>{{ $bitacora->total_puntas_porcentaje ?? ''}}</td> '%'
                    <td>{{ $bitacora->total_mezcal_volumen ?? '' }}</td>
                    <td>{{$bitacora->total_mezcal_porcentaje ?? ''}}</td> '%'
                    <td>{{ $bitacora->total_colas_volumen ?? '' }}</td>
                    <td>{{ $bitacora->total_colas_porcentaje ?? ''}}</td> '%' --}}
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="vertical-align: top; width: 50%; border: none;">
                <table class="tercera" style="width: 100%;">
                    <!-- tabla de tercera destilación -->

                    <tbody>
                        <tr>
                            <td class="text-title-destilacion" {{--  style="vertical-align: bottom; font-weight: bold; font-family: 'calibri-bold'; " --}} colspan="8">TERCERA DESTILACIÓN
                            </td>
                        </tr>

                        <tr class="text-title">
                            <td class="no-border"></td>
                            <td rowspan="2">FECHA DE DESTILACIÓN</td>
                            <td colspan="2">FLOR</td>
                            <td colspan="2">MEZCAL</td>
                            <td colspan="2">COLAS</td>
                        </tr>
                        <tr class="text-title">
                            <td class="no-border"></td>
                            <td>Volumen</td>
                            <td>%Alc.Vol.</td>
                            <td>Volumen</td>
                            <td>%Alc.Vol.</td>
                            <td>Volumen</td>
                            <td>%Alc.Vol.</td>
                        </tr>
                        <tr>
                            <td class="no-border">1</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="no-border">2</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="no-border">3</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="no-border"></td>
                            <td>VOLUMEN TOTAL</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <p class="inspector" style="font-family: 'calibri';">
        NOMBRE Y FIRMA DEL INSPECTOR&nbsp;&nbsp;

        @if ($userSegundaDestilacion && $userSegundaDestilacion->firma)
            @php
                $firmaS = $userSegundaDestilacion->firma;
                $rutaFirmaS = public_path('storage/firmas/' . $firmaS);
            @endphp

            @if (!empty($firmaS) && file_exists($rutaFirmaS))
                <span style="display: inline-block; text-align: center; min-width: 150px;">
                    <img src="{{ $rutaFirmaS }}" alt="Firma"
                        style="height: 50px; margin-bottom: -35px; margin-top: 10px;">
                    <br>
                    <span
                        style="border-bottom: 1.2px solid #000; display: inline-block; min-width: 405px; margin-top:18px;">
                        {{ $userSegundaDestilacion->name }}
                    </span>
                </span>
            @else
                <span style="border-bottom: 1.5px solid #000; min-width: 300px; display: inline-block;">
                    Firma no encontrada
                </span>
            @endif
        @else
            <span style="border-bottom: 1.5px solid #000; min-width: 300px; display: inline-block;">
                Sin firma
            </span>
        @endif
    </p>

    <p class="inspector" style="font-family: 'calibri';">
        NOMBRE Y FIRMA DEL INSPECTOR&nbsp;&nbsp;

        @if ($userProductoTerminado && $userProductoTerminado->firma)
            @php
                $firmaP = $userProductoTerminado->firma;
                $rutaFirmaP = public_path('storage/firmas/' . $firmaP);
            @endphp

            @if (!empty($firmaP) && file_exists($rutaFirmaP))
                <span style="display: inline-block; text-align: center; min-width: 150px;">
                    <img src="{{ $rutaFirmaP }}" alt="Firma"
                        style="height: 50px; margin-bottom: -35px; margin-top: 10px;">
                    <br>
                    <span
                        style="border-bottom: 1.2px solid #000; display: inline-block; min-width: 405px; margin-top:18px;">
                        {{ $userProductoTerminado->name }}
                    </span>
                </span>
            @else
                <span style="border-bottom: 1.5px solid #000; min-width: 300px; display: inline-block;">
                    Firma no encontrada
                </span>
            @endif
        @else
            <span style="border-bottom: 1.5px solid #000; min-width: 300px; display: inline-block;">
                Sin firma
            </span>
        @endif
    </p>
    {{--   <div> --}}
    {{-- <p class="datos"></p> --}}
    {{--     <p class="inspector">NOMBRE Y FIRMA DEL INSPECTOR
        ____________________________________________________________________</p> --}}
    {{--    </div> --}}

    {{--   <br> --}}

    <table class="observaciones-table2">
        <tr>
            <td>OBSERVACIONES</td>
        </tr>
    </table>

    @php
        $lines = preg_split('/\r\n|\r|\n/', $bitacora->observaciones ?? '');
        $max_lines = 5;
    @endphp

    <table class="observaciones-table">
        @for ($i = 0; $i < $max_lines; $i++)
            <tr class="line">
                <td class="linea">
                    {{ $lines[$i] ?? '' }}
                </td>
            </tr>
        @endfor
    </table>


    {{--  <table class="observaciones-table">
        <!-- Líneas para escribir -->
        <tr class="line">
            <td class="linea"></td>
        </tr>
        <tr class="line">
            <td class="linea"></td>
        </tr>
        <tr class="line">
            <td class="linea"></td>
        </tr>
        <tr class="line">
            <td class="linea"></td>
        </tr>
        <tr class="line">
            <td class="linea"></td>
        </tr>
    </table> --}}

    <script type="text/php">
    if (isset($pdf)) {
        $pdf->page_script('

            $font = $fontMetrics->get_font("Calibri", "normal");
            $width = $pdf->get_width();
            $size = 11;

            $text1 = "Página $PAGE_NUM de $PAGE_COUNT";
            $text2 = "F-7.1-01-57 Bitácora para proceso de elaboración de Mezcal";
            $text3 = "Ed. 0 Entrada en vigor: 21-07-2025";

            $textWidth1 = $fontMetrics->getTextWidth($text1, $font, $size);
            $textWidth2 = $fontMetrics->getTextWidth($text2, $font, $size);
            $textWidth3 = $fontMetrics->getTextWidth($text3, $font, $size);

            // 🠗 Posición vertical
            $y = 550;

            // 🠔 Más a la izquierda
            $rightMargin = 100;

            $x1 = $width - $textWidth1 - $rightMargin;
            $x2 = $width - $textWidth2 - $rightMargin;
            $x3 = $width - $textWidth3 - $rightMargin;

            $pdf->text($x1, $y, $text1, $font, $size);
            $pdf->text($x2, $y + 15, $text2, $font, $size);
            $pdf->text($x3, $y + 30, $text3, $font, $size);
        ');
    }
    </script>





</body>

</html>
