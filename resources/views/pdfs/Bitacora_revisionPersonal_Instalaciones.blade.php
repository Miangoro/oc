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

      /*   @font-face {
            font-family: 'Century Gothic';
            src: url('fonts/CenturyGothic.ttf') format('truetype');

        }

       @font-face {
            font-family: 'Century Gothic Negrita';
            src: url('fonts/GOTHICB.TTF') format('truetype');
        }*/

        .negrita {

            font-family: 'Century Gothic Negrita';
        }


        .header {
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
            padding: 4px;
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
        }

        .no-margin-top {
            margin-top: 0;
        }

        .no-padding {
            padding: 0;
        }

        .letra-fondo {
            color: black;
            font-size: 12px;
            background-color: #8cb2ee;
            text-align: center;

        }

        .letra-fondoOPcional {
            color: black;
            font-size: 12px;
            background-color: #c8daf8;
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
            margin-top: -20px;
            margin-left: -30px;


        }

        /* Estilo para el texto de fondo */
        .background-text {
            position: absolute;
            top: 248px;
            left: 365px;
            z-index: -1;
            color: #000000;
            font-size: 14px;
            line-height: 1.4;
            white-space: nowrap;
            text-align: left;
        }
    </style>


    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        <div style="font-size: 14px; margin-right: 25px"> Bitácora de revisión documental y aprobación por el personal del OC CIDAM <br>NOM-070-SCFI-2016
            <br>F7.1-01-49 Ed. 6 <br>Entrada en vigor 27/06/2024</div>

    </div>
