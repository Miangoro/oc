<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Propuesta Bitácora De Hologramas</title>
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
        font-size: 18px;
    }

    tr.text-title td,
    tr.text-title th {
        padding: 2px;
        text-align: center;
        font-size: 13px;
        word-break: break-word;
        height: auto;
        width: auto;
        vertical-align: middle;
        background: #D0CECE;
        font-family: 'calibri-bold';
    }

    .pie {
        text-align: right;
        font-size: 13px;
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
        /* color: #A6A6A6; */
    }
</style>

<body>

    <table width="100%" style="border: none;">
        <tr>
            {{-- Logo Unidad de Inspección --}}
            <td style="width: 25%; text-align: left; vertical-align: top; padding-left: 0; border:none; ">
                <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Unidad de Inspección"
                    style="height: 80px; padding-top: 10px;">
            </td>
            {{-- Título y Cliente --}}
            <td style="width: 50%; text-align: center; border:none;">
                <p style="font-size: 25px; margin: 0; font-family: 'calibri-bold';">
                    CONTROL DE HOLOGRAMAS {{ $title ? "($title)" : '' }}
                </p>
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
                <p style="font-size: 20px; margin-top: 5px; font-family: 'calibri-bold';">
                    <span style="color: red;">&nbsp; {{ $numeroCliente }} - {{ $razon }} </span>
                </p>
            </td>
            {{-- Logo OC --}}
            <td style="width: 25%; text-align: right; vertical-align: top; padding-right: 0; border:none;">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo OC"
                    style="height: 100px; width:auto;">
            </td>
        </tr>
    </table>
    <table>
        <tbody>
            <tr class="text-title">
                <td rowspan="2">#</td>
                <td rowspan="2">FECHA</td>
                <td rowspan="2">MARCA</td>
                <td rowspan="2">LOTE DE ENVASADO</td>
                <td rowspan="2">CATEGORÍA</td>
                <td rowspan="2">CLASE</td>
                <td rowspan="2">CAPACIDAD</td>
                <td rowspan="2">%ALC. VOL.</td>
                <td colspan="2">INVENTARIO INICIAL</td>
                <td colspan="2">ENTRADAS</td>
                <td colspan="2">SALIDAS</td>
                <td colspan="2">FINAL</td>
                <td colspan="2">MERMAS</td>
                <td rowspan="2">OBSERVACIONES</td>
                <td rowspan="2">FIRMA DE LA UI</td>
            </tr>
            <tr class="text-title">
                <td>SERIE</td>
                <td>NÚM. SELLOS</td>
                <td>SERIE</td>
                <td>NÚM. SELLOS</td>
                <td>SERIE</td>
                <td>NÚM. SELLOS</td>
                <td>SERIE</td>
                <td>NÚM. SELLOS</td>
                <td>SERIE</td>
                <td>NÚM. SELLOS</td>
            </tr>
            @forelse($bitacoras as $bitacora)
                <tr class="bitacora-row">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $bitacora->fecha ?? '----' }}</td>
                    {{-- Marca (puedes cambiar esto por nombre de marca si hay relación) --}}
                    <td>{{ $bitacora->loteBitacora->marca->marca ?? '----' }}</td>
                    {{-- Lote de envasado --}}
                    <td>{{ $bitacora->loteBitacora->nombre ?? '----' }}</td>
                    @php
                        $primerGranel = $bitacora->loteBitacora->lotes_envasado_granel->first();
                    @endphp
                    {{-- Categoría --}}
                    <td>{{ $primerGranel?->loteGranel?->categoria?->categoria ?? '----' }}</td>
                    {{-- Clase --}}
                    <td>{{ $primerGranel?->loteGranel?->clase?->clase ?? '----' }}</td>
                    {{-- Capacidad --}}
                    <td> {{ $bitacora->loteBitacora->presentacion && $bitacora->loteBitacora->unidad
                        ? "{$bitacora->loteBitacora->presentacion} {$bitacora->loteBitacora->unidad}"
                        : '----' }}
                    </td>

                    {{-- % Alc. Vol. --}}
                    <td> {{ $bitacora->loteBitacora->cont_alc_envasado ? "{$bitacora->loteBitacora->cont_alc_envasado}% Alc. Vol." : '----' }}
                    </td>
                    {{-- Inventario Inicial --}}
                    <td>{{ $bitacora->serie_inicial ?? '----' }}</td>
                    <td>{{ $bitacora->num_sellos_inicial ?? '----' }}</td>
                    {{-- Entradas --}}
                    <td>{{ $bitacora->serie_entrada ?? '----' }}</td>
                    <td>{{ $bitacora->num_sellos_entrada ?? '----' }}</td>
                    {{-- Salidas --}}
                    <td>{{ $bitacora->serie_salidas ?? '----' }}</td>
                    <td>{{ $bitacora->num_sellos_salidas ?? '----' }}</td>
                    {{-- Final --}}
                    <td>{{ $bitacora->serie_final ?? '----' }}</td>
                    <td>{{ $bitacora->num_sellos_final ?? '----' }}</td>
                    {{-- Mermas --}}
                    <td>{{ $bitacora->serie_merma ?? '----' }}</td>
                    <td>{{ $bitacora->num_sellos_merma ?? '----' }}</td>

                    {{-- Observaciones --}}
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
            @empty
                <tr>
                    <td colspan="15" class="text-center">No hay datos para mostrar</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pie">
        <p>Página 1 de 1 <br>
            F7.2-01-07 Bitácora para Control de Hologramas <br>
            Ed. 0 Entrada en vigor: 21-07-2025<br>

        </p>
    </div>

</body>

</html>
