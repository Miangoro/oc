<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de envasador de mezcal</title>
    <style>

        @page {
            size: 216mm 279mm;
        }

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
            pointer-events: none; 
        }

        .header img {
            float: left; 
            margin-left: -10px;
            margin-top: -30px; 
        }

        .description1 {
            font-size: 25px;
            font-weight: bold;
            text-align: right;
        }

        .description2 {
            font-weight: bold;
            font-size: 14px;
            color: #5A5768;
            white-space: nowrap;
            position: relative;
            top: -64px;
            left: 295px; 
        }

        .description3 {
            font-weight: bold;
            margin-right: 30px;
            text-align: right;
            font-size: 13px;
            position: relative;
            top: -30px;
        }

        .text {
            font-size: 13.5px;
            line-height: 1.5;
            text-align: justify;
            margin: 10 20px;
        }

        .text1 {
            font-size: 13.5px;
            line-height: 1.5;
            text-align: justify;
            margin: -5 20px;
        }

        .title {
            font-size: 25px;
            text-align: center;
            font-weight: bold;
            letter-spacing: 9px;
            line-height: 0.5;
        }

        .title2 {
            font-size: 25px;
            text-align: center;
            font-weight: bold;
            line-height: 0.5;
        }

        .title3 {
            font-size: 20px;
            text-align: center;
            font-weight: bold;
            line-height: 0.5;
        }

        table {
            width: 95%; 
            border-collapse: collapse;
            margin: 25px 0; 
            font-size: 13px;
            margin: 10px 20px;
            white-space: normal; 
        }

        td, th {
            border: 1px solid #595959;
            padding: 8px; 
            text-align: left;
        }

        th {
            background: #f0e6cc;
            font-weight: bold;
        }

        td[colspan="3"] {
            width: 75%;
        }

        td[colspan="2"] {
            width: 50%;
        }

        .even {
            background: #fbf8f0;
        }

        .odd {
            background: #fefcf9;
        }
        
        .cell {
            border-right: 1px solid transparent;
            white-space: nowrap; 
        }
        
        .cell1 {
            white-space: nowrap; 
        }

        .cellx {
            white-space: nowrap; 
        }

        .cent {
            white-space: normal; 
        }

        .signature {
            margin: 50px 20px; 
            text-align: center; 
            margin-top: 30px; 
        }

        .signature-line {
            line-height: 10;
            border-top: 1px solid #000; 
            width: 240px; 
            margin: 0 auto; 
            padding-top: 5px; 
        }

        .signature-name {
            font-family: Arial;
            margin: 10px 0 0; 
            font-size: 13px; 
            font-weight: bold;
            line-height: 0.5;
        }

        .down{
            text-align: right;
            font-size: 11px;
            margin-top: -40px; 
            margin-right: 50px;
        }

        .down1{
            text-align: right;
            font-size: 11px;
            margin-top: -5px; 
            margin-right: 50px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 20px;
            color: #333;
            transform: translateY(50px);
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .footer-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px; 
            font-weight: bold;
            color: #5A5768;
            margin: 2; 
        }

        .footer-item img {
            width: 20px;
            height: 20px;
        }

        .footer-left {
            flex: 1;
            text-align: left;
        }

        .footer-center {
            flex: 1;
            text-align: center;
            position: relative;
            margin-top: -25px; 
        }

        .footer-right {
            flex: 1;
            text-align: right;
            position: relative;
            margin-top: -25px; 
            margin-right: 60px;
        }

        .footer-address, .footer-phone {
            flex-basis: 100%;
            text-align: center; 
            font-size: 12px;
            font-weight: bold;
            color: #5A5768;
            margin-right: 20px;
        }
    </style>
</head>
<body>
<img src="{{ public_path('img_pdf/logo_fondo.png') }}" alt="Marca de Agua" class="watermark">

<div class="header">
    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM" width="320px">
</div>

<div class="description1">ORGANISMO CERTIFICADOR</div>
<div class="description2">Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C</div>
<div class="description3">No. CERTIFICADO: CIDAM C-INS-088/2024</div>

<p class="text1">
Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C. Acreditado como organismo de certificación de producto con número de acreditación 144/18 ante la Entidad Mexicana de Acreditación, A.C. otorga el siguiente:
</p>

<p class="title">CERTIFICADO NOM</p>
<p class="title2">COMO ENVASADOR DE MEZCAL A</p>
<p class="title3">"ALBERTO FRANCO MORGADO"</p>

