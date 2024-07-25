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
                    'ingredientes' => $lote->ingredientes,
                    'edad' => $lote->edad,
                    'id_guia' => $lote->guias->Folio ?? 'NA',
                    'folio_certificado' => $lote->folio_certificado,
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

            return response()->json(['success' => 'Lote eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el lote'], 500);
        }
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_empresa' => 'required|exists:empresa,id_empresa',
            'nombre_lote' => 'required|string|max:255',
            'tipo_lote' => 'required|string',
            // Agrega más validaciones según tus necesidades
        ]);
        // Crear una nueva instancia del modelo LotesGranel
        $lote = new LotesGranel();
    
        // Asignar los valores del formulario a las propiedades del modelo
        $lote->id_empresa = $request->input('id_empresa'); // Aquí se usa el ID de la empresa
        $lote->nombre_lote = $request->input('nombre_lote');
        $lote->tipo_lote = $request->input('tipo_lote');
        // Asignar más propiedades según los campos del formulario
    
        // Guardar el nuevo lote en la base de datos
        $lote->save();
    
        // Retornar una respuesta
        return response()->json([
            'success' => true,
            'message' => 'Lote registrado exitosamente',
        ]);
    }
    


}