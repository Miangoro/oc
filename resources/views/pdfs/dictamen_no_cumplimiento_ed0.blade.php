<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de No Cumplimiento</title>
    <style>
    @page {
        size: 227mm 292mm; /*Tamaño carta*/
        margin: 30px 60px 30px 60px;  /*márgenes (arriba, derecha, abajo, izquierda) */
    }
    /*@font-face {
        font-family: 'fuenteNegrita';
        font-family: 'calibri';
        font-family: 'Arial Negrita', Gadget, sans-serif;
        font-family: sans-serif;
        font-family: Arial, Helvetica, Verdana;
        font-family: lucida sans seminegrita;
        src: url('{{ storage_path('fonts/LSANSD.ttf') }}');
    }*/

    body {/*ajustes generales*/
        font-family: 'calibri';
        font-size: 15px;
        line-height: 0.9;/*interlineado*/
        text-align: justify
    }*/

    /*.fondo {
        position: fixed;
        top: 30%;
        left: 130px;
        width: 500px;
        height: 440px;
        opacity: 0.2;
    }*/

    .encabezado {
        border: 2px solid blue;
        position: fixed;
        /*width: 100%; 
        border: 2px solid blue;
        top: -14px;*/
    }
    /*.encabezado img {
        width: 110px; 
        height: 100px;
        vertical-align: top;/*alinear verticalmente el contenido en la parte superior de inline-block
    }*/
    .header-text {
        display: inline-block;/*coloca elementos en línea horizontalmente*/
        color: #151442;
        padding-left: 150px;
        line-height: 0.7;
    }
    .header-text p {
        margin: 2px;
        text-align: center;
    }


    /*pie de pagina*/
    .footer {
        /*border: 2px solid blue;*/
        position: fixed;/*lo fija en pantalla*/
        left: -60px;
        right: -60px;
        bottom: -30px;
    }
    .footer p{
        margin: 0px 60px 4px 0px; /*arriba, derecha, abajo, izquierda*/
        font-size: 10px;
        line-height: 0.8;
    } 
    .leyenda{
        text-align: right;
        font-family: 'Lucida Sans Unicode';
    }
    .footer-text {
        text-align: center;
        background-color: #158F60;
        padding: 6px;
        color: rgb(248, 248, 248);
    }




    .contenido {
        margin-top: 13%;
        /*margin-left: 30px;
        margin-right: 20px;*/
    }

    


    .sub-negrita{
        font-family: sans-serif;
        font-weight: bold;
    }

    /*tabla*/
    table {
        border-collapse: collapse;
        border: 2px solid #003300;
    }
    td {
        border: 2px solid #003300;
        padding-left: 10px;
    }
    .bold{
        font-family: sans-serif;
        font-style: italic;
        font-weight: bold;
        padding: 5px 10px; /*top-bottom, left-right*/
        font-size: 14px;
        text-align: center;
        color: #171353;
    }




    /*inicia firma digital DIV*/
    .firma {
        border: 2px solid blue;
    }

    .images-container {
        position: relative;
        width: 100%;
        /*vertical-align: bottom;*/
    }
    .image-right {
        position: absolute;
        width: 200px;
        right: 10px;
        margin-top: -5px;
    }
    .sello {
        position: absolute;
        right: 5%;
        margin-top: -13px;
        font-size: 11px;
        font-family: 'Arial Negrita' !important;
    }
    </style>
</head>

<body>

{{-- <img class="fondo" src="{{ public_path('img_pdf/fondo_dictamen.png') }}"  alt="Fondo agave"> --}}

<div class="encabezado">
    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="width: 250px; height: 98px;" alt="Logo UI">
    <div class="header-text">
        <p style="font-size: 16px; font-family: 'Arial Negrita', Gadget, sans-serif;">Unidad de Inspección No.<br>UVNOM-129</p>
        <p style="font-size: 11px; font-family: 'Arial Negrita', Gadget, sans-serif;">Centro de Innovación y Desarrollo Agroalimentario de<br>Michoacán, A.C.</p>
        <p style="font-size: 11px; font-family: sans-serif;">Acreditados ante la Entidad Mexicana de Acreditación, A.C.</p>
    </div>
</div>


<div class="footer">
    <p class="leyenda">
        {{-- @if ($id_sustituye)
        Este dictamen sustituye al: {{ $id_sustituye }}
        @endif --}}
        <br>Entrada en vigor: 10-07-2025
        <br>F-UV-04-30 Ed. 0.
    </p>
    <div class="footer-text">
        <p style="font-family: Lucida Sans Seminegrita;">www.cidam.org . unidadverificacion@cidam.org</p>
        <p style="font-family: Lucida Sans Unicode;">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
    </div>
</div> 