<table>
    <tbody>
        <tr>
            <td class="cellx"><strong>Domicilio Fiscal:</strong></td>
            <td colspan="3" class="cent" style="text-align: center; vertical-align: middle;">Av, Periférico 5ur, No. Ext. 3915 No. Int. Escorpion 801, Pedregal De Carrasco, Coyoacán, Ciudad De México. C.P.04700.</td>
        </tr>
        <tr>
            <td class="cell"><strong>RFC:</strong></td>
            <td>FAMA860914190</td>
            <td class="cell"><strong>Tel:</strong></td>
            <td>5537449304</td>
        </tr>
        <tr>
            <td class="cell"><strong>Correo electrónico:</strong></td>
            <td colspan="3">albertofranci1313@gmail.com</td>
        </tr>
        <tr>
            <td class="cellx"><strong>Fecha de inicio vigencia:</strong></td>
            <td>22/julio/2024</td>
            <td class="cell1"><strong>Fecha de Vencimiento:</strong></td>
            <td>23/Julio/2025</td>
        </tr>
    </tbody>
</table>

<p class="text">La presente certificación se realiza de acuerdo a la Norma Oficial Mexicana NOM-070-SCFI-2016, Bebidas
Alcohólicas-Mezcal-Especificaciones, en vigor, mediante el esquema dé certificación para productos con
Denominación de Origen.<br>Esta empresa a demostrado que cuenta con la infraestructura, conocimientos y la práctica necesaria para ejecutar
las etapas de comercializació¡ de la Bebida Alcohólica Destil_ada Denominada Mezcal de conformidad con lo
establecido en la NOM-070-SCFI-2016, Bebidas Alcohólicas-Mezcal-Especificaciones.<br>Esta certificación ampara exclusivamente la comercialización del'producto Mezcal, Mezcal Artesanal, Mezcal
Ancestral, <strong>Clase:</strong> Joven, Madurado en Vidrio, Reposado, AñeJo, flbocadocon, Destilado con, que se realice en las
instalaciones indicadas a continuación.<br><strong>Domicilio de la unidad de Envasado:</strong> Francisco l. Madero, 12 A, Col. 20 De Noviembre,<br>
Chilpancingo de los Bravo, Guerrero, C.P. 39096.<br><strong>No. De Dictamen de cumplimiento con la NOM:</strong>  UMC-076/2024<br></p>

<P class="text">Dichas instalaciones cuentan con el equipg requerido para el envasado del producto Mezcal y se encuentran
dentro dé los estados y municipios que contempla la Resolución mediante la cua,l se otorga la protección prevista
a la Denominación de Origen Mezcal, para ser aplicada a la bebida alcohólica del mismo nombre,.publicada el 28
de Noviembre de l-994. así como sus subsecuentes modificaciones</P>

<div class="signature">
    <p class="signature-line"></p>
    <p class="signature-name">M.S.LG. Eia Viviana Soto Barrlentos</p>
    <p class="signature-name">Gerente del Organismo Certificador CIDAM</p>
</div>

<p class="down">Este cértificado sustituye al: No aplica<br>Certificado como Comercializador de Mezcal NOM-070-SCFI-2016 F7.1-01-37<br>Edición 5 Entrada en vigor 12/01/2024</p>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-left">
            <div class="footer-item">
                <img src="{{ public_path('img_pdf/internet.png') }}" alt="Logo CIDAM" width="20px">
                <a>www.cidam.org</a>
            </div>
        </div>
        <div class="footer-center">
            <div class="footer-item">
                <img src="{{ public_path('img_pdf/mail.png') }}" alt="Logo CIDAM" width="20px">
                <a>organismocertificadorcidam@gmail.com</a>
            </div>
        </div>
        <div class="footer-right">
            <div class="footer-item">
                <img src="{{ public_path('img_pdf/facebook.png') }}" alt="Logo CIDAM" width="20px">
                <a>cidam</a>
            </div>
        </div>
        <div class="footer-address">
            Kilómetro 8 Antigua Carretera a Pátzcuaro S/N - Colonia otra no especificada en el catálogo - C.P. 58341 - Morelia, Mich
        </div>
        <div class="footer-phone">
            Tels: 443 299 0181 · 443 299 0264
        </div>
    </div>
</footer>

</body>
</html>
