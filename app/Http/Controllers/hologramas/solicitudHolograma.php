<?php

namespace App\Http\Controllers\hologramas;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\empresa;
use App\Models\solicitudHolograma as ModelsSolicitudHolograma;
use Illuminate\Http\Request;

class solicitudHolograma extends Controller
{
    public function UserManagement()
    {
        $Empresa = Empresa::where('tipo', '=', '2')->get(); // Esto depende de cómo tengas configurado tu modelo Empresa
        $ModelsSolicitudHolograma = ModelsSolicitudHolograma::all();
        $userCount = $ModelsSolicitudHolograma->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('hologramas.find_solicitud_hologramas_view', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'Empresa' => $Empresa, // Pasa la lista de clientes a la vista
            'ModelsSolicitudHolograma' => $ModelsSolicitudHolograma,     // Pasa la lista de marcas a la vista


        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_solicitud',
            2 => 'folio',
            3 => 'id_empresa',
            4 => 'id_solicitante',
            5 => 'id_marca',
            6 => 'cantidad_hologramas',
            7 => 'id_direccion',
            8 => 'comentarios'


        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'id_solicitud';
        $dir = $request->input('order.0.dir');

        $searchValue = $request->input('search.value');

        $query = ModelsSolicitudHolograma::with(['empresa']);

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('id_solicitud', 'LIKE', "%{$searchValue}%")
                    ->orWhere('folio', 'LIKE', "%{$searchValue}%")
                    ->orWhere('id_empresa', 'LIKE', "%{$searchValue}%");
            });
        }

        $totalData = ModelsSolicitudHolograma::count();
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
                    'fake_id' => ++$ids,
                    'id_solicitud' => $user->id_solicitud,
                    'folio' => $user->folio,
                    'razon_social' => $user->empresa ? $user->empresa->razon_social : '',
                    'id_empresa' => $user->numero_cliente,
                    'id_solicitante' => $user->id_solicitante,
                    'id_marca' => $user->id_marca,
                    'cantidad_hologramas' => $user->cantidad_hologramas,
                    'id_direccion' => $user->id_direccion,
                    'comentarios' => $user->comentarios,
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
       public function destroy($id_solicitud)
       {
           $clase = ModelsSolicitudHolograma::findOrFail($id_solicitud);
           $clase->delete();
   
           return response()->json(['success' => 'Clase eliminada correctamente']);
       }


           //Metodo para registrar

           public function store(Request $request)
           {
               // Validar los datos recibidos del formulario
               $request->validate([
                   'folio' => 'required|string|max:255',
                   'id_empresa' => 'required|integer',
                   'id_marca' => 'required|integer',
                   'id_solicitante' => 'required|integer',
                   'cantidad_hologramas' => 'required|integer',
                   'id_direccion' => 'required|integer',
                   'comentarios' => 'nullable|string|max:1000',
               ]);
           
               // Crear una nueva instancia del modelo Hologramas
               $holograma = new ModelsSolicitudHolograma();
               $holograma->folio = $request->folio;
               $holograma->id_empresa = $request->id_empresa;
               $holograma->id_marca = $request->id_marca;
               $holograma->id_solicitante = $request->id_solicitante;
               $holograma->cantidad_hologramas = $request->cantidad_hologramas;
               $holograma->id_direccion = $request->id_direccion;
               $holograma->comentarios = $request->comentarios;
           
               // Guardar el nuevo registro en la base de datos
               $holograma->save();
           
               // Retornar una respuesta JSON indicando éxito
               return response()->json(['success' => 'Solicitud de Hologramas registrada correctamente']);
           }
           




// Método para obtener una guía por ID
public function edit($id_solicitud)
{
    try {
        $hologramas = ModelsSolicitudHolograma::findOrFail($id_solicitud);
        return response()->json($hologramas);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener la guía'], 500);
    }
}



}
