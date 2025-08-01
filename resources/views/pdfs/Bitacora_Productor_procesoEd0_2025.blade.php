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
        /* text-align: right;
        margin-top: -30px; */
        font-family: 'calibri-bold';
        font-size: 18px;
    }

    /*
    .numero {
        text-align: right;
        margin-top: -30px;
        font-family: 'calibri-bold';
        font-size: 18px;
        position: absolute;
        right: 0;
        top: 80px;
        right: 70px;
    } */

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
.segunda {
    width:50%;
    float: left;
    border-collapse: collapse;
}

.tercera {
    width: 50%;
    float: right;
    border-collapse: collapse;
}
.contenedor-tablas::after {
    content: "";
    display: table;
    clear: both;
}


/* .contenedor-tablas {
    overflow: hidden;
}
 */

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

    .observaciones-table {
        width: 100%;
        border-collapse: collapse;
        margin-left: 0;
    }

    .observaciones-table td {
        padding: 0;
        text-align: left;
        font-size: 12px;
        word-break: break-word;
        height: 15px;
        vertical-align: top;
        background: white;
        font-family: 'calibri';
        border: none;
    }

    .line td {
        border-bottom: 1px solid black;
        height: 17px;
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
            <p class="num">NÚM. TAPADA: ________________</p>
        </div>
        {{-- Limpiar floats --}}
        <div style="clear: both;"></div>

    </div>



    <div>
        <p class="subtitle">INGRESO E IDENTIFICACIÓN DEL AGAVE</p>
    </div>

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
            </tr>
        </tbody>
    </table>

   {{--  <div> --}}
        {{-- <p class="datos"></p> --}}
        <p class="inspector">NOMBRE Y FIRMA DEL INSPECTOR
            ____________________________________________________________________</p>
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
            </tr>
            <tr>
                <td class="no-border">3</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>


    {{-- <div> --}}
        {{-- <p class="datos"></p> --}}
        <p class="inspector">NOMBRE Y FIRMA DEL INSPECTOR
            ____________________________________________________________________</p>
  {{--   </div> --}}
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
            <tr>
                <td class="no-border">1</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">4</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">5</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">6</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">7</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">8</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">9</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">10</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">11</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">12</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">13</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">14</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">15</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="no-border">16</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                <td class="no-border"></td>
                <td class="no-border"></td>
                <td>VOLUMEN TOTAL</td>
                <td></td>
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

  {{--   <div> --}}
        {{-- <p class="datos"></p> --}}
        <p class="inspector">NOMBRE Y FIRMA DEL INSPECTOR
            ____________________________________________________________________</p>
  {{--   </div> --}}



    <div class="contenedor-tablas">
        <table class="segunda">
            <tbody>
              <tr>
              <td class="text-title-destilacion"  {{-- style="vertical-align: bottom; font-weight: bold; font-family: 'calibri-bold'; " --}} colspan="8">SEGUNDA DESTILACIÓN</td>
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
                    <td class="no-border">4</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border">5</td>
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
        <table class="tercera">
            <tbody>
              <tr><td class="text-title-destilacion" {{--  style="vertical-align: bottom; font-weight: bold; font-family: 'calibri-bold'; " --}}  colspan="8">TERCERA DESTILACIÓN</td></tr>

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
                    <td class="no-border">4</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border">5</td>
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
    </div>


  {{--   <div> --}}
        {{-- <p class="datos"></p> --}}
        <p class="inspector">NOMBRE Y FIRMA DEL INSPECTOR
            ____________________________________________________________________</p>
 {{--    </div> --}}

  {{--   <br> --}}

    <table class="observaciones-table2">
        <tr>
            <td>OBSERVACIONES</td>
        </tr>
    </table>

    <table class="observaciones-table">
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
    </table>

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
