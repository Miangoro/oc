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
      border-collapse: separate;
      font-size: 12px;
      border: 2px solid #000
    }

    table td {
      border: 1px solid #000;
      padding: 4px;
      vertical-align: middle;
      border: 2px solid #000;
    }
    .celda-azul {
      color: #17365D;
      text-align: center;
      font-weight: bold;
      line-height: 1.5;
    }
    .celda-normal {
      text-align: center;
       font-weight: bold;
    }
    .centrado {
      text-align: center;
      font-size: 14px;
      line-height: .8;
    }
    .bloque-autorizacion {
  margin-top: 30px;
  line-height: 1.5;
}

.autorizado {
  font-size: 9px;
  font-weight: bold;
  font-family: 'Calibri', sans-serif;
  color: #000000;
}
.ccp{
   line-height: 1;
   font-size: 11px;
}
 .negrita{
            font-family: 'fuenteNegrita';
            font-size: 14px;
        }
         /* Estilo para la tabla */
        table.datos_empresa {
            text-align: center;
            border-collapse: separate;
           
            width: 100%;
            /* Opcional: hace que la tabla ocupe todo el ancho disponible */
        }

        /* Estilo para las celdas de la tabla */
        table.datos_empresa td {
            border: 2px solid black;
            /* Ajusta el color y grosor del borde */
            padding: 2px;
            /* Opcional: agrega espacio dentro de las celdas */
        }

  .prueba{
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


<h3 style=" font-weight: bold; font-size: 15px; margin-bottom: 0; margin-left: 25px;">I. Datos de la empresa</h3>

<table class="datos_empresa">
            <tr>
  <td colspan="4">
    <table style="width: 100%; border: none; border-collapse: collapse;">
      <tr>
        <td class="negrita" style="padding-top: 10px; padding-bottom: 10px; text-align: center; color: #17365D; width: 25%; border-top: none; border-left: none; border-bottom: none; border-right: 4px double black;">
  Nombre de la empresa 
</td>

<td style="padding-top: 10px; padding-bottom: 10px; text-align: center; width: 75%; font-size: 16px; font-weight: bold; border-top: none; border-right: none; border-bottom: none; border-left: 4px doubled black;">
  {{ $data->inspeccione->solicitud->empresa->razon_social ?? '' }}
</td>
      </tr>
    </table>
  </td>
</tr>
            <tr>
                <td class="negrita" style="color: #17365D;" rowspan="2">Dirección</td>
                <td rowspan="2" style="width: 25%; font-size: 13px; vertical-align: top;" >
                   <span class="negrita">Domicilio fiscal:</span>  {{ $data->inspeccione->solicitud->empresa->domicilio_fiscal ?? ''}}<br>

                   <span class="negrita">Domicilio de instalaciones:</span> {{ $data->inspeccione->solicitud->instalacion->direccion_completa ?? 'NA' }}

                </td>
                <td class="negrita" style="color: #17365D; width: 17%; height: 20px; vertical-align: middle;">RFC</td>
                <td class="celda-normal" style="width: 25%; height: 20px; vertical-align: middle;">{{  $data->inspeccione->solicitud->empresa->rfc }}</td>
            </tr>
            <tr>
                <td class="negrita" style="color: #17365D;">
                    Representante legal
                </td>
                <td class="celda-normal">{{ $data->inspeccione->solicitud->empresa->representante }}
                </td>
            </tr>
            <tr>
                <td class="negrita" style="color: #17365D; width: 11%;">No. de servicio</td>
                <td class="celda-normal">{{ $data->inspeccione->num_servicio }}</td>
                <td class="negrita" style="color: #17365D;">Número de <br>dictamen</td>
                <td class="celda-normal">{{ $data->num_dictamen }}</td>
            </tr>
            <tr>
                <td class="negrita" style="color: #17365D; width: 11%;">Nombre del Inspector</td>
                <td class="celda-normal">{{ $data->inspeccione->inspector->name }}</td>
                <td class="negrita" style="color: #17365D;">Fecha de <br>servicio</td>
                <td class="celda-normal">{{ $fecha_servicio }}</td>
            </tr>
            <tr>
                <td class="negrita" style="color: #17365D; width: 11%;">Fecha de emisión</td>
                <td class="celda-normal">{{ $fecha_emision }}</td>
                <td class="negrita" style="color: #17365D;">Fecha de <br> vencimiento</td>
                <td class="celda-normal">{{ $fecha_vigencia }}</td>
            </tr>
        </table>

<h3 style=" font-weight: bold; font-size: 15px; margin-bottom: 0; margin-left: 25px;"> II. Descripcioón del producto</h3>
<table>
<tr>
  <td colspan="6" class="celda-normal"><p>PRODUCTO {{ $data->inspeccione->solicitud->lote_granel->categoria->categoria ?? 'NA' }}</p>
                    <p>ORIGEN {{ $estado }}</p></td>         
</tr>

<tr>
    <td class="celda-azul"> Categoría y <br>Clase</td>
<td  class="celda-normal">Mezcal Artesanal clase <br> Blanco o Joven</td>
    <td class="celda-azul"> No de lote a <br>granel</td>
<td  class="celda-normal">2507ESVCAM</td>
    <td class="celda-azul"> No. de <br>análisis</td>
    <td  class="celda-normal">NNMZ-51195</td>
</tr>

<tr>
    <td class="celda-azul">Ingredientes</td>
<td  class="celda-normal">---</td>
    <td class="celda-azul">  Volumen de <br> lote</td>
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

<div class="bloque-autorizacion">
  <div class="autorizado">AUTORIZÓ</div>
  <div class="autorizado">Cadena Original</div>
  <div class="autorizado">Sello Digital</div>
</div>

<p class="ccp"> C.c.p Dirección General de Normas, DGN. <br>
C.c.p Gerente del Organismo Certificador del CIDAM A.C. </p>

</div>











</body>
</html>
