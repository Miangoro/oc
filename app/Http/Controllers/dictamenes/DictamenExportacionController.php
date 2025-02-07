<?php

namespace App\Http\Controllers\dictamenes;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dictamen_Exportacion;
use App\Models\inspecciones; 
use App\Models\User;

use App\Models\Instalaciones; 
use App\Models\empresa; 
use App\Models\solicitudesModel;
use App\Notifications\GeneralNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Faker\Extension\Helper;

class DictamenExportacionController extends Controller
{

  public function UserManagement()
    {
        $dictamenes = Dictamen_Exportacion::all(); // Obtener todos los datos
        $users = User::where('tipo',2)->get(); //Solo inspectores 
        $inspeccion = inspecciones::whereHas('solicitud.tipo_solicitud', function ($query) {
            $query->where('id_tipo', 14);
        })
        ->orderBy('id_inspeccion', 'desc')
        ->get();
        $empresa = empresa::all();
 
        return view('dictamenes.dictamen_exportacion', compact('dictamenes', 'inspeccion', 'users', 'empresa'));
    }


public function index(Request $request)
{
        $columns = [
        //CAMPOS PARA ORDENAR LA TABLA DE INICIO "thead"
            1 => 'num_dictamen',
            2 => 'id_inspeccion',
            3 => 'razon_social',
            4 => 'fecha_emision',
        ];

        $search = [];
        
        $totalData = Dictamen_Exportacion::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        if (empty($request->input('search.value'))) {
            // ORDENAR EL BUSCADOR "thead"
            $users = Dictamen_Exportacion::where('id_dictamen', 'LIKE', "%{$request->input('search.value')}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
        } else {
            // BUSCADOR
            $search = $request->input('search.value');
        
        
            // Consulta con filtros
        $query = Dictamen_Exportacion::where('id_dictamen', 'LIKE', "%{$search}%")
        ->where("id_dictamen", 1)
        ->orWhere('num_dictamen', 'LIKE', "%{$search}%");

        $users = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
  
        $totalFiltered = Dictamen_Exportacion::where('id_dictamen', 'LIKE', "%{$search}%")
          ->where("id_dictamen", 1)
          ->orWhere('num_dictamen', 'LIKE', "%{$search}%")
          ->count();
      }
        

        $data = [];

        if (!empty($users)) {
            $ids = $start;

            foreach ($users as $user) {
            //MANDA LOS DATOS AL JS
                $nestedData['id_dictamen'] = $user->id_dictamen;
                $nestedData['num_dictamen'] = $user->num_dictamen;
                $nestedData['id_inspeccion'] = $user->inspeccione->num_servicio;
                ///numero y nombre empresa
                $empresa = $user->inspeccione->solicitud->empresa;
                $numero_cliente = $empresa && $empresa->empresaNumClientes->isNotEmpty()
                ? $empresa->empresaNumClientes
                    ->first(fn($item) => $item->empresa_id === $empresa->id && !empty($item->numero_cliente))?->numero_cliente ?? 'N/A'
                : 'N/A';
                $nestedData['numero_cliente'] = $numero_cliente;
                $nestedData['razon_social'] = $user->inspeccione->solicitud->empresa->razon_social ?? 'No encontrado';

                $fecha_emision = Helpers::formatearFecha($user->fecha_emision);
                $fecha_vigencia = Helpers::formatearFecha($user->fecha_vigencia);
                $nestedData['fechas'] = '<b>Fecha Emisión: </b>' .$fecha_emision. '<br> <b>Fecha Vigencia: </b>' .$fecha_vigencia;
                
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
        // Crear y guardar el nuevo dictamen
        $var = new Dictamen_Exportacion();
        $var->num_dictamen = $request->num_dictamen;
        $var->id_inspeccion = $request->id_inspeccion;
        $var->fecha_emision = $request->fecha_emision;
        $var->fecha_vigencia = $request->fecha_vigencia;
        $var->id_firmante = $request->id_firmante;
        $var->save(); // Guardar en BD

        return response()->json(['success' => 'Registro agregado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Ocurrió un error al intentar agregar el registro'], 500);
    }
}



//FUNCION PARA ELIMINAR
public function destroy($id_dictamen)
{
    try {
        $eliminar = Dictamen_Exportacion::findOrFail($id_dictamen);
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
        $var1 = Dictamen_Exportacion::findOrFail($id_dictamen);

        return response()->json([
            'id_dictamen' => $var1->id_dictamen,
            'num_dictamen' => $var1->num_dictamen,
            'id_inspeccion' => $var1->id_inspeccion,
            'fecha_emision' => $var1->fecha_emision,
            'fecha_vigencia' => $var1->fecha_vigencia,
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
        'num_dictamen' => 'required|string|max:255',
        'id_inspeccion' => 'required|integer',
        'fecha_emision' => 'nullable|date',
        'fecha_vigencia' => 'nullable|date',
        'id_firmante' => 'required|integer',
    ]);
    try {
        $var2 = Dictamen_Exportacion::findOrFail($id_dictamen);
        $var2->num_dictamen = $request->num_dictamen;
        $var2->id_inspeccion = $request->id_inspeccion;
        $var2->fecha_emision = $request->fecha_emision;
        $var2->fecha_vigencia = $request->fecha_vigencia;
        $var2->id_firmante = $request->id_firmante;
        $var2->save();

        return response()->json(['success' => 'Editado correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al editar'], 500);
    }
}








}
