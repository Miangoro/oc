<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>F-UV-04-16 Ver 7 Dictamen de Cumplimiento NOM Mezcal a Granel</title>
    <style>
            @font-face {
                font-family: 'fuenteNormal';
                src: url('{{ storage_path('fonts/lsansuni.ttf') }}');
            }

            @font-face {
                font-family: 'fuenteNegrita';
                src: url('{{ storage_path('fonts/LSANSD.ttf') }}');
            }
        .header {
            display: flex;
            /* Alinea los elementos al inicio */
            position: fixed;
            top: -35px;
            width: 100%;
            height: 100px;
            padding: 0 15px;
            /* Ajusta el relleno según sea necesario */
            z-index: 1;

        }

        .header img {
            width: 250px;
            height: 87px;

            /* Espacio entre la imagen y el texto */
        }

        .header-text {
            color: #151442;
            font-family: sans-serif;
            line-height: 1.2;
            font-size: 9px;
            position: relative;
            width: 49%;
            left: 350px;
            top: -50px;
        }

        .header-text p {
            margin: 0;
            /* Elimina márgenes entre párrafos */
            padding: 0;
            /* Elimina padding adicional */
        }

        .large-text {
            bottom: -50px;
            font-size: 16px;
            font-family: 'Arial Negrita', Gadget, sans-serif;
        }

        .small-text {
            font-size: 8.5px;
            font-family: 'Arial Negrita', Gadget, sans-serif;
        }

        .normal-text {
            font-size: 9px;
            /* Ajusta según sea necesario */
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #009047;
            /* Verde similar al del ejemplo */
            color: white;
            text-align: center;
            line-height: 1.5cm;
            font-size: 10pt;
        }

        .footer-content {
            padding: 5px;
        }

        .footertext2 {
            font-family: 'Lucida Sans Unicode';
            font-size: 10px;
        }

        .footer-bar {
            position: fixed;
            bottom: -55px;
            left: -70px;
            right: -70px;
            width: calc(100% - 40px);
            height: 45px;
            background-color: #158F60;
            color: white;
            font-size: 10px;
            text-align: center;
            padding: 10px 0px;
        }

        .footer-bar p {
            margin: 0;
            line-height: 1;
        }

        .font-lucida-sans-seminegrita {
            font-family: 'Lucida Sans Seminegrita', sans-serif;
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-family: 'Arial Negrita', Gadget, sans-serif;
            line-height: 20px;
            margin-top: 10px;
        }

        .container {
            font-family: 'fuenteNormal','Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-size: 13px;
            padding: 5px;
            margin: 15px;
            margin-top: 47px;
            line-height: 0.8;
        }

        .contentt {
            position: relative;
            padding: 0 20px;
            /* 0 para padding superior e inferior, 15px para padding izquierdo y derecho */
            margin-top: 35px
        }

        p {
            margin: 0;
        }

        /* Estilo para la tabla */
        table.datos_empresa {
            text-align: center;
            border-collapse: collapse;
            /* Asegura que los bordes de las celdas se fusionen */
            width: 100%;
            /* Opcional: hace que la tabla ocupe todo el ancho disponible */
        }

        /* Estilo para las celdas de la tabla */
        table.datos_empresa td {
            border: 2px solid #003300;
            /* Ajusta el color y grosor del borde */
            padding: 2px;
            /* Opcional: agrega espacio dentro de las celdas */
        }


        /* Estilo para la tabla */
        table.table_description {
            text-align: center;
            border-collapse: collapse;
            /* Asegura que los bordes de las celdas se fusionen */
            width: 100%;
            /* Opcional: hace que la tabla ocupe todo el ancho disponible */
        }

        /* Estilo para las celdas de la tabla */
        table.table_description td,
        {
        border: 2px solid #003300;
        /* Ajusta el color y grosor del borde */
        padding: 2px;
        /* Opcional: agrega espacio dentro de las celdas */
        }

        .images-container {
            position: relative;
            display: flex;
            margin-top: -40px;
         
            width: 100%;
        }

        .textx1 {
            bottom: 82px;
            position: fixed;
            line-height: 1.2;
            font-family: Arial, Helvetica, Verdana;
        }

        .textx2 {
            bottom: 71px;
            position: fixed;
            line-height: 1.2;
            font-family: Arial, Helvetica, Verdana;
        }

        .textx3 {
            bottom: 60px;
            position: fixed;
            line-height: 1.2;
            font-family: Arial, Helvetica, Verdana;
        }

        .textx,
        .textsello {
            line-height: 1.2;
            font-family: Arial, Helvetica, Verdana;
        }

        .textsello {
            text-align: left;
            font-size: 8px;
            margin: 0;
            padding: 0;
        }

        .sello {
            text-align: right;
            font-size: 11px;
            margin: 0;
            padding: 0;
            position: fixed;
            right: 30px;
            top: 840px;
            font-family: 'Arial Negrita' !important;
        }

        .image-right {
            position: absolute;
            right: 10px;
            top: 18px;
            width: 240px;
        }

        .pie {
            position: fixed;
            font-family: 'Lucida Sans Unicode';
            bottom: 10.5px;
            left: 550px;
            text-align: right;
            font-size: 9px;
            line-height: 1;
            padding-bottom: 8px;
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

        .negrita{
            font-family: 'fuenteNegrita';
        }
    </style>
</head>

<body>

    @if ($watermarkText)
        <div class="watermark">
            Cancelado
        </div>
    @endif



    {{-- cabecera --}}
    <div class="header">
        <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo CIDAM">
        <div class="header-text">
            <p class="large-text">Unidad de Inspección No. UVNOM-129</p>
            <p class="small-text">Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C.</p>
            <p class="normal-text">Acreditados ante la Entidad Mexicana de Acreditación, A.C.</p>
        </div>

    </div>
    <div class="footer-bar">
        <p class="font-lucida-sans-seminegrita" style="bottom: 4px;">www.cidam.org . unidadverificacion@cidam.org</p>
        <p class="footertext2">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo
            C.P. 58341. Morelia Michoacán</p>
    </div>
    <div class="container">
        <div class="title">Dictamen de Cumplimiento NOM Mezcal a Granel</div>
        <br>
        <p style="text-align: justify;">La Unidad de Inspección de Mezcal de CIDAM A.C., con domicilio en Kilómetro 8
            Antigua Carretera a
            Pátzcuaro, S/N Colonia Otra no Especificada en el Catálogo, C.P. 58341, Morelia, Michoacán. acreditada
            como Unidad de Inspección tipo A con acreditación No. UVNOM-129, por la entidad mexicana de
            acreditación, A.C.
        </p>

        <br><span class="negrita">I. &nbsp;&nbsp;&nbsp;Datos de la empresa</span><br>
        <br>
        <table class="datos_empresa">
            <tr>
                <td class="negrita" style="color: #17365D; width: 15%;">Nombre de la empresa</td>
                <td  class="negrita" colspan="3" style="width: 43%; font-size:16px">{{ $data->inspeccione->solicitud->empresa->razon_social ?? ''}}</td>
            </tr>
            <tr>
                <td class="negrita" style="color: #17365D;" rowspan="2">Dirección</td>
                <td rowspan="2">
                   <span class="negrita">Domicilio fiscal:</span>  {{ $data->inspeccione->solicitud->empresa->domicilio_fiscal ?? ''}}<br>

                   <span class="negrita">Domicilio de instalaciones:</span> {{ $data->inspeccione->solicitud->instalacion->direccion_completa ?? 'NA' }}

                </td>
                <td class="negrita" style="color: #17365D; width: 17%;">RFC</td>
                <td style="width: 25%;">{{  $data->inspeccione->solicitud->empresa->rfc }}</td>
            </tr>
            <tr>
                <td class="negrita" style="color: #17365D;">
                    Representante legal
                </td>
                <td>{{ $data->inspeccione->solicitud->empresa->representante }}
                </td>
            </tr>
            <tr>
                <td class="negrita" style="color: #17365D;">No. de servicio</td>
                <td>{{ $data->inspeccione->num_servicio }}</td>
                <td class="negrita" style="color: #17365D;">Número de dictamen</td>
                <td>{{ $data->num_dictamen }}</td>
            </tr>
            <tr>
                <td class="negrita" style="color: #17365D;">Nombre del Inspector</td>
                <td>{{ $data->inspeccione->inspector->name }}</td>
                <td class="negrita" style="color: #17365D;">Fecha de servicio</td>
                <td>{{ $fecha_servicio }}</td>
            </tr>
            <tr>
                <td class="negrita" style="color: #17365D;">Fecha de emisión</td>
                <td>{{ $fecha_emision }}</td>
                <td class="negrita" style="color: #17365D;">Vigencia hasta</td>
                <td>{{ $fecha_vigencia }}</td>
            </tr>
        </table>
        <span class="negrita">II.&nbsp;&nbsp;&nbsp;Descripción del producto</span>
        <br><br>
        <table class="table_description">
            <tr>
                <td colspan="6" class="negrita" style="font-size: 13px; text-transform: uppercase; padding: 5px;">
                    <p>producto {{ $data->inspeccione->solicitud->lote_granel->categoria->categoria ?? 'NA' }}</p>
                    <p>origen {{ $data->inspeccione->solicitud->instalacion->estados->nombre ?? 'NA' }}</p>
                </td>
            </tr>
            <tr>
                <td class="negrita" style="color: #17365D; width: 16%;">Categoría y clase</td>
                <td>{{ $data->inspeccione->solicitud->lote_granel->categoria->categoria ?? 'NA' }} {{$data->inspeccione->solicitud->lote_granel->clase->clase ?? 'NA' }}</td>
                <td class="negrita" style="color: #17365D;  width: 19%">No. de lote a granel</td>
                <td>{{ $data->inspeccione->solicitud->lote_granel->nombre_lote ?? '------' }}</td>
                <td class="negrita" style="color: #17365D; width: 14%;">No. de análisis</td>
                <td>{{ $data->inspeccione->solicitud->lote_granel->folio_fq ?? 'NA'}}</td>
            </tr>
            <tr>
                <td class="negrita" style="color: #17365D;">Ingredientes</td>
                <td>{{ $data->inspeccione->solicitud->lote_granel->ingredientes ?? 'NA' }}</td>
                <td class="negrita" style="color: #17365D;">Volumen de lote</td>
                <td>{{ $data->inspeccione->solicitud->lote_granel->volumen ?? '----' }} L</td>
                <td class="negrita" style="color: #17365D;">Contenido alcohólico</td>
                <td>{{ $data->inspeccione->solicitud->lote_granel->cont_alc ?? 'NA' }} % Alc. Vol.</td>
            </tr>
            <tr>
                <td class="negrita" style="color: #17365D;">Edad</td>
                <td>{{ $data->inspeccione->solicitud->lote_granel->edad ?? 'NA' }}</td>
                <td class="negrita" style="color: #17365D;">Tipo de maguey</td>
                <td colspan="3">
                    @if(!empty($data->inspeccione->solicitud->lote_granel->tiposRelacionados))
                    @foreach($data->inspeccione->solicitud->lote_granel->tiposRelacionados as $tipo)
                        {{ $tipo->nombre }} (<i>{{ $tipo->cientifico }}</i>)
                    @endforeach
                        @else
                            ------
                     @endif
                    
                </td>
            </tr>
        </table>

        <p>Este dictamen de cumplimiento de mezcal a granel se expide de acuerdo a la Norma Oficial Mexicana
            NOM-070-SCFI-2016. Bebidas alcohólicas -mezcal-especificaciones.</p>
    </div>

<br><br>


<!--FIRMA DIGITAL-->
<div style="margin-left: 15px;">
        <p class="sello">Sello de Unidad de Inspección</p>
        <div class="images-container">
            <img src="{{ $qrCodeBase64 }}" alt="Logo UVEM" width="90px">
            <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Imagen derecha" class="image-right">
        </div>
        <p class="textx" style="font-size: 9px;">
            <strong>AUTORIZÓ</strong>
            {{-- <span style="margin-left: 50px;">
                <strong>{{ $data->firmante->puesto }} | {{ $data->firmante->name }}</strong>
            </span> --}}
            <span style="margin-left: 50px;">
                @php
                    use Illuminate\Support\Facades\Storage;
                    $firma = $data->firmante->firma ?? null;
                    $firmaPath = $firma ? 'firmas/' . $firma : null;
                @endphp
        
                @if ($firma && Storage::disk('public')->exists($firmaPath))
                    <img style="position: absolute; top: -45px; left: 170; right: 0; margin: 0 auto;" height="60px"
                        src="{{ asset('storage/' . $firmaPath) }}">
                @endif
        
                <strong>{{ $data->firmante->puesto ?? '' }} | {{ $data->firmante->name ?? '' }}</strong>
            </span>
        </p>

        <p class="textx" style="font-size: 9px;">
            <strong>CADENA ORIGINAL</strong>
            <span style="margin-left: 14px;">
                <strong>{{ $firmaDigital['cadena_original'] }}</strong>
            </span>
        </p>

        <p class="textx" style="font-size: 9px; ">
            <strong>SELLO DIGITAL</strong>
        </p>

        <p class="textsello" style="width: 85%; word-wrap: break-word; white-space: normal;">
            {{ $firmaDigital['firma'] }}
        </p>

    </div>



    <p class="pie">Entrada en vigor: 15-07-2024 <br>
        F-UV-04-16 Ver 7
    </p>
</body>

</html>
