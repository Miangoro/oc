<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitud de Emisión del Certificado NOM para Exportación</title>
    <style>
        @page {
            size: 225mm 280mm;
            margin-left: 52px;
            margin-right: 56px;
            /*margin-top: 30;
            margin-left: 80px;
            margin-right: 25px;
            margin-bottom: 1px;*/
        }
        body {
            font-family: Helvetica;
            font-size: 12px;
            padding-top: 12%;
        }
        .encabezado {
            position: fixed;
            top: 0;
            width: 100%; 
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            /*table-layout: fixed; /* Esto asegura que las columnas tengan un ancho fijo */
        }
        td {
            border: 1.5px solid #000000;
            text-align: center;
            font-size: 11px;
        }
        .amarillo{
            background-color: rgb(255, 209, 3);
            font-weight: bold;
            padding: 2px;
            text-align: left;
            border-bottom: none;
        }


    
        .footer {
            position: fixed;
            bottom: 15;
            right: 5;
            width: 100%;
            z-index: 9999; /* Para que el pie de página se mantenga encima de otros elementos */
            font-family: Arial, sans-serif;
            /*padding-bottom: 2px; /*espacio al fondo si es necesario */
        }
        .img-footer {
            background-image: url("{{ public_path('img_pdf/pie_certificado.png') }}");
            background-size: cover; /* ajusta img al contenedor */
            background-position: center; /* Centra la imagen en el contenedor */
            height: 45px; 
            width: 95%; /* Hace que la imagen ocupe todo el ancho del contenedor */
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
        .titulo, .subtitulo {
            display: inline-block;
            margin-right: 30px; /* Espacio entre los textos */
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

<div class="footer">
    <p style="text-align: right; font-size: 8px; margin-bottom: 1px;">
        @if ($id_sustituye)<!-- Aparece solo si tiene valor -->
            Cancela y sustituye al certificado con clave: {{ $id_sustituye }}
        @endif
        <br>Solicitud de emisión de Certificado para Exportación NOM-070-S SCFI-2016 F7.1-01-21<br>
        Edición 10 Entrada en vigor: 26/08/2024
    </p>
    {{-- <img src="{{ public_path('img_pdf/pie_certificado.png') }}" style="height: 40px; width: 710px; position: absolute; margin-top: 0;"
        alt="pie de certificado"> --}}
    <div class="img-footer"></div>
</div>
    
<div class="encabezado">
    {{-- <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" style="width: 160px; margin-right: 30px;" alt="logo de CIDAM">
    <b style="font-size: 16px; display: inline-block; margin-right: 30px;">CENTRO DE INNOVACION Y DESARROLLO<br>AGROALIMENTARIO DE MICHOACÁN A.C.</b>
    <p style="font-size: 8px; display: inline-block;">ORGANISMO DE CERTIFICACION No. de<br>acreditación 144/18 ante la ema A.C.</p> --}}
    <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" style="width: 160px; margin-right: 30px;" alt="logo de CIDAM">
    <div style="display: inline-block; margin-bottom: 5px;">
        <b style="font-size: 16px; display: inline-block; margin-right: 30px;">CENTRO DE INNOVACION Y DESARROLLO<br>AGROALIMENTARIO DE MICHOACÁN A.C.</b>
        <p style="font-size: 8px; display: inline-block;">ORGANISMO DE CERTIFICACION No. de<br>acreditación 144/18 ante la ema A.C.</p>
    </div>
</div>


    <div style="text-align: center; font-weight: bold; font-size: 13px; padding: 9px;" >
        SOLICITUD DE EMISIÓN DEL CERTIFICADO NOM PARA EXPORTACIÓN
    </div>
    <table>
        <tr>
            <td class="amarillo" style="width: 70px; text-align:center;"><b>I: </td>
            <td class="amarillo"><b>&nbsp;&nbsp; INFORMACIÓN DEL SOLICITANTE</b></td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="padding:8px;"> Fecha de solicitud:</td>
            <td style="font-weight: bold;">{{ $expedicion}}</td>
            <td>N° de cliente:</td>
            <td><b>{{ $n_cliente}}</b></td>
        </tr>
        <tr>
            <td style="padding-top:16px; padding-bottom:16px">Domicilio donde se<br>encuentra el producto:</td>
            <td style="font-weight: bold; width: 500px" colspan="3"> {{ $domicilio}}</td>
        </tr>
    </table>

    <!--PUNTO 2-->
    <table>
        <tr>
            <td class="amarillo" style="width: 70px; text-align:center; border-top:none"><b>II: </td>
            <td class="amarillo" style="border-top:none"><b>&nbsp;&nbsp;SERVICIO SOLICITADO</b></td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width: 200px; padding: 10%; border-bottom:none"></td>
            <td style="width: 200px;  padding: 10%; border-bottom:none"></td>
        </tr>
    </table>

    <!--PUNTO 3-->
@foreach($lotes as $lote) 
    <table>
        <tr>
            <td class="amarillo" style="width: 70px; text-align:center;"><b>III: </td>
            <td class="amarillo"><b>&nbsp;&nbsp; CARACTERISTICAS DEL PRODUCTO @if( $lotes->count() > 0 ) COMBINADO @endif</b></td>
        </tr>
    </table>

    <table>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">&nbsp;&nbsp;Marca:</td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $lote->marca->marca ?? "N"}}
            </td>
            <td style="text-align: left;  width: 20%;">&nbsp;&nbsp;Categoría y Clase:</td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $lote->lotesGranel->first()->categoria->categoria ?? "N"}}, 
                {{ $lote->lotesGranel->first()->clase->clase ?? "N"}} 
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;Certificado NOM a Granel:
            </td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $lote->lotesGranel->first()->folio_certificado ?? "N" }}
            </td>
            <td style="text-align: left;  width: 20%;">
                &nbsp;&nbsp;Edad:
            </td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $lote->lotesGranel->first()->edad ?? "NA"}}  
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;No. de análisis:
            </td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $lote->lotesGranel->first()->folio_fq ?? "N" }} 
            </td>
            <td style="text-align: left;  width: 20%;">
                &nbsp;&nbsp;Contenido Alcohólico:</td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $lote->lotesGranel->first()->cont_alc ?? "N" }}% 
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;No. de análisis de ajuste:
            </td>
            <td style="font-weight: bold; width: 30%;"> 
               FALTA
            </td>
            <td style="text-align: left;  width: 20%;">
                &nbsp;&nbsp; No. de lote a granel:</td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $lote->lotesGranel->first()->nombre_lote ?? "N" }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;Tipo de Maguey: 
            </td>
            <td style="font-weight: bold; width: 30%;"> 
               FALTA
            </td>
            <td style="text-align: left;  width: 20%;">
                &nbsp;&nbsp;No. de lote envasado:</td>
            <td style="font-weight: bold; width: 30%;"> 
                {{ $lote->nombre ?? "N" }}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;Contenido neto por
            </td>
            <td style="font-weight: bold; width: 30%;"> 
               xxxx
            </td>
            <td style="text-align: left;  width: 20%;">
                &nbsp;&nbsp;xxxx</td>
            <td style="font-weight: bold; width: 30%;"> 
                xxxx
            </td>
        </tr>
    </table>

    <br><br>
    <table>
        
