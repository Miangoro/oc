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
        top: 0px; 
        right: 0;  
        text-align: right; 
    }

    .description1 {
        font-family: 'Lucida Sans Unicode';
        font-size: 13px;
        line-height: 1;
        display: inline-block;
        width: auto; 
        white-space: nowrap; 
        border-bottom: 1px solid black;
        padding-bottom: 5px;
    }

    .title {
        font-family: 'Lucida Sans Unicode';
        font-size: 20px;
        text-align: center;
        margin-top: 20px;
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
