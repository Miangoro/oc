<?php

namespace App\Http\Controllers\guias;

use App\Helpers\Helpers;
use App\Models\guias;
use App\Models\empresa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class GuiasController  extends Controller
{
    public function UserManagement()
    {

        $guias = guias::all();
        $empresa = Empresa::where('tipo', 2)->get(); // Esto depende de cómo tengas configurado tu modelo Empresa
        $userCount = $guias->count();
        $verified = 5;
        $notVerified = 10;
        $userDuplicates = 40;

        return view('guias.find_guias_maguey_agave', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
            'guias' => $guias,
            'empresa' => $empresa,
        ]);
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_guia',
            2 => 'id_plantacion',
            3 => 'folio',
            4 => 'id_empresa',
            5 => 'nombre_predio',
            6 => 'numero_plantas',
            7 => 'numero_guias',
            8 => 'num_anterior',
            9 => 'num_comercializadas',
            10 => 'mermas_plantas',

        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'id_guia';
        $dir = $request->input('order.0.dir');

        $searchValue = $request->input('search.value');

        $query = Guias::with(['empresa', 'predios']);

        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('id_guia', 'LIKE', "%{$searchValue}%")
                    ->orWhere('folio', 'LIKE', "%{$searchValue}%")
                    ->orWhere('id_empresa', 'LIKE', "%{$searchValue}%");
            });
        }

        $totalData = guias::count();
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
                $numero_cliente = \App\Models\EmpresaNumCliente::where('id_empresa', $user->id_empresa)->value('numero_cliente');


                $nestedData = [
                    'id_guia' => $user->id_guia,
                    'id_plantacion' => $user->id_plantacion,
                    'fake_id' => ++$ids,
                    'folio' => $user->folio,
                    'razon_social' => $user->empresa ? $user->empresa->razon_social : '',
                    'id_empresa' => $numero_cliente, // Asignar numero_cliente a id_empresa
                    'id_predio' => $user->predios ? $user->predios->nombre_predio : '',
                    'numero_plantas' => $user->numero_plantas,
                    'num_anterior' => $user->num_anterior,
                    'num_comercializadas' => $user->num_comercializadas,
                    'mermas_plantas' => $user->mermas_plantas,


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
    public function destroy($id_guia)
    {
        $clase = guias::findOrFail($id_guia);
        $clase->delete();

        return response()->json(['success' => 'Clase eliminada correctamente']);
    }
    //Metodo para registrar
    public function store(Request $request)
    {

        $request->validate([
            'empresa' => 'required|exists:empresa,id_empresa',
            'numero_guias' => 'required|numeric',
            'predios' => 'required',
            'plantacion' => 'required',
            'anterior' => 'required|numeric',
            'comercializadas' => 'required|numeric',
            'mermas' => 'required|numeric',
            'plantas' => 'required|numeric',
        ]);

        for ($i = 0; $i < $request->input('numero_guias'); $i++) {

            // Crear una nueva instancia del modelo Guia
            $guia = new guias();
            $guia->id_empresa = $request->input('empresa');
            $guia->numero_guias = $request->input('numero_guias');
            $guia->id_predio = $request->input('predios');
            $guia->id_plantacion = $request->input('plantacion');
            $guia->folio = Helpers::generarFolioGuia($request->predios);
            $guia->num_anterior = $request->input('anterior', 0);
            $guia->num_comercializadas = $request->input('comercializadas', 0);
            $guia->mermas_plantas = $request->input('mermas', 0);
            $guia->numero_plantas = $request->input('plantas', 0);
            $guia->save();
        }
        // Responder con éxito
        return response()->json(['success' => 'Guía registrada correctamente']);
    }

/*     //Metodo para llenar el pdf
    public function info($id)
    {
        $res = DB::select('SELECT p.id_producto, n.id_norma, a.id_actividad, s.medios, s.competencia, s.capacidad, s.comentarios, e.representante, e.razon_social, fecha_registro, info_procesos, s.fecha_registro, e.correo, e.telefono
      FROM empresa e 
      JOIN solicitud_informacion s ON (e.id_empresa = s.id_empresa) 
      JOIN empresa_producto_certificar p ON (p.id_empresa = e.id_empresa)
      JOIN empresa_norma_certificar n ON (n.id_empresa = e.id_empresa)
      JOIN empresa_actividad_cliente a ON (a.id_empresa = e.id_empresa)
      WHERE e.id_empresa=' . $id);
        $pdf = Pdf::loadView('pdfs.SolicitudInfoCliente', ['datos' => $res]);
        return $pdf->stream('F7.1-01-02  Solicitud de Información del Cliente NOM-070-SCFI-2016 y NMX-V-052-NORMEX-2016 Ed.pdf');
    } */


        //Metodo para llenar el pdf
        public function infoprueba($id)
        {
            $res = DB::select('SELECT a.razon_social, p.nombre, p.cientifico, s.num_plantas, s.anio_plantacion, e.id_guia, e.folio, e.id_empresa, e.num_predio, e.numero_plantas, e.num_anterior, e.num_comercializadas, e.mermas_plantas
              FROM guias e 
              JOIN predio_plantacion s ON (e.id_predio = s.id_predio) 
              JOIN catalogo_tipo_agave p ON (p.id_tipo = s.id_tipo) 
              JOIN empresa a ON (a.id_empresa = e.id_empresa)
              WHERE e.id_predio=' . $id);
            $pdf = Pdf::loadView('pdfs.GuiaDeTranslado', ['datos' => $res]);
            return $pdf->stream('539G005_Guia_de_traslado_de_maguey_o_agave.pdf');
        }

        
/*                 //Metodo para llenar el pdf
                public function infoprueba($id)
                {
                    $res = DB::select('SELECT s.num_predio, s.nombre_predio, e.id_guia, e.id_plantacion, e.folio, e.id_predio, e.num_predio, e.numero_plantas, e.num_anterior, e.num_comercializadas, e.mermas_plantas
                      FROM guias e 
                      JOIN predios s ON (e.id_empresa = s.id_empresa) 
                      WHERE e.id_empresa=' . $id);
                    $pdf = Pdf::loadView('pdfs.GuiaDeTranslado', ['datos' => $res]);
                    return $pdf->stream('539G005_Guia_de_traslado_de_maguey_o_agave.pdf');
                } */
}
