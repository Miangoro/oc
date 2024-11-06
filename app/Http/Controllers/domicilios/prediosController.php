<?php

namespace App\Http\Controllers\domicilios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Predios;
use App\Models\empresa;
use App\Models\tipos;
use App\Models\PredioCoordenadas;
use App\Models\predio_plantacion;
use App\Models\Documentacion;
use App\Models\Documentacion_url;
use App\Models\Predios_Inspeccion;
use App\Models\estados;
use App\Models\solicitudesModel;
use App\Models\inspecciones;
use App\Models\PrediosCaracteristicasMaguey;
use App\Notifications\GeneralNotification;
use App\Models\User;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;



class PrediosController extends Controller
{
    public function UserManagement()
    {
        $predios = Predios::with('empresa')->get(); // Obtener todos los registros con la relación cargada
        $empresas = empresa::where('tipo', 2)->get(); // Obtener solo las empresas tipo '2'
        $tipos = tipos::all(); // Obtén todos los tipos de agave
        $estados = estados::all(); // Obtén todos los estados
       /*  $documentos = Documentacion::where('id_documento', '=', '34')->get(); */
        return view('domicilios.find_domicilio_predios_view', [
            'predios' => $predios, // Pasar los datos a la vista
            'empresas' => $empresas, // Pasar las empresas a la vista
            'tipos' => $tipos, // Pasar los tipos a la vista
            'estados' => $estados,
            //'documentos' => $documentos // Pasar los documentos a la vista
        ]);
    }


