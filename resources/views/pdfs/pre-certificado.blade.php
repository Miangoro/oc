<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de mezcal a granel</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            position: relative;
        }

        .watermark {
            position: absolute;
            top: 43%; 
            left: 55%; 
            width: 40%;
            height: auto;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1;
        }

        .header img {
            float: left;
            margin-left: -10px;
            margin-top: -30px;
        }

        .description1 {
            margin-right: 30px;
            font-size: 25px;
            font-weight: bold;
            text-align: right;
            font-family: 'Calibri', sans-serif;
        }

        .description2 {
            font-weight: bold;
            font-size: 12px;
            white-space: nowrap;
            position: relative;
            top: 8px;
            left: 30px;
            font-family: 'Calibri', sans-serif;
        }

        .foother {
            position: fixed;
            bottom: -40px;
            left: 0;
            width: 100%;
            text-align: center;
            margin: 0;
            padding: 10px 0;
            z-index: 1; 
        }

        .foother img {
            margin-top: 40px;
            width: 700px;
            height: auto;
            display: inline-block;
            margin: 0;
        }

        .pie {
            text-align: right;
            font-size: 10px;
            line-height: 1;
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            width: calc(100% - 40px);
            height: 45px;
            margin-right: 30px;
            padding: 10px 0;
            font-family: 'Lucida Sans Unicode';
            z-index: 1; 
        }

        .pie-pag {
            text-align: right;
            font-size: 12px;
            line-height: 1;
            position: fixed;
            bottom: 40px;
            left: 0;
            right: 0;
            width: calc(100% - 40px);
            height: 45px;
            margin-right: 30px;
            padding: 10px 0;
            font-family: 'Lucida Sans Unicode';
            z-index: 1; 
            color: #A6A6A6;
        }

        .text {
            margin-top: 40px;
            margin-left: 40px;
            margin-right: 40px;
            font-size: 10px;
            text-align: justify;
            position: relative;
            z-index: 1; 
        }

        .text2 {
            margin-top: 10px;
            margin-left: 40px;
            margin-right: 40px;
            font-size: 10px;
            text-align: justify;
            position: relative;
            z-index: 1; 
        }

        .titulo {
            margin-top: -10px;
            text-align: center;
            font-size: 50px;
            color: #808080;
            z-index: 1; 
        }

        .img-background-left {
            position: absolute;
            top: 90px; 
            left: -80px; 
            width: 144px;
            height: 850px; 
            max-height: 100vh; 
            z-index: -1;
            background-image: url('{{ public_path('img_pdf/img_granel.jpg') }}');
            background-size: contain; 
            background-repeat: no-repeat;
            background-position: center;
        }

        .subtitulo {
            margin-top: -50px;
            margin-left: 40px;
            font-family: 'calibri-bold';
        }

        .subtitulo2 {
            margin-top: 20px;
            margin-left: 40px;
            margin-bottom: 20px; 
            font-family: 'calibri-bold';
        }

        table {
            width: 90%; 
            border-collapse: collapse;
            margin: 25px 40; 
            font-size: 13px;
            margin: -10px 40px;
            white-space: normal;
        }

        td, th {
            border: 2px solid #1F497D;
            padding: 8px; 
            text-align: left;
        }

        th {
            background: #f0e6cc;
            font-weight: bold;
        }

        .columna {
            text-align: center;
            font-weight: bold; 
        }

        .columna-text {
            text-align: center;
            font-family: 'Arial', sans-serif;
        }

        .columna-norm {
            text-align: center;
        }

        .columna-end {
            font-weight: bold; 
            width: 150px;
        }

        .negrita {         
            font-family: 'calibri-bold';
        }

        .firma {
            margin-top: 30px;
            font-size: 13px;
            text-align: center;
            font-family: 'calibri-bold';
        }
    </style>

