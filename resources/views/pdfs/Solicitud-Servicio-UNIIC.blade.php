<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R-UNIIC-001 Solicitud y especificaciones del Servicio para emisión de Constancias de Conformidad JUAN RAMÓN</title>

    <style>
        body {
            font-family: 'century gothic', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
        }

        @page {
            margin: 30px 10px 0px 10px; 
        }


        table {
            width: 90%;
            border: 2px solid #1E4678;
            border-collapse: collapse;
            margin: auto;
            margin-top: -50px;
            font-size: 13.5px;
            line-height: 1;
            vertical-align: top;
            font-family: Arial, Helvetica, Verdana;
        }

        td, th {
            border: 2px solid #1E4678;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        td {
            width: 50%;
        }

        .header {
            position: fixed;
            top: 20px; 
            left: 30px;
            width: calc(100% - 60px);
            height: 100px; 
            overflow: hidden; 
        }

        .logo {
            margin-left: 30px;
            width: 150px;
            display: block;
        }

        .description1,
        .description2,
        .description3 {
            position: fixed;
            right: 30px;
            text-align: right;
        }

        .description1 {
            font-family: 'Arial', sans-serif;
            margin-right: 30px;
            top: 40px;
            font-size: 14px;
        }

        .description2 {
            font-family: 'Arial', sans-serif;
            margin-right: 30px;
            top: 60px;
            font-size: 14px;
        }

        .description3 {
            margin-right: 30px;
            top: 80px;
            font-size: 14px;
            padding-bottom: 5px;
            width: 63%;
        }

        .tema {
            text-align: center;
            margin-top: 80px; 
            font-size: 16px;
            font-family: 'century gothic negrita';
            margin-left: -120px;
        }

        .subtema {
            text-align: center;
            margin-top: 10px; 
            font-size: 15px;
            color: #ED7D31;
            font-family: 'century gothic negrita';
        }

        .subtema1 {
            margin-left: 60px;
            margin-top: 10px; 
            font-size: 13.5px;
            font-family: 'century gothic negrita';
            margin-bottom: 30px;
        }

        .subtema2 {
            margin-left: 60px;
            margin-top: 30px; 
            font-size: 13.5px;
            font-family: 'century gothic negrita';
            margin-bottom: 30px;
            color: #305496;
        }

        .subtema3 {
            text-align: center;
            margin-top: 10px; 
            font-size: 15px;
            color: #305496;
            margin-bottom: 30px;
            font-family: 'century gothic negrita';
        }

        .subtema-r {
            margin-right: 60px;
            text-align: right;
            margin-top: -250px; 
            font-size: 13.5px;
            font-family: 'century gothic negrita';
        }

        .text {
            font-size: 13.5px;
            margin-left: 60px;
        }

        .text1 {
            margin-top: -17px;
            font-size: 13.5px;
            margin-left: 60px;
        }

        .my-table-0 {
            border-collapse: collapse;
            width: 85%; 
            margin-left: 60px;
            margin-right: 60px;
            margin-top: 120px;
            font-family: 'century gothic';
        }

        .my-table-0 td {
            font-size: 13.5px;
            vertical-align: middle;
            text-align: center;
            border: 3px solid #E36C09;
            padding: 5px; 
            text-align: center;
        }

        .my-table {
            border-collapse: collapse;
            width: 40%; 
            margin-left: 60px;
            margin-top: 10px;
            font-family: 'century gothic';
        }

        .my-table td {
            font-size: 13.5px;
            vertical-align: middle;
            text-align: center;
            border: 3px solid #E36C09;
            padding: 5px; 
            text-align: center;
        }

        .my-table1 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 40%; 
            margin-left: 420px;
            margin-top: -150px;
            font-family: 'century gothic';
        }

        .my-table1 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #E36C09;
            padding: 5px; 
            text-align: center;
        }

        .my-table2 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 40%; 
            margin-left: 60px;
            margin-top: -10px;
            font-family: 'century gothic';
        }

        .my-table2 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #E36C09;
            padding: 5px; 
            text-align: center;
        }

        .my-table3 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 10%; 
            margin-left: 500px;
            margin-top: -100px;
            font-family: 'century gothic';
        }

        .my-table3 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #E36C09;
            padding: 5px; 
            text-align: center;
        }

        .my-table4 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 40%; 
            margin-left: 60px;
            margin-top: 30px;
            font-family: 'century gothic';
        }

        .my-table4 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #2F5292;
            padding: 5px; 
            text-align: center;
        }

        .my-table5 {
            font-size: 13.5px;
            border-collapse: collapse;
            width: 40%; 
            margin-right: 60px;
            margin-top: -195px;
            font-family: 'century gothic';
        }

        .my-table5 td {
            vertical-align: middle;
            text-align: center;
            border: 3px solid #2F5292;
            padding: 5px; 
            text-align: center;
        }

        .null {
            border-top: 3px solid rgb(255, 254, 254) !important;  
            border-right: 3px solid rgb(255, 254, 254) !important;  
        }

        .text-n{
            font-family: 'century gothic negrita';
        }

        .page-break {
            page-break-before: always;
        }
    </style>

