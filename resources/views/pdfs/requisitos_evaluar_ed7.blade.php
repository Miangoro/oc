<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisitos a evaluar</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        @page {
            margin: 100px 30px;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 120px;
            /* Ajusta según el diseño institucional */
            padding: 0;
            /* Asegura que no haya espacio extra */
        }

        .header img {
            margin-top: -85px;
            /* Baja la imagen */
            margin-bottom: 0px;
            /* Evita que se desplace más abajo */
            vertical-align: top;
        }

        .logo {
            margin-left: 30px;
            width: 150px;
            display: block;
        }

        .description1,
        .description2,
        .description3 {
            position: fixed;
            right: 30px;
            text-align: right;
        }

        .description1 {
            margin-right: 30px;
            top: -50px;
            font-size: 14px;
        }

        .description2 {
            margin-right: 30px;
            top: -30px;
            font-size: 14px;
        }

        .description3 {
            margin-right: 30px;
            top: -10px;
            font-size: 14px;
            border-bottom: 1px solid black;
            padding-bottom: 5px;
            width: 63%;
            display: inline-block;
        }

        .footer {
            position: absolute;
            bottom: -50px;
            left: 60px;
            right: 60px;
            width: calc(100% - 60px);
            font-size: 11px;
            text-align: center;
        }

        .footer .page-number {
            position: absolute;
            right: -10px;
            font-size: 10px;
            top: -15px;
        }

        .page-break {
            page-break-before: always;
        }

        .content {
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 80px;
            margin-bottom: 70px;
        }

        .content2 {
            margin-left: 20px;
            margin-right: 20px;
            margin-bottom: 70px;
        }

        .title {
            margin-left: 20px;
            text-align: center;
            color: #000000ff;
            font-size: 12px;
            margin-top: -70px;
            font-weight: bold;
        }

        .title2 {
            margin-left: 38px;
            text-align: left;
            color: #000000ff;
            margin-top: 20px;
            font-weight: bold;
            font-size: 15px;
            line-height: 2;
        }

        .title3 {
            text-align: center;
            color: #1F497D;
            margin-top: 90px;
            font-weight: bold;
            font-size: 16px;
            line-height: 2;
        }

        .subtitle {
            margin-left: 5px;
            font-size: 14px;
            margin-bottom: -10px;
        }

        .subtitle2 {
            margin-left: 25px;
            font-size: 14px;
            font-weight: bold;
        }

        .subtitle3 {
            margin-top: -20px;
            margin-left: 25px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 60px;
        }

        .subtitlex {
            margin-top: 30px;
            margin-left: 25px;
            font-size: 14px;
            font-weight: bold;
        }

        .subtitle-nn {
            margin-top: 2px;
            margin-left: 25px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: -2px;
        }

        .subtitle4 {
            margin-top: -25px;
            margin-left: 25px;
            font-size: 14px;
            font-weight: bold;
        }



        table {
            width: 90%;
            border: 1px solid #000000ff;
            border-collapse: collapse;
            margin: auto;
            margin-top: -70px;
            font-size: 13px;
            line-height: 1;
            vertical-align: top;
            font-family: Arial, Helvetica, Verdana;
        }

        td,
        th {
            border: 1px solid #000000ff;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
            font-weight: normal;
        }


        td {
            width: 50%;
        }

        .colum-n {
            vertical-align: middle;
            text-align: center;

        }

        .colum-p {
            vertical-align: middle;
            text-align: center;
        }

        .colum-x {
            vertical-align: middle;
            text-align: center;
            text-align: justify;
        }

        .colum-s {
            vertical-align: middle;
            text-align: justify;
            font-weight: bold;
        }

        .bullet {
            margin-top: -10px;
            margin-left: 20px;
            margin-bottom: 20px;
            line-height: 1.5;
            font-size: 13px;
        }

        .table-container {
            display: inline-block;
            vertical-align: top;
            margin-left: 350px;
            margin-top: -70px;
        }

        

        .table-x {
            width: 40%;
            margin-top: 60px;
            margin-left: 20px;
        }

        .nota {
            margin-left: 35px;
            font-size: 13px;
            text-align: justify;
            margin-right: 450px;
            color: #243F60;
            font-weight: bold;
            margin-top: -2px;
        }

        .nota2 {
            margin-left: 35px;
            font-size: 13px;
            text-align: justify;
            margin-right: 35px;
            color: #243F60;
            margin-top: 40px;
            font-weight: bold;
        }

        .nota3 {
            margin-left: 35px;
            font-size: 13px;
            text-align: justify;
            margin-right: 35px;
            color: #243F60;
            margin-top: 1px;
            font-weight: bold;
        }

        .img-botellas-right {
            float: right;
            margin-right: 100px;
            margin-top: -150px;
            width: 250px;
        }

        .final {
            margin-top: 70px;
        }

        .t-final {
            margin-top: 40px;
            margin-left: 40px;
            color: #E36C09;
            font-size: 14px;
        }



        .cuadro {
            text-align: justify;
        }

        
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM" class="logo">
    </div>

    <div class="description1">Requisitos a evaluar NOM-070-SCFI-2016 F7.1-01-09 </div>
    <div class="description2">Edición 7 Entrada en Vigor: 28/04/2025</div>
    <div class="description3"></div>

    <div class="content">
        <p class="title">NOM-070-SCFI-2016</p>
    </div>

    <table>
        <tbody>
            <tr>
                <td class="colum-n" style="background-color: #80a1e4ff;">Cliente:</td>
                <td colspan="3" class="colum-n"></td>
            </tr>
            <tr>
                <td class="colum-n" style="background-color: #80a1e4ff;">Numero del cliente:</td>
                <td class="colum-p"></td>
                <td class="colum-n" style="background-color: #80a1e4ff;">Fecha de revisión de
                    expediente:</td>
                <td class="colum-n"></td>
            </tr>
            <tr>
                <td class="colum-n" style="background-color: #80a1e4ff;">Nombre de quien realiza la revisión del
                    expediente:</td>
                <td class="colum-n"></td>
                <td class="colum-n" style="background-color: #80a1e4ff;">Firma de quien realiza la
                    revisión del expediente:</td>
                <td class="colum-n"></td>
            </tr>
        </tbody>
    </table>

    <p class="title2">
        <strong><u>I. REQUISITOS PRODUCTOR DE MAGUEY</u></strong>
    </p>

    <br><br><br>

    <table>
        <tbody>
            <tr>
                <td class="colum-n" style="width: 35%; background-color: #8aaef7; height: 20px;">Dirección de
                    instalación:</td>
                <td class="colum-n" style="width: 65%;"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>


    <table>
        <thead>
            <tr style="background-color: #ffffffff;">
                <th class="colum-n" style="width: 1%;">C/NC</th>
                <th class="colum-n" style="width: 280%; font-weight: bold;">Requisito documental</th>
                <th class="colum-n" style="width: 150%;">Observaciones</th>
            </tr>
        </thead>

       <tbody>
     @foreach ($data->where('tipo', 1) as $index => $pregunta)
                <tr style="background-color: {{ $index % 2 == 0 ? '#e8e8e8' : '#ffffff' }};">
                    <td class="colum-n"></td>
                    <td class="colum-x">{{ $pregunta->pregunta }}</td>
                    <td class="colum-n"></td>
                </tr>
            @endforeach
