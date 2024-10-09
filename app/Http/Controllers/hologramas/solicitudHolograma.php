<?php

namespace App\Http\Controllers\hologramas;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\activarHologramasModelo;
use App\Models\empresa;
use App\Models\solicitudHolograma as ModelsSolicitudHolograma;
use App\Models\direcciones;
use App\Models\empresaNumCliente;
use App\Models\inspecciones; 
use App\Models\tipos; 

use App\Models\categorias;
use App\Models\Documentacion_url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class solicitudHolograma extends Controller
{
    public function UserManagement()
    {
        $Empresa = empresa::where('tipo', '=', '2')->get(); // Esto depende de cómo tengas configurado tu modelo Empresa
        $inspeccion = inspecciones::all();
        $categorias = categorias::all();
        $tipos = tipos::all();

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
            'inspeccion' => $inspeccion, // Pasa la lista de clientes a la vista
            'categorias' => $categorias, // Pasa la lista de clientes a la vista
            'tipos' => $tipos, // Pasa la lista de clientes a la vista




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
            8 => 'comentarios',
            9 => 'tipo_pago',
            10 => 'fecha_envio',
            11 => 'costo_envio',
            12 => 'no_guia'
            




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
                $numero_cliente = \App\Models\empresaNumCliente::where('id_empresa', $user->id_empresa)->value('numero_cliente');

                $marca = \App\Models\marcas::where('id_marca', $user->id_marca)->value('marca');
                $direccion = \App\Models\direcciones::where('id_direccion', $user->id_direccion)->value('direccion');
                
                //el segundo es el nombre de la variable del usuario
                $name = \App\Models\User::where('id', $user->id_solicitante)->value('name');


                $nestedData = [
                    'fake_id' => ++$ids,
                    'id_solicitud' => $user->id_solicitud,
                    'folio' => $user->folio,
                    'razon_social' => $user->empresa ? $user->empresa->razon_social : '',
                    'id_empresa' => $user->id_empresa,
                    'id_solicitante' => $name,
                    'id_marca' => $marca, // Asignar el nombre de la marca a id_marca
                    'cantidad_hologramas' => $user->cantidad_hologramas,
                    'id_direccion' => $direccion,
                    'comentarios' => $user->comentarios,
                    'tipo_pago' => $user->tipo_pago,
                    'fecha_envio' => $user->fecha_envio,
                    'costo_envio' => $user->costo_envio,
                    'no_guia' => $user->no_guia,
                    'estatus' => $user->estatus,
                    'folio_inicial' => $user->folio_inicial,
                    'folio_final' => $user->folio_final,




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
    
        // Obtener el último folio_final registrado con la misma id_empresa e id_marca
        $ultimoFolio = ModelsSolicitudHolograma::where('id_empresa', $request->id_empresa)
                        ->where('id_marca', $request->id_marca)
                        ->orderBy('folio_final', 'desc')
                        ->value('folio_final');
    
        // Si existe un registro previo, usar su folio_final + 1 como el nuevo folio_inicial, de lo contrario iniciar en 1
        $folioInicial = $ultimoFolio ? $ultimoFolio + 1 : 1;
    
        // Crear una nueva instancia del modelo Hologramas
        $holograma = new ModelsSolicitudHolograma();
        $holograma->folio = $request->folio;
        $holograma->id_empresa = $request->id_empresa;
        $holograma->id_marca = $request->id_marca;
        $holograma->id_solicitante = Auth::user()->id; // Obtiene el ID del usuario actual
        $holograma->cantidad_hologramas = $request->cantidad_hologramas;
        $holograma->id_direccion = $request->id_direccion;
        $holograma->comentarios = $request->comentarios;
        $holograma->folio_inicial = $folioInicial;
    
        // Calcular el folio final
        $holograma->folio_final = $folioInicial + $request->cantidad_hologramas - 1;
    
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
public function update(Request $request)
{
    try {
        // Encuentra la solicitud de hologramas por su ID
        $holograma = ModelsSolicitudHolograma::findOrFail($request->input('id_solicitud'));

        // Actualiza los campos con los datos del formulario
        $holograma->folio = $request->input('edit_folio');
        $holograma->id_empresa = $request->input('edit_id_empresa');
        $holograma->id_marca = $request->input('edit_id_marca');
        $holograma->id_solicitante = Auth::user()->id; // Actualiza el ID del solicitante con el ID del usuario actual
        $holograma->cantidad_hologramas = $request->input('edit_cantidad_hologramas');
        $holograma->id_direccion = $request->input('edit_id_direccion');
        $holograma->comentarios = $request->input('edit_comentarios');

        // Solo modificar el folio_final si el folio_inicial es 1
        if ($holograma->folio_inicial == 1) {
            // Calcular el folio final basado en la cantidad de hologramas
            $holograma->folio_final = $holograma->folio_inicial + $request->input('edit_cantidad_hologramas') - 1;
        } else {
            // Si no es el primer registro, recalcular folio_inicial y folio_final basado en el último registro de la misma empresa y marca
            $ultimoFolio = ModelsSolicitudHolograma::where('id_empresa', $request->input('edit_id_empresa'))
                ->where('id_marca', $request->input('edit_id_marca'))
                ->where('id_solicitud', '!=', $holograma->id_solicitud) // Excluir el registro actual
                ->orderBy('folio_final', 'desc') // Ordenar por el folio_final más alto
                ->value('folio_final'); // Obtener el valor del folio_final más alto
            
            // Si existe un registro previo, usar su folio_final + 1 como el nuevo folio_inicial
            $folioInicial = $ultimoFolio ? $ultimoFolio + 1 : 1;
            $holograma->folio_inicial = $folioInicial;
            $holograma->folio_final = $folioInicial + $request->input('edit_cantidad_hologramas') - 1;
        }

        // Guarda los cambios en la base de datos
        $holograma->save();

        // Retorna una respuesta exitosa
        return response()->json(['success' => 'Solicitud actualizada correctamente']);
    } catch (\Exception $e) {
        // Maneja cualquier error que ocurra durante el proceso
        return response()->json(['error' => 'Error al actualizar la solicitud'], 500);
    }
}

    
    

    public function update2(Request $request) //Este es para adjuntar comprobante de pago
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $holograma = ModelsSolicitudHolograma::findOrFail($request->input('id_solicitud'));
            $holograma->tipo_pago = $request->input('tipo_pago'); // Nuevo campo tipo_pago
            $holograma->estatus = 'Pagado';

            $holograma->save();
            //metodo para guardar pdf
            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();

            foreach ($request->id_documento as $index => $id_documento) {
                // Agregar nuevo documento si no existe
                if ($request->hasFile('url') && isset($request->file('url')[$index])) {
                    $file = $request->file('url')[$index];
                    $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');

                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $holograma->id_solicitud;
                    $documentacion_url->id_documento = $id_documento;
                    $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                    $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                    $documentacion_url->id_empresa = $request->empresa;
                    $documentacion_url->save();
                }
            }
            // Retorna una respuesta exitosa
            return response()->json(['success' => 'Solicitud de pago actualizada correctamente']);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el proceso
            return response()->json(['error' => 'Error al actualizar la solicitud de pago'], 500);
        }
    }


    public function update3(Request $request)
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $holograma = ModelsSolicitudHolograma::findOrFail($request->input('id_solicitud'));
            $holograma->fecha_envio = $request->input('fecha_envio');
            $holograma->costo_envio = $request->input('costo_envio');
            $holograma->no_guia = $request->input('no_guia');
            $holograma->estatus = 'Enviado';

        
            $holograma->save();
            //metodo para guardar pdf
            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
        
            foreach ($request->id_documento as $index => $id_documento) {
                // Agregar nuevo documento si no existe
                if ($request->hasFile('url') && isset($request->file('url')[$index])) {
                    $file = $request->file('url')[$index];
                    $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');
        
                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $holograma->id_solicitud;
                    $documentacion_url->id_documento = $id_documento;
                    $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                    $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                    $documentacion_url->id_empresa = $request->empresa;
                    $documentacion_url->save();
                }
            }
            // Retorna una respuesta exitosa
            return response()->json(['success' => 'Solicitud de envio actualizada correctamente']);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el proceso
            return response()->json(['error' => 'Error al actualizar la solicitud de envio'], 500);
        }
    }


    public function updateAsignar(Request $request)
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $holograma = ModelsSolicitudHolograma::findOrFail($request->input('id_solicitud'));
            $holograma->folio_inicial = $request->input('asig_folio_inicial');
            $holograma->folio_final = $request->input('asig_folio_final');
            $holograma->estatus = 'Asignado';

        
            $holograma->save();
            //metodo para guardar pdf

            // Retorna una respuesta exitosa
            return response()->json(['success' => 'Solicitud de envio actualizada correctamente']);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el proceso
            return response()->json(['error' => 'Error al actualizar la solicitud de envio'], 500);
        }
    }



    public function updateRecepcion(Request $request)
    {
        try {
            // Encuentra la solicitud de hologramas por su ID
            $holograma = ModelsSolicitudHolograma::findOrFail($request->input('id_solicitud'));

            $holograma->estatus = 'Completado';

        
            $holograma->save();
            //metodo para guardar pdf
            $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $request->empresa)->first();
            $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first();
        
            foreach ($request->id_documento as $index => $id_documento) {
                // Agregar nuevo documento si no existe
                if ($request->hasFile('url') && isset($request->file('url')[$index])) {
                    $file = $request->file('url')[$index];
                    $filename = $request->nombre_documento[$index] . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('uploads/' . $numeroCliente, $filename, 'public');
        
                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_relacion = $holograma->id_solicitud;
                    $documentacion_url->id_documento = $id_documento;
                    $documentacion_url->nombre_documento = $request->nombre_documento[$index];
                    $documentacion_url->url = $filename; // Corregido para almacenar solo el nombre del archivo
                    $documentacion_url->id_empresa = $request->empresa;
                    $documentacion_url->save();
                }
            }
            // Retorna una respuesta exitosa
            return response()->json(['success' => 'Solicitud de envio actualizada correctamente']);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante el proceso
            return response()->json(['error' => 'Error al actualizar la solicitud de envio'], 500);
        }
    }

    public function ModelsSolicitudHolograma($id)
    {
        // Cargar la solicitud de holograma con la relación de la empresa
        $datos = ModelsSolicitudHolograma::with('empresa', 'direcciones', 'user', 'empresanumcliente')->findOrFail($id);

        // Pasar los datos a la vista del PDF
        $pdf = Pdf::loadView('pdfs.solicitudDeHologramas', ['datos' => $datos]);

        // Generar y devolver el PDF
        return $pdf->stream('INV-4232024-Nazareth_Camacho_.pdf');
    }

    //metodo para activar hologramas
