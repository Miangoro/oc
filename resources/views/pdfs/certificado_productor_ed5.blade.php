<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado como Productor de Mezcal NOM-070-SCFI-2016 F7.1-01-35</title>
    <style>

        body {
        font-family: 'Calibri', sans-serif;
        }

        .watermark {
            position: absolute;
            top: 43%;
            left: 55%;
            width: 50%;
            height: auto;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1;
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

        .header img {
            float: left;
            margin-left: -10px;
            margin-top: -30px;
        }

        .cidam {
            color:rgb(76, 80, 109);
            text-align: left;
            margin-left: 0;
            margin-right: 5;
            margin-bottom: 10px;
            font-family: 'Arial', sans-serif;
        }

        .description3 {
            font-weight: bold;
            margin-right: 30px;
            text-align: right;
            font-size: 15px;
            position: relative;
            top: -20px;
        }

        .text {
            font-size: 13.5px;
            line-height: 1;
            text-align: justify;
            margin: 10 20px;
        }

        .text1 {
            font-size: 13.5px;
            line-height: 1;
            text-align: justify;
            margin: -5 20px;
        }

        .title {
            font-size: 25px;
            text-align: center;
            font-weight: bold;
            letter-spacing: 9px;
            line-height: 0.5;
        }

        .title2 {
            font-size: 25px;
            text-align: center;
            font-weight: bold;
            line-height: 0.5;
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

        .signature {
            margin: 50px 20px;
            text-align: center;
            margin-top: 20px;
        }

        .signature-line {
            line-height: 10;
            border-top: 1px solid #000;
            width: 240px;
            margin: 0 auto;
            padding-top: 5px;
        }

        .signature-name {
            font-family: Arial;
            margin: 10px 0 0;
            font-size: 13px;
            font-weight: bold;
            line-height: 0.5;
        }


        .footer {
            position: fixed;
            bottom: -22;
            width: 100%;
            text-align: center;
        }



        #tabla-principal td{
        line-height: 9px; /* Asegura que el contenido se ajuste a la altura */
        overflow: hidden; /* Evita desbordamientos del contenido */
        border: solid 2.5px;
        }
    </style>
</head>

<body>

    @if ($watermarkText)
        <div class="watermark-cancelado">
            Cancelado
        </div>
    @endif

<img src="{{ public_path('img_pdf/logo_fondo.png') }}" alt="Fondo CIDAM" class="watermark">

    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}"
            style="width: 325px; float: left; margin-left: -15px; margin-top: -20px;" alt="logo de CIDAM 3D">
    <div class="cidam" style="margin-bottom: 10px"> <b style="font-size: 24px;">Centro de Innovación y Desarrollo
        <br>Agroalimentario de Michoacán, A.C</b>
    </div>
    <br>
    <div class="description3" style="margin-right: 30px; text-align: right; font-size: 13px; margin-top: 20px;">
        <b>No. de Certificado: {{ $num_certificado }}</b>
    </div>


<p class="text1">
Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C. Acreditado como organismo de certificación de producto con número de acreditación 144/18 ante la Entidad Mexicana de Acreditación, A.C. otorga el siguiente:
</p>

<p class="title">CERTIFICADO NOM</p>
<p class="title2">COMO COMERCIALIZADOR DE MEZCAL A</p>
<p style="font-size: 20px; text-align: center;"><b>"{{ strtoupper(str_replace(['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'], ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'], $razon_social)) }}"</b></p>


<table id="tabla-principal">
    <tbody>
        <tr>
            <td style="border-right: none"><strong>Domicilio:</strong></td>
            <td colspan="3" style="text-align: center; vertical-align: middle; border-left: none">{{$domicilio_fiscal}}</td>
        </tr>
        <tr>
            <td style="border-right: none"><strong>RFC:</strong></td>
            <td style="border-left: none">{{$rfc}}</td>
            <td style="border-right: none"><strong>Tel:</strong></td>
            <td style="border-left: none">{{$telefono}}</td>
        </tr>
        <tr>
            <td style="border-right: none"><strong>Correo electrónico:</strong></td>
            <td colspan="3" style="border-left: none">{{$correo}}</td>
        </tr>
        <tr>
            <td><strong>Fecha de inicio vigencia:</strong></td>
            <td>{{$fecha_emision}}</td>
            <td><strong>Fecha de Vencimiento:</strong></td>
            <td>{{$fecha_vigencia}}</td>
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
        <br>Certificado como Productor de Mezcal NOM-070-SCFI-2016 F7.1-01-35
        <br>Entrada en vigor: 12/01/2024
    </p>
    <img src="{{ public_path('img_pdf/pie_certificado.png') }}" alt="pie de pagina" width="705px">
</div>


</body>
</html>
