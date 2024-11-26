<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CertificadosGranel;
use App\Models\Dictamen_Granel;
use App\Models\User;
use App\Models\RevisorGranel; 
//Notificacion
use App\Notifications\GeneralNotification;
//Enviar Correo
use App\Mail\CorreoCertificado;
use Illuminate\Support\Facades\Mail; 

class Certificado_GranelController extends Controller
{
    public function UserManagement()
    {
        $certificados = CertificadosGranel::all(); 
        $dictamenes = Dictamen_Granel::all();
        $users = User::all(); 
        $revisores = RevisorGranel::all(); 
        return view('certificados.certificados_granel_view', compact('certificados' , 'dictamenes' , 'users', 'revisores'));
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
                'id_revisor' => $certificado->revisor && $certificado->revisor->user ? $certificado->revisor->user->name : 'Sin asignar',
                'id_revisor2' => $certificado->revisor && $certificado->revisor->user2 ? $certificado->revisor->user2->name : 'Sin asignar',
                'estatus' => $certificado->estatus
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

    // Funcion de eliminar
    public function destroy($id_certificado)
    {
        try {
            // Buscar el certificado
            $certificado = CertificadosGranel::findOrFail($id_certificado);
    
            // Eliminar todos los revisores asociados al certificado en la tabla certificados_revision
            RevisorGranel::where('id_certificado', $id_certificado)->delete();
    
            // Luego, eliminar el certificado
            $certificado->delete();
    
            return response()->json(['success' => 'Certificado y revisores eliminados correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al eliminar el certificado y los revisores: ' . $e->getMessage()], 500);
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

    // Funcion para cargar
    public function edit($id)
    {
        $certificado = CertificadosGranel::find($id);
    
        if ($certificado) {
            return response()->json($certificado);
        }

        return response()->json(['error' => 'Certificado no encontrado'], 404);
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

    // Función agregar Revisor
    public function storeRevisor(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'tipoRevisor' => 'required|string|in:1,2',
                'nombreRevisor' => 'required|integer|exists:users,id',
                'numeroRevision' => 'required|string|max:50',
                'esCorreccion' => 'nullable|in:si,no',
                'observaciones' => 'nullable|string|max:255',
                'id_certificado' => 'required|integer|exists:certificados_granel,id_certificado',
            ]);
            
            $user = User::find($validatedData['nombreRevisor']);
            if (!$user) {
                return response()->json(['message' => 'El revisor no existe.'], 404);
            }

            $certificado = CertificadosGranel::find($validatedData['id_certificado']);
            if (!$certificado) {
                return response()->json(['message' => 'El certificado no existe.'], 404);
            }

            $revisor = RevisorGranel::where('id_certificado', $validatedData['id_certificado'])->first();
            $message = ''; // Inicializar el mensaje

            if ($revisor) {
                // Actualizar el revisor existente
                if ($validatedData['tipoRevisor'] == '1') {
                    if ($revisor->id_revisor == $validatedData['nombreRevisor']) {
                        $message = 'Revisor reasignado.'; 
                    } else {
                        $revisor->id_revisor = $validatedData['nombreRevisor'];
                        $message = 'Revisor asignado exitosamente.';
                    }
                } else {
                    if ($revisor->id_revisor2 == $validatedData['nombreRevisor']) {
                        $message = 'Revisor reasignado.';
                    } else {
                        $revisor->id_revisor2 = $validatedData['nombreRevisor'];
                        $message = 'Revisor Miembro del consejo asignado exitosamente.';
                    }
                }
            } else {
                // Crear un nuevo revisor
                $revisor = new RevisorGranel();
                $revisor->id_certificado = $validatedData['id_certificado'];
                $revisor->tipo_revision = $validatedData['tipoRevisor'];

                if ($validatedData['tipoRevisor'] == '1') {
                    $revisor->id_revisor = $validatedData['nombreRevisor'];
                    $message = 'Revisor asignado exitosamente.';
                } else {
                    $revisor->id_revisor2 = $validatedData['nombreRevisor'];
                    $message = 'Revisor Miembro del consejo asignado exitosamente.';
                }
            }

            // Guardar los datos del revisor
            $revisor->numero_revision = $validatedData['numeroRevision'];
            $revisor->es_correccion = $validatedData['esCorreccion'] ?? 'no';
            $revisor->observaciones = $validatedData['observaciones'] ?? '';
            $revisor->save();

            // Preparar datos para el correo
            $data1 = [
                'title' => 'Nuevo registro de solicitud',
                'message' => 'Se ha asignado el revisor (' . $user->name . ') al certificado número ' . $certificado->num_certificado, 
                'url' => 'solicitudes-historial',
                'nombreRevisor' => $user->name,
                'emailRevisor' => $user->email,
                'num_certificado' => $certificado->num_certificado,
                'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
                'fecha_vencimiento' => Helpers::formatearFecha($certificado->fecha_vencimiento), 
                'razon_social' => $certificado->dictamen->inspeccione->solicitud->empresa->razon_social ?? 'Sin asignar',
                'numero_cliente' => $certificado->dictamen->inspeccione->solicitud->empresa->empresaNumClientes->first()->numero_cliente ?? 'Sin asignar',
                'tipo_certificado' => $certificado->id_dictamen
            ];

            // Notificación Local
            $users = User::whereIn('id', [18, 19, 20])->get();
            foreach ($users as $notifiedUser) {
                $notifiedUser->notify(new GeneralNotification($data1));
            }

/*             // Correo a Revisores
            try {
                info('Enviando correo a: ' . $user->email);

                if (empty($user->email)) {
                    return response()->json(['message' => 'El correo del revisor no está disponible.'], 404);
                }

                Mail::to($user->email)->send(new CorreoCertificado($data1)); 
                info('Correo enviado a: ' . $user->email);
            } catch (\Exception $e) {
                Log::error('Error al enviar el correo: ' . $e->getMessage()); 
                return response()->json(['message' => 'Error al enviar el correo: ' . $e->getMessage()], 500);
            } */

            return response()->json([
                'message' => $message ?? 'Revisor del OC asignado exitosamente',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocurrió un error al asignar el revisor: ' . $e->getMessage()], 500);
        }
    }

    //Funcion para reexpedir certificado
    public function reexpedir(Request $request)
    {
        try {
            $request->validate([
            'id_firmante' => 'required|integer',
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string',
            'fecha_vigencia' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'observaciones' => 'nullable|string',
            ]);
    
            $certificado = CertificadosGranel::findOrFail($request->id_certificado);
    
            if ($request->accion_reexpedir == '1') {
                $certificado->estatus = 1; 
                $certificado->observaciones = $request->observaciones; 
                $certificado->save();
            } elseif ($request->accion_reexpedir == '2') {
                $certificado->estatus = 1;
                $certificado->observaciones = $request->observaciones; 
                $certificado->save(); 
    
                // Crear un nuevo registro de certificado (reexpedición)
                $nuevoCertificado = new CertificadosGranel();
                $nuevoCertificado->id_dictamen = $request->id_dictamen;
                $nuevoCertificado->num_certificado = $request->num_certificado;
                $nuevoCertificado->fecha_vigencia = $request->fecha_vigencia;
                $nuevoCertificado->fecha_vencimiento = $request->fecha_vencimiento;
                $nuevoCertificado->id_firmante = $request->id_firmante;
                $nuevoCertificado->estatus = 2;
                
                // Guarda el nuevo certificado
                $nuevoCertificado->save();
            }
    
            return response()->json(['message' => 'Certificado procesado correctamente.']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => 'Error al procesar el certificado.', 'error' => $e->getMessage()], 500);
        }
    }

    public function PreCertificado($id_certificado)
    {
        // Aseguramos de cargar también la relación 'lote_granel.clase' si es necesario
        $certificado = CertificadosGranel::with('dictamen.empresa.instalaciones', 'dictamen.lote_granel.clase')->findOrFail($id_certificado);
    
        // Obtener la dirección completa de la primera instalación
        $direccionCompleta = $certificado->dictamen->empresa->instalaciones->first()->direccion_completa ?? 'Dirección no disponible';
    
        // Obtener el valor de la clase si está disponible
        $clase = $certificado->dictamen->lote_granel->clase->clase ?? 'Clase no disponible';
    
        // Verificar el watermark
        $watermarkText = $certificado->estatus === 1 ? 'Certificado válido' : 'Certificado no válido';
    
        // Datos para el PDF
        $pdfData = [
            // Tabla #1
            'num_certificado' => $certificado->num_certificado,
            'razon_social' => $certificado->dictamen->empresa->razon_social,
            'representante' => $certificado->dictamen->empresa->representante,
            'domicilio_fiscal' => $certificado->dictamen->empresa->domicilio_fiscal,
            'rfc' => $certificado->dictamen->empresa->rfc,
            'direccion_completa' => $direccionCompleta,
            'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
            'fecha_vencimiento' => Helpers::formatearFecha($certificado->fecha_vencimiento),
    
            // Agregar la clase al PDF
            'nombre_lote' => $clase,
    
            'watermarkText' => $watermarkText,
        ];
    
        // Generar y mostrar el PDF
        return Pdf::loadView('pdfs.pre-certificado', $pdfData)->stream("Pre-certificado.pdf");
    }
    
}