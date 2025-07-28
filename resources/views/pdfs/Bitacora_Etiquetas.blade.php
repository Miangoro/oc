<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INVENTARIO DE PRODUCTO ENVASADO (SIN ETIQUETA)</title>
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
        bottom: -40px;
        left: 0;
        right: 0;
        width: calc(100% - 40px);
        height: 45px;
        margin-right: 30px;
        padding: 10px 0;
        font-family: 'Lucida Sans Unicode';
        z-index: 1;
        color: #A6A6A6;
    }
</style>

<body>
    <div class="img">
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
        <p class="text">INVENTARIO DE PRODUCTO ENVASADO (SIN ETIQUETA) <br>
            <span style="color: red;">&nbsp; {{ $numeroCliente }} - {{ $razon }} </span>
        </p>

        {{-- <span style="font-size: 20px; font-family: 'calibri-bold';"> --}}

        {{-- </span> --}}
    </div>


    <table>
        <tbody>
            <tr class="text-title">
              <td rowspan="2">#
              </td>
                <td rowspan="2">FECHA</td>
                <td rowspan="2">BOT/ CAJA</td>
                <td rowspan="2">MARCA</td>
                <td rowspan="2">LOTE A GRANEL</td>
                <td rowspan="2">LOTE DE ENVASADO</td>
                <td rowspan="2">NÚM. ANÁLISIS FISICOQUÍMICO</td>

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
                <td rowspan="2">OBSERVACIONES</td>
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
            @foreach ($bitacoras as $bitacora)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                    <td>{{ $bitacora->fecha ?? '----' }}</td>
                    <td>{{ $bitacora->cantidad_botellas_cajas ?? '' }}</td> {{-- botellas_por_caja --}}
                    <td>{{ $bitacora->marca->marca ?? '----' }}</td>

                    <td>{{ $bitacora->loteGranelBitacora->nombre_lote ?? '----' }}</td>
                    <td>{{ $bitacora->loteBitacora->nombre ?? '----' }}</td>
                    <td>{{ $bitacora->folio_fq ?? '----' }}</td> {{-- num_analisis_fq --}}

                    <td>{{ $bitacora->categorias->categoria ?? '----' }}</td> {{-- puedes mapear esto desde id_categoria si quieres mostrar nombre --}}
                    <td>{{ $bitacora->clases->clase ?? '----' }}</td> {{-- igual con id_clase --}}
                    <td>{{ $bitacora->ingredientes ?? '----' }}</td> {{-- ingrediente --}}
                    <td>{{ $bitacora->edad ?? '----' }}</td>
                    <td>
                        @foreach ($bitacora->tipos_agave as $tipo)
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
                    <td>{{ $bitacora->alcohol_inicial ?? '----' }}</td> {{-- porcentaje_alcohol --}}

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
        <p>Página 1 de 1</p>
    </div>
</body>

</html>
