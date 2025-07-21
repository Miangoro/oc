<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dictamen de Cumplimiento para Producto de Exportación</title>
    <style>
        @page {
            size: 227mm 292mm;
            /*Tamaño carta*/
            margin: 30px 60px 30px 60px;
            /*márgenes (arriba, derecha, abajo, izquierda) */
        }


        body {
            /*ajustes generales*/
            font-family: 'calibri';
            font-size: 15px;
            line-height: 0.9;
            /*interlineado*/
            text-align: justify
        }

        */ .encabezado {
            /* border: 2px solid blue; */
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
        }

        .header-text {
            display: inline-block;
            /*coloca elementos en línea horizontalmente*/
            color: #151442;
            padding-left: 150px;
            line-height: 0.7;
        }

        .header-text p {
            margin: 2px;
            text-align: center;
        }


        /*pie de pagina*/
        .footer {
            /*border: 2px solid blue;*/
            position: fixed;
            /*lo fija en pantalla*/
            left: -60px;
            right: -60px;
            bottom: -30px;
        }

        .footer p {
            margin: 0px 60px 4px 0px;
            /*arriba, derecha, abajo, izquierda*/
            font-size: 10px;
            line-height: 0.8;
        }

        .leyenda {
            text-align: right;
            font-family: 'Lucida Sans Unicode';
        }

        .footer-text {
            text-align: center;
            background-color: #158F60;
            padding: 6px;
            color: rgb(248, 248, 248);
        }



        .contenido {
            margin-top: 13%;
        }

        .titulos {
            font-size: 18px;
            line-height: 0.9;
            padding: 10px;
            text-align: center;
            font-family: 'Arial';
        }

        .leftLetter {
            text-align: left;
        }

        .rightLetter {
            text-align: right;
        }

        .letter-color {
            color: black;
            text-align: center;
            margin-left: 0;
            margin-bottom: 20px;
        }

        .bloque-contenedor {
            border: 1px solid black;
            padding: 1px;
            margin-top: 10px;
            background-color: #f9f9f9ff;
        }

        .tabla-casillas {
            width: 100%;
            border-spacing: 3px;
            /* espacio entre celdas */
            border-collapse: separate;
            /* evitar colapsado de bordes */
            font-family: 'calibri';
            font-size: 25px;
        }

        .tabla-casillas td {
            border: 1px solid black;
            padding: 8px;
            font-size: 11px;
            text-align: center;
            background-color: #ffffff;
            vertical-align: middle;
        }
    </style>
</head>

