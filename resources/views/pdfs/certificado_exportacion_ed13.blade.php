<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado de Exportacion</title>
    <style>
        @page {
            size: 227mm 292mm;
            margin-top: 30;
            margin-left: 80px;
            margin-right: 25px;
            margin-bottom: 1px;
        }

        body {
            font-family: Helvetica;
            font-size: 11.6px;
            padding-top: 23%;
            padding-right: 4px;
            padding-left: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /*table-layout: fixed; /* Esto asegura que las columnas tengan un ancho fijo */
        }

        td {
            border: 1px solid #366091;
            text-align: center;
        }

        th {
            background-color: #608390;
            color: white;
            text-align: center;
        }

        .td-margins {
            border-right: none;
            border-left: none;
        }

        .titulos {
            font-size: 15px;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }

        .titulo2 {
            text-align: center;
            padding: 10px;
        }

        .img-fondo {
            position: fixed;
            top: 250px;
            left: 100px;
            width: 530px;
            height: 444px;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/logo_fondo.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.1;
        }

        .img-exportacion {
            position: fixed;
            top: 130px;
            left: -70px;
            width: 87px;
            height: 740px;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/exportacion.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .encabezado {
            position: fixed;
            width: 100%;
            top: -2%;
            left: 0;
        }

        .cidam {
            color: #161c4a;
            text-align: center;
            display: inline-block;
            margin-top: 7.5%;
            margin-left: -9px;
        }

        .footer {
            position: fixed;
            bottom: 11;
            right: 5;
            width: 100%;
            z-index: 9999;
            /* Para que el pie de página se mantenga encima de otros elementos */
            font-family: Arial, sans-serif;
            /*padding-bottom: 2px; /*espacio al fondo si es necesario */
        }

        .pagenum:before {
            content: "Página " counter(page) " de 1" ;
        }

        .img-footer {
            /*background-image: url("{{ public_path('img_pdf/pie_certificado.png') }}");*/
            background-size: cover;
            /* ajusta img al contenedor */
            background-position: center;
            width: 705px;
            height: 50px;
        }

        .watermark-cancelado {
            font-family: Arial;
            color: red;
            position: fixed;
            top: 48%;
            left: 45%;
            transform: translate(-50%, -50%) rotate(-45deg) scaleY(1.2);
            opacity: 0.5;
            /* Opacidad predeterminada */
            letter-spacing: 3px;
            font-size: 150px;
            white-space: nowrap;
            z-index: -1;
        }

         /*inicia firma digital DIV*/
    .images-container {
        position: relative;
        width: 100%;
        /*vertical-align: bottom;*/
    }
    .image-right {
        position: absolute;
        width: 200px;
        right: 10px;
        margin-top: -30px;
        margin-right: 100px;
    }

     .image-right2 {
        position: absolute;
        right: 10px;
        margin-top: 25px;

    }
    .sello {
        position: absolute;
        right: 5%;
        margin-top: -13px;
        font-size: 11px;
        font-family: 'Arial Negrita' !important;
    }
    .textx {
        line-height: 0.5;
        font-size: 9px;
        font-family: Arial, Helvetica, Verdana;
    }
    .textsello {
        width: 60%; 
        text-align: left;
        word-wrap: break-word;
        margin-top: -5px;
        line-height: 1.2;
        font-size: 8px;
        font-family: Arial, Helvetica, Verdana;
    }
    </style>
</head>

<body>
<!-- Aparece la marca de agua solo si la variable 'watermarkText' tiene valor -->
@if ($watermarkText)
    <div class="watermark-cancelado">
        Cancelado
    </div>
@endif

<div class="img-fondo"></div>
<div class="img-exportacion"></div>

<!--ENCABEZADO-->
<div class="encabezado">
    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" style="width: 340px; vertical-align: top; margin-left: -13px" alt="logo de CIDAM 3D">

    <div class="cidam">
        <b style="font-size: 17.5px;">CENTRO DE INNOVACIÓN Y DESARROLLO<br>AGROALIMENTARIO DE MICHOACÁN A.C.</b>
        <p style="font-size: 11px; margin-top: 0px;">Organismo de Certificación de producto acreditado ante la
            <br>entidad mexicana de acreditación ema A.C. con <b>No. 144/18</b>
        </p>
    </div>

    <div class="titulos" style="margin-top: -2%;">CERTIFICADO DE AUTENTICIDAD DE EXPORTACIÓN DE MEZCAL</div>
    <table>
      <tr>
        <td style="font-weight: bold; text-align: center; border:none">
            Número de Certificado:</td>
        <td style="font-weight:bold; font-size: 11px; text-align: left;border:none">
            {{ $data->num_certificado }}
        </td>
        <td style="font-weight: bold; text-align: right;padding-right: 20px; border:none">
            Fecha de<br>expedición:</td>
        <td style="font-weight: bold; text-align: right; border:none">
            {{ $expedicion }}
        </td>
        <td style="font-weight: bold;  text-align: right; padding-right: 20px; border:none">
            Vigencia de 90 días<br>naturales:</td>
        <td style="font-weight: bold; text-align: right;padding-right: 20px; border:none">
            {{ $vigencia }}
        </td>
      </tr>
    </table>
</div>

<!--PIE DE PAGINAS-->
<div class="footer">
    <p style="text-align: right; font-size: 8px; margin-bottom: 1px; line-height: 1.3;">
        @if ($id_sustituye)
            <!-- Aparece solo si tiene valor -->
            Cancela y sustituye al certificado con clave: {{ $id_sustituye }}
        @endif
        <br>Certificado de Exportación NOM-070-SCFI-2016 F7.1-01-23 Ed 13
        <br>Entrada en vigor: 01-07-2025<br>  
        <span class="pagenum"></span>
    </p>
    
    <img class="img-footer" src="{{ public_path('img_pdf/pie_certificado.png') }}" alt="pie de pagina">
</div>



    <div class="titulos">DATOS GENERALES DEL EXPORTADOR</div>
    <table>
    <tr>
        <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
            Nombre o razón social:</td>
        <td class="td-margins" style="text-align: left">
            {{ mb_strtoupper($empresa) }}
        </td>
        <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
            Número de Cliente:</td>
        <td class="td-margins" style="text-align: left">
            {{ $n_cliente }}
        </td>
    </tr>
    <tr>
        <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px; padding-top: 8px;padding-bottom: 8px;">
            Domicilio:</td>
        <td class="td-margins" style="font-size: 11px; text-align: left; padding-top: 8px;padding-bottom: 8px;" colspan="3">
            {{ mb_strtoupper($domicilio) }}
        </td>
    </tr>
    <tr>
        <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px; padding-top: 10px;padding-bottom: 10px;">
            Código Postal:</td>
        <td class="td-margins" style="text-align: left">
            {{ $cp }}&nbsp;
        </td>
        <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
            Estado:</td>
        <td class="td-margins" style="text-align: left; padding-right: 4px;">
            {{ mb_strtoupper($estado) }}
        </td>
    </tr>
    <tr>
        <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
            Registro Federal de Contribuyentes:</td>
        <td class="td-margins" style="text-align: left">
            {{ $rfc }}
        </td>
        <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
            País:</td>
        <td class="td-margins" style="text-align: left">
            MÉXICO
        </td>
    </tr>
    <tr>
        <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
            Registro de Productor<br>Autorizado (DOM):</td>
        <td class="td-margins" style="text-align: left">
            {{ $DOM }}
        </td>
        <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
            Número de Convenio de corresponsabilidad:</td>
        <td class="td-margins" style="text-align: left">
            {{ $convenio }}
        </td>
    </tr>
    </table>


<!--PARA HOLOGRAMAS-->
@php
    $idHologramas = json_decode($data->id_hologramas, true);
    $oldHologramas = json_decode($data->old_hologramas, true);
    $contador = 0;

    ///SOLICITUD Y ACTIVACION HOLOGRAMAS
    use App\Models\activarHologramasModelo;
    use App\Models\solicitudHolograma;
    $id_activacion = $idHologramas['folio1']['id'] ?? null;//id de la tabla activar_hologamas
    $activacion = activarHologramasModelo::find($id_activacion);

    $solic = null;
    if ($activacion) {
        $solic = solicitudHolograma::find($activacion->id_solicitud);
    }

    $empresa_hol = $solic->empresa ?? null;
    $num_clien_hol = $empresa_hol && $empresa_hol->empresaNumClientes->isNotEmpty()
        ? $empresa_hol->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa_hol
        ->id && !empty($item->numero_cliente)) ?->numero_cliente ?? 'No encontrado' : 'N/A';
    $no_cliente = explode('070-', $num_clien_hol)[1] ?? null;


    $foliosPorLote = [];

    foreach ($lotes as $lote) {
        $clave = 'folio' . ($contador + 1);
        $contenido = '';

        /* if (!empty($idHologramas[$clave])) {
            $grupo = $idHologramas[$clave];
            $rangoTexto = [];

            foreach ($grupo['rangos'] ?? [] as $rango) {
                $rangoTexto[] = ($rango['inicial'] ?? '?') . ' - ' . ($rango['final'] ?? '?');
            }

            $contenido .= implode('<br>', $rangoTexto);
        } */
       // Solo modificar esta parte para id_hologramas
        if (!empty($idHologramas[$clave])) {
            $grupo = $idHologramas[$clave];
            $rangoTexto = [];

            foreach ($grupo['rangos'] ?? [] as $rango) {
                $folioInicial = str_pad($rango['inicial'] ?? '', 7, '0', STR_PAD_LEFT);
                $folioFinal = str_pad($rango['final'] ?? '', 7, '0', STR_PAD_LEFT);

                $enlaceInicial = '<a style="color: black; text-decoration: none; target="_blank" href="/holograma/' . $num_clien_hol . '-' . $solic->tipo.$solic->marcas->folio . $folioInicial . '">' .
                    $no_cliente . '-' . $solic->tipo.$solic->marcas->folio . $folioInicial . '</a>';
                $enlaceFinal = '<a style="color: black; text-decoration: none; target="_blank" href="/holograma/' . $num_clien_hol . '-' . $solic->tipo.$solic->marcas->folio . $folioFinal . '">' .
                    $no_cliente . '-' . $solic->tipo.$solic->marcas->folio . $folioFinal  . '</a>';

                $rangoTexto[] = $enlaceInicial . ' - ' . $enlaceFinal;
            }

            $contenido .= implode('<br>', $rangoTexto);
        }

        // old_hologramas
        if (!empty($oldHologramas[$clave])) {
            $lineaConSaltos = str_replace(',', '<br>', $oldHologramas[$clave]);
            $contenido .= ($contenido ? '<br>' : '') . $lineaConSaltos;
        }

        if (empty($contenido)) {
            $contenido = '------';
        }

        $foliosPorLote[] = $contenido;
        $contador++;
    }
