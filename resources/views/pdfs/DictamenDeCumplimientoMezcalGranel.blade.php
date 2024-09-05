<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>F-UV-04-16 Ver 7 Dictamen de Cumplimiento NOM Mezcal a Granel</title>
    <style>
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
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            font-size: 14px;
            padding: 5px;
            margin: 15px;
            margin-top: 47px;
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
            position: fixed;
            margin-top: -20px;
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
            position: fixed;
            text-align: left;
            font-size: 8px;
            bottom: 30px;
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
            height: auto;
            position: fixed;
            right: 0;
            width: 225px;
            top: -20px;
        }

        .pie {
            position: fixed;
            font-family: 'Lucida Sans Unicode';
            bottom: 10.5px;
            left: 550px;
            text-align: right;
            font-size: 9px;
            line-height: 1;
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

        <br><strong>I. &nbsp;&nbsp;&nbsp;&nbsp;Datos de la empresa</strong><br>
        <br>
        <table class="datos_empresa">
            <tr>
                <td style="color: #17365D; font-weight: bold;  width: 15%;">Nombre de la empresa</td>
                <td colspan="3">{{ $data->empresa->razon_social }}</td>
            </tr>
            <tr>
                <td style="color: #17365D; font-weight: bold;" rowspan="2">Dirección</td>
                <td rowspan="2">
                   <b>Domicilio fiscal:</b>  {{ $data->empresa->domicilio_fiscal }}<br>
                   
                    <b>Domicilio de instalaciones:</b> {{ $data->inspeccion->solicitud->instalacion->direccion_completa }}

                </td>
                <td style="color: #17365D; font-weight: bold; width: 18%;">RFC</td>
                <td>{{ $data->empresa->rfc }}</td>
            </tr>
            <tr>
                <td style="color: #17365D; font-weight: bold;">
                    Representante legal
                </td>
                <td>{{ $data->empresa->representante }}
                </td>
            </tr>
            <tr>
                <td style="color: #17365D; font-weight: bold;">No. de servicio</td>
                <td>{{ $data->inspeccion->num_servicio }}</td>
                <td style="color: #17365D; font-weight: bold;">Número de dictamen</td>
                <td>{{ $data->num_dictamen }}</td>
            </tr>
            <tr>
                <td style="color: #17365D; font-weight: bold;">Nombre del Inspector</td>
                <td>{{ $data->inspeccion->inspector->name }}</td>
                <td style="color: #17365D; font-weight: bold;">Fecha de servicio</td>
                <td>{{ $fecha_servicio }}</td>
            </tr>
            <tr>
                <td style="color: #17365D; font-weight: bold;">Fecha de emisión</td>
                <td>{{ $fecha_emision }}</td>
                <td style="color: #17365D; font-weight: bold;">Vigencia hasta</td>
                <td>{{ $fecha_vigencia }}</td>
            </tr>
        </table>
        <strong>II.&nbsp;&nbsp;&nbsp;&nbsp; Descripción del producto</strong>
        <br><br>
        <table class="table_description">
            <tr>
                <td colspan="6" style="font-weight: bold; font-size: 13px; text-transform: uppercase;">
                    <p>producto {{ $data->lote_granel->categoria->categoria ?? 'N/A' }}</p>
                    <p>origen {{ $data->inspeccion->solicitud->instalacion->estados->nombre }}</p>
                </td>
            </tr>
            <tr>
                <td style="color: #17365D; font-weight: bold; width: 16%;">Categoría y clase</td>
                <td>{{ $data->lote_granel->categoria->categoria ?? 'N/A' }} {{ $data->lote_granel->clase->clase ?? 'N/A' }}</td>
                <td style="color: #17365D; font-weight: bold; width: 19%">No. de lote a granel</td>
                <td>{{ $data->lote_granel->nombre_lote ?? 'N/A' }}</td>
                <td style="color: #17365D; font-weight: bold; width: 14%;">No. de análisis</td>
                <td>{{ $data->lote_granel->folio_fq ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td style="color: #17365D; font-weight: bold;">Ingredientes</td>
                <td>{{ $data->lote_granel->ingredientes ?? 'N/A' }}</td>
                <td style="color: #17365D; font-weight: bold;">Volumen de lote</td>
                <td>{{ $data->lote_granel->volumen ?? 'N/A' }}</td>
                <td style="color: #17365D; font-weight: bold;">Contenido alcohólico</td>
                <td>{{ $data->lote_granel->cont_alc ?? 'N/A' }} % Alc. Vol.</td>
            </tr>
            <tr>
                <td style="color: #17365D; font-weight: bold;">Edad</td>
                <td>{{ $data->lote_granel->edad ?? 'N/A' }}</td>
                <td style="color: #17365D; font-weight: bold;">Tipo de maguey</td>
                <td colspan="3">{{ $data->lote_granel->tipo->nombre ?? 'N/A' }}
                    <i>{{ $data->lote_granel->tipo->cientifico ?? 'N/A' }}</>
                </td>
            </tr>
        </table>

        <p>Este dictamen de cumplimiento de mezcal a granel se expide de acuerdo a la Norma Oficial Mexicana
            NOM-070-SCFI-2016. Bebidas alcohólicas -mezcal-especificaciones.</p>
    </div>

    <div class="contentt">
        <p class="sello">Sello de Unidad de Inspección</p>
        <div class="images-container">
            <img src="{{ public_path('img_pdf/qr_umc-074.png') }}" alt="Logo UVEM" width="88px">
            <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Imagen derecha" class="image-right">
        </div>
        <p class="textx1" style="font-size: 10px; margin: 1;">
            <strong>AUTORIZÓ</strong>
            <span style="margin-left: 50px;">
                <strong>Gerente Técnico Sustituto de la Unidad de Inspección | {{$data->inspectores->name ?? 'N/A'}}</strong>
            </span>
        </p>

        <p class="textx2" style="font-size: 10px; margin: 1;">
            <strong>Cadena Origina</strong>
            <span style="margin-left: 29px;">
                <strong>UMG-159/2024|2024-06-26|UMS-1094/2024</strong>
            </span>
        </p>
        <p class="textx3" style="font-size: 10px; margin: 1;">
            <strong>Sello Digital</strong>
        </p>

        <p class = "textsello">e2N1P+r+E79e0YxKzS/jMssKuASlmYXy2ppP+2PJN8vKUeFRxYTSY99MEWrgiHOnA
            N3pLUrdUBiD39v25Y648G4TK5qQ0LwZPLofRmjRQ2Ty5rHlDwnPRm37zaOkMjkRD<br>
            xC0ikyHPD+T3EFhEc9sgAFI6bZUd88yevfS+ZFZ7j9f5EA44Sz76jsN3P4e7lyePHmNz
            Jxg5ZupHICg5xBZu5ygOniMZNbzG6w0ZDPL58yoMQK1JDi8lwwiGJBaCNHN6krn<br>
            No5v5rvZPkbUthYT2r5M0sGP5Y+s97oLa8GA5hqyDAgE9P0d1u0uwU7Q8SF0GYfe lavijxvsWaZg5QA5og==
        </p>
    </div>


    <p class="pie">Entrada en vigor: 15-07-2024 <br>
        F-UV-04-16 Ver 7
    </p>
</body>

</html>
