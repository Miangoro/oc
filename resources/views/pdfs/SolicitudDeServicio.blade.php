<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body img {
            width: 105px;
            object-fit: cover;


        }

        body {
            font-family: Georgia, 'Times New Roman', Times, serif;
            margin: 30px;
            font-size: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #608390;
            color: white;
            text-align: center;
            font-size: 11px;
            font-family: Arial, sans-serif;

        }

        .td-margins {
            border-bottom: none;
            border-top: none;
            border-right: 1px solid black;
            border-left: 1px solid black;
        }

        .td-no-margins {
            border: none;
        }

        .letra_td {
            text-align: right;
        }

        .th-color {
            background-color: #d8d8d8;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td rowspan="3">
                <div>
                    <center>
                        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM"
                            style="max-width: 100%; height: auto;">
                    </center>
                </div>
            </td>
            <td rowspan="2" colspan="5">SOLICITUD DE SERVICIOS</td>
            <td colspan="3" style="text-align: right">Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32 <br>
                Edición 10 Entrada en vigor:
                20/06/2024</td>
        </tr>
        <tr>
            <td colspan="3">
                ORGANISMO DE CERTIFICACION No. de <br> acreditación 144/18 ante la ema A.C
            </td>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td class="th-color">N° DE SOLICITUD:</td>
            <td colspan="3">&nbsp;</td>

        </tr>
        </tr>
        <tr>
            <th>I:</th>
            <th colspan="8">INFORMACIÓN DEL SOLICITANTE</th>
        </tr>
        <tr>
            <td rowspan="2">Nombre del cliente/ o Razon <br> social:</td>
            <td rowspan="2" colspan="4">&nbsp;</td>
            <td>N° de cliente:</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>e-mail:</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>Fecha de solicitud:</td>
            <td colspan="4">&nbsp;</td>
            <td>Teléfono:</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>Responsable de las <br> instalaciones</td>
            <td colspan="4">&nbsp;</td>
            <td>SKU:</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>Domicilio Fiscal:</td>
            <td colspan="4">&nbsp;</td>
            <td rowspan="2"> Dirección de destino: <br> Empresa de destino:</td>
            <td colspan="3" rowspan="2">&nbsp;</td>

        </tr>
        <tr>
            <td>Domicilio de inspección:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <th>II:</th>
            <th colspan="8">
                SERVICIO SOLICITADO A LA UVEM
            </th>
        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="color: red">Seleccione el servicio solicitado colocando una X
                en la casilla
                correspondiente.</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Muestreo de agave (ART)</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>

            <td colspan="2" class="td-no-margins letra_td">Fecha y hora de visita <br> propuesta</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Vigilancia en producción de lote</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>

            <td colspan="2" class="td-no-margins letra_td">Fecha y hora de visita <br> propuesta</td>
            <td colspan="4">&nbsp;</td>

        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Muestreo de lote a granel</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>

            <td colspan="2" class="td-no-margins letra_td">Fecha y hora de visita <br> propuesta</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Vigilancia en el traslado del lote</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>

            <td colspan="2" class="td-no-margins letra_td">Fecha y hora de visita <br> propuesta</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Inspección de envasado</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>

            <td colspan="2" class="td-no-margins letra_td">Fecha y hora de visita <br> propuesta</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Muestreo de lote envasado</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>

            <td colspan="2" class="td-no-margins letra_td">Fecha y hora de visita <br> propuesta</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Inspeccion ingreso a barrica/ contenedor de <br>vidrio</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>

            <td colspan="2" class="td-no-margins letra_td">Fecha y hora de visita <br> propuesta</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Liberación de productoterminado</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>

            <td colspan="2" class="td-no-margins letra_td">Fecha y hora de visita <br> propuesta</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Inspección de liberación a barrica/contenedor <br>de vidrio</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>

            <td colspan="2" class="td-no-margins letra_td">Fecha y hora de visita <br> propuesta</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Georreferenciación</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>
            <td colspan="2" class=" td-no-margins letra_td">Fecha y hora de visita <br> propuesta</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Pedidos para exportación</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>

            <td colspan="2" class=" td-no-margins letra_td">Fecha y hora de visita <br> propuesta</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Emisión de certificado NOM a granel</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>

            <td colspan="2" class="td-no-margins letra_td">Fecha de emisión <br>propuesta:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-margins letra_td">Emisión de certificado venta nacional</td>
            <td>&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>

            <td colspan="2" class="td-no-margins letra_td">Fecha de emisión <br>propuesta:</td>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td class="td-no-margins" colspan="9">Este documento es propiedad del Centro de Innovación y Desarroll
                Agroalimentario de Michoacán A.C.</td>
        </tr>
        <tr>
            <td class="td-no-margins">&nbsp;</td>
        </tr>
        <tr>
            <td rowspan="2" class="td-margins letra_td">Dictaminación de instalaciones:</td>
            <td rowspan="2">&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>
            <td>Productor de <br>Mezca</td>
            <td>&nbsp;</td>
            <td>Envasador</td>
            <td>&nbsp;</td>
            <td>Comercializador</td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td class="td-no-margins">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td">Fecha y hora de visita
                propuesta:</td>
            <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <td rowspan="2" class="td-margins letra_td">Renovación de dictaminación de instalaciones:</td>
            <td rowspan="2">&nbsp;</td>
            <td class="td-no-margins">&nbsp;</td>
            <td>Productor de <br>Mezca</td>
            <td>&nbsp;</td>
            <td>Envasador</td>
            <td>&nbsp;</td>
            <td>Comercializador</td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td class="td-no-margins">&nbsp;</td>
            <td colspan="2" class="td-no-margins letra_td">Fecha y hora de visita
                propuesta:</td>
            <td colspan="4">&nbsp;</td>
        </tr>

        <tr>
            <th>III:</th>
            <th colspan="8">CARACTERISTICAS DEL PRODUCTO</th>
        </tr>

        <tr>
            <td>1) No. de lote granel:</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="3">6) No. de certificado NOM de Mezcal a
                granel vigente:</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>2) Categoria:</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="3">7) Clase:</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>3) No. de análisis de
                laboratorio:</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="3">8) Contenido Alcohólico:</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>4) Marca:</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="3">9) No. de lote de envasado:</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>5) Especie de Agave:</td>
            <td colspan="2">&nbsp;</td>
            <td colspan="3">10) Cajas y botellas:</td>
            <td colspan="3">&nbsp;</td>
        </tr>

    </table>
    <br>
    <table>
        <tr>
            <td rowspan="3">
                <div>
                    <center>
                        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM"
                            style="max-width: 100%; height: auto;">
                    </center>
                </div>
            </td>
            <td rowspan="2" colspan="5">SOLICITUD DE SERVICIOS</td>
            <td colspan="3" style="text-align: right">Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32 <br>
                Edición 10 Entrada en vigor:
                20/06/2024</td>
        </tr>
        <tr>
            <td colspan="3">
                ORGANISMO DE CERTIFICACION No. de <br> acreditación 144/18 ante la ema A.C
            </td>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td class="th-color">N° DE SOLICITUD:</td>
            <td colspan="3">&nbsp;</td>

        </tr>
        <tr>
            <td colspan="3">INFORMACIÓN ADICIONAL SOBRE LA ACTIVIDAD:</td>
            <td colspan="6">&nbsp;</td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td rowspan="3">
                <div>
                    <center>
                        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM"
                            style="max-width: 100%; height: auto;">
                    </center>
                </div>
            </td>
            <td rowspan="2" colspan="5">SOLICITUD DE SERVICIOS</td>
            <td colspan="3" style="text-align: right">Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32 <br>
                Edición 10 Entrada en vigor:
                20/06/2024</td>
        </tr>
        <tr>
            <td colspan="3">
                ORGANISMO DE CERTIFICACION No. de <br> acreditación 144/18 ante la ema A.C
            </td>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td class="th-color">N° DE SOLICITUD:</td>
            <td colspan="3">&nbsp;</td>

        </tr>
        <tr>
            <td class="td-margins" colspan="9" style="padding: .05px">&nbsp;</td>
        </tr>
        <tr>
            <th>V:</th>
            <th colspan="8">ANEXOS</th>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="8" style="text-align: center; color: red">Adjuntar a la solicitud los documentos que a
                continuación se enlistan:</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="7">Copia del análisis de laboratorio de cada uno de los lotes en cumplimiento con el
                apartado 4.3 de la NOM-070-SCFI-2016. En caso de <br>
                producto cuente con ajuste de grado alcohólico, reposado o añejo adjuntar copia de los analisis de
                laboratorio posteriores al proceso <br>
                en cumplimiento con el numeral 5 de la NOM-070-SCFI-2016.</td>
        </tr>
        <tr>
            <td colspan="9">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="9">La empresa se da por enterada que: la Unidad de Verificación establecerá una vigilancia
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
            <th>NO</th>
        </tr>

        <tr>
            <td colspan="4">Se cuenta con todos los medios para realizar todas las actividades de evaluación para la <br>
                Certificación:</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td rowspan="2" colspan="3">Validó solicitud y verificó la
                viabilidad del servicio:</td>
        </tr>
        <tr>
            <td colspan="4">El organismo de Certificación tiene la competencia para realizar la Certificación</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">El organismo de Certificación tiene la capacidad para llevar a cabo las actividades de <br>
                certificación</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td rowspan="2" colspan="3">Nombre y firma</td>
        </tr>
        <td colspan="2">Comentarios:</td>
            <td colspan="4">&nbsp;</td>
    </tr>

    </table>

</body>

</html>
