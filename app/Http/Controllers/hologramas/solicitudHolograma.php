<?php

namespace App\Http\Controllers\hologramas;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\empresa;
use App\Models\solicitudHolograma as ModelsSolicitudHolograma;
use App\Models\direcciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


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

                $marca = \App\Models\Marcas::where('id_marca', $user->id_marca)->value('marca');

                $nestedData = [
                    'fake_id' => ++$ids,
                    'id_solicitud' => $user->id_solicitud,
                    'folio' => $user->folio,
                    'razon_social' => $user->empresa ? $user->empresa->razon_social : '',
                    'id_empresa' => $user->id_empresa,
                    'id_solicitante' => $user->id_solicitante,
                    'id_marca' => $marca, // Asignar el nombre de la marca a id_marca
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
        if (!Auth::check()) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }
        
        // Validar los datos recibidos del formulario
        $request->validate([
            'folio' => 'required|string|max:255',
            'id_empresa' => 'required|integer',
            'id_marca' => 'required|integer',
            'cantidad_hologramas' => 'required|integer',
            'id_direccion' => 'required|integer',
            'comentarios' => 'nullable|string|max:1000',
        ]);
    
        // Crear una nueva instancia del modelo Hologramas
        $holograma = new ModelsSolicitudHolograma();
        $holograma->folio = $request->folio;
        $holograma->id_empresa = $request->id_empresa;
        $holograma->id_marca = $request->id_marca;
        $holograma->id_solicitante = Auth::user()->id; // Obtiene el ID del usuario actual
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
            $holograma = ModelsSolicitudHolograma::findOrFail($id_solicitud);
            return response()->json($holograma);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la guía'], 500);
        }
    }


    // Método para actualizar un registro existente
    public function update(Request $request, $id_solicitud)
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $holograma = ModelsSolicitudHolograma::findOrFail($id_solicitud);
    
            // Actualiza los campos con los datos del formulario
            $holograma->folio = $request->input('edit_folio');
            $holograma->id_empresa = $request->input('edit_id_empresa');
            $holograma->id_marca = $request->input('edit_id_marca');
            $holograma->id_solicitante = Auth::user()->id; // Actualiza el ID del solicitante con el ID del usuario actual
            $holograma->cantidad_hologramas = $request->input('edit_cantidad_hologramas');
            $holograma->id_direccion = $request->input('edit_id_direccion');
            $holograma->comentarios = $request->input('edit_comentarios');
    
            // Guarda los cambios en la base de datos
            $holograma->save();
    
            // Retorna una respuesta exitosa
            return response()->json(['success' => 'Solicitud actualizada correctamente']);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el proceso
            return response()->json(['error' => 'Error al actualizar la solicitud'], 500);
        }
    }
    


    public function ModelsSolicitudHolograma($id)
    {
        // Cargar la solicitud de holograma con la relación de la empresa
        $datos = ModelsSolicitudHolograma::with('empresa', 'direcciones')->findOrFail($id);

        // Pasar los datos a la vista del PDF
        $pdf = Pdf::loadView('pdfs.solicitudDeHologramas', ['datos' => $datos]);
    
        // Generar y devolver el PDF
        return $pdf->stream('INV-4232024-Nazareth_Camacho_.pdf');
    }
    
    
}
