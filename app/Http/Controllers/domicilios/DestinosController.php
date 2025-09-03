<?php

namespace App\Http\Controllers\domicilios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\empresa;
use App\Models\Destinos;
use App\Models\etiquetas_destino;
use App\Notifications\GeneralNotification;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;//Permisos de empresa


class DestinosController extends Controller
{

    public function UserManagement()
    {
        $empresaId = null;

        //if (auth()->user()->tipo == 3) {
        if (Auth::check() && Auth::user()->tipo == 3) {
            //$empresaId = auth()->user()->empresa?->id_empresa;
            $empresaId = Auth::user()->empresa?->id_empresa;
        }
        $destinosQuery = Destinos::with('empresa');
        if ($empresaId) {
            $destinosQuery->where('id_empresa', $empresaId);
        }
        $destinos = $destinosQuery->get();
        $empresasQuery = empresa::where('tipo', 2);
        if ($empresaId) {
            $empresasQuery->where('id_empresa', $empresaId);
        }
        $empresas = $empresasQuery->get();
        return view('domicilios.find_domicilio_destinos_view', [
            'destinos' => $destinos,
            'empresas' => $empresas,
        ]);
    }


public function index(Request $request)
{
        $columns = [
            1 => 'id_direccion',
            2 => 'tipo_direccion',
            3 => 'id_empresa',
            4 => 'direccion',
            5 => 'destinatario',
            //6 => 'aduana',
            7 => 'pais_destino',
            8 => 'nombre_recibe',
            9 => 'correo_recibe',
            10 => 'celular_recibe',
        ];


        /*if (auth()->user()->tipo == 3) {
            $empresaId = auth()->user()->empresa?->id_empresa;
        } else {
            $empresaId = null;
        }*/
        $empresaId = Auth::user()?->tipo == 3
        ? Auth::user()->empresa?->id_empresa
        : null;
        
        // Obtener el total de registros filtrados
        $totalData = Destinos::whereHas('empresa', function ($query) use ($empresaId) {
            $query->where('tipo', 2);
            if ($empresaId) {
                $query->where('id_empresa', $empresaId);
            }
        })->count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            if (empty($request->input('search.value'))) {
                $destinos = Destinos::with('empresa')
                    ->whereHas('empresa', function ($query) use ($empresaId) {
                       $query->where('tipo', 2);
                        if ($empresaId) {
                            $query->where('id_empresa', $empresaId);
                        }

                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {///SI NO ESTA VACIO
                $search = $request->input('search.value');
                $destinos = Destinos::with('empresa')
                    ->whereHas('empresa', function ($query) use ($empresaId) {
                        $query->where('tipo', 2);
                        if ($empresaId) {
                            $query->where('id_empresa', $empresaId);
                        }
                    })
                    ->where(function ($query) use ($search) {
                        $query->whereHas('empresa', function ($q) use ($search) {
                            $q->where('razon_social', 'LIKE', "%{$search}%");
                        })
                            ->orWhere('direccion', 'LIKE', "%{$search}%")
                            ->orWhere('destinatario', 'LIKE', "%{$search}%")
                            //->orWhere('aduana', 'LIKE', "%{$search}%")
                            ->orWhere('pais_destino', 'LIKE', "%{$search}%")
                            ->orWhere('nombre_recibe', 'LIKE', "%{$search}%")
                            ->orWhere('correo_recibe', 'LIKE', "%{$search}%")
                            ->orWhere('celular_recibe', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = Destinos::with('empresa')
                    ->whereHas('empresa', function ($query) use ($empresaId) {
                        $query->where('tipo', 2);
                        if ($empresaId) {
                            $query->where('id_empresa', $empresaId);
                        }
                    })
                    ->where(function ($query) use ($search) {
                        $query->whereHas('empresa', function ($q) use ($search) {
                            $q->where('razon_social', 'LIKE', "%{$search}%");
                        })
                            ->orWhere('direccion', 'LIKE', "%{$search}%")
                            ->orWhere('destinatario', 'LIKE', "%{$search}%")
                            //->orWhere('aduana', 'LIKE', "%{$search}%")
                            ->orWhere('pais_destino', 'LIKE', "%{$search}%")
                            ->orWhere('nombre_recibe', 'LIKE', "%{$search}%")
                            ->orWhere('correo_recibe', 'LIKE', "%{$search}%")
                            ->orWhere('celular_recibe', 'LIKE', "%{$search}%");
                    })
                    ->count();
            }
/*
            $limit = $request->input('length');
            $start = $request->input('start');
            $orderColumnIndex = $request->input('order.0.column');
            $orderDirection = $request->input('order.0.dir') ?? 'desc';
            $orderColumn = $columns[$orderColumnIndex] ?? 'id_direccion';
            $search = $request->input('search.value');

            ///CONSULTA QUERY BASE
            $query = Destinos::with('empresa');

        // Filtro empresa (propia + maquiladores)
        if ($empresaId) {
            $query->where('id_empresa', $empresaId);
        }
        // Filtro por instalaciones (usuario tipo 3)
        if (!empty($instalacionAuth)) {
            $query->where('solicitudes.id_instalacion', $instalacionAuth);
        }
        // Filtro especial para usuario 49
        if (Auth::user() == 49) {
            $query->where('direcciones.tipo_direccion', 1);
        }


        $baseQuery = clone $query;// Clonamos el query antes de aplicar búsqueda, paginación u ordenamiento
        $totalData = $baseQuery->count();// totalData (sin búsqueda)


        // Búsqueda global
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('direccion', 'LIKE', "%{$search}%")
                    ->orWhere('destinatario', 'LIKE', "%{$search}%")
                    ->orWhere('aduana', 'LIKE', "%{$search}%")
                    ->orWhere('pais_destino', 'LIKE', "%{$search}%")
                    ->orWhere('nombre_recibe', 'LIKE', "%{$search}%")
                    ->orWhere('correo_recibe', 'LIKE', "%{$search}%")
                    ->orWhere('celular_recibe', 'LIKE', "%{$search}%")
                    ->orWhereHas('empresa', fn($q) => $q->where('razon_social', 'LIKE', "%{$search}%"));
            });

            $totalFiltered = $query->count();
        } else {
            $totalFiltered = $totalData;
        }


        $destinos = $query
            ->offset($start)
            ->limit($limit)
            ->orderBy($orderColumn, $orderDirection)
            ->get();
            */



            $data = [];
            // Mapea los valores de tipo_direccion a texto
            $tipoDireccionMap = [
                1 => 'Exportación',
                2 => 'Nacional',
                3 => 'Hologramas'
            ];

            if (!empty($destinos)) {
                $ids = $start;

                foreach ($destinos as $destino) {
                    $nestedData['id_direccion'] = $destino->id_direccion;
                    $nestedData['fake_id'] = ++$ids;
                    $nestedData['tipo_direccion'] = $tipoDireccionMap[$destino->tipo_direccion] ?? 'Desconocido';

                    //$nestedData['id_empresa'] = $destino->empresa->razon_social;
                    $numeroCliente =
                    $destino->empresa->empresaNumClientes[0]->numero_cliente ??
                    $destino->empresa->empresaNumClientes[1]->numero_cliente ??
                    $destino->empresa->empresaNumClientes[2]->numero_cliente;
                    $razonSocial = $destino->empresa->razon_social;
                    $nestedData['id_empresa'] = '<b>' . $numeroCliente . '</b><br>' . $razonSocial;

                    $nestedData['direccion'] = $destino->direccion;
                    $nestedData['destinatario'] = $destino->destinatario ?? 'N/A';
                    $nestedData['aduana'] = $destino->aduana ?? 'N/A';
                    $nestedData['pais_destino'] = $destino->pais_destino ?? 'N/A';
                    $nestedData['nombre_recibe'] = $destino->nombre_recibe ?? 'N/A';
                    $nestedData['correo_recibe'] = $destino->correo_recibe ?? 'N/A';
                    $nestedData['celular_recibe'] = $destino->celular_recibe ?? 'N/A';

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
            public function destroy($id_direccion)
            {
                try {
                    $destino = Destinos::findOrFail($id_direccion);
                     $destino->delete();

                     return response()->json(['success' => 'Direccion eliminada correctamente']);
                } catch (\Exception $e) {
                     return response()->json(['error' => 'Error al eliminar la dirección ' . $e->getMessage()], 500);
                 }
            }

            public function store(Request $request)
            {
                // Validar los datos del formulario
                $validated = $request->validate([
                    'tipo_direccion' => 'required|string',
                    'id_empresa' => 'required|exists:empresa,id_empresa',
                    'direccion' => 'required|string',
                    'destinatario' => 'nullable|string',
                    //'aduana' => 'nullable|string',
                    'pais_destino' => 'nullable|string',
                    'nombre_recibe' => 'nullable|string',
                    'correo_recibe' => 'nullable|email',
                    'celular_recibe' => 'nullable|string',

                    'id_etiqueta' => 'nullable|array',
                    'id_etiqueta.*' => 'exists:etiquetas,id_etiqueta',
                ]);

                // Crear una nueva instancia del modelo Predios
                $destino = new Destinos();
                $destino->tipo_direccion = $validated['tipo_direccion'];
                $destino->id_empresa = $validated['id_empresa'];
                $destino->direccion = $validated['direccion'];
                $destino->destinatario = $validated['destinatario'];
                //$destino->aduana = $validated['aduana'];
                $destino->pais_destino = $validated['pais_destino'];
                $destino->nombre_recibe = $validated['nombre_recibe'];
                $destino->correo_recibe = $validated['correo_recibe'];
                $destino->celular_recibe = $validated['celular_recibe'];



                // Guardar el nuevo predio en la base de datos
                $destino->save();
                /* dd($destino); */
                //guardado de las etiquetas
            if ($request->filled('id_etiqueta')) {
                foreach ($request->id_etiqueta as $id_etiqueta) {
                    $relacion = new etiquetas_destino();
                    $relacion->id_etiqueta = $id_etiqueta;
                    $relacion->id_direccion = $destino->id_direccion;
                    $relacion->save();
                }
            }




                // Obtener los usuarios por ID
                $users = User::whereIn('id', [18, 19, 20])->get(); // IDs de los usuarios

                // Definir el mapeo de tipo de dirección
                $tipoDireccionMap = [
                    1 => 'Para exportación',
                    2 => 'Para venta nacional',
                    3 => 'Para envío de hologramas',
                ];

                // Obtener el tipo de dirección basado en el valor de tipo_direccion
                $tipoDireccion = isset($tipoDireccionMap[$destino->tipo_direccion]) ? $tipoDireccionMap[$destino->tipo_direccion] : 'Tipo desconocido';



                // Retornar una respuesta
                return response()->json([
                    'success' => true,
                    'message' => 'Domicilio de destino registrado exitosamente',
                ]);
            }

            //funcion para llenar el campo del formulario
    public function edit($id_direccion)
    {

        try {
            $destino = Destinos::findOrFail($id_direccion);
            $etiquetas = etiquetas_destino::where('id_direccion', $id_direccion)->pluck('id_etiqueta');

            return response()->json([
            'destino' => $destino,
            'etiquetas' => $etiquetas,
        ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el domicilio de destino'], 500);
        }
    }

    public function update(Request $request, $id_direccion)
    {
        try {
            // Validar los datos del formulario
            $validated = $request->validate([
                'tipo_direccion' => 'required|string',
                'id_empresa' => 'required|exists:empresa,id_empresa',
                'direccion' => 'required|string',
                'destinatario' => 'nullable|string',
                //'aduana' => 'nullable|string',
                'pais_destino' => 'nullable|string',
                'nombre_recibe' => 'nullable|string',
                'correo_recibe' => 'nullable|email',
                'celular_recibe' => 'nullable|string',

                'id_etiqueta' => 'nullable|array',
                'id_etiqueta.*' => 'exists:etiquetas,id_etiqueta',
            ]);

            $destino = Destinos::findOrFail($id_direccion);

            // Actualizar destino
            $destino->update([
                'tipo_direccion' => $validated['tipo_direccion'],
                'id_empresa' => $validated['id_empresa'],
                'direccion' => $validated['direccion'],
                'destinatario' => $validated['destinatario'],
                //'aduana' => $validated['aduana'],
                'pais_destino' => $validated['pais_destino'],
                'nombre_recibe' => $validated['nombre_recibe'],
                'correo_recibe' => $validated['correo_recibe'],
                'celular_recibe' => $validated['celular_recibe'],
            ]);

          // Guardado de las etiquetas SOLO si vienen en la petición
          if ($request->filled('id_etiqueta')) {
              // Eliminar relaciones anteriores
              etiquetas_destino::where('id_direccion', $destino->id_direccion)->delete();

              // Insertar nuevas relaciones
              foreach ($request->id_etiqueta as $id_etiqueta) {
                  etiquetas_destino::create([
                      'id_etiqueta' => $id_etiqueta,
                      'id_direccion' => $destino->id_direccion,
                  ]);
              }
          }

            // Devolver una respuesta de éxito
            return response()->json([
                'success' => true,
                'message' => 'Destino actualizado correctamente.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
