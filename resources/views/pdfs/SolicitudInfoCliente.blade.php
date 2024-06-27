<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de Información del Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 2px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4f81bd;
            color: white;
            text-align: center;
            font-size: 11px;
            font-family: Arial, sans-serif;

        }

        .no-border {
            border: none;
        }

        .header {
            padding: 10px;
            text-align: right;
        }

        .header img {
            width: 240px;
            float: left;

        }

        .td_text {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .spaced-text span {
            margin-right: 10px;
            /* Márgen derecho entre los spans */
        }

        .cenetered-text {
            text-align: center;
        }

        .no-bottom-border td {
            border-bottom: none;
        }

        .no-top-border td {
            border-top: none;

        }

        .checkbox-cell {
            width: 50px;
        }
    </style>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM">
        <h3>Solicitud de Información del Cliente NOM-070-SCFI-2016 y NMX-V- <br> 052-NORMEX-2016 F7.1-01-02 <br> Edición
            12 Entrada en Vigor: 01-02-2024 <br>__________________________________________________________</h3>
    </div>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <table class="no-bottom-border">
                        <tr>
                            <th colspan="3">INFORMACIÓN DEL CLIENTE</th>
                        </tr>
                    </table>
                </div>
                <table class="table, no-top-border">
                    <tr>
                        <td colspan="2" style="font-weight: bold;">Nombre del cliente:</td>
                        <td style="font-weight: bold">Fecha de solicitud:</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-weight: bold">Correo Electrónico:</td>
                        <td style="font-weight: bold">Teléfono:</td>
                    </tr>

                    <tr>
                        <td rowspan="2" class="custom-table-cell"
                            style="vertical-align: top; border-right: 1px solid black;">
                            <!-- Contenido del lado izquierdo -->
                            <br>
                            <p style="text-align: center; font-weight: bold; ">Domicilio Fiscal:</p>
                        </td>
                        <td class="custom-table-cell spaced-text" colspan="2">
                            <!-- Contenido del lado derecho, primer elemento -->
                            <span style="margin-right: 200px;">Calle:</span>
                            <span style="margin-right: 30px;">Número:</span>
                            <span style="margin-right: 20px;">Colonia:</span>

                        </td>
                    </tr>
                    <tr>
                        <td class="custom-table-cell spaced-text" colspan="2">
                            <!-- Contenido del lado derecho, segundo elemento -->
                            <span style="margin-right: 200px">Localidad/Municipio/Ciudad/Estado:</span>
                            <span>C.P.:</span>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2" class="custom-table-cell"
                            style="vertical-align: top; border-right: 1px solid black;">
                            <!-- Contenido del lado izquierdo -->
                            <p style="text-align: center; font-weight: bold">Domicilio de: <br><br><br>
                                __________________ </p>
                        </td>
                        <td class="custom-table-cell spaced-text" colspan="2">
                            <!-- Contenido del lado derecho, primer elemento -->
                            <span style="margin-right: 200px;">Calle:</span>
                            <span style="margin-right: 30px;">Número:</span>
                            <span style="margin-right: 20px;">Colonia:</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-table-cell spaced-text" colspan="2">
                            <!-- Contenido del lado derecho, segundo elemento -->
                            <span style="margin-right: 200px">Localidad/Municipio/Ciudad/Estado:</span>
                            <span>C.P.:</span>
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2" class="custom-table-cell"
                            style="vertical-align: top; border-right: 1px solid black;">
                            <!-- Contenido del lado izquierdo -->
                            <p style="text-align: center; font-weight: bold">Domicilio de: <br><br><br>
                                __________________ </p>
                        </td>
                        <td class="custom-table-cell spaced-text" colspan="2">
                            <!-- Contenido del lado derecho, primer elemento -->
                            <span style="margin-right: 200px;">Calle:</span>
                            <span style="margin-right: 30px;">Número:</span>
                            <span style="margin-right: 20px;">Colonia:</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-table-cell spaced-text" colspan="2">
                            <!-- Contenido del lado derecho, segundo elemento -->
                            <span style="margin-right: 200px;">Localidad/Municipio/Ciudad/Estado:</span>
                            <span>C.P.:</span>
                        </td>
                    </tr>
                </table>
            </div>

            <table class="no-top-border">
                <tr>
                    <td>En caso de contar con más instalaciones en domicilios diferentes donde lleve a cabo su
                        actividad (planta de producción, envasado, bodega de maduración u otro) agregar las
                        tablas necesarias y especificar domicilios*</td>
                </tr>
            </table>

            <table class="no-top-border">
                <tr>
                    <td colspan="3" class="cenetered-text" style="font-weight: bold">Producto (s) que se va a
                        certificar <br> Alcance del Organismo Certificador
                    </td>
                </tr>

            </table>
            <table class="no-top-border">
                <tr>
                    <td>Mezcal</td>
                    <td style="width: 20px;">&nbsp;</td>
                    <td>Bebida alcohólica <br> preparada que contiene <br> Mezcal</td>
                    <td style="width: 20px;">&nbsp;</td>
                    <td>Cóctel que <br> contiene Mezcal</td>
                    <td style="width: 20px;">&nbsp;</td>
                    <td style="width: 50px;">&nbsp;</td>

                </tr>
                <tr>
                    <td>Licor y/o crema que <br>contiene Mezcal </td>
                    <td>&nbsp;</td>
                    <td colspan="5">&nbsp;</td>
                </tr>
            </table>

            <table class="no-top-border">
                <tr>
                    <td colspan="3" class="cenetered-text" style="font-weight: bold">Documentos normativos para los
                        cuales busca la
                        certificación:
                    </td>
                </tr>

            </table>
            <table class="no-top-border">
                <tr>
                    <td>NOM-070-SCFI-2016</td>
                    <td>&nbsp;</td>
                    <td>NOM-251-SSA1-2009</td>
                    <td>&nbsp;</td>
                    <td style="width: 50px;">&nbsp;</td>

                </tr>
                <tr>
                    <td>NMX-V-052-NORMEX-2016</td>
                    <td>&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>

            <table class="no-top-border">
                <tr>
                    <td colspan="3" class="cenetered-text" style="font-weight: bold">Actividad del cliente
                        NOM-070-SCFI-2016 :
                    </td>
                </tr>

            </table>
            <table class="no-top-border">
                <tr>
                    <td>Productor de Agave</td>
                    <td>&nbsp;</td>
                    <td>Envasador de Mezcal</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>


                </tr>
                <tr>
                    <td>Productor de Mezcal</td>
                    <td>&nbsp;</td>
                    <td>Comercializador de Mezcal</td>
                    <td>&nbsp;</td>
                    <td style="width: 50px;">&nbsp;</td>

                </tr>
            </table>
            <br>
            <p style="text-align: center; margin-top: 70px;">
                Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no
                puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo
            </p>
            <br>
            <div class="header">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM">
                <h3>Solicitud de Información del Cliente NOM-070-SCFI-2016 y NMX-V- <br> 052-NORMEX-2016 F7.1-01-02 <br>
                    Edición
                    12 Entrada en Vigor: 01-02-2024 <br>__________________________________________________________</h3>
            </div>
            <table>
                <tr>
                    <td colspan="3" class="cenetered-text" style="font-weight: bold">Actividad del cliente
                        NMX-V-052-NORMEX-2016: :
                    </td>
                </tr>

            </table>
            <table class="no-top-border">
                <tr>
                    <td style="font-weight: bold">Productor de bebidas <br> alcohólicas que contienen <br> Mezcal</td>
                    <td>&nbsp;</td>
                    <td style="font-weight: bold">Envasador de bebidas <br> alcohólicas que contienen <br> Mezcal</td>
                    <td style="width: 20px;">&nbsp;</td>
                    <td style="width: 50px;" colspan="2">&nbsp;</td>


                </tr>
                <tr>
                    <td style="font-weight: bold">Comercializador de bebidas <br> alcohólicas que contienen <br> Mezcal
                    </td>
                    <td style="width: 20px;">&nbsp;</td>
                    <td></td>
                    <td colspan="3">&nbsp;</td>

                </tr>
            </table>

            <table class="no-bottom-border, no no-top-border">
                <td rowspan="4" class="custom-table-cell" style="vertical-align: top; ">
                    <!-- Contenido del lado izquierdo -->
                    <br>
                    <p style="text-align: center; font-weight: bold; margin-top: 0px">Información sobre los Procesos y productos a certificar por el cliente:</p>
                </td>
            </table>

            <table class="no-bottom-border">
                <tr>
                    <td style="text-align: center; font-weight: bold;">NOMBRE DEL CLIENTE SOLICITANTE:</td>
                </tr>
            </table>
            <table class="no-top-border">
                <td style="height: 40px; text-align: center; vertical-align: middle; font-weight: bold">
                    Quien queda enterado de todos los requisitos que debe cumplir para proseguir su proceso de
                    certificación.
                </td>
            </table>
            <br>
            <br>

            <table>
                <tr>
                    <th colspan="3">INFORMACIÓN DEL ORGANISMO CERTIFICADOR (Exclusivo CIDAM) <br>Viabilidad del
                        servicio
                    </th>
                </tr>
                <td style="width: 500px; text-align: center; font-weight: bold">DESCRIPCIÓN:</td>
                <td style="text-align: center; font-weight: bold">SI</td>
                <td style="text-align: center; font-weight: bold">NO</td>
                <tr>
                    <td style="width: 500px;">Se cuenta con todos los medios para realizar todas las actividades de
                        evaluación para la <br> Certificación </td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td style="width: 500px;">El organismo de Certificación tiene la competencia para realizar la
                        Certificación :</td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td style="width: 500px;">El organismo de Certificación tiene la capacidad para llevar a cabo las
                        actividades de <br> certificación.</td>
                    <td></td>
                    <td></td>

                </tr>
                <tr>
                    <td colspan="3">No. De cliente CIDAM: </td>

                </tr>
                <tr>
                    <td colspan="3">Comentarios: </td>

                </tr>

            </table>
            <br>
            <br>
            <table>
                <tr>
                    <th style="height: 50px;">Nombre y Puesto de quien <br> realiza la revisión</th>
                    <td style="width: 140px;"></td>
                    <th style="height: 50px;">Firma de quien <br> realiza la revisión</td>
                    <td style="width: 140px;"></td>
                </tr>
            </table>


            <p style="text-align: center; margin-top: 120px;">
                Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no
                puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo
            </p>
            <br>
        </div>
    </div>
</body>

</html>
