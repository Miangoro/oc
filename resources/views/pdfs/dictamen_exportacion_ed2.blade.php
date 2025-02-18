<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento para Producto de Exportación</title>
    <style>
        @page {
            margin-top: 30;
            margin-right: 80px;
            margin-left: 80px;
            margin-bottom: 3px;
        }

        @font-face {
            font-family: 'Lucida Sans Unicode';
            src: url('fonts/lsansuni.ttf') format('truetype');
        }

        @font-face {
            font-family: 'Lucida Sans Seminegrita';
            src: url('fonts/LSANSD.ttf') format('truetype');
        }

        @font-face {
            font-family: 'Arial Negrita';
            src: url('fonts/arial-negrita.ttf') format('truetype');
        }

        .negrita {
            font-family: 'Arial Negrita';
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            padding-right: 4px;
            padding-left: 4px;
            ;
        }

        .leftLetter {
            text-align: left;
        }

        .rightLetter {
            text-align: right;
        }

        .letter-color {
            color: black;
            text-align: center;
            margin-left: 0;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            border: 2px solid black;
            padding-top: 8px;
            padding-bottom: 8px;
            text-align: center;
            font-size: 11px;
        }

        th {
            background-color: #608390;
            color: white;
            text-align: center;
            font-size: 11px;
        }

        .td-margins {
            border-bottom: 1px solid #366091;
            border-top: 1px solid #366091;
            border-right: none;
            border-left: none;
            font-size: 11px;
        }

        .td-margins-none {
            border-bottom: 1px solid #366091;
            border-top: none;
            border-right: none;
            border-left: none;
            font-size: 11px;
        }

        .td-no-margins {
            border: none;
        }

        .td-barra {
            border-bottom: none;
            border-top: none;
            border-right: none;
            border-left: 1px solid black;
        }

        .titulos {
            font-size: 22px;
            line-height: 0.9;
            padding: 10px;
            text-align: center;
            font-family: 'Arial Negrita';
        }

        .titutlos-footer {
            font-size: 16px;
            text-align: center;
            padding: 10px;
        }

        .footer-bar {
            position: absolute;
            bottom: -10px;
            left: -80px;
            right: -80px;
            width: calc(100% - 40px);
            height: 45px;
            background-color: #158F60;
            color: white;
            font-size: 10px;
            text-align: center;
            padding: 10px 0px;
            vertical-align: top;
            padding-top: 0;
            padding-bottom: 19px;
        }

        .pie {
            position: absolute;
            /* Mueve el elemento 50px en X y 50px en Y */
            text-align: right;
            font-size: 10px;
        }

        .page-break {
            page-break-before: always;
        }

        .sello {
            text-align: right;
            font-size: 11px;
            margin: 0;
            padding: 0;
            position: absolute;
            right: 50px;
            top: 825px;
            font-family: 'Arial Negrita' !important;
        }

        .textx, .textsello {
            line-height: 1.2;
            font-family: Arial, Helvetica, Verdana;
        }

        .textsello {
            text-align: left;
            font-size: 8px;
            margin: 0;
            padding: 0;
        }

        .images-container {
            position: relative;
            display: flex;
            margin-top: -40px;
            width: 100%;
        }

        .image-right {
            position: absolute; 
            right: 10px; 
            top: -20px; 
            width: 240px;
        }

        .watermark-cancelado {
            font-family: Arial;
            color: red;
            position: fixed;
            top: 48%;
            left: 45%;
            transform: translate(-50%, -50%) rotate(-45deg) scaleY(1.2);
            opacity: 0.5;
            /* Opacidad predeterminada */
            letter-spacing: 3px;
            font-size: 150px;
            white-space: nowrap;
            z-index:-1;
        }

    </style>
</head>

