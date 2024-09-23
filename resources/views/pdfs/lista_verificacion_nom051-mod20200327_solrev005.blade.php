<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>R-UNIIC-004 Orden de trabajo de inspección de etiquetas, tq CAFE</title>
    <style>
        body {
            font-family: 'Calibri', 'Arial', sans-serif;
            font-size: 14px;
        }

        .header {
            position: fixed;
            top: 0px;
            left: 40px;
            width: 84%;
            padding: 10px;
            text-align: right;
            z-index: 1;
            margin-bottom: 30px;

        }


        .header img {
            width: 150px;
            height: 80px;
            margin-right: 450px;
        }

        .line {
            position: absolute;
            top: 90px;
            right: 10px;
            width: 68%;
            border-bottom: 1.5px solid black;
        }

        .header-text {
            font-size: 13px;
            margin-top: -45;
        }

        .img img {
            width: 100px;
            height: auto;
            display: block;
            margin-left: 20px;
            /* Centra la imagen horizontalmente */
        }

        p {
            margin: 0;
        }

        p+p {
            margin-top: 3px;
            /* Ajusta este valor según sea necesario */
        }

        .container {
            padding-left: 45px;
            padding-right: 45px;
            padding-top: 100px;
            margin-left: 35px;
            margin-right: 35px;
            border: 3px solid black;
        }

        /* tabla1 */
        .mi-tabla {
            border-collapse: collapse;
            width: 100%;
        }

        /* .mi-tabla, */
        .mi-tabla td {
            border: 1px solid black;
        }

        .mi-tabla td {
            padding: 1px;
            text-align: center;
            /*             font-weight: bold;
            font-size: 13px; */
        }
        .green{
           background-color: #A8D08D;
        }
        .yellow{
            background-color: #F6FB63;
        }
        .N{
            font-weight: bold;
            font-size: 13px;
        }

        .table-largue{
            border-collapse: collapse;
            width: 100%;
        }

        /* .mi-tabla, */
        .table-largue td {
            border: 1px solid black;
        }

        .table-largue td {
            padding: 1px;
            text-align: center;
            /*             font-weight: bold;
            font-size: 13px; */
        }
        .gray{
            background-color: #E7E6E6;
        }
        .fondo{
            background-color: #a7a7a7;
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- cabecera --}}
        <div class="header">
            <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo CIDAM">
            <div class="header-text">
                <p style=" margin: 0;">Lista de Verificación NOM-051-SCFI/SSA1-2010 y MOD 27.03.2020 R-UNIIC005</p>
                <p style=" margin: 0;">Edición 0, 28/05/2024</p>
            </div>
            <div class="line"></div>
        </div>

        <p>Lista de verificación de la NOM-051-
            SCFI/SSA1-2010 y MOD 27.03.2020</p>
        <br>
        <table class="mi-tabla">
            <tr>
                <td class="yellow">Inspector asignado:</td>
                <td colspan="3">Andres Alejandro Vidales Aroche</td>
                <td class="green">Fecha de revisión</td>
                <td>12/09/2024</td>d>
            </tr>
            <tr>
                <td class="yellow">Producto:</td>
                <td colspan="3">Mix de Semillas con Miel</td>
                <td class="green">OSC</td>
                <td>no aplica</td>
            </tr>
            <tr>
                <td class="yellow">Marca:</td>
                <td colspan="3">Sarayu Productos nutritivos(marca en tramite)</td>
                <td class="green">No. de servicio</td>
                <td>SOL-REV-005</td>
            </tr>
            <tr>
                <td>No. Revisión</td>
                <td colspan="3"></td>
                <td rowspan="2" class="green">Sólido / líquido</td>
                <td rowspan="2">Sólido</td>
            </tr>
            <tr style="border: none;">
                <td colspan="4" style="border: none;"></td>
            </tr>
            <tr style="border: none;">
                <td class="N">C = CUMPLE</td>
                <td class="N">NC = NO CUMPLE</td>
                <td class="N">NA = NO APLICA</td>
                <td style="border: none;"></td>
                <td class="green">Bebida sin calorías</td>
                <td class="green">No</td>
            </tr>

        </table>
        <br>
        <table class="table-largue">
            <tr class="green">
                <td>No.</td>
                <td>Especificaciones</td>
                <td>C/NC/ NA</td>
                <td>Observaciones</td>
            </tr>
            <tr>
                <td class="green">1</td>
                <td colspan="3" class="yellow">Generalidades</td>
            </tr>
            <tr>
                <td class="green">1 (4.2.10.1.4)</td>
                <td class="gray">En caso de que el envase esté cubierto por una envoltura,
                    debe figurar en ésta toda la información aplicable, a menos
                    de que la etiqueta pueda leerse fácilmente a través de la
                    envoltura exterior.</td>
                <td>C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green">1.2 (4.2.10.1.1)</td>
                <td class="gray">La etiqueta debe fijarse de manera tal que permanezcan
                    disponibles hasta el momento del consumo en condiciones
                    normales.</td>
                <td>C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green">1.3 (4.1.11.1)</td>
                <td class="gray">Los alimentos y bebidas no alcohólicas deben ostentar la
                    informacion obligatoria que se refiere a la NOM-051-
                    SCFI/SSA1-2010 en idioma español, sin prejuicio de que se
                    exprese en otros idiomas.</td>
                <td>C</td>
                <td class="fondo"></td>
            </tr>
            <tr>
                <td class="green">.4 (4.2.11.2)</td>
                <td class="gray">La información o representación gráfica adicional en la
                    etiqueta que puede estar presente en otro idioma, no debe
                    sustituir, sino añadirse a los requisitos de etiquetado,
                    siempre y cuando dicha información resulte necesaria para
                    evitar que se induzca a error o engaño al consumidor</td>
                <td>C</td>
                <td class="fondo"></td>
            </tr>
        </table>



    </div>{{-- fin del container --}}



</body>

</html>
