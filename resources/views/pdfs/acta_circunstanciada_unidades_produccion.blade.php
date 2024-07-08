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
            font-family: 'Times New Roman', Times, serif;
            margin: 35px;
            border: 3px dotted #14aa80;
            padding: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        td, th {
            text-align: left;
            vertical-align: middle;
        }
        .header-table td {
            padding-top: 0px;
        }

        .img img {
            width: 100px;
            height: auto;
            display: block;
            margin-left: 20px; /* Centra la imagen horizontalmente */
        }

        .text-titulo {
            width: 41%;
            text-align: center; /* Asegura que el contenido esté centrado */
            vertical-align: top; /* Alinea el contenido en la parte superior */
        }

        .centro {
            opacity: 0.5;
            position: relative;
            left: -52px; /* Mueve el contenido 5 píxeles a la izquierda */
            top: 15px; /* Mueve el contenido 5 píxeles hacia arriba */
        }

        .centro p{
            margin: 0;
        }

        .text-center {
            width: 25%;
        }

        .text-bold {
            font-weight: bold;
        }     

        .label {
            background-color: rgba(31, 179, 117, 0.5); /* Verde con 50% de opacidad */
            color: #ffffff;
            text-align: center;
            padding: 10px 15px; /* Ajusta estos valores para reducir la altura */
            font-family: sans-serif;
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
            display: inline-block; /* Asegura que el div solo ocupe el ancho necesario */
            width: auto; /* Asegura que el ancho se ajuste al contenido */
            margin-bottom: 0; /* Ajusta esto si necesitas un margen inferior específico */
            line-height: 1.2; /* Ajusta la altura de la línea para reducir la altura total */
            height: auto; /* Asegura que la altura se ajuste al contenido */
            box-sizing: border-box; 
        }

        .content-table td {
            text-align: center;
            height: 3%;
            width: 100%;
            border: none;
        }

        .contenedor {
            margin-left: 44px;
            margin-right: 44px;
            position: relative; /* Asegura que la posición sea relativa para que la marca de agua se posicione correctamente */
        }

        .sign-table td {
            border: 2px solid #0e695e;
            text-align: center;
            vertical-align: middle;
        }

        p {
            margin: 0;
        }

        p + p {
            margin-top: 5px; /* Ajusta este valor según sea necesario */
        }

        .texto {
            text-align: justify;
            word-spacing: 1px;
        }

        .footer {
            text-align: right;
            font-size: 13px;
            margin-right: 44px;
            opacity: 0.5;
        }

        .watermark {
            position: fixed;
            top: 50%; /* Ajusta la posición verticalmente */
            left: 50%; /* Ajusta la posición horizontalmente */
            transform: translate(-50%, -50%) rotate(-45deg) scaleY(1.5); /* Rotación y escala para mejor apariencia */
            opacity: 0.2; /* Ajusta la opacidad según sea necesario */
            font-size: 60px; /* Tamaño del texto de la marca de agua */
            white-space: nowrap; /* Evita que el texto se divida en múltiples líneas */
            z-index: -1; /* Asegura que esté detrás del contenido */
            pointer-events: none; /* No afecta la interacción del usuario */
        } 

    </style>
