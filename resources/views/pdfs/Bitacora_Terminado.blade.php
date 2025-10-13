<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bitácora Producto Terminado</title>
</head>
<style>
    table {
        width: 101%;
        border-collapse: collapse;
        /* table-layout: fixed; */
    }

     tr:nth-child(even) {
        background-color: #f2f2f2; /* gris claro */
    }

    th,
    td {
        border: 1px solid;
        padding: 8px;
        text-align: center;
        font-size: 14px;
        word-wrap: break-word;
        width: auto;
        height: 25px;
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
        font-size: 20px;
    }

    tr.text-title td,
    tr.text-title th {
        padding: 2px;
        text-align: center;
        font-size: 10.5px;
        word-break: break-word;
        height: auto;
        width: auto;
        vertical-align: middle;
        background: #D0CECE;
        font-family: 'calibri-bold';
    }

    .pie {
        text-align: right;
        font-size: 12px;
        line-height: 1;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: calc(100% - 40px);
        height: 45px;
        margin-right: 30px;
        padding: 10px 0;
        font-family: 'Lucida Sans Unicode';
        z-index: 1;
        color: #000000;
    }
     @page {
        margin: 150px 50px 130px 50px;
    }
</style>

<body>
{{--     <div class="img">
        <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
    </div>

    <div>
        @php
            $razon = $empresaPadre->razon_social ?? 'Sin razón social';
            $numeroCliente = 'Sin número cliente';
            if ($empresaPadre && $empresaPadre->empresaNumClientes->isNotEmpty()) {
                foreach ($empresaPadre->empresaNumClientes as $cliente) {
                    if (!empty($cliente->numero_cliente)) {
                        $numeroCliente = $cliente->numero_cliente;
                        break;
                    }
                }
            }
        @endphp

        <p class="text">INVENTARIO DE PRODUCTO TERMINADO {{ $title }} <br>
            <span style="color: red;">&nbsp; {{ $numeroCliente }} - {{ $razon }} </span>
        </p>
    </div> --}}

    <div style="width: 100%; position: fixed; overflow: hidden; margin-top: -130px;">
        {{-- Logo Unidad de Inspección --}}
        <div style="width: 25%; float: left; text-align: left;">
            <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Unidad de Inspección" style="height: 100px; width: auto;">
        </div>
        {{-- Título y Cliente --}}
        <div style="width: 50%; float: left; text-align: center;">
            <p style="font-size: 25px; margin: 0; font-family: 'calibri-bold';">
                INVENTARIO DE PRODUCTO TERMINADO {{ $title }}
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
                <td rowspan="2">BOT/ CAJA</td>
                <td rowspan="2">MARCA</td>
                <td rowspan="2">SKU</td>
                <td rowspan="2">LOTE A GRANEL</td>
                <td rowspan="2">LOTE DE ENVASADO</td>
                <td rowspan="2">NÚM. ANÁLISIS FISICOQUÍMICO</td>
                <td rowspan="2">NÚM. DE CERTIFICADO</td>
                <td rowspan="2">CATEGORÍA</td>
                <td rowspan="2">CLASE</td>
                <td rowspan="2">INGREDIENTE</td>
                <td rowspan="2">EDAD (AÑOS)</td>
                <td rowspan="2">TIPO DE AGAVE</td>
                <td rowspan="2">CAPACIDAD</td>
                <td rowspan="2">%ALC.VOL.</td>
                <td colspan="2">I. INICIAL</td>
                <td colspan="3">ENTRADAS</td>
                <td colspan="3">SALIDAS</td>
                <td colspan="2">I. FINAL</td>
                <td rowspan="2">MERMAS</td>
                <td rowspan="2" style="width: 200px;">OBSERVACIONES</td>
                <td rowspan="2">FIRMA DE LA UV</td>
            </tr>
            <tr class="text-title">
                <td>NÚM. CAJAS</td>
                <td>NÚM. BOT.</td>
                <td>PROCEDENCIA</td>
                <td>NÚM. CAJAS</td>
                <td>NÚM. BOT.</td>
                <td>DESTINO</td>
                <td>NÚM. CAJAS</td>
                <td>NÚM. BOT.</td>
                <td>NÚM. CAJAS</td>
                <td>NÚM. BOT</td>
            </tr>
             @php use Carbon\Carbon; @endphp
            @foreach ($bitacoras as $bitacora)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                   <td>
                        {{ $bitacora->fecha
                            ? \Carbon\Carbon::parse($bitacora->fecha)->translatedFormat('d \d\e F \d\e Y')
                            : '----'
                        }}
                    </td>
                    <td>{{ $bitacora->cantidad_botellas_cajas ?? '' }}</td> {{-- botellas_por_caja --}}
                    <td>{{ $bitacora->marca->marca ?? '----' }}</td>
                    <td>{{ $bitacora->sku ?? '----' }}</td>
                    <td>{{ $bitacora->granel->nombre_lote ?? '----' }}</td>
                    <td><b>{{ $bitacora->envasado->nombre ?? '----' }}</b></td>
                    <td>{{ $bitacora->folio_fq ?? '----' }}</td> {{-- num_analisis_fq --}}
                    <td>{{ $bitacora->granel->certificadoGranel->num_certificado ?? '----' }}</td> {{-- num_certificado --}}
                    <td>{{ $bitacora->categorias->categoria ?? '----' }}</td> {{-- puedes mapear esto desde id_categoria si quieres mostrar nombre --}}
                    <td>{{ $bitacora->clases->clase ?? '----' }}</td> {{-- igual con id_clase --}}
                    <td>{{ $bitacora->ingredientes ?? '----' }}</td> {{-- ingrediente --}}
                    <td>{{ $bitacora->edad ?? '----' }}</td>

                    <td>
                        {{-- @foreach ($bitacora->tipos_agave as $tipo)
                            {{ $tipo->nombre }}
                            @if ($tipo->cientifico)
                                <em>({{ $tipo->cientifico }})</em>
                            @endif
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach --}}
                        @php//ORDENAR TIPOS POR GUARDADO
                            // IDs guardados en la base (orden original)
                            $orden = json_decode($bitacora->id_tipo ?? '[]', true); // ["8","1","2"]
                            $orden = array_map('intval', $orden); // convertir a enteros
                            // Reordenar la colección según el arreglo de IDs
                            $tiposOrdenados = $bitacora->tipos_agave->sortBy(function($tipo) use ($orden) {
                                return array_search(intval($tipo->id_tipo), $orden);
                            });
                        @endphp
                        @foreach ($tiposOrdenados as $tipo)
                            {{ $tipo->nombre }}
                            @if ($tipo->cientifico)
                                <em>({{ $tipo->cientifico }})</em>
                            @endif
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </td>

                    <td>{{ $bitacora->capacidad ?? '----' }}</td>
                    <td>{{ $bitacora->alc_vol ?? '----' }}</td> {{-- porcentaje_alcohol --}}

                    {{-- Inventario inicial --}}
                    <td>{{ $bitacora->cant_cajas_inicial ?? '----' }}</td>
                    <td>{{ $bitacora->cant_bot_inicial ?? '----' }}</td>

                    {{-- Entradas --}}
                    <td>{{ $bitacora->procedencia_entrada ?? '----' }}</td>
                    <td>{{ $bitacora->cant_cajas_entrada ?? '----' }}</td>
                    <td>{{ $bitacora->cant_bot_entrada ?? '----' }}</td>

                    {{-- Salidas --}}
                    <td>{{ $bitacora->destino_salidas ?? '----' }}</td>
                    <td>{{ $bitacora->cant_cajas_salidas ?? '----' }}</td>
                    <td>{{ $bitacora->cant_bot_salidas ?? '----' }}</td>

                    {{-- Inventario final --}}
                    <td>{{ $bitacora->cant_cajas_final ?? '----' }}</td>
                    <td>{{ $bitacora->cant_bot_final ?? '----' }}</td>

                    <td>{{ $bitacora->mermas ?? '----' }}</td>
                    <td>{{ $bitacora->observaciones ?? '----' }}</td>
                    <td style="padding: 0; text-align: center;">
                    @if ($bitacora->id_firmante != 0 && $bitacora->firmante)
                        @php
                            $firma = $bitacora->firmante->firma;
                            $rutaFirma = public_path('storage/firmas/' . $firma);
                        @endphp

                        @if (!empty($firma) && file_exists($rutaFirma))
                            <img src="{{ $rutaFirma }}" alt="Firma" style="max-width: 70%; height: auto;">
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
            @endforeach



        </tbody>
    </table>

{{--     <div class="pie">
        <p>Página 1 de 1<br>
            F7.1-01-59 Bitácora Inventario de Producto Terminado <br>
            Ed. 0 Entrada en vigor: 21-07-2025
        </p>
    </div> --}}
    <script type="text/php">
      if(isset($pdf)){
        $pdf->page_script('
        $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
        $pdf->text(1580, 1090, "Página $PAGE_NUM de $PAGE_COUNT", $font, 11);
        $pdf->text(1395, 1105, "F7.1-01-59 Bitácora Inventario de Producto Terminado", $font, 11);
        $pdf->text(1485, 1120, "Ed. 0 Entrada en vigor: 21-07-2025", $font, 11);
        ');
      }
    </script>
</body>

</html>