@endphp
<!--INICIO DE TABLAS LOTES-->
    @foreach ($lotes as $lote)
        <div class="titulos">DESCRIPCIÓN DEL EMBARQUE QUE AMPARA EL CERTIFICADO</div>
        <table>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; height: 30px; width: 12%;">
                Marca:</td>
            <td style="text-align: left; padding-left: 4px; width: 22%;">
                {{ mb_strtoupper($lote->marca->marca) ?? 'N' }}
            </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; width: 12%;">
                Categoría y Clase:</td>
            <td style="text-align: left; padding-left: 4px; width: 20%;">
                {{ mb_strtoupper($lote->lotesGranel->first()->categoria->categoria) ?? 'No encontrado' }},
                {{ mb_strtoupper($lote->lotesGranel->first()->clase->clase) ?? 'No encontrado' }}
            </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; width: 12%;">
                Edad:</td>
            <td style="text-align: left; padding-left: 4px;">
                {{ in_array(optional($lote->lotesGranel->first())->id_clase, [2, 3]) 
                    ? (filled(optional($lote->lotesGranel->first())->edad) 
                        ? mb_strtoupper(optional($lote->lotesGranel->first())->edad) 
                        : 'No encontrado') 
                    : 'NA' }}
            </td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; height: 30px;">
                Certificado<br>NOM a<br>Granel:</td>
            <td style="text-align: left; padding-left: 4px;">
                {{ $lote->lotesGranel->first()?->certificadoGranel?->num_certificado 
                    ?? $lote->lotesGranel->first()->folio_certificado
                    ?? 'No encontrado'; }}&nbsp;
            </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">
                Contenido Neto:</td>
            <td style="text-align: left; padding-left: 4px;">
                {{ $lote->presentacion ?? 'No encontrado' }} {{ $lote->unidad ?? 'No encontrado' }}
            </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">
                %Alc. Vol.:</td>
            <td style="text-align: left; padding-left: 4px;">
                {{ $lote->cont_alc_envasado ?? 'No encontrado' }}%
            </td>
        </tr>
        @php
            $folios = explode(',', $lote->lotesGranel->first()->folio_fq ?? 'No encontrado');
            $folio1 = trim($folios[0] ?? '');
            $folio2 = isset($folios[1]) && trim($folios[1]) !== '' ? trim($folios[1]) : 'NA';
        @endphp
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">
                No. de análisis:</td>
            <td style="text-align: left; padding-left: 4px;">
                {{ $folio1 }}
            </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">
                No. lote granel:</td>
            <td style="text-align: left; padding-left: 4px;">
                {{ $lote->lotesGranel->first()->nombre_lote ?? 'No encontrado' }}
            </td>
            <td style="text-align: right; font-weight: bold; font-size: 10.6px; padding-right: 8px;">
                Tipo de Maguey:</td>
            <td style="text-align: left; padding-left: 2px; font-size: 10.6px;">
                {!! $lote->lotesGranel->first()->tiposRelacionados->map(function ($tipo) {
                    return $tipo->nombre . ' (<i>' . $tipo->cientifico . '</i>)';
                })->implode('<br>') !!}
            </td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; height: 30px">No.
                de análisis ajuste:</td>
            <td style="text-align: left; padding-left: 4px;">
                {{ $folio2 }} &nbsp;
            </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">
                No. de lote envasado:</td>
            <td style="text-align: left; padding-left: 4px;">
                {{ $lote->nombre ?? 'No encontrado' }}
            </td> 
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">
                Folio Hologramas:</td>
            <td style="text-align: left; font-size: 9px; padding-left: 4px;">
                {!! $foliosPorLote[$loop->index] ?? '------' !!}
            </td>
        </tr>
        </table>


        <!--Salto de pag después de tabla 2-->
        @if ($loop->iteration == 2)
            <div style="page-break-before: always;"></div>
        @endif

    @endforeach<!-- FIN DE TABLAS LOTES -->


