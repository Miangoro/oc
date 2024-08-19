<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>F-UV-02-04 Ver 10, Dictamen de cumplimiento de Instalaciones como productor</title>
    <style>

        @font-face {
            font-family: 'Lucida Sans Unicode';
            src: url('fonts/lsansuni.ttf') format('truetype');
            
        }

        @font-face{
            font-family: 'Arial Negrita';
            src: url('fonts/arial-negrita.ttf') format('truetype');
        }

        @font-face{
            font-family: 'Lucida Sans Unicode Negrita';
            src: url('fonts/LSANSD.TTF') format('truetype');
        }

        @page {
            size: 227mm 292mm;
            margin-left: 1.83cm;  
            margin-right: 1.83cm; 
            margin-top: 0.92cm;
        }      

        body {
            font-family: 'Lucida Sans Unicode';
            line-height: 12px;
        }

       

        #encabezado{
         
            text-align: center;
           
        }

        #encabezado #titulos {
            margin-top: 40px; /* Ajusta el espacio entre los párrafos */
          
        }

        #encabezado p {
    margin-bottom: 1px; /* Ajusta el espacio entre los párrafos */
}

#encabezado p:last-child {
    margin-bottom: 0; /* Elimina el margen inferior del último párrafo */
}


        #encabezado #logo{
            
            text-align: left;
            float: left;
        }

       

        .description1 {
           
            font-size: 16px;
            color: #151442; 
            font-family: 'Arial Negrita' !important;
           
        }

        .description2 {
            font-size: 8.5px;
            color: #151442;
            font-family: 'Arial Negrita' !important;
            
        }

        .description3 {
        
            font-size: 8.5px;
            color: #151442;
            font-family: 'Lucida Sans Unicode';
          
        }

        .textimg {
            font-family: 'Lucida Sans Unicode Negrita';
            font-size: 13.5px;
            margin-top: 10px; 
            margin-left: 5px; 

        }

        .text {
            text-align: justify; 
            font-size: 13.5px;
           
        }

        .title {
          
            text-align: center;
            font-size: 22px; 
            font-family: 'Arial Negrita', Gadget, sans-serif;
         
          
        }

        .footer-bar {
            position: fixed;
            bottom: -55px;
            left: -70px;
            right: -70px;
            width: calc(100% - 40px);
            height: 45px;
            background-color: #158F60;
            color: white;
            font-size: 9px;
            text-align: center;
            padding: 5px 0px;
            box-sizing: border-box;
            vertical-align: middle
        }

        .footer-bar p {
            margin: 0; 
        }

        table {
            width: 100%; 
            border: 2px solid #1E4678;
            border-collapse: collapse;
            margin: auto;
            font-size: 13.5px;
            vertical-align: middle;
        }

        td, th {
            border: 2px solid #1E4678;
            padding: 5px; 
           
            word-wrap: break-word; 
            vertical-align: middle;
        }

        td {
            width: 50%;
        }

        .text2 {
            text-align: justify; 
            font-size: 11px;
            line-height: 9px;
        }

        .images-container {
            position: relative; 
            display: flex;
            justify-content: space-between;
            align-items: center; 
            margin-top: -20px; 
            width: 100%; 
            position: relative; 
        }

        .image-right {
            width: 25%; 
            height: auto;
        }

        .image-left {
            margin-right: 60%;
            width: 12%; 
        }

        .textsello {
            text-align: left;
            font-size: 8px; 
            margin: 0;
            padding: 0; 
            line-height: 5px;
        }

        .numpag {
            font-size: 10px;
            position: fixed; 
            bottom: 10px;
            right: 15px; 
            margin: 0;
            padding: 0;
        }

        .sello {
            text-align: right; 
            font-size: 12px; 
            margin: 0; 
            padding: 0; 
            position: absolute;
            right: 20px; 
            top: 895px; 
            font-family: 'Arial Negrita' !important;
        }

        .negrita{
            font-family: 'Lucida Sans Unicode Negrita' !important;
        }
       
    </style>