</head>
<body>

    <div class="watermark">Acta Circunstanciada</div>
    {{-- cabecera --}}
    <table class="header-table">
        <tr>
            <td class="img">
                <img src="{{ public_path('img_pdf/logo_uvem.png') }}" alt="Logo UVEM">
            </td>
            <td class="text-titulo">
                <div class="centro">
                    <p style="font-size: 23px; margin-bottom: 0px;">Acta Circunstanciada</p>
                    <p style="font-size: 14px; margin-top: 0px; ">Para unidades de producción</p>        
                </div>
            </td>
            <td class="text-center">
                <div class="label"><span class="text">F-UV-02-02 VERSIÓN 6</span> </div>
            </td>
        </tr>
    </table>
    {{-- contenedor --}}
    <div class="contenedor">

        <table class="content-table" style="margin-top: 15px;">
            <tr>
                <td style="text-align: left; width: 105px;"><strong>Acta número:</strong></td>
                <td style="border: 2px solid #0e695e; width: 180px; font-family: sans-serif;">
                    <b style="font-size: 13.5px;">UMS-____________/2024</b>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <br>
    <div class="texto" >
     <p>En la categoría de Unidad de producción de Agave ( ), unidad de producción de Mezcal ( ), planta de Envasado ( ), comercializadora ( ) o almacén ( ).</p>
    <p>En _______________________________ siendo las _______ horas del día _____ del mes de ______ del dos mil veinticuatro. El suscrito Inspector comisionado por la Unidad de Inspección de la Universidad Michoacana de San Nicolás de Hidalgo, me encuentro en la Unidad de producción.</p> <br>
    <p>Denominación social:  _________________________________________________ </p>
    <p>Dirección: ___________________________________________________________</p>
    <p>RFC: ___________________</p><br>
    <p>Para practicar la visita de inspección para generación del Dictamen de cumplimiento de instalaciones (X) en términos de la:</p>
    <p>Orden de servicio número: UMS-__________/2024</p>
    <p>De fecha: __________/2024</p>
    <p>Número de cliente: NOM-070-_________C</p> <br>
    <p>Cuyo original se entrega en el presente acto al C.___________________________________, quien dijo tener el cargo de responsable de instalaciones y ante quien me identifiqué debidamente exhibiendo la credencial vigente número _____________, expedida por la Unidad de Inspección con número de acreditación UVNOM 129, ante la entidad mexicana de acreditación, a.c y número de aprobación 312.01.2017.1017 otorgada por la Dirección General de Normas de la Secretaría de Economía; debidamente firmada por el director de la Unidad de Inspección, misma que la persona con quien se entiende la diligencia tiene a la vista, examina y devuelve al Inspector, acto seguido se requiere al visitado nombrar a dos testigos, a lo cual manifiesta de conformidad que _____ los designó, comunicándole que en caso de ausencia o negativa de los suscritos, se procederá con la actividad encomendada, a la cual manifiesta que se puede proceder con la diligencia. Las personas designadas por el interesado son las siguientes:</p>       
    </div> 

    <table class="sign-table" style="margin-top: 20px; font-size: 10;">
        <tr>
            <td style="width: 100px;">No. de testigo</td>
            <td>Nombre y firma del testigo</td>
            <td style="width: 280px;">Domicilio</td>
        </tr>
        <tr >
            <td style="height: 28px;">1</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="height: 28px;">2</td>
            <td></td>
            <td></td>
        </tr>
    </table>
    
    </div>
    <br><br><br>
    <div class="footer">
            <p>Entrada en vigor: 16-09-2021</p>
            <p>Página 1 de 4</p>
    </div>


{{-- seccion 2 --}}

    <table class="header-table">
        <tr>
            <td class="img">
                <img src="{{ public_path('img_pdf/logo_uvem.png') }}" alt="Logo UVEM">
            </td>
            <td class="text-titulo">
                <div class="centro">
                    <p style="font-size: 23px; margin-bottom: 0px;">Acta Circunstanciada</p>
                    <p style="font-size: 14px; margin-top: 0px; ">Para unidades de producción</p>        
                </div>
            </td>
            <td class="text-center">
                <div class="label"><span class="text">F-UV-02-02 VERSIÓN 6</span> </div>
            </td>
        </tr>
    </table>
    <br>
    {{-- contenedor --}}
    <div class="contenedor">
    <div class="texto" >
     <p><strong>Parte I Unidad de producción de ________________.</strong></p>
     <p>Se constató físicamente la existencia de la unidad de producción de agave: </p>
    </div> 
    <table class="sign-table" style="margin-top: 20px; font-size: 10;">
        <tr>
            <td style="width: 90px; height: 40px;">Nombre del predio</td>
            <td>Especie de agave</td>
            <td>Superficie (hectáreas)</td>
            <td>Madurez del agave (años)</td>
            <td>Plagas en el cultivo</td>
            <td>Cantidad de Plantas</td>
            <td style="width: 90px;">Coordenadas</td>
        </tr>
        <tr >
            <td style="height: 40px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="height: 40px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <br>
    <div class="texto" >
        <p><strong>Parte II Unidad de producción de Mezcal.</strong></p>
        <br>
        <p>Se constató físicamente la existencia del siguiente de las áreas y equipo:</p>
       </div> 
       <table class="sign-table" style=" font-size: 10;">
        <tr>
            <td style="width: 90px; height: 40px;">Recepción (materia prima)</td>
            <td>Área de pesado</td>
            <td>Área de cocción</td>
            <td>Área de maguey cocido</td>
            <td>Área de molienda</td>
            <td>Área de fermentación</td>
            <td style="width: 90px;">Área de destilación</td>
            <td>Almacén a graneles</td>
        </tr>
        <tr >
            <td style="height: 40px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
