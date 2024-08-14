<?php

namespace App\Http\Controllers\guias;

use App\Helpers\Helpers;
use App\Models\guias;
use App\Models\empresa;
use App\Models\Predios;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class GuiasController  extends Controller
{
    public function UserManagement()
    {

        $guias = guias::all();
        $empresa = Empresa::where('tipo', 2)->get(); // Esto depende de cómo tengas configurado tu modelo Empresa
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
        $columns = [
            1 => 'id_guia',
            2 => 'id_plantacion',
            3 => 'folio',
            4 => 'id_empresa',
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


        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'id_guia';
        $dir = $request->input('order.0.dir');

        $searchValue = $request->input('search.value');

        $query = Guias::with(['empresa', 'predios']);

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('id_guia', 'LIKE', "%{$searchValue}%")
                    ->orWhere('folio', 'LIKE', "%{$searchValue}%")
                    ->orWhere('id_empresa', 'LIKE', "%{$searchValue}%");
            });
        }

        $totalData = guias::count();
        $totalFiltered = $query->count();

        $users = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];

        if ($users->isNotEmpty()) {
            $ids = $start;

            foreach ($users as $user) {
                //$numero_cliente = \App\Models\Empresa::where('id_empresa', $user->id_empresa)->value('razon_social');
                $numero_cliente = \App\Models\EmpresaNumCliente::where('id_empresa', $user->id_empresa)->value('numero_cliente');


                $nestedData = [
                    'id_guia' => $user->id_guia,
                    'id_plantacion' => $user->id_plantacion,
                    'fake_id' => ++$ids,
                    'folio' => $user->folio,
                    'razon_social' => $user->empresa ? $user->empresa->razon_social : '',
                    'id_empresa' => $numero_cliente, // Asignar numero_cliente a id_empresa
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

    //Metodo para eliminar
    public function destroy($id_guia)
    {
        $clase = guias::findOrFail($id_guia);
        $clase->delete();

        return response()->json(['success' => 'Clase eliminada correctamente']);
    }
    
    //Metodo para registrar
    public function store(Request $request)
    {

        $request->validate([
            'empresa' => 'required|exists:empresa,id_empresa',
            'numero_guias' => 'required|numeric',
            'predios' => 'required',
            'plantacion' => 'required',
            'anterior' => 'required|numeric',
            'comercializadas' => 'required|numeric',
            'mermas' => 'required|numeric',
            'plantas' => 'required|numeric',
        ]);

        for ($i = 0; $i < $request->input('numero_guias'); $i++) {

            // Crear una nueva instancia del modelo Guia
            $guia = new guias();
            $guia->id_empresa = $request->input('empresa');
            $guia->numero_guias = $request->input('numero_guias');
            $guia->id_predio = $request->input('predios');
            $guia->id_plantacion = $request->input('plantacion');
            $guia->folio = Helpers::generarFolioGuia($request->predios);
            $guia->num_anterior = $request->input('anterior', 0);
            $guia->num_comercializadas = $request->input('comercializadas', 0);
            $guia->mermas_plantas = $request->input('mermas', 0);
            $guia->numero_plantas = $request->input('plantas', 0);
            $guia->save();
        }
        // Responder con éxito
        return response()->json(['success' => 'Guía registrada correctamente']);
    }




// Método para obtener una guía por ID
public function edit($id_guia)
{
    try {
        $guia = guias::findOrFail($id_guia);
        return response()->json($guia);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener la guía'], 500);
    }
}

// Método para actualizar una guía existente
public function update(Request $request, $id_guia)
{
    

    try {
        $guia = guias::findOrFail($id_guia);
        $guia->id_empresa = $request->input('empresa');
        $guia->numero_guias = $request->input('numero_guias');
        $guia->id_predio = $request->input('predios');
        $guia->id_plantacion = $request->input('plantacion');
        $guia->num_anterior = $request->input('anterior');
        $guia->num_comercializadas = $request->input('comercializadas');
        $guia->mermas_plantas = $request->input('mermas');
        $guia->numero_plantas = $request->input('plantas');
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

        $guia->save();

        return response()->json(['success' => 'Guía actualizada correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al actualizar la guía'], 500);
    }
}

 
      

        //Metodo para llenar el pdf
        public function guiasTranslado($id_guia)
        {   
            $res = DB::select('SELECT f.numero_cliente, p.nombre_productor, a.razon_social, p.nombre_predio, p.num_predio, a.razon_social, t.nombre, t.cientifico, s.num_plantas, s.anio_plantacion, e.id_guia, e.folio, e.id_empresa, e.numero_plantas, e.num_anterior, e.num_comercializadas, e.mermas_plantas,
            e.art,e.kg_maguey,e.no_lote_pedido,e.fecha_corte, e.edad, e.nombre_cliente,e.no_cliente,e.fecha_ingreso,e.domicilio
            FROM guias e 
            JOIN predios p ON (e.id_predio = p.id_predio) 
            JOIN predio_plantacion s ON (e.id_plantacion = s.id_plantacion) 
            JOIN catalogo_tipo_agave t ON (t.id_tipo = s.id_tipo) 
            JOIN empresa a ON (a.id_empresa = e.id_empresa) 
            JOIN empresa_num_cliente f ON (f.id_empresa = e.id_empresa) 
            WHERE e.id_guia=' . $id_guia);
            $pdf = Pdf::loadView('pdfs.GuiaDeTranslado',['datos' =>$res]);
            return $pdf->stream('539G005_Guia_de_traslado_de_maguey_o_agave.pdf');
        }

}
