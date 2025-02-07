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
use App\Models\direcciones;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helpers;
use App\Models\etiquetas;
use App\Models\etiquetas_destino;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class EtiquetasController extends Controller
{
    /*Crea la solicitud JSEON*/
    public function UserManagement()
    {
        // Obtener listado de clientes (empresas)
        $clientes = Empresa::with('empresaNumClientes')->where('tipo', 2)->get();


        // Otros datos que puedas querer pasar a la vista
        $marcas = marcas::all();
        //$direcciones = direcciones::where('id_empresa',$marca->id_empresa)->get();

        $tipos = tipos::all();
        $clases = clases::all();
        $categorias = categorias::all();
        $destinos = direcciones::all();


        return view('catalogo.find_etiquetas', [
            'clientes' => $clientes,
            'tipos' => $tipos,
            'clases' => $clases,
            'categorias' => $categorias,
            'destinos' => $destinos,
            'marcas' => $marcas,

        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_etiqueta',
            2 => 'sku',
            3 => 'presentacion',
            4 => 'unidad',
            5 => 'alc_vol',
        ];

        $search = [];

        $totalData = etiquetas::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $sql = etiquetas::with('destinos', 'marca') // Incluye la relación empresa
                ->offset($start)
                ->limit($limit)
                //  ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $sql = etiquetas::with('destinos', 'marca') // Incluye la relación empresa
                ->where('sku', 'LIKE', "%{$search}%")
                ->orWhere('presentacion', 'LIKE', "%{$search}%")
                ->orWhere('alc_vol', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                //  ->orderBy($order, $dir)
                ->get();
            $totalFiltered = etiquetas::where('sku', 'LIKE', "%{$search}%")
                ->orWhere('unidad', 'LIKE', "%{$search}%")
                ->orWhere('presentacion', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($sql)) {
            // providing a dummy id instead of database ids
            $ids = $start;

            foreach ($sql as $etiqueta) {
                $nestedData['id_etiqueta'] = $etiqueta->id_etiqueta;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['marca'] = $etiqueta->marca->marca;
                $nestedData['sku'] = $etiqueta->presentacion;
                $nestedData['presentacion'] = $etiqueta->presentacion;
                $nestedData['unidad'] = $etiqueta->unidad;
                $nestedData['alc_vol'] = $etiqueta->alc_vol;
                $nestedData['categoria'] = $etiqueta->categoria->categoria;
                $nestedData['clase'] = $etiqueta->clase->clase;
                $nestedData['tipo'] = $etiqueta->tipo->nombre . " (" . $etiqueta->tipo->cientifico . ")";
                $nestedData['numero_cliente'] = $etiqueta->marca->empresa->empresaNumClientes
                    ?->pluck('numero_cliente')
                    ?->first(fn($num) => !empty($num)) ?? "";

                $nestedData['url_etiqueta'] = $etiqueta->url_etiqueta->url ?? "Sin documento";
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

        // Verificar si estamos editando o creando una nueva etiqueta
        $etiqueta = $request->id_etiqueta ? etiquetas::find($request->id_etiqueta) : new etiquetas();

        // Si estamos editando y la etiqueta no existe, retornar error
        if ($request->id_etiqueta && !$etiqueta) {
            return response()->json(['error' => 'Etiqueta no encontrada.'], 404);
        }

        // Obtener el número de cliente asociado a la empresa
        $empresa = marcas::with("empresa.empresaNumClientes")->where("id_marca", $request->id_marca)->first();
        $numeroCliente = $empresa->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        // Asignar valores al modelo
        $etiqueta->id_marca = $request->id_marca;
        $etiqueta->sku = $request->sku ?? '';
        $etiqueta->id_categoria = $request->id_categoria;
        $etiqueta->id_clase = $request->id_clase;
        $etiqueta->id_tipo = $request->id_tipo;
        $etiqueta->presentacion = $request->presentacion;
        $etiqueta->unidad = $request->unidad;
        $etiqueta->alc_vol = $request->alc_vol;
        $etiqueta->save();

        // Eliminar destinos previos si es edición
        if ($request->id_etiqueta) {
            etiquetas_destino::where('id_etiqueta', $etiqueta->id_etiqueta)->delete();
        }

        // Guardar nuevos destinos
        foreach ($request->id_destino as $destino) {
            $direccion = new etiquetas_destino();
            $direccion->id_direccion = $destino;
            $direccion->id_etiqueta = $etiqueta->id_etiqueta;
            $direccion->save();
        }

        // Manejar la carga de documentos
        if ($request->hasFile('url_etiqueta')) {
            $file = $request->file('url_etiqueta');
            $filename = $request->nombre_documento_etiqueta . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploads/' . $numeroCliente . '/' . $filename;

            // Buscar si ya existe un documento para esta etiqueta
            $documentacion_url = Documentacion_url::where('id_relacion', $etiqueta->id_etiqueta)->where('id_documento',60)->first();

            if ($documentacion_url) {
                // Eliminar el archivo anterior si existe
                $oldFilePath = 'uploads/' . $numeroCliente . '/' . $documentacion_url->url;
                if (Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
            } else {
                // Si no existe un registro, creamos uno nuevo
                $documentacion_url = new Documentacion_url();
                $documentacion_url->id_relacion = $etiqueta->id_etiqueta;
                $documentacion_url->id_documento = $request->id_documento_etiqueta;
                $documentacion_url->id_empresa = $empresa->id_empresa;
            }

            // Guardar el nuevo archivo
            $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

            // Actualizar la información del documento
            $documentacion_url->nombre_documento = $request->nombre_documento_etiqueta;
            $documentacion_url->url = $filename;
            $documentacion_url->save();
        }


           // Manejar la carga de documentos
           if ($request->hasFile('url_corrugado')) {
            $file = $request->file('url_corrugado');
            $filename = $request->nombre_documento_corrugado . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = 'uploads/' . $numeroCliente . '/' . $filename;

            // Buscar si ya existe un documento para esta etiqueta
            $documentacion_url = Documentacion_url::where('id_relacion', $etiqueta->id_etiqueta)->where('id_documento',75)->first();

            if ($documentacion_url) {
                // Eliminar el archivo anterior si existe
                $oldFilePath = 'uploads/' . $numeroCliente . '/' . $documentacion_url->url;
                if (Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
            } else {
                // Si no existe un registro, creamos uno nuevo
                $documentacion_url = new Documentacion_url();
                $documentacion_url->id_relacion = $etiqueta->id_etiqueta;
                $documentacion_url->id_documento = $request->id_documento_corrugado;
                $documentacion_url->id_empresa = $empresa->id_empresa;
            }

            // Guardar el nuevo archivo
            $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

            // Actualizar la información del documento
            $documentacion_url->nombre_documento = $request->nombre_documento_corrugado;
            $documentacion_url->url = $filename;
            $documentacion_url->save();
        }


        return response()->json(['success' => $request->id_etiqueta ? 'Etiqueta actualizada exitosamente.' : 'Etiqueta registrada exitosamente.']);
    }

    //Metodo para editar las marcas
    public function edit_etiqueta($id_etiqueta)
    {
        $etiqueta = etiquetas::with('destinos')->findOrFail($id_etiqueta);
        $documentacion_urls = Documentacion_url::where('id_relacion', $id_etiqueta)->where('id_documento',60)->get(); // Obtener los documentos asociados a la marca
        $documentacion_urls_corrugado = Documentacion_url::where('id_relacion', $id_etiqueta)->where('id_documento',75)->get(); // Obtener los documentos asociados a la marca
        $empresa = marcas::with("empresa.empresaNumClientes")->where("id_marca", $etiqueta->id_marca)->first();
        $numeroCliente = $empresa->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        return response()->json([
            'etiqueta' => $etiqueta,
            'documentacion_urls' => $documentacion_urls, // Incluir la fecha de vigencia en los datos
            'documentacion_urls_corrugado' => $documentacion_urls_corrugado, // Incluir la fecha de vigencia en los datos
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
            // Validación de los campos requeridos
            $request->validate([
                'id_direccion' => 'required|array',
                'id_marca' => 'required|exists:marcas,id_marca',
                'sku' => 'array',
                'id_tipo' => 'array',
                'presentacion' => 'array',
                'unidad' => 'array',
                'id_clase' => 'array',
                'id_categoria' => 'array',
                'alc_vol' => 'array',
                'id_documento' => 'array',
                'url_etiqueta' => 'array',
                'url_corrugado' => 'array',
            ]);

            // Obtener datos del formulario
            $direcciones = $request->id_direccion;
            $totalElementos = count($direcciones);
            $idUnico = $request->id_unico ?? [];

            // Completar IDs únicos si faltan
            for ($i = count($idUnico); $i < $totalElementos; $i++) {
                $idUnico[] = Str::uuid()->toString();
            }

            // Actualizar el lote envasado con datos etiquetados
            $loteEnvasado = marcas::findOrFail($request->id_marca);
            $loteEnvasado->etiquetado = json_encode([
                'id_unico' => $idUnico,
                'id_direccion' => $direcciones,
                'sku' => $request->sku,
                'id_tipo' => $request->id_tipo,
                'presentacion' => $request->presentacion,
                'unidad' => $request->unidad,
                'id_clase' => $request->id_clase,
                'id_categoria' => $request->id_categoria,
                'alc_vol' => $request->alc_vol,
            ]);
            $loteEnvasado->save();

            // Obtener el número de cliente
            $empresa = empresa::with('empresaNumClientes')
                ->where('id_empresa', $loteEnvasado->id_empresa)
                ->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')
                ->first(fn($numero) => !empty($numero));

            // Documentos actuales
            $documentosActuales = Documentacion_url::where('id_relacion', $loteEnvasado->id_marca)
                ->whereIn('id_documento', [60, 75])
                ->pluck('id_doc', 'id_documento')
                ->toArray();
            $imprimir = 'No entra a nada';

            foreach ($idUnico as $item) {
                $idUnico1[] = $item;
                $idUnico1[] = $item; // Duplicamos el valor
            }


            // Procesar cada documento enviado
            foreach ($request->id_documento as $index => $id_documento) {



                if ($id_documento == 60 and !isset($idUnico1[$index]) and !isset($request->url_etiqueta[$index])) {
                    continue;
                }

                if ($id_documento == 75 and !isset($idUnico1[$index]) and !isset($request->url_corrugado[$index])) {
                    continue;
                }

                // $imprimir = $imprimir.'-entro aunque sea al for'.$idUnico1[$index].' y '.$id_documento;

                $currentIdUnico = $idUnico1[$index];
                $documento = Documentacion_url::where('id_doc', $currentIdUnico)
                    ->where('id_documento', $id_documento)
                    ->where('id_relacion', $loteEnvasado->id_marca)
                    ->first();

                if ($documento) {
                    // Actualizar documento existente
                    $imprimir = $imprimir . '---entro al editar' . $id_documento . ' ' . $currentIdUnico;
                    $this->updateDocument($documento, $request, $index, $numeroCliente, $imprimir);
                } else {
                    // Crear un nuevo documento
                    //$imprimir = $imprimir.'---entro al registrar'.$id_documento.' '.$currentIdUnico;
                    $this->createNewDocuments($loteEnvasado, $currentIdUnico, $request, $index, $numeroCliente);
                }
            }

            return response()->json(['success' => 'Etiquetas actualizadas correctamente']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar las etiquetas',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }

    protected function updateDocument($documento, $request, $index, $numeroCliente, $imprimir)
    {
        $imprimir = 'a editar';
        if (isset($request->file('url')[$index]) && $documento->id_documento == 60) {
            $file = $request->file('url')[$index];
            $filename = 'etiquetas_editado' . time() . $index . '.' . $file->getClientOriginalExtension();
            $file->storeAs("uploads/$numeroCliente", $filename, 'public');
            $documento->url = $filename;
            $documento->save();
        }

        if (isset($request->file('url')[$index]) && $documento->id_documento == 75) {
            $file = $request->file('url')[$index];
            $filename = 'corrugado_editado' . time() . $index . '.' . $file->getClientOriginalExtension();
            $file->storeAs("uploads/$numeroCliente", $filename, 'public');
            $documento->url = $filename;
            $documento->save();
        }
    }

    protected function createNewDocuments($loteEnvasado, $currentIdUnico, $request, $index, $numeroCliente)
    {
        $imprimir = 'a registrar';
        if (isset($request->file('url')[$index])) {
            $file = $request->file('url')[$index];
            $filename = $request->nombre_documento[$index] . '_' . time() . $index . '.' . $file->getClientOriginalExtension();
            $file->storeAs("uploads/$numeroCliente", $filename, 'public');

            Documentacion_url::create([
                'id_relacion' => $loteEnvasado->id_marca,
                'id_doc' => $currentIdUnico,
                'id_documento' => $request->id_documento[$index],
                'nombre_documento' => $request->nombre_documento[$index],
                'url' => $filename,
                'id_empresa' => $loteEnvasado->id_empresa,
            ]);
        }
    }






    //Editar etiquetas solo para quie se guarde
    public function editEtiquetas($id)
    {
        $marca = Marcas::findOrFail($id);
        $tipos = tipos::all();
        $clases = clases::all();
        $direcciones = direcciones::where('id_empresa', $marca->id_empresa)->where('tipo_direccion', 1)->get();
        $categorias = categorias::all();
        $documentacion_urls = Documentacion_url::where('id_relacion', $id)->get();
        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $marca->id_empresa)->first();
        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
            return !empty($numero);
        });

        $etiquetado = json_decode($marca->etiquetado, true);
        $marca->id_direccion = $etiquetado['id_direccion'] ?? null;
        $marca->sku = $etiquetado['sku'] ?? null;
        $marca->id_tipo = $etiquetado['id_tipo'] ?? null;
        $marca->presentacion = $etiquetado['presentacion'] ?? null;
        $marca->id_clase = $etiquetado['id_clase'] ?? null;
        $marca->id_categoria = $etiquetado['id_categoria'] ?? null;
        $marca->id_unico = $etiquetado['id_unico'] ?? null;
        $marca->alc_vol = $etiquetado['alc_vol'] ?? null;
        $marca->unidad = $etiquetado['unidad'] ?? null;

        return response()->json([
            'direcciones' => $direcciones,
            'marca' => $marca,
            'tipos' => $tipos,
            'clases' => $clases,
            'categorias' => $categorias,
            'documentacion_urls' => $documentacion_urls, // Incluir la fecha de vigencia en los datos
            'numeroCliente' => $numeroCliente
        ]);
    }
}
