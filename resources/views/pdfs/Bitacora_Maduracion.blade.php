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
</style>

<body>
    <div class="img">
        <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" class="logo-small">
    </div>

    <div> @php
        $primerBitacora = $bitacoras->first();
        $razon = $primerBitacora->empresaBitacora->razon_social ?? 'Sin razón social';
        $numeroCliente = 'Sin número cliente';
        if ($primerBitacora->empresaBitacora && $primerBitacora->empresaBitacora->empresaNumClientes->isNotEmpty()) {
            foreach ($primerBitacora->empresaBitacora->empresaNumClientes as $cliente) {
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
    </div>

    <table>
        <tbody>
            <tr class="text-title">
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
                    {{-- Datos generales --}}
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
                    <td>
                        @if ($bitacora->id_firmante != 0 && $bitacora->firmante)
                            @php
                                $firma = $bitacora->firmante->firma;
                                $rutaFirma = public_path('storage/firmas/' . $firma);
                            @endphp

                            @if (!empty($firma) && file_exists($rutaFirma))
                                <img src="{{ $rutaFirma }}" alt="Firma" height="100"><br>
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
    <div class="pie">
        <p>Página 1 de 1 <br>
            F7.1-01-58 Bitácora Inventario de Producto en Maduración <br>
            Ed. 0 Entrada en vigor: 21-07-2025
        </p>
    </div>
</body>

</html>
