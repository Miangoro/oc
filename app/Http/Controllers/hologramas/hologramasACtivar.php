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
use App\Models\clases;
use App\Models\Documentacion_url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class hologramasActivar extends Controller
{
    public function find_hologramas_activar()
    {
        $Empresa = Empresa::with('empresaNumClientes')->where('tipo', 2)->get();
        $inspeccion = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 5)->Orwhere('id_tipo', 6)->Orwhere('id_tipo', 11)->Orwhere('id_tipo', 8);
        })
        ->orderBy('id_inspeccion', 'desc')
        ->get();
        $categorias = categorias::all();
        $tipos = tipos::all();
        $clases = clases::all();

        $ModelsSolicitudHolograma = ModelsSolicitudHolograma::all();
        $userCount = $ModelsSolicitudHolograma->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('hologramas.find_activar_hologramas_view', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'Empresa' => $Empresa,
            'ModelsSolicitudHolograma' => $ModelsSolicitudHolograma,
            'inspeccion' => $inspeccion,
            'categorias' => $categorias,
            'tipos' => $tipos,
            'clases' => $clases,
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

        $query = ModelsSolicitudHolograma::with(['empresa.empresaNumClientes', 'user', 'marcas']);

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('estatus', 'LIKE', "%{$searchValue}%")
                    ->orWhere('folio', 'LIKE', "%{$searchValue}%")
                    ->orWhere('id_empresa', 'LIKE', "%{$searchValue}%");

                $q->orWhereHas('empresa', function ($Nombre) use ($searchValue) {
                    $Nombre->where('razon_social', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('empresa.empresaNumClientes', function ($q) use ($searchValue) {
                    $q->where('numero_cliente', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('user', function ($Solicitante) use ($searchValue) {
                    $Solicitante->where('name', 'LIKE', "%{$searchValue}%");
                });

                $q->orWhereHas('marcas', function ($Marca) use ($searchValue) {
                    $Marca->where('marca', 'LIKE', "%{$searchValue}%");
                });
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
                $numero_cliente = \App\Models\empresaNumCliente::where('id_empresa', $user->id_empresa)->value('numero_cliente');
                $marca = \App\Models\marcas::where('id_marca', $user->id_marca)->value('marca');
                $direccion = \App\Models\direcciones::where('id_direccion', $user->id_direccion)->value('direccion');
                $name = \App\Models\User::where('id', $user->id_solicitante)->value('name');
        
                $razon_social = $user->empresa ? $user->empresa->razon_social : '';
        
                // Concatenar razon_social y numero_cliente
                $razonSocialFormatted = '<b>' . $numero_cliente . '</b><br>' . $razon_social;
        
                $nestedData = [
                    'fake_id' => ++$ids,
                    'id_solicitud' => $user->id_solicitud,
                    'folio' => $user->folio,
                    'id_empresa' => $user->id_empresa,
                    'id_solicitante' => $name,
                    'id_marca' => $marca, 
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
                    'activados' => $user->cantidadActivados($user->id_solicitud),
                    'restantes' => max(0, ($user->cantidad_hologramas - $user->cantidadActivados($user->id_solicitud) - $user->cantidadMermas($user->id_solicitud))),
                    'mermas' => $user->cantidadMermas($user->id_solicitud),
                    'razon_social' => $razonSocialFormatted, // Aquí asignamos la clave correctamente
                    'razon_social_pdf' => $user->empresa ? $user->empresa->razon_social : '',
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


    public function activarHologramas(Request $request)
{
    $solicitudes = $request->input('solicitudes'); // Array de solicitudes involucradas
    $folios = $request->input('folios'); // Array de folios seleccionados

    // Convertimos las cadenas en arrays (si es necesario)
    if (!is_array($solicitudes)) {
        $solicitudes = explode(',', $solicitudes);
    }
    if (!is_array($folios)) {
        $folios = explode(',', $folios);
    }

    // Activamos los hologramas
    $activarHologramas = new activarHologramasModelo();
    $activarHologramas->activarHologramasDesdeVariasSolicitudes($solicitudes, $folios);

    return response()->json(['message' => 'Hologramas activados correctamente']);
}


public function getDatosInpeccion($id_inspeccion){

    $datos = inspecciones::with('solicitud.lote_envasado')->find($id_inspeccion);

    $numeroCliente = $datos->solicitud->empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
      return !empty($numero);
  });
    $datos->url_acta = $datos->solicitud->documentacion(69)->pluck('url')->toArray();
    $datos->numero_cliente = $numeroCliente;
    return response()->json($datos); // Retorna en formato JSON
}


    

    
}
