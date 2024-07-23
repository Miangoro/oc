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


class LotesGranelController extends Controller
{
    public function UserManagement(Request $request)
    {
        $empresas = Empresa::all();
        $categorias = categorias::all();
        $clases = clases::all();
        $tipos = Tipo::all(); // Obtén todos los tipos de agave
        $lotes = LotesGranel::with('empresa', 'categoria', 'clase', 'tipo', 'organismo')->get();
        
        return view('catalogo.lotes_granel', compact('lotes', 'empresas', 'categorias', 'clases', 'tipos'));
    }
    
    public function index(Request $request)
    {
        try {
            $columns = [
                1 => 'id_lote_granel',
                2 => 'razon_social',
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
                    'id_guia' => $lote->id_guia,
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


public function destroy($id)
{
    try {
        $lote = LotesGranel::findOrFail($id);
        $lote->delete();
        return response()->json(['success' => true, 'message' => '¡El lote ha sido eliminado exitosamente!']);
    } catch (\Exception $e) {
        \Log::error('Error al eliminar el lote: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Hubo un problema al eliminar el lote.'], 500);
    }
}


}