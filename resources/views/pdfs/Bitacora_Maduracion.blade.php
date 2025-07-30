<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bitácora Producto en Maduración</title>
</head>
<style>
    table {
        width: 101%;
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
        font-size: 10px;
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
        bottom: 0px;
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

    <div>  @php
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
        <p class="text">INVENTARIO DE PRODUCTO EN MADURACIÓN <br>
            <span style="font-size: 20px; margin-top: 5px; font-family: 'calibri-bold'; color: red;">&nbsp;
                {{ $numeroCliente }} - {{ $razon }} </span>
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
                INVENTARIO DE PRODUCTO EN MADURACIÓN
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
                <td rowspan="2">FECHA DE INGRESO</td>
                <td rowspan="2">LOTE A GRANEL</td>
                <td rowspan="2">CATEGORÍA</td>
                <td rowspan="2">CLASE</td>
                <td rowspan="2">EDAD</td>
                <td rowspan="2">TIPO DE RECIPIENTE</td>
                <td rowspan="2">TIPO DE MADERA</td>
                <td rowspan="2">VOLUMEN DEL RECIPIENTE</td>
                <td rowspan="2">NÚM. ANALÍSIS FISICOQUIÍMICO</td>
                <td rowspan="2">NÚM. DE CERTIFICADO
                </td>
                <td colspan="3">NÚM. DE CERTIFICADO</td>
                <td colspan="4">ENTRADA</td>
                <td colspan="4">SALIDAS</td>
                <td colspan="3">INVENTARIO FINAL</td>
                <td rowspan="2">OBSERVACIONES</td>
                <td rowspan="2">FIRMA DE LA UI</td>
            </tr>
            <tr class="text-title">
                <td>NÚM. RECIPIENTES</td>
                <td>VOLUMEN</td>
                <td>%ALC.VOL.</td>
                <td>PROCEDENCIA</td>
                <td>NÚM. DE RECIPIENTES</td>
                <td>VOLUMEN</td>
                <td>%ALC.VOL.</td>
                <td>FECHA DE SALIDA</td>
                <td>NÚM. DE RECIPIENTES</td>
                <td>VOLUMEN</td>
                <td>%ALC.VOL.</td>
                <td>NÚM. DE RECIPIENTES</td>
                <td>VOLUMEN</td>
                <td>%ALC.VOL.</td>
            </tr>
            @foreach ($bitacoras as $bitacora)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bitacora->fecha ?? '' }}</td>
                    <td>{{ $bitacora->loteBitacora->nombre_lote ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora->categoria->categoria ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora->clase->clase ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora->edad ?? '----' }}</td>
                    <td>{{ $bitacora->tipo_recipientes ?? '----' }}</td>
                    <td>{{ $bitacora->tipo_madera ?? '----' }}</td>
                    <td>{{ $bitacora->volumen_inicial ?? '----' }}</td> {{-- Volumen del recipiente --}}
                    <td>{{ $bitacora->loteBitacora->folio_fq ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora->folio_certificado ?? '' }}</td>

                    {{-- NÚM. DE CERTIFICADO (Interpretación libre) --}}
                    <td>{{ $bitacora->num_recipientes ?? '----' }}</td>
                    <td>{{ $bitacora->volumen_inicial ?? '----' }}</td>
                    <td>{{ $bitacora->alcohol_inicial ?? '----' }}</td>

                    {{-- ENTRADA --}}
                    <td>{{ $bitacora->procedencia_entrada ?? '----' }}</td>
                    <td>{{ $bitacora->num_recipientes_entrada ?? '' }}</td>
                    <td>{{ $bitacora->volumen_entrada ?? '----' }}</td>
                    <td>{{ $bitacora->alcohol_entrada ?? '----' }}</td>

                    {{-- SALIDAS --}}
                    <td>{{ $bitacora->fecha_salida ?? '----' }}</td>
                    <td>{{ $bitacora->num_recipientes_salida ?? '----' }}</td>
                    <td>{{ $bitacora->volumen_salidas ?? '----' }}</td>
                    <td>{{ $bitacora->alcohol_salidas ?? '----' }}</td>

                    {{-- INVENTARIO FINAL --}}
                    <td>{{ $bitacora->num_recipientes_final ?? '' }}</td>
                    <td>{{ $bitacora->volumen_final ?? '----' }}</td>
                    <td>{{ $bitacora->alcohol_final ?? '----' }}</td>

                    <td>{{ $bitacora->observaciones ?? '----' }}</td>
                    {{-- Firma --}}
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
            @endforeach
        </tbody>
    </table>
    {{-- <div class="pie">
        <p>Página 1 de 1 <br>
            F7.1-01-58 Bitácora Inventario de Producto en Maduración <br>
            Ed. 0 Entrada en vigor: 21-07-2025
        </p>
    </div>
 --}}
      <script type="text/php">
      if(isset($pdf)){
        $pdf->page_script('
        $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
        $pdf->text(1580, 1090, "Página $PAGE_NUM de $PAGE_COUNT", $font, 11);
        $pdf->text(1372, 1105, " F7.1-01-58 Bitácora Inventario de Producto en Maduración", $font, 11);
        $pdf->text(1485, 1120, "Ed. 0 Entrada en vigor: 21-07-2025", $font, 11);
        ');
      }
    </script>
</body>

</html>