</head>
<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM" class="logo">
    </div>

    <div class="description1">R-UNIIC-001 Solicitud y especificaciones del Servicio para </div>
    <div class="description2">emisión de Constancias de Conformidad</div>
    <div class="description3">Edición 1 Entrada en Vigor: 19-08-2024</div>

    <p class="tema">Solicitud de servicio</p>
    <p class="subtema">Datos generales del cliente</p>

    <p class="text">Fecha de solicitud del servicio:</p>
    <p class="text">Nombre del cliente</p>
    <P class="text1">Numero telefonico</P>
    <p class="text1">Correo electronico</p>

    <p class="subtema1">Marca con una X la casilla que corresponda</p>

    <p class="text1">¿Cuenta con una empresa Legal constituida?</p>

    <div class="table1">
        <table class="my-table">
            <tbody>
                <tr>
                    <td class="text-n">SI</td>
                    <td></td>
                    <td class="null"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: justify;">Nombre del representante Legal de la Marco o empresa</td>
                    <td rowspan="3"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left;">Domicilio fiscal</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left;">RFC</td>
                </tr>
            </tbody>
        </table>

        <table  class="my-table1">
            <tbody>
                <tr>
                    <td class="text-n">No</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: justify;">Domicilio del cliente (Indicando nombre, calle, número, código postal y entidad)</td>
                    <td></td>
                </tr>
                <tr>
                    <td  style="text-align: left;">RFC</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <p class="subtema2">Tu producto es:</p>

        <table class="my-table2">
            <tbody>
                <tr>
                    <td style="text-align: left;">Bebida alcohólica</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Alimento</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Bebida no alcohólica</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="page-break"></div>

    <p class="tema">Solicitud de servicio</p>
    <p class="subtema3">Datos para etiquetas de alimentos y bebidas no alcohólicas <br> NOM-051-SCFI/SSA1-2010 Mod 27.03.2020 </p>

    <p class="subtema1">Marca con una X la casilla que corresponda a tu producto</p>
    <p class="text1">NOM-051-SCFI/SSA1-2010 Mod 27.03.2020</p>
    <p class="text">NOM-051-SCFI/SSA1-2010 Mod 27.03.2020 Producto importado</p>
    <p class="text">Etiquetado FDA</p>

    <div class="table1">
    <table class="my-table3">
        <tbody>
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            <tr>
                <td style="height: 15px;"></td>
            </tr>
            <tr>
                <td style="height: 15px;"></td>
            </tr>
        </tbody>
    </table>
    <br>

    <p class="subtema1">I. Infomación del producto</p>

    <table class="my-table4">
        <tbody>
            <tr>
                <td style="width: 200px; text-align: left;">Nombre de la marca comercial del producto</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td style="text-align: left;">Denominación del producto</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td style="text-align: left;">Presentación o contenido neto</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align: left;">La caducidad de tu producto es mayor a tres meses</td>
                <td class="text-n" style="width: 50px;">SI </td>
                <td style="width: 50px;"></td>
            </tr>
            <tr>
                <td class="text-n">NO</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div>   
        <p class="subtema-r">II. De acuerdo al registro de tu marca <br> responde lo siguiente:</p>
    </div>
    
    <div>    <table class="my-table5">
        <tbody>
            <tr>
                <td>Tipo de marca y
    clase de registro
    </td>
                <td></td>
            </tr>
            <tr>
                <td>No. de Registro y No.
    Expediente de la
    marca
    </td>
                <td></td>
            </tr>
            <tr>
                <td>País de Origen
    (Bebidas importadas)</td>
                <td></td>
            </tr>
        </tbody>
    </table></div>
</div>

<div class="page-break"></div>
<div>
    <table class="my-table-0">
            <tbody>
                <tr>
                    <td colspan="3" rowspan="5">INGREDIENTES DEL PRODUCTO: Enlistar todos los ingredientes sin excepción en orden decreciente (de mayor a menor) según la formulación del
                    producto, no es necesario mencionar las cantidades.
                    </td>
                    <td colspan="3">1</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">2</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">3</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">4</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">¿Agrega agua a su producto? NOTA : Se debe indicar el agua añadida por orden de predominio, excepto cuando ésta forme parte de un
                    ingrediente compuesto y la que se utilice en los procesos de cocción y reconstitución. No es necesario declarar el agua u otros ingredientes volátiles que se evaporan durante la
                    fabricación.
                </td>
                    <td>Si </td>
                    <td></td>
                    <td>No 
                </td>
                    <td></td>
                </tr>
                <tr>
                    <td>¿Se adicionan azúcares?</td>
                    <td>Si</td>
                    <td></td>
                    <td>No</td>
                    <td></td>
                    <td>En caso afirmativo, indique la cantidad que se añade en 100 gó mL:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>¿Se adicionan aditivos?</td>
                    <td>Si</td>
                    <td></td>
                    <td>No</td>
                    <td></td>
                    <td>En caso afirmativo, indique la cantidad y tipo/s de aditivo que se añade en 100 g ó mL:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>¿Se adiciona cafeína? </td>
                    <td>Si</td>
                    <td></td>
                    <td>No</td>
                    <td></td>
                    <td>En caso afirmativo, indique la cantidad que se añade en 100 gó mL: 
                </td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="7">Observaciones
                </td>
                </tr>
            </tbody>
        </table>
</div>

</body>
</html>