<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bitácora de revisión de certificado de exportación NOM-070-SCFI-2016 F7.1-01-33</title>
    <style>
        body {
            font-weight: 12px;
        }

        @page {
            margin-left: 70px;
            margin-right: 70px;
            margin-top: 40px;
            margin-bottom: 10px;

        }

        @font-face {
            font-family: 'Century Gothic';
            src: url('fonts/CenturyGothic.ttf') format('truetype');

        }

        @font-face {
            font-family: 'Century Gothic Negrita';
            src: url('fonts/GOTHICB.TTF') format('truetype');
        }

        .negrita {

            font-family: 'Century Gothic Negrita';
        }


        .header {
            font-family: 'Century Gothic';
            text-align: right;
            font-size: 14px;
            margin-right: -30px;

        }

        .title {
            text-align: center;
            font-size: 17px;
        }

        /*Tablas*/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 2px solid black;
            padding: 5px;
/*             padding-bottom: 6px;
            padding-top: 6px; */
            font-size: 11px;
            text-align: center;
            font-family: 'Century Gothic';
        }

        th {
            background-color: black;
            color: white;
            text-align: center;

        }

        .td-border {
            border-bottom: none;
            border-top: none;
            border-right: 1px solid black;
            border-left: 1px solid black;

        }

        .td-no-border {
            border: none;
        }

        .td-barra {
            border-bottom: none;
            border-top: none;
            border-right: none;
            border-left: 1px solid black;
        }

        .letra_td {
            text-align: right;
        }

        .th-color {
            background-color: #d8d8d8;
        }

        .leftLetter {
            text-align: left;

        }

        .rightLetter {
            text-align: right;
            vertical-align: top;
            padding-bottom: 8px;
            padding-top: 0;
        }

        .no-margin-top {
            margin-top: 0;
        }

        .no-padding {
            padding: 0;
        }

        .letra-fondo {
            /* font-weight: 300; */
            font-family: 'Century Gothic negrita';
            color: black;
            font-size: 12px;
            background-color: #9FC5E8;
            text-align: center;

        }

        .letra-title {
            font-family: 'Century Gothic negrita';
            color: black;
            font-size: 15px;
            background-color: #9FC5E8;
            text-align: left;
            padding: 3px;

        }

        .letra-up {
            vertical-align: top;
            padding-bottom: 10px;
            padding-top: 0;

        }

        .header {
            padding: 10px;
            text-align: right;
        }

        .header img {
            float: left;
            max-width: 165px;
            padding: 0;
            margin-top: -30px;
            margin-left: -50px;


        }

        /* Estilo para el texto de fondo */
        .background-text {
            padding-top: -15px;
            margin-left: auto;
            margin-right: 0;
            width: 65%;
            /* o el ancho que desees */
            font-family: 'Century Gothic Negrita';
            border: #000000 1px solid;
            color: #000000;
            font-size: 12px;
            white-space: normal;
            text-align: left;
        }

        .espacio_letras td {

        }

        .sin-border td {
            padding-top: 10px;
            padding-bottom: 10px;
            border: none;
        }

        .td-negrita {
            font-size: 12.5px;
            color: #000000;
            text-align: left;
            padding: 0;
            padding-right: 5px;
        }
    </style>


    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        <div> Bitácora de revisión de certificado de exportación NOM-070-SCFI-2016 F7.1-01-33<br> Ed. 6 Entrada en vigor
            07/11/2023<br>
        </div>
</head>

<body>
    <div>
        <p class="letra-title">PRIMERA REVISIÓN POR PARTE DEL CONSEJO PARA LA DECISIÓN DE LA CERTIFICACIÓN</p>
    </div>

    <table>
        <tr>
            <td class="letra-fondo" style="text-align: left" colspan="4">Razón social del cliente:</td>
            <td class="leftLetter" colspan="2">ALBERTO FRANCO MORGADO</td>
        </tr>
        <tr>
            <td class="letra-fondo" style="text-align: left" colspan="2">No. Cliente:</td>
            <td colspan="2">NOM-070-270C</td>
            <td class="letra-fondo" style="text-align: left">Fecha de primera revisión:</td>
            <td>2024-07-25 11:35:43</td>
        </tr>
        <tr>
            <td class="letra-fondo" style="text-align: left" colspan="2">No. De certificado:</td>
            <td colspan="2">CIDAM C-INS-088/2024</td>
            <td class="td-no-border"></td>
            <td class="td-no-border"></td>
        </tr>

    </table>
    <br>

    <table class="background-text">
        <tr>
            <td class="td-negrita">
                Nota: Para el llenado de la bitácora colocar {{-- <br>  --}}C= Cumple, NC= No Cumple, NA= No
                Aplica o {{-- <br> --}} bien una X en
                el recuadro correspondiente en {{-- <br> --}}cada uno de los requisitos y datos que estipula
                {{-- <br>  --}}la bitácora.
            </td>
        </tr>
    </table>
    <br>
    <table style="width:100%; border: none;">
        <tr class="sin-padding">
            <td style="vertical-align: top; text-align: left; border: none;">
                <table style="display: inline-table; width: 200px;" {{-- class="espacio_letras tabla-1" --}}>
                    <!-- ...contenido de la primera tabla... -->
                    <tr>
                        <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 110px;">Datos
                            generales del exportador
                        </td>
                        <td class="letra-fondo" style="width: 50px">C </td>
                        <td class="letra-fondo" style="width: 50px">N/C </td>
                        <td class="letra-fondo" style="width: 50px">N/A</td>
                    </tr>

                    <tr>
                        <td style="text-align: left"> Número de certificado</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">Domicilio </td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">País</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">Código postal</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Registro de productor autorizado (Uso de la DOM)</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Certificado de cumplimiento de la norma (NOM a Granel)</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">No. De convenio de corresponsabilidad </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="sin-border">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="sin-border">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="sin-border">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 110px;">Destinatario
                        </td>
                        <td class="letra-fondo" style="width: 45px">C </td>
                        <td class="letra-fondo" style="width: 45px">N/C </td>
                        <td class="letra-fondo"style="width: 45px">N/A</td>
                    </tr>

                    <tr>
                        <td style="text-align: left"> Nombre</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Domicilio </td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> país de destino </td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                </table>
                {{-- segunda tabla --}}

            </td>
            <td style="vertical-align: top; text-align: center; border: none;">
                <table style="display: inline-table; width: 300px;" {{-- class="tabla-2" --}}>
                    <!-- ...contenido de la segunda tabla... -->
                    <tr>
                        <td class="letra-fondo" style="padding-right: 0; text-align: left; width: 110px;">Descripción del embarque que ampara el certificado
                    </td>
                        <td class="letra-fondo" style="width: 50px">C </td>
                        <td class="letra-fondo" style="width: 50px">N/C </td>
                        <td class="letra-fondo" style="width: 50px">N/A</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Categoría</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Marca</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">Clase</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Volumen</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">% Alcohol volumen</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Cantidad de botellas / cajas</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Lugar de envasado</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> No. De lote a granel y envasado</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Número de análisis</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Aduana de despacho </td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Fracción arancelaria</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Número de factura proforma</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Tipo de maguey </td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Etiquetas </td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                    <tr>
                        <td style="text-align: left"> Corrugado</td>
                        <td>C</td>
                        <td>- -</td>
                        <td>- -</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </div>
</body>

</html>
