<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado de Exportacion</title>
    <style>
        @page {
            margin-top: 30;
            margin-right: 20px;
            margin-left: 80px;
            margin-bottom: 1px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            padding-right: 4px;
            padding-left: 4px;
        }

        .img-background {
            position: absolute;
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

        .img-background-left {
            position: absolute;
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

    </style>
</head>

<body>
    <div class="img-background"></div>
    <div class="img-background-left"></div>


    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}"
        style="width: 300px; float: left; margin-left: -20px; margin-top: -20px;" alt="logo de CIDAM 3D">

        

</body>

</html>
