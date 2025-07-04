<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticidad de Certificados</title>


    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Barra de navegación */
        .nav_bar {
            background-color: #062e61;
            color: white;
            padding: 15px;
            text-align: center;
        }

        #texto1 {
            font-size: 20px;
            font-weight: bold;
        }

        #texto2 {
            font-size: 16px;
        }

        /* Estilos para el panel */
        .panel {
            border-radius: 15px;
            background-color: #fff;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        
            padding: 20px;
        }

        .panel-heading {
            background-color: #062e61;
            color: white;
            font-size: 22px;
            text-align: center;
            padding: 10px 0;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .alert {
            background-color: #062e61;
            color: white;
            font-size: 18px;
            margin: 10px 0;
            padding: 15px;
        }

        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #243868;
            color: white;
        }

        .table td {
            background-color: #f9f9f9;
        }



        #footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            background-color: #062e61;
            color: white;
            padding: 15px;
            font-size: 14px;
        }

        #footer a {
            color: #2adc9f;
            text-decoration: none;
        }


        @media only screen and (max-width: 600px) {
            .panel {
                padding: 15px;
            }

            .panel-heading {
                font-size: 20px;
            }

            .table th,
            .table td {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <!--LOGO DE LA UNIDAD-->
    <div class="header-banner" style="text-align: center; padding: 15px 0; background-color: white;">
        <img src="{{ asset('assets/img/illustrations/banner_oc_cidam.png') }}" style="max-width: 100%; height: auto;">
    </div>
    
    <div class="nav_bar">
        <div id="texto1">Autenticidad de guía de traslado de agave</div>
        <div id="texto2">UNIDAD DE INSPECCIÓN CIDAM</div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-lg-8" style="float:none;margin:auto; margin-bottom:80px">
                <div class="panel panel-default">

                    <div class="alert" style="text-align: center">
                        <strong>GUÍA DE TRASLADO ORIGINAL</strong>
                    </div>

                    <div class="alert">
                        <strong>FOLIO DE GUÍA: {{$datos->folio ?? ''}}</strong>
                    </div>

                    <table class="table">
                        <tbody>
                            <tr>
                                <td><b>Nombre del predio</b></td>
                                <td>{{$guia->predios->nombre_predio ?? ''}}</td>
                            </tr>
                            <tr>
                                <td><b>Nombre de la empresa/productor:</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Fecha de corte</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Tipo de maguey (Tipo de agave)</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Edad</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>No. de lote o No. de tapada</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>No. de piñas comercializadas</b></td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td><b>No. de piñas anterior</b></td>
                                <td> </td>
                            </tr>
                            <tr>
                                <td><b>No. de piñas actual</b></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" style="font-size: 23px; text-align: center;">Comercializador o
                                    Licenciatario de Marca</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>NOMBRE / EMPRESA</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>RFC</b></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div id="footer">
            <div>2025 © Todos los derechos reservados a <a href="https://cidam.org/sitio/">
            Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C.
            </a></div>
        </div>

    </div>


</body>
</html>