</head>
<body>
    <div class="img-background-left"></div>
    <img src="{{ public_path('img_pdf/logo_fondo.png') }}" alt="Marca de Agua" class="watermark">

    <div class="header">
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM" width="300px">
    </div>

    <div class="description1">ORGANISMO CERTIFICADOR</div>
    <div class="description2">Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C</div>

    <p class="text">El Centro de Innovación y Desarrollo Agroalimentario de Michoacán, (CIDAM) acreditado como Organismo de Certificación con acreditación No. 144/18,
    acreditado por la entidad mexicana de acreditación, a.c. y aprobado por la DGN con el No. 144/18 otorga el presente:</p>

    <p class="titulo">CERTIFICADO</p>
    <p class="subtitulo">DATOS DE LA EMPRESA</p>

    <table>
	<tbody>
		<tr>
		
        <td class="columna">Nombre de la empresa</td>
			<td colspan="3" class="columna">MESOAMERICANA DE BEBIDAS S. de R.L. de C.V. lore</td>
		</tr>
		
        <tr> 
			<td class="columna">Representante Legal</td>
			<td class="columna">Salvador Rentería Jasso</td>
			<td class="columna">Número de Certificado</td>
			<td class="columna-end">CIDAM C-GRA-210/2024</td>
		</tr>

		<tr>
			<td class="columna">Dirección</td>

            <td class="columna-text">
                <span class="negrita">Domicilio Fiscal:</span> Av. Las Palmas, Otra No Especificada En El Catalogo, C.P. 68228, Magdalena Apasco, Oaxaca.
                <br>
                <span class="negrita">Domicilio de Instalaciones:</span> Av. Las Palmas, Agencia de Lache, Barrio de Lache C.P. 68220, Magdalena Apasco, Oaxaca.
            </td>

            <td class="columna">Fecha de emisión </td>
			<td class="columna-norm">23/Agosto/2024</td>
		</tr>

		<tr>
			<td class="columna">RFC</td>
			<td class="columna">MBE180712Q57 </td>
			<td class="columna">Fecha de Vencimiento </td>
			<td class="columna-norm">23/Agosto/2025</td>
		</tr>
	</tbody>
</table>

<p class="subtitulo2">DESCRIPCIÓN DEL PRODUCTO</p>

<table>
	<tbody>
		<tr>
			<td colspan="6" class="columna"  style="font-size: 15px;">PRODUCTO: MEZCAL ARTESANAL<br>ORIGEN: OAXACA</td>
		</tr>
		<tr>
			<td class="columna" style="white-space: nowrap;">Categoría y clase</td>
			<td class="columna-norm">Artesanal Blanco o Joven</td>
			<td class="columna">No. de lote</td>
			<td class="columna-norm">2408ESPSN</td>
			<td class="columna">No. de análisis</td>
            <td class="columna-norm" style="white-space: nowrap;">OTR-A 015861.2</td>
		</tr>
		<tr>
			<td class="columna">Ingredientes</td>
			<td class="columna-norm">-----</td>
			<td class="columna" style="white-space: nowrap;">Volumen de lote</td>
			<td class="columna-norm">5279 L</td>
			<td class="columna">Contenido Alcohólico</td>
			<td class="columna-norm" style="white-space: nowrap;">51.0% Alc. Vol</td>
		</tr>
		<tr>
			<td class="columna">Tipo de maguey</td>
			<td class="columna-norm">Espadín (A. angustifolia)</td>
			<td class="columna">Edad</td>
			<td class="columna-norm">-----</td>
			<td class="columna">No. de dictamen</td>
			<td class="columna-norm" style="white-space: nowrap;">UMG-210/2024</td>
		</tr>
	</tbody>
</table>

<p class="text2">Este certificado de cumplimiento de mezcal a granel se expide de acuerdo a Norma Oficial Mexicana NOM-070-SCFI-2016. Bebidas Alcohólicasmezcal-especificaciones, en vigor.</p>

<p class="firma">AUTORIZÓ <br><br> Q.F.B. Mayra Gutiérrez Romero <br> Gerente Técnico del Organismo Certificador CIDAM</p>

  <p class="pie-pag">Página 1 de 1</p>
    <p class="pie">Certificado NOM de Mezcal a Granel NOM-070-SCFI-2016F7.1-01-07
    <br>
    Edición 7 Entrada en vigor: 07/11/2023
    </p>

    <div class="foother">
        <img src="{{ public_path('img_pdf/pie_certificado.png') }}" alt="Logo CIDAM" width="300px">
    </div>
</body>
</html>
