<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>F-UV-21-02 Inspección para la geo-referenciación de los predios de maguey o agave Ed. 6 Vigente</title>

    <style>
        body {
            font-family: Verdana, 'Geneva', Tahoma, sans-serif;
            margin: 35px;
            padding: 10px;
            margin-top: 60px;
            margin-bottom: 55px;
            font-size: 15px;
        }

        .header {
            position: fixed;
            top: -35px;
            right: 30px;
            width: 100%;
            padding: 0px;
            text-align: right;
            z-index: 1;
            margin-bottom: 30px;
        }

        .header img {
            width: 203px;
            height: 83px;
            margin-right: 500px;
        }

        .line {
            position: absolute;
            top: 85px;
            right: 10px;
            width: 68%;
            border-bottom: 1.5px solid black;
        }

        .header-text {
            line-height: 1.5;
            font-size: 13px;
            margin-top: -45;
            padding: 0;
        }

        .footer {
            position: fixed;
            bottom: -45px;
            left: 75px;
            width: 82%;
            font-size: 10.5px;
        }

        .footer-page {
            font-family: 'Times New Roman', Times, serif;
            position: absolute;
            left: 530px;
            width: 75px;
            margin-top: 5px;
            font-size: 10.5px;
        }

        .footer-text {
            text-align: center;
            width: 95%;
            position: relative;
        }

        .footer-text2 {
            width: 100%;
            text-align: right;
            margin-top: 25px;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            color: #151442;
        }

        .footer .page:after {
            content: counter(page);
        }

        .generales td {
            border: solid 2px #006666;
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            font-weight: bold;
        }

        .generales {
            border-collapse: collapse;
            width: 50%;
            margin-left: auto;
            /* Alinea la tabla a la derecha */
            margin-right: 0;
            /* Opcional: asegura que la tabla esté pegada al borde derecho */
        }

        .datos {
            border-collapse: collapse;
            width: 100%;
        }

        .datos td {
            border: solid 2px #006666;
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            font-weight: bold;
        }

        .datosprediotabla {
            border-collapse: collapse;
            width: 100%;
        }

        .datosprediotabla td {
            border: solid 2px #006666;
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            font-weight: bold;
        }

        .datosprediotabla tr td:first-child {
            background-color: #DDFFFF;
        }

        .datos tr td:first-child {
            background-color: #DDFFFF;
        }

        .indice {
            color: #006666;
            font-size: 16px;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
        }

        .tabla-maguey {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* Fijar el ancho de las celdas */
            text-align: center;
        }

        /* Aplicar color de fondo al primer tr */
        .tabla-maguey tr:first-child td {
            background-color: #DDFFFF;
            /* Color de fondo de las celdas del primer tr */
        }

        .tabla-maguey td {
            border: solid 2px #006666;
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            font-weight: bold;
        }

        .caracteristicas {
            width: 80%;
            text-align: center;
            border-collapse: collapse;
        }

        .caracteristicas td {
            border: solid 2px #006666;
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            font-weight: bold;
        }

        .plantacion {
            width: 100%;
            border-collapse: collapse;
        }

        .plantacion td {
            border: solid 2px #006666;
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            font-weight: bold;
        }

        .tabletipo {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .tabletipo td {
            border: solid 2px #006666;
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            font-weight: bold;
        }

        .tabla-coordenadas {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-coordenadas td {
            border: solid 2px #006666;
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            font-weight: bold;
        }

        /* Estilos generales para la tabla de firmas */
        .firma-section {
            width: 100%;
            margin-top: 50px;
            text-align: center;
        }

        .firma-section td {
            width: 50%;
            /* Cada celda ocupa la mitad de la tabla */
            padding: 20px;
        }

        .firma-linea {
            border-top: 1px solid black;
            margin-bottom: 10px;
            width: 80%;
        }

        .firma-texto {
            font-family: 'Times New Roman', Times, serif;
            font-weight: bold;

        }
    </style>
</head>

<body>
    {{-- cabecera --}}
    <div class="header">
        <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo CIDAM">
        <div class="header-text">
            Inspección para la geo-referenciación de los predios de maguey o agave F-UV-21-02 <br> Edición 6,
            15/07/2024<br></div>
        <div class="line"></div>
    </div>
    {{-- footer --}}
    <div class="footer">
        <p class="footer-text">
            Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no
            puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo.
        </p>
        <p class="footer-page">
            Página <span class="page"></span> de 3
        </p>
        <p class="footer-text2">No. de acreditación UVNOM129 Aprobación por DGN 312.01.2017.1017</p>
    </div>
    {{-- contenido --}}
    <div class="container">
        <p style="font-size: 17px; font-weight: bold; text-align: center;">Inspección para la geo-referenciación de los
            predios de maguey o agave</p>

        <p class="indice">I.&nbsp;&nbsp;&nbsp;&nbsp; Datos Generales</p>

        <table class="generales">
            <tr>
                <td style="width: 60%;"> No. orden de servicio
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td style="height: 18px;"></td>
                <td></td>
            </tr>
            <tr>
                <td>No. de Cliente</td>
                <td></td>
            </tr>
        </table>
        <br>
        <table class="datos">
            <tr>
                <td style="width: 40%">Nombre del cliente</td>
                <td style="background-color: #D9D9D9;"></td>
            </tr>
            <tr>
                <td>Tipo de agave</td>
                <td></td>
            </tr>
            <tr>
                <td>Domicilio fiscal</td>
                <td style="background-color: #D9D9D9;"></td>
            </tr>
            <tr>
                <td>Teléfono</td>
                <td></td>
            </tr>
            <tr>
                <td>Ubicacion del predio</td>
                <td style="background-color: #D9D9D9;"></td>
            </tr>
        </table> <br>
        <p class="indice">II. &nbsp;&nbsp;&nbsp;&nbsp; Datos del predio</p>
        <br>
        <table class="datosprediotabla">
            <tr>
                <td style="width: 29%">Localidad</td>
                <td></td>
            </tr>
            <tr>
                <td>Municipio</td>
                <td></td>
            </tr>
            <tr>
                <td>Distrito</td>
                <td></td>
            </tr>
            <tr>
                <td>Estado</td>
                <td></td>
            </tr>
            <tr>
                <td>Nombre del paraje</td>
                <td></td>
            </tr>
            <tr>
                <td>Predio en zona DOM (Si/No)</td>
                <td></td>
            </tr>
        </table>
        <br>
        <p class="indice">III. &nbsp;&nbsp;&nbsp;&nbsp; Datos de geo-referenciación del predio</p>
        <br>
        <table class="tabla-coordenadas">
            <tr>
                <td rowspan="10" style="width: 25%;">Grados decimales</td>
                <td>Latitud</td>
                <td></td>
            </tr>
            <tr>
                <td>Longitud</td>
                <td></td>
            </tr>
            <tr>
                <td>Latitud</td>
                <td></td>
            </tr>
            <tr>
                <td>Longitud</td>
                <td></td>
            </tr>
            <tr>
                <td>Latitud</td>
                <td></td>
            </tr>
            <tr>
                <td>Longitud</td>
                <td></td>
            </tr>
            <tr>
                <td>Latitud</td>
                <td></td>
            </tr>
            <tr>
                <td>Longitud</td>
                <td></td>
            </tr>
            <tr>
                <td>Latitud</td>
                <td></td>
            </tr>
            <tr>
                <td>Longitud</td>
                <td></td>
            </tr>
            <tr>
                <td>Superficie</td>
                <td colspan="2"></td>
            </tr>
        </table>
    </div>

    <div class="container">
        <p class="indice">IV. &nbsp;&nbsp;&nbsp;&nbsp; Características del maguey</p>
        <p class="indice">a) &nbsp;&nbsp;&nbsp;&nbsp; Cultivado</p>

        <table class="tabla-maguey">
            <tr>
                <td style="height: 40px;">Tipo de maguey</td>
                <td>Distancia entre surcos (m)</td>
                <td>Distancia entre plantas (m)</td>
                <td>Marco de plantación (m2)</td>
            </tr>
            <tr>
                <td style="height: 50px;">Maguey cultivado</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <br>
        <p class="indice" style="margin: 0;">b) &nbsp;&nbsp;&nbsp;&nbsp; Plantación silvestre</p>
        <table class="plantacion">
            <tbody>
                <tr>
                    <td rowspan="2" style="background-color: #DDFFFF;"></td>
                    <td colspan="3" style="background-color: #DDFFFF;">Método utilizado</td>
                </tr>
                <tr>
                    <td style="height: 40px;">Transecto</td>
                    <td>Cuadrante</td>
                    <td>Punto centro cuadrado</td>
                </tr>
                <tr>
                    <td style="height: 40px;">Tamaño</td>
                    <td></td>
                    <td></td>
                    <td rowspan="2" style=" font-weight: normal;">
                        <p style="margin: 0;">d1=</p>
                        <p style="margin: 0;">d2=</p>
                        <p style="margin: 0;">d3=</p>
                        <p style="margin: 0;">d4=</p>
                        <p></p>
                        <p style="margin: 0;">D=</p>
                    </td>


                </tr>
                <tr>
                    <td style="height: 40px;">Número de plantas</td>
                    <td></td>
                    <td></td>

                </tr>
            </tbody>
        </table>
        <br>
        <p style="margin: 0;" class="indice">V. &nbsp;&nbsp;&nbsp;&nbsp; Características del maguey</p>
        <p style="margin: 0;" class="indice">&nbsp;&nbsp; Edad</p>
        <br>
        <table class="caracteristicas">
            <tr>
                <td style="background-color: #DDFFFF;">No. planta</td>
                <td style="background-color: #DDFFFF;">Altura (m)</td>
                <td style="background-color: #DDFFFF;">Diámetro (cm)</td>
                <td style="background-color: #DDFFFF;">Número de hojas</td>
            </tr>
            <tr>
                <td>1</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>5</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>6</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>7</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>8</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>9</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>10</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Promedio</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <br> <br>
        <table class="tabletipo">
            <tr>
                <td style="height: 40px; background-color: #DDFFFF;">Tipo de maguey</td>
                <td style="background-color: #DDFFFF;">Especie de agave</td>
                <td style="background-color: #DDFFFF;">No. De plantas</td>
                <td style="background-color: #DDFFFF;">Edad (años)</td>
                <td style="background-color: #DDFFFF;">Tipo de plantación</td>
            </tr>
            <tr>
                <td style="height: 50px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <br>
        <table class="firma-section">
            <tr>
                <td>
                    <div class="firma-linea"></div>
                    <div class="firma-texto">Nombre y firma del Inspector</div>
                </td>
                <td>
                    <div class="firma-linea"></div>
                    <div class="firma-texto">Fecha</div>
                </td>
            </tr>
        </table>
    </div>


</body>

</html>