<br><br>
    <table>
    <tr>
        <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; height: 45px; width: 12%;">
            Envasado en:</td>
        <td style="text-align: justify; font-size: 9px; padding-left: 4px; padding-right: 2px; width: 22%;">
            {{ mb_strtoupper($envasadoEN) }}&nbsp;
        </td>
        <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; width: 12%;">
            Cajas:</td>
        <td style="text-align: left; padding-left: 4px;">
            {{ $cajas }}
        </td>
        <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; width: 12%;">
            Botellas:</td>
        <td style="text-align: left; padding-left: 4px; width: 22%;">
            {{ $botellas }}
        </td>
    </tr>
    <tr>
        <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; height: 35px;">
            Aduana de despacho:</td>
        <td style="text-align: left; padding-left: 4px; font-size: 10.5px;">
            {{ $aduana }}
        </td>
        <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">
            Fracción Arancelaria:</td>
        <td style="text-align: left; padding-left: 4px;">2208.90.05.00</td>
        <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">
            No. de<br>pedido:</td>
        <td style="text-align: left; padding-left: 4px;">
            {{ $n_pedido }}
        </td>
    </tr>
    </table>


    <div class="titulos" style="padding:14px">DESTINATARIO</div>
    <table>
    <tr>
        <td class="td-margins" style="text-align: right; font-weight: bold; font-size: 12px; border-top: none; width: 12%;">
            Nombre:</td>
        <td class="td-margins" style="text-align: left; border-top: none; padding-left: 6px;">
            {{ $nombre_destinatario }}
        </td>
    </tr>
    <tr>
        <td class=" td-margins" style="text-align: right; font-weight: bold; font-size: 12px; padding-top: 8px; padding-bottom: 8px;">
            Domicilio:</td>
        <td class="td-margins" style="text-align: left; padding-left: 6px;">
            {{ $dom_destino }}
        </td>
    </tr>
    <tr>
        <td class="td-margins" style="text-align: right; font-weight: bold; font-size: 12px;">
            País destino:</td>
        <td class="td-margins" style="text-align: left; padding-left: 6px;">
            {{ $pais }}
        </td>
    </tr>
    </table>

    <p style="font-size: 7.5px">
        El presente certificado se emite para fines de exportación conforme a la norma oficial mexicana de
        mezcal NOM-070-SCFI-2016. Bebidas Alcohólicas-Mezcal-Especificaciones, en cumplimiento con lo
        dispuesto en la Ley Federal de Infraestructura de la Calidad.
        Este documento no debe ser reproducido en forma parcial.
    </p>
    

    <!--<div class="titulo2"><b>AUTORIZÓ</b></div>
    <div class="titulo2" style="margin-top: 0;">
        <b>{{ $data->firmante->name }}<br>{{ $data->firmante->puesto }}</b>
    </div>-->

    <!--FIRMA DIGITAL-->
