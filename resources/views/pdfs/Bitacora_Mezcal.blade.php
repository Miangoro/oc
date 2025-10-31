<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bitácora Mezcal a Granel</title>
</head>
<style>
    body {}

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    th,
    td {
        border: 1px solid;
        padding: 8px;
        text-align: center;
        font-size: 10px;
        word-wrap: break-word;
        width: auto;
        height: 25px;
        font-family: 'calibri';
    }

    /* Estilo para filas alternadas tipo table-striped */
    tr.bitacora-row:nth-child(even) {
        background-color: #dddddd;
        /* Gris claro */
    }

    tr.text-title td,
    tr.text-title th {
        padding: 2px;
        text-align: center;
        font-size: 14px;
        word-break: break-word;
        height: auto;
        width: auto;
        vertical-align: middle;
        background: #bdbdbd;
        font-family: 'calibri-bold';
    }

    tr.bitacora-row td,
    tr.bitacora-row th {
        font-size: 14px;
        /*         border: 1px solid #bbb; */
        padding: 3px 5px;
        text-align: center;
        vertical-align: middle;
        word-wrap: break-word;
    }

    /*     table {
        page-break-inside: auto;
    }

    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    } */
    .pie {
        text-align: right;
        font-size: 12px;
        /* line-height: 1; */
        position: relative;
        bottom: -100px;
        left: 0;
        right: 0;
        width: calc(100% - 40px);
        height: 45px;
        margin-right: 30px;
        padding: 10px 0;
        font-family: 'Lucida Sans Unicode';
        /*  z-index: 1; */
    }

    @page {
        margin: 150px 50px 130px 50px;
    }
</style>

