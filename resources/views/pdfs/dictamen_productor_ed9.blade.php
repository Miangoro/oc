<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento NOM de Productor de Mezcal</title>
    <style>
        @page {
            size: 227mm 292mm;
            /*Tamaño carta*/
            margin: 30px 60px 30px 60px;
            /*márgenes (arriba, derecha, abajo, izquierda) */
        }

        /*@font-face {
        font-family: 'fuenteNegrita';
        src: url('{{ storage_path('fonts/LSANSD.ttf') }}');
    }*/

        body {
            /*ajustes generales*/
            font-family: 'calibri';
            font-size: 14px;
            line-height: 0.9;
            /*interlineado*/
        }


        .encabezado {
            position: fixed;
            /* top: -14px;
        padding-left: 2%; */
        }

        .encabezado img {
            width: 110px;
            height: 100px;
            padding-right: 160px;
            vertical-align: top;
            /*alinear verticalmente el contenido en la parte superior de inline-block*/
        }

        .encabezado p {
            display: inline-block;
            /*coloca elementos en línea horizontalmente*/
            margin-top: 6%;
            text-align: right;
            font-family: 'fuenteNegrita';
            font-size: 28px;
            line-height: 1;
        }


        .footer {
            position: fixed;
            /*lo fija en pantalla*/
            bottom: -30px;
            left: -60px;
            right: -60px;
            padding-bottom: 5px;
            background-color: #158F60;
            color: white;
            /*color letra*/
            text-align: center;
            font-size: 11px;
        }

        .footer p {
            margin: 1;
            line-height: 1;
        }

        .leyenda {
            position: fixed;
            bottom: 6px;
            right: 0;
            text-align: right;
            font-family: 'Lucida Sans Unicode';
            font-size: 9px;
            line-height: 0.9;
        }


        .contenido {
            font-family: 'TeXGyreTermes', serif;
            margin-top: 15%;
            margin-left: 30px;
            margin-right: 20px;
            font-size: 14px;
            line-height: 1.3;
            color: #000000;
            /*margin-left: 30px;
        margin-right: 20px;*/
        }




        .watermark {
            color: red;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg) scaleY(1.2);
            opacity: 0.5;
            /* Opacidad predeterminada */
            letter-spacing: 3px;
            font-size: 150px;
            white-space: nowrap;
            z-index: -1;
        }


        .fondo {
            position: fixed;
            top: 30%;
            left: 130px;
            width: 500px;
            height: 440px;
            opacity: 0.2;
        }


        /*inicia firma digital DIV*/
        .firma {
            position: relative;
            width: 100%;
            /*vertical-align: bottom;*/
        }

        /* Encabezados principales */
        .title {
            font-family: 'TeXGyreTermes', serif;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 1.5;
            padding: 0;
        }

        .title2 {
            font-family: 'TeXGyreTermes', serif;
            font-size: 38px;
            font-weight: bold;
            color: #a9a9a9ff;
            text-align: center;
            margin: 10px 0 20px 0;
        }

        /* Textos generales */
        .text {
            font-family: 'TeXGyreTermes', serif;
            margin: 0;
            font-size: 14px;
            text-align: justify;
            margin-bottom: 12px;
        }

        .textx {
            line-height: 0.5;
            font-size: 9px;
            font-family: Arial, Helvetica, Verdana;
        }

        /* Etiquetas como "No.", "A:" */
        .textimg {
            font-family: 'TeXGyreTermes', serif;
            text-align: center;
            font-weight: bold;
            font-size: 15px;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .textp {
            font-family: 'TeXGyreTermes', serif;
            font-size: 28px;
            font-weight: bold;
            color: #004A80;
            text-align: center;
            margin-bottom: 25px;
        }

        .textsello {
            width: 85%;
            text-align: left;
            word-wrap: break-word;
            margin-top: -5px;
            line-height: 1.2;
            font-size: 8px;
            font-family: Arial, Helvetica, Verdana;
        }

        /* Tabla de datos */
        .table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
            font-size: 13px;
        }

        .table td,
        .table th {
            font-family: 'TeXGyreTermes', serif;
            border: 1px solid #003300;
            padding: 8px;
            vertical-align: middle;
            text-align: left;
        }

        .datos-comercio {
            font-family: 'TeXGyreTermes', serif;
            font-size: 15px;
            line-height: 1.3;
            color: #000;
            margin-top: 25px;
            text-align: justify;
        }

        .resaltado2 {
            font-weight: bold;
            display: inline;
        }


        .bold {
            font-weight: bold;
        }

        .subtitulos {
            font-family: 'TeXGyreTermes', serif;
            font-size: 14px;
            margin-top: 1.5;
            margin-bottom: 0.3em;
            padding-left: 1em;
            font-weight: bold;
            text-align: center;
        }

        .pie {
            text-align: right;
            font-size: 9px;
            line-height: 1;
            position: fixed;
            bottom: -4;
            left: 0;
            right: 0;
            width: calc(100% - 40px);
            height: 45px;
            margin-right: 30px;
            padding: 10px 0px;
            font-family: 'Lucida Sans Unicode';
        }

       
    </style>
</head>

