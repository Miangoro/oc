<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento NOM Mezcal a Granel</title>
    <style>
    @page {
        size: 227mm 292mm; /*Tamaño carta*/
        margin: 30px 60px 30px 60px;  /*márgenes (arriba, derecha, abajo, izquierda) */
    }

    body {/*ajustes generales*/
        font-family: 'calibri';
        font-size: 15px;
        line-height: 0.9;/*interlineado*/
        text-align: justify
    }*/

    .encabezado {
        /* border: 2px solid blue; */
        position: fixed;
    }
 
    .header-text {
        display: inline-block;/*coloca elementos en línea horizontalmente*/
        color: #151442;
        padding-left: 150px;
        line-height: 0.7;
    }
    .header-text p {
        margin: 2px;
        text-align: center;
    }


    /*pie de pagina*/
    .footer {
        /*border: 2px solid blue;*/
        position: fixed;/*lo fija en pantalla*/
        left: -60px;
        right: -60px;
        bottom: -30px;
    }
    .footer p{
        margin: 0px 60px 4px 0px; /*arriba, derecha, abajo, izquierda*/
        font-size: 10px;
        line-height: 0.8;
    } 
    .leyenda{
        text-align: right;
        font-family: 'Lucida Sans Unicode';
    }
    .footer-text {
        text-align: center;
        background-color: #158F60;
        padding: 6px;
        color: rgb(248, 248, 248);
    }



    .contenido {
        margin-top: 13%;
    }

    </style>
</head>

<body>

{{-- <img class="fondo" src="{{ public_path('img_pdf/fondo_dictamen.png') }}"  alt="Fondo agave"> --}}

<div class="encabezado">
    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="width: 250px; height: 98px;" alt="Logo UI">
    <div class="header-text">
        <p style="font-size: 16px; font-family: 'Arial Negrita', Gadget, sans-serif;">Unidad de Inspección No.<br>UVNOM-129</p>
        <p style="font-size: 11px; font-family: 'Arial Negrita', Gadget, sans-serif;">Centro de Innovación y Desarrollo Agroalimentario de<br>Michoacán, A.C.</p>
        <p style="font-size: 11px; font-family: sans-serif;">Acreditados ante la Entidad Mexicana de Acreditación, A.C.</p>
    </div>
</div>


<div class="footer">
    <p class="leyenda">
        @if ($id_sustituye)
        Este dictamen sustituye al: {{ $id_sustituye }}
        @endif
        <br>F-UV-04-16 Versión 6 Página 1 de 1
        <br>Entrada en vigor: 03-09-2022
    </p>
    <div class="footer-text">
        <p style="font-family: Lucida Sans Seminegrita;">www.cidam.org . unidadverificacion@cidam.org</p>
        <p style="font-family: Lucida Sans Unicode;">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
    </div>
</div> 






<div class="contenido">

 


    

</div>








</body>
</html>
