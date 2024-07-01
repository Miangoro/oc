<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de productor de mezcal</title>
    <style>
        .header img {
            float: left; 
            margin-left: 25px;
            margin-top: -25px; 
        }

        .header .img2 {
            float: right;
            margin-right: 40px;
            margin-top: -5px; 
        }

        .description {
            text-align: center;
            margin-top: 20px; /* Ajusta el margen superior según sea necesario */
        }

        .description p {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            line-height: 0.5; /* Ajustado para separación normal */
        }

        .description .title {
            font-size: 36.5px;
            font-weight: bold;
            color: #b0b0b0; /* Color gris */
            font-family: 'Times New Roman', Times, serif; /* Fuente similar */
            margin-top: 20px; /* Espacio arriba del título */
        }

        .marca-agua {
            position: fixed;
            top: -20px; /* Ajusta aquí la posición hacia arriba */
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none; /* La marca de agua no es clickeable */
            background-image: url('{{ public_path('img_pdf/fondo_dictamen.png') }}');
            background-size: 500px;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.2; /* Ajusta la opacidad según sea necesario */
        }

        .text {
            font-size: 14.67px;
            text-align: justify;
            margin-right: 10px;
            margin-left: 10px;
            margin-right: 25px;
            margin-left: 25px;
        }

        .header-text {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 24px; /* Ajustar según la imagen */
            color: #184070; /* Ajuste el color al azul oscuro */
            text-align: center; /* Centrar el texto */
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="marca-agua"></div>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_uvem.png') }}" alt="Logo CIDAM" width="120px">
        <img class="img2" src="{{ public_path('img_pdf/logoumsn.png') }}" alt="Logo UMSN" width="325px">
        <br><br><br><br><br><br>
    </div>
    <div class="description">
        <p>No.: UMC-075/2024</p>
        <p>Constancia de cumplimiento con la NOM-070-SCFI-2016</p>
        <p>como</p>
        <div class="title">
            Productor de Mezcal
        </div>
    </div>
    <div class="text">
        <p>De acuerdo a lo establecido en los procedimientos internos de la Unidad de Inspección <strong>No.UVNOM 129</strong> de la
            Universidad Michoacana de San Nicolás de Hidalgo, con domicilio en Francisco J. Múgica s/n Col. Felicitas del
            Rio, Morelia Michoacán para la revisión de procesos de producción del producto Mezcal, su envasado y
            comercialización; y con fundamento en los artículos 56 Fracción I y 60 fracción I de la Ley de Infraestructura de la
            Calidad que establece el funcionamiento de las Unidades de Inspección. Después de realizar la inspección de las
            instalaciones en fecha del <u>25 de Junio del 2024</u> partiendo del acta circunstanciada o número de inspección:
            <u>UMS-1113/2024</u></p>
            <center><strong>A:</strong></center>
            <div class="header-text">
                <strong>GAO TAMLEI S.A DE C.V.</strong>
            </div>
            <br>
            <strong>Domicilio Fiscal:</strong>Gaspar De Villadiego, 117, Nueva Valladolid , C.P. 58190, Morelia, Michoacán. <br>
            <strong>Domicilio de la unidad de producción:</strong>: Prolongación Melchor Ocampo, 29, Centro, C.P. 58480, Etúcuaro, Madero, Michoacán de Ocampo.<br>
    </div>
</body>
</html>
