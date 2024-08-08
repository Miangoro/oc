<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>F-UV-02-04 Ver 10, Dictamen de cumplimiento de Instalaciones como productor</title>
    <style>
        .header img {
            float: left; 
            margin-left: -10px;
            margin-top: -30px; 
        }

        .description1 {
            margin-right: 70px;
            text-align: right;
            font-size: 16px;
            color: #151442; 
        }

        .description2 {
            margin-right: 25px;
            text-align: right;
            font-size: 9px;
            color: #151442;
        }

        .description3 {
            margin-right: 30px;
            text-align: right;
            font-size: 10px;
            color: #151442;
        }

        .textimg {
            margin-top: 10px; 
            margin-left: 5px; 
        }

        .text {
            text-align: justify; 
        }

        .title {
            text-align: center;
            font-size: 20px; 
        }

        .footer-bar {
            position: fixed;
            bottom: -55px;
            left: -45px;
            right: -45px;
            width: calc(100% - 40px);
            height: 30px;
            background-color: #158F60;
            color: white;
            font-size: 12px;
            text-align: center;
            padding: 10px 0px;
            box-sizing: border-box;
        }

        .footer-bar p {
            margin: 0; 
        }

        table {
            width: 100%; 
            border: 2px solid #1E4678;
            border-collapse: collapse;
            margin: auto;
            font-size: 14px;
        }

        td, th {
            border: 2px solid #1E4678;
            padding: 5px; 
            vertical-align: top;
            word-wrap: break-word; 
        }

        td {
            width: 50%;
        }

        .text2 {
            text-align: justify; 
            font-size: 13px;
        }

        .line {
            text-align: center; 
            margin: 10px 0; 
        }

        .line::after {
            content: "";
            display: block;
            width: 30%; 
            height: 2px; 
            background-color: black; 
            margin: 0 auto;
        }

        .firma {
            text-align: center; 
            font-size: 10px;
        }

        .firma p {
            margin: 0; 
            line-height: 1.2; 
        }

        .images-container {
            position: relative; 
            display: flex;
            justify-content: space-between;
            align-items: center; 
            margin-top: 20px; 
            width: 100%; 
            position: relative; 
        }

        .image-right {
            width: 30%; 
            height: auto;
        }

        .image-left {
            margin-right: 59%;
            width: 10%; 
        }

        .textsello {
            text-align: left;
            font-size: 10px; 
            margin: 0;
            padding: 0; 
        }

        .textsello1 {
            text-align: left;
            font-size: 5px; 
            margin: 0;
            padding: 0; 
        }

        .numpag {
            font-size: 10px; 
            text-align: right;
            margin: 0; 
            padding: 0;
        }

        .sello {
            text-align: right; 
            font-size: 10px; 
            margin: 0; 
            padding: 0; 
            position: absolute;
            right: 110px; 
            top: 900px; 
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo UVEM" width="250px">
    </div>

    <div class="description1">Unidad de Inspección No. UVNOM-129</div>
    <div class="description2">Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C.</div>
    <div class="description3">Acreditados ante la Entidad Mexicana de Acreditación, A.C</div>
    <br>
    <div class="textimg">No.: UMC-00__/20___</div>
    <br>
    <div class="title">Dictamen de cumplimiento de Instalaciones como productor</div>

    <div class="text">
        <p>De acuerdo a lo establecido en los procedimientos internos de la Unidad de Inspección No. UVNOM 129 para
        la revisión de procesos de producción del producto Mezcal, su envasado y comercialización; y con fundamento
        en los artículos 56 Fracción I y 60 fracción I de la Ley de Infraestructura de la Calidad que establece el
        funcionamiento de las Unidades de Inspección.</p>

        <p>Después de realizar la inspección de las instalaciones en fecha del ____de ______del 20 ___partiendo del acta
        circunstanciada o número de inspección: _____</p>

        <p><strong>Nombre del productor/empresa: _______________________________________________________</strong></p>
    </div>

    <table>
        <tbody>
            <tr>
                <td><p><strong>Número de cliente:</strong><br>(Otorgado por el Organismo Certificador del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. (CIDAM)</p></td>
                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae culpa qui omnis cumque enim dolore, quod animi tempora, dolorem soluta vel quisquam hic quis ut nostrum? Eum cumque atque ducimus.</td>
            </tr>
            <tr>
                <td><strong>Domicilio Fiscal:</strong></td>
                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
            </tr>
            <tr>
                <td><strong>Domicilio de la unidad de producción:</strong></td>
                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, atque!</td>
            </tr>
            <tr>
                <td><strong>Responsable de la inspección:</strong></td>
                <td>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium, atque!</td>
            </tr>
            <tr>
                <td><strong>Fecha de emisión de dictamen:</strong></td>
                <td>08/082024</td>
            </tr>
            <tr>
                <td><strong>Periodo de vigencia hasta:</strong></td>
                <td>08/082024</td>
            </tr>
        </tbody>
    </table>

    <p class="text">Se dictamina que la <strong>Unidad de producción</strong> cuenta con la infraestructura, el equipo y los procesos necesarios
    para la producción de <strong>Mezcal_______, clase (s)________,</strong> requisitos establecidos en la NOM-070-SCFI-2016,
    Bebidas alcohólicas-Mezcal- Especificaciones y por el Organismo de Certificación del Centro de Innovación y
    Desarrollo Agroalimentario de Michoacán A.C. (CIDAM)</p>

    <p class="text2">Las instalaciones se encuentran en región de los estados y municipios que contempla la resolución mediante el cual se otorga la protección
    prevista a la denominación de origen Mezcal, para ser aplicada a la bebida alcohólica del mismo nombre, publicada el 28 de noviembre
    de 1994, así como sus modificaciones subsecuentes.</p>
    <br><br>

    <p class="line"></p>
    
    <div class="firma">
        <p>QFB. Mario Villanueva Flores</p>
        <p>Gerente Técnico Sustituto de la Unidad de Inspección</p>
    </div>

    <p class = "sello">Sello Unidad de Inspección</p>
    <div class="images-container">
        <img src="{{ public_path('img_pdf/qr_umc-075.png') }}" alt="Imagen izquierda" class="image-left"> <!-- Imagen PROVISONAL -->
        <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Imagen derecha" class="image-right"
    </div>

    <p class = "textsello">Cadena Original UMG-159/2024|2024-06-26|UMS-1094/2024 Sello Digital</p>

    <p class = "textsello1">e2N1P+r+E79e0YxKzS/jMssKuASlmYXy2ppP+2PJN8vKUeFRxYTSY99MEWrgiHOnA N3pLUrdUBiD39v25Y648G4TK5qQ0LwZPLofRmjRQ2Ty5rHlDwnPRm37zaOkMjkRD <br>
    xC0ikyHPD+T3EFhEc9sgAFI6bZUd88yevfS+ZFZ7j9f5EA44Sz76jsN3P4e7lyePHmNz Jxg5ZupHICg5xBZu5ygOniMZNbzG6w0ZDPL58yoMQK1JDi8lwwiGJBaCNHN6krn <br>
    No5v5rvZPkbUthYT2r5M0sGP5Y+s97oLa8GA5hqyDAgE9P0d1u0uwU7Q8SF0GYfe lavijxvsWaZg5QA5og==
    </p>

    <br>
    <p class = "numpag">Entrada en vigor: 15-07-2024</p>
    <p class = "numpag">F-UV-02-12 Ver 5.</p>

    <div class="footer-bar">
        <p>www.cidam.org . unidadverificacion@cidam.org <unidadverificacion@cidam.org></p>
        <p>Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
    </div>
</body>
</html>