<!--Si es 1 tabla, agregamos la ultima-->
@if( $lotes->count() == 1 )
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;No. de cajas: 
            </td>
            <td style="font-weight: bold; width: 30%;"> 
                {{$cajas}}
            </td>
            <td style="text-align: left;  width: 20%;">
                &nbsp;&nbsp;No. de botellas: </td>
            <td style="font-weight: bold; width: 30%;"> 
                {{$botellas}}
            </td>
        </tr>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;Contenido neto por
            </td>
            <td style="font-weight: bold; width: 30%;"> 
               xxxx
            </td>
            <td style="text-align: left;  width: 20%;">
                &nbsp;&nbsp;xxxx</td>
            <td style="font-weight: bold; width: 30%;"> 
                xxxx
            </td>
        </tr>
@endif

    </table>

@if($loop->iteration == 1)<!--Salto de pag después de tabla 2-->
    <div style="page-break-before: always;"></div> 
@endif

<!--si hay más de un lote, agregar al final una nueva-->
@if($loop->iteration > 1 && $loop->last)
    <br>
    <table>
        <tr>
            <td style="text-align: left; padding-top:16px; padding-bottom:16px; width: 20%;">
                &nbsp;&nbsp;No. de cajas: 
            </td>
            <td style="font-weight: bold; width: 30%;"> 
                {{$cajas}}
            </td>
            <td style="text-align: left;  width: 20%;">
                &nbsp;&nbsp;No. de botellas: </td>
            <td style="font-weight: bold; width: 30%;"> 
                {{$botellas}}
            </td>
        </tr>
    </table>
