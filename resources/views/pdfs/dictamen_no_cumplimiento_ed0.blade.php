<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de No Cumplimiento</title>
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
        text-align: justify
    }

    /*.fondo {
        position: fixed;
        top: 30%;
        left: 130px;
        width: 500px;
        height: 440px;
        opacity: 0.2;
    }*/

    .encabezado {
        position: fixed;
        /*width: 100%; 
        border: 2px solid blue;
        top: -14px;*/
    }
    /*.encabezado img {
        width: 110px; 
        height: 100px;
        vertical-align: top;/*alinear verticalmente el contenido en la parte superior de inline-block
    }*/
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

    

    /*falta*/
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
        margin-top: 13%;
        /*margin-left: 30px;
        margin-right: 20px;*/
    }

    

    


     /*inicia firma digital DIV*/
    .firma {
        position: relative;
        width: 100%;
        /*vertical-align: bottom;*/
    }
    



    /*tabla*/
    
    table {
        color: #000000;
    }
    td, th {
        border: solid #003300;
    }
    .bold{
        text-align: center;
        color: rgb(19, 117, 230);
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
    <p style="font-family: Lucida Sans Seminegrita;">www.cidam.org . unidadverificacion@cidam.org</p>
    <p style="font-family: Lucida Sans Unicode; font-size: 10px;">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
</div> 



<div class="contenido">

    <p style="text-align: center; font-size:26px; font-family:'Arial Negrita', Gadget, sans-serif; padding-top:6px;"><b>Dictamen de No Cumplimiento</b></p>
 

    <p>No.: <b></b></p>


    <div style="text-align: center; font-weight: bold">
        <p style="display: inline-block;">Instalaciones ( ) </p>
        <p style="display: inline-block; padding: 0 10%">Lote de mezcal a granel ( ) </p><!--orden: top right bottom left; equivale top:0; bottom:0; left:10%; right:10%; -->
        <p style="display: inline-block;">Envasado ( )</p>
    </div>

    <p style="font-size: 16px">De acuerdo con lo establecido en los procedimientos internos de la Unidad de Inspección
No. UVNOM 129 para la revisión de procesos de producción del producto Mezcal, su
envasado y comercialización; y con fundamento en los artículos 56 Fracción I y 60 fracción I
de la Ley de Infraestructura de la Calidad que establece el funcionamiento de las Unidades
de Inspección.</p>


<div style="color: #003300;">I. Datos de la empresa</div>
<table>
    <tr>
        <td class="bold">Nombre de la Empresa</td>
        <td colspan="3">AMANTES DEL MEZCAL S.A. DE C.V.</td>
    </tr>
    <tr>
        <td class="bold" rowspan="2">Dirección</td>
        <td rowspan="2">
            <strong>Domicilio Fiscal:</strong> Av. Ferrocarril Número exterior 69, Número interior Bis. San Sebastián Tutla, Oaxaca De Juárez, Oaxaca. C.P. 71320.<br>
            <strong>Domicilio de Instalaciones:</strong> Lib. 5 Señores No. 915, Carretera Internacional, Tlalixtac De Cabrera, C.P. 68270, Tlalixtac De Cabrera, Oaxaca.
        </td>
        <td class="bold">RFC</td>
        <td>AME1906138K7</td>
    </tr>
    <tr>
        <td class="bold">Representante legal</td>
        <td>Francisco Arrañaga Patrón</td>
    </tr>
    <tr>
        <td class="bold">No. de servicio</td>
        <td>UMS-0785/2025</td>
        <td class="bold">Fecha de servicio</td>
        <td>26/Junio/2025</td>
    </tr>
    <tr>
        <td class="bold">Nombre del inspector</td>
        <td></td>
        <td class="bold">Fecha de emisión</td>
        <td></td>
    </tr>
</table>



<p style="margin: 0 30px;"><!--orden: top right bottom left; equivale top:0; bottom:0; left:30; right:30; -->
Este dictamen de cumplimiento de lote de mezcal envasado se expide de acuerdo a la Norma Oficial Mexicana
NOM-070-SCFI-2016. Bebidas alcohólicas –mezcal-especificaciones
</p>








    <p class="leyenda">
        {{-- @if ($id_sustituye)
        Este dictamen sustituye al: {{ $id_sustituye }}
        @endif --}}
        <br>F-UV-04-17 Versión 4
        <br>Entrada en vigor: 08-11-2021
    </p>
</div>






    



</body>
</html>
