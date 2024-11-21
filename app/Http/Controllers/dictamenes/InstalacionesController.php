<?php

namespace App\Http\Controllers\dictamenes;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dictamen_instalaciones;
use App\Models\clases; 
use App\Models\categorias;
use App\Models\inspecciones; 

use App\Models\empresa; 
use App\Models\solicitudesModel;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Faker\Extension\Helper;

class InstalacionesController extends Controller
{

  public function UserManagement()
    {
        $dictamenes = Dictamen_instalaciones::all(); // Obtener todos los datos
        $clases = clases::all();
        $categoria = categorias::all();
        $inspeccion = inspecciones::all();
        $empresa = empresa::all();
        $soli = solicitudesModel::all();
        return view('dictamenes.dictamen_instalaciones_view', compact('dictamenes', 'clases', 'categoria', 'inspeccion'));
    }


    public function index(Request $request)
    {
        $columns = [
        //CAMPOS PARA LA TABLA DE INICIO "thead"
            1 => 'id_dictamen',
            2 => 'tipo_dictamen',
            3 => 'num_dictamen',
            4 => 'num_servicio',
            5 => 'fecha_emision',
            6 => 'razon_social',//este lugar lo ocupa fecha en find
            7 => 'id_instalacion',
        ];

        $search = [];
        
        $totalData = Dictamen_instalaciones::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

       

        if ( empty($request->input('search.value'))) {
            //$users = Dictamen_instalaciones::with('inspeccione.solicitud.empresa')
            $users = Dictamen_instalaciones::join('inspecciones AS i', 'dictamenes_instalaciones.id_inspeccion', '=', 'i.id_inspeccion')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
                
        } else {
            $search = $request->input('search.value');
            //$users = Dictamen_instalaciones::with('inspeccione.solicitud.empresa')
            $users = Dictamen_instalaciones::join('inspecciones AS i', 'dictamenes_instalaciones.id_inspeccion', '=', 'i.id_inspeccion')
                ->where('id_dictamen', 'LIKE', "%{$search}%")
                ->orWhere('tipo_dictamen', 'LIKE', "%{$search}%")
                ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
                ->orWhere('fecha_emision', 'LIKE', "%{$search}%")
                ->orWhere('num_servicio', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Dictamen_instalaciones::with('inspeccione.solicitud.empresa')
                ->where('id_dictamen', 'LIKE', "%{$search}%")
                ->orWhere('tipo_dictamen', 'LIKE', "%{$search}%")
                ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
                ->orWhere('fecha_emision', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
            //MUESTRA LOS DATOS EN EL FIND
                $nestedData['fake_id'] = ++$ids;
                $nestedData['id_dictamen'] = $user->id_dictamen;
                $nestedData['tipo_dictamen'] = $user->tipo_dictamen;
                $nestedData['razon_social'] = $user->inspeccione->solicitud->empresa->razon_social;
                $nestedData['num_dictamen'] = $user->num_dictamen;
                $nestedData['num_servicio'] = $user->inspeccione->num_servicio;
                $nestedData['fecha_emision'] = $user->fecha_emision;

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


// Función para agregar registro
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



// Función para eliminar una clase
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


    
//funcion para llenar el campo del formulario
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
            'clases' => $clases
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al obtener el dictamen'], 500);
    }
}

// Función para EDITAR
    public function update(Request $request, $id_dictamen)
{
    $request->validate([
        'tipo_dictamen' => 'required|integer',
        'num_dictamen' => 'required|string|max:255',
        'fecha_emision' => 'nullable|date',
        'fecha_vigencia' => 'nullable|date',
        /*'categorias' => 'required|string|max:100',
        'clases' => 'required|string|max:100',*/
        'categorias' => 'required|array',
        'clases' => 'required|array',  
        'id_inspeccion' => 'required|integer',
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
        $var2->save();

        return response()->json(['success' => 'Editado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al editar'], 500);
    }
}


    //PDFs Dictamen de instalaciones
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