<body>

    <div style="width: 100%; position: fixed; overflow: hidden; margin-top: -130px;">
        {{-- Logo Unidad de Inspección --}}
        <div style="width: 25%; float: left; text-align: left;">
            <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Unidad de Inspección"
                style="height: 100px; width: auto;">
        </div>
        {{-- Título y Cliente --}}
        <div style="width: 50%; float: left; text-align: center;">
            <p style="font-size: 25px; margin: 0; font-family: 'calibri-bold';">
                INVENTARIO DE MEZCAL A GRANEL {{ $title ? "($title)" : '' }}
            </p>
            @php
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
            @endphp
            <p style="font-size: 20px; margin-top: 5px; font-family: 'calibri-bold';">
                <span style="color: red;">&nbsp; {{ $numeroCliente }} - {{ $razon }} </span>
            </p>
            <p style="font-size: px; margin-top: -21px; font-family: 'calibri-bold';  margin-bottom: 15px;">
                INSTALACIÓN: <span style="color: red;">&nbsp; {{  $domicilio_instalacion ?? 'Sin definir' }} </span>
            </p>
        </div>
        {{-- Logo OC (comentado) --}}
        <div style="width: 25%; float: left; text-align: right;">
            {{-- <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo OC" style="height: 100px; width:auto;"> --}}
        </div>
        {{-- Limpiar floats --}}
        <div style="clear: both;"></div>

    </div>




    <table>
        <tbody>
            <tr class="text-title">
                <td rowspan="2">#</td>
                <td rowspan="2">FECHA</td>
                <td rowspan="2">ID DE TANQUE</td>
                <td rowspan="2">LOTE A GRANEL</td>
                <td rowspan="2">OPERACIÓN ADICIONAL</td>
                <td rowspan="2">CATEGORÍA</td>
                <td rowspan="2">CLASE</td>
                <td rowspan="2">INGREDIENTE(S)</td>
                <td rowspan="2">EDAD (AÑOS)</td>
                <td rowspan="2">TIPO DE AGAVE</td>
                <td rowspan="2">NÚM. ANALÍSIS FISICOQUIÍMICO</td>
                <td rowspan="2">NÚM. DE CERTIFICADO</td>
                <td colspan="2">INVENTARIO INICIAL</td>
                <td colspan="4">ENTRADA</td>
                <td colspan="3">SALIDAS</td>
                <td colspan="2">INVENTARIO FINAL</td>
                <td rowspan="2">OBSERVACIONES</td>
                <td rowspan="2">FIRMA DE LA UI</td>
            </tr>
            <tr class="text-title">
                <td>VOLUMEN</td>
                <td>%ALC.VOL.</td>
                <td>PROCEDENCIA</td>
                <td>VOLUMEN</td>
                <td>%ALC.VOL.</td>
                <td>AGUA</td>
                <td>VOLUMEN</td>
                <td>%ALC.VOL.</td>
                <td>DESTINO</td>
                <td>VOLUMEN</td>
                <td>%ALC.VOL.</td>
            </tr>
             @php use Carbon\Carbon; @endphp
            @forelse($bitacoras as $bitacora)
                <tr class="bitacora-row">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bitacora->fecha ? \Carbon\Carbon::parse($bitacora->fecha)->translatedFormat('d \d\e F \d\e Y') : '----'  }}</td>
                    <td>{{ $bitacora->id_tanque ?? $bitacora->loteBitacora?->id_tanque ?? '----' }}</td>
                    <td style="color:darkblue; font-family: 'calibri-bold';">{{ $bitacora->loteBitacora?->nombre_lote ?? '----' }}</td>
                    <td>{{ $bitacora->operacion_adicional ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora->categoria->categoria ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora->clase->clase ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora?->ingredientes ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora?->edad ?? '----' }}</td>

                    <td>
                        {{-- @if ($bitacora->loteBitacora && $bitacora->loteBitacora->tiposRelacionados->isNotEmpty())
                            {!! $bitacora->loteBitacora->tiposRelacionados->map(function ($tipo) {
                                    return $tipo->nombre . ' (<em>' . $tipo->cientifico . '</em>)';
                                })->implode(', ') !!}
                        @else
                            ---
                        @endif --}}
                        @php
                            // IDs guardados en la base (orden original)
                            $orden = json_decode($bitacora->id_tipo ?? '[]', true);
                            $orden = array_map('intval', $orden);

                            // Asegurar que haya tipos relacionados
                            $tipos = $bitacora->loteBitacora->tiposRelacionados ?? collect();

                            // Reordenar según el arreglo de IDs
                            $tiposOrdenados = $tipos->sortBy(function($tipo) use ($orden) {
                                return array_search(intval($tipo->id_tipo), $orden);
                            });
                        @endphp
                            @if ($tiposOrdenados->isNotEmpty())
                                @foreach ($tiposOrdenados as $tipo)
                                    {{ $tipo->nombre }}
                                    @if ($tipo->cientifico)
                                        <em>({{ $tipo->cientifico }})</em>
                                    @endif
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @else
                                ---
                            @endif
                    </td>

                    <td>{{ $bitacora->loteBitacora?->folio_fq ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora?->folio_certificado ?? '----' }}</td>
                    <td>{{ $bitacora->volumen_inicial ?? '----' }}</td>
                    <td>{{ $bitacora->alcohol_inicial ?? '----' }}</td>
                    <td>{{ $bitacora->procedencia_entrada ?? '----' }}</td>
                    <td>{{ $bitacora->volumen_entrada ?? '----' }}</td>
                    <td>{{ $bitacora->alcohol_entrada ?? '----' }}</td>
                    <td>{{ $bitacora->agua_entrada ?? '----' }}</td>
                    <td>{{ $bitacora->volumen_salidas ?? '----' }}</td>
                    <td>{{ $bitacora->alcohol_salidas ?? '----' }}</td>
                    <td>{{ $bitacora->destino_salidas ?? '----' }}</td>
                    <td>{{ $bitacora->volumen_final ?? '----' }}</td>
                    <td>{{ $bitacora->alcohol_final ?? '----' }}</td>
                    <td style="font-size: 10px !important">{{ $bitacora->observaciones ?? '----' }}</td>
                    <td style="padding: 0; text-align: center;">
                        @if ($bitacora->id_firmante != 0 && $bitacora->firmante)
                            @php
                                $firma = $bitacora->firmante->firma;
                                $rutaFirma = public_path('storage/firmas/' . $firma);
                            @endphp

                            @if (!empty($firma) && file_exists($rutaFirma))
                                <img src="{{ $rutaFirma }}" alt="Firma" style="max-width: 100%; height: auto;">
                                <br>
                                <small>{{ $bitacora->firmante->name }}</small>
                            @else
                                <span class="text-muted">Firma no encontrada</span>
                            @endif
                        @else
                            <span>Sin firma</span>
                        @endif
                    </td>


                </tr>
            @empty
                <tr>
                    <td colspan="24" class="text-center">No hay datos para mostrar</td>
                </tr>
            @endforelse

        </tbody>
    </table>
    {{--     <div class="pie">
        <p>Página 1 de 1<br>
        F7.1-01-60 Bitácora Inventario de Mezcal a Granel <br>
        Ed. 0 Entrada en vigor: 21-07-2025
        </p>
    </div> --}}
    {{-- pie de pagina --}}
    <script type="text/php">
      if(isset($pdf)){
        $pdf->page_script('
        $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
        $pdf->text(1580, 1090, "Página $PAGE_NUM de $PAGE_COUNT", $font, 11);
        $pdf->text(1416, 1105, "F7.1-01-60 Bitácora Inventario de Mezcal a Granel", $font, 11);
        $pdf->text(1485, 1120, "Ed. 0 Entrada en vigor: 21-07-2025", $font, 11);
        ');
      }
    </script>

</body>

</html>
