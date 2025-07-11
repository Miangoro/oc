<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento NOM de Mezcal Envasado</title>
    <style>
    @page {
        size: 227mm 292mm; /*Tamaño carta*/
        margin: 30px 60px 30px 60px;  /*márgenes (arriba, derecha, abajo, izquierda) */
    }
    /*@font-face {
        font-family: 'fuenteNegrita';
        src: url('{{ storage_path('fonts/LSANSD.ttf') }}');
    }*/

    body {/*ajustes generales*/
        font-family: 'calibri';
        font-size: 14px;
        line-height: 0.9;/*interlineado*/
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
        vertical-align: top;/*alinear verticalmente el contenido en la parte superior de inline-block*/
    }
    .encabezado p {
        display: inline-block;/*coloca elementos en línea horizontalmente*/
        margin-top: 6%;
        text-align: right;
        font-family: 'fuenteNegrita';
        font-size: 28px;
        line-height: 1;
    }


    .footer {
        position: fixed;/*lo fija en pantalla*/
        bottom: -30px; 
        left: -60px;
        right: -60px;
        padding-bottom: 5px;
        background-color: #158F60;
        color: white;/*color letra*/
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

    td, th {
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

<img class="fondo" src="{{ public_path('img_pdf/fondo_dictamen.png') }}"  alt="Fondo agave">


<div class="encabezado">
    <img src="{{ public_path('img_pdf/logo_uvem.png') }}" alt="Logo">
    <p>Universidad Michoacana de San <br>Nicolás de Hidalgo</p>
</div>

<div class="footer">
    <p style="font-family: Lucida Sans Seminegrita;">www.cidam.org . unidadverificacion@cidam.org</p>
    <p style="font-family: Lucida Sans Unicode; font-size: 10px;">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
</div> 



<div class="contenido">

    <p style="text-align: center; padding-left: 40px; padding-right: 40px;">La Unidad de Inspección de mezcal de la Universidad Michoacana de San Nicolás de Hidalgo, con
        domicilio en Francisco J. Múgica s/n, Col. Felícitas del Río, Morelia, Michoacán; acreditada como Unidad
        de Inspeccióntipo A con acreditación No. UVNOM-129, por la entidad mexicana de acreditación, a.c.
    </p>

    <p style="text-align: center; font-size:26px; font-family:Lucida Sans Seminegrita; padding-top:6px;"><b>DICTAMEN DE CUMPLIMIENTO NOM DE<br>MEZCAL ENVASADO</b></p>
    
 
<div class="subtitulos" style="color: #003300;">I. Datos de la empresa</div>
<table cellpadding="5" cellspacing="3">
    <tr>
        <td class="bold" width="100">Nombre de la Empresa</td>
        <td colspan="3">AMANTES DEL MEZCAL S.A. DE C.V.</td>
    </tr>
    <tr>
        <td class="bold">Representante legal</td>
        <td>Francisco Arrañaga Patrón</td>
        <td class="bold">Número de dictamen</td>
        <td>UME-134/2025</td>
    </tr>
    <tr>
        <td class="bold">Dirección</td>
        <td>
            <strong>Domicilio Fiscal:</strong> Av. Ferrocarril Número exterior 69, Número interior Bis. San Sebastián Tutla, Oaxaca De Juárez, Oaxaca. C.P. 71320.<br>
            <strong>Domicilio de Instalaciones:</strong> Lib. 5 Señores No. 915, Carretera Internacional, Tlalixtac De Cabrera, C.P. 68270, Tlalixtac De Cabrera, Oaxaca.
        </td>
        <td class="bold">Fecha de emisión</td>
        <td>02/Julio/2025</td>
    </tr>
    <tr>
        <td class="bold">RFC</td>
        <td>AME1906138K7</td>
        <td class="bold">Fecha de vencimiento</td>
        <td>Indefinido</td>
    </tr>
    <tr>
        <td class="bold">No. de servicio</td>
        <td>UMS-0785/2025</td>
        <td class="bold">Fecha de servicio</td>
        <td>26/Junio/2025</td>
    </tr>
</table>

<div class="subtitulos" style="color: #003300;">II. Descripción del producto</div>
<table cellpadding="5" cellspacing="3">
    <tr>
        <td colspan="6" class="subtitulos" style="text-align: center">
            PRODUCTO --<br>ORIGEN --
        </td>
    </tr>
    <tr>
        <td class="bold">Categoría y clase</td>
        <td>Mezcal Artesanal Reposado</td>
        <td class="bold" rowspan="2">No. de lote de envasado</td>
        <td rowspan="2">001-25AM</td>
        <td class="bold" rowspan="2">No. de botellas</td>
        <td rowspan="2">10740</td>
    </tr>
    <tr>
        <td class="bold">Ingredientes</td>
        <td>----</td>
    </tr>
    <tr>
        <td class="bold">Edad<br>(Exclusivo clase añejo)</td>
        <td>5 Meses</td>
        <td class="bold">No. de lote a granel</td>
        <td>AM-11CR</td>
        <td class="bold">No. de análisis</td>
        <td>NNMZ-46384, NNMZ-50938</td>
    </tr>
    <tr>
        <td class="bold">Presentación</td>
        <td>375 mL</td>
        <td class="bold">Volumen del lote</td>
        <td>4027.5</td>
        <td class="bold">Contenido alcohólico</td>
        <td>35.09% Alc. Vol.</td>
    </tr>
    <tr>
        <td class="bold">Tipo de maguey</td>
        <td colspan="2">Maguey Espadín (A. angustifolia)</td>
        <td class="bold">Marca</td>
        <td colspan="2">CREYENTE</td>
    </tr>
</table>

<p style="margin: 0 30px;"><!--orden: top right bottom left; equivale top:0; bottom:0; left:30; right:30; -->
Este dictamen de cumplimiento de lote de mezcal envasado se expide de acuerdo a la Norma Oficial Mexicana
NOM-070-SCFI-2016. Bebidas alcohólicas –mezcal-especificaciones
</p>





<!--FIRMA DIGITAL-->
<div class="firma" style="width: 75%; border-bottom: 2px solid #23b850; display: flex;">
    @php
        use Illuminate\Support\Facades\Storage;
        /* $firma = $data->firmante->firma ?? null;
        $firmaPath = $firma ? 'firmas/' . $firma : null; */
    @endphp
    <img  style="margin-right:30px" src="{{ public_path('img_pdf/sello_uvem.png') }}" alt="Sello Uvem" width="110px" height="100px">

    <p style="display: inline-block; text-align:center; padding-top: 10px;">
        QFB. Mario Villanueva Flores<br>
        Gerente Técnico Sustituto de la Unidad de Inspección
    </p>

</div>







    <p class="leyenda">
        @if ($id_sustituye)
        Este dictamen sustituye al: {{ $id_sustituye }}
        @endif
        <br>F-UV-04-17 Versión 4
        <br>Entrada en vigor: 08-11-2021
    </p>
</div>






    



</body>
</html>