<body>

    {{-- <img class="fondo" src="{{ public_path('img_pdf/fondo_dictamen.png') }}" alt="Fondo agave"> --}}

    <div class="encabezado">
        <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="width: 250px; height: 98px;" alt="Logo UI">
        <div class="header-text">
            <p style="font-size: 16px; font-family: 'Arial Negrita', Gadget, sans-serif;">Unidad de Inspección
                No.<br>UVNOM-129</p>
            <p style="font-size: 11px; font-family: 'Arial Negrita', Gadget, sans-serif;">Centro de Innovación y
                Desarrollo Agroalimentario de<br>Michoacán, A.C.</p>
            <p style="font-size: 11px; font-family: sans-serif;">Acreditados ante la Entidad Mexicana de Acreditación,
                A.C.</p>
        </div>
    </div>


    <div class="footer">
        <p class="leyenda">
            @if ($id_sustituye)
                Este dictamen sustituye al: {{ $id_sustituye }}
            @endif
            <br>Entrada en vigor: 10-12-2019
            <br>F-UV-04-18 Ver 1.
        </p>
        <div class="footer-text">
            <p style="font-family: Lucida Sans Seminegrita;">www.cidam.org . unidadverificacion@cidam.org</p>
            <p style="font-family: Lucida Sans Unicode;">Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no
                especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
        </div>
    </div>






    <div class="contenido">

        <div class="titulos">
            UNIDAD VERIFICADORA DE MICHOACÁN
        </div>
        <div class="titulos">DICTAMEN DE CUMPLIMIENTO PARA<br>
            PRODUCTO DE EXPORTACION</div>
        <table style="width: 100%; font-size: 14px; margin-bottom: 5px;">
            <tr>
                <td class="negrita" style="text-align: left;">
                    PRODUCTO: <strong>{{ $producto }}</strong>
                </td>
                <td class="negrita" style="text-align: right;">
                    Número de dictamen: <strong>{{ $no_dictamen }}</strong>
                </td>
            </tr>
        </table>




        <div class="bloque-contenedor">
            <table class="tabla-casillas">
                <tr>
                    <td style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 110px">Fecha de emisión
                    </td>
                    <td style="width: 90px">{{ mb_strtoupper($fecha_emision) }}</td>
                    <td style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 110px">Número de
                        informe:</td>
                    <td style="width: 90px"></td>
                </tr>
                <tr>
                    <td style="font-size: 15px">Razón social</td>
                    <td>{{ mb_strtoupper($empresa) }}</td>
                    <td style="font-size: 15px">Domicilio fiscal</td>
                    <td>{{ mb_strtoupper($domicilio) }} C.P. {{ $cp }}</td>
                </tr>
                <tr>
                    <td style="font-size: 15px">RFC</td>
                    <td style="font-size: 15px">{{ $rfc }}</td>
                    <td style="font-size: 15px">Registro de productor autorizado</td>
                    <td style="font-size: 15px">{{ $productor_autorizado }}</td>
                </tr>
            </table>
        </div>


        <div style="height: 20px"></div>
        <div style="font-size: 14px; text-align: justify;">
            Con fundamento en los artículos 53, 54, 55, 56, 57 y 69 de la Ley de Infraestructura de la Calidad, la
            Norma Oficial Mexicana NOM-070-SCFI-2016, Bebidas alcohólicas-Mezcal- Especificaciones y el
            apartado 7.4 de la Norma Mexicana NMX-EC-17020-INMC-2014 “Evaluación de la conformidadRequisitos para el
            funcionamiento de diferentes tipos de unidades (organismos) que realizan la verificación
            (Inspección)”; la Unidad de Inspección CIDAM A.C. con domicilio en Kilómetro 8 Antigua Carretera a
            Pátzcuaro, S/N Colonia Otra no Especificada en el Catálogo, C.P. 58341, Morelia, Michoacán.con número
            de acreditación UVNOM 129 ante la Entidad Mexicana de Acreditación A.C. y debidamente aprobada por
            la Dirección General de Normas de la Secretaría de Economía.
        </div>
        <div style="font-size: 14px; text-align: justify;padding-bottom: 10px; padding-top: 10px">El producto tiene como
            destino la venta de exportación a:
        </div>
        <div class="bloque-contenedor">
            <table class="tabla-casillas">
                <tr>
                    <td style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 110px"><b>Importador</b>
                    </td>
                    <td style="width: 90px; font-size: 15px">{{$importador}}</td>
                    <td style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 110px"><b>Dirección</b>
                    </td>
                    <td style="width: 90px; font-size: 14.3px">{{$direccion}}</td>
                </tr>
                <tr>
                    <td style="font-size: 15px"><b>País de destino</b></td>
                    <td style="width: 90px;font-size: 15px">{{$pais}}</td>
                    <td style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 110px"><b>Aduana de
                            salida</b></td>
                    <td style="font-size: 15px; width: 90px">{{$aduana}}</td>
                </tr>
                <tr>
                    <td style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 110px"><b>RFC</b></td>
                    <td style="font-size: 15px; width: 90px">---</td>

                </tr>
            </table>
        </div>
        <div style="page-break-after: always;"><br></div>
        <br>
        <br>
        @foreach($lotes as $lote)
            <br>
            <br>
            <br>
            <br>
            <div class="bloque-contenedor">
                <table class="tabla-casillas">
                    <tr>
                        <td style="font-size: 15px; padding-bottom: 15px; padding-top: 15px; width: 90px">
                            <b>Identificación</b>
                        </td>
                        <td style="width: 90px">---</td>
                        <td style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 90px"><b>Marca</b></td>
                        <td style="width: 90px">{{ $lote->marca->marca ?? "No encontrada"}} </td>
                        <td style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 90px"><b>Producto</b>
                        </td>
                        <td style="width: 90px">{{ $lote->lotesGranel->first()->categoria->categoria ?? "No encontrada"}}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px;padding-bottom: 0; padding-top: 0;"><b>Categoría</b></td>
                        <td>{{ $lote->lotesGranel->first()->categoria->categoria ?? "No encontrada"}}</td>
                        <td style="font-size: 15px;padding-bottom: 0; padding-top: 0;"><b>Clase</b></td>
                        <td>{{ $lote->lotesGranel->first()->clase->clase ?? "N"}}</td>
                        <td style="font-size: 15px;padding-bottom: 0; padding-top: 0;"><b>% Alc. Vol.<br>(etiqueta)</b></td>
                        <td> {{ $lote->cont_alc_envasado ?? "No encontrada" }}% </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px;"><b>Cont. Net. <br>(mL)</b></td>
                        <td>{{ $presentacion ?? '' }} </td>
                        <td style="font-size: 15px;"><b>No. Botellas</b></td>
                        <td>{{$botellas}}</td>
                        <td style="font-size: 15px;"><b>No. Cajas</b></td>
                        <td>{{$cajas}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-size: 15px; padding-bottom: 10px; padding-top: 10px; width: 90px;">
                            <b>No. de Certificado</b></td>
                        <td colspan="4" style="font-size: 15px;"></td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px;"><b>Lote de <br>Envasado</b></td>
                        <td>{{ $lote->nombre ?? "No encontrada" }}</td>
                        <td style="font-size: 15px;"><b>Estado <br>Productor</b></td>
                        <td>{{$envasado_en}}</td>
                        <td style="font-size: 15px;"><b>Lote a <br>granel</b></td>
                        <td>{{ $lote->lotesGranel->first()->nombre_lote ?? "No encontrada" }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px;"><b>No. Análisis</b></td>
                        <td>{{ $lote->lotesGranel->first()->folio_fq ?? "No encontrada" }}</td>
                        <td style="font-size: 15px;"><b>% Alc. Vol. <br>(No. análisis)</b></td>
                        <td>{{ $lote->lotesGranel->first()->cont_alc ?? "No encontrada" }}% Alc. Vol.</td>
                        <td style="font-size: 15px;"><b>Especie de agave o maguey</b></td>
                        <td style="font-size: 12px;">
                            {{ $lote->lotesGranel->first()->tiposRelacionados->pluck('nombre')->implode(', ') ?? 'No encontrado' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px;"><b>Ingrediente</b></td>
                        <td>---</td>
                        <td style="font-size: 15px;"><b>Sellos</b></td>
                        <td>---</td>
                    </tr>
                </table>
            </div>


            @if($loop->last)<!--AL FINAL DE LA TABLA-->
                <div style="height: 15px"></div>
                <div>OBSERVACIONES:</div>
                <div style="text-align: center;">
                    <p style="font-size: 18px;">Gerente sustituto de la Unidad de Inspección</p>
                </div>


                <div style="height: 40%"></div><!--espacio alto-->




            @endif


            @if(!$loop->last) <!--salto de página si NO es el último lote-->
                <div style="page-break-after: always;"></div>
            @endif
        @endforeach




    </div>








</body>

</html>