<body>

    @if ($watermarkText)
        <div class="watermark">
            Cancelado
        </div>
    @endif

    <img class="fondo" src="{{ public_path('img_pdf/fondo_dictamen.png') }}" alt="Fondo agave">

    <div class="encabezado">
        <img src="{{ public_path('img_pdf/logo_uvem.png') }}" alt="Logo">
        <p>Universidad Michoacana de San <br>Nicolás de Hidalgo</p>
    </div>

    <div class="footer">
        <p style="font-family: Lucida Sans Seminegrita;">www.cidam.org . unidadverificacion@cidam.org</p>
        <p style="font-family: Lucida Sans Unicode; font-size: 10px;">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N.
            Col. Otra no especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
    </div>







    <div class="contenido">
        <div class="title">No.:UMC-102/2025 </div>

        <div class="title"> Constancia de cumplimiento con la NOM-070-SCFI-2016 </div>
        <div class="subtitulos">como</div>

        <div class="title2">Productor de Mezcal</div>
        <div class="text">
            De acuerdo a lo establecido en los procedimientos internos de la Unidad de Inspección <strong>No.UVNOM129
            </strong>de la
            Universidad Michoacana de San Nicolás de Hidalgo,con domicilio en Francisco J.Múgica s/n Col. Felicitas del
            Rio,Morelia Michoacán para la revisión de procesos de producción del producto Mezcal, su envasado y
            comercialización; y confundamento en los artículos 56 Fracción I y 60 fracción I de la Ley de
            Infraestructura de la
            Calidad que establece el funcionamiento de las Unidades de Inspección. Después de realizar la inspección de
            las
            instalaciones en fecha del <u><span class="negrita">{{ $fecha_inspeccion }}</span></u> partiendo del acta
            circunstanciada o número de inspección: <u><span
                    class="negrita">{{ $datos->inspeccione->num_servicio ?? '' }}</u></span></p>
        </div>

        <div class="textimg negrita">A:</div>
        <p class="textp">ISIDRO RODRIGUEZ MONTOYA</p>

        <p class="datos-comercio">
            <span class="resaltado2">Domicilio Fiscal: </span>
            {{ $datos->inspeccione->solicitud->empresa->domicilio_fiscal ?? '' }} C.P. {{ $datos->inspeccione->solicitud->empresa->cp ?? '' }}<br>
            <span class="resaltado2">Domicilio de la unidad de comercialización: </span>
            {{ $datos->instalaciones->direccion_completa ?? '' }}<br>
            <span class="resaltado2">Categorías de mezcal:</span> Mezcal, Mezcal Artesanal, Mezcal Ancestral<br>
            <span class="resaltado2">Clases de mezcal que comercializa: </span>Blanco o Joven, Madurado en Vidrio,
            Reposado, Añejo, Abocado con, Destilado con<br>
            <span class="resaltado2">Fecha de emisión del dictamen: </span>{{ $fecha_emision }}<br>
            <span class="resaltado2">Fecha de vigencia del dictamen: </span>{{ $fecha_vigencia }}
        </p>
        <p class="text">
            El presente dictamen ampara exclusivamente la producción del producto mezcal que se elabora en las
            instalaciones
            referidas en el presente documento. Dichas Instalaciones de producción cuentan con la infraestructura y
            equipamiento requerido para la producción de mezcal indicados en la NOM-070-SCFI-2016,Bebidas alcohólicas
            Mezcal-Especificaciones y se encuentran dentro de los estados y municipios que contempla la resolución
            mediante
            el cual se otorga la protección prevista a la denominación de origen Mezcal,para ser aplicada a la bebida
            alcohólica
            del mismo nombre, publicada el 28 de noviembre de 1994, así como sus modificaciones subsecuentes.
        </p>
        <br>
        <div>
            <p class="textx">
                <strong>AUTORIZÓ</strong>
                <span style="margin-left: 54px; display: inline-block; text-align: center; position: relative;">
                    <strong>{{ $datos->firmante->puesto ?? '' }} | {{ $datos->firmante->name ?? '' }}</strong>
                    {{-- <strong>Gerente Técnico Sustituto de la Unidad de Inspección | Juana Karen Velázquez
                        Sánchez</strong> --}}
                </span>
            </p>
            <p class="textx">
                <strong>CADENA ORIGINAL</strong>
                <span style="margin-left: 14px;">
                    <strong>UMC-102/2025|2025-07-03|UMS-0593/2025</strong>
                </span>
            </p>
            <p class="textx">
                <strong>SELLO DIGITAL</strong>
            </p>
            <p class="textsello">
                X+FJsmqH0mqd7HIO9qbD+1Jt/7nM2XETteB+EVdPeMD9xip5joKOUE1yJzzBSwvraL878G/Umvi06/1/bVVZyFO1LCP53AfSlhYsvN/APhk4Fax7GSk6EK/EEmvM4LzDc0
                Oziy6AJRM48u3hi3uPtEc0yVSzQH3AbkG8diWo7pzzx6xAA3WzKc67CR4FTiBJNpdtQhgjv/CnxPlv2U1lwQQtRLEnJfBejxUbC303bSB+m10tT4SfjCYeAKBUUUtSy+HH
                GNrRawUUkJO5iWp6RBdHMuKrpriq4oOGgaeGEcRL1WujGV1Xi9C5rSHmZl9kxji+CbtY1gE9eekydqt0CA== <br>
                C.c.p. Dirección General de Normas, DGN.<br>
                C.c.p. Gerente del Organismo Certificador del CIDAM A.C.<br>
                C.c.p. Expediente de la Unidad de Verificación del UMSNH.
            </p>

        </div>
       

        <p class="pie">
            @if ($id_sustituye)
                Este dictamen sustituye al: {{ $id_sustituye }}
            @endif
            <br>Entrada en vigor: 22-06-2024
            <br>F-UV-02-04 Ver 9.
        </p>

    </div>



</body>

</html>