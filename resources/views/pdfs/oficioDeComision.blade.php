<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficio de Comisión</title>
    <style>
        body {
            font-family: 'Century Gothic', sans-serif;
        }

        @page {
            margin-left: 50px;
            margin-right: 50px;
            /* Elimina los márgenes */
        }

        .header {
            text-align: right;
            font-size: 12px;
            margin-right: 50px;

        }

        .logo {
            float: left;
            width: 120px;
        }

        .clear {
            clear: both;
        }

        .title {
            text-align: center;
            margin-top: 30px;
            font-weight: bold;
            font-size: 18px;
        }

        .content {
            margin-right: 50px;
            margin-left: 50px;
            font-size: 16px;
            line-height: 1.5;
            text-align: justify;
        }

        .content p {
            margin: 20px 0;
        }

        .signature {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }



        .no-margin-top {
    margin-top: 0;
  }
  .footer{
    margin-top: 45px;
    font-size: 10px;
    text-align: center;
  }
    </style>
</head>

<body>
        <img src="{{ public_path('img_pdf/logo_cidam_texto.png') }}" style="width: 140px; float: left;" class="no-margin-top" alt="Logo CIDAM" class="logo">

    <div class="header">
        <p>
            Oficio de Comisión F-UV-02-9<br>
            Edición 5, 15/07/2024 <br>
            ________________________________________________________________________________
        </p>
    </div>
    <div class="title">
        Oficio de Comisión
    </div>

    <div class="content" >
        <div style="text-align: right; margin-top: 0px;">
            <p>
                Oficio No. _____/20___<br>
                Oficina: Gerencia Técnica<br>
                ______________ , ___ a ___ de ____ del 20___
            </p>
        </div>


        <p>
            C. __________________________<br>
            Inspector designado
        </p>

        <p>
            <strong>P R E S E N T E.-</strong>
        </p>

        <p>
            Mediante el presente designo a Usted para que realice el servicio ________________, indicado en la orden de
            servicio No. ______/20___, en el domicilio y con el responsable que indica la misma. Para esta diligencia
            debe presentarse en las instalaciones referidas a las ______.
        </p>

        <p>
            Durante el servicio indicado deberá llenar el Acta circunstanciada y los registros correspondientes a la
            actividad que realiza.
        </p>

        <p>
            Al final de su intervención deberá enviar los registros correspondientes al Gerente Técnico para la revisión
            y continuidad del proceso.
        </p>

        <div class="signature">
            <p>
                Atentamente
            </p>
            <p>
                ________________________________<br>
                Gerente Técnico
            </p>
        </div>
    </div>

    <div class="footer">
        Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede <br>
        ser distribuido externamente sin la autorización escrita del Director Ejecutivo
    </div>

</body>

</html>
