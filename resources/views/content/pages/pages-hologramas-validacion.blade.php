@extends('layouts/layoutMaster')

@section('title', 'Hologramas - Validacion')


@section('page-style')
    <!-- Page -->
    @vite(['resources/css/hologramas.css'])
@endsection

<style>
        //estios para el pie
    .panel-footer {
        background: url('{{ asset('assets/img/illustrations/organismo_certificador_cidam.png') }}')no-repeat 50%;
    
    }

    .panel-footer {
        background: url('{{ asset('assets/img/illustrations/organismo_certificador_cidam.png') }}')no-repeat 50%;
       
    }

    @media only screen and (max-width: 900px) {
        .panel-footer {
            background: url('{{ asset('assets/img/illustrations/organismo_certificador_cidam.png') }}')no-repeat 50%;
           
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
                        <div class="centrado"> 040CA000199 </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-footer"></div>
        <div id="footer">
            <div>2024 © Todos los derechos reservados a <a style="color:#2adc9f;" href="https://cidam.org/sitio/">CIDAM</a>
            </div>

        </div>
    </div>

@endsection