<br>
    <div class="texto" >
        <p>Se constató físicamente la existencia de los siguientes equipos: </p>
       </div>
       <table class="sign-table" style="margin-top: 20px; font-size: 10;">
        <thead>
            <tr>
                <td style="width: 240px; height: 19px;">Equipo</td>
                <td style="width: 120px;">Cantidad</td>
                <td>Capacidad</td>
                <td>Tipo de material</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 15px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 15px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 15px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    </div>
    <br><br>
    <div class="footer">
        <p>Entrada en vigor: 16-09-2021</p>
        <p>Página 2 de 4</p>
</div>


{{-- seccion 3 --}}

    <table class="header-table">
        <tr>
            <td class="img">
                <img src="{{ public_path('img_pdf/logo_uvem.png') }}" alt="Logo UVEM">
            </td>
            <td class="text-titulo">
                <div class="centro">
                    <p style="font-size: 23px; margin-bottom: 0px;">Acta Circunstanciada</p>
                    <p style="font-size: 14px; margin-top: 0px; ">Para unidades de producción</p>        
                </div>
            </td>
            <td class="text-center">
                <div class="label"><span class="text">F-UV-02-02 VERSIÓN 6</span></div>
            </td>
        </tr>
    </table>
    <br>
    {{-- contenedor --}}
    <div class="contenedor">
    <div class="texto" >
    <p>Se constató que (_______) cuenta con la infraestructura y equipo para producir <u>Mezcal:</u></p>
    <br>
    <p>Categoría(s): ____________________ Clase(s): _________________ Otra: ______________.</p>
    <br>
    <p><strong>Parte III Unidad de envasado</strong></p>
    <p>Se constató físicamente la existencia del siguiente de las áreas y equipo:</p>
    </div> 
    
    <table class="sign-table" style="margin-top: 20px; font-size: 10;">
        <tr>
            <td style="width: 90px; height: 40px;">Almacén de insumos</td>
            <td style="width: 105px;">Almacén a gráneles</td>
            <td>Sistema de filtrado</td>
            <td>Área de envasado</td>
            <td>Área de tiquetado</td>
            <td>Almacén de producto terminado</td>
            <td style="width: 115px;">Área de aseo personal</td>
        </tr>
        <tr >
            <td style="height: 20px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <br>
    <div class="texto" >
        <p>Se constató que la unidad de envasado, ( ) cumple con los requisitos de infraestructura y
            equipamiento indispensables para el envasado de mezcal.</p>
        <br>
        <p>Se constató físicamente la existencia de los siguientes equipos: </p>
    </div> 

    <table class="sign-table" style="margin-top: 15px; font-size: 10;">
        <thead>
            <tr>
                <td style="width: 245px; height: 19px;">Equipo</td>
                <td style="width: 120px;">Cantidad</td>
                <td>Capacidad</td>
                <td>Tipo de material</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 15px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 19px;"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