<div>
    <div class="images-container">
        <img src="{{ $qrCodeBase64 }}" alt="QR" width="75px" class="image-right2">
        <img src="{{ public_path('img_pdf/Sello oc.png') }}" alt="Sello UI" class="image-right">
    </div>
  
    

        @php
            use Illuminate\Support\Facades\Storage;
            $firma = $data->firmante->firma ?? null;
            $firmaPath = $firma ? 'firmas/' . $firma : null;
        @endphp

      

    <p class="textx" style="margin-top: 5px">
        <strong>AUTORIZÓ</strong>
        <span style="margin-left: 54px; display: inline-block; text-align: left; position: relative; margin-top: 10px;">
            <strong>{{ $data->firmante->puesto ?? '' }}<br><br>{{ mb_strtoupper($data->firmante->name ?? '', 'UTF-8') }}</strong>
        </span>
    </p>
    <p class="textx">
        <strong>CADENA ORIGINAL</strong>
        <span style="margin-left: 14px;">
            <strong>{{ $firmaDigital['cadena_original'] ?? '' }}</strong>
        </span>
    </p>
    <p class="textx">
        <strong>SELLO DIGITAL</strong>
    </p>
    <p class="textsello">
        {{ $firmaDigital['firma'] ?? ''}}
    </p>
</div>




</body>
</html>
