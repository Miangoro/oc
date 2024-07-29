<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\Empresa; // Corregido de 'empresa' a 'Empresa'
use App\Models\Categorias; // Corregido de 'categorias' a 'Categorias'
use App\Models\Clases; // Corregido de 'clases' a 'Clases'
use App\Models\Documentacion;
use App\Models\Documentacion_url;
use App\Models\Tipos;
use App\Models\Organismo;
use App\Models\Guias;


class LotesGranelController extends Controller
{
    public function UserManagement(Request $request)
    {
        $empresas = Empresa::where('tipo', 2)->get();
        $categorias = Categorias::all();
        $clases = Clases::all();
        $tipos = Tipos::all(); // Obtén todos los tipos de agave
        $organismos = Organismo::all(); // Obtén todos los organismos
        $guias = Guias::all(); // Obtén todas las guías
        $lotes = LotesGranel::with('empresa', 'categoria', 'clase', 'tipo', 'organismo', 'guias')->get();
        $documentos = Documentacion::where('id_documento', '=', '58')
            ->get();

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
                12 => 'id_guia',
                13 => 'folio_certificado',
                14 => 'id_organismo',
                15 => 'fecha_emision',
                16 => 'fecha_vigencia',
            ];

            $search = $request->input('search.value');
            $totalData = LotesGranel::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $LotesGranel = LotesGranel::with(['empresa', 'categoria', 'clase', 'Tipo', 'Organismo', 'guias'])
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

            foreach ($LotesGranel as $lote) {
                $data[] = [
                    'id_lote_granel' => $lote->id_lote_granel,
                    'fake_id' => $start + 1, // Incremental ID
                    'id_empresa' => $lote->empresa->razon_social ?? 'NA',
                    'nombre_lote' => $lote->nombre_lote,
                    'tipo_lote' => $lote->tipo_lote,
                    'folio_fq' => $lote->folio_fq,
                    'volumen' => $lote->volumen,
                    'cont_alc' => $lote->cont_alc,
                    'id_categoria' => $lote->categoria->categoria ?? 'NA',
                    'id_clase' => $lote->clase->clase ?? 'NA',
                    'id_tipo' => $lote->tipo->nombre ?? 'NA',
                    'ingredientes' => $lote->ingredientes ?? 'NA',
                    'edad' => $lote->edad ?? 'NA',
                    'id_guia' => $lote->guias->Folio ?? 'NA',
                    'folio_certificado' => $lote->folio_certificado ?? 'NA',
                    'id_organismo' => $lote->organismo->organismo ?? 'NA',
                    'fecha_emision' => $lote->fecha_emision,
                    'fecha_vigencia' => $lote->fecha_vigencia,
                    'actions' => '<button class="btn btn-danger btn-sm delete-record" data-id="' . $lote->id_lote_granel . '">Eliminar</button>',
                ];
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


        // Validar los datos del formulario
        $validatedData = $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'nombre_lote' => 'required|string|max:70',
            'tipo_lote' => 'required|integer',
            'volumen' => 'nullable|numeric',
            'cont_alc' => 'nullable|numeric',
            'id_categoria' => 'nullable|integer|exists:catalogo_categorias,id_categoria',
            'id_clase' => 'nullable|integer|exists:catalogo_clases,id_clase',
            'id_tipo' => 'nullable|integer|exists:catalogo_tipo_agave,id_tipo',
            'ingredientes' => 'nullable|string|max:100',
            'edad' => 'nullable|string|max:30',
            'id_guia' => 'nullable|integer',
            'folio_certificado' => 'nullable|string|max:50',
            'id_organismo' => 'nullable|integer|exists:catalogo_organismos,id_organismo',
            'fecha_emision' => 'nullable|date',
            'fecha_vigencia' => 'nullable|date',
            'folio_fq_completo' => 'nullable|string|max:50',
            'folio_fq_ajuste' => 'nullable|string|max:50',
            'folio_fq' => 'nullable|string|max:50'
        ]);
    
        // Crear una nueva instancia del modelo LotesGranel
        $lote = new LotesGranel();
    
        // Asignar los valores del formulario a las propiedades del modelo
        $lote->id_empresa = $validatedData['id_empresa'];
        $lote->nombre_lote = $validatedData['nombre_lote'];
        $lote->tipo_lote = $validatedData['tipo_lote'];
        $lote->volumen = $validatedData['volumen'] ?? null;
        $lote->cont_alc = $validatedData['cont_alc'] ?? null;
        $lote->id_categoria = $validatedData['id_categoria'] ?? null;
        $lote->id_clase = $validatedData['id_clase'] ?? null;
        $lote->id_tipo = $validatedData['id_tipo'] ?? null;
        $lote->ingredientes = $validatedData['ingredientes'] ?? null;
        $lote->edad = $validatedData['edad'] ?? null;
        $lote->id_guia = $validatedData['id_guia'] ?? 0;
        $lote->folio_certificado = $validatedData['folio_certificado'] ?? null;
        $lote->id_organismo = $validatedData['id_organismo'] ?? 0;
        $lote->fecha_emision = $validatedData['fecha_emision'] ?? null;
        $lote->fecha_vigencia = $validatedData['fecha_vigencia'] ?? null;
    
        // Determinar cuál folio_fq usar
        if ($validatedData['tipo_lote'] == 1) {
            // "Certificación por OC CIDAM"
            $lote->folio_fq = $validatedData['folio_fq_completo'] ?? null;
        } elseif ($validatedData['tipo_lote'] == 2) {
            // "Certificado por otro organismo"
            $lote->folio_fq = $validatedData['folio_fq_ajuste'] ?? $validatedData['folio_certificado'] ?? null;
        } else {
            $lote->folio_fq = null;
        }
    
        // Guardar el nuevo lote en la base de datos
        $lote->save();
    
        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $lote->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();


        // Almacenar nuevos documentos solo si se envían
        if ($request->hasFile('url')) {
            foreach ($request->file('url') as $index => $file) {
                $folio_fq = $index == 0 && $request->id_documento[$index] == 58 
                    ? $request->folio_fq_completo 
                    : $request->folio_fq_ajuste ?? '';
    
                $tipo_analisis = $request->tipo_analisis[$index] ?? '';
                


                $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public'); // Aqui se guarda en la ruta definida storage/public
    
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
    /* funcion para llenar modal */
    public function edit($id_lote_granel)
{
    try {
        $lote = LotesGranel::findOrFail($id_lote_granel);
        return response()->json(['success' => true, 'lote' => $lote]);
    } catch (ModelNotFoundException $e) {
        return response()->json(['success' => false], 404);
    }
}


    
    
}
