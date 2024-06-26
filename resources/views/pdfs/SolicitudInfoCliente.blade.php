<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de Información del Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #5B9BD5;
            color: white;
            text-align: center;
        }

        .no-border {
            border: none;
        }

        .header {
            padding: 10px;
            text-align: center;
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
    </style>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM">
        <h5>Solicitud de Información del Cliente NOM-070-SCFI-2016 y NMX-V-052-NORMEX-2016</h5>
        <h6>F7.1-01-02 Edición 12 Entrada en Vigor: 01-02-2024</h6>
    </div>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <table>


                        <tr>
                            <th>INFORMACIÓN DEL CLIENTE</th>
                        </tr>
                    </table>
                </div>
                <table class="table">
                    <tr>
                        <td>Nombre del Cliente:</td>
                        <td>Fecha de solicitud:</td>
                    </tr>
                    <tr>
                        <td>Correo Electrónico:</td>
                        <td>Teléfono:</td>
                    </tr>
                    <tr>
                        <td>Domicilio Fiscal:</td>
                        <td class="spaced-text">
                            <span>Calle:</span>
                            <span>Numero:</span>
                            <span>Colonia:</span>
                            <br>
                            <span>Localidad/Municipio/Ciudad/Estado:</span>
                            <span>C.P.:</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Domicilio de: <br> __________________ </td>
                        <td class="spaced-text">
                            <span>Calle:</span>
                            <span>Numero:</span>
                            <span>Colonia:</span>
                            <br>
                            <span>Localidad/Municipio/Ciudad/Estado:</span>
                            <span>C.P.:</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Domicilio de: <br> __________________ </td>
                        <td class="spaced-text">
                            <span>Calle:</span>
                            <span>Numero:</span>
                            <span>Colonia:</span>
                            <br>
                            <span>Localidad/Municipio/Ciudad/Estado:</span>
                            <span>C.P.:</span>
                        </td>
                    </tr>

                </table>
                <div>
                    <table>
                        <tr>
                            <td>En caso de contar con más instalaciones en domicilios diferentes donde lleve a cabo su
                                actividad (planta de producción, envasado, bodega de maduración u otro) agregar las
                                tablas necesarias y especificar domicilios* </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6">

                <table class="table">



                </table>

            </div>
            <div class="col-md-6">
                <table class="table">

                </table>
            </div>
        </div>
    </div>
</body>

</html>