<div class="contenido">

    <p style="text-align: center; font-size:26px; font-family:'Arial Negrita', Gadget, sans-serif; padding-top:6px;">Dictamen de No Cumplimiento</p>
 
    <p style="margin-top: -25px">No.: <span class="sub-negrita">{{ $num_dictamen }}</span></p>


    <div style="font-family: fuenteNegrita; margin-top: -5px; text-align: center;">
        <p style="display: inline-block;">Instalaciones (  ) </p>
        <p style="display: inline-block; padding: 0 10%">Lote de mezcal a granel (  ) </p><!--orden: top right bottom left; equivale top:0; bottom:0; left:10%; right:10%; -->
        <p style="display: inline-block;">Envasado (  )</p>
    </div>

    <p style="margin-top: -10px;">De acuerdo con lo establecido en los procedimientos internos de la Unidad de Inspección
        No. UVNOM 129 para la revisión de procesos de producción del producto Mezcal, su
        envasado y comercialización; y con fundamento en los artículos 56 Fracción I y 60 fracción I
        de la Ley de Infraestructura de la Calidad que establece el funcionamiento de las Unidades
        de Inspección.
    </p>



    <div class="sub-negrita">I. Datos de la empresa</div>
    <table>
        <tr>
            <td class="bold">Nombre de la Empresa</td>
            <td colspan="3">{{ $empresa }}</td>
        </tr>
        <tr>
            <td class="bold" rowspan="2" style="width: 16%;">Dirección</td>
            <td rowspan="2" style="padding: 5px 5px; font-size:14px; width: 40%;">
                <span class="sub-negrita">Domicilio Fiscal:</span> {{ $dom_fiscal }}<br>
                <span class="sub-negrita">Domicilio de Instalaciones:</span> {{ $dom_inspeccion }}
            </td>
            <td class="bold" style="width: 25%;">RFC</td>
            <td style="width: 20%;">{{ $rfc }}</td>
        </tr>
        <tr>
            <td class="bold">Representante legal</td>
            <td>{{ $representante }}</td>
        </tr>
        <tr>
            <td class="bold">No. de servicio</td>
            <td>{{ $num_servicio }}</td>
            <td class="bold" style="text-align: left">Fecha de servicio</td>
            <td>{{ $fecha_servicio }}</td>
        </tr>
        <tr>
            <td class="bold">Nombre del inspector</td>
            <td>{{ $inspector }}</td>
            <td class="bold" style="text-align: left">Fecha de emisión</td>
            <td>{{ $fecha_emision }}</td>
        </tr>
    </table>


    <div style="margin-top: 10px;"><span class="sub-negrita">II. Descripción de la No Conformidad</span><br>
        Se emite el presente Dictamen debido al incumplimiento de requisitos establecidos en la
        NOM-070-SCFI-2016, Bebidas alcohólicas-Mezcal- Especiaciones y por la Unidad de
        Inspección del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C.
        (CIDAM), indicados a continuación:
    </div>
    <table style="width: 100%; border: 1px; margin-top:2px;">
        <tr>
            <td class="sub-negrita" style="padding: 30px 10px; width: 50%; border: 1px solid #171353;"><b>ANOMALIAS, INCONFORMIDADES U OBSERVACIONES:</b></td>
            <td style="border:1px solid #171353;">{{ $observaciones }}</td>
        </tr>
    </table>


    <p style="font-size: 13px;">
        El presente Dictamen no deberá ser alterado ni reproducido en formar parcial o total son la del Centro de
        Innovación y Desarrollo Agroalimentario de Michoacán A.C.
    </p>


</div>



<!--FIRMA DIGITAL-->
<div class="firma">
    <div class="images-container">
        <img src="{{ $qrCodeBase64 }}" alt="QR" width="75px">
        <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Sello UI" class="image-right">
    </div>
    <p class="sello">Sello de Unidad de Inspección</p>
    

        {{-- @php
            use Illuminate\Support\Facades\Storage;
            $firma = $data->firmante->firma ?? null;
            $firmaPath = $firma ? 'firmas/' . $firma : null;
        @endphp

        @if ($firma && Storage::disk('public')->exists($firmaPath))
            <img style="position: absolute; margin-top: -10%; left: 45%;" height="60px"
            src="{{ public_path('storage/' . $firmaPath) }}">
        @endif

    <p class="textx" style="margin-top: -5px">
        <strong>AUTORIZÓ</strong>
        <span style="margin-left: 54px; display: inline-block; text-align: center; position: relative;">
            <strong>{{ $data->firmante->puesto ?? '' }} | {{ $data->firmante->name ?? '' }}</strong>
        </span>
    </p>
    <p class="textx">
        <strong>CADENA ORIGINAL</strong>
        <span style="margin-left: 14px;">
            <strong>{{ $firmaDigital['cadena_original'] }}</strong>
        </span>
    </p>
    <p class="textx">
        <strong>SELLO DIGITAL</strong>
    </p>
    <p class="textsello">
        {{ $firmaDigital['firma'] }}
    </p> --}}
</div>







</body>
</html>
