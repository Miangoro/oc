<?php

namespace App\Http\Controllers\guias;

use App\Helpers\Helpers;
use App\Models\Guias;
use App\Models\empresa;
use App\Models\Predios;
use App\Http\Controllers\Controller;
use App\Models\Documentacion_url;
use App\Models\predio_plantacion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
//codigo QR
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Auth;//sesion iniciada
use Illuminate\Support\Facades\Storage;


class GuiasController  extends Controller
{
    public function UserManagement()
    {
        $guias = Guias::all();
        $empresa = empresa::where('tipo', 2)->get(); // Esto depende de cómo tengas configurado tu modelo Empresa
        $predios = Predios::all();
        $userCount = $guias->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('guias.find_guias_maguey_agave', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'guias' => $guias,
            'empresa' => $empresa,
            'predios' => $predios,
        ]);
    }

    public function index(Request $request)
    {
        //Permiso de empresa
        $empresaId = null;
        if (Auth::check() && Auth::user()->tipo == 3) {
            $empresaId = Auth::user()->empresa?->id_empresa;
        }

        $columns = [
            1 => 'id_guia',
            2 => 'id_plantacion',
            3 => 'folio',
            4 => 'razon_social',
            5 => 'nombre_predio',
            6 => 'numero_plantas',
            7 => 'numero_guias',
            8 => 'num_anterior',
            9 => 'num_comercializadas',
            10 => 'mermas_plantas',
            11 => 'id_art',
            12 => 'kg_magey',
            13 => 'no_lote_pedido',
            14 => 'fecha_corte',
            15 => 'observaciones',
            16 => 'nombre_cliente',
            17 => 'no_cliente',
            18 => 'fecha_ingreso',
            19 => 'domicilio',
            20 => 'run_folio'
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'id_guia';
        $dir = $request->input('order.0.dir');

        $searchValue = $request->input('search.value');

        $query = Guias::with(['empresa.empresaNumClientes', 'predios'])
            ->groupBy('run_folio');
        if ($empresaId) {
            $query->where('id_empresa', $empresaId);
        }
        $baseQuery = clone $query;// Clonamos el query antes de aplicar búsqueda, paginación u ordenamiento
        $totalData = $baseQuery->count();


        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('run_folio', 'LIKE', "%{$searchValue}%")
                    ->orWhere('folio', 'LIKE', "%{$searchValue}%")
                    ->orWhere('id_empresa', 'LIKE', "%{$searchValue}%");

                $q->orWhereHas('empresa', function ($Nombre) use ($searchValue) {
                    $Nombre->where('razon_social', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('empresa.empresaNumClientes', function ($q) use ($searchValue) {
                    $q->where('numero_cliente', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('predios', function ($Predio) use ($searchValue) {
                    $Predio->where('nombre_predio', 'LIKE', "%{$searchValue}%");
                });
            });

            $totalData = $query->get()->count();
            $totalFiltered = $query->count();

        }else{
            $totalFiltered = $totalData;
        }

            
        

        $guias = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];

        if ($guias->isNotEmpty()) {
            $ids = $start;



            foreach ($guias as $user) {
                //$numero_cliente = empresaNumCliente::where('id_empresa', $user->id_empresa)->value('numero_cliente');
                // Nombre y Número de empresa
                $empresa = $user->empresa ?? null;

                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                    ? $empresa->empresaNumClientes->first(fn($item) =>
                        $item->empresa_id === $empresa->id && !empty($item->numero_cliente)
                    )?->numero_cliente ?? 'No encontrado' : 'N/A';

                
                $documentoGuia = Documentacion_url::where('id_relacion', $user->id_guia)
                    ->where('id_documento', 71)
                    ->first();

                $documentoArt = Documentacion_url::where('id_relacion', $user->id_guia)
                    ->where('id_documento', 132)
                    ->first();

                $nestedData = [

                    'documento_guia' => $documentoGuia?->url
                        ? asset("files/{$numero_cliente}/{$documentoGuia->url}") : null,

                    'documento_art' => $documentoArt?->url
                        ? asset("files/{$numero_cliente}/{$documentoArt->url}") : null,

                    'id_guia' => $user->id_guia,
                    'id_plantacion' => $user->id_plantacion,
                    'fake_id' => ++$ids,
                    'folio' => $user->folio,
                    'run_folio' => $user->run_folio,
                    'razon_social' => $empresa->razon_social ?? 'No encontrado',
                    'numero_cliente' => $numero_cliente, // Asignar numero_cliente
                    'id_predio' => $user->predios ? $user->predios->nombre_predio : '',
                    'numero_plantas' => $user->numero_plantas,
                    'num_anterior' => $user->num_anterior,
                    'num_comercializadas' => $user->num_comercializadas,
                    'mermas_plantas' => $user->mermas_plantas,
                    'id_art' => $user->id_art,
                    'kg_magey' => $user->kg_magey,
                    'no_lote_pedido' => $user->no_lote_pedido,
                    'fecha_corte' => $user->fecha_corte,
                    'observaciones' => $user->observaciones,
                    'nombre_cliente' => $user->nombre_cliente,
                    'no_cliente' => $user->no_cliente,
                    'fecha_ingreso' => $user->fecha_ingreso,
                    'domicilio' => $user->domicilio,
                    'numero_guias' => $user->numero_guias,
                ];
                $data[] = $nestedData;
            }
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
    }



//ELIMINAR
public function destroy($id_guia)
{
    $guia = Guias::findOrFail($id_guia);
    $run_folio = $guia->run_folio;

    // Obtener todas las guías con ese run_folio
    $guias = Guias::where('run_folio', $run_folio)->get();

    foreach ($guias as $guia) {
        // Buscar solo documentos con ID 71 (guía) o 132 (resultados ART)
        $documentos = Documentacion_url::where('id_relacion', $guia->id_guia)
            ->whereIn('id_documento', [71, 132])
            ->get();

        foreach ($documentos as $doc) {
            //Busca el archivo fisico
            $numeroCliente = $guia->empresa->empresaNumClientes->first()?->numero_cliente;
            $rutaArchivo = 'uploads/' . $numeroCliente . '/' . $doc->url;
            // Eliminar archivo físico si existe
            if ($numeroCliente && Storage::disk('public')->exists($rutaArchivo)) {
                Storage::disk('public')->delete($rutaArchivo);
            }

            // Eliminar registro en la tabla documentacion_url
            $doc->delete();
        }

        // Eliminar la guía
        $guia->delete();
    }

    return response()->json(['success' => 'Guías y documentos con mismo run_folio eliminados correctamente.']);
}



///REGISTRAR
public function store(Request $request)
{
    $userId = Auth::id(); // Obtiene el ID del usuario en sesión
    
    $request->validate([
        // Obligatorios
        'empresa' => 'required|exists:empresa,id_empresa',
        'numero_guias' => 'required|numeric',
        'predios' => 'required',
        'plantacion' => 'required',
        //opcionales
        'anterior' => 'nullable|numeric',
        'comercializadas' => 'nullable|numeric',
        'mermas' => 'nullable|numeric',
        'plantas' => 'nullable|numeric',

        // Nuevos campos opcionales
        'edad' => 'nullable|string|max:255',
        'art' => 'nullable|numeric|min:0',
        'kg_maguey' => 'nullable|numeric|min:0',
        'no_lote_pedido' => 'nullable|string|max:255',
        'fecha_corte' => 'nullable|date',
        'observaciones' => 'nullable|string|max:2000',
        'nombre_cliente' => 'nullable|string|max:255',
        'no_cliente' => 'nullable|string|regex:/^[A-Za-z0-9\-]+$/',
        'fecha_ingreso' => 'nullable|date',
        'domicilio' => 'nullable|string|max:255',
        //documentos
        'url.*' => 'nullable|file|max:10240',
        'id_documento.*' => 'nullable|integer',
        'nombre_documento.*' => 'nullable|string|max:255',
    ]);

    // Obtener el valor de plantas actuales y num_anterior
    $plantasActuales = $request->input('plantas');
    $numAnterior = $request->input('anterior');
    // Verificar si plantasActuales no es null
    if ($plantasActuales !== null) {
        // Calcular el valor a actualizar en predio_plantacion
        $plantasNuevas = $plantasActuales - $numAnterior;
    } else {
        // Si plantas es null, no modificamos predio_plantacion
        $plantasNuevas = null;
    }
    // Obtener el último run_folio creado
    $ultimoFolio = Guias::latest('run_folio')->first();
    // Extraer el número del último run_folio y calcular el siguiente número
    if ($ultimoFolio) {
        $ultimoNumero = intval(substr($ultimoFolio->run_folio, 9, 6)); // Extrae 000001 de SOL-GUIA-000001/24
        $nuevoNumero = $ultimoNumero + 1;
    } else {
        $nuevoNumero = 1;
    }
    // Formatear el nuevo run_folio
    $nuevoFolio = sprintf('SOL-GUIA-%06d-24', $nuevoNumero);


    $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->empresa)->first();
    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

    // Procesar la creación de las guías
    for ($i = 0; $i < $request->input('numero_guias'); $i++) {
        // Crear una nueva instancia del modelo Guia
        $guia = new guias();
        $guia->id_empresa = $request->input('empresa');
        $guia->numero_guias = $request->input('numero_guias');
        $guia->run_folio = $nuevoFolio;
        $guia->id_predio = $request->input('predios');
        $guia->id_plantacion = $request->input('plantacion');
        $guia->folio = Helpers::generarFolioGuia($request->predios);
        $guia->num_anterior = $numAnterior;
        $guia->num_comercializadas = $request->input('comercializadas');
        $guia->mermas_plantas = $request->input('mermas');
        $guia->numero_plantas = $plantasActuales;

        // Nuevos campos
        $guia->edad = $request->input('edad');
        $guia->art = $request->input('art');
        $guia->kg_maguey = $request->input('kg_maguey');
        $guia->no_lote_pedido = $request->input('no_lote_pedido');
        $guia->fecha_corte = $request->input('fecha_corte');
        $guia->observaciones = $request->input('observaciones');
        $guia->nombre_cliente = $request->input('nombre_cliente');
        $guia->no_cliente = $request->input('no_cliente');
        $guia->fecha_ingreso = $request->input('fecha_ingreso');
        $guia->domicilio = $request->input('domicilio');

        $guia->id_registro = $userId;//guardar quien solicita
        $guia->save();

        // Guardar documentos
        if ($request->hasFile('url')) {
            foreach ($request->file('url') as $index => $archivo) {
                if ($archivo) {
                    $nombreDoc = $request->nombre_documento[$index] ?? 'Sin nombre';
                    $filename = $nombreDoc . '_' . time() . '.' . $archivo->getClientOriginalExtension();
                    $filePath = $archivo->storeAs('uploads/' . $numeroCliente, $filename, 'public');

                    $documento = new Documentacion_url();
                    $documento->id_relacion = $guia->id_guia;
                    $documento->id_documento = $request->id_documento[$index] ?? null;
                    $documento->nombre_documento = $nombreDoc;
                    $documento->url = $filename;
                    $documento->id_empresa = $request->input('empresa');
                    $documento->save();
                }
            }
        }
    }

    // Actualizar la cantidad de plantas en la tabla predio_plantacion si es necesario
    if ($plantasNuevas !== null) {
        $predioPlantacion = predio_plantacion::where('id_predio', $request->input('predios'))
            ->where('id_plantacion', $request->input('plantacion'))
            ->first();
        if ($predioPlantacion) {
            $predioPlantacion->num_plantas = $predioPlantacion->num_plantas + $plantasNuevas;
            $predioPlantacion->save();
        }
    }

    // Responder con éxito
    return response()->json(['success' => 'Guía registrada correctamente']);
}






    // Método para OBTENER SOLICITUD GUIA por AGRUPACION
    public function edit($id_run_folio)
    {
        $guia = guias::findOrFail($id_run_folio);
        return response()->json($guia);
    }
    //Metodo EDITAR GUIAS (POR UNA Y UNA)
    public function editGuias($run_folio)
    {
        $guias = Guias::where('run_folio', $run_folio)
            ->with('empresa') // Suponiendo que `razon_social` está en la tabla `empresas`
            ->get();
        return response()->json($guias);
    }

// Método para ACTUALIZAR una guía existente
/*public function update(Request $request, $id)
{
    //Buscar la guía para obtener el run_folio
    $guia = guias::findOrFail($id);

    // Actualizar todas las guías con el mismo run_folio
    guias::where('run_folio', $guia->run_folio)->update([
        'id_empresa' => $request->input('empresa'),
        'numero_guias' => $request->input('numero_guias'),
        'id_predio' => $request->input('predios'),
        'id_plantacion' => $request->input('plantacion'),
        'num_anterior' => $request->input('anterior'),
        'num_comercializadas' => $request->input('comercializadas'),
        'mermas_plantas' => $request->input('mermas'),
        'numero_plantas' => $request->input('plantas'),
        'edad' => $request->input('edad'),
        'art' => $request->input('art'),
        'kg_maguey' => $request->input('kg_maguey'),
        'no_lote_pedido' => $request->input('no_lote_pedido'),
        'fecha_corte' => $request->input('fecha_corte'),
        'observaciones' => $request->input('observaciones'),
        'nombre_cliente' => $request->input('nombre_cliente'),
        'no_cliente' => $request->input('no_cliente'),
        'fecha_ingreso' => $request->input('fecha_ingreso'),
        'domicilio' => $request->input('domicilio'),
    ]);

    // Manejo de documentos (solo para el id_guia original o para todos si es necesario)
    /*$empresa = empresa::with("empresaNumClientes")
        ->where("id_empresa", $request->empresa)
        ->first();
    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

    foreach ($request->id_documento as $index => $id_documento) {
        if ($request->hasFile('url') && isset($request->file('url')[$index])) {
            $file = $request->file('url')[$index];
            $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

            $documentacion_url = new Documentacion_url();
            $documentacion_url->id_relacion = $guia->id_guia; // o el id que corresponda
            $documentacion_url->id_documento = $id_documento;
            $documentacion_url->nombre_documento = $request->nombre_documento[$index];
            $documentacion_url->url = $filename;
            $documentacion_url->id_empresa = $request->empresa;
            $documentacion_url->save();
        }
    }*

    return response()->json(['success' => 'Guías actualizadas correctamente']);
}*/
public function update(Request $request, $id)
{
    $guia = Guias::findOrFail($id);
    $runFolio = $guia->run_folio;

    // Restaurar plantas en la plantacion anterior
    $plantacionAnterior = predio_plantacion::find($guia->id_plantacion);
    if ($plantacionAnterior) {
        //$plantacionAnterior->num_plantas += $guia->num_anterior;
        $plantacionAnterior->num_plantas = $guia->num_anterior;
        $plantacionAnterior->save();
    }

    // Actualizar datos de la guía
    Guias::where('run_folio', $runFolio)->update([
        'id_empresa' => $request->empresa,
        'numero_guias' => $request->numero_guias,
        'id_predio' => $request->predios,
        'id_plantacion' => $request->plantacion,
        'num_anterior' => $request->anterior,
        'num_comercializadas' => $request->comercializadas,
        'mermas_plantas' => $request->mermas,
        'numero_plantas' => $request->plantas,
        'edad' => $request->edad,
        'art' => $request->art,
        'kg_maguey' => $request->kg_maguey,
        'no_lote_pedido' => $request->no_lote_pedido,
        'fecha_corte' => $request->fecha_corte,
        'observaciones' => $request->observaciones,
        'nombre_cliente' => $request->nombre_cliente,
        'no_cliente' => $request->no_cliente,
        'fecha_ingreso' => $request->fecha_ingreso,
        'domicilio' => $request->domicilio,
    ]);

    // Descontar plantas en la nueva plantación (restar num_anterior)
    $plantacionNueva = predio_plantacion::find($request->plantacion);
    if ($plantacionNueva) {
        //$plantacionNueva->num_plantas = max(0, $plantacionNueva->num_plantas - $request->plantas);
        $plantacionNueva->num_plantas = $request->plantas;
        $plantacionNueva->save();
    }

    return response()->json(['success' => 'Guías actualizadas correctamente']);
}









///PDF GUIA
public function guiasTranslado($id_guia)
{
    $res = DB::select('SELECT f.numero_cliente, p.nombre_productor, a.razon_social, p.nombre_predio, p.num_predio, a.razon_social, t.nombre, t.cientifico, s.num_plantas, s.anio_plantacion, e.id_guia, e.folio, e.id_empresa, e.numero_plantas, e.num_anterior, e.num_comercializadas, e.mermas_plantas,
        e.art,e.kg_maguey,e.no_lote_pedido,e.fecha_corte, e.edad, e.nombre_cliente,e.no_cliente,e.fecha_ingreso,e.domicilio, e.id_registro
        FROM guias e 
        JOIN predios p ON (e.id_predio = p.id_predio) 
        JOIN predio_plantacion s ON (e.id_plantacion = s.id_plantacion) 
        JOIN catalogo_tipo_agave t ON (t.id_tipo = s.id_tipo) 
        JOIN empresa a ON (a.id_empresa = e.id_empresa) 
        JOIN empresa_num_cliente f ON (f.id_empresa = e.id_empresa) 
        WHERE e.id_guia=' . $id_guia);

    
    $id_empresa = $res[0]->id_empresa ?? null;
    $data = empresa::find($id_empresa);//Obtener datos
    $numero_cliente = $data && $data->empresaNumClientes->isNotEmpty()
    ? $data->empresaNumClientes->first(fn($item) => $item->empresa_id === $data
    ->id && !empty($item->numero_cliente)) ?->numero_cliente ?? 'No encontrado' : 'N/A';

    //CODIGO QR
    $url = route('QR-guias', ['id' => $id_guia]);
    $qrCode = new QrCode(
        data: $url,
        encoding: new Encoding('UTF-8'),
        errorCorrectionLevel: ErrorCorrectionLevel::Low,
        size: 100,
        margin: 10,
        roundBlockSizeMode: RoundBlockSizeMode::Margin,
        foregroundColor: new Color(0, 0, 0),
        backgroundColor: new Color(255, 255, 255)
    );
    // Escribir el QR en formato PNG
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    // Convertirlo a Base64
    $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($result->getString());

    //dd($res[0]);
    $id_registro = $res[0]->id_registro;

    $pdf = Pdf::loadView('pdfs.GuiaDeTranslado', [
        'datos' => $res,
        'razon_social' => $data->razon_social ?? '',
        'numero_cliente' => $numero_cliente ?? '',
        'id_registro' => $id_registro,
        'qrCodeBase64' => $qrCodeBase64,
    ]);
    return $pdf->stream('Guia_de_traslado_de_maguey_o_agave.pdf');
}





}
