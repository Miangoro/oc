<?php

namespace App\Http\Controllers\guias;

use App\Models\guias;
use App\Models\empresa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuiasController  extends Controller
{
    public function UserManagement()
    {

        $guias = guias::all();
        $empresa = Empresa::where('tipo', 2)->get(); // Esto depende de cómo tengas configurado tu modelo Empresa
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
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_guia',
            2 => 'id_plantacion',
            3 => 'folio',
            4 => 'id_empresa',
            5 => 'id_predio',
            6 => 'numero_plantas',
            7 => 'numero_guias',
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

        $query = guias::with('empresa');

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
                    'id_predio' => $user->id_predio,
                    'numero_plantas' => $user->numero_plantas,
                    'numero_guias' => $user->numero_guias,
                    'num_anterior' => $user->num_anterior,
                    'num_comercializadas' => $user->num_comercializadas,
                    'mermas_plantas' => $user->mermas_plantas,


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

public function store(Request $request)
{
    // Validar los datos recibidos
    $request->validate([
        'empresa' => 'required|exists:empresa,id_empresa',
        'presentacion' => 'required|numeric',
        'predios' => 'required|exists:predios,id_predio',
        'plantacion' => 'required|exists:predio_plantacion,id_plantacion',
        'folio' => 'required|string|max:255',
        'anterior' => 'required|numeric',
        'comercializadas' => 'required|numeric',
        'mermas' => 'required|numeric',
        'plantas' => 'required|numeric',
    ]);

    // Crear una nueva instancia del modelo Guia
    $guia = new guias();
    $guia->id_empresa = $request->input('empresa');
    $guia->id_predio = $request->input('predios');
    $guia->id_plantacion = $request->input('plantacion');
    $guia->folio = $request->input('folio');
    $guia->num_anterior = $request->input('anterior', 0);
    $guia->num_comercializadas = $request->input('comercializadas', 0);
    $guia->mermas_plantas = $request->input('mermas', 0);
    $guia->numero_plantas = $request->input('plantas', 0);
    $guia->numero_guias = $request->input('presentacion');
    $guia->save();

    // Responder con éxito
    return response()->json(['success' => 'Guía registrada correctamente']);
}


}