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
            margin: 0 25px;
        }

        .header-text {
            font-family: 'Georgia', 'Times New Roman', serif;
            font-size: 24px; /* Ajustar según la imagen */
            color: #184070; /* Ajuste el color al azul oscuro */
            text-align: center; /* Centrar el texto */
            margin-top: 20px;
        }

        .text2 {
            font-size: 14.67px;
            margin: 0 25px;
            text-align: justify;
        }

        .footer {
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin-left: 25px;
            line-height: 1.5;
        }

        .code {
            font-family: Arial, sans-serif;
            text-align: justify;
            margin-left: 25px;
            margin-right: 25px;
            font-size: 7.5px;
            line-height: 0.3;
        }

        .code img {
            position: absolute;
            margin-left: 80%; /* Ajusta el valor según sea necesario */
            margin-top: -100px; /* Ajusta el margen superior si es necesario */
        }

        .uvem {
            font-family: Arial, sans-serif;
            font-size: 7.5px;
            margin-left: 25px;
            margin-right: 25px;
            line-height: 0.5;
        }

        .uvem img {
            position: absolute;
            margin-left: 56%; /* Ajusta el valor según sea necesario */
            margin-top: -100px; /* Ajusta el margen superior si es necesario */
        }

        .footer-bar {
            position: fixed;
            bottom: -55px; /* Ajusta este valor para bajar la barra más */
            left: -45px; /* Espacio en blanco a la izquierda */
            right: -45px; /* Espacio en blanco a la derecha */
            width: calc(100% - 40px); /* Resta el espacio en blanco a ambos lados */
            height: 30px; /* Ajusta este valor para estirar la barra verticalmente */
            background-color: #007b3e;
            color: white;
            font-size: 12px;
            text-align: center;
            padding: 5px 0px;
            box-sizing: border-box;
        }

        .footer-bar p {
            font-family: Arial, sans-serif;
            margin: 4px;
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
            <strong>Domicilio Fiscal: </strong>Gaspar De Villadiego, 117, Nueva Valladolid , C.P. 58190, Morelia, Michoacán. <br>
            <strong>Domicilio de la unidad de producción: </strong>Prolongación Melchor Ocampo, 29, Centro, C.P. 58480, Etúcuaro, Madero, Michoacán de Ocampo.<br>
            <strong>Categorías de mezcal: </strong>Mezcal Artesanal<br>
            <strong>Clases de mezcal que produce: </strong>Blanco o Joven<br>
            <strong>Fecha de emisión del dictamen: </strong>26 de Junio del 2024<br>
            <strong>Fecha de vigencia del dictamen: </strong>26 de Junio del 2025<br>
    </div> 
    <div class="text2">
        <p>El presente dictamen ampara exclusivamente la producción del producto mezcal que se elabora en las instalaciones
            referidas en el presente documento. Dichas Instalaciones de producción cuentan con la infraestructura y
            equipamiento requerido para la producción de mezcal indicados en la NOM-070-SCFI-2016, Bebidas alcohólicasMezcal- Especificaciones y se encuentran dentro de los estados y municipios que contempla la resolución mediante
            el cual se otorga la protección prevista a la denominación de origen Mezcal, para ser aplicada a la bebida alcohólica
            del mismo nombre, publicada el 28 de noviembre de 1994, así como sus modificaciones subsecuentes.</p>
    </div><br><br>
    <div class="footer">
        <strong>AUTORIZÓ                     Gerente Técnico Sustituto de la Unidad de Inspección | QFB. Mario Villanueva Flores</strong><br>
        <strong>Cadena Original              UMC-075/2024|2024-06-26|UMS-1113/2024</strong><br>
        <strong>Sello Digita</strong>
    </div>
    <div class="code">
        <p>WWjgdR2Ues6u2YPQcMFqcFqLQ3LA+dYVXpnB0g30TgQa6S5YkiVbK2w3UcTeAk7YQDvTKs6TKBssf5FdtbhTOifzF219tHjKHvJh1mt8c2QlQAhQWLvJeSl4K6Yd3jbV</p>
        <p>kV5p/e8n1RDjexuBeuTFASQ57nb359trB/o1i5P+LV+2/pK6IPGxEt01n5UkQoc0VI8k76G1DP7Yk4JXSLzv0k4Eis/UeWZ24hQJbtYzyedjQCFk7cZxW03Wn6fztg3BUVFCg</p>
        <p>XlksjVklcbi3RvLSfxCgZSFT8jmVYnWzlUQoI7NI2or/o2G3ZN7/OJiRfas1tQHesExVAem0LGYS9bNhA==</p>
            <img src="{{ public_path('img_pdf/qr_umc-075.png') }}" alt="QR" width="90px" class="code-img">
    </div>
    <div class="uvem">
        <p>C.c.p. Dirección General de Normas, DGN.</p>
        <p>C.c.p. Gerente del Organismo Certificador del CIDAM A.C.</p>
        <p>C.c.p. Expediente de la Unidad de Verificación del UMSNH.</p>
        <img src="{{ public_path('img_pdf/sello_uvem.png') }}" alt="Logo UVEM" width="125px" class="uvem-img"><br><br>
        <p>_________________________________________________________________________________________________________________</p>
        <center><p>Fin del documento</p></center>
        <p style="text-align: right; font-size: 10px;">Entrada en vigor: 22-06-2024</p>
        <p style="text-align: right; font-size: 10px;">F-UV-02-04 Ver 11 Página 1 de 1</p>
    </div>
    <div class="footer-bar">
        <p>Francisco J. Múgica S/N · Col. Felicitas del Rio · CP. 58040 · Morelia Mich. · Tel. 443 322 3500 · Ext. 4124 · unidadverificacion@cidam.org</p>
    </div>
</body>
</html>