<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de asignación de número de cliente</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 15px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .text_marge{
            margin: 40px;
        }

        .header img {
            width: 240px;
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
            margin: 0; padding: 0;

        }


        .section .bold {
            font-weight: bold;
        }



        .text_c{
            color: rgb(4, 57, 78);
            margin: 2px 0; /* Ajusta el margen según sea necesario */

        }
        .content {
            margin-left: 20rem; /* Adjust this value as needed to ensure enough space on the right */
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM">
        <h2 class="text_c font-weight-bold">Centro de Innovación y Desarrollo Agroalimentario <br> de Michoacán, A.C.</h2>
        <h2>Acreditado como organismo de certificación de producto con <br>
             número de acreditación 144/18 ante la Entidad Mexicana <br> 
             de Acreditación, A.C.</h2>

    </div>

    <div class="section content">
        <p class="text_al left">Oficio:<strong>CIDAM/OC/____/20__</strong></p>
        <p class="text_al left">Morelia, Michoacán. a __ de _____ del 20__</p>
        <p class="text_al left">ASUNTO: Asignación del número de cliente.</p>
    </div>

    <div class="section">
        <strong>C. REPRESENTANTE LEGAL</strong>
        <p class="font-weight-bold">__________________________</p>
        <strong>PRESENTE</strong>
    </div>

    <div class="section">
        <p style="text-align: justify;">Por medio de la presente el Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. acreditado como Organismo de Certificación de Producto, con número 144/18 ante la Entidad Mexicana de Acreditación, A.C. de acuerdo con los criterios establecidos en la Norma Mexicana NMX-EC-17065-IMNC-2014/ISO/IEC 17065:2012 para las actividades de certificación. Se le informa que a partir de esta fecha queda inscrito como cliente del Organismo Certificador del CIDAM, como parte de la cadena productiva Agave-Mezcal en los eslabones __________________________ por consiguiente se le designa el número:</p>
        <div class=" text-center">
            <strong>NOM-070-341C</strong>
        </div>
        <div style="margin-bottom: 50px;">
            <p>Sin otro en particular le envío un cordial saludo.</p>

        </div  >

        <div class="text_marge text-center">
            <p>Atentamente.</p>

        </div>

    </div>
    <div style="margin-bottom: 70px;">
        <p class="text_al text-center">GERENTE TÉCNICO DEL ORGANISMO</p>
        <p class="text_al text-center">CERTIFICADOR CIDAM A.C.</p>
    </div>
    
    <div style="margin-bottom: 30px;">
        <p class="text_al">Carta asignación del número de cliente NOM-070-SCFI-2016 F7.1-01-27</p>
        <p class="text_al">Edición 4 Entrada en vigor: 02-09-2022</p>
    </div>
    <div>
        <p class="text-center" style="font-size: 10px;">
            Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede <br> 
            ser distribuido externamente sin la autorización escrita del Director Ejecutivo.
        </p>
    </div>
    
    
</body>

</html>
