<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado productor demezcal</title>
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
            opacity: 0.3;
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

        .description1 {
            font-size: 25px;
            font-weight: bold;
            text-align: right;
        }

        .description2 {
            font-weight: bold;
            font-size: 14px;
            color: #5A5768;
            white-space: nowrap;
            position: relative;
            top: -64px;
            left: 295px; 
        }

        .description3 {
            font-weight: bold;
            margin-right: 30px;
            text-align: right;
            font-size: 13px;
            position: relative;
            top: -30px;
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

        .title3 {
            font-size: 20px;
            text-align: center;
            font-weight: bold;
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

        .down {
            text-align: right;
            font-size: 11px;
            margin-top: -40px; 
            margin-right: 20px;
        }

        .foother {
            position: fixed;
            bottom: -40; 
            left: 0; 
            width: 100%; 
            text-align: center; 
            margin: 0;
            padding: 10px 0; 
        }

        .foother img {
            margin-top: 40px;
            width: 700px; 
            height: auto;
            display: inline-block;
        }

    </style>
</head>
<body>

    @if ($watermarkText)
        <div class="watermark-cancelado">
            Cancelado
        </div>
    @endif

<img src="{{ public_path('img_pdf/logo_fondo.png') }}" alt="Marca de Agua" class="watermark">

<div class="header">
    <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM" width="300px">
</div>

<div class="description1">ORGANISMO CERTIFICADOR</div>
<div class="description2">Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C</div>
<div class="description3">No. CERTIFICADO: {{ $num_certificado }}</div>

<p class="text1">
Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C. Acreditado como organismo de certificación de producto con número de acreditación 144/18 ante la Entidad Mexicana de Acreditación, A.C. otorga el siguiente:
</p>

<p class="title">CERTIFICADO NOM</p>
<p class="title2">COMO PRODUCTOR DE MEZCAL A</p>
<p class="title3">"{{ strtoupper(str_replace(['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'], ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'], $razon_social)) }}"</p>

<table>
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
            <td>{{ $fecha_vigencia }}</td>
            <td class="cell1"><strong>Fecha de Vencimiento:</strong></td>
            <td>{{ $fecha_vencimiento }}</td>
        </tr>
    </tbody>
</table>

<p class="text">El presente certificado se realiza deacuerdo a la Norma Oficial Mexicana NOM-070-SCFI-2016, Bebidas Alcohólical
-Mezcal-Especificaciones, en vigor, mediante el esquema de certificación para productos con Denominación de
Origen, ya que ha demostrado que cumple con el proceso de elaboración de Mezcal y produce la (s) categoría (s) y
clase (s): <strong>Mézcal Artesanal, Blanco o Joven, Reposado, Añejo</strong></p>

<p class="text">Este certificado ampara exclusivamente la producción del productb Mezcal que se realice en las instalaciones
indicadas a continuacion:</p>

<p class="text"><strong>Maestro Mezcalero: </strong>{{ $maestro_mezcalero }}<br>
<strong>Domicilio de la Unidad de Produccíón: </strong>{{  $direccion_completa }}<br>
<strong>No. De Autorización para el Uso de la Denominación de Origen Mezcal: </strong>{{ $num_autorizacion }}<br>
<strong>No. De Dictamen de cumplimiento con la NOM:</strong>  {{ $num_dictamen}} <br>
<strong>No. De Cliente ante el Organismo Certificador CIDAM A.C:</strong>  {{ $numero_cliente}}
</p>

<p class="text">Dichas instalaciones cuentan con el equipo requerido para la producción del producto Mezcal y se encuentran
dentro de los estados y municipios que contempla lafiesolución mediante la cualse otorga la protección prevista
a la Denominación de Origen Mezcal, para ser aplicada a la bebida alcohólica del mismo nombre, publicada el 28
de Noviembre de L994, así como sus subsecuentes modificaciones.</p>

<div class="signature">
    <div class="signature-line"></div>
    <div class="signature-name">{{$nombre_firmante}}</div>
    <div class="signature-name">Gerente Técnico del Organismo Certificador ClDAM</div>
</div>

<div class="down">Este cert¡ficado sustituye al: No aplica<br>Certificado como Productor de Mezcal NOM-070-SCFI-2016 F7.1-01-35<br>Edición 5 Entrada en vigor 08/03/2023</div>

<div class="foother">
    <img src="{{ public_path('img_pdf/pie_certificado.png') }}" alt="Logo CIDAM" width="300px">
</div>

</body>
</html>
