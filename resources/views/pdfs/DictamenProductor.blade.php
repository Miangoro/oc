<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>F-UV-02-04 Ver 10, Dictamen de cumplimiento de Instalaciones como productor</title>
    <style>
       
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ public_path('img_pdf/UVEM_logo.png') }}" alt="Logo UVEM" width="275px">
    </div>
    <br>
    <div class="description1">Unidad de Inspección No. UVNOM-129</div>
    <div class="description2">Centro de Innovación y Desarrollo Agroalimentario de Michoacán, A.C.</div>
    <div class="description3">Acreditados ante la Entidad Mexicana de Acreditación, A.C</div>
    <div class="textimg font-lucida-sans-seminegrita">No.: <u>{{ $datos->num_dictamen }}</u></div>
    <div class="title">Dictamen de cumplimiento de Instalaciones como <br> productor</div>
    <div class="text">
        <p>De acuerdo a lo establecido en los procedimientos internos de la Unidad de Inspección No. UVNOM 129 para
        la revisión de procesos de producción del producto Mezcal, su envasado y comercialización; y con fundamento
        en los artículos 56 Fracción I y 60 fracción I de la Ley de Infraestructura de la Calidad que establece el
        funcionamiento de las Unidades de Inspección.</p>
        <p>Después de realizar la inspección de las instalaciones en fecha del <u><span  class="font-lucida-sans-seminegrita">{{ $fecha_inspeccion }}</span></u> partiendo del acta
        circunstanciada o número de inspección: <u><span  class="font-lucida-sans-seminegrita">{{ $datos->inspeccione->num_servicio }}</u></span></p>
        <p class="textp">Nombre del productor/empresa: <u>{{ $datos->inspeccione->solicitud->empresa->razon_social }}</u></p>
    </div>
    <table>
        <tbody id="tabla">
            <tr>
            <td style="text-align: justify;">
            <span class="font-lucida-sans-seminegrita">Número de cliente:</span><br>
            (Otorgado por el Organismo Certificador del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C.) (CIDAM)
            </td>
                <td style="text-align: center; vertical-align: middle;">{{ $datos->inspeccione->solicitud->empresa->empresaNumClientes[0]->numero_cliente }}</td>
            </tr>
            <tr>
            <td>
            <span class="font-lucida-sans-seminegrita">Domicilio Fiscal:</span>
            </td>

                <td style="text-align: center; vertical-align: middle;">{{ $datos->inspeccione->solicitud->empresa->domicilio_fiscal }}</td>
            </tr>
            <tr>
            <td>
            <span class="font-lucida-sans-seminegrita">Domicilio de la unidad de producción:</span>
            </td>
                <td style="text-align: center; vertical-align: middle;">{{ $datos->instalaciones->direccion_completa }}</td>
            </tr>
            <tr>
                <td class="font-lucida-sans-seminegrita">Responsable de la inspección:</td>
                <td style="text-align: center; vertical-align: middle;">{{ $datos->inspeccione->inspector->name }}</td>
            </tr>
            <tr>
                <td class="font-lucida-sans-seminegrita">Fecha de emisión de dictamen:</td>
                <td style="text-align: center; vertical-align: middle;">{{ $fecha_emision }}</td>
            </tr>
            <tr>
                <td class="font-lucida-sans-seminegrita">Periodo de vigencia hasta:</td>
                <td style="text-align: center; vertical-align: middle;">{{ $fecha_vigencia }}</td>
            </tr>
        </tbody>
    </table>
    <p class="text">
    Se dictamina que la <span class="font-lucida-sans-seminegrita">Unidad de producción</span> cuenta con la infraestructura, el equipo y los procesos necesarios
    para la producción de <span class="font-lucida-sans-seminegrita">Mezcal, clase (s)</span>, requisitos establecidos en la NOM-070-SCFI-2016,
    Bebidas alcohólicas-Mezcal-Especificaciones y por el Organismo de Certificación del Centro de Innovación y
    Desarrollo Agroalimentario de Michoacán A.C. (CIDAM)
   </p>

    <p class="text1">Las instalaciones se encuentran en región de los estados y municipios que contempla la resolución mediante el cual se otorga la protección
    prevista a la denominación de origen Mezcal, para ser aplicada a la bebida alcohólica del mismo nombre, publicada el 28 de noviembre
    de 1994, así como sus modificaciones subsecuentes.</p>
    <br><br>
    <p class="sello">Sello de Unidad de Inspección</p>
    <div class="images-container">
    <img src="{{ public_path('img_pdf/qr_umc-074.png') }}" alt="Logo UVEM" width="90px">
    <img src="{{ public_path('img_pdf/Sello ui.png') }}" alt="Imagen derecha" class="image-right">
    </div>
    <p class="textx" style="font-size: 10px; margin: 1;">
    <strong>AUTORIZÓ</strong>
    <span style="margin-left: 50px;">
        <strong>Gerente Técnico Sustituto de la Unidad de Inspección | BTG. Erik Antonio Mejía Vaca</strong>
    </span>
    </p>

    <p class="textx" style="font-size: 10px; margin: 1;">
    <strong>Cadena Origina</strong>
    <span style="margin-left: 29px;">
        <strong>UMG-159/2024|2024-06-26|UMS-1094/2024</strong>
    </span>
    </p>

    <p class="textx" style="font-size: 10px; margin: 1;">
    <strong>Sello Digital</strong>
    </p>

    <p class = "textsello">e2N1P+r+E79e0YxKzS/jMssKuASlmYXy2ppP+2PJN8vKUeFRxYTSY99MEWrgiHOnA N3pLUrdUBiD39v25Y648G4TK5qQ0LwZPLofRmjRQ2Ty5rHlDwnPRm37zaOkMjkRD<br>
    xC0ikyHPD+T3EFhEc9sgAFI6bZUd88yevfS+ZFZ7j9f5EA44Sz76jsN3P4e7lyePHmNz Jxg5ZupHICg5xBZu5ygOniMZNbzG6w0ZDPL58yoMQK1JDi8lwwiGJBaCNHN6krn<br>
    No5v5rvZPkbUthYT2r5M0sGP5Y+s97oLa8GA5hqyDAgE9P0d1u0uwU7Q8SF0GYfe lavijxvsWaZg5QA5og==
    </p>

    <div class="footer-bar">
        <p class="font-lucida-sans-seminegrita">www.cidam.org . unidadverificacion@cidam.org</p>
        <p>Kilómetro 8, Antigua Carretera a Pátzcuaro S/N. Col. Otra no especificada en el catálogo C.P. 58341. Morelia Michoacán</p>
    </div>

    <p class="pie">Entrada en vigor: 15-07-2024 <br>
    F-UV-02-04 Ver 10
    </p>
</div>
</body>
</html>