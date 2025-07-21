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

    .texto-centrado {
    text-align: center;
   line-height: 0.75;
    font-size: 16px;
     
}
.linea1 {
    margin-left: 65px;
    margin-right: 65px;
    text-align: center;
    font-size: 16px;
 
margin-bottom: 0;
}

.linea2 {
    margin-left: 62px;
    margin-right: 62px;
    text-align: center;
    font-size: 16px;
margin-top: 0;
margin-bottom: 0;
}

.linea3 {
    margin-left: 53px;
    margin-right: 53px;
    text-align: center;
    font-size: 16px;
   margin-top: 0;
margin-bottom: 0;
}

.linea4 {
    text-align: center;
    font-size: 16px;
  margin-top: 0;
margin-bottom: 0;
}
.titulop1{
    text-align: center;
     font-weight: bold;
     font-size: 25px;
     margin-left: 95px;
    margin-right: 95px;
    margin-bottom: 0;
}
.titulop2{
    text-align: center;
     font-weight: bold;
     font-size: 25px;
     margin-left: 90px;
    margin-right: 90px;
     margin-top: 0; 
}
 /* Tabla de datos */
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }
     /* Definición de anchos por columna */
    table col:nth-child(1) { width: 15%; }
    table col:nth-child(2) { width: 6%; }
    table col:nth-child(3) { width: 6%; }
    table col:nth-child(4) { width: 25%; }
    table col:nth-child(5) { width: 24%; }
    table col:nth-child(6) { width: 24%; }


    table td {
      border: 1px solid #000;
      padding: 4px;
      vertical-align: middle;
    }
    .celda-azul {
      font-weight: bold;
      color: #003399;
      text-align: center;
    }
    .celda-normal {
      text-align: center;
       font-weight: bold;
    }
    .centrado {
      text-align: center;
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

 

 <div class="texto-centrado">
     <p class="linea1">La Unidad de Inspección de mezcal de la Universidad Michoacana de San Nicolás de Hidalgo,</p>
        <p class="linea2">con domicilio en Francisco J. Múgica s/n, Col. Felícitas del Río, Morelia, Michoacán; acreditada</p>
        <p class="linea3">como Unidad de Inspección tipo A con acreditación No. UVNOM-129, por la entidad mexicana de </p>
   <p class="linea4">acreditación, A.C.</p>
</div>

<p class="titulop1"> DICTAMEN DE CUMPLIMIENTO NOM DE</p>
 <p class="titulop2">MEZCAL A GRANEL</p>


<h3 style=" font-weight: bold; font-size: 15px;">I. Datos de la empresa</h3>


      <table>
      <colgroup>
        <col><col><col><col><col><col>
      </colgroup>

      <!-- Fila 1 -->
      <tr>
        <td colspan="2" class="celda-azul">Nombre de la Empresa</td>
        <td colspan="4" class="celda-normal">AMANTES DEL MEZCAL, S.A. DE C.V.</td>
      </tr>

      <!-- Fila 2 -->
      <tr>
        <td rowspan="3" class="celda-azul">Dirección</td>
        <td colspan="1" rowspan="3" class="centrado">
          <strong>Domicilio Fiscal:</strong> Av. Ferrocarril
 <br>Número exterior 69, Número
 <br>interior Bis. San Sebastián Tutla,
 <br>Oaxaca De Juárez, Oaxaca. C.P.
 <br>71320.<br>
          <strong>Domicilio de Instalaciones:</strong> <br>
          Paraje Salina Grande, S/N,<br> Tlacolula de Matamoros, Oaxaca. <br> C.P. 70400
        </td>
        <td class="celda-azul">RFC</td>
        <td colspan="3" class="celda-normal">AME1906138K7</td>
      </tr>

      <!-- Fila 3 -->
      <tr>
        <td rowspan="2" class="celda-azul">Representante legal</td>
        <td colspan="3" rowspan="2" class="celda-normal">Francisco Arrañaga Patrón</td>
      </tr>

      <!-- Fila 4 (vacía, consumida por rowspan) -->
      <tr></tr>

      <!-- Fila 5 -->
      <tr>
        <td class="celda-azul">No. de servicio</td>
        <td  class="celda-normal">UMS-0811/2025</td>
        <td class="celda-azul">Número de dictamen</td>
        <td colspan="3" class="celda-normal">UMG-153/2025</td>
      </tr>

      <!-- Fila 6 -->
      <tr>
        <td class="celda-azul">Nombre del inspector</td>
        <td class="celda-normal">Idalia González Zárate</td>
        <td class="celda-azul">Fecha de servicio</td>
        <td colspan="3" class="celda-normal">02/Julio/2025</td>
      </tr>

      <!-- Fila 7 -->
      <tr>
        <td class="celda-azul">Fecha de emisión</td>
        <td  class="celda-normal">03/Julio/2025</td>
        <td class="celda-azul">Fecha de vencimiento</td>
        <td colspan="3" class="celda-normal">03/Julio/2026</td>
      </tr>
    </table>

<h3 style=" font-weight: bold; font-size: 15px;">I. Datos de la empresa</h3>
<table>
<tr>
  <td colspan="6" class="celda-normal">PRODUCTO MEZCAL ARTESANAL <br> ORIGEN OAXACA</td>         
</tr>

<tr>
    <td class="celda-azul"> Categoría y Clase</td>
<td  class="celda-normal">Mezcal Artesanal clase <br> Blanco o Joven</td>
    <td class="celda-azul"> No de lote a granel</td>
<td  class="celda-normal">2507ESVCAM</td>
    <td class="celda-azul"> No. de análisis</td>
    <td  class="celda-normal">NNMZ-51195</td>
</tr>

<tr>
    <td class="celda-azul">Ingredientes</td>
<td  class="celda-normal">---</td>
    <td class="celda-azul">  Volumen de lote</td>
<td  class="celda-normal">151837 L</td>
    <td class="celda-azul">  Contenido <br> Alcohólico</td>
    <td  class="celda-normal">48.96% Alc.Vol.</td>
</tr>

<tr>
    <td class="celda-azul">Edad</td>
<td  class="celda-normal">---</td>
    <td colspan="2" class="celda-azul">  Tipo de Maguey </td>
<td colspan="2" class="celda-normal"><br> Maguey Espadín (A. angustifolia)</td>   
</tr>

</table>



</div>











</body>
</html>
