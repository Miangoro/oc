<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento NOM de Mezcal Envasado</title>
    <style>
    @page {
        size: 227mm 292mm; /*Tamaño carta*/
        margin: 30px 60px 30px 60px;  /*márgenes (arriba, derecha, abajo, izquierda) */
    }
    /*@font-face {
        font-family: 'fuenteNegrita';
        src: url('{{ storage_path('fonts/LSANSD.ttf') }}');
    }*/

    body {/*ajustes generales*/
        font-family: 'calibri';
        font-size: 14px;
        line-height: 0.9;/*interlineado*/
    }

    
    .encabezado {
        position: fixed;
        /* top: -14px;
        padding-left: 2%; */
    }
    .encabezado img {
        width: 110px; 
        height: 100px;
        padding-right: 160px;
        vertical-align: top;/*alinear verticalmente el contenido en la parte superior de inline-block*/
    }
    .encabezado p {
        display: inline-block;/*coloca elementos en línea horizontalmente*/
        margin-top: 6%;
        text-align: right;
        font-family: 'fuenteNegrita';
        font-size: 28px;
        line-height: 1;
    }


    .footer {
        position: fixed;/*lo fija en pantalla*/
        bottom: -30px; 
        left: -60px;
        right: -60px;
        padding-bottom: 5px;
        background-color: #158F60;
        color: white;/*color letra*/
        text-align: center;
        font-size: 11px;
    }
    .footer p {
        margin: 1;
        line-height: 1;
    }

    .leyenda {
        position: fixed;
        bottom: 6px;
        right: 0;
        text-align: right;
        font-family: 'Lucida Sans Unicode';
        font-size: 9px;
        line-height: 0.9;
    }


    .contenido {
        margin-top: 15%;
        /*margin-left: 30px;
        margin-right: 20px;*/
    }

    




    /*inicia firma digital DIV*/
    .images-container {
        position: relative;
        width: 100%;
        /*vertical-align: bottom;*/
    }



    .watermark {
        color: red;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg) scaleY(1.2);
        opacity: 0.5;
        /* Opacidad predeterminada */
        letter-spacing: 3px;
        font-size: 150px;
        white-space: nowrap;
        z-index: -1;
    }
    </style>
</head>

<body>

@if ($watermarkText)
    <div class="watermark">
        Cancelado
    </div>
@endif


<div class="encabezado">
    <img src="{{ public_path('img_pdf/logo_uvem.png') }}" alt="Logo">
    <p>Universidad Michoacana de San <br>Nicolás de Hidalgo</p>
</div>

<div class="footer">
    <p style="font-family: Lucida Sans Seminegrita;">www.cidam.org . unidadverificacion@cidam.org</p>
    <p style="font-family: Lucida Sans Unicode; font-size: 10px;">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
</div> 



<div class="contenido">

    <p style="text-align: center; padding-left: 40px; padding-right: 40px;">La Unidad de Inspección de mezcal de la Universidad Michoacana de San Nicolás de Hidalgo, con
        domicilio en Francisco J. Múgica s/n, Col. Felícitas del Río, Morelia, Michoacán; acreditada como Unidad
        de Inspeccióntipo A con acreditación No. UVNOM-129, por la entidad mexicana de acreditación, a.c.
    </p>

    <p style="text-align: center; font-size:26px; font-family:Lucida Sans Seminegrita; padding-top:6px;"><b>DICTAMEN DE CUMPLIMIENTO NOM DE<br>MEZCAL ENVASADO</b></p>
    




    <p class="leyenda">
        @if ($id_sustituye)
        Este dictamen sustituye al: {{ $id_sustituye }}
        @endif
        <br>F-UV-04-17 Versión 4
        <br>Entrada en vigor: 08-11-2021
    </p>
</div>





<!--FIRMA DIGITAL-->
{{-- <div>
    <div class="images-container">
        <img src="{{ $qrCodeBase64 }}" alt="QR" width="75px">
        <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Sello UI" class="image-right">
    </div>
    <p class="sello">Sello de Unidad de Inspección</p>
    

        @php
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
    </p>
</div> --}}

    



</body>
</html>