/*     public function editHolograma(Request $request)
{
    try {
        // Encuentra la solicitud de activación de hologramas por su ID
        $solicitud = activarHologramasModelo::findOrFail($request->input('id_solicitud'));

        // Actualiza los datos de la solicitud con los valores enviados desde el formulario
        $solicitud->id_inspeccion = $request->input('id_inspeccion');
        $solicitud->no_lote_agranel = $request->input('no_lote_agranel');
        $solicitud->categoria = $request->input('categoria');
        $solicitud->no_analisis = $request->input('no_analisis');
        $solicitud->cont_neto = $request->input('cont_neto');
        $solicitud->unidad = $request->input('unidad');
        $solicitud->clase = $request->input('clase');
        $solicitud->contenido = $request->input('contenido');
        $solicitud->no_lote_envasado = $request->input('no_lote_envasado');
        $solicitud->tipo_agave = $request->input('tipo_agave');
        $solicitud->lugar_produccion = $request->input('lugar_produccion');
        $solicitud->lugar_envasado = $request->input('lugar_envasado');
        $solicitud->cantidad_hologramas = $request->input('cantidad_hologramas');

        // Actualiza los rangos inicial y final de hologramas
        $solicitud->rango_inicial = $request->input('rango_inicial');
        $solicitud->rango_final = $request->input('rango_final');

        // Guarda la solicitud actualizada en la base de datos
        $solicitud->save();

        // Retorna una respuesta exitosa
        return response()->json(['success' => 'Solicitud de activación de hologramas actualizada correctamente']);
    } catch (\Exception $e) {
        // Maneja cualquier error que ocurra durante el proceso
        return response()->json(['error' => 'Error al actualizar la solicitud de activación de hologramas'], 500);
    }
} */


 
     public function storeActivar(Request $request)
    {
        
        // Crear nuevo registro en la base de datos
        $loteEnvasado = new activarHologramasModelo();
        $loteEnvasado->id_inspeccion = $request->id_inspeccion;
        $loteEnvasado->no_lote_agranel = $request->no_lote_agranel;
        $loteEnvasado->categoria = $request->categoria;
        $loteEnvasado->no_analisis = $request->no_analisis;
        $loteEnvasado->cont_neto = $request->cont_neto;
        $loteEnvasado->unidad = $request->unidad;
        $loteEnvasado->clase = $request->clase;
        $loteEnvasado->contenido = $request->contenido;
        $loteEnvasado->no_lote_envasado = $request->no_lote_envasado;
        $loteEnvasado->tipo_agave = $request->tipo_agave;
        $loteEnvasado->lugar_produccion = $request->lugar_produccion;
        $loteEnvasado->lugar_envasado = $request->lugar_envasado;
        $loteEnvasado->id_solicitud = $request->id_solicitudActivacion;

        $loteEnvasado->folios = json_encode([
            'folio_inicial' => $request->rango_inicial,
            'folio_final' => $request->rango_final // Puedes agregar otros valores también
        ]);
        //$loteEnvasado->folio_final = $request->id_solicitudActivacion;
    
        // Guardar el nuevo lote en la base de datos
        $loteEnvasado->save();
    
        // Retornar respuesta exitosa
        return response()->json(['message' => 'Hologramas activados exitosamente']);
    } 
     

    public function editActivos($id)
    {
        try {
            // Obtener los registros
            $activaciones = activarHologramasModelo::where('id_solicitud', '=', $id)->get();
    
            // Decodificar el JSON de los folios en cada registro
            $activaciones->transform(function($item) {
                $folios = json_decode($item->folios, true); // Decodifica el JSON
                $item->folio_inicial = $folios['folio_inicial'] ?? null;
                $item->folio_final = $folios['folio_final'] ?? null;
                return $item;
            });
    
            return response()->json($activaciones);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las activaciones'], 500);
        }
    }
    





    public function verificarFolios(Request $request)
{
    $folio_inicial = $request->input('folio_inicial');
    $folio_final = $request->input('folio_final');
    $id_solicitud = $request->input('id_solicitud');

    // Obtener el rango de folios de la solicitud
    $solicitud = ModelsSolicitudHolograma::where('id_solicitud', $id_solicitud)->first();

    if (!$solicitud) {
        return response()->json(['error' => 'La solicitud no existe.'], 400);
    }

    // Validar que el rango esté dentro del rango de la solicitud
    if ($folio_inicial < $solicitud->folio_inicial || $folio_final > $solicitud->folio_final) {
        return response()->json(['error' => 'El rango de folios está fuera del rango permitido por la solicitud.'], 400);
    }
        // ** Segunda Consulta: Verificar que el rango de folios no se solape con rangos existentes **
        $rangoExistente = activarHologramasModelo::where(function($query) use ($folio_inicial, $folio_final) {
            // Verificar si el nuevo rango se solapa con algún rango existente
            $query->where('folio_inicial', '<=', $folio_final)
                  ->where('folio_final', '>=', $folio_inicial);
        })->where('id_solicitud', $id_solicitud)->exists();

    
    // ** Tercera Consulta: Verificar que el nuevo rango no envuelva a los rangos existentes **
    $rangoEnvolvente = activarHologramasModelo::where(function($query) use ($folio_inicial, $folio_final) {
        // Verificar si el nuevo rango envuelve algún rango existente
        $query->where('folio_inicial', '>=', $folio_inicial)
              ->where('folio_final', '<=', $folio_final);
    })->where('id_solicitud', $id_solicitud)->exists();
    

    
    /*$sql = $query->toSql();
    $bindings = $query->getBindings();
    $rangoExistente = $query->exists();

    Log::info('Consulta SQL: ' . $sql);
    Log::info('Parámetros: ', $bindings);*/

    if ($rangoEnvolvente) {
        return response()->json(['error' => 'El rango de folios no puede envolver a otro rango ya activado.'], 400);
    }

    if ($rangoExistente) {
        return response()->json(['error' => 'Este rango de folios ya está activado.'],400);
    }

    return response()->json(['success' => 'El rango de folios está disponible.']);
}




}