    public function index(Request $request)
    {
        $columns = [
            1 => 'id_predio',
            2 => 'id_empresa',
            3 => 'nombre_productor',
            4 => 'nombre_predio',
            5 => 'ubicacion_predio',
            6 => 'tipo_predio',
            7 => 'puntos_referencia',
            8 => 'cuenta_con_coordenadas',
            9 => 'superficie',
            10 => 'estatus'
        ];

        $search = [];

        // Obtener el total de registros filtrados
        $totalData = Predios::whereHas('empresa', function ($query) {
            $query->where('tipo', 2);
        })->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $predios = Predios::with('empresa') // Carga la relación
                ->whereHas('empresa', function ($query) {
                    $query->where('tipo', 2);
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $predios = Predios::with('empresa')
                ->whereHas('empresa', function ($query) {
                    $query->where('tipo', 2);
                })
                ->where(function ($query) use ($search) {
                    $query->whereHas('empresa', function ($q) use ($search) {
                        $q->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('nombre_productor', 'LIKE', "%{$search}%")
                    ->orWhere('nombre_predio', 'LIKE', "%{$search}%")
                    ->orWhere('ubicacion_predio', 'LIKE', "%{$search}%")
                    ->orWhere('tipo_predio', 'LIKE', "%{$search}%")
                    ->orWhere('puntos_referencia', 'LIKE', "%{$search}%")
                    ->orWhere('superficie', 'LIKE', "%{$search}%");
                })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Predios::with('empresa')
                ->whereHas('empresa', function ($query) {
                    $query->where('tipo', 2);
                })
                ->where(function ($query) use ($search) {
                    $query->whereHas('empresa', function ($q) use ($search) {
                        $q->where('razon_social', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('nombre_productor', 'LIKE', "%{$search}%")
                    ->orWhere('nombre_predio', 'LIKE', "%{$search}%")
                    ->orWhere('ubicacion_predio', 'LIKE', "%{$search}%")
                    ->orWhere('tipo_predio', 'LIKE', "%{$search}%")
                    ->orWhere('puntos_referencia', 'LIKE', "%{$search}%")
                    ->orWhere('superficie', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = [];

        if (!empty($predios)) {
            $ids = $start;

            foreach ($predios as $predio) {

              $hasSolicitud = $predio->solicitudes()->exists();

                $nestedData['id_predio'] = $predio->id_predio;
                $nestedData['fake_id'] = ++$ids;
                $nestedData['id_empresa'] = $predio->empresa->razon_social ?? 'N/A'; // Muestra la razón social de la empresa
                $nestedData['nombre_productor'] = $predio->nombre_productor;
                $nestedData['nombre_predio'] = $predio->nombre_predio;
                $nestedData['ubicacion_predio'] = $predio->ubicacion_predio ?? 'N/A';
                $nestedData['tipo_predio'] = $predio->tipo_predio;
                $nestedData['puntos_referencia'] = $predio->puntos_referencia  ?? 'N/A';
                $nestedData['cuenta_con_coordenadas'] = $predio->cuenta_con_coordenadas  ?? 'N/A';
                $nestedData['superficie'] = $predio->superficie;
                $nestedData['estatus']=$predio->estatus;
                $nestedData['hasSolicitud'] = $hasSolicitud;

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


        // Función para eliminar un predio
        public function destroy($id_predio)
        {
            try {
                $predio = Predios::findOrFail($id_predio);
                $predio->delete();

                return response()->json(['success' => 'Predio eliminado correctamente']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al eliminar el predio: ' . $e->getMessage()], 500);
            }
        }


        public function store(Request $request)
        {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'id_empresa' => 'required|exists:empresa,id_empresa',
                'nombre_productor' => 'required|string|max:70',
                'nombre_predio' => 'required|string',
                'ubicacion_predio' => 'nullable|string',
                'tipo_predio' => 'required|string',
                'puntos_referencia' => 'required|string',
                'tiene_coordenadas' => 'nullable|string|max:2',
                'superficie' => 'required|string',
                'url' => 'required|file|mimes:jpg,jpeg,png,pdf',
                'id_documento' => 'required|integer',
                'nombre_documento' => 'required|string|max:255'
            ]);

            // Crear una nueva instancia del modelo Predios
            $predio = new Predios();
            $predio->id_empresa = $validatedData['id_empresa'];
            $predio->nombre_productor = $validatedData['nombre_productor'];
            $predio->nombre_predio = $validatedData['nombre_predio'];
            $predio->ubicacion_predio = $validatedData['ubicacion_predio'];
            $predio->tipo_predio = $validatedData['tipo_predio'];
            $predio->puntos_referencia = $validatedData['puntos_referencia'];
            $predio->cuenta_con_coordenadas = $validatedData['tiene_coordenadas'];
            $predio->superficie = $validatedData['superficie'];

            // Guardar el nuevo predio en la base de datos
            $predio->save();

            // Solo guardar coordenadas si tiene_coordenadas es 'Si'
            if ($validatedData['tiene_coordenadas'] === 'Si') {
              if ($request->has('latitud') && $request->has('longitud')) {
                  foreach ($request->latitud as $index => $latitud) {
                      if (!is_null($latitud) && !is_null($request->longitud[$index])) {
                          PredioCoordenadas::create([
                              'id_predio' => $predio->id_predio,
                              'latitud' => $latitud,
                              'longitud' => $request->longitud[$index],
                          ]);
                      }
                  }
              }
          }
            // Almacenar los datos de plantación en la tabla predio_plantacion, si existen
            if ($request->has('id_tipo')) {
                foreach ($request->id_tipo as $index => $id_tipo) {
                    if (!is_null($id_tipo) && !is_null($request->numero_plantas[$index]) && !is_null($request->edad_plantacion[$index]) && !is_null($request->tipo_plantacion[$index])) {
                        predio_plantacion::create([
                            'id_predio' => $predio->id_predio,
                            'id_tipo' => $id_tipo,
                            'num_plantas' => $request->numero_plantas[$index],
                            'anio_plantacion' => $request->edad_plantacion[$index],
                            'tipo_plantacion' => $request->tipo_plantacion[$index],
                        ]);
                    }
                }
            }

            // Obtener el número del cliente desde la tabla empresa_num_cliente
            $empresaNumCliente = DB::table('empresa_num_cliente')
                ->where('id_empresa', $validatedData['id_empresa'])
                ->value('numero_cliente');

            if (!$empresaNumCliente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Número de cliente no encontrado para el ID de empresa proporcionado.',
                ], 404);
            }

            // Almacenar el documento si se envía
            if ($request->hasFile('url')) {
                $file = $request->file('url');

                // Generar un nombre único para el archivo
                $uniqueId = uniqid(); // Genera un identificador único
                $filename = $validatedData['nombre_documento'] . '_' . $uniqueId . '.' . $file->getClientOriginalExtension();

                // Ruta de la subcarpeta usando numero_cliente
                $directory = $empresaNumCliente;

                // Verificar y crear la carpeta si no existe
                $path = storage_path('app/public/uploads/' . $directory);
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                // Guardar el archivo en la subcarpeta
                $filePath = $file->storeAs($directory, $filename, 'public_uploads'); // Aquí se guarda en la ruta definida storage/public/uploads

                // Extraer solo el nombre del archivo para guardar en la base de datos
                $fileNameOnly = basename($filePath);

                // Crear una nueva instancia de Documentacion_url
                $documentacion_url = new Documentacion_url();
                $documentacion_url->id_empresa = $validatedData['id_empresa'];
                $documentacion_url->url = $fileNameOnly; // Almacena solo el nombre del archivo
                $documentacion_url->id_relacion = $predio->id_predio; // Aquí puedes ajustar si es necesario
                $documentacion_url->id_documento = $validatedData['id_documento'];
                $documentacion_url->nombre_documento = $validatedData['nombre_documento'];

                $documentacion_url->save();
            }
            $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

            $data1 = [
                'title' => 'Nuevo registro de predio',
                'message' => 'Se ha registrado un nuevo predio: ' . $predio->nombre_predio . '.',
                'url' => 'predios-historial',
            ];
            foreach ($users as $user) {
              $user->notify(new GeneralNotification($data1));
          }


            // Retornar una respuesta
            return response()->json([
                'success' => true,
                'message' => 'Predio registrado exitosamente',
            ]);
        }





        public function edit($id_predio)
        {
            try {
                $predio = Predios::with(['coordenadas', 'predio_plantaciones', 'documentos'])->findOrFail($id_predio);
                $tipos = tipos::all();

                // Obtener el número del cliente
                $numeroCliente = DB::table('empresa_num_cliente')
                    ->where('id_empresa', $predio->id_empresa)
                    ->value('numero_cliente');

                // Filtrar documentos para obtener solo el documento con id_documento igual a 34
                $documentos = $predio->documentos->filter(function ($documento) {
                    return $documento->id_documento == 34;
                })->map(function ($documento) {
                    return [
                        'nombre' => $documento->nombre_documento,
                        'url' => $documento->url // Solo nombre del archivo
                    ];
                });

                return response()->json([
                    'success' => true,
                    'predio' => $predio,
                    'coordenadas' => $predio->coordenadas,
                    'plantaciones' => $predio->predio_plantaciones,
                    'tipos' => $tipos,
                    'documentos' => $documentos,
                    'numeroCliente' => $numeroCliente // Incluye el número del cliente
                ]);
            } catch (ModelNotFoundException $e) {
                return response()->json(['success' => false], 404);
            }
        }

        public function update(Request $request, $id_predio)
        {
            try {


                // Validar los datos del formulario
                $validated = $request->validate([
                    'id_empresa' => 'required|exists:empresa,id_empresa',
                    'nombre_productor' => 'required|string|max:70',
                    'nombre_predio' => 'required|string',
                    'ubicacion_predio' => 'nullable|string',
                    'tipo_predio' => 'required|string',
                    'puntos_referencia' => 'required|string',
                    'tiene_coordenadas' => 'nullable|string|max:2',
                    'superficie' => 'required|string',
                    'latitud' => 'nullable|array',
                    'latitud.*' => 'nullable|numeric',
                    'longitud' => 'nullable|array',
                    'longitud.*' => 'nullable|numeric',
                    'id_tipo' => 'nullable|array',
                    'id_tipo.*' => 'required|exists:catalogo_tipo_agave,id_tipo',
                    'numero_plantas' => 'required|array',
                    'numero_plantas.*' => 'required|numeric',
                    'edad_plantacion' => 'required|array',
                    'edad_plantacion.*' => 'required|numeric',
                    'tipo_plantacion' => 'required|array',
                    'tipo_plantacion.*' => 'required|string',
                    'url' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                    'id_documento' => 'required|integer',
                    'nombre_documento' => 'required|string|max:255'
                ]);

                $predio = Predios::findOrFail($id_predio);

                // Obtener el documento actual
                $documentacion_url = Documentacion_url::where('id_relacion', $predio->id_predio)
                    ->where('id_documento', $validated['id_documento'])
                    ->first();

                $oldFileName = $documentacion_url ? $documentacion_url->url : null;

                // Si se carga un nuevo archivo
                if ($request->hasFile('url')) {
                    $file = $request->file('url');

                    // Generar un nombre único para el archivo
                    $uniqueId = uniqid();
                    $filename = $validated['nombre_documento'] . '_' . $uniqueId . '.' . $file->getClientOriginalExtension();

                    // Ruta de la subcarpeta usando numero_cliente
                    $empresaNumCliente = DB::table('empresa_num_cliente')
                        ->where('id_empresa', $validated['id_empresa'])
                        ->value('numero_cliente');
                    $directory = $empresaNumCliente;

                    // Guardar el nuevo archivo
                    $filePath = $file->storeAs($directory, $filename, 'public_uploads');

                    // Actualizar el registro en la base de datos
                    if ($documentacion_url) {
                        $documentacion_url->url = basename($filePath);
                        $documentacion_url->nombre_documento = $validated['nombre_documento'];
                        $documentacion_url->save();
                    } else {
                        // Si no existe registro, crear uno nuevo
                        Documentacion_url::create([
                            'id_empresa' => $validated['id_empresa'],
                            'url' => basename($filePath),
                            'id_relacion' => $predio->id_predio,
                            'id_documento' => $validated['id_documento'],
                            'nombre_documento' => $validated['nombre_documento'],
                        ]);
                    }

                    // Eliminar el archivo anterior
                    if ($oldFileName) {
                        $oldFilePath = storage_path('app/public/uploads/' . $empresaNumCliente . '/' . $oldFileName);
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                }
  

                // Actualizar los demás datos del predio
                $predio->update([
                    'id_empresa' => $validated['id_empresa'],
                    'nombre_productor' => $validated['nombre_productor'],
                    'nombre_predio' => $validated['nombre_predio'],
                    'ubicacion_predio' => $validated['ubicacion_predio'],
                    'tipo_predio' => $validated['tipo_predio'],
                    'puntos_referencia' => $validated['puntos_referencia'],
                    'cuenta_con_coordenadas' => $validated['tiene_coordenadas'],
                    'superficie' => $validated['superficie'],
                ]);

                // Manejar coordenadas
                if ($validated['tiene_coordenadas'] == 'Si') {
                    // Eliminar coordenadas antiguas
                    $predio->coordenadas()->delete();

                    // Agregar nuevas coordenadas
                    if (!empty($validated['latitud']) && !empty($validated['longitud'])) {
                        foreach ($validated['latitud'] as $index => $latitud) {
                            $predio->coordenadas()->create([
                                'latitud' => $latitud,
                                'longitud' => $validated['longitud'][$index],
                            ]);
                        }
                    }
                } else {
                    // Si no se tienen coordenadas, elimina las coordenadas existentes
                    $predio->coordenadas()->delete();
                }

                // Manejar plantaciones
                // Manejar plantaciones
                if (!empty($validated['id_tipo'])) {
                    // Eliminar plantaciones antiguas
                    $predio->predio_plantaciones()->delete();

                    // Agregar nuevas plantaciones
                    foreach ($validated['id_tipo'] as $index => $tipo) {
                        // Asegúrate de que todos los datos necesarios estén presentes
                        $numeroPlantas = isset($validated['numero_plantas'][$index]) ? $validated['numero_plantas'][$index] : null;
                        $edadPlantacion = isset($validated['edad_plantacion'][$index]) ? $validated['edad_plantacion'][$index] : null;
                        $tipoPlantacion = isset($validated['tipo_plantacion'][$index]) ? $validated['tipo_plantacion'][$index] : null;

                        // Asegúrate de que el campo 'numero_plantas' sea manejado adecuadamente
                        $predio->predio_plantaciones()->create([
                            'id_tipo' => $tipo,
                            'num_plantas' => $numeroPlantas,
                            'anio_plantacion' => $edadPlantacion,
                            'tipo_plantacion' => $tipoPlantacion,
                        ]);
                    }
                } else {
                    // Si no se tienen plantaciones, elimina las plantaciones existentes
                    $predio->predio_plantaciones()->delete();
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Predio actualizado exitosamente',
                ]);
            } catch (\Exception $e) {
                Log::error('Error al actualizar el predio: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el predio: ' . $e->getMessage(),
                ], 500);
            }
        }



        public function PdfPreRegistroPredios($id_predio)
        {

            $datos = Predios::with(['predio_plantaciones.tipo','empresa.empresaNumClientes'])->find($id_predio);
            $comunal = '___';
            $ejidal = '___';
            $propiedad = '___';
            $otro = '___';

            switch ($datos->tipo_predio) {
                case 'Comunal':
                    $comunal = 'X';
                    break;
                case 'Ejidal':
                    $ejidal = 'X';
                    break;
                case 'Propiedad Privada':
                    $propiedad = 'X';
                    break;
                case 'Otro':
                    $otro = 'X';
                    break;
            }


            $pdf = Pdf::loadView('pdfs.Pre-registro_predios', ['datos'=>$datos, 'comunal' => $comunal, 'ejidal' => $ejidal, 'propiedad' => $propiedad, 'otro' => $otro]);
            return $pdf->stream('F-UV-21-01 Pre-registro de predios de maguey o agave Ed.1 Vigente.pdf');
        }

    /* Registro de predio inspección */
    public function inspeccion(Request $request, $id_predio)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'ubicacion_predio' => 'required|string|max:255',
            'localidad' => 'required|string|max:255',
            'municipio' => 'required|string|max:255',
            'distrito' => 'required|string|max:255',
            'estado' => 'required|exists:estados,id',
            'nombre_paraje' => 'required|string|max:255',
            'zona_dom' => 'required|string|in:si,no',
            'marco_plantacion' => 'required|numeric',
            'distancia_surcos' => 'required|numeric',
            'distancia_plantas' => 'required|numeric',
            'tiene_coordenadas' => 'required|string|max:2',
            'superficie' => 'required|numeric',
            'latitud' => 'nullable|array',
            'longitud' => 'nullable|array',
            'id_tipo' => 'nullable|array',
            'numero_plantas' => 'nullable|array',
            'edad_plantacion' => 'nullable|array',
            'tipo_plantacion' => 'nullable|array',
            'no_planta' => 'nullable|array',
            'altura' => 'nullable|array',
            'diametro' => 'nullable|array',
            'numero_hojas' => 'nullable|array',

            'id_empresa' => 'required|exists:empresa,id_empresa', // Asegúrate de validar id_empresa
            'titulo_foto.*' => 'required|string|max:255', // Títulos de las fotos
            'fotografias_inspeccion' => 'sometimes|array', // Para las fotos, si existen
            'fotografias_inspeccion.*' => 'image|mimes:jpeg,png,jpg,gif' // Validación de imágenes
        ]);

        // Crear una nueva instancia del modelo Predios_Inspeccion
        $inspeccion = new Predios_Inspeccion();
        $inspeccion->id_predio = $id_predio;
        $inspeccion->ubicacion_predio = $validatedData['ubicacion_predio'];
        $inspeccion->localidad = $validatedData['localidad'];
        $inspeccion->municipio = $validatedData['municipio'];
        $inspeccion->distrito = $validatedData['distrito'];
        $inspeccion->id_estado = $validatedData['estado'];
        $inspeccion->nombre_paraje = $validatedData['nombre_paraje'];
        $inspeccion->zona_dom = $validatedData['zona_dom'];
        $inspeccion->marco_plantacion = $validatedData['marco_plantacion'];
        $inspeccion->distancia_surcos = $validatedData['distancia_surcos'];
        $inspeccion->distancia_plantas = $validatedData['distancia_plantas'];
        $inspeccion->superficie = $validatedData['superficie'];

        // Guardar el nuevo registro de inspección en la base de datos
        $inspeccion->save();

                // Recuperar el predio
        $predio = Predios::findOrFail($id_predio);

        // Cambiar el estatus a 'Inspeccionado'
        $predio->estatus = 'Inspeccionado';

        // Guardar los cambios en el predio
        $predio->save();


        // Solo guardar coordenadas si tiene_coordenadas es 'Si'
        if ($validatedData['tiene_coordenadas'] === 'Si') {
            if ($request->has('latitud') && $request->has('longitud')) {
                foreach ($request->latitud as $index => $latitud) {
                    if (!is_null($latitud) && !is_null($request->longitud[$index])) {
                        PredioCoordenadas::create([
                           /*  'id_predio' => $id_predio, */
                            'id_inspeccion' => $inspeccion->id_inspeccion,
                            'latitud' => $latitud,
                            'longitud' => $request->longitud[$index],
                        ]);
                    }
                }
            }
        }

        // Guardar plantaciones, si existen y no son nulas
        if ($request->has('id_tipo')) {
            foreach ($request->id_tipo as $index => $id_tipo) {
                if (!is_null($id_tipo) && !is_null($request->numero_plantas[$index]) && !is_null($request->edad_plantacion[$index]) && !is_null($request->tipo_plantacion[$index])) {
                    predio_plantacion::create([
                        /* 'id_predio' => $id_predio, */
                        'id_inspeccion' => $inspeccion->id_inspeccion,
                        'id_tipo' => $id_tipo,
                        'num_plantas' => $request->numero_plantas[$index],
                        'anio_plantacion' => $request->edad_plantacion[$index],
                        'tipo_plantacion' => $request->tipo_plantacion[$index],
                    ]);
                }
            }
        }

        // Guardar características, si existen y no son nulas
        if ($request->has('no_planta')) {
            foreach ($request->no_planta as $index => $no_planta) {
                if (!is_null($no_planta) && !is_null($request->altura[$index]) && !is_null($request->diametro[$index]) && !is_null($request->numero_hojas[$index])) {
                    PrediosCaracteristicasMaguey::create([
                        'id_predio' => $id_predio,
                        'id_inspeccion' => $inspeccion->id_inspeccion,
                        'no_planta' => $no_planta,
                        'altura' => $request->altura[$index],
                        'diametro' => $request->diametro[$index],
                        'numero_hojas' => $request->numero_hojas[$index],
                    ]);
                }
            }
        }

        // Obtener el número del cliente
        $empresaNumCliente = DB::table('empresa_num_cliente')
            ->where('id_empresa', $validatedData['id_empresa'])
            ->value('numero_cliente');

        if (!$empresaNumCliente) {
            return response()->json([
                'success' => false,
                'message' => 'Número de cliente no encontrado para el ID de empresa proporcionado.',
            ], 404);
        }

        // Obtener el nombre del documento donde id_documento es 70
        $nombreDocumento = DB::table('documentacion')
            ->where('id_documento', 70)
            ->value('nombre');

        if (!$nombreDocumento) {
            return response()->json([
                'success' => false,
                'message' => 'Nombre del documento no encontrado para el ID de documento 70.',
            ], 404);
        }

        // Almacenar archivos si se envían
        if ($request->hasFile('fotografias_inspeccion')) {
            foreach ($request->file('fotografias_inspeccion') as $index => $file) {
                if ($file->isValid()) {
                    // Generar un nombre único para el archivo
                    $uniqueId = uniqid();
                    $filename = $validatedData['titulo_foto'][$index] . '_' . $uniqueId . '.' . $file->getClientOriginalExtension();

                    // Crear una carpeta con el número de cliente
                    $directory = $empresaNumCliente; // Utiliza el número de cliente
                    $path = storage_path('app/public/uploads/inspecciones/' . $directory);

                    // Verificar si la carpeta existe, si no, crearla
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    // Guardar el archivo en la carpeta correspondiente
                    $filePath = $file->storeAs('uploads/inspecciones/' . $directory, $filename, 'public');

                    // Crear una nueva instancia del modelo para guardar la ruta del archivo
                    $documentacion_url = new Documentacion_url();
                    $documentacion_url->id_empresa = $validatedData['id_empresa']; // Asegúrate de que este campo esté en tu validación
                    $documentacion_url->url = $validatedData['titulo_foto'][$index]; // Almacena el título de la foto como el nombre
                    $documentacion_url->id_relacion = $inspeccion->id_inspeccion; // Relacionar con la inspección
                    $documentacion_url->nombre_documento = $nombreDocumento; // Usar el nombre del documento obtenido

                    // Asignar el id_documento como 70
                    $documentacion_url->id_documento = 70; // Agrega esta línea

                    // Guardar el registro
                    $documentacion_url->save();
                }
            }
        }


        // Notificación y retorno de respuesta
        $predio = Predios::find($id_predio);
        $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

        $data1 = [
            'title' => 'Nuevo registro de inspección de predio',
            'message' => 'Se ha registrado una nueva inspección en el predio: ' . $predio->nombre_predio . ', con la orden de servicio ' . $inspeccion->no_orden_servicio,
            'url' => 'inspecciones-historial',
        ];

        foreach ($users as $user) {
            $user->notify(new GeneralNotification($data1));
        }

        // Retornar una respuesta exitosa
        return response()->json([
            'success' => true,
            'message' => 'Inspección registrada exitosamente.',
        ]);
    }

    public function PDFInspeccionGeoreferenciacion($id_predio) {
      // Obtener la primera (y única) inspección relacionada con el predio
      $inspeccion = Predios_Inspeccion::where('id_predio', $id_predio)->first();

/*       if (!$inspeccion) {
          // Manejo de errores si no se encuentra la inspección
          return response()->json(['error' => 'No se encontró la inspección para este predio.'], 404);
      } */
      $predio = Predios::with(['empresa', 'empresa.empresaNumClientes'])->find($id_predio);

      // Obtener la solicitud relacionada a partir del id_predio
      $solicitud = solicitudesModel::where('id_predio', $id_predio)->first();
      // Obtener la inspección relacionada a partir del id_solicitud de la solicitud
      $inspeccionData = inspecciones::where('id_solicitud', $solicitud->id_solicitud)->first();

      // Obtener todas las coordenadas relacionadas con la inspección
      $coordenadas = PredioCoordenadas::where('id_inspeccion', $inspeccion->id_inspeccion)->get();
      $caracteristicas = PrediosCaracteristicasMaguey::where('id_inspeccion', $inspeccion->id_inspeccion)->get();
      $plantacion = predio_plantacion::where('id_inspeccion', $inspeccion->id_inspeccion)->get();

      // Cargar la vista PDF con la inspección y las coordenadas
      $pdf = Pdf::loadView('pdfs.inspeccion_geo_referenciacion', [
          'inspeccion' => $inspeccion,
          'solicitud' => $solicitud, // Pasar la solicitud
          'inspeccionData' => $inspeccionData, // Pasar la inspección relacionada
          'coordenadas' => $coordenadas,
          'caracteristicas' => $caracteristicas,
          'plantacion' => $plantacion,
          'predio' => $predio,
              ]);

      // Generar y retornar el PDF
      return $pdf->stream('Registro de Predios Maguey Agave.pdf');
  }


    public function PDFRegistroPredios($id_predio) {
      $inspeccion = Predios_Inspeccion::where('id_predio', $id_predio)->first();
      $predio = Predios::with(['empresa', 'empresa.empresaNumClientes'])->find($id_predio);
      $vigencia = Helpers::formatearFecha($inspeccion->predio->fecha_vigencia);
      $emision = Helpers::formatearFecha($inspeccion->predio->fecha_emision);
    // Obtener la solicitud relacionada a partir del id_predio
    $solicitud = solicitudesModel::where('id_predio', $id_predio)->first();
    // Obtener la inspección relacionada a partir del id_solicitud de la solicitud
    $inspeccionData = inspecciones::where('id_solicitud', $solicitud->id_solicitud)->first();

    // Obtener todas las coordenadas relacionadas con la inspección
    $coordenadas = PredioCoordenadas::where('id_inspeccion', $inspeccion->id_inspeccion)->get();
    $caracteristicas = PrediosCaracteristicasMaguey::where('id_inspeccion', $inspeccion->id_inspeccion)->get();
    $plantacion = predio_plantacion::where('id_inspeccion', $inspeccion->id_inspeccion)->get();

      $pdf = Pdf::loadView('pdfs.Registro_de_Predios_Maguey_Agave' , [
          'inspeccion' => $inspeccion,
          'vigencia' => $vigencia,
          'emision' => $emision,
          'inspeccionData' => $inspeccionData, // Pasar la inspección relacionada
          'predio' => $predio,
          'solicitud' => $solicitud, // Pasar la solicitud
          'coordenadas' => $coordenadas,
          'caracteristicas' => $caracteristicas,
          'plantacion' => $plantacion,
      ] );
      return $pdf->stream('F-UV-21-03 Registro de predios de maguey o agave Ed. 4 Vigente.pdf');
    }

  public function registroPredio(Request $request, $id_predio)
  {
      try {
          // Validar los datos del formulario
          $validated = $request->validate([
              'num_predio' => 'required|string',
              'fecha_emision' => 'required|date',
              'fecha_vigencia' => 'required|date',
          ]);

          $predio = Predios::findOrFail($id_predio);

          // Actualizar los datos del predio, incluyendo el estatus
          $predio->update([
              'num_predio' => $validated['num_predio'],
              'fecha_emision' => $validated['fecha_emision'],
              'fecha_vigencia' => $validated['fecha_vigencia'],
              'estatus' => 'Completado'
          ]);

          return response()->json([
              'success' => true,
              'message' => 'Predio registrado exitosamente',
          ]);
      } catch (\Exception $e) {
          return response()->json([
              'success' => false,
              'message' => 'Error al actualizar el predio: ' . $e->getMessage(),
          ], 500);
      }

  }



  public function pdf_solicitud_servicios_070($id_predio)
  {
      // Busca la solicitud que tiene el id_predio proporcionado
    $datos = solicitudesModel::where('id_predio', $id_predio)->first();
       // Inicializa las variables con un valor vacío
    $muestreo_agave = '------------';
    $vigilancia_produccion = '------------';
    $muestreo_granel= '------------';
    $vigilancia_traslado= '------------';
    $inspeccion_envasado= '------------';
    $muestreo_envasado= '------------';
    $ingreso_barrica= '------------';
    $liberacion= '------------';
    $liberacion_barrica= '------------';
    $geo= '------------';
    $exportacion= '------------';
    $certificado_granel= '------------';
    $certificado_nacional= '------------';
    $dictaminacion = '------------';
    $renovacion_dictaminacion = '------------';
    // Verificar el valor de id_tipo y marcar la opción correspondiente
    if ($datos->id_tipo == 1) {
        $muestreo_agave = 'X';
    }
    if ($datos->id_tipo == 2) {
        $vigilancia_produccion = 'X';
    }
    if ($datos->id_tipo == 3) {
        $muestreo_granel= 'X';
    }
    if ($datos->id_tipo == 4) {
        $vigilancia_traslado= 'X';
    }
    if ($datos->id_tipo == 5) {
        $inspeccion_envasado= 'X';
    }
    if ($datos->id_tipo == 6) {
        $muestreo_envasado= 'X';
    }
    if ($datos->id_tipo == 7) {
        $ingreso_barrica= 'X';
    }
    if ($datos->id_tipo == 8) {
        $liberacion= 'X';
    }
    if ($datos->id_tipo == 9) {
        $liberacion_barrica= 'X';
    }
    if ($datos->id_tipo == 10) {
        $geo= 'X';
    }
    if ($datos->id_tipo == 11) {
        $exportacion= 'X';
    }
    if ($datos->id_tipo == 12) {
        $certificado_granel= 'X';
    }
    if ($datos->id_tipo == 13) {
        $certificado_nacional= 'X';
    }
    if ($datos->id_tipo == 14) {
        $dictaminacion = 'X';
    }
    if ($datos->id_tipo == 15) {
        $renovacion_dictaminacion = 'X';
    }
        $pdf = Pdf::loadView('pdfs.SolicitudDeServicio', compact('datos','muestreo_agave','vigilancia_produccion','dictaminacion','muestreo_granel',
        'vigilancia_traslado','inspeccion_envasado','muestreo_envasado','ingreso_barrica','liberacion','liberacion_barrica','geo','exportacion','certificado_granel','certificado_nacional','dictaminacion','renovacion_dictaminacion'))
        ->setPaper([0, 0, 640, 830]); ;
        return $pdf->stream('Solicitud de servicios NOM-070-SCFI-2016 F7.1-01-32 Ed10 VIGENTE.pdf');
    }




}