</head>
<body>
    
    <div id="encabezado">
        <div id="logo">
            <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo UVEM" width="250px">
        </div>
        <div id="titulos">
            <span class="description1">Unidad de Inspección No. UVNOM-129</span><br>
            <span class="description2">Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C.</span><br>
            <span class="description3">Acreditados ante la Entidad Mexicana de Acreditación, A.C</span>
        </div>
    </div>
    <div class="textimg">No.: UMC-00__/20___</div>
    <div class="title">Dictamen de cumplimiento de Instalaciones como productor</div>

    <div class="text">
        <p>De acuerdo a lo establecido en los procedimientos internos de la Unidad de Inspección No. UVNOM 129 para
        la revisión de procesos de producción del producto Mezcal, su envasado y comercialización; y con fundamento
        en los artículos 56 Fracción I y 60 fracción I de la Ley de Infraestructura de la Calidad que establece el
        funcionamiento de las Unidades de Inspección.</p>
        
        <p>Después de realizar la inspección de las instalaciones en fecha del ____de ______del 20 ___partiendo del acta
        circunstanciada o número de inspección: _____</p>

        <p><span class="negrita">Nombre del productor/empresa: _______________________________________________________</span></p>
    </div>

    <table>
        <tbody id="tabla">
            <tr>
                <td style="text-align: justify;"><span class="negrita">Número de cliente:</span><br>(Otorgado por el Organismo Certificador del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C.) (CIDAM)</td>
                <td style="text-align: center; vertical-align: middle;">Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
            <tr>
                <td><span class="negrita">Domicilio Fiscal:</span></td>
                <td style="text-align: center; vertical-align: middle;">Lorem ipsum dolor sit amet consectetur adipisicing elit.</td>
            </tr>
            <tr>
                <td><span class="negrita">Domicilio de la unidad de producción:</span></td>
                <td style="text-align: center; vertical-align: middle;">Río Paso Guayabo S/N, Santa María Ecatepec, Oaxaca C.P. 70560
                    </td>
            </tr>
            <tr>
                <td><span class="negrita">Responsable de la inspección:</span></td>
                <td style="text-align: center; vertical-align: middle;">J. Karen Velázquez Sánchez</td>
            </tr>
            <tr>
                <td><span class="negrita">Fecha de emisión de dictamen:</span></td>
                <td style="text-align: center; vertical-align: middle;">01 de Agosto del 2024</td>
            </tr>
            <tr>
                <td><span class="negrita">Periodo de vigencia hasta:</span></td>
                <td style="text-align: center; vertical-align: middle;">01 de Agosto del 2025</td>
            </tr>
        </tbody>
    </table>

    <p class="text">Se dictamina que la <span class="negrita">Unidad de producción</span> cuenta con la infraestructura, el equipo y los procesos necesarios
    para la producción de <span class="negrita">Mezcal_______, clase (s)________,</span> requisitos establecidos en la NOM-070-SCFI-2016,
    Bebidas alcohólicas-Mezcal- Especificaciones y por el Organismo de Certificación del Centro de Innovación y
    Desarrollo Agroalimentario de Michoacán A.C. (CIDAM)</p>

    <p class="text2">Las instalaciones se encuentran en región de los estados y municipios que contempla la resolución mediante el cual se otorga la protección
    prevista a la denominación de origen Mezcal, para ser aplicada a la bebida alcohólica del mismo nombre, publicada el 28 de noviembre
    de 1994, así como sus modificaciones subsecuentes.</p>
    <br><br>

    <p class = "sello">Sello de Unidad de Inspección</p>
    <div class="images-container">
        <img src="{{ public_path('img_pdf/qr_umc-075.png') }}" alt="Imagen izquierda" class="image-left"> <!-- Imagen PROVISONAL -->
        <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Imagen derecha" class="image-right">
    </div>

    <p style="font-size: 10px; margin: 0px;">
    <span class="negrita">AUTORIZÓ</span>
    <span style="margin-left: 50px;">
        <span class="negrita">Gerente Técnico Sustituto de la Unidad de Inspección | BTG. Erik Antonio Mejía Vaca</span>
    </span>
    </p>

    <p style="font-size: 10px; margin: 1;">
    <span class="negrita">Cadena Origina</span>
    <span style="margin-left: 29px;">
        <span class="negrita">UMG-159/2024|2024-06-26|UMS-1094/2024 S</span>
    </span>
    </p>

    <p style="font-size: 10px; margin: 1;">
    <span class="negrita">Sello Digital</span>
    </p>

    <p class = "textsello">e2N1P+r+E79e0YxKzS/jMssKuASlmYXy2ppP+2PJN8vKUeFRxYTSY99MEWrgiHOnA N3pLUrdUBiD39v25Y648G4TK5qQ0LwZPLofRmjRQ2Ty5rHlDwnPRm37zaOkMjkRD <br>
    xC0ikyHPD+T3EFhEc9sgAFI6bZUd88yevfS+ZFZ7j9f5EA44Sz76jsN3P4e7lyePHmNz Jxg5ZupHICg5xBZu5ygOniMZNbzG6w0ZDPL58yoMQK1JDi8lwwiGJBaCNHN6krn <br>
    No5v5rvZPkbUthYT2r5M0sGP5Y+s97oLa8GA5hqyDAgE9P0d1u0uwU7Q8SF0GYfe lavijxvsWaZg5QA5og==
    </p>

    <p class = "numpag">Entrada en vigor: 15-07-2024 <br>F-UV-02-04 Ver 10.</p>

    <div class="footer-bar">
        <p><span class="negrita">www.cidam.org . unidadverificacion@cidam.org <unidadverificacion@cidam.org></span> <br>
        Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
    </div>
</body>
</html>
