<?php

namespace App\Http\Controllers\catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documentacion;
use App\Models\Documentacion_url;
use App\Models\marcas;
use App\Models\empresa;
use App\Models\catalogo_norma_certificar;
use App\Models\tipos;
use App\Models\clases;
use App\Models\categorias;

use Illuminate\Support\Facades\Auth;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Storage;



class marcasCatalogoController extends Controller
{
    /*Crea la solicitud JSEON*/
    public function UserManagement()
    {
        // Obtener listado de clientes (empresas)
        $clientes = Empresa::where('tipo', 2)->get(); // Esto depende de cómo tengas configurado tu modelo Empresa
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
        $catalogo_norma_certificar = catalogo_norma_certificar::all();
        $tipos = tipos::all();
        $clases = clases::all();
        $categorias = categorias::all();
        $userCount = $marcas->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('catalogo.find_catalago_marcas', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'clientes' => $clientes, // Pasa la lista de clientes a la vista
            'documentos' => $documentos,
            'catalogo_norma_certificar' => $catalogo_norma_certificar,
            'tipos' => $tipos,
            'clases' => $clases,
            'categorias' => $categorias,



        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_marca',
            2 => 'folio',
            3 => 'marca',
            4 => 'id_empresa',
            5 => 'id_norma',
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
                $id_norma = \App\Models\catalogo_norma_certificar::where('id_norma', $user->id_norma)->value('norma');

                $nestedData['id_marca'] = $user->id_marca;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['folio'] = $user->folio;
                $nestedData['marca'] = $user->marca;
                $nestedData['id_empresa'] = $user->id_empresa;
                $nestedData['id_norma'] = $id_norma;
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



        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->cliente)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

        if ($request->id) {
            // Actualizar marca existente
            $marca = marcas::findOrFail($request->id);
            $marca->id_empresa = $request->cliente;
            $marca->marca = $request->marca;
            $marca->id_norma = $request->id_norma;
            $marca->folio = Helpers::generarFolioMarca($request->cliente);
            $marca->save();

            // Actualizar documentos existentes o agregar nuevos
            if ($request->has('id_documento')) {
                foreach ($request->id_documento as $index => $id_documento) {
                    $documento = Documentacion_url::where('id_relacion', $marca->id_marca)
                        ->where('id_documento', $id_documento)
                        ->first();

                    if ($documento) {
                        // Actualizar archivo y fecha de vigencia si están presentes
                        if ($request->hasFile('url') && isset($request->file('url')[$index])) {
                            // Eliminar el archivo anterior
                            Storage::disk('public')->delete('uploads/' . $numeroCliente . '/' . $documento->url);

                            // Subir el nuevo archivo
                            $file = $request->file('url')[$index];
                            $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                            $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

                            // Actualizar en la base de datos
                            $documento->url = $filename;
                        }

                        // Actualizar fecha de vigencia solo si está presente en la solicitud
                        if (!empty($request->fecha_vigencia[$index])) {
                            $documento->fecha_vigencia = $request->fecha_vigencia[$index];
                        }
                        $documento->save();
                    } else {
                        // Agregar nuevo documento si no existe
                        if ($request->hasFile('url') && isset($request->file('url')[$index])) {
                            $file = $request->file('url')[$index];
                            $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                            $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

                            $documentacion_url = new Documentacion_url();
                            $documentacion_url->id_relacion = $marca->id_marca;
                            $documentacion_url->id_documento = $id_documento;
                            $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                            $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                            $documentacion_url->id_empresa = $request->cliente;
                            $documentacion_url->fecha_vigencia = $request->fecha_vigencia[$index] ?? null;
                            $documentacion_url->save();
                        }
                    }
                }
            }
        } else {
            // Crear nueva marca
            $marca = new marcas();
            $marca->id_empresa = $request->cliente;
            $marca->marca = $request->marca;
            $marca->id_norma = $request->id_norma;
            $marca->folio = Helpers::generarFolioMarca($request->cliente);
            $marca->save();

            // Almacenar nuevos documentos solo si se envían
            if ($request->hasFile('url')) {
                foreach ($request->file('url') as $index => $file) {
                    $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $marca->id_marca;
                    $documentacion_url->id_documento = $request->id_documento[$index];
                    $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                    $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                    $documentacion_url->id_empresa = $request->cliente;
                    $documentacion_url->fecha_vigencia = $request->fecha_vigencia[$index] ?? null; // Usa null si no hay fecha
                    $documentacion_url->save();
                }
            }
        }

        return response()->json(['success' => 'Marca registrada exitosamente.']);
    }




    //Metodo para editar las marcas
    public function edit($id)
    {

        $marca = Marcas::findOrFail($id);
        $documentacion_urls = Documentacion_url::where('id_relacion', $id)->get(); // Obtener los documentos asociados a la marca

        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $marca->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();



        return response()->json([
            'marca' => $marca,
            'documentacion_urls' => $documentacion_urls, // Incluir la fecha de vigencia en los datos
            'numeroCliente' => $numeroCliente
        ]);
    }







