<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de comercializador</title>
    <style>
    
        body {
        font-family: 'Calibri', sans-serif;
        }

        .watermark {
            position: absolute;
            top: 43%;
            left: 55%;
            width: 50%;
            height: auto; 
            transform: translate(-50%, -50%);
            opacity: 0.3;
            z-index: -1; 
        }

        .header img {
            float: left; 
            margin-left: -10px;
            margin-top: -30px; 
        }

        .description1 {
            margin-right: 30px;
            font-size: 25px;
            font-weight: bold;
            text-align: right;
        }

        .description2 {
            font-weight: bold;
            font-size: 13.5px;
            white-space: nowrap;
            position: relative;
            top: -60px;
            left: 295px; 
        }

        .foother {
            position: fixed;
            bottom: -40; 
            left: 0; 
            width: 100%; 
            text-align: center; 
            margin: 0;
            padding: 10px 0; 
        }

        .foother img {
            margin-top: 40px;
            width: 700px; 
            height: auto;
            display: inline-block;
        }
        .pie {
            text-align: right;
            font-size: 9px;
            line-height: 1;
            position: fixed;
            bottom: -10;
            left: 0;   
            right: 0;  
            width: calc(100% - 40px); 
            height: 45px;
            margin-right: 30px; 
            padding: 10px 0px;
            font-family: 'Lucida Sans Unicode';
        }

    </style>
</head>
<body>
<img src="{{ public_path('img_pdf/logo_fondo.png') }}" alt="Marca de Agua" class="watermark">

<div class="header">
    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM" width="300px">
</div>

<div class="description1">ORGANISMO CERTIFICADOR</div>
<div class="description2">Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C</div>





<p class="pie">Entrada en vigor: 15-07-2024 <br>
    F-UV-02-04 Ver 10
    </p>
<div class="foother">
    <img src="{{ public_path('img_pdf/pie_certificado.png') }}" alt="Logo CIDAM" width="300px">
</div>

</body>
</html>
