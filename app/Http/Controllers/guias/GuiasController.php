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
    2 => 'razon_social',
    3 => 'folio',
    4 => 'run_folio',
    5 => 'nombre_predio',
    6 => 'numero_guias',
    7 => 'numero_plantas',
    8 => 'num_anterior',
    9 => 'num_comercializadas',
    10 => 'mermas_plantas',
];

$limit = $request->input('length');
$start = $request->input('start');
$orderColumnIndex = $request->input('order.0.column');
$order = $columns[$orderColumnIndex] ?? 'id_guia';
$dir = $request->input('order.0.dir');
$searchValue = $request->input('search.value');

// Base query (sin groupBy) para contar total
$queryBase = Guias::with(['empresa.empresaNumClientes', 'predios']);
if ($empresaId) {
    $queryBase->where('id_empresa', $empresaId);
}

$totalData = $queryBase->count(); // Total sin filtros

// Query con groupBy (para traer registros únicos por run_folio)
$query = Guias::with(['empresa.empresaNumClientes', 'predios'])
    ->select('guias.*') // importante para no romper con groupBy
    ->groupBy('run_folio');

if ($empresaId) {
    $query->where('id_empresa', $empresaId);
}

// Si hay búsqueda
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

    // 👀 Ojo: aquí contamos sobre un clon de la query (sin paginación)
    $totalFiltered = $query->get()->count();
} else {
    $totalFiltered = $totalData;
}