    // Método para actualizar una marca existente
    public function update(Request $request)
    {
        $request->validate([
            'marca' => 'required|string|max:60',
            'cliente' => 'required|integer|exists:empresa,id_empresa',
        ]);

        try {
            $marca = marcas::findOrFail($request->input('id_marca'));
            $marca->marca = $request->marca;
            $marca->id_empresa = $request->cliente;
            $marca->id_norma = $request->edit_id_norma;
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
        return view('catalogo.find_catalago_marcas', compact('opciones', 'clientes'));
    }




    //funcion para eliminar
    public function destroy($id_marca)
    {
        $clase = marcas::findOrFail($id_marca);
        $clase->delete();

        return response()->json(['success' => 'Clase eliminada correctamente']);
    }



    public function updateEtiquetas(Request $request)
    {
        try {
            // Obtener el lote envasado existente
            $loteEnvasado = marcas::findOrFail($request->input('id_marca'));
    
            // Decodificar el JSON existente
            $etiquetado = json_decode($loteEnvasado->etiquetado, true);
            
            // Inicializar los arrays si no existen
            if (!isset($etiquetado['id_doc'])) {
                $etiquetado['id_doc'] = [];
            }
            if (!isset($etiquetado['sku'])) {
                $etiquetado['sku'] = [];
            }
            if (!isset($etiquetado['id_tipo'])) {
                $etiquetado['id_tipo'] = [];
            }
            if (!isset($etiquetado['presentacion'])) {
                $etiquetado['presentacion'] = [];
            }
            if (!isset($etiquetado['id_clase'])) {
                $etiquetado['id_clase'] = [];
            }
            if (!isset($etiquetado['id_categoria'])) {
                $etiquetado['id_categoria'] = [];
            }
    
            // Obtener el siguiente id_doc
            $nuevoIdDoc = count($etiquetado['id_doc']) + 1; // Incrementar el contador
    
            // Agregar los datos recibidos en la solicitud solo si no existen
            foreach ($request->sku as $index => $sku) {
                // Verificar si el SKU ya existe
                if (!in_array($sku, $etiquetado['sku'])) {
                    $etiquetado['id_doc'][] = (string)($nuevoIdDoc); // Asignar un nuevo id_doc
                    $etiquetado['sku'][] = $sku;
                    $etiquetado['id_tipo'][] = $request->id_tipo[$index];
                    $etiquetado['presentacion'][] = $request->presentacion[$index];
                    $etiquetado['id_clase'][] = $request->id_clase[$index];
                    $etiquetado['id_categoria'][] = $request->id_categoria[$index];
                    $nuevoIdDoc++; // Incrementar el id_doc para la siguiente entrada
                }
            }
    
            // Volver a codificar el JSON
            $loteEnvasado->etiquetado = json_encode($etiquetado);
            $loteEnvasado->save();
    
            // Método para guardar PDF
            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $loteEnvasado->id_empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
    
            // Guardar documentos subidos
            foreach ($request->id_documento as $index => $id_documento) {
                // Agregar nuevo documento si existe el archivo correspondiente
                if ($request->hasFile('url') && isset($request->file('url')[$index])) {
                    $file = $request->file('url')[$index];
                    $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');
    
                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $loteEnvasado->id_marca;
                    $documentacion_url->id_documento = $id_documento;
                    $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                    $documentacion_url->url = $filename; // Almacenar solo el nombre del archivo
                    $documentacion_url->id_empresa = $loteEnvasado->id_empresa;
    
                    // Aquí asociamos el id_doc correspondiente del SKU
                    if (isset($etiquetado['id_doc'][$index])) {
                        $documentacion_url->id_doc = $etiquetado['id_doc'][$index]; // Asociar el id_doc correspondiente
                    }
    
                    // Si no se asigna, se podría asignar el último id_doc
                    if (!isset($documentacion_url->id_doc)) {
                        $documentacion_url->id_doc = end($etiquetado['id_doc']);
                    }
    
                    $documentacion_url->save();
                }
            }
    
            // Retornar respuesta exitosa
            return response()->json(['success' => 'Etiquetas cargadas correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar la etiqueta: ' . $e->getMessage()], 500);
        }
    }
    
    
    
    
    



    public function editEtiquetas($id)
    {

        $marca = Marcas::findOrFail($id);
        $tipos = tipos::all();
        $clases = clases::all();
        $categorias = categorias::all();
        $documentacion_urls = Documentacion_url::where('id_relacion', $id)->get();

        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $marca->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

        $etiquetado = json_decode($marca->etiquetado, true);
        $marca->sku = $etiquetado['sku'] ?? null;
        $marca->id_tipo = $etiquetado['id_tipo'] ?? null;
        $marca->presentacion = $etiquetado['presentacion'] ?? null;
        $marca->id_clase = $etiquetado['id_clase'] ?? null;
        $marca->id_categoria = $etiquetado['id_categoria'] ?? null;

        return response()->json([
            'marca' => $marca,
            'tipos' => $tipos,
            'clases' => $clases,
            'categorias' => $categorias,
            'documentacion_urls' => $documentacion_urls, // Incluir la fecha de vigencia en los datos
            'numeroCliente' => $numeroCliente
        ]);
    }
}
