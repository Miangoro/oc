<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar Autenticidad de CERTIFICADO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:wght@500&family=Roboto:wght@400&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f2f2f2;
        }

        .header-banner img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .panel {
            border-radius: 40px;
            background-color: #062e6163;
            padding: 0 0 20px 0;
            overflow: hidden;
            margin-bottom: 30px; /* Espacio entre panel y footer */
        }

        .alert {
            background-color: #062e61;
            color: white;
            font-size: 18px;
            margin: 0;
            padding: 15px;
            text-align: center;
            border-top-left-radius: 40px;
            border-top-right-radius: 40px;
        }

        .table {
            color: #FFF;
            width: 100%;
            margin-top: 0;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #fff;
        }

        .table th {
            font-size: 18px;
            font-weight: bold;
            background-color: #062e61;
            text-align: center;
        }

        .table td {
            background-color: transparent;
        }

        #footer {
            font-size: 15px;
            text-align: center;
            background-color: #2E2E2E;
            color: white;
            padding: 15px 10px;
        }

        #footer a {
            color: #2adc9f;
            text-decoration: none;
        }

        @media only screen and (max-width: 768px) {
            .panel {
                border-radius: 20px;
            }

            .alert {
                border-radius: 20px 20px 0 0;
            }
        }
    </style>
</head>
<body>

    <!-- Banner -->
    <div class="header-banner">
        <img src="{{ asset('assets/img/illustrations/banner_oc_cidam.png') }}" alt="Banner OC CIDAM">
    </div>


<!--INICIO DE LOTES-->
@foreach ($lotes as $lote)
    <!-- Panel principal -->
    <div class="container">
        <div class="panel">
            {{-- <div class="alert">
                <h4><strong>CERTIFICADO DE EXPORTACIÓN</strong></h4>
            </div> --}}
            <!-- Tabla producto -->
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="2">Verificar autenticidad de certificado expedido por el Organismo Certificador de CIDAM</th>
                    </tr>
                    <tr>
                        <th colspan="2">CERTIFICADO DE EXPORTACIÓN</th>
                    </tr>
                    <tr>
                        <th colspan="2">Producto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><b>CATEGORÍA</b></td><td>{{ mb_strtoupper($lote->lotesGranel->first()->categoria->categoria) ?? 'No encontrado' }},</td></tr>
                    <tr><td><b>CLASE</b></td><td>{{ mb_strtoupper($lote->lotesGranel->first()->clase->clase) ?? 'No encontrado' }}</td></tr>
                    <tr><td><b>MARCA</b></td><td>{{ mb_strtoupper($lote->marca->marca) ?? 'N' }}</td></tr>
                    <tr><td><b>LOTE A GRANEL</b></td><td>{{ $lote->lotesGranel->first()->nombre_lote ?? 'No encontrado' }}</td></tr>
                    <tr><td><b>LOTE ENVASADO</b></td><td> {{ $lote->nombre ?? 'No encontrado' }}</td></tr>
                    <tr><td><b>TIPO DE AGAVE</b></td><td>{!! $lote->lotesGranel->first()->tiposRelacionados->map(function ($tipo) {
                    return $tipo->nombre . ' (' . $tipo->cientifico . ')';
                })->implode('<br>') !!}</td></tr>
                    <tr><td><b>CONTENIDO ALCOHÓLICO</b></td><td>{{ $lote->cont_alc_envasado ?? 'No encontrado' }}%</td></tr>
                @php
                    $folios = explode(',', $lote->lotesGranel->first()->folio_fq ?? 'No encontrado');
                    $folio1 = trim($folios[0] ?? '');
                    $folio2 = isset($folios[1]) && trim($folios[1]) !== '' ? trim($folios[1]) : ' ';
                @endphp
                    <tr><td><b>FISICOQUÍMICOS</b></td><td>{{ $folio1 }}&nbsp; {{ $folio2 }} </td></tr>
                    <tr><td><b>ENVASADO EN</b></td><td>{{ mb_strtoupper($envasadoEN) }}&nbsp;</td></tr>
                    <tr><td><b>PAÍS DE DESTINO</b></td><td>{{ $pais }}</td></tr>
                    <tr>
                        <td><b>ESTADO DEL CERTIFICADO</b></td>
                        <td style="color: green"><b>Activo</b></td>
                    </tr>
                </tbody>
            </table>


            <!-- Tabla empresa -->
            <table class="table">
                
                    <tr>
                        <th colspan="2">Comercializador o Licenciatario de Marca</th>
                    </tr>
                
                    <tr><td><b>Nombre / Empresa</b></td><td>{{ $empresa }}</td></tr>
                    <tr><td><b>RFC</b></td><td>{{ $rfc}}</td></tr>
                
            </table>

    </div> <!-- Fin del panel -->
@endforeach<!-- FIN DE LOTES -->



        <!-- Footer separado -->
        <div id="footer">
            {{ date('Y') }} © Todos los derechos reservados a 
            <a href="https://cidam.org">Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C.</a>
        </div>

    </div>
</body>
</html>
