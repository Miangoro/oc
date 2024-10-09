@extends('layouts/layoutMaster')

@section('title', 'Hologramas - Validacion')

<style>
    body {
        font-family: "Roboto", Arial, sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #3b4350;
        background-color: #ffffff;
        height: 100%;
    }

    #texto1 {
        color: #062e61;
        font-family: 'Anton', sans-serif;
        letter-spacing: 2px;
        text-shadow: 1px 1px 2px #10ab84;
        font-size: 45px;
    }

    #texto2 {
        color: #003366;
        font-size: 1.5em;
        margin-top: 0;
        text-shadow: 2px 2px 4px #003366;
        margin-bottom: 20px
    }

    .nav_bar {
        text-align: center;
        padding: 0px;
        background-color: #e9e9e9;
    }

    .panel-body {
        padding: 0px;
    }

    .panel-body {
        padding: 15px;
    }

    .placa {
        width: 100%;
        border: 1px solid #ccc;
        padding: 20px;
        margin: 20px auto;
        background-color: #fff;
        box-shadow: 2px 2px 4px #888888;
    }

    .placa h1 {
        text-align: center;
        color: #003366;
        font-size: 2.5em;
        margin-bottom: 0.5em;
        text-shadow: 2px 2px 4px #888888;
    }

    .placa h2 {
        text-align: center;
        color: #006699;
        font-size: 1.5em;
        margin-top: 0.5em;
    }

    .placa .dato {
        margin-bottom: 10px;
    }

    .placa .dato span {
        font-weight: bold;
        color: #003366;
    }

    .panel-heading {
        font-size: 18px;
        padding: 7px 15px;
        border-top-right-radius: 0 !important;
        border-top-left-radius: 0 !important;
        border-color: #e5e5e5 !important;
    }

    #trazabilidad {
        font-size: 23px;
        font-weight: bold;
        color: #FFF;
        text-align: center;
        border-top-left-radius: 50px !important;
        border-top-right-radius: 50px !important;
        background-color: #062e61 !important;
    }


    .col-lg-8 {
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }

    @media (min-width: 1200px) {
        .col-lg-8 {
            float: left;
        }
    }

    @media (min-width: 1200px) {
        .col-lg-8 {
            width: 66.66666667%;
        }
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
        line-height: 1.42857143;

        /* Aplica el color blanco a toda la tabla */
    }

    .table tbody tr td {
        border-top: 1px solid #efefef;
    }


    table {
        border-spacing: 0;
        border-collapse: collapse
    }

    .td {
        color: #FFF !important;
        border-color: inherit;
        border-style: none;
        border-width: 0;
        /* Asegura que las celdas y encabezados también sean blancos */
    }


    .tdd {
        border-color: inherit;
        border-style: none;
        border-width: 0;
        /* Asegura que las celdas y encabezados también sean blancos */
    }


    td {
        padding: 3px 10px 3px !important;

    }

    @media (min-width: 992px) {
        .container {
            width: 970px;
        }
    }

    @media (min-width: 768px) {
        .container {
            width: 750px;
        }

        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        //clases panel

        .panel-default {
            background-color: #e9e9e9;
            text-align: center;
        }

        .panel {
            -webkit-box-shadow: none;
            box-shadow: none;
            -webkit-border-radius: 0 !important;
            -moz-border-radius: 0 !important;
            border-radius: 0 !important;
        }

        .panel {
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            -webkit-border-radius: 0 !important;
            -moz-border-radius: 0 !important;
            border-radius: 0 !important;
        }

        .panel-default {
            border-color: #ddd;
        }

        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

        //imagen
        @media (min-width: 768px) {
            .col-sm-12 {
                width: 100%;
            }
        }


        @media (min-width: 768px) {
            .col-sm-12 {
                float: left;
            }
        }



        .col-sm-12 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        @media (min-width: 576px) {
            .col-sm-12 {
                flex: 0 0 auto;
                width: 100%;
            }
        }


        @media only screen and (max-width: 900px) {
            .contenedor-imagenes {
                display: flex;
                margin-bottom: 200px;
                position: relative;
            }
        }

        .contenedor-imagenes {
            display: flex;
            margin-bottom: 300px;
            position: relative;
            justify-content: center;
        }

        @media only screen and (max-width: 900px) {
            .contenedor-imagenes #holograma {
                width: 100%;
                height: 100%;
            }
        }

        .contenedor-imagenes #holograma {
            width: 100%;
            height: 100%;
        }

        @media only screen and (max-width: 900px) {
            .contenedor-imagenes {
                display: flex;
                margin-bottom: 200px;
                position: relative;
            }
        }

        img {
    vertical-align: middle;
    border: 0;
}


