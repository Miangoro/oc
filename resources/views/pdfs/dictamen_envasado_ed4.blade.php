<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento NOM de Mezcal Envasado</title>
    <style>
    @page {
        size: 227mm 292mm;/*Tamaño carta*/
    }
    /*@font-face {
        font-family: 'fuenteNegrita';
        src: url('{{ storage_path('fonts/LSANSD.ttf') }}');
    }*/

    body {
        margin-top: 15%;
        font-family: 'calibri';
        margin-left: 15px;
        margin-right: 20px;
        font-size: 13px;
    }


    /*inicia firma digital DIV*/
    .images-container {
        position: relative;
        width: 100%;
        /*vertical-align: bottom;*/
    }


    .pie {
        position: fixed;
        right: 12px;
        bottom: 4px;
        text-align: right;
        line-height: 0.9;
        font-family: 'Lucida Sans Unicode';
        font-size: 9px;
    }

 

    
        
    /*inicia header DIV*/
    .header {
        position: fixed;
        width: 100%;
        top: -12px;
    }
    .header-text {
        color: #151442;
        display: inline-block;
        text-align: center;
        margin-left: 16%;
    }
    .header-text p {
        margin: 5px;
    }

    .large-text {
        font-size: 16px;
        font-family: 'Arial Negrita', Gadget, sans-serif;
        line-height: 0.8;
    }
    .small-text {
        font-size: 11px;
        font-family: 'Arial Negrita', Gadget, sans-serif;
        line-height: 0.8;
    }
    .normal-text {
        font-family: sans-serif;
        font-size: 11px;
    }


    .footer {
        position: fixed;
        
        background-color: #158F60;
        color: white;/*color letra*/
        /*left: -70px;
        right: -70px;
        width: calc(100% - 40px);
        height: 35px;
        
        
        font-size: 10px;
        text-align: center;
        padding: 10px 0px;*/
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

<div class="header">
    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="width: 255px; height: 95px; padding-left:6px" alt="Logo CIDAM">
    <div class="header-text">
        <p class="large-text">Unidad de Inspección<br>No. UVNOM-129</p>
        <p class="small-text">Centro de Innovación y Desarrollo Agroalimentario de<br>Michoacán, A.C.</p>
        <p class="normal-text">Acreditados ante la Entidad Mexicana de Acreditación, A.C.</p>
    </div>
</div>

<div class="footer">
    {{-- <p class="pie">
        @if ($id_sustituye)
        Este dictamen sustituye al: {{ $id_sustituye }}
        @endif
        <br>F-UV-04-17 Dictamen de Cumplimiento NOM de Mezcal Envasado Ed. 7
        <br>Entrada en vigor: 10-12-2024
    </p> --}}
    <p style="font-family: Lucida Sans Seminegrita;">www.cidam.org . unidadverificacion@cidam.org</p>
    <p style="font-family: Lucida Sans Unicode; font-size: 10px;">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
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
