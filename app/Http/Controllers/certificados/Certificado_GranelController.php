<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertificadosGranel;
use App\Models\Dictamen_Granel;
use App\Models\User;

class Certificado_GranelController extends Controller
{
    public function UserManagement()
    {
        $certificados = CertificadosGranel::all(); 
        $dictamenes = Dictamen_Granel::all();
        $users = User::all(); 
        return view('certificados.certificados_granel_view', compact('certificados' , 'dictamenes' , 'users'));
    }

    public function index(Request $request)
    {
        $columns = [
            1 => 'id_dictamen',
            2 => 'id_firmante',
            3 => 'fecha_vigencia',
            4 => 'fecha_vencimiento',
        ];

        $search = $request->input('search.value');
        $totalData = CertificadosGranel::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        $order = $columns[$orderIndex] ?? 'id_dictamen';
        $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';

        $query = CertificadosGranel::with('dictamen')
            ->when($search, function($q, $search) {
                $q->orWhere('id_firmante', 'LIKE', "%{$search}%")
                  ->orWhere('fecha_vigencia', 'LIKE', "%{$search}%")
                  ->orWhere('fecha_vencimiento', 'LIKE', "%{$search}%");
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir);

        $certificados = $query->get();

        if ($search) {
            $totalFiltered = CertificadosGranel::where('id_firmante', 'LIKE', "%{$search}%")
                ->orWhere('fecha_vigencia', 'LIKE', "%{$search}%")
                ->orWhere('fecha_vencimiento', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = $certificados->map(function ($certificado) use (&$start) {
            return [
                'fake_id' => ++$start,
                'id_certificado' => $certificado->id_certificado,
                'num_dictamen' => $certificado->dictamen->num_dictamen ?? 'N/A',
                'id_firmante' => $certificado->user->name ?? 'N/A',
                'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
                'fecha_vencimiento' => Helpers::formatearFecha($certificado->fecha_vencimiento),
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ]);
    }

    // Método para agregar un certificado
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_firmante' => 'required|integer',
            'num_dictamen' => 'required|integer',
            'fecha_vigencia' => 'required|date',
            'fecha_vencimiento' => 'required|date',
        ]);

        // Crear el registro en la tabla `certificados_granel`
        $certificado = CertificadosGranel::create([
            'id_firmante' => $validatedData['id_firmante'],
            'num_dictamen' => $validatedData['num_dictamen'],
            'fecha_vigencia' => $validatedData['fecha_vigencia'],
            'fecha_vencimiento' => $validatedData['fecha_vencimiento'],
        ]);

        return response()->json([
            'message' => 'Certificado registrado exitosamente',
            'certificado' => $certificado
        ]);
    }

}
