<?php

namespace App\Http\Controllers\dictamenes;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dictamen_instalaciones;
use App\Models\clases; 
use App\Models\categorias;
use App\Models\inspecciones; 
use App\Models\Instalaciones; 

use App\Models\empresa; 
use App\Models\solicitudesModel;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Faker\Extension\Helper;

class InstalacionesController extends Controller
{

  public function UserManagement()
    {
        $dictamenes = Dictamen_instalaciones::all(); // Obtener todos los datos
        $clases = clases::all();
        $users = User::where('tipo',2)->get(); //Solo inspectores 
        $categoria = categorias::all();
        $inspeccion = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 14);
        })
        ->orderBy('id_inspeccion', 'desc')
        ->get();
        
        $empresa = empresa::all();
        $soli = solicitudesModel::all();

        return view('dictamenes.dictamen_instalaciones_view', compact('dictamenes', 'clases', 'categoria', 'inspeccion','users'));
    }


public function index(Request $request)
{
        $columns = [
        //CAMPOS PARA ORDENAR LA TABLA DE INICIO "thead"
            1 => 'id_dictamen',
            2 => 'tipo_dictamen',
            3 => 'num_dictamen',
            4 => 'num_servicio',
            5 => 'fecha_emision',
            6 => 'razon_social',//este lugar lo ocupa fecha en find
            7 => 'direccion_completa',
            8 => 'fecha_vigencia'
        ];

        $search = [];
        
        $totalData = Dictamen_instalaciones::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if ( empty($request->input('search.value'))) {
        //ORDENAR EL BUSCADOR "thead"
            //$users = Dictamen_instalaciones::with('inspeccione.solicitud.empresa')
            $users = Dictamen_instalaciones::join('inspecciones AS i', 'dictamenes_instalaciones.id_inspeccion', '=', 'i.id_inspeccion')
            ->leftjoin('solicitudes AS s', 's.id_solicitud', '=', 'i.id_solicitud')
            ->leftjoin('empresa AS e', 'e.id_empresa', '=', 's.id_empresa')
            //->leftjoin('instalaciones AS ins', 'ins.id_instalacion', '=', 's.id_instalacion')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
                
        } else {
        //BUSCADOR
            $search = $request->input('search.value');

        //Definimos el nombre al valor de "tipo_dictamen"
            $map = [
                'productor' => 1,
                'envasador' => 2,
                'comercializador' => 3,
                'almacén y bodega' => 4,
                'área de maduración' => 5,
                ];

        // Verificar si la búsqueda es uno de los valores mapeados
            $searchValue = strtolower(trim($search)); //minusculas
            $searchType = null;

        // Si el término es valor conocido, asignamos el valor corres
            if (isset($map[$searchValue])) {
                $searchType = $map[$searchValue];
            }

        // Consulta con filtros
            //$users = Dictamen_instalaciones::with('inspeccione.solicitud.empresa')
            $query = Dictamen_instalaciones::join('inspecciones AS i', 'dictamenes_instalaciones.id_inspeccion', '=', 'i.id_inspeccion')
                ->leftjoin('solicitudes AS s', 's.id_solicitud', '=', 'i.id_solicitud')
                ->leftjoin('empresa AS e', 'e.id_empresa', '=', 's.id_empresa');
                //->leftjoin('instalaciones AS ins', 'ins.id_instalacion', '=', 's.id_instalacion');

        // Si se proporciona un tipo_dictamen válido, filtramos
            if ($searchType !== null) {
                $query->where('tipo_dictamen',  'LIKE', "%{$searchType}%");
            } else {
        // Si no se busca por tipo_dictamen, buscamos por otros campos
                $query->where('id_dictamen', 'LIKE', "%{$search}%")
                    ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
                    ->orWhereDate('dictamenes_instalaciones.fecha_emision', 'LIKE', "%{$search}%")
                    ->orWhere('dictamenes_instalaciones.fecha_vigencia', 'LIKE', "%{$search}%")
                    ->orWhere('num_servicio', 'LIKE', "%{$search}%")
                    ->orWhere('razon_social', 'LIKE', "%{$search}%");
                    //->orWhere('direccion_completa', 'LIKE', "%{$search}%");
            }
            $users = $query->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Dictamen_instalaciones::with('inspeccione.solicitud.empresa')
                ->where('id_dictamen', 'LIKE', "%{$search}%")
                ->orWhere('tipo_dictamen', 'LIKE', "%{$search}%")
                ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
            //MANDA LOS DATOS AL JS
                //$nestedData['fake_id'] = ++$ids;
                $nestedData['id_dictamen'] = $user->id_dictamen;
                $nestedData['tipo_dictamen'] = $user->tipo_dictamen;
                $nestedData['razon_social'] = $user->inspeccione->solicitud->empresa->razon_social;
                $nestedData['num_dictamen'] = $user->num_dictamen;
                $nestedData['num_servicio'] = $user->inspeccione->num_servicio;
                /*$nestedData['fecha_emision'] = $user->fecha_emision;
                $nestedData['fecha_vigencia'] = $user->fecha_vigencia;*/
                //$fecha_emision= Helpers::formatearFecha($user->fecha_emision) ?? 'N/A';
                $fecha_emision = Helpers::formatearFecha($user->fecha_emision);
                $fecha_vigencia = Helpers::formatearFecha($user->fecha_vigencia);
                $nestedData['fechas'] = '<b>Fecha Emisión: </b>' .$fecha_emision. '<br> <b>Fecha Vigencia: </b>' .$fecha_vigencia;
                $nestedData['direccion_completa'] = $user->inspeccione->solicitud->instalacion->direccion_completa;



                $fechaActual = Carbon::now()->startOfDay(); // Asegúrate de trabajar solo con fechas, sin horas
                $fechaVigencia = Carbon::parse($user->fecha_vigencia)->startOfDay();
                
                if ($fechaActual->isSameDay($fechaVigencia)) {
                    $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Hoy se vence este dictamen</span>";
                } else {
                    $diasRestantes = $fechaActual->diffInDays($fechaVigencia, false);
                
                    if ($diasRestantes > 0) {
                        if($diasRestantes > 15){
                            $res = "<span class='badge bg-success'>$diasRestantes días de vigencia.</span>";
                        }else{
                            $res = "<span class='badge bg-warning'>$diasRestantes días de vigencia.</span>";
                        }
                        $nestedData['diasRestantes'] = $res;
                    } else {
                        $nestedData['diasRestantes'] = "<span class='badge bg-danger'>Vencido hace " . abs($diasRestantes) . " días.</span>";
                    }
                }
                


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



//FUNCION PARA REGISTRAR
public function store(Request $request)
{
    try {
        $instalaciones = inspecciones::with(['solicitud.instalacion'])->find($request->id_inspeccion);

        $var = new Dictamen_instalaciones();
        $var->id_inspeccion = $request->id_inspeccion;
        $var->tipo_dictamen = $request->tipo_dictamen;
        $var->id_instalacion =  $instalaciones->solicitud->instalacion->id_instalacion;
        $var->num_dictamen = $request->num_dictamen;
        $var->fecha_emision = $request->fecha_emision;
        $var->fecha_vigencia = $request->fecha_vigencia;
        $var->categorias = json_encode($request->categorias);
        $var->clases =  json_encode($request->clases);
        $var->save();//guardar en BD

        return response()->json(['success' => 'Registro agregada correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al agregar'], 500);
    }
}



//FUNCION PARA ELIMINAR
public function destroy($id_dictamen)
{
    try {
        $eliminar = Dictamen_instalaciones::findOrFail($id_dictamen);
        $eliminar->delete();

        return response()->json(['success' => 'Eliminado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al eliminar'], 500);
    }
}



//FUNCION PARA LLENAR EL FORMULARIO
public function edit($id_dictamen)
{
    try {
        $var1 = Dictamen_instalaciones::findOrFail($id_dictamen);

        $categorias = json_decode($var1->categorias);  //Convertir array
        $clases = json_decode($var1->clases);  //Convertir array
        //return response()->json($var1);
        return response()->json([
            'id_dictamen' => $var1->id_dictamen,
            'tipo_dictamen' => $var1->tipo_dictamen,
            'num_dictamen' => $var1->num_dictamen,
            'fecha_emision' => $var1->fecha_emision,
            'fecha_vigencia' => $var1->fecha_vigencia,
            'id_inspeccion' => $var1->id_inspeccion,
            'categorias' => $categorias,
            'clases' => $clases,
            'id_firmante' => $var1->id_firmante,
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener el dictamen'], 500);
    }
}



//FUNCION PARA EDITAR
    public function update(Request $request, $id_dictamen) 
{
    $request->validate([
        'tipo_dictamen' => 'required|integer',
        'num_dictamen' => 'required|string|max:255',
        'fecha_emision' => 'nullable|date',
        'fecha_vigencia' => 'nullable|date',
        //'categorias' => 'required|array',
        //'clases' => 'required|array',  
        'id_inspeccion' => 'required|integer',
        'id_firmante' => 'required|integer',
    ]);
    try {
        $var2 = Dictamen_instalaciones::findOrFail($id_dictamen);
        $var2->id_inspeccion = $request->id_inspeccion;
        $var2->tipo_dictamen = $request->tipo_dictamen;
        $var2->num_dictamen = $request->num_dictamen;
        $var2->fecha_emision = $request->fecha_emision;
        $var2->fecha_vigencia = $request->fecha_vigencia;
        $var2->categorias = $request->categorias;
        $var2->clases = $request->clases;
        $var2->id_firmante = $request->id_firmante;
        $var2->save();

        return response()->json(['success' => 'Editado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al editar'], 500);
    }
}



//PDF'S DICTAMEN DE INSTALACIONES
    public function dictamen_productor($id_dictamen)
    {   
        $datos = Dictamen_instalaciones::with(['inspeccione.solicitud.empresa.empresaNumClientes', 'instalaciones', 'inspeccione.inspector'])->find($id_dictamen);

        $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
        $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
        $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
        $pdf = Pdf::loadView('pdfs.DictamenProductor',['datos'=>$datos, 'fecha_inspeccion'=>$fecha_inspeccion,'fecha_emision'=>$fecha_emision,'fecha_vigencia'=>$fecha_vigencia]);
        return $pdf->stream('F-UV-02-04 Ver 10, Dictamen de cumplimiento de Instalaciones como productor.pdf');
    }

    public function dictamen_envasador($id_dictamen)
    {   
        $datos = Dictamen_instalaciones::with(['inspeccione.solicitud.empresa.empresaNumClientes', 'instalaciones', 'inspeccione.inspector'])->find($id_dictamen);

        $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
        $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
        $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
        $pdf = Pdf::loadView('pdfs.DictamenEnvasado',['datos'=>$datos, 'fecha_inspeccion'=>$fecha_inspeccion,'fecha_emision'=>$fecha_emision,'fecha_vigencia'=>$fecha_vigencia]);
        return $pdf->stream('F-UV-02-11 Ver 5, Dictamen de cumplimiento de Instalaciones como envasador.pdf');
    }

    public function dictamen_comercializador($id_dictamen)
    {   
        $datos = Dictamen_instalaciones::with(['inspeccione.solicitud.empresa.empresaNumClientes', 'instalaciones', 'inspeccione.inspector'])->find($id_dictamen);

        $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
        $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
        $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
        $pdf = Pdf::loadView('pdfs.DictamenComercializador',['datos'=>$datos, 'fecha_inspeccion'=>$fecha_inspeccion,'fecha_emision'=>$fecha_emision,'fecha_vigencia'=>$fecha_vigencia]);
        return $pdf->stream('F-UV-02-12 Ver 5, Dictamen de cumplimiento de Instalaciones como comercializador.pdf');
    }

    public function dictamen_almacen($id_dictamen)
    {
        $datos = Dictamen_instalaciones::find($id_dictamen);
    
        $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
        $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
        $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    
        // Solucion al problema de la cadena, como se guarda en la BD: ["Blanco o Joven","Reposado", "A\u00f1ejo"
        $categorias = json_decode($datos->categorias, true);
        $clases = json_decode($datos->clases, true);
    
        $pdf = Pdf::loadView('pdfs.Dictamen_cumplimiento_Instalaciones', [
            'datos' => $datos,
            'fecha_inspeccion' => $fecha_inspeccion,
            'fecha_emision' => $fecha_emision,
            'fecha_vigencia' => $fecha_vigencia,
            'categorias' => $categorias,
            'clases' => $clases
        ]);
    
        return $pdf->stream('F-UV-02-13 Ver 1, Dictamen de cumplimiento de Instalaciones almacén.pdf');
    }
    
    public function dictamen_maduracion($id_dictamen)
    {
        $datos = Dictamen_instalaciones::find($id_dictamen);
    
        $fecha_inspeccion = Helpers::formatearFecha($datos->inspeccione->fecha_servicio);
        $fecha_emision = Helpers::formatearFecha($datos->fecha_emision);
        $fecha_vigencia = Helpers::formatearFecha($datos->fecha_vigencia);
    
        // Solucion al problema de la cadena, como se guarda en la BD: ["Blanco o Joven","Reposado", "A\u00f1ejo"
        $categorias = json_decode($datos->categorias, true);
        $clases = json_decode($datos->clases, true);
    
        $pdf = Pdf::loadView('pdfs.Dictamen_Instalaciones_maduracion_mezcal', [
            'datos' => $datos,
            'fecha_inspeccion' => $fecha_inspeccion,
            'fecha_emision' => $fecha_emision,
            'fecha_vigencia' => $fecha_vigencia,
            'categorias' => $categorias,
            'clases' => $clases
        ]);

        return $pdf->stream('F-UV-02-12 Ver 5, Dictamen de cumplimiento de Instalaciones del área de maduración.pdf');
    }
    





}
