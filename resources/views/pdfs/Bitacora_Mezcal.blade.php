<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bitácora Mezcal a Granel</title>
</head>
<style>
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

/*     img {
        display: flex;
        margin-bottom: 10px;
    }
 */
/*     .img .logo-small {
        height: 80px;

    } */

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
        /* color: #A6A6A6; */
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
</style>

<body>
<table width="100%" style="border: none;">
    <tr>
        {{-- Logo Unidad de Inspección --}}
        <td style="width: 25%; text-align: left; vertical-align: top; padding-left: 0; border:none; ">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección" style="height: 80px; padding-top: 10px;">
        </td>
        {{-- Título y Cliente --}}
        <td style="width: 50%; text-align: center; border:none;">
            <p style="font-size: 25px; margin: 0; font-family: 'calibri-bold';">
                INVENTARIO DE MEZCAL A GRANEL {{ $title ? "($title)" : '' }}
            </p>
            @php
                $primerBitacora = $bitacoras->first();
                $razon = $primerBitacora->empresaBitacora->razon_social ?? 'Sin razón social';
                $numeroCliente = 'Sin número cliente';
                if (
                    $primerBitacora->empresaBitacora &&
                    $primerBitacora->empresaBitacora->empresaNumClientes->isNotEmpty()
                ) {
                    foreach ($primerBitacora->empresaBitacora->empresaNumClientes as $cliente) {
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
        </td>
        {{-- Logo OC --}}
        <td style="width: 25%; text-align: right; vertical-align: top; padding-right: 0; border:none;">
            <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo OC" style="height: 100px; width:auto;">
        </td>
    </tr>
</table>




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
            @forelse($bitacoras as $bitacora)
                <tr class="bitacora-row">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bitacora->fecha ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora?->id_tanque ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora?->nombre_lote ?? '----' }}</td>
                    <td>{{ $bitacora->operacion_adicional ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora->categoria->categoria ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora->clase->clase ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora?->ingredientes ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora?->edad ?? '----' }}</td>
                    <td>
                        @if ($bitacora->loteBitacora && $bitacora->loteBitacora->tiposRelacionados->isNotEmpty())
                            {!! $bitacora->loteBitacora->tiposRelacionados->map(function ($tipo) {
                                    return $tipo->nombre . ' (<em>' . $tipo->cientifico . '</em>)';
                                })->implode(', ') !!}
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
                    <td>{{ $bitacora->observaciones ?? '----' }}</td>
                    <td>
                        @if ($bitacora->id_firmante != 0 && $bitacora->firmante)
                            @php
                                $firma = $bitacora->firmante->firma;
                                $rutaFirma = public_path('storage/firmas/' . $firma);
                            @endphp

                            @if (!empty($firma) && file_exists($rutaFirma))
                                <img src="{{ $rutaFirma }}" alt="Firma" height="100">
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

    <div class="pie">
        <p>Página 1 de 1 <br>
        F7.1-01-60 Bitácora Inventario de Mezcal a Granel <br>
        Ed. 0 Entrada en vigor: 21-07-2025
        </p>
    </div>

</body>

</html>