<body>

    <!-- Aparece la marca de agua solo si la variable 'watermarkText' tiene valor -->
    @if ($watermarkText)
        <div class="watermark-cancelado">
            Cancelado
        </div>
    @endif


    {{-- cabecera --}}
    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}"
        style="width: 270px; float: left; margin-left: -40px; margin-top: -30px;" alt="logo de CIDAM 3D">
    <div class="letter-color" style=" line-height: 0.6; color: #151442">
        <p class="rightLetter" style="font-size: 16px"><span class="negrita">Unidad de Inspección No. UVNOM-129</span>
            <br>
            <span class="negrita rightLetter" style="font-size: 9px"> Centro de Innovación y Desarrollo Agroalimentario
                de Michoacán, A.C. </span><br><span class="rightLetter" style="font-size: 9.5px">Acreditados ante la
                Entidad Mexicana de Acreditación, A.C.</span>
        </p>
    </div>
    <div></div>
    <div class="titulos">
        Dictamen de Cumplimiento para Producto de <br>
        Exportación
    </div>
    <div class="negrita" style="font-size: 14px">PRODUCTO:</div>
    <table>
        <tr>
            <td style="font-size: 15px;padding-bottom: 15px; padding-top: 15px"><b>Fecha de emisión</b></td>
            <td style="width: 130px">{{ $fecha_emision }}</td>
            <td style="font-size: 15px; width: 170px"><b>Número de dictamen:</b></td>
            <td style="width: 130px">{{ $no_dictamen }}</td>
        </tr>
        <tr>
            <td style="font-size: 15px;padding-bottom: 25px; padding-top: 25px"><b>Razón social</b></td>
            <td>{{ $empresa }}</td>
            <td style="font-size: 15px"><b>Domicilio fiscal</b></td>
            <td>{{$domicilio}}</td>
        </tr>
        <tr>
            <td style="font-size: 15px; padding-bottom: 15px; padding-top: 15px"><b>RFC</b></td>
            <td>{{$rfc}}</td>
            <td style="font-size: 15px"><b>Contraseña NOM</b></td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <div style="height: 20px"></div>
    <div style="font-size: 14px; text-align: justify;">
        Con fundamento en los artículos 53, 54, 55, 56, 57 y 69 de la Ley de Infraestructura de la Calidad, la
        Norma Oficial Mexicana NOM-070-SCFI-2016, Bebidas alcohólicas-Mezcal- Especificaciones y el
        apartado 7.4 de la Norma Mexicana NMX-EC-17020-INMC-2014 “Evaluación de la conformidadRequisitos para el
        funcionamiento de diferentes tipos de unidades (organismos) que realizan la verificación
        (Inspección)”; la Unidad de Inspección CIDAM A.C. con domicilio en Kilómetro 8 Antigua Carretera a
        Pátzcuaro, S/N Colonia Otra no Especificada en el Catálogo, C.P. 58341, Morelia, Michoacán.con número
        de acreditación UVNOM 129 ante la Entidad Mexicana de Acreditación A.C. y debidamente aprobada por
        la Dirección General de Normas de la Secretaría de Economía.
    </div>
    <div style="font-size: 14px; text-align: justify;padding-bottom: 20px; padding-top: 20px">El producto tiene como
        destino la <b> venta de exportación</b> a:
    </div>

    <table>
        <tr>
            <td style="font-size: 15px; width: 160px; padding-bottom: 15px; padding-top: 15px"><b>Importador</b></td>
            <td style="width: 160px"></td>
            <td style="font-size: 15px; width: 120px"><b>Dirección</b></td>
            <td style="width: 180px"></td>
        </tr>
        <tr>
            <td style="font-size: 15px"><b>País de destino</b></td>
            <td></td>
            <td style="font-size: 15px" rowspan="2"><b>Aduana de <br>
                    salida</b></td>
            <td rowspan="2"></td>
        </tr>
        <tr>
            <td style="font-size: 15px"><b>RFC</b></td>
            <td></td>
        </tr>
    </table>
    <div class="pie" style="transform: translate(520px, 245px);">Entrada en vigor: 15-07-2024 <br>
        F-UV-04-18 Ver 2s</div>
    <div class="footer-bar" style="line-height: 0.7;">
        <p class="font-lucida-sans-seminegrita" style="font-size: 11px"><b>www.cidam.org .
                unidadverificacion@cidam.org</b></p>
        <p style="font-size: 12px">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el
            catálogo C.P. 58341. Morelia Michoacán</p>
    </div>

    {{-- Segunda hoja --}}
    <div class="page-break"></div>
    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}"
        style="width: 270px; float: left; margin-left: -40px; margin-top: -30px;" alt="logo de CIDAM 3D">
    <div class="letter-color" style=" line-height: 0.6; color: #151442">
        <p class="rightLetter" style="font-size: 16px"><span class="negrita">Unidad de Inspección No. UVNOM-129</span>
            <br>
            <span class="negrita rightLetter" style="font-size: 9px"> Centro de Innovación y Desarrollo Agroalimentario
                de Michoacán, A.C. </span><br><span class="rightLetter" style="font-size: 9.5px">Acreditados ante la
                Entidad Mexicana de Acreditación, A.C.</span>
        </p>
    </div>
    <table>
        <tr>
            <td style="font-size: 15px; padding-bottom: 15px; padding-top: 15px; width: 90px"><b>Identificación</b></td>
            <td style="width: 90px"></td>
            <td style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 90px"><b>Marca</b></td>
            <td style="width: 90px"></td>
            <td style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 90px"><b>Producto</b></td>
            <td style="width: 90px"></td>
        </tr>
        <tr>
            <td style="font-size: 15px;padding-bottom: 0; padding-top: 0;"><b>Categoría</b></td>
            <td></td>
            <td style="font-size: 15px;padding-bottom: 0; padding-top: 0;"><b>Clase</b></td>
            <td></td>
            <td style="font-size: 15px;padding-bottom: 0; padding-top: 0;"><b>% Alc. Vol. <br>
                    (etiqueta)</b></td>
            <td></td>
        </tr>
        <tr>
            <td style="font-size: 15px;"><b>Cont. Net. <br>
                    (mL)</b></td>
            <td></td>
            <td style="font-size: 15px;"><b>No. Botellas</b></td>
            <td></td>
            <td style="font-size: 15px;"><b>No. Cajas</b></td>
            <td></td>
        </tr>
        <tr>
            <td class="leftLetter" style="font-size: 15px;padding-bottom: 0; padding-top: 0;" colspan="6"><b>No. de
                    Certificado</b></td>
        </tr>
        <tr>
            <td style="font-size: 15px;"><b>Lote de <br>
                    Envasado</b></td>
            <td></td>
            <td style="font-size: 15px;"><b>Estado <br>
                    Productor</b></td>
            <td></td>
            <td style="font-size: 15px;"><b>Lote a <br>
                    granel</b></td>
            <td></td>
        </tr>
        <tr>
            <td style="font-size: 15px;"><b>No. Análisis</b></td>
            <td></td>
            <td style="font-size: 15px;"><b>% Alc. Vol.
                    (No. análisis)</b></td>
            <td></td>
            <td style="font-size: 15px;" rowspan="2"><b>Especie de
                    agave o
                    maguey</b></td>
            <td style="font-size: 15px;" rowspan="2"></td>
        </tr>
        <tr>
            <td style="font-size: 15px;"><b>Ingrediente</b></td>
            <td></td>
            <td style="font-size: 15px;"><b>Sellos</b></td>
            <td></td>

        </tr>
    </table>
    <div style="height: 15px"></div>
    <div>OBSERVACIONES:
    </div>
    <div style="height: 30px"></div>

    <div class="negrita" style="text-align: center; font-size: 10px ;line-height: 0.9">
        _____________________________________________<br>
        QFB. Mario Villanueva Flores <br>
        Gerente Técnico Sustituto de la Unidad de Inspección
    </div>





    <div style="height: 30px"></div>


    <p class="negrita" style="transform: translate(450px, 80px); font-size: 10px">Sello de Unidad de Inspección</p>
    <div class="images-container">
    <img src="{{ public_path('img_pdf/qr_umc-074.png') }}" alt="Logo UVEM" width="70px">
    <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Imagen derecha" class="image-right">
    </div>
    <p class="textx" style="font-size: 12px; margin: 1;">
    <span style="margin-left: -30px;">
        <strong>Cadena Original UMG-159/2024|2024-06-26|UMS- <br><span style="margin-left: -30px;">1094/2024 Sello Digital</span></strong>
    </span>
    </p>

