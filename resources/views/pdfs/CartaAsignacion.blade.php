<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento PDF</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 170px;
            float: left;
            
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
        }

        .header h2 {
            font-size: 14px;
            margin: 0;
            font-weight: normal;
        }

        .header h6 {
            font-size: 10px;
            margin: 0;
            font-weight: normal;
        }

        .section {
            margin-top: 20px;
            margin-bottom: 4rem;
        }

        .section p {
            margin: 0px 5px;
        }

        .text_al {
            text-align: right;
        }


        .section .bold {
            font-weight: bold;
        }



        .text_c{
            color: gray;
            margin: 2px 0; /* Ajusta el margen según sea necesario */

        }
        .content {
            margin-left: 20rem; /* Adjust this value as needed to ensure enough space on the right */
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_nuevo.png') }}" alt="Logo CIDAM">
        <h4 class="text_c">Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C.</h4>
        <h6 class="text_c">Acreditado como organismo de certificación de producto con</h6>
        <h6 class="text_c">número de acreditación 144/18 ante la Entidad Mexicana de </h6>
        <h6 class="text_c">Acreditación, A.C.</h6>

        <h2 class="font-weight-bold">ORGANISMO DE CERTIFICACIÓN</h2>
    </div>

    <div class="section content">
        <p class="left">Oficio:</p>
        <p class="left">Morelia, Michoacán a 24 de Junio del 2024</p>
        <p class="left">ASUNTO: Asignación del número de cliente.</p>
    </div>

    <div class="section">
        <p>C. REPRESENTANTE LEGAL</p>
        <p>NORBORTO BUCIO ALCAUCER</p>
        <p class="font-weight-bold">PRESENTE</p>
    </div>

    <div class="section">
        <p>Por medio de la presente el Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. acreditado como Organismo de Certificación de Producto, con número 144/18 ante la Entidad Mexicana de Acreditación, A.C. de acuerdo con los criterios establecidos en la Norma Mexicana NMX-EC-17065-IMNC-2014/ISO/IEC 17065:2012 para las actividades de certificación. Se le informa que a partir de esta fecha queda inscrito como cliente del Organismo Certificador del CIDAM, como parte de la cadena productiva Agave-Mezcal en los eslabones de <strong>Productor de agave</strong> por consiguiente se le designa el número:</p>
        <div class="section text-center">
            <p class="font-weight-bold text-center">NOM-070-341C</p>

            <p>Sin otro en particular le envío un cordial saludo.</p>
            <p>Atentamente,</p>
            <br>
        </div>
    </div>

    <div class="text-center">
        <p class="name">MAYRA GUTIÉRREZ ROMERO</p>
        <p class="position">GERENTE TÉCNICO DEL ORGANISMO</p>
        <p class="position">DE CERTIFICACIÓN</p>
    </div>

    <div class="text_al">
        <p class="text_c">F7.1-01-27 Ed 3</p>
        <p class="text_c">Fecha de entrada en vigor</p>
        <p class="text_c">08-02-2021</p>
    </div>
</body>

</html>