</head>
<div style="height: 30px;"></div>
<body>
    <div class="background-text">
        <table class="letra-fondo" style="width: 310px">
            <tr>
                <td class="negrita" style="font-size: 9px; padding: 15px" colspan="4" >REVISIÓN CERTIFICADO INSTALACIONES</td>
            </tr>
            <tr>
                <td class="negrita" style="font-size: 8px; width: 120px;">DOCUMENTO</td>
                <td class="negrita" style="font-size: 8px">C</td>
                <td class="negrita" style="font-size: 8px">N/C</td>
                <td class="negrita" style="font-size: 8px">N/A</td>
            </tr>
        </table>
        <br>
        <table style="width: 310px; ;" >
            <tr>
                <td class="leftLetter" style="font-size: 6.5px; width: 120px; ">SOLICITUD DEL SERVICIO DE <br>
                    DICTAMINACION DE INSTALACIONES</td>
                <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta6']['respuesta']) && $respuestas['pregunta6']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta6']['respuesta']) && $respuestas['pregunta6']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta6']['respuesta']) && $respuestas['pregunta6']['respuesta'] == 'NA' ? 'NA' : '---' }}</td>
            </tr>
            <tr>
                <td class="leftLetter" style="font-size: 6.5px; "> NÚMERO DE CERTIFICADO DE <br>
                    INSTALACIONES</td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta7']['respuesta']) && $respuestas['pregunta7']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta7']['respuesta']) && $respuestas['pregunta7']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta7']['respuesta']) && $respuestas['pregunta7']['respuesta'] == 'NA' ? 'NA' : '---' }}</td>
            </tr>
            <tr>
                <td class="leftLetter" style="font-size: 6.5px; ">NOMBRE DE LA EMPRESA O <br>
                    PERSONA FÍSICA</td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta8']['respuesta']) && $respuestas['pregunta8']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta8']['respuesta']) && $respuestas['pregunta8']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta8']['respuesta']) && $respuestas['pregunta8']['respuesta'] == 'NA' ? 'NA' : '---' }}</td>
            </tr>
            <tr>
                <td class="leftLetter" style="font-size: 6.5px; ">DOMICILIO FISCAL DE LAS <br>
                    INSTALACIONES </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta9']['respuesta']) && $respuestas['pregunta9']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta9']['respuesta']) && $respuestas['pregunta9']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta9']['respuesta']) && $respuestas['pregunta9']['respuesta'] == 'NA' ? 'NA' : '---' }}</td>
            </tr>
            <tr>
                <td class="leftLetter" style="font-size: 6.5px; ">CORREO ELECTRONICO Y NUMERO <br>
                    TELEFONICO </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta10']['respuesta']) && $respuestas['pregunta10']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta10']['respuesta']) && $respuestas['pregunta10']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta10']['respuesta']) && $respuestas['pregunta10']['respuesta'] == 'NA' ? 'NA' : '---' }}</td>
            </tr>
            <tr>
                <td class="leftLetter" style="font-size: 6.5px; ">FECHA DE VIGENCIA Y <br>
                    VENCIMIENTO DEL CERTIFICADO </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta11']['respuesta']) && $respuestas['pregunta11']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta11']['respuesta']) && $respuestas['pregunta11']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta11']['respuesta']) && $respuestas['pregunta11']['respuesta'] == 'NA' ? 'NA' : '---' }}</td>
            </tr>
            <tr>
                <td class="leftLetter" style="font-size: 6.5px; ">ALCANCE DE LA CERTIFICACIÓN </td>
                <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta12']['respuesta']) && $respuestas['pregunta12']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta12']['respuesta']) && $respuestas['pregunta12']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta12']['respuesta']) && $respuestas['pregunta12']['respuesta'] == 'NA' ? 'NA' : '---' }}</td>
            </tr>
            <tr>
                <td class="leftLetter" style="font-size: 6.5px; ">NO. DE CLIENTE</td>
                <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta13']['respuesta']) && $respuestas['pregunta13']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta13']['respuesta']) && $respuestas['pregunta13']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta13']['respuesta']) && $respuestas['pregunta13']['respuesta'] == 'NA' ? 'NA' : '---' }}</td>
            </tr>
            <tr>
                <td class="leftLetter" style="font-size: 6.5px; ">NÚMERO DE DICTAMEN EMITIDO <br>
                    POR LA UVEM </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta14']['respuesta']) && $respuestas['pregunta14']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta14']['respuesta']) && $respuestas['pregunta14']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta14']['respuesta']) && $respuestas['pregunta14']['respuesta'] == 'NA' ? 'NA' : '---' }}</td>
            </tr>
            <tr>
                <td class="leftLetter" style="font-size: 6.5px; ">ACTA DE LA UNIDAD DE INSPECCIÓN <br>
                    (FECHA DE INICIO, TÉRMINO Y <br>
                    FIRMAS)
                    </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta15']['respuesta']) && $respuestas['pregunta15']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta15']['respuesta']) && $respuestas['pregunta15']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta15']['respuesta']) && $respuestas['pregunta15']['respuesta'] == 'NA' ? 'NA' : '---' }}</td>
            </tr>
            <tr>
                <td class="leftLetter" style="font-size: 6.5px; ">NOMBRE Y PUESTO DEL <br>
                    RESPONSABLE DE LA EMISIÓN DEL <br>
                    CERTIFICADO
                    </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta16']['respuesta']) && $respuestas['pregunta16']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta16']['respuesta']) && $respuestas['pregunta16']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta16']['respuesta']) && $respuestas['pregunta16']['respuesta'] == 'NA' ? 'NA' : '---' }}</td>
            </tr>
            <tr>
                <td class="leftLetter" style="font-size: 6.5px;">NOMBRE Y DIRECCIÓN DEL <br>
                    ORGANISMO CERTIFICADOR CIDAM</td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta17']['respuesta']) && $respuestas['pregunta17']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta17']['respuesta']) && $respuestas['pregunta17']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                    <td style="font-size: 6.5px; "> {{ isset($respuestas['pregunta17']['respuesta']) && $respuestas['pregunta17']['respuesta'] == 'NA' ? 'NA' : '---' }}</td>
            </tr>
        </table>
    </div>

    <table>
        <tr>
            <td class="letra-fondo negrita " style="text-align: right; padding-top: 0; padding-bottom: 0">RAZON SOCIAL O NOMBRE DEL CLIENTE:</td>
            <td class="negrita" style="padding-top: 0; padding-bottom: 0">{{ $razon_social }}</td>
        </tr>
        <tr>
            <td class="letra-fondo negrita " style="text-align: right; padding-top: 0; padding-bottom: 0">NO. CLIENTE:</td>
            <td class="negrita" style="padding-top: 0; padding-bottom: 0">{{ $numero_cliente }}</td>
        </tr>
        <tr>
            <td class="letra-fondo negrita" style="text-align: right; padding-top: 0; padding-bottom: 0">NO. DE CERTIFICADO:</td>
            <td class="negrita" style="padding-top: 0; padding-bottom: 0">{{ $num_certificado }}</td>
        </tr>
        <tr>
            <td class="letra-fondo negrita " style="text-align: right; padding-top: 0; padding-bottom: 0">TIPO DE CERTIFICADO:</td>
            <td class="negrita" style="padding-top: 0; padding-bottom: 0">{{ $tipo_certificado }}</td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td class="td-no-border" style="width: 340px;padding-top: 0; padding-bottom: 0">&nbsp;</td>
            <td class="leftLetter" style="padding-top: 0; padding-bottom: 0; font-size: 9px">C= Cumple, NC= No Cumple, NA= No Aplica</td>
            <td class="td-no-border" style="width: 25px;padding-top: 0; padding-bottom: 0">&nbsp;</td>
        </tr>
    </table>
    <div style="height: 10px"></div>
    <table style="width: 325px">
        <tr>
            <td class="letra-fondo negrita" colspan="4" style="font-size: 9px">REVISIÓN DOCUMENTAL PARA LA TOMA DE DECISIÓN PARA LA <br>
                CERTIFICACIÓN DE CERTIFICADOS DE GRANEL, EXPORTACIÓN, <br>
                NACIONAL Y/O INSTALACIONES.<br>
        </tr>
    
        <tr>
            <td class="letra-fondoOPcional" style="font-size: 7.5px;">DOCUMENTO</td>
            <td class="letra-fondoOPcional" style="font-size: 7.5px;">C</td>
            <td class="letra-fondoOPcional" style="font-size: 7.5px;">N/C</td>
            <td class="letra-fondoOPcional" style="font-size: 7.5px;">N/A</td>
        </tr>
        <tr>
            <td style="padding-top: 0; padding-bottom: 0; font-size: 7.5px;text-align: left">CONTRATO DE <br>
                PRESTACIÓN DE <br>
                SERVICIOS</td>
            <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta1']['respuesta']) && $respuestas['pregunta1']['respuesta'] == 'C' ? 'C' : '---' }} </td>
            <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta1']['respuesta']) && $respuestas['pregunta1']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
            <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta1']['respuesta']) && $respuestas['pregunta1']['respuesta'] == 'NA' ? 'NA' : '---' }} </td>                
        </tr>
        <tr>
            <td style="padding-top: 0; padding-bottom: 0; font-size: 7.5px;text-align: left">CONSTANCIA SITUACIÓN <br>
                FISCAL Y RFC</td>
                <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta2']['respuesta']) && $respuestas['pregunta2']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta2']['respuesta']) && $respuestas['pregunta2']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta2']['respuesta']) && $respuestas['pregunta2']['respuesta'] == 'NA' ? 'NA' : '---' }} </td> 
        </tr>
        <tr>
            <td style=" font-size: 7.5px;text-align: left">CARTA NO. CLIENTE</td>
            <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta3']['respuesta']) && $respuestas['pregunta3']['respuesta'] == 'C' ? 'C' : '---' }} </td>
            <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta3']['respuesta']) && $respuestas['pregunta3']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
            <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta3']['respuesta']) && $respuestas['pregunta3']['respuesta'] == 'NA' ? 'NA' : '---' }} </td> 
        </tr>
        <tr>
            <td style="padding-top: 0; padding-bottom: 0; font-size: 7.5px;text-align: left">NOMBRE DE LA EMPRESA <br>
                O PERSONA FÍSICA</td>
                <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta4']['respuesta']) && $respuestas['pregunta4']['respuesta'] == 'C' ? 'C' : '---' }} </td>
                <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta4']['respuesta']) && $respuestas['pregunta4']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
                <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta4']['respuesta']) && $respuestas['pregunta4']['respuesta'] == 'NA' ? 'NA' : '---' }} </td> 
        </tr>
        <tr>
            <td style="padding-top: 0; padding-bottom: 0; font-size: 7.5px;text-align: left">DIRECCIÓN FISCAL</td>
            <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta5']['respuesta']) && $respuestas['pregunta5']['respuesta'] == 'C' ? 'C' : '---' }} </td>
            <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta5']['respuesta']) && $respuestas['pregunta5']['respuesta'] == 'NC' ? 'NC' : '---' }} </td>
            <td style="font-size: 7.5px"> {{ isset($respuestas['pregunta5']['respuesta']) && $respuestas['pregunta5']['respuesta'] == 'NA' ? 'NA' : '---' }} </td> 
        </tr>
       
    </table>
    <br>
    <table style="width: 325px">
        <tr>
            <td style="background-color: #FFE598; text-align: left; font-size: 9px;padding-top: 0; padding-bottom: 0;"><div> <span class="negrita"> NOTA:</span>Resaltar el recuadro correspondiente para la toma de la <br>
                decisión para la certificación. Si la decisión es negativa explicar el <br>
                motivo por el cuál no es apto pasar al Consejo para la Decisión de <br>
                la Certificación para poder emitir el certificado. <br>
                <span class="negrita">*Cancelar los recuadros que no sean utilizados*.</span></div></td>
        </tr>
    </table>
    <br>