<div style="height: 15px"></div>
    <p class = "textsello" style="margin-left: -30px;">e2N1P+r+E79e0YxKzS/jMssKuASlmYXy2ppP+2PJN8vKUeFRxYTSY99MEWrgiHOnA N3pLUrdUBiD39v25Y648G4TK5qQ0LwZPLofRmjRQ2Ty5rHlDwnPRm37zaOkMjkRD<br>
    xC0ikyHPD+T3EFhEc9sgAFI6bZUd88yevfS+ZFZ7j9f5EA44Sz76jsN3P4e7lyePHmNz Jxg5ZupHICg5xBZu5ygOniMZNbzG6w0ZDPL58yoMQK1JDi8lwwiGJBaCNHN6krn<br>
    No5v5rvZPkbUthYT2r5M0sGP5Y+s97oLa8GA5hqyDAgE9P0d1u0uwU7Q8SF0GYfe lavijxvsWaZg5QA5og==
    </p>


    <div class="pie" style="transform: translate(520px, 250px);">Entrada en vigor: 15-07-2024 <br>
        F-UV-04-18 Ver 2s</div>
    <div class="footer-bar" style="line-height: 0.7;">
        <p class="font-lucida-sans-seminegrita" style="font-size: 11px"><b>www.cidam.org .
                unidadverificacion@cidam.org</b></p>
        <p style="font-size: 12px">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el
            catálogo C.P. 58341. Morelia Michoacán</p>
    </div>
</body>

</html>
