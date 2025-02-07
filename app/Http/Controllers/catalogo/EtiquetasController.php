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
                $nestedData['sku'] = $etiqueta->sku;
                $nestedData['presentacion'] = $etiqueta->presentacion;
                $nestedData['unidad'] = $etiqueta->unidad;
                $nestedData['alc_vol'] = $etiqueta->alc_vol;
                $nestedData['categoria'] = $etiqueta->categoria->categoria;
                $nestedData['clase'] = $etiqueta->clase->clase;
                $nestedData['tipo'] = $etiqueta->tipo->nombre . " (" . $etiqueta->tipo->cientifico . ")";
                $nestedData['numero_cliente'] = $etiqueta->marca->empresa->empresaNumClientes
                    ?->pluck('numero_cliente')
                    ?->first(fn($num) => !empty($num)) ?? "";
                $nestedData['razon_social'] = $etiqueta->marca->empresa->razon_social;
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


    //funcion para eliminar
    public function destroy($id_etiqueta)
    {
        $etiqueta = etiquetas::findOrFail($id_etiqueta);

        // Eliminar relaciones
        $etiqueta->destinos()->delete();
        $etiqueta->url_etiqueta()->delete();
        $etiqueta->url_corrugado()->delete();
    
        // Eliminar la etiqueta principal
        $etiqueta->delete();
        return response()->json(['success' => 'Etiqueta eliminada correctamente']);
    }



}
