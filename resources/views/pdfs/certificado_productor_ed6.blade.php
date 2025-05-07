<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado productor de mezcal EDICION 6</title>
    <style>
        @page {
            size: 227mm 292mm; /*tamaño carta*/
            /*margin-top: 30;
            margin-left: 80px;
            margin-right: 25px;
            margin-bottom: 1px;*/
        }
        body {
            font-family: 'Calibri', sans-serif;
            font-size: 13.5px;
        }

        .img-fondo {
            position: fixed;
            top: 250px;
            left: 100px;
            width: 530px;
            height: 444px;
            z-index: -1;
            opacity: 0.1;
        }

        .encabezado {
            /*position: fixed;*/
            width: 100%; 
            color: #2f2b5a;
        }


        #tabla-principal td{
        line-height: 9px; /* Asegura que el contenido se ajuste a la altura */
        overflow: hidden; /* Evita desbordamientos del contenido */
        border: solid 2.5px;
        }

        table {
            width: 95%; 
            border-collapse: collapse;
            margin: 25px 0; 
            font-size: 13px;
            margin: 10px 20px;
            white-space: normal; 
        }

        td, th {
            border: 1px solid #595959;
            padding: 8px; 
            text-align: left;
        }

        th {
            background: #f0e6cc;
            font-weight: bold;
        }

        td[colspan="3"] {
            width: 75%;
        }

        td[colspan="2"] {
            width: 50%;
        }

        .even {
            background: #fbf8f0;
        }

        .odd {
            background: #fefcf9;
        }
        
        .cell {
            border-right: 1px solid transparent;
            white-space: nowrap; 
        }
        
        .cell1 {
            white-space: nowrap; 
        }

        .cent {
            white-space: normal; 
        }

 


        .footer {
            position: fixed;
            bottom: -22; 
            width: 100%; 
            text-align: center; 
        }

        .watermark-cancelado {
            font-family: Arial;
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
            z-index:-1;
        }
    </style>
</head>

<body>

    @if ($watermarkText)
        <div class="watermark-cancelado">
            Cancelado
        </div>
    @endif

    <div class="img-fondo">
        <img src="{{ public_path('img_pdf/logo_fondo.png') }}" alt="Marca de Agua fondo">
    </div>

    <div class="encabezado">
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" style="width: 300px; float: left; margin-left: -20px; margin-top: -20px;" alt="logo OC 3D">
        
        <div  style="margin-bottom: 15px">
            <b style="font-size: 20px;">Centro de Innovación y Desarrollo<br>Agroalimentario de Michoacán, A.C</b>
        </div>
    </div>

<div>No. CERTIFICADO: {{ $num_certificado }}</div>

<p >
Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C. Acreditado como organismo de certificación de producto con número de acreditación 144/18 ante la Entidad Mexicana de Acreditación, A.C. otorga el siguiente:
</p>




<p class="title">CERTIFICADO NOM EDICION 6</p>
<p class="title2">COMO PRODUCTOR DE MEZCAL A</p>
<p class="title3">"{{ strtoupper(str_replace(['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'], ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'], $razon_social)) }}"</p>

<table id="tabla-principal">
    <tbody>
        <tr>
            <td class="cell1"><strong>Domicilio Fiscal:</strong></td>
            <td colspan="3" class="cent" style="text-align: center; vertical-align: middle;">{{ $domicilio_fiscal }}</td>
        </tr>
        <tr>
            <td class="cell"><strong>RFC:</strong></td>
            <td>{{ $rfc }}</td>
            <td class="cell"><strong>Tel:</strong></td>
            <td>{{ $telefono }}</td>
        </tr>
        <tr>
            <td class="cell"><strong>Correo electrónico:</strong></td>
            <td colspan="3">{{ $correo }}</td>
        </tr>
        <tr>
            <td class="cell1"><strong>Fecha de inicio vigencia:</strong></td>
            <td>{{ $fecha_emision }}</td>
            <td class="cell1"><strong>Fecha de Vencimiento:</strong></td>
            <td>{{ $fecha_vigencia }}</td>
        </tr>
    </tbody>
</table>

<p class="text">El presente certificado se realiza deacuerdo a la Norma Oficial Mexicana NOM-070-SCFI-2016, Bebidas Alcohólical
-Mezcal-Especificaciones, en vigor, mediante el esquema de certificación para productos con Denominación de
Origen, ya que ha demostrado que cumple con el proceso de elaboración de Mezcal y produce la (s) categoría(s) <u><b>{{ $categorias }}</b></u> y
clase (s): <u><b>{{ $clases }}</b></u></p>

<p class="text">Este certificado ampara exclusivamente la producción del producto Mezcal que se realice en las instalaciones
indicadas a continuación:</p>

<p class="text"><strong>Maestro Mezcalero: </strong>{{ $maestro_mezcalero ?? "----------------------------------" }}<br>
<strong>Domicilio de la Unidad de Producción: </strong>{{  $direccion_completa }}<br>
<strong>No. De Autorización para el Uso de la Denominación de Origen Mezcal: </strong>{{ $num_autorizacion }}<br>
<strong>No. De Dictamen de cumplimiento con la NOM:</strong>  {{ $num_dictamen}} <br>
<strong>No. De Cliente ante el Organismo Certificador CIDAM A.C:</strong>  {{ $numero_cliente}}
</p>

<p class="text">Dichas instalaciones cuentan con el equipo requerido para la producción del producto Mezcal y se encuentran
dentro de los estados y municipios que contempla la Resolución mediante la cual se otorga la protección prevista
a la Denominación de Origen Mezcal, para ser aplicada a la bebida alcohólica del mismo nombre, publicada el 28
de Noviembre de 1994, así como sus subsecuentes modificaciones.</p>

<div class="signature">
    {{-- <img style="display: block; margin: 0 auto;" height="60px" src="{{ storage_path('app/public/firmas/'.$firma_firmante) }}"> --}}
    <div class="signature-line"></div>
    <div class="signature-name">{{ $nombre_firmante }}</div>
    <div class="signature-name">{{ $puesto_firmante }}</div>
</div>


<div class="footer">
    <p style="text-align: right; font-size: 9px; line-height: 1; margin-bottom: 1px;">
        @if ($id_sustituye)
            Cancela y sustituye al certificado con clave: {{ $id_sustituye }}
        @endif
        <br>Certificado como Productor de Mezcal NOM-070-SCFI-2016 F7.1-01-35<br>
        Entrada en vigor: 
    </p>
    <img src="{{ public_path('img_pdf/pie_certificado.png') }}" alt="pie de pagina" width="705px">
</div>

</body>
</html>
