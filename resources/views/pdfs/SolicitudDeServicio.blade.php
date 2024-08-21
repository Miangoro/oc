<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        @page {
            margin-top: 50px;
            margin-right: 50px;
            margin-left: 50px;
            margin-bottom: 1px;
        }

        @font-face {
            font-family: 'Century Gothic';
            src: url('fonts/CenturyGothic.ttf') format('truetype');
            
        }

        @font-face {
            font-family: 'Century Gothic Negrita';
            src: url('fonts/GOTHICB.TTF') format('truetype');
        }

        body {
            font-family: 'Century Gothic', sans-serif;
            font-size: 10px;

        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1.5px solid black;
            padding: 3px;
            text-align: center;
        }

        th {
            background-color: #608390;
            color: white;
            padding-top: 0;
            padding-bottom: 0;
            text-align: center;
            font-size: 9px;
        }

        .td-margins {
            border-bottom: none;
            border-top: none;
            border-right: 0.5px solid black;
            border-left: 0.5px solid black;
           
        }

        .td-no-margins {
            border: none;
        }

        .td-barra {
            border-bottom: none;
            border-top: none;
            border-right: none;
            border-left: 1px solid black;
        }

        .letra_td {
            text-align: right;
        }

        .th-color {
            background-color: #d8d8d8;
        }

        .con-negra {
            font-family: 'Century Gothic Negrita';
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td rowspan="3" colspan="3" style="padding: 0; height: auto;">
                <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" style="width: 170px; margin: 0;" alt="Logo CIDAM">
            </td>

            <td class="con-negra" rowspan="2" colspan="5"
                style="font-size: 14px; padding-left: 13px; padding-right: 13px;">SOLICITUD DE SERVICIOS</td>
            <td colspan="5" style="text-align: right; font-size: 8.5px; padding-left: 0; padding-top: 0;">Solicitud de
                servicios NOM-070-SCFI-2016
                F7.1-01-32 <br>
                Edición 10 Entrada en vigor:
                20/06/2024</td>
        </tr>
        <tr>
            <td colspan="5" style="padding-top: 0; font-size: 9px;">
                ORGANISMO DE CERTIFICACION No. de <br> acreditación 144/18 ante la ema A.C
            </td>
        <tr>
            <td colspan="3">&nbsp;</td>
            <td class="th-color con-negra" colspan="2" style="padding-top: 5px;padding-bottom: 5px;">N° DE SOLICITUD:</td>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <th style="width:40px;">I:</th>
            <th colspan="12" style="padding-top: 2px;padding-bottom: 2px;">INFORMACIÓN DEL SOLICITANTE</th>
        </tr>
        <tr>
            <td class="con-negra" rowspan="2" colspan="2">Nombre del cliente/ o<br> Razon social:</td>
            <td rowspan="2" colspan="4">&nbsp;</td>
            <td class="con-negra" colspan="3">N° de cliente:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="3">e-mail:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2">Fecha de solicitud:</td>
            <td colspan="4">&nbsp;</td>
            <td class="con-negra" colspan="3">Teléfono:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" style="padding-top: 0; padding-bottom: 0;" colspan="2">Responsable de las <br> instalaciones</td>
            <td colspan="4">&nbsp;</td>
            <td class="con-negra" colspan="3">SKU:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2" style="padding-top: 1px; padding-bottom: 1px;">Domicilio Fiscal:</td>
            <td colspan="4">&nbsp;</td>
            <td class="con-negra" rowspan="2" style="width: 90px;" colspan="3">
                <br>Dirección de destino:
                <br>&nbsp;<br> Empresa de destino:
                <br>&nbsp;<br>
            </td>
            <td colspan="4" rowspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2">Domicilio de inspección:</td>
            <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
            <th>II:</th>
            <th colspan="12" style="padding-top: 0;padding-bottom: 0;">
                SERVICIO SOLICITADO A LA UVEM
            </th>
        </tr>
        <tr>
            <td class="td-margins con-negra" colspan="13" style="color: red; padding: 0;">Seleccione el servicio solicitado colocando una X en la casilla correspondiente.</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Muestreo de agave (ART)</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td" style="font-weight: bold"">Fecha y hora de visita propuesta</td>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 2px;"></td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Vigilancia en producción de lote</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td" style="font-weight: bold">Fecha y hora de visita propuesta</td>
            <td colspan="7">&nbsp;</td>

        </tr>
        <tr>
            <td class="td-margins" colspan="13"style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Muestreo de lote a granel</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td" style="font-weight: bold">Fecha y hora de visita propuesta</td>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Vigilancia en el traslado del lote</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td" style="font-weight: bold">Fecha y hora de visita propuesta</td>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13"style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Inspección de envasado</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td" style="font-weight: bold">Fecha y hora de visita propuesta</td>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Muestreo de lote envasado</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td" style="font-weight: bold">Fecha y hora de visita propuesta</td>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Inspeccion ingreso a barrica/ contenedor de vidrio</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td" style="font-weight: bold">Fecha y hora de visita propuesta</td>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Liberación de productoterminado</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td" style="font-weight: bold">Fecha y hora de visita propuesta</td>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Inspección de liberación a barrica/contenedor de vidrio</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td" style="font-weight: bold">Fecha y hora de visita propuesta</td>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Georreferenciación</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class=" td-no-margins letra_td" style="font-weight: bold">Fecha y hora de visita propuesta</td>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Pedidos para exportación</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class=" td-no-margins letra_td" style="font-weight: bold">Fecha y hora de visita propuesta</td>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Emisión de certificado NOM a granel</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td" style="font-weight: bold">Fecha de emisión propuesta:</td>
            <td colspan="7">&nbsp;</td>
        </tr>

        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Emisión de certificado venta nacional</td>
            <td style="width: 50px;">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td" style="font-weight: bold">Fecha de emisión propuesta:</td>
            <td colspan="7">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Dictaminación de instalaciones:</td>
            <td style="width: 50px;">&nbsp;</td>
            <td class="td-no-margins" style="width: 10px">&nbsp;</td>
            <td style="width: 50px" style="font-weight: bold">Productor de <br> Mezca</td>
            <td style="width: 10px">&nbsp;</td>
            <td style="width: 30px" style="font-weight: bold">Envasador</td>
            <td style="width: 30px">&nbsp;</td>
            <td style="width: 30px" colspan="2" style="font-weight: bold">Comercializador</td>
            <td style="width: 30px" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-barra" colspan="4">&nbsp;</td>
            <td colspan="2" class="td-no-margins" style="text-align: right" style="font-weight: bold">Fecha y hora de visita <br> propuesta:</td>
            <td colspan="7">&nbsp;</td>
        </tr>

        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td" colspan="3" style="font-weight: bold">Renovación de dictaminación de instalaciones:</td>
            <td style="width: 50px;">&nbsp;</td>
            <td class="td-no-margins" style="width: 1px">&nbsp;</td>
            <td style="width: 70px" style="font-weight: bold">Productor de <br> Mezca</td>
            <td style="width: 20px">&nbsp;</td>
            <td style="width: 30px" style="font-weight: bold">Envasador</td>
            <td style="width: 30px">&nbsp;</td>
            <td style="width: 30px" colspan="2" style="font-weight: bold">Comercializador</td>
            <td style="width: 30px" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="13" style="padding: 0;">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-barra" colspan="4">&nbsp;</td>
            <td colspan="2" class="td-no-margins" style="text-align: right" style="font-weight: bold">Fecha y hora de visita <br> propuesta:</td>
            <td colspan="7">&nbsp;</td>
        </tr>

        <tr>
            <th>III:</th>
            <th colspan="12" style="padding-top: 0;padding-bottom: 0;">CARACTERISTICAS DEL PRODUCTO</th>
        </tr>
        <tr>
            <td class="con-negra" colspan="2" style="text-align: left">1) No. de lote granel:</td>
            <td colspan="3">&nbsp;</td>
            <td class="con-negra" colspan="4" style="text-align: left">6) No. de certificado NOM de Mezcal <br> a granel vigente:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2" style="text-align: left">2) Categoria:</td>
            <td colspan="3">&nbsp;</td>
            <td class="con-negra" colspan="4" style="text-align: left">7) Clase:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2" style="text-align: left">3) No. de análisis de
                laboratorio:</td>
            <td colspan="3">&nbsp;</td>
            <td class="con-negra" colspan="4" style="text-align: left">8) Contenido Alcohólico:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2" style="text-align: left">4) Marca:</td>
            <td colspan="3">&nbsp;</td>
            <td class="con-negra" colspan="4" style="text-align: left">9) No. de lote de envasado:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="2" style="text-align: left">5) Especie de Agave:</td>
            <td colspan="3">&nbsp;</td>
            <td class="con-negra" colspan="4" style="text-align: left">10) Cajas y botellas:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
    </table>

    <br>
    <br>
    <br>
    <table>
        <tr>
            <td rowspan="3" colspan="2">
                <div>
                    <center>
                        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM"
                            style="max-width: 100px; height: auto;">
                    </center>
                </div>
            </td>
            <td class="con-negra" rowspan="2" colspan="4" style="font-size: 12px">SOLICITUD DE SERVICIOS</td>
            <td colspan="3" style="text-align: right; font-size: 10px !important;">Solicitud de servicios NOM-070-SCFI-2016
                F7.1-01-32 <br>
                Edición 10 Entrada en vigor:
                20/06/2024</td>
        </tr>
        <tr>
            <td colspan="3">
                ORGANISMO DE CERTIFICACION No. de <br> acreditación 144/18 ante la ema A.C
            </td>
        <tr>
            <td colspan="3">&nbsp;</td>
            <td class="th-color con-negra" style="width: 80px">N° DE SOLICITUD:</td>
            <td colspan="3">&nbsp;</td>

        </tr>
        <tr>
            <td class="con-negra" colspan="3" rowspan="3">INFORMACIÓN ADICIONAL SOBRE LA <br> ACTIVIDAD:</td>
            <td class="td-margins" colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="6">&nbsp;</td>

        </tr>
        <tr>
            <td class="td-margins" colspan="6">&nbsp;</td>

        </tr>
        <tr>
            <th>V:</th>
            <th colspan="8">ANEXOS</th>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="con-negra" colspan="8" style="text-align: center; color: red">Adjuntar a la solicitud los
                documentos que a
                continuación se enlistan:</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="7">Copia del análisis de laboratorio de cada uno de los lotes en
                cumplimiento con el
                apartado 4.3 de la NOM-070-SCFI-2016. En caso de <br>
                producto cuente con ajuste de grado alcohólico, reposado o añejo adjuntar copia de los analisis de
                laboratorio posteriores al proceso <br>
                en cumplimiento con el numeral 5 de la NOM-070-SCFI-2016.</td>
        </tr>
        <tr>
            <td class="con-negra" colspan="9">La empresa se da por enterada que: la Unidad de Verificación
                establecerá una vigilancia
                de cumplimiento con la NOM permanente a sus instalaciones una vez que <br>
                el Certificado NOM sea emitido. Para validar la información el OC podrá solicitar los documentos
                originales para su cotejo respectivo</td>
        </tr>
        <tr>
            <th colspan="6">VIABILIDAD DEL SERVICIO</th>
            <th rowspan="2" colspan="3">Validó solicitud y verificó la
                viabilidad del servicio:</th>
        </tr>
        <tr>
            <th colspan="4">DESCRIPCIÓN:</th>
            <th>SI</th>
            <th style="width: 40px">NO</th>
        </tr>

        <tr>
            <td class="sin-negrita" colspan="4">Se cuenta con todos los medios para realizar todas las actividades
                de evaluación para la <br>
                Certificación:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td rowspan="2" colspan="3">Validó solicitud y verificó la viabilidad del servicio: <br>&nbsp;<br>
            </td>
        </tr>
        <tr>
            <td class="sin-negrita" colspan="4">El organismo de Certificación tiene la competencia para realizar la
                Certificación</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td class="sin-negrita" colspan="4">El organismo de Certificación tiene la capacidad para llevar a cabo
                las actividades de <br>
                certificación</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td rowspan="2" colspan="3">Nombre y firma<br>&nbsp;<br></td>
        </tr>
        <td class="sin-negrita" colspan="2">Comentarios:</td>
        <td colspan="4">&nbsp;</td>
        </tr>
    </table>
    <table>



    </table>

</body>

</html>
