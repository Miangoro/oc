<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento NOM de Comercializador de Mezcal</title>
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
    .numero {
  font-weight: bold;
  margin-bottom: 5px;
  font-size: 18px;
}

.numero span {
  margin-left: 5px;
}

.titulo {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 2px;
}

.subtitulo {
  font-size: 16px;
  font-weight: bold;
}
.bloque-centrado {
  text-align: center;
  margin-bottom: 20px;
  line-height: 1.4;
}

.bloque-centrado .numero,
.bloque-centrado .titulo,
.bloque-centrado .subtitulo,
.bloque-centrado .comercializador {
  margin: 4px 0;
}
.comercializador {
  font-size: 40px;
  color: #a5a5a5; /* gris claro */
  font-weight: bold;
  margin-top: 5px;
  text-align: center;
}
.justificado {
  text-align: justify;
  font-size: 15px;
  line-height: 1;
}
.resaltado {
  font-weight: bold;
  font-size: 16px;
}
.destinatario {
  text-align: center;
  font-size: 25px;
  font-weight: bold;
  color: #1f497c; /* Azul profesional */
  text-transform: uppercase;
  margin-top: 5px;
}
.datos-comercio {
  text-align: justify;
  font-size: 15px;
  line-height: 1;
  margin-top: 10px;
  margin-bottom: 40px;
} 
.resaltado2 {
  font-weight: bold;
  font-size: 15px;
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
 
  <div class="bloque-centrado">
    <div class="numero">No.: </div>
    <div class="titulo">Dictamen de cumplimiento de Instalaciones</div>
    <div class="subtitulo">como</div>
    <div class="comercializador">Comercializador de Mezcal</div>
  </div>
 
  <p class="justificado">De acuerdo a lo establecido en los procedimientos internos de la Unidad de Inspección <span class="resaltado">No.UVNOM129</span> de la
 Universidad Michoacana de San Nicolás de Hidalgo, con domicilio en Francisco J. Múgicas/n Col. Felicitas del
 Rio, Morelia, Michoacán para la revisión de procesos de producción del producto Mezcal, su envasado y
 comercialización; y confundamento en los artículos 56 Fracción I y 60 fracción I de la Ley de Infraestructura de la
 Calidad que establece el funcionamiento de las Unidades de Inspección. Después de realizar la inspección de las
 instalaciones en fecha del <u>10 de Junio del 2025</u> partiendo del acta circunstanciada o número de inspección:
 <u>UMS-0725/2025</u> se otorga el Dictamen de Instalaciones</p>
  <div class="bloque-centrado">
 <div class="numero">A: </div>
 </div>

 <div class="bloque-centrado">
  <div class="destinatario">GAO TAMLEI S.A DE C.V.</div>
</div>

<p class="datos-comercio">
  <span class="resaltado2">Domicilio Fiscal:</span> Gaspar De Villadiego, 117, Nueva Valladolid, Morelia C.P. 58190<br>
  <span class="resaltado2">Domicilio de la unidad de comercialización:</span> Gaspar De Villadiego, 117, Nueva Valladolid, Morelia, Michoacán. C.P. 58190<br>
  <span class="resaltado2">Categorías de mezcal:</span> Mezcal, Mezcal Artesanal, Mezcal Ancestral<br>
  <span class="resaltado2">Clases de mezcal que comercializa: </span>Blanco o Joven, Madurado en Vidrio, Reposado, Añejo, Abocado con, Destilado con<br>
  <span class="resaltado2">Fecha de emisión del dictamen:</span>03 de Julio del 2025<br>
  <span class="resaltado2">Fecha de vigencia del dictamen:</span> 03 de Julio del 2026
</p>


 <p class="justificado">El presente dictamen ampara exclusivamente la comercialización del producto mezcal que se realiza en las
 instalaciones referidas en el presente documento. Dichas Instalaciones de comercialización cuentan con la
 infraestructura y equipamiento requerido  para la comercialización de mezcal indicados en la NOM-070-SCFI-2016,
 Bebidas alcohólicas-Mezcal- Especificaciones. 
</p>


<div class="bloque-autorizacion">
  <div class="autorizado">AUTORIZÓ</div>
  <div class="autorizado">Cadena Original</div>
  <div class="autorizado">Sello Digital</div>
</div>
</div>







</body>
</html>
