<?php

namespace App\Http\Controllers\marcasCatalogo;

use App\Http\Controllers\Controller;
use App\Models\Documentacion;
use App\Models\Documentacion_url;
use Illuminate\Http\Request;
use App\Models\marcas;
use App\Models\empresa;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Storage;



class marcasCatalogoController extends Controller
{

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_marca',
            2 => 'folio',
            3 => 'marca',
            4 => 'id_empresa',
        ];

        $search = [];

        $totalData = marcas::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $users = marcas::with('empresa') // Incluye la relación empresa
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = marcas::with('empresa') // Incluye la relación empresa
                ->where('id_marca', 'LIKE', "%{$search}%")
                ->orWhere('folio', 'LIKE', "%{$search}%")
                ->orWhere('marca', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = marcas::where('id_marca', 'LIKE', "%{$search}%")
                ->orWhere('folio', 'LIKE', "%{$search}%")
                ->orWhere('marca', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($users)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($users as $user) {
                $nestedData['id_marca'] = $user->id_marca;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['folio'] = $user->folio;
                $nestedData['marca'] = $user->marca;
                $nestedData['id_empresa'] = $user->id_empresa;
                $nestedData['razon_social'] = $user->empresa ? $user->empresa->razon_social : ''; // Obtiene la razón social

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


    /*Metodo para actualizar*/
    public function store(Request $request)
    {
        $request->validate([
            'marca' => 'required|string|max:60',
        ]);

        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->cliente)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

        if ($request->id) {
            // Actualizar marca existente
            $marca = marcas::findOrFail($request->id);
            $marca->id_empresa = $request->cliente;
            $marca->marca = $request->marca;
            $marca->folio = Helpers::generarFolioMarca($request->cliente);
            $marca->save();
        } else {
            // Crear nueva marca
            $marca = new marcas();
            $marca->id_empresa = $request->cliente;
            $marca->marca = $request->marca;
            $marca->folio = Helpers::generarFolioMarca($request->cliente);
            $marca->save();
        }

        // Almacenar el archivo
        if ($request->hasFile('url')) {
            foreach ($request->file('url') as $index => $file) {
                $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

                // Verificar si el documento ya existe para esta marca y cliente
                $existingDocument = Documentacion_url::where('id_relacion', $marca->id_marca)
                    ->where('id_documento', $request->id_documento[$index])
                    ->first();

                if ($existingDocument) {
                    // Eliminar el archivo anterior
                    Storage::disk('public')->delete($existingDocument->url);

                    // Actualizar la información del archivo en la base de datos
                    $existingDocument->url = $filePath;
                    $existingDocument->nombre_documento = $request->nombre_documento[$index];
                    $existingDocument->save();
                } else {
                    // Crear nuevo registro de documento
                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $marca->id_marca;
                    $documentacion_url->id_documento = $request->id_documento[$index];
                    $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                    $documentacion_url->url = $filePath;
                    $documentacion_url->id_empresa = $request->cliente;
                    $documentacion_url->save();
                }
            }
        }
    }


    //Metodo para editar las marcas
    public function edit($id_marca)
    {
        try {
            $marca = marcas::findOrFail($id_marca);
            return response()->json($marca);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener los datos de la marcona'], 500);
        }
    }

    // Método para actualizar una marca existente
    public function update(Request $request, $id_marca)
    {
        $request->validate([
            'marca' => 'required|string|max:60',
            'cliente' => 'required|integer|exists:empresa,id_empresa',
        ]);

        try {
            $marca = marcas::findOrFail($id_marca);
            $marca->marca = $request->marca;
            $marca->id_empresa = $request->cliente;
            $marca->save();

            return response()->json(['success' => 'Marca actualizada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la marca'], 500);
        }
    }

    public function marcas()
    {
        $clientes = empresa::where('tipo', 1)->get();
        $opciones = marcas::all();
        return view('clientesMarcas.find_catalago_marcas', compact('opciones', 'clientes'));
    }




    //funcion para eliminar
    public function destroy($id_marca)
    {
        $clase = marcas::findOrFail($id_marca);
        $clase->delete();

        return response()->json(['success' => 'Clase eliminada correctamente']);
    }


    /*Crea la solicitud JSEON*/
    public function UserManagement()
    {
        // Obtener listado de clientes (empresas)
        $clientes = Empresa::all(); // Esto depende de cómo tengas configurado tu modelo Empresa
        $documentos = Documentacion::where('id_documento', '=', '82')
            ->orWhere('id_documento', '=', '80')
            ->orWhere('id_documento', '=', '121')
            ->orWhere('id_documento', '=', '107')
            ->orWhere('id_documento', '=', '38')
            ->orWhere('id_documento', '=', '39')
            ->orWhere('id_documento', '=', '40')
            ->get();

        // Otros datos que puedas querer pasar a la vista
        $marcas = marcas::all();
        $userCount = $marcas->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('clientesMarcas.find_catalago_marcas', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'clientes' => $clientes, // Pasa la lista de clientes a la vista
            'documentos' => $documentos,
        ]);
    }
}
