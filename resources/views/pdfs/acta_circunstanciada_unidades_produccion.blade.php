<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>F-UV-02-02 ACTA CIRCUNSTANCIADA V6</title>
    <style>
        @page {
            size: 216mm 279mm; /* Establece el tamaño de página a 216mm de ancho por 279mm de alto */
            margin: 0; /* Elimina todos los márgenes */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 35px;
            border: 2px dotted #14aa80;
            padding: 10px;
        }
        header{
            margin-top: 0px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif; /* Fuente similar */
        }
        td {
            border: 2px solid #383838; /* Borde sólido con color #383838 y grosor 2px */
            padding: 10px; /* Relleno interno para el td */
            text-align: center; /* Centra el texto del td */
            font-weight: bold; /* Aplica negrita al texto */
            vertical-align: middle; /* Centra verticalmente el contenido */
        }
        .img {
            width: 20%;
        }
        .img img {
            width: 70%;
            height: auto;
            display: block;
            margin: 0 auto; /* Centra la imagen horizontalmente */
        }
        .tex {
            width: 30%;
            text-align: center; /* Centra el texto */
        }
        .etiqueta {
            width: 20%;
            white-space: nowrap; /* Evita que el texto se divida en varias líneas */
        }
        .etiqueta div {
            align-content: right;
            background-color: #06E88D; /* Color de fondo para el div */
            display: inline-block;
            padding: 2px;
            width: 100%;
            height: 30px;
            margin: 0 auto;
        }
        .etiqueta p {
            text-align: center;
            font-family: Arial, sans-serif;
            color: #ffffff;
            font-weight: bold; /* Aplica negrita al texto */
            font-size: 12px;
            margin: 0; /* Elimina el margen del párrafo */
        }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td class="img">
                    <img src="{{ public_path('img_pdf/logo_uvem.png') }}" alt="Logo CIDAM" width="120px">
                </td>
                <td class="tex">
                    <p style="font-size: 22px">Acta Circunstanciada</p> 
                        Para unidades de producción
                </td>
                <td class="etiqueta">
                    <div>
                        <p>F-UV-02-02 VERSIÓN 6</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>