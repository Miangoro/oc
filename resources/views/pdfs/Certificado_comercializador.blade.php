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
<<<<<<< HEAD
            
=======
>>>>>>> 6992792300159390f24051b20ea1af744c22949b
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

        .cent {
            white-space: normal; 
        }

        .signature {
            margin: 50px 20px; 
            text-align: center; 
            margin-top: 70px; 
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

        .down {
            text-align: right;
            font-size: 11px;
            margin-top: -40px; 
            margin-right: 20px;
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

    </style>
</head>
<body>
<img src="{{ public_path('img_pdf/logo_fondo.png') }}" alt="Marca de Agua" class="watermark">

<div class="header">
    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM" width="300px">
</div>

<div class="description1">ORGANISMO CERTIFICADOR</div>
<div class="description2">Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C</div>
<div class="description3">No. CERTIFICADO: CIDAM C-INS-089/2024</div>

<p class="text1">
Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C. Acreditado como organismo de certificación de producto con número de acreditación 144/18 ante la Entidad Mexicana de Acreditación, A.C. otorga el siguiente:
</p>

<p class="title">CERTIFICADO NOM</p>
<p class="title2">COMO COMERCIALIZADOR DE MEZCAL A</p>
<p class="title3">"ALBERTO FRANCO MORGADO"</p>

<table>
    <tbody>
        <tr>
            <td class="cell"><strong>Domicilio:</strong></td>
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
            <td class="cell1"><strong>Fecha de inicio vigencia:</strong></td>
            <td>22/julio/2024</td>
            <td class="cell1"><strong>Fecha de Vencimiento:</strong></td>
            <td>23/Julio/2025</td>
        </tr>
    </tbody>
</table>

<p class="text">La presente certificación se realiza de acuerdo a la Norma Oficial Mexicana NOM-070-SCFI-2016, Bebidas
Alcohólicas-Mezcal-Especificaciones, en vigor, mediante el esquema dé certificación para productos con
Denominación de Origen.</p>

<p class="text">Esta empresa a demostrado que cuenta con la infraestructura, conocimientos y la práctica necesaria para ejecutar
las etapas de comercialización de la Bebida Alcohólica Destilada Denominada Mezcal de conformidad con lo
establecido en la NOM-070-SCFI-2016, Bebidas Alcohólicas-Mezcal-Especificaciones.
</p>

<p class="text">Esta certificación ampara exclusivamente la comercialización del producto Mezcal, Mezcal Artesanal, Mezcal
Ancestral, <strong>Clase:</strong> Joven, Madurado en Vidrio, Reposado, Añejo, Abocado con, Destilado con, que se realice en las
instalaciones indicadas a continuación.</p>

<p class="text"><strong>Domicilio de la unidad de Comercialización:</strong>Francisco l. Madero, 12 A, Col. 20 De Noviembre, Chilpancingo de los Bravo, Guerrero, C.P. 39096.
Michoacán.</p>

<p class="text"><strong>No. De Dictamen de cumplimiento con la NOM:</strong> UMC-077/2024</p>

<div class="signature">
    <div class="signature-line"></div>
    <div class="signature-name">M.S.LG. Eia Viviana Soto Barrlentos</div>
    <div class="signature-name">Gerente del Organismo Certificador CIDAM</div>
</div>

<div class="down">Certificado como Comercializador de Mezcal NOM-070-2016 F7.1-01-37 <br>Edición 5 Entrada en vigor 12/01/2024</div>

<<<<<<< HEAD
<footer class="footer">
    <div class="footer-container">
        
        <div class="footer-center">
            <div class="footer-item">
                <img src="{{ public_path('img_pdf/pie_certificado.png') }}" alt="Logo CIDAM" width="205px">
                <a>organismocertificadorcidam@gmail.com</a>
            </div>
        </div>
     
    </div>
</footer>
=======
<div class="foother">
    <img src="{{ public_path('img_pdf/pie_certificado.png') }}" alt="Logo CIDAM" width="300px">
</div>
>>>>>>> 6992792300159390f24051b20ea1af744c22949b

</body>
</html>