.imagen-holograma {
    width: 50%; /* ajusta el ancho de la imagen */
    height: auto; /* ajusta el alto de la imagen automáticamente */
    margin: 20px auto; /* agrega un margen para centrar la imagen */
}


    }

    .imagen-holograma {
    max-width: 100%; /* ajusta el ancho máximo de la imagen al ancho de la tabla */
    height: auto; /* ajusta el alto de la imagen automáticamente */
    margin: 20px auto; /* agrega un margen para centrar la imagen */
}

@media (max-width: 768px) {
    .imagen-holograma {
        width: 100%; /* ajusta el ancho de la imagen al ancho de la pantalla */
        height: auto; /* ajusta el alto de la imagen automáticamente */
    }
}
</style>

@section('content')

    <div class="nav_bar">
        <div id="texto1">VALIDACIÓN DE HOLOGRAMAS</div>
        <div id="texto2">ORGANISMO CERTIFICADOR CIDAM</div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-8" style="float:none;margin:auto;">
                <div style=" border-radius: 40px !important; background-color: #062e6163  !important;"
                    class="panel panel-default">
                    <div id="trazabilidad" class="panel-heading">Trazabilidad</div>
                    <div style=" border: 1px solid #fff;text-align: center; background-color: #062e61; color: white;">
                        <strong>CERTIFICADO
                            VENTA
                            NACIONAL Y/O EXPORTACIÓN: <br>
                            CIDAM C-EXP-497/2024</strong>
                    </div>

                    <div style=" border: 1px solid #fff;text-align: center; background-color: #062e61; color: white;">
                        <strong>FOLIO
                            DE
                            HOLOGRAMA:
                            NOM-070-040CA000199</strong>
                    </div>

                    <div
                        style=" border: 1px solid #fff;text-align: center; background-color: #062e61; color: white; font-size: 30px">
                        <strong>PRODUCTO
                            CERTIFICADO</strong>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="td"><b>CERTIFICADO DE LOTE A GRANEL</b></td>
                                <td class="td">CIDAM C-GRA-057/2024
                                </td>
                            </tr>
                            <tr>
                                <td class="td">CATEGORÍA</td>
                                <td class="td">Mezcal Ancestral</td>
                            </tr>
                            <tr>
                                <td class="td">CLASE</td>
                                <td class="td">Blanco O Joven</td>
                            </tr>
                            <tr>
                                <td class="td">MARCA</td>
                                <td class="td">Envido 29
                                </td>
                            </tr>
                            <tr>
                                <td class="td">LOTE A GRANEL </td>
                                <td class="td">ES-0224
                                </td>
                            </tr>
                            <tr>
                                <td class="td">LOTE ENVASADO </td>
                                <td class="td">ES-0224
                                </td>
                            </tr>
                            <tr>
                                <td class="td">TIPO DE AGAVE </td>
                                <td class="td">Maguey Espadín (a. Angustifolia)
                                </td>
                            </tr>
                            <tr>
                                <td class="td">PRODUCIDO EN </td>
                                <td class="td">Oaxaca</td>
                            </tr>
                            <tr>
                                <td class="td">ENVASADO EN </td>
                                <td class="td">Oaxaca</td>
                            </tr>
                            <tr>
                                <td class="td">CONTENIDO ALCOHÓLICO </td>
                                <td class="td">50 % Alc. Vol</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="font-size: 23px;font-weight: bold;color: #FFF;text-align: center;background-color: #243868 !important; padding: 8px; border-color: #ebccd1; border-top: 0; text-transform: none;"
                                    colspan="2">Comercializador o Licenciatario de Marca
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="tdd"><b>NOMBRE / EMPRESA </b></td>
                                <td class="tdd">PEDRO RODRÍGUEZ DÍAZ
                                </td>
                            </tr>
                            <tr>
                                <td class="tdd"><b>RFC</b></td>
                                <td class="tdd">RODP830905D51
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>




                <div class="row">
                    <div class="col-sm-12" style="text-align: center"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12 contenedor-imagenes">
                        <img src="{{ asset('assets/img/illustrations/holograma_cidam.png') }}"
                        alt="Holograma de organismo certificador de cidam" id="holograma" class="imagen-holograma" />

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