<!-- Tabla decision -->
<table style="width: 340px">
    <tr>
        <td class="letra-fondo negrita" style="font-size: 10.5px; padding-top: 0" colspan="2">
            TOMA DE DECISIÓN PARA LA CERTIFICACIÓN POR PARTE DEL PERSONAL DEL OC CIDAM
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-size: 8px; padding: 0">
            Derivado de la revisión minuciosa y con la documentación completa entregada de manera digital y/o física por el cliente, el personal del OC CIDAM determina que:
        </td>
    </tr>
    <tr>
        <td style="background-color: {{ $decision == 'positiva' ? '#b6d7a7' : 'white' }}; font-size: 10px; padding-top: 0; vertical-align: top; width: 50%; text-align: center;">
            SI
        </td>
        <td style="background-color: {{ $decision == 'negativa' ? '#b6d7a7' : 'white' }}; font-size: 10px; padding-top: 0; vertical-align: top; width: 50%; text-align: center;">
            NO
        </td>
    </tr>
    <tr>
        @if($decision === 'positiva')
            <!-- Si la decisión es "SI", la celda de "SI" tiene contenido y la de "NO" está vacía -->
            <td class="leftLetter" style="background-color: #b6d7a7; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: justify;">
                Cumple con cada uno de los requisitos mencionados en este documento para poder
                turnarse a uno de los miembros del Consejo para la decisión de la Certificación y decidan
                otorgar o denegar la certificación de (producto Y/O instalaciones, según corresponda) y así
                emitir el certificado correspondiente.
            </td>
            <td style="color: red; background-color: white; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: center;">
                ---
            </td>
        @elseif($decision === 'negativa')
            <!-- Si la decisión es "NO", la celda de "NO" tiene contenido y la de "SI" está vacía -->
            <td class="leftLetter" style="background-color: white; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: center;">
                ---
            </td>
            <td style="color: red; background-color: #b6d7a7; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: justify;">
                No cumple con cada uno de los requisitos mencionados en este documento para poder
                turnarse a uno de los miembros del Consejo para la decisión de la Certificación y decidan
                otorgar o denegar la certificación de (producto Y/O instalaciones, según corresponda) y así
                emitir el certificado correspondiente.
            </td>
        @else
            <!-- Si no hay decisión, dejar ambas celdas con "---" -->
            <td class="leftLetter" style="background-color: white; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: center; height: 100px;">
                ---
            </td>
            <td style="color: red; background-color: white; font-size: 7px; padding-top: 0; padding-bottom: 0; text-align: center;">
                ---
            </td>
        @endif
    </tr>
