<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>F7.1-03-02 Solicitud de Información al Cliente NOM-199-SCFI-2017 Ed. 4 VIGENTE</title>
    <style>
        @page {
            size: 216mm 279mm; /* Establece el tamaño de página a 216mm de ancho por 279mm de alto */
            margin: 0; /* Elimina todos los márgenes */
            margin-top: 80px;
        }
        body {
            font-size: 13px;
            font-family: Arial, sans-serif;
        }
        .img img {
            width: 140px;
            height: auto;
            display: block;
            margin-left: 5px;
        }

        .header-table {
            width: 72%;
            border: solid #bab9b9 2px;
            margin: 0 auto; /* Centra la tabla horizontalmente */
            table-layout: fixed; /* Asegura que las celdas tengan un ancho fijo */
        }

        .img {
            width: 30%; /* Ajusta el ancho de la celda de la imagen */
        }

        .text-titulo {
            width: 70%; /* Ajusta el ancho de la celda del texto */
        }

        .centro {
            text-align: right; /* Alínea el texto a la derecha */
        }

        p {
            margin: 0;
            padding: 0;
        }

        p + p {
            margin-top: 0; /* Ajusta este valor según sea necesario */
        }

        .line {
            position: relative;
            margin-top: 2px; /* Reduce el margen superior */
            width: 98%; /* Largo */
            border-bottom: 1px solid black; /* Estilo de la línea */
        }

        .container {
            width: 75%;
            border: 1px solid black; /* Estilo de la línea */
            border-bottom: none;
            margin: 0 auto; /* Centra la tabla horizontalmente */
 /*  */
        }
        
        .header {
            background-color: #4081b2;
            color: white;
            text-align: center;
            padding: 10px;
            font-weight: bold;
            border: solid black 1px;
        }
        .section-title {
            font-weight: bold;
        }

        .table-title {
            text-align: center;
            font-weight: bold;
            padding: 15px;
            margin-left: 170px;
            margin-right: 170px ;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
        .nested-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .info {
            text-align: right;
            font-size: 12px;
        }

        .table-cell {
            border: 1px solid black;
            margin-left: 50px;
            margin-right: 50px;
            padding: 10px; /* Reducir el padding */
            vertical-align: top;
            font-size: 12px; /* Reducir el tamaño de la fuente */
            text-align: center; /* Centrar el texto horizontalmente */
            vertical-align: middle; /* Centrar el texto verticalmente */
        }
        .tablas{
            margin-left: 30px;
            margin-right: 30px;
        }
        .footer{
            margin-left: 70px;
            margin-right: 70px;
        }
    </style>
</head>
<body>
    {{-- encabezado --}}
    <table class="header-table">
        <tr>
            <td class="img" style="border: none;">
                <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM">
            </td>
            <td class="text-titulo"  style="border: none;">
                <div class="centro">
                    <p>Solicitud de Información al Cliente NOM-199-SCFI-2017 F7.1-03-02</p>
                    <p>Edición 4 Entrada en vigor. 20/06/2024</p>  
                    <div class="line"></div>      
                </div>
            </td>
        </tr>
    </table> <br>
    {{--  --}}
    <div class="container">
        <div class="header">
            INFORMACIÓN DEL CLIENTE (Exclusivo cliente)
        </div>
        <table class="section-content" style="border: solid black 1px;">
            <tr style="border: solid black 1px;">
                <td class="section-title">Fecha de solicitud:</td>
            </tr>
            <tr style="border: solid black 1px;">
                <td class="section-title">Nombre / Razón Social del cliente:</td>
            </tr>
            <tr style="border: solid black 1px;">
                <td class="section-title">Teléfono y Correo electrónico:</td>
            </tr>
        </table>
{{-- tabla fisica --}}
    <div class="section-content" style="border: solid black 1px;">
        <div class="section-title" style="text-align: center; font-size: 13px;">Dirección de las ubicaciones físicas:</div>
        
        <table class="nested-table">
            <tr>
                <th rowspan="3" class="rowspan-title" style="position: relative; width: 124px; text-align: center; ">
                    <div style="border: solid #000000 2px; width: 35px; height: 85px; position: absolute; left: 102px; top: 6.6%; transform: translateY(-50%);"></div>
                    Fiscal:
                </th>
                <td >Calle:</td>
                <td >Número:</td>
            </tr>
            <tr>
                <td style="border-top: solid black 1px;">Colonia:</td>
                <td style="border-top: solid black 1px;">C.P.:</td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: solid black 1px;">Localidad/Municipio/Ciudad/Estado:</td>
            </tr>
        </table>
        

        <table class="nested-table" style="border-top: solid black 1px;">
            <tr>
                <th rowspan="3" class="rowspan-title" style="position: relative; width: 124px;">
                    <div style="border: solid #000000 2px; width: 35px; height: 85px; position: absolute; left: 102px; top: 6.6%; transform: translateY(-50%);"></div>
                    Producción, Envasador y
                    Comercializador:
                </th>
                <td>Calle:</td>
                <td>Número:</td>
            </tr>
            <tr>
                <td style="border-top: solid black 1px;">Colonia:</td>
                <td style="border-top: solid black 1px;">C.P.:</td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: solid black 1px;">Localidad/Municipio/Ciudad/Estado:</td>
            </tr>
        </table>

    </div>
    <p style="border: solid black 1px; font-size: 11px;"><b>En caso de contar con más instalaciones en domicilios diferentes donde lleve a cabo su actividad (planta de producción, envasado, bodega de maduración u otro) agregar las tablas necesarias y especificar domicilios*</b></p>
    
        <div class="table-title">
            Clasificación de Bebida(s) Alcohólica(s) por su proceso de elaboración.
        </div>
    <div class="tablas">
  <table>
            <tr>
                <td class="table-cell" style="border-bottom: none; "></td>
                <td class="table-cell" style="width: 120px;">Cerveza</td>
                <td class="table-cell" style="width: 30px;"></td>
                <td style="border: solid black 1px; border-bottom: none;"></td>
                <td class="table-cell">Aguardiente</td>
                <td style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell" rowspan="6" style="border-top: none; width: 100px;"><strong>Bebidas Alcohólicas Fermentadas (2% a 20% Alc. Vol.)</strong></td>
                <td class="table-cell">“_____Ale”</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell" rowspan="6" style="border-top: none; width: 100px;"><strong>Bebidas Alcohólicas Destiladas (32% a 55% Alc. Vol.)</strong></td>
                <td class="table-cell">Armagnac</td>
                <td style="border: solid black 1px; width: 30px"></td>
            </tr>
            <tr>
                <td class="table-cell">Pulque</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell">Bacanora</td>
                <td style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell">Sake</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell">Brandy</td>
                <td style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell">Sidra</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell">Cachaca</td>
                <td style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell">Vino</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell">Comiteco</td>
                <td style="border: solid black 1px;"></td>
            </tr>
            <tr>
                <td class="table-cell">Otro (Especifique):</td>
                <td style="border: solid black 1px;"></td>
                <td class="table-cell">Ginebra</td>
                <td style="border: solid black 1px;"></td>
            </tr>

               
        </table>
    </div>

    </div>
    <br>
<div class="footer">
        <p style="text-align: center; margin-top: 15px; font-size: 10.5px;">
        Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser distribuido externamente sin la autorización escrita del Director Ejecutivo
        </p>
        <p style="text-align: right; margin-top: 20px; font-size: 12px;">
        1/3
        </p>
</div>

{{-- seccion 2 --}}
 {{-- encabezado --}}
 <table class="header-table">
    <tr>
        <td class="img" style="border: none;">
            <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" alt="Logo UVEM">
        </td>
        <td class="text-titulo"  style="border: none;">
            <div class="centro">
                <p>Solicitud de Información al Cliente NOM-199-SCFI-2017 F7.1-03-02</p>
                <p>Edición 4 Entrada en vigor. 20/06/2024</p>  
                <div class="line"></div>      
            </div>
        </td>
    </tr>
</table> <br>
{{--  --}}
    <div class="container">


        <div class="tablas">
            <table>
                      <tr>
                          <td class="table-cell" style="border-bottom: none; "></td>
                          <td class="table-cell" style="width: 120px;">Anís</td>
                          <td class="table-cell" style="width: 30px;"></td>
                          <td style="border: solid black 1px; border-bottom: none;"></td>
                          <td class="table-cell">habanero</td>
                          <td style="border: solid black 1px;"></td>
                      </tr>
                      <tr>
                          <td class="table-cell" rowspan="6" style="border-top: none; width: 100px;"><strong>Licores o cremas (13.5% a 55% Alc. Vol.)</strong></td>
                          <td class="table-cell">“_____Ale”</td>
                          <td style="border: solid black 1px;"></td>
                          <td class="table-cell" rowspan="6" style="border-top: none; width: 100px;"><strong>Bebidas Alcohólicas Destiladas (32% a 55% Alc. Vol.)</strong></td>
                          <td class="table-cell">Armagnac</td>
                          <td style="border: solid black 1px; width: 30px"></td>
                      </tr>
                      <tr>
                          <td class="table-cell">Pulque</td>
                          <td style="border: solid black 1px;"></td>
                          <td class="table-cell">Bacanora</td>
                          <td style="border: solid black 1px;"></td>
                      </tr>
                      <tr>
                          <td class="table-cell">Sake</td>
                          <td style="border: solid black 1px;"></td>
                          <td class="table-cell">Brandy</td>
                          <td style="border: solid black 1px;"></td>
                      </tr>
                      <tr>
                          <td class="table-cell">Sidra</td>
                          <td style="border: solid black 1px;"></td>
                          <td class="table-cell">Cachaca</td>
                          <td style="border: solid black 1px;"></td>
                      </tr>
                      <tr>
                          <td class="table-cell">Vino</td>
                          <td style="border: solid black 1px;"></td>
                          <td class="table-cell">Comiteco</td>
                          <td style="border: solid black 1px;"></td>
                      </tr>
                      <tr>
                          <td class="table-cell">Otro (Especifique):</td>
                          <td style="border: solid black 1px;"></td>
                          <td class="table-cell">Ginebra</td>
                          <td style="border: solid black 1px;"></td>
                      </tr>
          
                         
                  </table>
              </div>
        
    </div>


</body>
</html>