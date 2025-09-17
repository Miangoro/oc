<?php

namespace App\Http\Controllers\Tramite_impi;

use App\Http\Controllers\Controller;
use App\Helpers\Helpers;
use Illuminate\Http\Request;

use App\Models\Impi;
use App\Models\Impi_evento;
use App\Models\empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class impiController extends Controller
{

    public function UserManagement()
    {
      $tramites = Impi::all();
      $empresas = empresa::with('empresaNumClientes')->where('tipo', 2)->get();
      $evento = Impi_evento::all();

      return view('Tramite_impi.find_impi', compact('tramites', 'empresas'));
    }

    // Método para mostrar la vista principal de trámites
    public function index(Request $request)
    {
        $columns = [
        //CAMPOS PARA ORDENAR LA TABLA DE INICIO "thead"
            //1 => 'id_impi',
            1 => 'folio',
            2 => 'fecha_solicitud',
            3 => 'id_empresa',
            4 => 'tramite',
            5 => 'contrasena',
            6 => 'pago',
            7 => '',
            8 => 'observaciones',
            9 => 'estatus'
        ];

    $search = [];

    $totalData = Impi::count();
    $totalFiltered = $totalData;

    $limit = $request->input('length');
    $start = $request->input('start');
    $order = $columns[$request->input('order.0.column')];
    $dir = $request->input('order.0.dir');

    $search1 = $request->input('search.value');

      if (empty($request->input('search.value'))) {
        //ORDENAR EL BUSCADOR "thead"
        //$users = Impi::where("nombre", 2)->offset($start)
        $impi = Impi::where('id_impi', 'LIKE', "%{$request->input('search.value')}%")
          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();

      } else {
        //BUSCADOR
        $search = $request->input('search.value');
        /*$impi = Impi::where('id_impi', 'LIKE', "%{$search}%")
          ->where("nombre", 1)
          ->orWhere('tramite', 'LIKE', "%{$search}%")

          ->offset($start)
          ->limit($limit)
          ->orderBy($order, $dir)
          ->get();*/
        //Definimos el nombre al valor de "Estatus"
        $map = [
            'Pendiente' => 1,
            'Tramite' => 2,
            'Tramite favorable' => 3,
            'Tramite no favorable' => 4,
            ];

    // Verificar si la búsqueda es uno de los valores mapeados
        $searchValue = strtolower(trim($search)); //minusculas
        $searchType = null;

    // Si el término es valor conocido, asignamos el valor corres
        if (isset($map[$searchValue])) {
            $searchType = $map[$searchValue];
        }

    // Consulta con filtros
        $query = Impi::where('id_impi', 'LIKE', "%{$search}%")
        ->where("id_impi", 1)
        ->orWhere('tramite', 'LIKE', "%{$search}%");

    // Si se proporciona un tipo_dictamen válido, filtramos
        if ($searchType !== null) {
            $query->where('estatus',  'LIKE', "%{$searchType}%");
        } else {
    // Si no se busca por tipo_dictamen, buscamos por otros campos
            $query->where('id_impi', 'LIKE', "%{$search}%")
                ->orWhere('tramite', 'LIKE', "%{$search}%")
                ->orWhere('fecha_solicitud', 'LIKE', "%{$search}%");
        }
        $impi = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = Impi::where('id_impi', 'LIKE', "%{$search}%")
          ->where("id_impi", 1)
          ->orWhere('tramite', 'LIKE', "%{$search}%")
          ->orWhere('estatus', 'LIKE', "%{$search}%")
          ->count();
      }

      $data = [];


        if (!empty($impi)) {
            $ids = $start;

            foreach ($impi as $impi) {
            //MANDA LOS DATOS AL JS
                //$nestedData['fake_id'] = ++$ids;
                $nestedData['id_impi'] = $impi->id_impi ?? '';
                $nestedData['folio'] = $impi->folio ?? '';
                //$nestedData['fecha_solicitud'] = $impi->fecha_solicitud;
                //$nestedData['fecha_solicitud'] = Helpers::formatearFechaHora($impi->fecha_solicitud) ?? 'N/A';
                $nestedData['fecha_solicitud'] = Helpers::formatearFecha($impi->fecha_solicitud) ?? '';
                $nestedData['id_empresa'] = $impi->id_empresa ?? '';
                $nestedData['tramite'] = $impi->tramite ?? '';
                $nestedData['contrasena'] = $impi->contrasena ?? '';
                $nestedData['pago'] = $impi->pago ?? '';
                $nestedData['observaciones'] = $impi->observaciones ?? '';
                $nestedData['estatus'] = $impi->estatus ?? '';
                //empresa y folio
                $empresa = $dictamen->inspeccione->solicitud->empresa ?? null;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                    ? $empresa->empresaNumClientes->first(fn($item) => $item->empresa_id === $empresa
                    ->id && !empty($item->numero_cliente))?->numero_cliente ?? 'No encontrado' : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['razon_social'] = $dictamen->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';
                $nestedData['razon_social'] = '<b>'.$numero_cliente . '</b> <br>' . $empresa;
                //telefono y correo
                $tel = $impi->empresa->telefono ?? '';
                $email = $impi->empresa->correo ?? '';
                $nestedData['contacto'] = '<b>Teléfono: </b>' .$tel. '<br> <b>Correo: </b>' .$email;

                $data[] = $nestedData;
      }
    }

    if ($data) {
      return response()->json([
        'draw' => intval($request->input('draw')),
        'recordsTotal' => intval($totalData),
        'recordsFiltered' => intval($totalFiltered),
        'code' => 200,
        'data' => $data,
      ]);
    } else {
      return response()->json([
        'message' => 'Internal Server Error',
        'code' => 500,
        'data' => [],
      ]);
    }
}




///FUNCION PARA REGISTRAR
public function store(Request $request)
{
    // Obtén el último registro para el folio
    /*$lastRecord = Impi::orderBy('folio', 'desc')// Ordena por folio de forma descendente
        ->first();
    // Si hay registro previo
    if ( !empty($lastRecord) ) {
        // Extrae el número del folio y suma 1
        preg_match('/-(\d+)$/', $lastRecord->folio, $matches);
        $nextFolioNumber = (int)$matches[1] + 1;
    } else {
        // Si no hay registros previos
        $nextFolioNumber = 1;
    }

    // Genera el folio
    $newFolio = 'TRÁMITE-' . str_pad($nextFolioNumber, 4, '0', STR_PAD_LEFT);*/
        $year = date('y'); // Últimos dos dígitos del año

        // Buscar el último registro de este año
        $lastRecord = Impi::where('folio', 'like', "TRÁMITE-$year-%")
            ->orderBy('id_impi', 'desc')
            ->first();

        if ($lastRecord) {
            preg_match('/-(\d+)$/', $lastRecord->folio, $matches);
            $nextNumber = (int) $matches[1] + 1;
        } else {
            $nextNumber = 1;
        }

        $newFolio = "TRÁMITE-$year-" . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $var = new Impi();
        $var->folio = $newFolio;
        $var->fecha_solicitud = $request->fecha_solicitud;
        $var->id_empresa = $request->id_empresa;
        $var->tramite = $request->tramite;
        $var->contrasena = $request->contrasena;
        $var->pago = $request->pago;
        $var->observaciones = $request->observaciones;
        $var->estatus = $request->estatus;
        $var->id_usuario_registro = Auth::id();  // o auth()->id()
        $var->save();//guardar en BD

        return response()->json(['success' => 'Registro agregado correctamente']);


    //EVENTO
    /*
        $var1 = new Impi_evento();
        $var1->evento = $request2->evento;
        $var1->descripcion = $request2->descripcion;
        $var1->save();

        return response()->json(['success' => 'Registro agregado correctamente22']);
    */
}



///FUNCION PARA ELIMINAR
public function destroy($id_impi)
{
    $eliminar = Impi::findOrFail($id_impi);
    $eliminar->delete();

    return response()->json(['success' => 'Eliminado correctamente']);
}



///FUNCION PARA OBTENER DATOS
public function edit($id_impi)
{
    $var1 = Impi::findOrFail($id_impi);
    //$categorias = json_decode($var1->categorias);  //Convertir array
    //return response()->json($var1);
    return response()->json([
        'id_impi' => $var1->id_impi,
        'tramite' => $var1->tramite,
        'fecha_solicitud' => $var1->fecha_solicitud,
        'id_empresa' => $var1->id_empresa,
        'contrasena' => $var1->contrasena,
        'pago' => $var1->pago,
        'estatus' => $var1->estatus,
        'observaciones' => $var1->observaciones,
        //'categorias' => $categorias,
    ]);
}

///FUNCION PARA ACTUALIZAR
public function update(Request $request, $id_impi)
{
    $var2 = Impi::findOrFail($id_impi);
    //$var2->id_impi = $request->id_impi;
    $var2->tramite = $request->tramite;
    $var2->fecha_solicitud = $request->fecha_solicitud;
    $var2->id_empresa = $request->id_empresa;
    $var2->contrasena = $request->contrasena;
    $var2->pago = $request->pago;
    $var2->estatus = $request->estatus;
    $var2->observaciones = $request->observaciones;
    $var2->save();

    return response()->json(['success' => 'Actualizado correctamente']);
}



///FUNCION PARA REGISTRAR
public function evento(Request $request)
{
    $validated = $request->validate([
        'id_impi' => 'required|exists:tramite_impi,id_impi',
        'evento' => 'required|string',
        'descripcion' => 'required|string',
        'url_anexo' => 'nullable|mimes:pdf|max:3072',
    ]);

    $impi = Impi::findOrFail($validated['id_impi']);
    /* $empresa = Empresa::with("empresaNumClientes")
                ->where("id_empresa", $impi->id_empresa)
                ->first();

    $numeroCliente = $empresa->empresaNumClientes
                    ->pluck('numero_cliente')
                    ->first(function ($numero) {
                        return !empty($numero);
                    }); */

    $url_anexo = null;
    if ($request->hasFile('url_anexo')) {
        $nombreArchivo = $impi->folio.'_'. uniqid() .'.pdf';
        $rutaCarpeta = "public/tramites_impi";
        Storage::putFileAs($rutaCarpeta, $request->file('url_anexo'), $nombreArchivo);

        $url_anexo = "$nombreArchivo";
    }

    // Guardar evento
    $evento = new Impi_evento();
    $evento->id_impi = $validated['id_impi'];
    $evento->evento = $validated['evento'];
    $evento->descripcion = $validated['descripcion'];
    $evento->url_anexo = $url_anexo;
    $evento->save();

    // Actualizar estatus en tramite_impi
    $impi->estatus = $request->estatus;
    $impi->save();

    return response()->json(['success' => 'Evento registrado correctamente']);
}



///FUNCION PARA TRAZABILIDAD

public function tracking($id)
{
    $var1 = Impi_evento::where('id_impi', $id)
    /*return response()->json([
        'id_impi' => $var1->id_impi,
        'evento' => $var1->evento,
        'descripcion' => $var1->descripcion,
        'url_anexo' => $var1->url_anexo,
    ]);*/
    ->orderBy('created_at', 'asc')
    ->get();

    return response()->json($var1);
}



  public function show($id)
    {
        $evento = Impi_evento::findOrFail($id);
        return response()->json($evento);
    }

public function update_event(Request $request)
{
    $request->validate([
        'id_evento'   => 'required|exists:evento_impi,id_evento',
        'evento'      => 'required|string|max:255',
        'descripcion' => 'required|string',
        'estatus'     => 'required|in:1,2,3,4', // Asegura que estatus sea válido
        'url_anexo'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB
    ]);

    $evento = Impi_evento::findOrFail($request->id_evento);
    $evento->evento = $request->evento;
    $evento->descripcion = $request->descripcion;
    $evento->estatus = $request->estatus;

    // Actualizar archivo si se envió uno
    if ($request->hasFile('url_anexo')) {
        // Borrar archivo antiguo si existe
        if ($evento->url_anexo && Storage::exists('public/tramites_impi/' . $evento->url_anexo)) {
            Storage::delete('public/tramites_impi/' . $evento->url_anexo);
        }

        // Obtener extensión del archivo
        $extension = $request->file('url_anexo')->getClientOriginalExtension();

        // Crear nombre: TRÁMITE-[folio]-[numeracion]_[aleatorio].ext
        $folio = str_replace('TRÁMITE-', '', $evento->impi->folio ?? '0000'); // si tienes relación con el trámite
        $numeroAleatorio = Str::random(12);
        $numeroSecuencia = str_pad($evento->id_evento, 4, '0', STR_PAD_LEFT); // opcional: secuencia interna
        $filename = "TRÁMITE-{$folio}-{$numeroSecuencia}_{$numeroAleatorio}.{$extension}";

        // Guardar archivo
        $request->file('url_anexo')->storeAs('public/tramites_impi', $filename);
        $evento->url_anexo = $filename;
    }

    $evento->save();

    return response()->json([
        'success' => true,
        'message' => 'Evento actualizado correctamente',
        'id_impi' => $evento->id_impi
    ]);
}

public function destroy_event($id)
{
    $evento = Impi_evento::findOrFail($id);

    // Borrar archivo si existe
    if ($evento->url_anexo && Storage::exists('public/tramites_impi/'.$evento->url_anexo)) {
        Storage::delete('public/tramites_impi/'.$evento->url_anexo);
    }

    $evento->delete();

    return response()->json([
        'success' => true,
        'message' => 'Evento eliminado correctamente'
    ]);
}


}//fin CONTROLLER
