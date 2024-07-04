<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Comercializador</title>

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
        <p>No.: UMC-072/2024</p>
        <p>Dictamen de cumplimiento de Instalaciones</p>
        <p>como</p>
        <div class="title">
            Comercializador de Mezcal
        </div>
    </div>
    <div class="text">
        <p>De acuerdo a lo establecido en los procedimientos internos de la Unidad de Inspección <strong>No. UVNOM 129 </strong>de la
            Universidad Michoacana de San Nicolás de Hidalgo, con domicilio en Francisco J. Múgica s/n Col. Felicitas del
            Rio, Morelia, Michoacán para la revisión de procesos de producción del producto Mezcal, su envasado y
            comercialización; y con fundamento en los artículos 56 Fracción I y 60 fracción I de la Ley de Infraestructura de la
            Calidad que establece el funcionamiento de las Unidades de Inspección. Después de realizar la inspección de las
            instalaciones en fecha del <u>21 de Junio del 2024</u> partiendo del acta circunstanciada o número de inspección:
            <u>UMS-1075/2024</u> se otorga el Dictamen de Instalaciones</p>
            <center><strong>A:</strong></center>
            <div class="header-text">
                <strong>CORPORATIVO 60 GRADOS S.A.P.I. DE C.V.</strong>
            </div>
            <br>
            <strong>Domicilio Fiscal: </strong>: Alberto Alvarado, 1025, Villa Universidad, C.P. 58060, Morelia, Michoacán<br>
            <strong>Domicilio de la unidad de comercialización:</strong> Alberto Alvarado, 1025, Villa Universidad, Morelia, 58060, Morelia,
            Michoacán de Ocampo<br>
            <strong>Categorías de mezcal: </strong>Mezcal, Mezcal Artesanal, Mezcal Ancestral<br>
            <strong>Clases de mezcal que comercializa: </strong>Blanco o Joven, Madurado en Vidrio, Reposado, Añejo, Abocado con,
            Destilado con
            <br>
            <strong>Fecha de emisión del dictamen: </strong>26 de Junio del 2024<br>
            <strong>Fecha de vigencia del dictamen: </strong> 26 de Junio del 2025
            <br>
    </div> 
    <div class="text2">
        <p>El presente dictamen ampara exclusivamente la comercialización del producto mezcal que se realiza en las
            instalaciones referidas en el presente documento. Dichas Instalaciones de comercialización cuentan con la
            infraestructura y equipamiento requerido para la comercialización de mezcal indicados en la NOM-070-SCFI-2016,
            Bebidas alcohólicas-Mezcal- Especificaciones.</p>
    </div><br><br>
    <div class="footer">
        <strong>AUTORIZÓ                     Gerente Técnico Sustituto de la Unidad de Inspección | QFB. Mario Villanueva Flores</strong><br>
        <strong>Cadena Original              UMC-075/2024|2024-06-26|UMS-1113/2024</strong><br>
        <strong>Sello Digita</strong>
    </div>
    <div class="code">
        <p>RbZmXb5fD5McSRrdWzWxFFdgNFIYuW4920voRIgsq+gZWJd8PAbzPxLpmRu6uQuDPjRyF3YVIVU99VvaHrMHAZGF60ZQHGk3/f2Zo/WRQetPr17ZfGMS49LPUtqhjs</p>
        <p>pqeCJE+mLH6zR+aSVgz5aqio3/ckbMLnnnLcQyzdXxWCofhGA+LVfyUKp8cvEq5xqdQEJT1cXWo+F0VlqohgzysRqdsXBJpQXTvpemuQcqa5PnoLRLkKWm7DUHc50Q</p>
        <p>jHuymCW941KwC0568++oOZe6PYnFQAzIPxLr3Lwfi+ZefBpRl7Sd8pzP40YwPjoyDzNr19ODEc+KraxRcYA3xoK2iw==</p>
            <img src="{{ public_path('img_pdf/qr_umc-072.png') }}" alt="QR" width="90px" class="code-img">
    </div>
    <div class="uvem">
        <strong><p>C.c.p Gerente del Organismo Certificador del CIDAM A.C.</p></strong>
        <strong><p>C.c.p Expediente de la Unidad de Inspección del UMSNH.</p></strong>
        <br>
        <img src="{{ public_path('img_pdf/sello_uvem.png') }}" alt="Logo UVEM" width="125px" class="uvem-img"><br><br>
        <p>_________________________________________________________________________________________________________________</p>
        <strong><center>Fin del documento</center></strong>
        <p style="text-align: right; font-size: 10px;">Entrada en vigor: 16-08-2023</p>
        <p style="text-align: right; font-size: 10px;">F-UV-02-04 Ver 11 Página 1 de 1</p>
    </div>
    <div class="footer-bar">
        <p>Francisco J. Múgica S/N · Col. Felicitas del Rio · CP. 58040 · Morelia Mich. · Tel. 443 322 3500 · Ext. 4124 · unidadverificacion@cidam.org</p>
    </div>
</body>
</html> 