<br>

    <div class="texto" >
        <p><b>Parte IV Unidad de comercialización</b></p>
        <br>
        <p>Se constató físicamente la existencia del siguiente de las áreas y equipo:</p>
        <br>
    </div> 
    
    <table class="sign-table" style=" font-size: 10;">
        <tr>
            <td style="width: 180px; height: 16px;">Bodega o almacén</td>
            <td>Tarimas</td>
            <td>Bitácoras</td>
            <td style="width: 120px;">Otro:</td>
            <td style="width: 120px;">Otro:</td>
        </tr>
        <tr >
            <td style="height: 19px;"></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
        <br>
    <div class="texto" >
        <p>Se procede a tomar evidencias fotográficas de la infraestructura y equipo relacionadas a la actividad realizada, las cuales serán integradas en su expediente.</p>
        <br>
        <p>Se cierra la presente acta. - Respecto a los hechos consignados en el presente acta y de conformidad con los artículos 53, 54, 55, 56, 57 y 69 de la Ley de Infraestructura de la Calidad, </p>
        <br>
    </div> 
    </div>

    <div class="footer">
        <p>Entrada en vigor: 16-09-2021</p>
        <p>Página 3 de 4</p>
    </div>

{{-- seccion 4 --}}
    <table class="header-table">
        <tr>
            <td class="img">
                <img src="{{ public_path('img_pdf/logo_uvem.png') }}" alt="Logo UVEM">
            </td>
            <td class="text-titulo">
                <div class="centro">
                    <p style="font-size: 23px; margin-bottom: 0px;">Acta Circunstanciada</p>
                    <p style="font-size: 14px; margin-top: 0px; ">Para unidades de producción</p>        
                </div>
            </td>
            <td class="text-center">
                <div class="label"><span class="text">F-UV-02-02 VERSIÓN 6</span></div>
            </td>
        </tr>
    </table>
    <br>
    <div class="contenedor">
        <div class="texto">
            <p>La Norma Oficial Mexicana NOM-070-SCFI-2016, Bebidas alcohólicas-Mezcal-Especificaciones y el apartado 7.4 de la Norma Mexicana NMX-EC-17020-IMNC-2014
                “Evaluación de la conformidad- Requisitos para el funcionamiento de diferentes tipos de
                unidades (organismos) que realizan la verificación (Inspección)”, se da oportunidad al visitado
                para que haga las observaciones y ofrezca pruebas en relación con los hechos contenidos en
                ella o por escrito hacer uso de tal derecho dentro del término de cinco días hábiles siguientes a
                la fecha en que se haya levantado la presente acta.</p>
            <p>Se da por terminada la presente diligencia siendo las ____:____ horas del día ______ del mes
                de ____________________ del dos mil veinticuatro.
            </p>
        </div>
    
        <div style="padding: 20px;">
            <table class="sign-table" style="font-size: 12;">
                <tr>
                    <td style="width: 45%; height: 10px;">Nombre del interesado</td>
                    <td>Nombre del Inspector</td>
                </tr>
                <tr>
                    <td style="height: 90px;"></td>
                    <td style="text-align: end; vertical-align: top; padding-top: 70px;">Mario Villanueva Flores</td>
                </tr>
            </table>
    
            <br>
    
            <table class="sign-table">
                <tr>
                    <td colspan="2">No conformidades identificadas en la inspección</td>
                </tr>
                <tr>
                    <td style="width: 45%; height: 33px; text-align: start;  vertical-align: top;">Infraestructura</td>
                    <td style="height: 33px; text-align: start;  vertical-align: top;">Equipo</td>
                </tr>
                <tr>
                    <td style="height: 350px;"></td>
                    <td style="height: 350px;"></td>
                </tr>
            </table>
        </div>
    </div>
     <br>
            <div class="footer">
            <p>Entrada en vigor: 16-09-2021</p>
            <p>Página 4 de 4</p>
        </div>


</body>
</html>
