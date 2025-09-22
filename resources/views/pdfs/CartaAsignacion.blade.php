<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F7.1-01-27 Carta asignación del número de cliente NOM-070-SCFI-2016. Ed. 4, Vigente </title>
 
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 15px;
            color:#000000;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .text_marge{
            margin: 25px;
        }

        .header img {
            width: 250px;
            float: left;
            
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
        }

        .header h2 {
            font-size: 14px;
            margin: 0;
            font-weight: normal;
        }

        .header h6 {
            font-size: 10px;
            margin: 0;
        }

        .section {
            margin-top: 20px;
            margin-bottom: 3rem;
        }

        .section p {
            margin: 0px 5px;
        }

        .text_al {
            text-align: right;
            margin: 0; padding: 0;

        }


        .section .bold {
            font-weight: bold;
        }



        .text_c{
            color: rgb(4, 57, 78);
            margin: 2px 0; /* Ajusta el margen según sea necesario */

        }
        .content {
            margin-left: 20rem; /* Adjust this value as needed to ensure enough space on the right */
        }

        .Atentamente p {
            font-size: 16px;
            text-align: center;
            /*line-height: 0.8;*/
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('img_pdf/logo_oc_3d.png') }}" alt="Logo CIDAM">
        <h2 class="text_c font-weight-bold">Centro de Innovación y Desarrollo Agroalimentario <br> de Michoacán, A.C.</h2>
        <h2>Acreditado como organismo de certificación de producto con <br>
             número de acreditación 144/18 ante la Entidad Mexicana <br> 
             de Acreditación, A.C.</h2>

    </div>

    <div class="section content">
        <p class="text_al left">Oficio: <strong>{{ $codigo_oficio }}</strong></p>
        {{-- <p class="text_al left">Morelia, Michoacán. a __ de _____ del 20__</p> --}}
        
        <p class="text_al left">Morelia, Michoacán. a {{$fecha_registro}}</p>
        <p class="text_al left">ASUNTO: Asignación del número de cliente.</p>
    </div>

    <div class="section">
        <strong>C. REPRESENTANTE LEGAL</strong> <br>
        <span class="font-weight-bold" style="text-decoration: underline;"> {{ !empty($datos[0]->representante) && $datos[0]->representante !== 'No aplica' ? $datos[0]->representante : $datos[0]->razon_social }}</span> <br>
        <strong>PRESENTE</strong>
    </div>

    <div class="section">
        <p style="text-align: justify; text-indent: 40px;">Por medio de la presente el Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. acreditado como Organismo de Certificación de Producto, con número 144/18 ante la Entidad Mexicana de Acreditación, A.C. de acuerdo con los criterios establecidos en la Norma Mexicana NMX-EC-17065-IMNC-2014/ISO/IEC 17065:2012 para las actividades de certificación. Se le informa que a partir de esta fecha queda inscrito como cliente del Organismo Certificador del CIDAM, como parte de la cadena productiva Agave-Mezcal en los eslabones 
            @php
                $total = count($datos);
                $i = 0;
            @endphp

            @foreach ($datos as $eslabon)
            <strong>{{$eslabon->actividad}}</strong>{{ !$loop->last ? ',' : '' }}
            @php
                $i++;
            @endphp
            @endforeach
            
            por consiguiente se le designa el número:</p>
        <div class=" text-center">
            <strong>{{$datos[0]->numero_cliente}}</strong>
        </div>
        <div style="margin-bottom: 40px;">
            <p>Sin otro en particular le envío un cordial saludo.</p>

        </div>
    </div>



    @php
        use Illuminate\Support\Facades\Storage;
        use Carbon\Carbon;
        use App\Models\User;
        $firma = $contacto->firma ?? null;
        $firmaPath = $firma ? 'firmas/' . $firma : null;

        $fechaRegistro = Carbon::parse($datos[0]->created_at);
         // límite 15 de julio del mismo año
        $fechaLimite = Carbon::create(2025, 7, 16);
        // Regla especial
        if ($contacto->id == 320 && $fechaRegistro<$fechaLimite) {
            $contacto = User::find(2) ?? $contacto;
            $firma = $contacto->firma ?? null;
            $firmaPath = $firma ? 'firmas/' . $firma : null;
        }
    @endphp

    

    {{-- <div style="font-size: 16px; text-align: center; margin-top: 10px;"> --}}
    <div class="Atentamente">
        <p>Atentamente. <br>
            @if ($firma && Storage::disk('public')->exists($firmaPath))
                {{-- <img style="position: absolute; left: 37%; margin-top: 4%; " height="60px"
                src="{{ public_path('storage/' . $firmaPath) }}">
                <img style="position: absolute; left: 55%;" height="130px" width="180px" src="{{ public_path('img_pdf/Sello oc.png') }}" alt="sello"> --}}
                <img style="margin-top: 2%;"  height="60px"
                src="{{ public_path('storage/' . $firmaPath) }}">
                <img style="position: absolute; left: 55%;" height="130px" width="180px" src="{{ public_path('img_pdf/Sello oc.png') }}" alt="sello">
            @endif
            <br>
            <u>{{$contacto->name ?? 'No encontrado'}}</u><br><br>
            {{$contacto->puesto ?? 'No encontrado'}}
        </p>
    </div>
    

    
    <div style="margin-top: 20%;">
        <p class="text_al">Carta asignación del número de cliente NOM-070-SCFI-2016 F7.1-01-27</p>
        <p class="text_al">Edición 4 Entrada en vigor: 02-09-2022</p>
    </div>
    <div>
        <p class="text-center" style="font-size: 10px;">
            Este documento es propiedad del Centro de Innovación y Desarrollo Agroalimentario de Michoacán A.C. y no puede <br> 
            ser distribuido externamente sin la autorización escrita del Director Ejecutivo.
        </p>
    </div>
    
    
</body>

</html>
