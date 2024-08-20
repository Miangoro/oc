<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
    @font-face {
        font-family: 'Lucida Sans Unicode';
        src: url('fonts/lsansuni.ttf') format('truetype');
    }

    .header img {
        display: block;
        width: 275px; 
        margin-top: -20px;
    }

    .description1-container {
        position: absolute;
        right: 0;   /* Alinea el contenido a la derecha */
        text-align: right; 
    }

    .description1 {
        font-family: 'Lucida Sans Unicode';
        font-size: 13px;
        line-height: 1;
        display: inline-block;
        width: auto; /* Permite que el contenedor se ajuste al contenido */
        white-space: nowrap; /* Evita que el texto se divida en líneas */
        border-bottom: 1px solid black;
        padding-bottom: 5px;
    }
</style>

</head>
<body>

<div class="header">
    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo UVEM" width="275px">
</div>

<div class="description1-container">
    <div class="description1">
        Pre-registro de predios de maguey o agave F-UV-21-01<br>Edición 1, 15/07/2024
    </div>
</div>

<p class="title">Pre-registro de predios de maguey o agave</p>

</body>
</html>