@endif

@endforeach <!-- Fin del for lotes -->


    <!--PUNTO 4-->
    <br>
    <table>
        <tr>
            <td class="amarillo" style="width: 70px; text-align:center;"><b>IV: </td>
            <td class="amarillo" style=""><b>&nbsp;&nbsp;INFORMACIÓN DEL PAÍS DESTINO (los datos deben aparecer tal cual se indican en la factura y orden de compra)</b></td>
        </tr>
    </table>

    <table>
        <tr>
            <td style="padding-top:16px; padding-bottom:16px; width: 20%;">
                Nombre:   
            </td>
            <td style="font-weight: bold; width: 80%" colspan="3">{{$nombre_destinatario}}</td>
        <tr>
            <td style="padding-top:16px; padding-bottom:16px; width: 20%;">
                Domicilio:</td>
            <td style="font-weight: bold; width: 80%" colspan="3">{{$dom_destino}}</td>
        </tr>
        <tr>
            <td style="padding-top:16px; padding-bottom:16px; width: 20%;" rowspan="2">
                País:</td>
            <td style="font-weight: bold; width: 20%" rowspan="2">
                {{$pais}} 
            </td>
            <td style="width: 20%">
                Aduana de salida:  
            </td>
            <td style="font-weight: bold; width: 40%">
                AEROPUERTO INTERNACIONAL DE LA CIUDAD
            </td>
        </tr>
        <tr>
            <td style="width: 20%">
                Fracción arancelaria
            </td>
            <td style="font-weight: bold; width: 40%" >
                2208.90.05.00
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="padding-top:16px; padding-bottom:16px; width: 50%; border-top: none">
                Angélica Yanet Delgadillo 
                <br><br>
                Nombre del responsable de instalaciones
            </td>
            <td style="font-weight: bold; width: 50%; border-top: none">
                JANETTE ELIZABETH CERVANTES
                <br><br>
                Nombre del solicitante de exportación
            </td>
        </tr>
    </table>
    <table>
        <td style="padding-top:16px; padding-bottom:16px; width: 30%;">
            INFORMACIÓN ADICIONAL SOBRE LA ACTIVIDAD:  
        </td>
        <td style="font-weight: bold; width: 70%"></td>
    </table>

    <!--PUNTO 5-->
    <table>
        <tr>
            <td class="amarillo" style="width: 70px; text-align:center;"><b>V: </td>
            <td class="amarillo" style=""><b>&nbsp;&nbsp;ANEXOS</b></td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width: 200px; padding: 10%; border-bottom:none"></td>
            <td style="width: 200px;  padding: 10%; border-bottom:none"></td>
        </tr>
    </table>



    <table>
        <tr>
            <td style="padding:3px; text-align: justify; border-bottom: none" colspan="3">
        La empresa se da por enterada que: la Unidad de Verificación establecerá una vigilancia de cumplimiento con la NOM
        permanente a sus instalaciones una vez que el Certificado NOM sea emitido. Para validar la información el OC podrá solicitar
        los documentos originales para su cotejo respectivo.
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: right; border-top: none"  >
                Campo para uso exclusivo del personal del<br>OC-CIDAM
            </td>
            <td style="width: 15%;">
                N° DE SOLICITUD: 
            </td>
            <td style="width: 35%">
                SOL-14401
            </td>
        </tr>
    </table>





</body>
</html>
