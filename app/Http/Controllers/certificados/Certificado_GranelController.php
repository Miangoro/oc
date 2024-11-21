<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use Barryvdh\DomPDF\Facade\Pdf;
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
                'id_dictamen' => $certificado->dictamen->num_dictamen ?? 'N/A',
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

    public function destroy($id_dictamen)
    {
        try {
            $eliminar = CertificadosGranel::findOrFail($id_dictamen);
            $eliminar->delete();

            return response()->json(['success' => 'Eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar'], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_firmante' => 'required|integer',
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string',
            'fecha_vigencia' => 'required|date',
            'fecha_vencimiento' => 'required|date',
        ]);

        $certificado = CertificadosGranel::create([
            'id_firmante' => $validatedData['id_firmante'],
            'id_dictamen' => $validatedData['id_dictamen'],
            'num_certificado' => $validatedData['num_certificado'],
            'fecha_vigencia' => $validatedData['fecha_vigencia'],
            'fecha_vencimiento' => $validatedData['fecha_vencimiento'],
        ]);

        return response()->json([
            'message' => 'Certificado registrado exitosamente',
            'certificado' => $certificado
        ]);
    }

    public function edit($id_certificado)
    {
        $certificado = CertificadosGranel::findOrFail($id_certificado);
        
        return response()->json([
            'id_certificado' => $certificado->id_certificado,
            'id_firmante' => $certificado->id_firmante,
            'id_dictamen' => $certificado->id_dictamen,
            'num_certificado' => $certificado->num_certificado,
            'fecha_vigencia' => $certificado->fecha_vigencia,
            'fecha_vencimiento' => $certificado->fecha_vencimiento,
        ]);
    }
    
    public function update(Request $request, $id_certificado)
    {
        $validatedData = $request->validate([
            'id_firmante' => 'required|integer',
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string',
            'fecha_vigencia' => 'required|date',
            'fecha_vencimiento' => 'required|date',
        ]);

        try {
            $certificado = CertificadosGranel::findOrFail($id_certificado);
            
            $certificado->update([
                'id_firmante' => $validatedData['id_firmante'],
                'id_dictamen' => $validatedData['id_dictamen'],
                'num_certificado' => $validatedData['num_certificado'],
                'fecha_vigencia' => $validatedData['fecha_vigencia'],
                'fecha_vencimiento' => $validatedData['fecha_vencimiento'],
            ]);

            return response()->json([
                'message' => 'Certificado actualizado exitosamente',
                'certificado' => $certificado
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al actualizar el certificado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function PreCertificado($id_certificado)
    {
        $certificado = CertificadosGranel::with('dictamen.empresa')->findOrFail($id_certificado);
    
        $pdfData = [
            'num_certificado' => $certificado->num_certificado,
            'razon_social' => $certificado->dictamen->empresa->razon_social,
        ];
    
        $pdf = Pdf::loadView('pdfs.pre-certificado', $pdfData);
        return $pdf->stream("Pre-certificado CIDAM C-GRA-{$certificado->id_certificado}.pdf");
    }
    
}
