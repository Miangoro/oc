@extends('layouts/layoutMaster')

@section('title', 'Hologramas - Validacion')

<style>
    body {
        font-family: "Roboto", Arial, sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #3b4350;
        background-color: #f0f2f5;
        height: 100%;
    }

    .nav_bar h1 {
        text-align: center;
        color: #003366;
        font-size: 2.5em;
        margin-bottom: 0;
        text-shadow: 2px 2px 4px #003366;
    }

    .nav_bar h2 {
        text-align: center;
        color: #003366;
        font-size: 1.5em;
        margin-top: 0;
        text-shadow: 2px 2px 4px #003366;

    }

    .nav_bar {

        padding: 10px;
        background-color: #e9e9e9;
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

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;



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
}
</style>

@section('content')

    <div class="nav_bar">
        <h1>VALIDACIÓN DE HOLOGRAMAS</h1>
        <h2>ORGANISMO CERTIFICADOR CIDAN</h2>
    </div>

    <div class="container">

    <div class="col-lg-8" style="float:none;margin:auto;">

        <div id="trazabilidad" class="panel-heading">Trazabilidad
        </div>

        <div style=" border: 1px solid #fff;text-align: center; background-color: #062e61; color: white;"><strong>CERTIFICADO
                VENTA
                NACIONAL Y/O EXPORTACIÓN:
                CIDAM C-EXP-497/2024</strong>
        </div>

        <div style=" border: 1px solid #fff;text-align: center; background-color: #062e61; color: white;"><strong>FOLIO DE
                HOLOGRAMA:
                NOM-070-040CA000199</strong>
        </div>

        <div style=" border: 1px solid #fff;text-align: center; background-color: #062e61; color: white; font-size: 30px">
            <strong>PRODUCTO
                CERTIFICADO</strong>
        </div>
            <table style="color: #FFF !important" class="table">
                <tbody>
                    <tr>
                        <td><b>CERTIFICADO DE LOTE A GRANEL</b></td>
                        <td>CIDAM C-GRA-057/2024
                        </td>
                    </tr>
                    <tr>
                        <td>CATEGORÍA</td>
                        <td>Mezcal Ancestral</td>
                    </tr>
                    <tr>
                        <td>CLASE</td>
                        <td>Blanco O Joven</td>
                    </tr>
                    <tr>
                        <td>MARCA</td>
                        <td>Envido 29
                        </td>
                    </tr>
                    <tr>
                        <td>LOTE A GRANEL </td>
                        <td>ES-0224
                        </td>
                    </tr>
                    <tr>
                        <td>LOTE ENVASADO </td>
                        <td>ES-0224
                        </td>
                    </tr>
                    <tr>
                        <td>TIPO DE AGAVE </td>
                        <td>Maguey Espadín (a. Angustifolia)
                        </td>
                    </tr>
                    <tr>
                        <td>PRODUCIDO EN </td>
                        <td>Oaxaca</td>
                    </tr>
                    <tr>
                        <td>ENVASADO EN </td>
                        <td>Oaxaca</td>
                    </tr>
                    <tr>
                        <td>CONTENIDO ALCOHÓLICO </td>
                        <td>50 % Alc. Vol</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