// Aplicar orden y paginación
$guias = $query->orderBy($order, $dir)
    ->offset($start)
    ->limit($limit)
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
        // Buscar documentos con ID 71(guía) o 132(resultados ART)
        $documentos = Documentacion_url::where('id_relacion', $guia->id_guia)
            ->whereIn('id_documento', [71, 132])
            ->get();

        foreach ($documentos as $doc) {
            //Busca el archivo fisico
            $numeroCliente = $guia->empresa->empresaNumClientes->first()?->numero_cliente;
            $rutaArchivo = 'uploads/' . $numeroCliente . '/guias/' . $doc->url;
            // Eliminar archivo físico si existe
            if ($doc->url && Storage::disk('public')->exists($rutaArchivo)) {
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


        /*'nombre_cliente' => 'nullable|string|max:255',
        'no_cliente' => 'nullable|string|regex:/^[A-Za-z0-9\-]+$/',
        'fecha_ingreso' => 'nullable|date',
        'domicilio' => 'nullable|string|max:255',
        //documentos
        'url.*' => 'nullable|file|max:10240',
        'id_documento.*' => 'nullable|integer',
        'nombre_documento.*' => 'nullable|string|max:255',*/
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


    /*$empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->empresa)->first();
    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();*/

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
        /*$guia->nombre_cliente = $request->input('nombre_cliente');
        $guia->no_cliente = $request->input('no_cliente');
        $guia->fecha_ingreso = $request->input('fecha_ingreso');
        $guia->domicilio = $request->input('domicilio');*/

        $guia->id_registro = $userId;//guardar quien solicita
        $guia->save();

        // Guardar documentos
        /*if ($request->hasFile('url')) {
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
        }*/
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
    $diferencia = $guia->num_anterior - $request->anterior;

    // Restaurar plantas en la plantacion anterior
    $plantacionAnterior = predio_plantacion::find($guia->id_plantacion);
    if ($plantacionAnterior) {

        $plantacionAnterior->num_plantas += $diferencia; 
        // Aquí sumas la diferencia, puede ser positivo o negativo, así ajustas el inventario
        if ($plantacionAnterior->num_plantas < 0) {
            $plantacionAnterior->num_plantas = 0; // no puede quedar negativo
        }
        //$plantacionAnterior->num_plantas += $guia->num_anterior;
        //$plantacionAnterior->num_plantas = $guia->num_anterior;
        $plantacionAnterior->save();
    }

    // Actualizar datos de la guía
    Guias::where('run_folio', $runFolio)->update([
        //'id_empresa' => $request->empresa,
        //'numero_guias' => $request->numero_guias,
        //'id_predio' => $request->predios,
        //'id_plantacion' => $request->plantacion,
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

        // Si cambió la plantación, hay que mover las plantas del inventario también
        /*if ($request->plantacion != $guia->id_plantacion) {
            // Devolver plantas a la plantación vieja (porque se cambia de plantación)
            $plantacionVieja = predio_plantacion::find($guia->id_plantacion);
            if ($plantacionVieja) {
                $plantacionVieja->num_plantas += $guia->num_anterior;
                $plantacionVieja->save();
            }

            // Descontar plantas de la nueva plantación
            $plantacionNueva = predio_plantacion::find($request->plantacion);
            if ($plantacionNueva) {
                $plantacionNueva->num_plantas -= $request->anterior;
                if ($plantacionNueva->num_plantas < 0) $plantacionNueva->num_plantas = 0;
                $plantacionNueva->save();
            }
        }else{
            $plantacionNueva = predio_plantacion::find($request->plantacion);
            if ($plantacionNueva) {
                //$plantacionNueva->num_plantas = max(0, $plantacionNueva->num_plantas - $request->plantas);
                $plantacionNueva->num_plantas = $request->plantas;
                $plantacionNueva->save();
            }
        }*/
    // Descontar plantas en la plantación
    $plantacionNueva = predio_plantacion::find($guia->id_plantacion);
    if ($plantacionNueva) {
        $plantacionNueva->num_plantas = $request->plantas;
        $plantacionNueva->save();
    }


    return response()->json(['success' => 'Guías actualizadas correctamente']);
}





///SUBIR DOCUMENTOS GUIA Y ART
public function subirDocGuias(Request $request)
{
    $request->validate([
        'id_guia' => 'required|exists:guias,id_guia',
        'documento.*' => 'nullable|mimes:pdf|max:3072',
    ]);

    $guia = Guias::findOrFail($request->id_guia);

    $guia_folio = preg_replace('/[^A-Za-z0-9_\-]/', '_', $guia->folio ?? 'No_encontrado');

    $empresa = empresa::with("empresaNumClientes")
        ->where("id_empresa", $guia->id_empresa)
        ->first();
    $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')
        ->first(function ($numero) {
            return !empty($numero);
        });

    $rutaCarpeta = "public/uploads/{$numeroCliente}/guias";

    // Recorremos los archivos enviados
    foreach ($request->documento as $id_documento => $archivo) {
        if ($archivo) {
            // Generar nombre único
            $nombreArchivo = $guia_folio . '_' . uniqid() . '.pdf';

            // Guardar archivo nuevo
            $upload = Storage::putFileAs($rutaCarpeta, $archivo, $nombreArchivo);

            if ($upload) {
                // Buscar si hay documento previo
                $docAnterior = Documentacion_url::where('id_documento', $id_documento)
                    ->where('id_relacion', $guia->id_guia)
                    ->first();

                // Solo eliminar si existe y ya guardamos el nuevo
                if ($docAnterior && Storage::exists($rutaCarpeta . '/' . $docAnterior->url)) {
                    Storage::delete($rutaCarpeta . '/' . $docAnterior->url);
                }

                // Crear o actualizar registro
                Documentacion_url::updateOrCreate(
                    [
                        'id_documento' => $id_documento,
                        'id_relacion' => $guia->id_guia,
                    ],
                    [
                        'nombre_documento' => $id_documento == 71
                            ? "Guía de traslado de agave"
                            : "Resultados ART",
                        'url' => $nombreArchivo,
                        'id_empresa' => $guia->id_empresa,
                    ]
                );
            }
        }
    }


    return response()->json(['message' => 'Documento actualizado correctamente.']);
}
///OBTENER DOCUMENTOS GUIA Y ART
public function mostrarDocGuias($id, $id_documento)
{
    $guia = Guias::findOrFail($id);

    // Buscar documento según tipo
    $documentacion = Documentacion_url::where('id_documento', $id_documento)
        ->where('id_relacion', $guia->id_guia)
        ->first();

    $empresa = empresa::with("empresaNumClientes")
        ->where("id_empresa", $guia->id_empresa)
        ->first();

    $numeroCliente = $empresa->empresaNumClientes
        ->pluck('numero_cliente')
        ->first(function ($numero) {
            return !empty($numero);
        });

    if ($documentacion) {
        $rutaArchivo = "{$numeroCliente}/guias/{$documentacion->url}";

        if (Storage::exists("public/uploads/{$rutaArchivo}")) {
            return response()->json([
                'documento_url' => asset("files/{$rutaArchivo}"),
                'nombre_archivo' => basename($documentacion->url),
            ]);
        } else {
            return response()->json([
                'documento_url' => null,
                'nombre_archivo' => null,
            ], 404);
        }
    }

    return response()->json([
        'documento_url' => null,
        'nombre_archivo' => null,
    ]);
}
///BORRAR DOCUMENTOS GUIA Y ART
public function borrarDocGuias($id, $id_documento)
{
    $guia = Guias::findOrFail($id);

    $documentacion = Documentacion_url::where('id_documento', $id_documento)
        ->where('id_relacion', $guia->id_guia)
        ->first();

    if (!$documentacion) {
        return response()->json(['message' => 'Documento no encontrado.'], 404);
    }

    $empresa = empresa::with("empresaNumClientes")
        ->where("id_empresa", $guia->id_empresa)
        ->first();

    $numeroCliente = $empresa->empresaNumClientes
        ->pluck('numero_cliente')
        ->first(function ($numero) {
            return !empty($numero);
        });

    $rutaArchivo = "public/uploads/{$numeroCliente}/guias/{$documentacion->url}";

    // Eliminar archivo físico
    if (Storage::exists($rutaArchivo)) {
        Storage::delete($rutaArchivo);
    }

    // Eliminar registro en la base de datos
    $documentacion->delete();

    return response()->json(['message' => 'Documento eliminado correctamente.']);
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
        'razon_social' => $data->razon_social ?? 'No encontrado',
        'numero_cliente' => $numero_cliente ?? 'No encontrado',
        'id_registro' => $id_registro,
        'qrCodeBase64' => $qrCodeBase64,
    ]);
    return $pdf->stream('Guia_de_traslado_de_maguey_o_agave.pdf');
}





}