</table>
<!-- end -->

    <br>
    
    <table style="width: 340px">
        <tr>
            <td class="letra-fondo negrita" colspan="2" style="font-size: 10.5px; padding-top: 0; vertical-align: top"> FIRMAS DE LAS PERSONAS RESPONSABLES DE LA TOMA DE
                DECISIÓN</td>
        </tr>
        <tr>
            <td class="letra-fondo negrita" style="font-size: 10px; padding-top: 0; vertical-align: top;padding-left: 0; width: 175px">NOMBRE, FIRMA , FECHA Y CARGO <br>
                DE QUIEN HACE LA REVISIÓN
                </td>
            <td class="leftLetter" style="font-size: 8px;padding-top: 0">{{ $id_revisor }} <br>
                Revisión realizada {{ $fecha }} 
                el Certificado Revisión por el <br>
                personal OC {{ ucfirst($decision) }} <div style="padding-top: 25px"></div>
            </td>
        </tr>
        <tr>
            <td class="letra-fondo negrita" style="font-size:10px; padding-top: 0; vertical-align: top; padding-left: 0">NOMBRE, FIRMA , FECHA Y CARGO <br>
                DE QUIEN TOMA LA APROBACIÓN</td>
            <td class="leftLetter" style="font-size: 8px;padding-top: 0">{{ $id_aprobador }} <br>
                Gerente Técnico del Organismo <br>
                Certificador de CIDAM <br>
                {{ $fecha_aprobacion }}  {{ ucfirst($aprobacion) }}<div style="padding-top: 20px"></div>
            </td>
        </tr>
    </table>

</body>