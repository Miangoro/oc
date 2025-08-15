<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Etiquetas para muestras de agave (ART/ARD)</title>
    <style>
        @page {
            size: 292mm 227mm;
            margin: 2px 40px 15px 40px;  /*márgenes (arriba, derecha, abajo, izquierda) */
        }
        body {
            font-family: sans-serif;
            /*font-family: 'Arial Negrita', Gadget, sans-serif; /*negrita*/
            font-size: 10px;
        }

        /*tabla*/
        td {
            border: 2px solid #000000;
            text-align: center;
            padding: 4px;
            /* vertical-align: middle;
            height: 17px; */
        }
        .azul {
            background-color: #3f84c7;
            color: white;
            font-weight: bold;
        }

        .footer {
            /* border: 2px solid blue; */
            position: fixed;
            width: 100%;
            bottom: 0;
            height: 50px;
            font-family: 'Lucida Sans Unicode';
            font-size: 14px;
            line-height: 0.8;
        }
        .left {
            position: absolute;
            left: 0;
            text-align: center;
        }
        .right {
            position: absolute;
            right: 0px;
            top: -25px;
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="footer">
        <p class="left">
            Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede ser<br>distribuido externamente sin la autorización escrita del Director Ejecutivo.
        </p>
        <p class="right">
            F-UV-04-04<br>Edición 17, 07/08/2025
        </p>
    </div>



    <table style="border-collapse: collapse; " width=100%>
            <tr>
                <td colspan="6" class="azul" style="background-color: #0d5295;">
                    CENTRO DE INNOVACION Y DESARROLLO AGROALIMENTARIO DE MICHOACÁN - UNIDAD DE INSPECCCION UVNOM-129
                </td>
            </tr>

            <tr>
                <td rowspan="4">
                    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 70px; padding-left: 8px" alt="Unidad de Inspección">
                </td>

                <td colspan="4" class="azul" style="background-color: #0d5295; font-size: 13px;">ETIQUETAS PARA MUESTRAS DE AGAVE(%ART Y/O ARD)</td>
                
                <td rowspan="4">
                    <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" style="position: absolute; width: 140px; height: 70px; padding-left: 8px" alt="Unidad de Inspección">
                </td>
            </tr>

            <tr>
                <td class="azul">FECHA DEL SERVICIO:</td>
                <td>{{ $fecha_muestreo }}</td>
                <td class="azul">NO. DE SERVICIO:</td>
                <td>{{ $datos->num_servicio ?? 'Sin asignar' }} </td>
            </tr>
            <tr>
                <td class="azul">RAZÓN SOCIAL:</td>
                <td colspan="3">{{ $datos->solicitud->empresa->razon_social }}</td>
            </tr>
            <tr>
                <td class="azul">DOMICILIO DEL SERVICIO:</td>
                <td colspan="3">{{ $datos->solicitud->instalaciones->direccion_completa ?? '' }}</td>
            </tr>


            <tr>
                <td colspan="2" class="azul">MAESTRO MEZCALERO:</td>
                <td>{{-- {{ $datos->solicitud->lote_granel->certificadoGranel?->maestro_mezcalero ?? '' }} --}}
                    {{ $datos->solicitud?->lotesGranel?->certificadoGranel?->maestro_mezcalero ?? '' }}
                    </td>
                <td class="azul">DESTINO DE LA MUESTRA:</td>
                <td colspan="2"> </td>
            </tr>

            <tr>
                <td colspan="6" style="padding: 10px"></td><!--LINEAAAA-->
            </tr>
    </table>


    <table style="border-collapse: collapse; " width=100%>
        <tr>
            <td style="width: 15%"> </td>
            <td class="azul" style="width: 20%">NO. DE GUÍA/NO. DE PREDIO:</td>
            <td>xxx</td>
            <td></td>
            <td class="azul" style="width: 15%">NO. DE TAPADA:</td>
            <td>xxx</td>
        </tr>
        <tr>
            <td> </td>
            <td class="azul">PESO DE MAGUEY (KG):</td>
            <td> </td>
            <td style="width:2px"> </td>
            <td class="azul">EDAD DEL AGAVE:</td>
            <td> </td>
        </tr>
        <tr>
            <td> </td>
            <td class="azul">NO. DE PIÑAS COMERCIALIZADAS:</td>
            <td> </td>
            <td style="width:2px"> </td>
            <td class="azul">TIPO DE AGAVE O MAGUEY:</td>
            <td>
                @if (isset($datos->solicitud->lote_granel) && $datos->solicitud->lote_granel->tipos_relacionados)
                    @foreach ($datos->solicitud->lote_granel->tipos_relacionados as $tipo)
                        {{ $tipo->nombre ?? '' }} (<em>{{ $tipo->cientifico ?? '' }}</em>)
                        @if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                @endif
            </td>
        </tr>

        
        <tr>
            <td colspan="6" style="padding:10"> </td>
        </tr>
 
        <tr>
            <td class="azul">ANÁLISIS A REALIZAR:</td>
            <td colspan="2">Art :________   %aArd:____________ </td>
            <td style="width:2px"> </td>
            <td class="azul">TIPO DE LA MUESTRA:</td>
            <td>MAGUEY CRUDO:_________     MAGUEY COCIDO:__________</td>
        </tr>

        <tr>
            <td colspan="6" style="padding:10"> </td>
        </tr>

        <tr>
            <td colspan="2" style="padding:10">{{ $datos->inspector->name }}</td>
            <td colspan="2" style="width:2px; padding:10"> </td>
            <td colspan="2" style="padding:10">{{ $datos->inspector->name }}</td>
        </tr>

        <tr>
            <td colspan="2" class="azul">NOMBRE Y FIRMA </td>
            <td colspan="2" style="width:2px"> </td>
            <td colspan="2" class="azul">NOMBRE Y FIRMA</td>
        </tr> --}}
    </table>




</body>
</html>
