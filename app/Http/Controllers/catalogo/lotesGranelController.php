<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\empresa; 
use App\Models\categorias; 
use App\Models\clases; 
use App\Models\Documentacion;
use App\Models\Documentacion_url;
use App\Models\tipos;
use App\Models\organismos;
use App\Models\Guias;
use App\Models\LotesGranelGuia;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class LotesGranelController extends Controller
{
    public function UserManagement(Request $request)
    {// Encuentra el lote a granel por ID
        $empresas = empresa::where('tipo', 2)->get();
        $categorias = categorias::all();
        $clases = clases::all();
        $tipos = tipos::all(); // Obtén todos los tipos de agave
        $organismos = organismos::all(); // Obtén todos los organismos, aquí usa 'organismos' en minúscula
        $guias = Guias::all(); // Obtén todas las guías
        $lotes = LotesGranel::with('empresa', 'categoria', 'clase', 'tipo', 'organismo', 'guias')->get();
        $documentos = Documentacion::where('id_documento', '=', '58')->get();
        return view('catalogo.lotes_granel', compact('lotes', 'empresas', 'categorias', 'clases', 'tipos', 'organismos', 'guias', 'documentos'));
    }


    public function index(Request $request)
    {
        try {
            $columns = [
                1 => 'id_lote_granel',
                2 => 'nombre_lote',
                3 => 'tipo_lote',
                4 => 'folio_fq',
                5 => 'volumen',
                6 => 'cont_alc',
                7 => 'id_categoria',
                8 => 'id_clase',
                9 => 'id_tipo',
                10 => 'ingredientes',
                11 => 'edad',
                12 => 'folio_certificado',
                13 => 'id_organismo',
                14 => 'fecha_emision',
                15 => 'fecha_vigencia',
                16 => 'estatus',
            ];

            $search = $request->input('search.value');
            $totalData = LotesGranel::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $LotesGranel = LotesGranel::with(['empresa', 'categoria', 'clase', 'Tipo', 'Organismo'])
                ->when($search, function ($query, $search) {
                    return $query->where('id_lote_granel', 'LIKE', "%{$search}%")
                        ->orWhere('nombre_lote', 'LIKE', "%{$search}%")
                        ->orWhere('folio_fq', 'LIKE', "%{$search}%")
                        ->orWhere('volumen', 'LIKE', "%{$search}%")
                        ->orWhere('cont_alc', 'LIKE', "%{$search}%")
                        ->orWhere('ingredientes', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = LotesGranel::when($search, function ($query, $search) {
                return $query->where('id_lote_granel', 'LIKE', "%{$search}%")
                    ->orWhere('nombre_lote', 'LIKE', "%{$search}%")
                    ->orWhere('folio_fq', 'LIKE', "%{$search}%")
                    ->orWhere('volumen', 'LIKE', "%{$search}%")
                    ->orWhere('cont_alc', 'LIKE', "%{$search}%")
                    ->orWhere('ingredientes', 'LIKE', "%{$search}%");
            })->count();

            $data = [];
            if (!empty($LotesGranel)) {
                $ids = $start;
        
                foreach ($LotesGranel as $lote) {
                    $nestedData['id_lote_granel'] = $lote->id_lote_granel ?? 'N/A';
                    $nestedData['fake_id'] = ++$ids ?? 'N/A'; // Incremental ID
                    $nestedData['id_empresa'] = $lote->empresa->razon_social ?? 'N/A';
                    $nestedData['nombre_lote'] = $lote->nombre_lote ?? 'N/A';
                    $nestedData['tipo_lote'] = $lote->tipo_lote ?? 'N/A';
                    $nestedData['folio_fq'] = $lote->folio_fq ?? 'N/A';
                    $nestedData['volumen'] = $lote->volumen ?? 'N/A';
                    $nestedData['volumen_restante'] = $lote->volumen_restante ?? 'N/A';
                    $nestedData['cont_alc'] = $lote->cont_alc ?? 'N/A';
                    $nestedData['id_categoria'] = $lote->categoria->categoria ?? 'N/A';
                    $nestedData['id_clase'] = $lote->clase->clase ?? 'N/A';
                    $nestedData['id_tipo'] = $lote->tipo->nombre ?? 'N/A';
                    $nestedData['ingredientes'] = $lote->ingredientes ?? 'N/A';
                    $nestedData['edad'] = $lote->edad ?? 'N/A';
                    $nestedData['folio_certificado'] = $lote->folio_certificado ?? 'N/A';
                    $nestedData['id_organismo'] = $lote->organismo->organismo ?? 'N/A';
                    $nestedData['fecha_emision'] = Helpers::formatearFecha($lote->fecha_emision) ?? 'N/A';
                    $nestedData['fecha_vigencia'] = Helpers::formatearFecha($lote->fecha_vigencia) ?? 'N/A';
                    $nestedData['estatus'] = $lote->estatus;
                    $nestedData['actions'] = '<button class="btn btn-danger btn-sm delete-record" data-id="' . $lote->id_lote_granel . '">Eliminar</button>';
        
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

        } catch (\Exception $e) {
            \Log::error('Error en LotesGranelController@index: ' . $e->getMessage());

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Error al procesar la solicitud.'
            ]);
        }
    }




    public function getLotesList(Request $request)
    {
        $columns = ['id_lote', 'num_clientes', 'nombre_cliente', 'tipo', 'no_lote', 'categoria', 'clase', 'no_analisis', 'tipo_maguey', 'volumen', 'cont_alc'];

        $query = Lote::query();

        // Filtrar y ordenar
        if ($request->has('search') && $request->input('search')['value']) {
            $search = $request->input('search')['value'];
            $query->where(function ($q) use ($search, $columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%$search%");
                }
            });
        }

        $totalData = $query->count();
        $totalFiltered = $totalData;

        $query->skip($request->input('start', 0))
            ->take($request->input('length', 10));

        $data = $query->get();

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }




    public function destroy($id_lote_granel)
    {
        try {
            $lote = LotesGranel::findOrFail($id_lote_granel);
            $lote->delete();

            return response()->json(['success' => 'Lote eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el lote'], 500);
        }
    }

    

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'nombre_lote' => 'required|string|max:70',
            'tipo_lote' => 'required|integer',
            'volumen' => 'required|numeric',
            'cont_alc' => 'required|numeric',
            'id_categoria' => 'required|integer|exists:catalogo_categorias,id_categoria',
            'id_clase' => 'required|integer|exists:catalogo_clases,id_clase',
            'id_tipo' => 'required|integer|exists:catalogo_tipo_agave,id_tipo',
            'ingredientes' => 'nullable|string|max:100',
            'edad' => 'nullable|string|max:30',
            'id_guia' => 'required|array',
            'id_guia.*' => 'exists:guias,id_guia',
            'folio_certificado' => 'nullable|string|max:50',
            'id_organismo' => 'nullable|integer|exists:catalogo_organismos,id_organismo',
            'fecha_emision' => 'nullable|date',
            'fecha_vigencia' => 'nullable|date',
            'url.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'folio_fq_completo' => 'nullable|string|max:50',
            'folio_fq_ajuste' => 'nullable|string|max:50',
            'folio_fq' => 'nullable|string|max:50',
            'es_creado_a_partir' => 'required|string',
            'lote_original_id' => 'required_if:es_creado_a_partir,si|integer|exists:lotes_granel,id_lote_granel',

        ]);
    
        // Crear una nueva instancia del modelo LotesGranel
        $lote = new LotesGranel();
        $lote->id_empresa = $validatedData['id_empresa'];
        $lote->nombre_lote = $validatedData['nombre_lote'];
        $lote->tipo_lote = $validatedData['tipo_lote'];
        $lote->volumen = $validatedData['volumen'];
        $lote->volumen_restante = $validatedData['volumen'];
        $lote->cont_alc = $validatedData['cont_alc'];
        $lote->id_categoria = $validatedData['id_categoria'];
        $lote->id_clase = $validatedData['id_clase'];
        $lote->id_tipo = $validatedData['id_tipo'];
        $lote->ingredientes = $validatedData['ingredientes'] ?? null;
        $lote->edad = $validatedData['edad'] ?? null;
        $lote->folio_certificado = $validatedData['folio_certificado'] ?? null;
        $lote->id_organismo = $validatedData['id_organismo'] ?? null;
        $lote->fecha_emision = $validatedData['fecha_emision'] ?? null;
        $lote->fecha_vigencia = $validatedData['fecha_vigencia'] ?? null;
    
        $folio_fq_Completo = $validatedData['folio_fq_completo'] ?? ' ';
        $folio_fq_ajuste = $validatedData['folio_fq_ajuste'] ?? ' ';
        
        // Verificar si ambos campos son espacios o vacíos
        if (trim($folio_fq_Completo) === '' && trim($folio_fq_ajuste) === '') {
            $lote->folio_fq = 'Sin FQ'; // Asignar 'Sin FQ' si ambos están vacíos
        } else {
            // Concatenar los valores si alguno tiene contenido
            if (!empty($folio_fq_ajuste)) {
                $folio_fq_Completo .= ' ' . $folio_fq_ajuste;
            }
            $lote->folio_fq = $folio_fq_Completo;
        }
        
                // Si el lote es creado a partir de otro lote
        if ($validatedData['es_creado_a_partir'] === 'si') {
            $loteOriginal = LotesGranel::find($validatedData['lote_original_id']);
            
            // Verificar si el lote original existe y tiene suficiente volumen
            if (!$loteOriginal || $loteOriginal->volumen < $validatedData['volumen']) {
                return response()->json([
                    'success' => false,
                    'message' => 'El lote original no tiene suficiente volumen',
                ], 400);
            }
            
            // Restar el volumen al lote original
            $loteOriginal->volumen -= $validatedData['volumen'];
            $loteOriginal->save();
            
            // Establecer el lote original en el nuevo lote
            $lote->lote_original_id = $validatedData['lote_original_id'];
        } else {
            $lote->lote_original_id = null;
        }
        // Guardar el nuevo lote en la base de datos
        $lote->save();
    
        // Almacenar las guías en la tabla intermedia usando el modelo LotesGranelGuia
        if (isset($validatedData['id_guia'])) {
            foreach ($validatedData['id_guia'] as $idGuia) {
                LotesGranelGuia::create([
                    'id_lote_granel' => $lote->id_lote_granel,
                    'id_guia' => $idGuia
                ]);
            }
        }
    
        // Obtener el número de cliente
        $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
    
        // Almacenar nuevos documentos solo si se envían
        if ($request->hasFile('url')) {
            foreach ($request->file('url') as $index => $file) {
                $folio_fq = $index == 0 && $request->id_documento[$index] == 58 
                    ? $request->folio_fq_completo 
                    : $request->folio_fq_ajuste;
                $tipo_analisis = $request->tipo_analisis[$index] ?? '';
                
                // Generar un nombre único para el archivo
                $uniqueId = uniqid(); // Genera un identificador único
                $filename = $request->nombre_documento[$index] . '_' . $uniqueId . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public'); // Aquí se guarda en la ruta definida storage/public
        
                $documentacion_url = new Documentacion_url();
                $documentacion_url->id_relacion = $lote->id_lote_granel;
                $documentacion_url->id_documento = $request->id_documento[$index];
                $documentacion_url->nombre_documento = $request->nombre_documento[$index] . ": " . $tipo_analisis . " - " . $folio_fq;
                $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                $documentacion_url->id_empresa = $lote->id_empresa;
        
                $documentacion_url->save();
            }
        }
        // Retornar una respuesta
        return response()->json([
            'success' => true,
            'message' => 'Lote registrado exitosamente',
        ]);

    }
    
    

    
    public function edit($id_lote_granel)
    {
        try {
            // Cargar el lote y las guías asociadas
            $lote = LotesGranel::with('lotesGuias.guia')->findOrFail($id_lote_granel);
    
            // Obtener los documentos asociados
            $documentos = Documentacion_url::where('id_relacion', $id_lote_granel)->get();
    
            // Extraer la URL de los documentos
            $documentosConUrl = $documentos->map(function ($documento) {
                return [
                    'id_documento' => $documento->id_documento,
                    'nombre' => $documento->nombre_documento,
                    'url' => $documento->url,
                    'tipo' => $documento->nombre_documento
                ];
            });
    
            $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
    
             // Obtener las guías asociadas con su ID y folio
            $guias = $lote->lotesGuias->map(function ($loteGuia) {
                return [
                    'id' => $loteGuia->guia->id_guia,
                    'folio' => $loteGuia->guia->folio,
                ];
            });

            // Obtener la URL del archivo para "otro organismo"
            $archivoUrlOtroOrganismo = $lote->tipo_lote == '2' ? $lote->url_certificado : '';
    
            return response()->json([
                'success' => true,
                'lote' => $lote,
                'guias' => $guias, // Devuelve tanto los IDs como los folios
                'documentos' => $documentosConUrl,
                'numeroCliente' => $numeroCliente,
                'archivo_url_otro_organismo' => $archivoUrlOtroOrganismo
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false], 404);
        }
    }
    
    public function update(Request $request, $id_lote_granel)
    {
        try {
            Log::info('Datos recibidos:', $request->all());
    
            // Validar los datos del formulario
            $validated = $request->validate([
                'nombre_lote' => 'required|string|max:255',
                'id_empresa' => 'required|integer|exists:empresa,id_empresa',
                'tipo_lote' => 'required|integer',
                'id_guia' => 'nullable|array',
                'id_guia.*' => 'integer|exists:guias,id_guia',
                'volumen' => 'required|numeric',
                'cont_alc' => 'required|numeric',
                'id_categoria' => 'required|integer|exists:catalogo_categorias,id_categoria',
                'id_clase' => 'required|integer|exists:catalogo_clases,id_clase',
                'id_tipo' => 'required|integer|exists:catalogo_tipo_agave,id_tipo',
                'ingredientes' => 'nullable|string',
                'edad' => 'nullable|string',
                'folio_certificado' => 'nullable|string',
                'id_organismo' => 'nullable|integer|exists:catalogo_organismos,id_organismo',
                'fecha_emision' => 'nullable|date',
                'fecha_vigencia' => 'nullable|date',
                'url.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'folio_fq_completo' => 'nullable|string|max:50',
                'folio_fq_ajuste' => 'nullable|string|max:50',
                'folio_fq' => 'nullable|string|max:50'
            ]);
    
            $lote = LotesGranel::findOrFail($id_lote_granel);
    
            // Actualizar lote
            $lote->update([
                'id_empresa' => $validated['id_empresa'],
                'nombre_lote' => $validated['nombre_lote'],
                'tipo_lote' => $validated['tipo_lote'],
                'volumen' => $validated['volumen'],
                'cont_alc' => $validated['cont_alc'],
                'id_categoria' => $validated['id_categoria'],
                'id_clase' => $validated['id_clase'],
                'id_tipo' => $validated['id_tipo'],
                'ingredientes' => $validated['ingredientes'],
                'edad' => $validated['edad'],
                'folio_certificado' => $validated['folio_certificado'],
                'id_organismo' => $validated['id_organismo'] ?? null,
                'fecha_emision' => $validated['fecha_emision'],
                'fecha_vigencia' => $validated['fecha_vigencia'],
            ]);
    
            // Obtener el número de cliente
            $empresa = Empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
    
            // Eliminar archivos antiguos
            $documentacionUrls = Documentacion_url::where('id_relacion', $id_lote_granel)->get();
            foreach ($documentacionUrls as $documentacionUrl) {
                $filePath = 'uploads/' . $numeroCliente . '/' . $documentacionUrl->url;
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $documentacionUrl->delete();
            }
    
            // Almacenar nuevos documentos solo si se envían
            if ($request->hasFile('url')) {
                foreach ($request->file('url') as $index => $file) {
                    $folio_fq = $index == 0 && $request->id_documento[$index] == 58 
                        ? $request->folio_fq_completo 
                        : $request->folio_fq_ajuste;
    
                    $tipo_analisis = $request->tipo_analisis[$index] ?? '';
                    
                    // Generar un nombre único para el archivo
                    $uniqueId = uniqid(); // Genera un identificador único
                    $filename = $request->nombre_documento[$index] . '_' . $uniqueId . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public'); // Aquí se guarda en la ruta definida storage/public
                    
                    Log::info('Archivo guardado:', ['path' => $filePath, 'filename' => $filename]);
    
                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $lote->id_lote_granel;
                    $documentacion_url->id_documento = $request->id_documento[$index];
                    $documentacion_url->nombre_documento = $request->nombre_documento[$index] . ": " . $tipo_analisis . " - " . $folio_fq;
                    $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                    $documentacion_url->id_empresa = $lote->id_empresa;
    
                    $documentacion_url->save();
                }
            }
    
            // Actualizar el campo folio_fq
            $folio_fq_Completo = substr($validated['folio_fq_completo'] ?? '', 0, 50);
            $folio_fq_ajuste = substr($validated['folio_fq_ajuste'] ?? '', 0, 50);
    
            if (trim($folio_fq_Completo) === '' && trim($folio_fq_ajuste) === '') {
                $lote->folio_fq = 'Sin FQ'; // Asignar 'Sin FQ' si ambos están vacíos
            } else {
                // Concatenar los valores si alguno tiene contenido
                if (!empty($folio_fq_ajuste)) {
                    $folio_fq_Completo .= ' ' . $folio_fq_ajuste;
                }
                $lote->folio_fq = substr($folio_fq_Completo, 0, 50); // Limitar a 50 caracteres
            }
    
            $lote->save();
    
            // Almacenar las guías en la tabla intermedia usando el modelo LotesGranelGuia
            LotesGranelGuia::where('id_lote_granel', $id_lote_granel)->delete();
            if (isset($validated['id_guia'])) {
                foreach ($validated['id_guia'] as $idGuia) {
                    LotesGranelGuia::create([
                        'id_lote_granel' => $lote->id_lote_granel,
                        'id_guia' => $idGuia
                    ]);
                }
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Lote actualizado exitosamente',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar el lote:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el lote: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    
    

}