<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bitácora de revisión de certificados de Instalaciones NOM-070-SCFI-2016 F7.1-01-40 </title>
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
            font-size: 12px;
            margin-right: -30px;

        }

        .title {
            text-align: center;
            font-size: 17px;
        }

        .footer {
            position: absolute;
            transform: translate(0px, 180px);
            /* Mueve el elemento 50px en X y 50px en Y */
            text-align: center;
            font-size: 11px;
        }

        /*Tablas*/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 3px;
            font-size: 10.5px;
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

        .table-centered td {
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
            background-color: #8eaadb;
            text-align: center;

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
            margin-top: -40px;
            margin-left: -30px;


        }

        /* Estilo para el texto de fondo */
        .background-text {
            width: 100%;
            border: 1px solid black;
            font-family: 'Century Gothic';
            /* position: absolute; */
            /* top: 450px;
            left: 412px; */
            margin-bottom: 20px;
            padding: 5px;
            padding-bottom: 30px;
            /*  z-index: -1; */
            color: #000000;
            font-size: 12px;
            /* line-height: 1.4; */
            /* white-space: nowrap; */
            text-align: left;
        }

        .negrita {
            font-family: 'Century Gothic negrita';
        }

        .espacio_letras td {
            border: solid 1px black !important;
            padding: 3px 0 3px 2px;
            text-align: left;
        }

        .table-2 td {
            border: solid 1px black !important;
            padding: 3px 0 3px 2px;
            text-align: left;
        }

        /*  .underline {
            text-decoration: underline;
        } */
        .titulo {
            font-family: 'Century Gothic negrita';
            text-align: center;
            font-size: 13px;
            margin-bottom: 10px;
            margin-top: 20px;
        }
    </style>


    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        <div style="margin-top: 10px;"> Bitácora de revisión de certificado venta nacional NOM-070-SCFI-2016
            F7.1-01-52<br>Ed. 1 Entrada en vigor 18/09/2025<br>
            <span {{-- style="display:inline-block; width:650px; border-bottom:1.5px solid black;" --}}></span>
        </div>
    </div>
</head>

<body>
    <div class="titulo">
        PRIMERA REVISIÓN POR PARTE DEL CONSEJO PARA LA DECISIÓN DE LA CERTIFICACIÓN
    </div>
    <table>
        <tr>
            <td class="letra-fondo" style="text-align: left; width: 50px;" colspan="3">Razón social del cliente:</td>
            <td class="leftLetter" colspan="3" style="width: 200px;"></td>
        </tr>
        <tr>
            <td class="letra-fondo" style="text-align: left;  width: 50px; height: 30px;" colspan="2">No. Cliente:</td>
            <td colspan="2"></td>
            <td class="letra-fondo" style="text-align: left; width: 120px;">Fecha de revisión:</td>
            <td style="width: 150px;"></td>
        </tr>
        <tr>
            <td class="letra-fondo" style="text-align: left; height: 30px;" colspan="2">No. de Certificado:</td>
            <td colspan="2"></td>
            <td colspan="2" class="td-no-border"></td>
        </tr>
    </table>
    <br>
    {{--  --}}
    <table class="table-centered" width="100%" border="0">
        <tr>
            <td width="55%" valign="top" style="padding-right:90px;">
                {{-- table 1 width="100%" --}}
                <table width="100%" class="espacio_letras table-1">
                    <tr>
                        <td class="letra-fondo" style="padding-right: 0; text-align: center; width: 120px;">Datos
                            generales
                        </td>
                        <td class="letra-fondo" style="width: 45px; text-align: center;">C </td>
                        <td class="letra-fondo" style="text-align: center;">N/C </td>
                        <td class="letra-fondo" style="text-align: center;">N/A</td>
                    </tr>
                    <tr>
                        <td>
                            Número de certificado
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Domicilio Fiscal</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Código postal
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Registro de productor autorizado (Uso de la DOM)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Convenio de corresponsabilidad
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Domicilio de envasado</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                {{-- end table 1 --}}
                {{-- <table  width="100%">
            <tr><td>Tabla 1</td></tr>
            <tr><td>Dato 1</td></tr>
          </table> --}}
            </td>
            <td width="45%" valign="top">
                {{-- table 2  --}}
                {{-- tabla 2 --}}
                <table class="table-2">
                    <tr>
                        <td class="letra-fondo" style="padding-right: 0; text-align: center; width: 100px; height: 30px">
                            Descripción
                            del
                            embarque que
                            ampara el
                            certificado</td>
                        <td class="letra-fondo" style="text-align: center; width: 45px;">C </td>
                        <td class="letra-fondo" style="text-align: center;">N/C </td>
                        <td class="letra-fondo" style="text-align: center;">N/A</td>
                    </tr>
                    <tr>
                        <td>Categoría</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Clase
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Marca
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Presentación</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>% Alcohol volumen
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Cantidad de botellas / cajas
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Certificado de
                            cumplimiento de la
                            norma (NOM a Granel)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>No. De lote a granel y
                            envasado</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Número de análisis
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Folios de hologramas</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                {{-- end tabla 2 --}}
                {{-- <table width="100%">
                    <tr>
                        <td>Tabla 2</td>
                    </tr>
                    <tr>
                        <td>Dato 2</td>
                    </tr>
                </table> --}}
            </td>
        </tr>
    </table>
    {{--  --}}
    <br>
    <div class="background-text">
        Nota: Para el llenado de la bitácora colocar <span class="negrita">C</span>=
        Cumple, <span class="negrita">NC</span>= No Cumple, <span class="negrita">NA</span>= No Aplica o bien una X
        en el recuadro correspondiente en cada uno de los requisitos y datos que estipula la bitácora.
    </div>
    <table>
        <tr>
            <td style="text-align: center; height: 100px; padding: 10px; font-size: 12px; font-family: 'Century Gothic';">
                Derivado de la revisión minuciosa y con la documentación completa entregada de manera digital por
                personal del
                OC CIDAM se revisa que el certificado cumple con cada uno de los requisitos mencionados en este
                documento, por consiguiente, se toma la decisión para <span class="negrita">otorgar/denegar</span> la certificación de producto.<br>
                <span class="negrita">Responsable de Revisión:</span><br><br>
                <span class="negrita">Miembro del Consejo para la decisión de la certificación.</span>
                {{-- <div style="padding: 30px"></div> --}}
            </td>
        </tr>
    </table>
    <div style="position: fixed; bottom: 25px; left: 0; width: 100%; padding: 5px 0; z-index: 1000;">
        <p style="font-size: 11px; text-align: center; font-family: 'Century Gothic'; margin: 0;">
            Este documento
            es propiedad del Centro de
            Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser <br>
            distribuido externamente sin la autorización escrita del Director Ejecutivo.</p>
    </div>

</body>

</html>
