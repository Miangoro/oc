<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Plan de auditoría de esquema de certificación</title>
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


        body {
            font-family: 'Century Gothic', sans-serif;
            font-size: 10px;

        }

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
            border: 3px solid black;
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
            border-bottom: 3px solid black;
            border-top: none;
            border-right: 3px solid black;
            border-left: 3px solid black;

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

        .no-padding-up-down {
            padding-top: 0;
            padding-bottom: 0;
        }


        .no-padding-r-l {
            padding-right: 0;
            padding-left: 0;
        }

        .letra-fondo {
            color: white;
            font-size: 12px;
            background-color: #028457;
            text-align: center;
            font-family: 'Century Gothic Negrita';


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
            margin-left: -30px;


        }

        .img-background {
            position: absolute;
            top: 400px;
            left: -385px;
            width: 780px;
            height: 650px;
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/logo_fondo.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.2;
        }

        .page-break {
            page-break-before: always;
        }

    
        .footer {
            position: fixed;
            bottom: 20%;
            width: 100%;
            color: #71777c;
            font-size: 8px;
        }
    </style>
</head>

<body>

   <div class="footer">
        <p style="text-align: center; width: 80%; position: relative; padding-left: 7%;">
            Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no<br>
            puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo
        </p>
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM"
            style="position: absolute; top: -2%; right: -7%; height: 70px;">
    </div>


    <div class="img-background"></div>

    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
        <div style="padding-right: 20px">Plan de auditoría de esquema de certificación NOM-070-SCFI-2016
            F7.1-01-13<br>Edición 2 Entrada en Vigor: 08/03/2023
            <br>_______________________________________________________________________________________
        </div>
    </div>

    <body>
        <div style="text-align: right; font-size: 12px; padding-bottom: 10px">
            <span class="negrita">Plan de Auditoría. No: </span>{{$datos->solicitud->folio ?? 'No encontrado'}}<br>
            <span class="negrita">Fecha de liberacióndel plan: </span> 
        </div>
        <table>
            <tr>
                <td class="letra-fondo" style="font-size: 14px" colspan="4">1. DATOS GENERALES DEL CLIENTE</td>
            </tr>
            <tr>
                <td class="letra-fondo" style="width: 150px">Nombre / Razón Social:</td>
                <td class="leftLetter" style="width: 240px">{{$datos->solicitud->empresa->razon_social ?? 'No encontrado'}}</td>
                <td class="letra-fondo" style="width: 110px">No. De <br>
                    Cliente:</td>
                <td class="leftLetter">{{$num_cliente}}</td>
            </tr>
            <tr>
                <td class="letra-fondo">Dirección:</td>
                <td colspan="3" class="no-padding-up-down" style="font-size: 11px">
                    {{$datos->solicitud->empresa->domicilio_fiscal ?? 'No encontrado'}}
                </td>
            </tr>
            <tr>
                <td class="letra-fondo" rowspan="2">Persona de contacto:</td>
                <td class="leftLetter" rowspan="2">{{$datos->solicitud->empresa->representante ?? 'No encontrado'}}</td>
                <td class="letra-fondo no-padding-up-down">Correo: </td>
                <td class="leftLetter no-padding-up-down">{{$datos->solicitud->empresa->correo ?? 'No encontrado'}}
                </td>
            </tr>
            <tr>
                <td class="letra-fondo">Teléfono:</td>
                <td class="leftLetter">{{$datos->solicitud->empresa->telefono ?? 'No encontrado'}}</td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td class="letra-fondo" style="font-size: 14px" colspan="4">2. DATOS DE LA AUDITORÍA
                </td>
            </tr>
            <tr>
                <td class="letra-fondo" style="width: 150px">Servicio:</td>
                <td class="leftLetter" style="width: 240px">{{$datos->solicitud->tipo_solicitud->tipo ?? 'No encontrado'}}</td>
                <td class="letra-fondo">Tipo de auditoría:</td>
                <td class="leftLetter"> </td>
            </tr>
            <tr>
                <td class="letra-fondo" style="width: 150px">Información adicional:</td>
                <td  style="width: 220px; color: red"> </td>
                <td class="letra-fondo">Fecha de la <br>auditoría:</td>
                <td class="leftLetter"> {{ $fecha_inspeccion1}}</td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="letra-fondo td-border" style="font-size: 14px" colspan="2">3. DATOS DEL PRODUCTO</td>
            </tr>
            <tr>
                <td class="letra-fondo" style="width: 250px">Producto(s): </td>
                <td class="leftLetter">   </td>
            </tr>
            <tr>
                <td class="letra-fondo">País destino del producto:</td>
                <td style="color: red">{{ $datos->solicitud->direccion_destino->direccion ?? 'NA'}}</td>
            </tr>

        </table>
        <br>
        <table>
            <tr>
                <td class="letra-fondo" style="font-size: 14px" colspan="2">4. CARACTERÍSTICAS DE LA AUDITORÍA
                </td>
            </tr>
            <tr>
                <td class="letra-fondo" style="width: 200px">Objetivo:</td>
                <td class="leftLetter">   </td>
            </tr>
            <tr>
                <td class="letra-fondo">Alcance:</td>
                <td class="leftLetter">   </td>
            </tr>
            <tr>
                <td class="letra-fondo no-padding-up-down">Criterios de evaluación:</td>
                <td class="leftLetter no-padding-up-down">   </td>
            </tr>
            <tr>
                <td class="letra-fondo">Otros (indique):</td>
                <td style="color: red">&nbsp;     </td>
            </tr>
        </table>


        {{------ PAGINA 2 ------}}
        <div class="page-break"></div>
        <div class="img-background"></div>

        <div class="header">
            <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
            <div style="padding-right: 20px">Plan de auditoría de esquema de certificación NOM-070-SCFI-2016
                F7.1-01-13<br>Edición 2 Entrada en Vigor: 08/03/2023
                <br>_______________________________________________________________________________________
            </div>
        </div>

        <div style="height: 40px"></div>
        <table>
            <tr>
                <td class="letra-fondo" style="font-size: 14px" colspan="3">5. DATOS DEL GRUPO EVALUADOR</td>
            </tr>
            <tr>
                <td class="letra-fondo">Designación:</td>
                <td class="letra-fondo">Nombre: </td>
                <td class="letra-fondo">Teléfono y correo electrónico:</td>
            </tr>
            <tr>
                <td >Inspector</td>
                <td >{{ $datos->inspector->name ?? 'No encontrado' }}</td>
                <td>{{ $datos->inspector->telefono ?? 'No encontrado' }} , {{ $datos->inspector->email ?? 'No encontrado' }}</td>
            </tr>
            <tr>
                <td>Auditor</td>
                <td>{{ $auditor }}</td>
                <td>{{ $auditor_telefono }} , {{ $auditor_email }}</td>
            </tr>
        </table>

        <br>
        <table>
            <tr>
                <td class="letra-fondo" style="font-size: 14px" colspan="5">6. DESCRIPCIÓN DE ACTIVIDADES DE AUDITORÍA</td>
            </tr>
            <tr>
                <td class="letra-fondo no-padding">Fecha:</td>
                <td class="letra-fondo no-padding">Inspector/ <br>Auditor:</td>
                <td class="letra-fondo" style="width: 370px">Actividad:</td>
                <td class="letra-fondo no-padding">Horario:</td>
                <td class="letra-fondo no-padding">Aplica <br>(Auditados)</td>
            </tr>
            <tr>
                <td class="no-padding">{{ $fecha_inspeccion2 }}</td>
                <td class="no-padding">{{ $datos->inspector->name ?? 'No encontrado' }}</td>
                <td class="no-padding">   </td>
                <td class="no-padding">   </td>
                <td class="no-padding">   </td>
            </tr>
        </table>
        <br>
        <table>
            <tr>
                <td class="letra-fondo" style="font-size: 14px" colspan="4">6. DESCRIPCIÓN DE ACTIVIDADES DE
                    AUDITORÍA
                </td>
            </tr>
            <tr>
                <td class="letra-fondo no-padding-up-down">Nombre del Inspector:</td>
                <td class="no-padding-up-down" colspan="3">{{ $datos->inspector->name ?? 'No encontrado' }}</td>
            </tr>
            <tr>
                <td class="letra-fondo no-padding-r-l">Acepta o rechaza el plan de <br>auditoría:</td>
                <td style="width: 140px">   </td>
                <td class="letra-fondo no-padding-r-l">Nombre del cliente o persona <br>autorizada que acepta o rechaza <br>el plan</td>
                <td style="width: 140px"> {{ $datos->solicitud->empresa->razon_social ?? 'No encontrado' }} </td>
            </tr>
            <tr>
                <td class="letra-fondo">Políticas:</td>
                <td class="leftLetter" style="font-size: 8px" colspan="3">1. Aceptar o rechazar el presente plan
                    de auditoria antes de 48 horas, de lo contrario se considera <br>
                    aceptado.<br>
                    2. Comunicarse previamente, mínimo 3 días previos a la auditoria, con el auditor asignado por el<br>
                    Organismo<br>
                    Certificador con la finalidad de coordinar la actividad en sitio.<br>
                    3. En caso de conflicto de interés, se debe notificar al Organismo de Certificación previamente.<br>
                    4. Para realizarel servicio de certificación se contratará una Unidad de Verificación y Laboratorios
                    de<br>
                    pruebas.</td>
            </tr>
        </table>


    </body>
</html>
