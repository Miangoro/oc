<?php

namespace App\Http\Controllers\catalogo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LotesGranel;
use App\Models\empresa;
use App\Models\categorias;
use App\Models\clases;
use App\Models\Tipo;
use App\Models\Organismo;
use App\Models\guias;


class LotesGranelController extends Controller
{
    public function UserManagement(Request $request)
    {
        $empresas = Empresa::all();
        $categorias = Categorias::all();
        $clases = Clases::all();
        $tipos = Tipo::all(); // Obtén todos los tipos de agave
        $organismos = Organismo::all(); // Obtén todos los organismos
        $guias = Guias::all(); // Obtén todas las guías
        $lotes = LotesGranel::with('empresa', 'categoria', 'clase', 'tipo', 'organismo', 'guias')->get();
        
        return view('catalogo.lotes_granel', compact('lotes', 'empresas', 'categorias', 'clases', 'tipos', 'organismos', 'guias'));
    }
    
    
    
    public function index(Request $request)
    {
        try {
            $columns = [
                1 => 'id_lote_granel',
                2 => 'razon_social',
                3 => 'nombre_lote',
                4 => 'tipo_lote',
                5 => 'folio_fq',
                6 => 'volumen',
                7 => 'cont_alc',
                8 => 'id_categoria',
                9 => 'id_clase',
                10 => 'id_tipo',
                11 => 'ingredientes',
                12 => 'edad',
                13 => 'id_guia',
                14 => 'folio_certificado',
                15 => 'id_organismo',
                16 => 'fecha_emision',
                17 => 'fecha_vigencia',
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
                    'id_empresa' => $lote->empresa->razon_social ?? '',
                    'nombre_lote' => $lote->nombre_lote,
                    'tipo_lote' => $lote->tipo_lote,
                    'folio_fq' => $lote->folio_fq,
                    'volumen' => $lote->volumen,
                    'cont_alc' => $lote->cont_alc,
                    'id_categoria' => $lote->categoria->categoria ?? '',
                    'id_clase' => $lote->clase->clase ?? '',
                    'id_tipo' => $lote->Tipo->nombre,
                    'ingredientes' => $lote->ingredientes,
                    'edad' => $lote->edad,
                    'id_guia' => $lote->guias->Folio,
                    'folio_certificado' => $lote->folio_certificado,
                    'id_organismo' => $lote->Organismo->organismo ?? '',
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
            // Log the error message
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
    $columns = ['id_lote', 'num_clientes', 'nombre_cliente', 'tipo', 'no_lote', 'categoria', 'clase', 'no_analisis', 'tipo_maguey', 'volumen_lote', 'contenido_alcoholico'];

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
        return response()->json([
            'success' => true,
            'message' => 'Lote eliminado con éxito.',
        ]);
    } catch (\Exception $e) {
        \Log::error('Error al eliminar lote: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al eliminar el lote.',
        ]);
    }
}





public function store(Request $request)
{
    $request->validate([
        'nombre_lote' => 'required|string|max:255',
        'id_empresa' => 'required|exists:empresas,id',
        'tipo_lote' => 'required|string|in:oc_cidam,otro_organismo',
        'no_analisis' => 'nullable|string|max:255',
        'analisis_fisicoquimico' => 'nullable|file|mimes:pdf',
        'volumen_lote' => 'nullable|numeric',
        'contenido_alcoholico' => 'nullable|numeric',
        'id_categoria' => 'nullable|exists:catalogo_categorias,id_categoria',
        'id_clase' => 'nullable|exists:catalogo_clases,id_clase',
        'id_tipo' => 'nullable|exists:catalogo_tipo_agave,id_tipo',
        'ingredientes' => 'nullable|string',
        'edad' => 'nullable|string|max:255',
        'id_guia' => 'nullable|exists:guias,id_guia',
        'folio_certificado' => 'nullable|string|max:255',
        'organismo_certificacion' => 'nullable|string|max:255',
        'fecha_emision' => 'nullable|date',
        'fecha_vigencia' => 'nullable|date',
        'certificado_lote' => 'nullable|file|mimes:pdf',
    ]);

    $lote = new Lote();
    $lote->nombre_lote = $request->input('nombre_lote');
    $lote->id_empresa = $request->input('id_empresa');
    $lote->tipo_lote = $request->input('tipo_lote');
    $lote->no_analisis = $request->input('no_analisis');
    $lote->volumen_lote = $request->input('volumen_lote');
    $lote->contenido_alcoholico = $request->input('contenido_alcoholico');
    $lote->id_categoria = $request->input('id_categoria');
    $lote->id_clase = $request->input('id_clase');
    $lote->id_tipo = $request->input('id_tipo');
    $lote->ingredientes = $request->input('ingredientes');
    $lote->edad = $request->input('edad');
    $lote->id_guia = $request->input('id_guia');
    $lote->folio_certificado = $request->input('folio_certificado');
    $lote->organismo_certificacion = $request->input('organismo_certificacion');
    $lote->fecha_emision = $request->input('fecha_emision');
    $lote->fecha_vigencia = $request->input('fecha_vigencia');

    if ($request->hasFile('analisis_fisicoquimico')) {
        $file = $request->file('analisis_fisicoquimico');
        $filename = time() . '_analisis_fisicoquimico.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/analisis'), $filename);
        $lote->analisis_fisicoquimico = $filename;
    }

    if ($request->hasFile('certificado_lote')) {
        $file = $request->file('certificado_lote');
        $filename = time() . '_certificado_lote.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/certificados'), $filename);
        $lote->certificado_lote = $filename;
    }

    $lote->save();

    return redirect()->route('lotes-granel.index')->with('success', 'Lote registrado exitosamente.');
}


}