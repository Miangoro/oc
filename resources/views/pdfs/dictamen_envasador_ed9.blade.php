<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento NOM de Envasador de Mezcal</title>
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


    .fondo {
        position: fixed;
        top: 30%;
        left: 130px;
        width: 500px;
        height: 440px;
        opacity: 0.2;
    }


     /*inicia firma digital DIV*/
    .firma {
        position: relative;
        width: 100%;
        /*vertical-align: bottom;*/
    }
    


    /*tabla*/
    table {
        border: 1px solid #003300;
        width: 100%;
        color: #000000;
    }

    td, th {
        border: 1px solid #003300;
        /* padding: 5px 8px; 
        line-height: 1.2;*/
        vertical-align: top;
    }

    th {
        font-weight: bold;
        text-align: left;
    }

    .bold {
        font-weight: bold;
    }

    .subtitulos {
        font-size: 16px;
        margin-top: 1em;
        margin-bottom: 0.3em;
        padding-left: 1em;
        font-weight: bold;
    }

    </style>
</head>

<body>

@if ($watermarkText)
    <div class="watermark">
        Cancelado
    </div>
@endif

<img class="fondo" src="{{ public_path('img_pdf/fondo_dictamen.png') }}"  alt="Fondo agave">

<div class="encabezado">
    <img src="{{ public_path('img_pdf/logo_uvem.png') }}" alt="Logo">
    <p>Universidad Michoacana de San <br>Nicolás de Hidalgo</p>
</div>

<div class="footer">
    <p style="font-family: Lucida Sans Seminegrita;">www.cidam.org . unidadverificacion@cidam.org</p>
    <p style="font-family: Lucida Sans Unicode; font-size: 10px;">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
</div> 







<div class="contenido">



</div>







</body>
</html>
