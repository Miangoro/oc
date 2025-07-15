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
            margin-top: 15%;
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



        /*tabla*/
        table {
            border: 1px solid #003300;
            width: 100%;
            color: #000000;
        }

        td,
        th {
            border: 1px solid #003300;
            /* padding: 5px 8px; 
        line-height: 1.2;*/
            vertical-align: top;
        }

        th {
            font-weight: bold;
            text-align: left;
        }

        .bold {
            font-weight: bold;
        }

        .subtitulos {
            font-size: 16px;
            margin-top: 1em;
            margin-bottom: 0.3em;
            padding-left: 1em;
            font-weight: bold;
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
        <div class="textimg negrita">No.: </div>
        <div class="title"> Constancia de cumplimiento con la NOM-070-SCFI-2016 <br> como</div>
        <div class="title2">Producto de Mezcal </div>
        <div class="text">
            <p>De acuerdo a lo establecido en los procedimientos internos de la Unidad de Inspección No. UVNOM 129 para
                la revisión de procesos de producción del producto Mezcal, su envasado y comercialización; y con
                fundamento
                en los artículos 56 Fracción I y 60 fracción I de la Ley de Infraestructura de la Calidad que establece
                el
                funcionamiento de las Unidades de Inspección.</p>
            <p>Después de realizar la inspección de las instalaciones en fecha del <u><span
                        class="negrita">{{ $fecha_inspeccion }}</span></u> partiendo del acta
                circunstanciada o número de inspección: <u><span
                        class="negrita">{{ $datos->inspeccione->num_servicio ?? '' }}</u></span></p>
            <p class="textp">Nombre del productor/empresa:
                <u>{{ $datos->inspeccione->solicitud->empresa->razon_social ?? '' }}</u></p>
        </div>

        <div class="textimg negrita">A:</div>
        <p class="textp"><u>{{ $datos->inspeccione->solicitud->empresa->razon_social ?? '' }}</u></p>

        <table class="interlineado">
            <tbody>
                <tr>
                    <td>
                        <span class="negrita">Domicilio Fiscal:</span>
                    </td>

                    <td style="text-align: center; vertical-align: middle;">
                        {{ $datos->inspeccione->solicitud->empresa->domicilio_fiscal ?? '' }}</td>
                </tr>
                <tr>
                    <td>
                        <span class="negrita">Domicilio de la unidad de producción:</span>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        {{ $datos->instalaciones->direccion_completa ?? '' }}</td>
                </tr>
                <tr>
                    <td>
                        <span class="negrita">Categorías de mezcal:</span>
                    </td>
                    <td style="text-align: center; vertical-align: middle;"></td>
                </tr>
                <tr>
                    <td>
                        <span class="negrita">Clasesdemezcalqueproduce:</span>
                    </td>
                    <td style="text-align: center; vertical-align: middle;"></td>
                </tr>
                <tr>
                    <td class="negrita">Fecha de emisión de dictamen:</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $fecha_emision }}</td>
                </tr>
                <tr>
                    <td class="negrita">Periodo de vigencia hasta:</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $fecha_vigencia }}</td>
                </tr>
            </tbody>
            </table>
            <p class="text">
                Elpresentedictamenamparaexclusivamentelaproduccióndelproductomezcalqueseelaboraenlasinstalaciones
                referidas en el presente documento. Dichas Instalaciones de producción cuentan con la infraestructura y
                equipamientorequeridoparalaproduccióndemezcal indicadosenlaNOM-070-SCFI-2016,Bebidasalcohólicas
                Mezcal-Especificacionesyseencuentrandentrodelosestadosymunicipiosquecontemplalaresoluciónmediante
                elcualseotorgalaprotecciónprevistaaladenominacióndeorigenMezcal,paraseraplicadaalabebidaalcohólica
                del mismo nombre, publicada el 28 de noviembre de 1994, así como sus modificaciones subsecuentes.
            </p>
          <p class="textx">
        <strong>AUTORIZÓ</strong>
        <span style="margin-left: 54px; display: inline-block; text-align: center; position: relative;">
            <strong>{{ $datos->firmante->puesto ?? '' }} | {{ $datos->firmante->name ?? '' }}</strong>
            {{-- <strong>Gerente Técnico Sustituto de la Unidad de Inspección | Juana Karen Velázquez Sánchez</strong> --}}
        </span>
    </p>
    <p class="textx">
        <strong>CADENA ORIGINAL</strong>
        <span style="margin-left: 14px;">
            <strong></strong>
        </span>
    </p>
    <p class="textx">
        <strong>SELLO DIGITAL</strong>
    </p>
    <p class="textsello">
       
    </p>

    </div>







</body>

</html>