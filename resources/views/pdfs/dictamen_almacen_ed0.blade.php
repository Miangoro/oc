<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento NOM de Almacén o Bodega</title>
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
.bloque-centrado .subtitulo {
  margin: 4px 0;
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
  font-size: 35px;
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
  margin-bottom: 20px;
} 
.resaltado2 {
  font-weight: bold;
  font-size: 15px;
}  
.nota-final {
  text-align: justify;
  font-size: 13px;
  color: #999999; /* Gris claro, más tenue que el texto normal */
  line-height: 1;
  margin-top: 10px;
  margin-bottom: 40px;
}
.bloque-autorizacion {
  margin-top: 30px;
  line-height: 1;
}

.autorizado {
  font-size: 11px;
  font-family: 'Calibri', sans-serif;
 
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
    <div class="titulo"> Nombre del productor/empresa:  </div>
    <div class="subtitulo">Dictamen de cumplimiento de Instalaciones de Bodega o Almacén</div>

     <p class="justificado">De acuerdo a lo establecido en los procedimientos internos de la Unidad de Inspección <span class="resaltado">No.UVNOM129</span> de la
 Universidad Michoacana de San Nicolás de Hidalgo, con domicilio en Francisco J. Múgicas/n Col. Felicitas del
 Rio, Morelia, Michoacán para la revisión de procesos de producción del producto Mezcal, su envasado y
 comercialización; y confundamento en los artículos 56 Fracción I y 60 fracción I de la Ley de Infraestructura de la
 Calidad que establece el funcionamiento de las Unidades de Inspección. </p>
</div>
 <p class="justificado">Después de realizar la inspección de las
 instalaciones en fecha del <u>10 de Junio del 2025</u> partiendo del acta circunstanciada o número de inspección:
 <u>UMS-0725/2025</u> se otorga el Dictamen de Instalaciones</p>

<div class="bloque-centrado">
 <div class="numero">Nombre del productor/empresa:  </div>
 </div>

<div class="bloque-centrado">
  <div class="destinatario">AMANTES DEL MEZCAL, S.A. DE</div>
</div>

<p class="datos-comercio">
  <span class="resaltado2">Domicilio Fiscal: </span> AMANTES DEL MEZCAL, S.A.DEC.V. Avenida Ferrocarril, Número exterior 69, Número
 interior Bis., San Sebastián Tutla, 71320, , Oaxaca De Juárez, Oaxaca<br>
  <span class="resaltado2">Domicilio de la Bodega o Almacén: </span> Nacional, 85, -, San Dionisio Ocotepec, 70495, San Dionisio Ocotepec,
 Oaxaca<br>
  <span class="resaltado2">Responsable de inspección: </span><br>
  <span class="resaltado2">Fecha de emisión del dictamen:</span>03 de Julio del 2025<br>
  <span class="resaltado2"> Vigencia hasta:</span> 10 de Junio del 2026 Se dictamina que la Bodega o Almacén cuenta con la infraestructura, el
 equipo y los procesos necesarios para la producción de <u>Mezcal Artesanal</u>, clase (s) <u>Blanco o Joven, Abocado con,
 Destilado con</u>, requisitos establecidos en la NOM-070-SCFI-2016, Bebidas alcohólicas-Mezcal-Especificaciones y
 por el Organismo de Certificación del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C.
 (CIDAM).
</p>
<p class="nota-final">Las instalaciones se encuentran en región de los estados y municipios que contempla la resolución mediante el cual se otorga la
 protección prevista a la denominación de origen Mezcal, para ser aplicada a la bebida alcohólica del mismo nombre, publicada
 el 28 de noviembre de 1994, así como sus modificaciones subsecuentes.</p>

<div class="bloque-autorizacion">
  <div class="autorizado">C.c.p Dirección General de Normas</div>
  <div class="autorizado">C.c.p Gerente del Organismo Certificador del CIDAM A.C.</div>
  <div class="autorizado">C.c.p Expediente de la Unidad de Verificación del UMSNH.</div>
</div>



</div>








</body>
</html>
