<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado de Exportacion</title>
    <style>
        @page {
            size: 227mm 292mm;
            margin-top: 30;
            margin-left: 80px;
            margin-right: 25px;
            margin-bottom: 1px;
        }
        body {
            font-family: Helvetica;
            font-size: 12px;
            padding-right: 4px;
            padding-left: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            /*table-layout: fixed; /* Esto asegura que las columnas tengan un ancho fijo */
        }
        td {
            border: 1px solid #366091;
            text-align: center;
            font-size: 11px;
        }
        th {
            background-color: #608390;
            color: white;
            text-align: center;
            font-size: 11px;
        }
        .cidam {
            color: #161c4a;
            text-align: center;
            margin-left: 0;
            margin-bottom: 20px;
        }
        .td-no-margins {
            border: none;
        }
        .td-margins {
            border-right: none;
            border-left: none;
            font-size: 11px;
        }
        .titulos {
            font-size: 15px;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }
        .titulo2 {
            font-size: 12px;
            text-align: center;
            padding: 10px;
        }
 
        .img-fondo {
            position: absolute;
            top: 250px;
            left: 100px;
            width: 530px;
            height: 444px;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/logo_fondo.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.1;
        }
        .img-exportacion {
            position: absolute;
            top: 130px;
            left: -70px;
            width: 87px;
            height: 740px;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/exportacion.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
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
    </style>
</head>

<body>
    <!-- Aparece la marca de agua solo si la variable 'watermarkText' tiene valor -->
    @if ($watermarkText)
        <div class="watermark-cancelado">
            Cancelado
        </div>
    @endif
 
    <div class="img-fondo"></div>
    <div class="img-exportacion"></div>
    
<img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" style="width: 300px; float: left; margin-left: -20px; margin-top: -20px;" alt="logo de CIDAM 3D">


    <div class="cidam" style="margin-bottom: 15px">
        <b style="font-size: 16px;">CENTRO DE INNOVACIÓN Y DESARROLLO <br>AGROALIMENTARIO DE MICHOACÁN A.C.</b>
        <p style="font-size: 10px">Organismo de Certificación de producto acreditado ante la <br>
            entidad mexicana de acreditación ema A.C. con <b> No. 144/18</b></p>
    </div>

    <div class="titulos">
        CERTIFICADO DE AUTENTICIDAD DE EXPORTACIÓN DE MEZCAL
    </div>
    <table>
        <tr>
            <td class="td-no-margins"
                style="font-weight: bold;font-size: 11.5px;padding-right: 4px;padding-left: 0; text-align: left">Número
                de Certificado:</td>
            <td class="td-no-margins"
                style="font-weight:bold; font-size:11.5px; padding-right: 4px;padding-left: 0; text-align: left">
                {{ $data->num_certificado }}</td>
            <td class="td-no-margins"
                style="font-weight: bold;font-size: 11.5px;padding-right: 4px;padding-left: 0; text-align: right">Fecha
                de <br> expedición:</td>
            <td class="td-no-margins"
                style="font-weight: bold;font-size: 11.5px;padding-right: 4px;padding-left: 0; text-align: right">
                {{ $expedicion }}</td>
            <td class="td-no-margins"
                style="font-weight: bold;font-size: 11.5px;padding-right: 4px;padding-left: 0; text-align: right">
                Vigencia de 90 días <br> naturales</td>
            <td class="td-no-margins"
                style="font-weight: bold;font-size: 11.5px;padding-right: 4px;padding-left: 0; text-align: right">
                {{ $vigencia }}</td>
        </tr>
    </table>
    
    <div class="titulos">
        DATOS GENERALES DEL EXPORTADOR
    </div>
    <table>
        <tr>
            <td class="td-margins"
                style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;padding-top: 10px;padding-bottom: 10px;">
                Nombre o razón social:</td>
            <td class="td-margins" style="text-align: left">{{$empresa}}</td>
            <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
                Número de Cliente:</td>
            <td class="td-margins" style="text-align: left">{{ $n_cliente}}</td>
        </tr>
        <tr>
            <td class="td-margins"
                style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px; padding-top: 8px;padding-bottom: 8px;">
                Domicilio:</td>
            <td class="td-margins" style="text-align: left; padding-top: 8px;padding-bottom: 8px;" colspan="3">
                {{ $domicilio}}</td>
        </tr>
        <tr>
            <td class="td-margins"
                style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px; padding-top: 10px;padding-bottom: 10px;">
                Código Postal:</td>
            <td class="td-margins" style="text-align: left"> &nbsp; </td>
            <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
                Estado:</td>
            <td class="td-margins" style="text-align: left; padding-right: 4px;">{{ $estado}}</td>
        </tr>
        <tr>
            <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
                Registro Federal de Contribuyentes:</td>
            <td class="td-margins" style="text-align: left">
                {{ $rfc }}</td>
            <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
                País:</td>
            <td class="td-margins" style="text-align: left"> MÉXICO </td>
        </tr>
        <tr>
            <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 1px;">
                Registro de Productor <br> Autorizado (Uso de la <br> DOM):</td>
            <td class="td-margins" style="text-align: left">
                {{ $DOM}}</td>
            <td class="td-margins" style="font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
                Número de Convenio de corresponsabilidad:</td>
            <td class="td-margins" style="text-align: left">
                {{ $convenio}}</td>
        </tr>
    </table>




@foreach($lotes as $lote)

    <div class="titulos">
        DESCRIPCIÓN DEL EMBARQUE QUE AMPARA EL CERTIFICADO
    </div>
    <table>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; height: 30px; width: 12%;">
                Marca:</td>
            <td style="text-align: left; padding-left: 4px; width: 20%;"> 
                {{ $lote->marca->marca ?? "N"}} </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; width: 12%;">
                Categoría y Clase:</td>
            <td style="text-align: left; padding-left: 4px; width: 20%;"> 
                {{ $lote->lotesGranel->first()->categoria->categoria ?? "N"}}, {{ $lote->lotesGranel->first()->clase->clase ?? "N"}} </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; width: 12%;">Edad
                (solo aplica en Añejo):</td>
            <td style="text-align: left; padding-left: 4px; width: 20%;"> 
                {{ $lote->lotesGranel->first()->edad ?? "N"}}  </td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; height: 30px;">
                Certificado <br> NOM a <br>Granel:</td>
            <td style="text-align: left; padding-left: 4px;"> 
                {{ $lote->lotesGranel->first()->folio_certificado ?? "N" }}&nbsp; </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">
                Volumen:</td>
            <td style="text-align: left; padding-left: 4px;"> 
                {{$presentacion}}  </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">%Alc.
                Vol.:</td>
            <td style="text-align: left; padding-left: 4px;"> 
                {{ $lote->lotesGranel->first()->cont_alc ?? "N" }}% </td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">No.
                de análisis:</td>
            <td style="text-align: left; padding-left: 4px;"> 
                {{ $lote->lotesGranel->first()->folio_fq ?? "N" }} </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">No.
                lote granel:</td>
            <td style="text-align: left; padding-left: 4px;"> 
                {{ $lote->lotesGranel->first()->nombre_lote ?? "N" }}</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">No.
                de lote envasado:</td>
            <td style="text-align: left; padding-left: 4px;"> 
                {{ $lote->nombre ?? "N" }}</td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; height: 30px">No.
                de análisis ajuste:</td>
            <td style="text-align: left; padding-left: 4px;"> 
                &nbsp; </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">Tipo
                de Maguey:</td>
            <td style="text-align: left; padding-left: 4px;"> 
                {{ $lote->lotesGranel->first()->tipos }} </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">Folio
                Hologramas:</td>
            <td style="text-align: left; padding-left: 4px;">
                
            </td>
        </tr>
        
{{------------------------- ULTIMA COLUMNA -------------------------}}
    {{-- if ($i == count($informacion) - 1) (Si estamos en la última tabla) --}}
    @if($loop->last)
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; height: 45px">
                Envasado en:</td>
            <td style="text-align: justify; padding-left: 4px;"> 
                &nbsp;</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">Cajas:
            </td>
            <td style="text-align: left; padding-left: 4px;"> 
                {{$cajas}} </td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">
                Botellas:</td>
            <td style="text-align: left; padding-left: 4px;"> 
                {{$botellas}} </td>
        </tr>
        <tr>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px; height: 35px;">
                Aduana de despacho:</td>
            <td style="text-align: left; padding-left: 4px;">
                {{$aduana}}</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">
                Fracción Arancelaria:</td>
            <td style="text-align: left; padding-left: 4px;">
                Falta</td>
            <td style="text-align: right; font-weight: bold; font-size: 12px; padding-right: 8px;">No.
                de <br> pedido:</td>
            <td style="text-align: left; padding-left: 4px;">
                {{ $n_pedido }}
            </td>
        </tr>
    @endif
{{------------------------- TERMINA CAJAS MULTIPLES -------------------------}}
    </table>
@endforeach




    <div class="titulos" style="padding-bottom: none;">
        DESTINATARIO
    </div>
    <table>
        <tr>
            <td class="td-margins"
                style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px; border-top: none;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre:</td>
            <td class="td-margins" style="text-align: left; border-top: none;"> 
                {{$nombre_destinatario}}
            </td>
        </tr>
        <tr>
            <td class=" td-margins"
                style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
                Domicilio:</td>
            <td class="td-margins" style="text-align: left">
                {{$dom_destino}}</td>
        </tr>
        <tr>
            <td class="td-margins"
                style="text-align: right; font-weight: bold; font-size: 12px;padding-right: 4px;padding-left: 4px;">
                País destino:</td>
            <td class="td-margins" style="text-align: left">
                {{$pais}} 
            </td>
        </tr>
    </table>

    <div>
        <p style="font-size: 7.5px">El presente certificado se emite para fines de exportación conforme 
            a la norma oficial mexicana de mezcal NOM-070-SCFI-2016. Bebidas Alcohólicas-Mezcal-Especificaciones, 
            en cumplimiento con lo dispuesto en la Ley Federal de Infraestructura de la Calidad. 
            Este documento no debe ser reproducido en forma parcial.</p>
    </div>

    <div class="titulo2">
       <b>AUTORIZÓ</b> 
    </div>
    <div class="titulo2" style="margin-top: 0;">
       <b>{{ $data->firmante->name }}<br>{{ $data->firmante->puesto }}</b>
    </div>



    <div class="footer">
        <p style="text-align: right; font-size: 8px; margin-bottom: 5px;">
            <!-- Aparece solo si tiene valor -->
            @if ($id_sustituye)
                Cancela y sustituye al certificado con clave: {{ $id_sustituye }}
            @endif
            <br>Certificado de Exportación NOM-070-SCFI-2016 F7.1-01-23 Ed 12 <br>
            Entrada en vigor: 26-08-2024
        </p>

        {{-- <img src="{{ public_path('img_pdf/pie_certificado.png') }}" style="height: 40px; width: 710px; position: absolute; margin-top: 0;"
            alt="pie de certificado"> --}}
        <div class="img-footer"></div>
    </div>




</body>
</html>