</tbody>
    </table>
    <table
        style="width: 90%; margin: auto; border-collapse: collapse; font-size: 11px; font-family: 'Arial', sans-serif;">
        <tbody>
            <tr style="background-color: #ffffff;">
                <td colspan="3" class="colum-s" style="font-weight: bold; text-align: left;">
                    En caso de nombrar a un representante o responsable de trámites, anexar:
                </td>
            </tr>
            <tr style="background-color: #ffffff;">
                <td style="width: 1%;"></td>
                <td style="width: 280%;">Copia de identificación oficial vigente de la persona autorizada.</td>
                <td style="width: 150%;"></td>
            </tr>
            <tr style="background-color: #e8e8e8ff;">
                <td></td>
                <td>Carta de designación de persona autorizada para realizar los trámites ante el Organismo Certificador
                    CIDAM.</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div style="width: 90%; margin: 20px auto; font-family: 'Arial', sans-serif; font-size: 12px;">
        <p style="font-weight: bold; text-decoration: underline; margin-bottom: 10px;">
            Nota: No requiere infraestructura ni equipamiento
        </p>
    </div>
     <div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y
            no puede ser distribuido
            externamente sin la autorización escrita del Director Ejecutivo
        </div>

    </div>


    <p class="title2">
        <strong><u>II. REQUISITOS PRODUCTOR DE MEZCAL</u></strong>
    </p>

    <br><br><br>

    <table>
        <tbody>
            <tr>
                <td class="colum-n" style="width: 35%; background-color: #8aaef7; height: 20px;">Dirección de
                    instalación:</td>
                <td class="colum-n" style="width: 65%;"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>

    <table>
        <thead>
            <tr style="background-color: #ffffffff;">
                <th class="colum-n" style="width: 1%;">C/NC</th>
                <th class="colum-n" style="width: 280%; font-weight: bold;">Requisito documental</th>
                <th class="colum-n" style="width: 150%;">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->where('tipo', 2) as $index => $pregunta)
                <tr style="background-color: {{ $index % 2 == 0 ? '#e8e8e8' : '#ffffff' }};">
                    <td class="colum-n"></td>
                    <td class="colum-x">{{ $pregunta->pregunta }}</td>
                    <td class="colum-n"></td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y
            no puede ser distribuido
            externamente sin la autorización escrita del Director Ejecutivo
        </div>

    </div>

    <!-- ░ REPRESENTANTE O RESPONSABLE DE TRÁMITES ░ -->
    <table
        style="width: 90%; margin: auto; border-collapse: collapse; font-size: 11px; font-family: 'Arial', sans-serif;">
        <tbody>
            <tr style="background-color: #ffffff;">
                <td colspan="3" class="colum-s" style="font-weight: bold; text-align: left;">
                    En caso de nombrar a un representante o responsable de trámites, anexar:
                </td>
            </tr>
            <tr style="background-color: #ffffff;">
                <td style="width: 1%;"></td>
                <td style="width: 280%;">Copia de identificación oficial vigente de la persona autorizada.</td>
                <td style="width: 150%;"></td>
            </tr>
            <tr style="background-color: #e8e8e8ff;">
                <td></td>
                <td>Carta de designación de persona autorizada para realizar los trámites ante el Organismo Certificador
                    CIDAM.</td>
                <td></td>
            </tr>
        </tbody>
    </table>



    <!-- ░ BLOQUE INFRAESTRUCTURA Y EQUIPO ░ -->
    <table
        style="width: 90%; margin: auto; border-collapse: collapse; font-size: 10px; font-family: 'Arial', sans-serif;">
        <tbody>
            <!-- INFRAESTRUCTURA -->
            <tr style="background-color: #ffffff;">
                <td colspan="1" class="colum-s"
                    style="font-weight: bold; text-align: center; text-decoration: underline; font-size: 11px;">
                    I N F R A E S T R U C T U R A
                </td>
            </tr>
            @php
                $infraestructura = [
                    'Área de recepción de Materia Prima' => 'Espacio para recibir el Maguey que se someterá a proceso, no es necesario que sea techado ni piso firme.',
                    'Área de Pesado' => 'Espacio donde se pesarán las piñas del Maguey debiendo tener una báscula de al menos 500 kg., no es necesario que sea techado ni piso firme.',
                    'Área de Cocción' => 'Horno de piso, horno de mampostería o autoclave para el cocimiento del Maguey. No es necesario que sea techado ni piso firme.',
                    'Área de Maguey Cocido' => 'Espacio donde se colocará el Maguey cocido que se someterá a molienda, no es necesario que sea techado ni piso firme.',
                    'Área de Molienda' => 'Espacio donde se realiza la maceración del Maguey cocido con mazo, tahona, desgarradora, tren de molinos o difusor. No es necesario que sea techado ni piso firme.',
                    'Área de Fermentación' => 'Espacio donde se encuentran las tinas o tanques para llevar a cabo la fermentación, no es necesario que sea techado ni piso firme.',
                    'Área de Destilación' => 'Espacio donde se realiza la destilación de los jugos fermentados en alambiques de caldera de cobre u olla de barro o columnas, no es necesario que sea techado ni piso firme.',
                    'Almacén de Graneles' => 'Espacio donde se encuentran los recipientes del mezcal, es necesario que esté techado y con paredes de acuerdo a los materiales utilizados en la región, no es necesario piso firme.'
                ];
            @endphp

            @foreach($infraestructura as $area => $detalle)
                <tr style="background-color: {{ $loop->index % 2 == 0 ? '#ffffff' : '#e8e8e8ff' }};">
                    <td
                        style="border-left: 1px solid #cccccc; border-right: 1px solid #cccccc; border-top: none; border-bottom: none; padding: 3.5px;">
                        <strong>{{ $area }}:</strong> {{ $detalle }}
                    </td>
                </tr>
            @endforeach


            <!-- EQUIPO -->
            <tr style="background-color: #ffffff;">
                <td class="colum-s" style="font-weight: bold; text-align: center; text-decoration: underline;">
                    E Q U I P O
                </td>
            </tr>
            @php
                $equipo = [
                    'Báscula 500 kg.',
                    'Tanques de almacenamiento de plástico grado alimenticio o acero inoxidable.',
                    'Juego de Alcoholímetros graduados a 20ºC: 0-100, 20-40, 40-60, 60-80 % Alc. Vol.',
                    'Termómetro: -10-120 ºC.',
                    'Probeta de plástico: 500 ml.',
                    'Tabla de correcciones para grado alcohólico por temperatura a 20ºC.',
                    'Bitácoras de producción',
                    'Bitácoras de producto a granel',
                    'Resultados de laboratorio: Resultados de laboratorio dentro de los parámetros marcados por la NOM-070-SCFI-2016',
                    '',
                    'Resultados de Unidad de verificación: Dictamen de cumplimiento con la NOM-070-SCFI-2016.'
                ];
            @endphp

            @foreach($equipo as $index => $item)
                <tr style="background-color: {{ $index % 2 == 0 ? '#ffffff' : '#e8e8e8ff' }};">
                    <td
                        style="border-left: 1px solid #cccccc; border-right: 1px solid #cccccc; border-top: none; border-bottom: solid #cccccc; padding: 3.5px; font-weight: bold">
                        {{ $item }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <p
        style="width: 90%; margin: 10px auto; text-align: justify; font-family: 'Arial', sans-serif; font-size: 11px; line-height: 1.5;">
        INFRAESTRUCTURA MÍNIMA: El espacio de producción no tiene un mínimo de metros cuadrados, sin embargo, es
        deseable que se encuentre delimitado. Además, es necesario considerar que deben mantenerse la limpieza y las
        buenas prácticas de manufactura, mantener alejados a los animales de granja y fuentes de producción.
    </p>
    <p class="title2">
        <strong><u>III. REQUISITOS PARA ENVASADORES</u></strong>
    </p>

    <br><br><br>

    <table>
        <tbody>
            <tr>
                <td class="colum-n" style="width: 35%; background-color: #8aaef7; height: 20px;">Dirección de
                    instalación:</td>
                <td class="colum-n" style="width: 65%;"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <table>
        <thead>
            <tr style="background-color: #ffffffff;">
                <th class="colum-n" style="width: 1%;">C/NC</th>
                <th class="colum-n" style="width: 280%; font-weight: bold;">Requisito documental</th>
                <th class="colum-n" style="width: 150%;">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->where('tipo', 3) as $index => $pregunta)
                <tr style="background-color: {{ $index % 2 == 0 ? '#e8e8e8' : '#ffffff' }};">
                    <td class="colum-n"></td>
                    <td class="colum-x">{{ $pregunta->pregunta }}</td>
                    <td class="colum-n"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table
        style="width: 90%; margin: auto; border-collapse: collapse; font-size: 11px; font-family: 'Arial', sans-serif;">
        <tbody>
            <tr style="background-color: #ffffff;">
                <td colspan="3" class="colum-s" style="font-weight: bold; text-align: left;">
                    En caso de nombrar a un representante o responsable de trámites, anexar:
                </td>
            </tr>
            <tr style="background-color: #ffffff;">
                <td style="width: 1%;"></td>
                <td style="width: 280%;">Copia de identificación oficial vigente de la persona autorizada.</td>
                <td style="width: 150%;"></td>
            </tr>
            <tr style="background-color: #e8e8e8ff;">
                <td></td>
                <td>Carta de designación de persona autorizada para realizar los trámites ante el Organismo Certificador
                    CIDAM.</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y
            no puede ser distribuido
            externamente sin la autorización escrita del Director Ejecutivo
        </div>

    </div>


    <!-- ░ BLOQUE INFRAESTRUCTURA Y EQUIPO ░ -->
    <table
        style="width: 90%; margin: auto; border-collapse: collapse; font-size: 11px; font-family: 'Arial', sans-serif;">
        <tbody>
            <!-- INFRAESTRUCTURA -->
            <tr style="background-color: #ffffff;">
                <td colspan="1" class="colum-s"
                    style="font-weight: bold; text-align: center; text-decoration: underline; font-size: 11.5px;">
                    I N F R A E S T R U C T U R A
                </td>
            </tr>
            @php
                $infraestructura = [
                    'Almacén de Insumos' => 'Espacio donde se encuentran las cajas, botellas, tapones, etiquetas, sellos y todo lo necesario para el envasado del mezcal, es necesario que esté techado y con paredes de acuerdo a los materiales utilizados en la región y piso firme.',
                    'Almacén de Graneles' => 'Espacio donde se encuentran los recipientes del mezcal, es necesario que esté techado y con paredes de acuerdo a los materiales utilizados en la región, no es necesario piso firme.',
                    'Sistema de Filtrado' => 'Proceso donde el mezcal es filtrado para eliminar los sólidos suspendidos, previo al envasado, necesario al menos un filtro de retención de sólidos.',
                    'Área de Envasado' => 'Espacio donde se realiza el llenado y taponado de botellas, es necesario contar con al menos una mesa de trabajo específica para ello, es necesario que esté techado y con paredes de acuerdo a los materiales utilizados en la región, piso firme; se permite el envasado a mano debiendo implementar medidas de buenas prácticas de manufactura como son el uso de cofias, cubre bocas, guantes etc.',
                    'Área de Etiquetado' => 'Espacio donde se realizará el pegado de las etiquetas y sellos de certificación a la botella, es necesario contar con al menos una mesa de trabajo específica para ello, es necesario que esté techado y con paredes de acuerdo a los materiales utilizados en la región, piso firme; se permite el etiquetado a mano debiendo implementar medidas de buenas prácticas de manufactura como son el uso de cofias, cubre bocas, guantes etc.',
                    'Almacén de Producto Terminado' => 'Espacio donde se resguarda el producto que fue filtrado, envasado, taponado y etiquetado, listo para su comercialización, es necesario que esté techado y con paredes de acuerdo a los materiales utilizados en la región, piso firme.',
                    'Área de Aseo del Personal' => 'Baño o medio baño con los servicios básicos para mantener la higiene del personal, es necesario que esté techado y con paredes de acuerdo a los materiales utilizados en la región, piso firme y que cuenten con instalaciones hidráulicas.'
                ];

            @endphp

            @foreach($infraestructura as $area => $detalle)
                <tr style="background-color: {{ $loop->index % 2 == 0 ? '#ffffff' : '#e8e8e8ff' }};">
                    <td
                        style="border-left: 1px solid #cccccc; border-right: 1px solid #cccccc; border-top: none; border-bottom: none; padding: 3.5px;">
                        <strong>{{ $area }}:</strong> {{ $detalle }}
                    </td>
                </tr>
            @endforeach


            <!-- EQUIPO -->
            <tr style="background-color: #ffffff;">
                <td class="colum-s" style="font-weight: bold; text-align: center; text-decoration: underline;">
                    E Q U I P O
                </td>
            </tr>
            @php
                $equipo = [
                    'Tarimas',
                    'Tanques de almacenamiento de plástico grado alimenticio o acero inoxidable',
                    'Bomba de ½ pulgada para productos alimenticios',
                    'Todas las mangueras deberán ser grado alimenticio',
                    'Juego de Alcoholímetros graduados a 20ºC: 0-100, 20-40, 40-60, 60-80 % Alc. Vol.',
                    'Termómetro: -10-120 ºC',
                    'Probeta de plástico: 500 ml.',
                    'Tabla de correcciones para grado alcohólico por temperatura a 20ºC',
                    'Bitácora de producto envasado.',
                    'Bitácoras de almacén de graneles.',
                    'Bitácora de hologramas.',
                    'Resultados de laboratorio: Resultados de laboratorio dentro de los parámetros marcados por la NOM-070-SCFI-2016',
                    'Resultados de Unidad de verificación: Dictamen de cumplimiento con la NOM-070-SCFI-2016'
                ];
            @endphp

            @foreach($equipo as $index => $item)
                <tr style="background-color: {{ $index % 2 == 0 ? '#ffffff' : '#e8e8e8ff' }};">
                    <td
                        style="border-left: 1px solid #cccccc; border-right: 1px solid #cccccc; border-top: none; border-bottom: solid #cccccc; padding: 3.5px; font-weight: bold">
                        {{ $item }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <p
        style="width: 90%; margin: 10px auto; text-align: justify; font-family: 'Arial', sans-serif; font-size: 11px; line-height: 1.5;">
        INFRAESTRUCTURA MÍNIMA El espacio de envasado no tiene un mínimo de metros cuadrados, sin embargo, debe
        ubicarse en una construcción con techo y paredes de acuerdo a los materiales utilizados en la región y piso
        firme, su uso debe ser exclusivo para envasadora, no debe funcionar como casa, dormitorio, cocina o comedor,
        además es
        necesario considerar que deben mantener la limpieza y buenas prácticas de manufactura, mantener alejados a los
        animales de granja y fuentes de producción.
    </p>
     <div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y
            no puede ser distribuido
            externamente sin la autorización escrita del Director Ejecutivo
        </div>

    </div>

    <p class="title2">
        <strong><u>IV. REQUISITOS PARA COMERCIALIZADORES</u></strong>
    </p>

    <br><br><br>

    <table>
        <tbody>
            <tr>
                <td class="colum-n" style="width: 35%; background-color: #8aaef7; height: 20px;">Dirección de
                    instalación:</td>
                <td class="colum-n" style="width: 65%;"></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <table>
        <thead>
            <tr style="background-color: #ffffffff;">
                <th class="colum-n" style="width: 1%;">C/NC</th>
                <th class="colum-n" style="width: 280%; font-weight: bold;">Requisito documental</th>
                <th class="colum-n" style="width: 150%;">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->where('tipo', 4) as $index => $pregunta)
                <tr style="background-color: {{ $index % 2 == 0 ? '#e8e8e8' : '#ffffff' }};">
                    <td class="colum-n"></td>
                    <td class="colum-x">{{ $pregunta->pregunta }}</td>
                    <td class="colum-n"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table
        style="width: 90%; margin: auto; border-collapse: collapse; font-size: 11px; font-family: 'Arial', sans-serif;">
        <tbody>
            <tr style="background-color: #ffffff;">
                <td colspan="3" class="colum-s" style="font-weight: bold; text-align: left;">
                    En caso de nombrar a un representante o responsable de trámites, anexar:
                </td>
            </tr>
            <tr style="background-color: #ffffff;">
                <td style="width: 1%;"></td>
                <td style="width: 280%;">Copia de identificación oficial vigente de la persona autorizada.</td>
                <td style="width: 150%;"></td>
            </tr>
            <tr style="background-color: #e8e8e8ff;">
                <td></td>
                <td>Carta de designación de persona autorizada para realizar los trámites ante el Organismo Certificador
                    CIDAM.</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    </div>

    <div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y
            no puede ser distribuido
            externamente sin la autorización escrita del Director Ejecutivo
        </div>

    </div>

    <table
        style="width: 90%; margin: auto; border-collapse: collapse; font-size: 10px; font-family: 'Arial', sans-serif;">
        <tbody>
            <!-- INFRAESTRUCTURA -->
            <tr style="background-color: #ffffff;">
                <td colspan="1" class="colum-s"
                    style="font-weight: bold; text-align: center; text-decoration: underline; font-size: 11px;">
                    I N F R A E S T R U C T U R A
                </td>
            </tr>
            @php
                $infraestructura = [
                    'Almacén de producto terminado:' => 'Espacio donde se guarda el producto que fue entregado por el envasador y listo 
                                                                                                para su comercialización (no es obligatorio pudiendo convenir con el envasador que el producto se guarde en la 
                                                                                                envasadora).'
                ];

            @endphp

            @foreach($infraestructura as $area => $detalle)
                <tr style="background-color: {{ $loop->index % 2 == 0 ? '#ffffff' : '#e8e8e8ff' }};">
                    <td
                        style="border-left: 1px solid #cccccc; border-right: 1px solid #cccccc; border-top: none; border-bottom: none; padding: 3.5px;">
                        <strong>{{ $area }}:</strong> {{ $detalle }}
                    </td>
                </tr>
            @endforeach


            <!-- EQUIPO -->
            <tr style="background-color: #ffffff;">
                <td class="colum-s" style="font-weight: bold; text-align: center; text-decoration: underline;">
                    E Q U I P O
                </td>
            </tr>
            @php
                $equipo = [
                    'Tarimas',
                    'Bitácora de producto terminado'
                ];
            @endphp

            @foreach($equipo as $index => $item)
                <tr style="background-color: {{ $index % 2 == 0 ? '#ffffff' : '#e8e8e8ff' }};">
                    <td
                        style="border-left: 1px solid #cccccc; border-right: 1px solid #cccccc; border-top: none; border-bottom: solid #cccccc; padding: 3.5px; font-weight: bold">
                        {{ $item }}
                    </td>
                </tr>
            @endforeach

            <tr style="background-color: #ffffff;">
                <td class="colum-s"
                    style="font-weight: bold; text-align: center; text-decoration: underline; border-bottom: none;">

                    CUMPLIMIENTO DE LA NOM-070-SCFI-2016
                </td>
            </tr>
            @php
                $equipo = [
                    ' Bitácoras para el comercializador'
                ];
            @endphp

            @foreach($equipo as $index => $item)
                <tr style="background-color: {{ $index % 2 == 0 ? '#e8e8e8ff' : '#ffffff' }};">
                    <td
                        style="border-left: 1px solid #cccccc; border-right: 1px solid #cccccc; border-top: none; border-bottom: none; padding: 3.5px; font-weight: bold text-align: center;">
                        {{ $item }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>


    <div class="footer">
        <div>Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y
            no puede ser distribuido
            externamente sin la autorización escrita del Director Ejecutivo
        </div>

    </div>
</body>

</html>