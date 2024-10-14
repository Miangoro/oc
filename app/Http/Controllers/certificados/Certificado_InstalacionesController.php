<?php

namespace App\Http\Controllers\certificados;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificados;
use App\Models\Dictamen_instalaciones;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Revisor; 
//Notificacion
use App\Notifications\GeneralNotification;
//Enviar Correo
use App\Mail\CorreoCertificado;
use Illuminate\Support\Facades\Mail; 

class Certificado_InstalacionesController extends Controller
{
    public function UserManagement()
    {
        $dictamenes = Dictamen_instalaciones::all();
        $users = User::all(); 
        $revisores = Revisor::all(); 
        return view('certificados.certificados_instalaciones_view', compact('dictamenes', 'users', 'revisores'));
    }
    
    public function index(Request $request)
    {
        $columns = [
            1 => 'num_dictamen',
            2 => 'num_certificado',
            3 => 'id_firmante',
            4 => 'maestro_mezcalero',
            5 => 'num_autorizacion',
            6 => 'fecha_vigencia',
            7 => 'fecha_vencimiento',
        ];
    
        $search = $request->input('search.value');
        $totalData = Certificados::with(['dictamen', 'firmante', 'revisor'])->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');
    
        $order = $columns[$orderIndex] ?? 'num_certificado';
        $dir = in_array($orderDir, ['asc', 'desc']) ? $orderDir : 'asc';
    
        $query = Certificados::with(['dictamen', 'firmante', 'revisor.user']) 
        ->when($search, function($q, $search) {
                $q->where('num_certificado', 'LIKE', "%{$search}%")
                  ->orWhere('maestro_mezcalero', 'LIKE', "%{$search}%")
                  ->orWhereHas('firmante', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir);
    
        $certificados = $query->get();
    
        if ($search) {
            $totalFiltered = Certificados::with('dictamen')
                ->where('num_certificado', 'LIKE', "%{$search}%")
                ->orWhere('maestro_mezcalero', 'LIKE', "%{$search}%")
                ->orWhereHas('firmante', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })
                ->count();
        }

        $data = $certificados->map(function ($certificado) use (&$start) {
            return [
                'id_certificado' => $certificado->id_certificado,
                'fake_id' => ++$start,
                'num_certificado' => $certificado->num_certificado,
                'num_autorizacion' => $certificado->num_autorizacion ?? 'N/A',
                'fecha_vigencia' => Helpers::formatearFecha($certificado->fecha_vigencia),
                'fecha_vencimiento' => Helpers::formatearFecha($certificado->fecha_vencimiento),
                'maestro_mezcalero' => $certificado->maestro_mezcalero ?? 'N/A',
                'num_dictamen' => $certificado->dictamen->num_dictamen,
                'tipo_dictamen' => $certificado->dictamen->tipo_dictamen,
                'id_firmante' => $certificado->firmante->name,
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
            $certificado = Certificados::findOrFail($id_certificado);
    
            // Eliminar todos los revisores asociados al certificado en la tabla certificados_revision
            Revisor::where('id_certificado', $id_certificado)->delete();
    
            // Luego, eliminar el certificado
            $certificado->delete();
    
            return response()->json(['success' => 'Certificado y revisores eliminados correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al eliminar el certificado y los revisores: ' . $e->getMessage()], 500);
        }
    }
    
    // Funcion agregar
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_vigencia' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'maestro_mezcalero' => 'nullable|string|max:60',
            'num_autorizacion' => 'nullable|integer',
            'id_firmante' => 'required|integer',
        ]);
    
        $certificado = Certificados::create([
            'id_dictamen' => $validatedData['id_dictamen'],
            'num_certificado' => $validatedData['num_certificado'],
            'fecha_vigencia' => $validatedData['fecha_vigencia'],
            'fecha_vencimiento' => $validatedData['fecha_vencimiento'],
            'maestro_mezcalero' => $validatedData['maestro_mezcalero'] ?: null, 
            'num_autorizacion' => $validatedData['num_autorizacion'] ?: null,
            'id_firmante' => $validatedData['id_firmante']
        ]);
    
        return response()->json([
            'message' => 'Certificado registrado exitosamente',
            'certificado' => $certificado
        ]);
    }
    
    // Funcion para cargar
    public function edit($id)
    {
        $certificado = Certificados::find($id);
    
        if ($certificado) {
            return response()->json($certificado);
        }
    
        return response()->json(['error' => 'Certificado no encontrado'], 404);
    }
 
    // Funcion Actualizar
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_dictamen' => 'required|integer',
            'num_certificado' => 'required|string|max:25',
            'fecha_vigencia' => 'required|date_format:Y-m-d',
            'fecha_vencimiento' => 'nullable|date_format:Y-m-d',
            'maestro_mezcalero' => 'nullable|string|max:60',
            'num_autorizacion' => 'nullable|integer',
            'id_firmante' => 'required|integer',
        ]);
    
        try {
            $certificado = Certificados::findOrFail($id);
    
            $certificado->id_dictamen = $validatedData['id_dictamen'];
            $certificado->num_certificado = $validatedData['num_certificado'];
            $certificado->fecha_vigencia = $validatedData['fecha_vigencia'];
            $certificado->fecha_vencimiento = $validatedData['fecha_vencimiento'];
            $certificado->maestro_mezcalero = $validatedData['maestro_mezcalero'] ?: null;
            $certificado->num_autorizacion = $validatedData['num_autorizacion'] ?: null;
            $certificado->id_firmante = $validatedData['id_firmante']; 
    
            $certificado->save();
    
            return response()->json([
                'message' => 'Certificado actualizado correctamente.',
                'certificado' => $certificado
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar el certificado. Por favor, intente de nuevo.'
            ], 500);
        }
    }
    
    public function pdf_certificado_productor($id_certificado)
    {
        $datos = Certificados::with(['dictamen.inspeccione.solicitud.empresa.empresaNumClientes','dictamen.instalaciones','dictamen.inspeccione.inspector','firmante'])->findOrFail($id_certificado);
    
        $empresa = $datos->dictamen->inspeccione->solicitud->empresa;
        $numero_cliente = $empresa->empresaNumClientes->firstWhere('empresa_id', $empresa->id)->numero_cliente;
    
        $watermarkText = $datos->estatus === 1;

        $pdfData = [
            'datos' => $datos,'num_certificado' => $datos->num_certificado,'num_autorizacion' => $datos->num_autorizacion,'num_dictamen' => $datos->dictamen->num_dictamen,'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),'fecha_vencimiento' => Helpers::formatearFecha($datos->fecha_vencimiento),'domicilio_fiscal' => $empresa->domicilio_fiscal,'rfc' => $empresa->rfc,
            'telefono' => $empresa->telefono,'correo' => $empresa->correo,
            'watermarkText' =>  $watermarkText,
            'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa,
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------','numero_cliente' => $numero_cliente,'nombre_firmante' => $datos->firmante->name
        ];
        
        $pdf = Pdf::loadView('pdfs.Certificado_productor_mezcal', $pdfData);    
        return $pdf->stream('Certificado de productor de mezcal.pdf');
    }
    
    
    public function pdf_certificado_envasador($id_certificado)
    {
        $datos = Certificados::with(['dictamen.inspeccione.solicitud.empresa.empresaNumClientes','dictamen.instalaciones','dictamen.inspeccione.inspector','firmante' ])->findOrFail($id_certificado);
    
        $empresa = $datos->dictamen->inspeccione->solicitud->empresa;
        $numero_cliente = $empresa->empresaNumClientes->firstWhere('empresa_id', $empresa->id)->numero_cliente;

        $watermarkText = $datos->estatus === 1;
    
        $pdfData = [
            'datos' => $datos,'num_certificado' => $datos->num_certificado,'num_autorizacion' => $datos->num_autorizacion,'num_dictamen' => $datos->dictamen->num_dictamen,
            'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),'fecha_vencimiento' => Helpers::formatearFecha($datos->fecha_vencimiento),
            'domicilio_fiscal' => $empresa->domicilio_fiscal,'rfc' => $empresa->rfc,
            'watermarkText' =>  $watermarkText,
            'telefono' => $empresa->telefono,'correo' => $empresa->correo,'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa,
            'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------','numero_cliente' => $numero_cliente,'nombre_firmante' => $datos->firmante->name
        ];
    
        $pdf = Pdf::loadView('pdfs.Certificado_envasador_mezcal', $pdfData);    
        return $pdf->stream('Certificado de envasador de mezcal.pdf');
    }

    public function pdf_certificado_comercializador($id_certificado)
    {
        $datos = Certificados::with(['dictamen.inspeccione.solicitud.empresa.empresaNumClientes','dictamen.instalaciones','dictamen.inspeccione.inspector','firmante'])->findOrFail($id_certificado);

        $empresa = $datos->dictamen->inspeccione->solicitud->empresa;
        $numero_cliente = $empresa->empresaNumClientes->firstWhere('empresa_id', $empresa->id)->numero_cliente;

        $watermarkText = $datos->estatus === 1;

         $pdfData = [
            'datos' => $datos,'num_certificado' => $datos->num_certificado,'num_autorizacion' => $datos->num_autorizacion,'num_dictamen' => $datos->dictamen->num_dictamen,'fecha_emision' => Helpers::formatearFecha($datos->fecha_emision),
            'fecha_vigencia' => Helpers::formatearFecha($datos->fecha_vigencia),'fecha_vencimiento' => Helpers::formatearFecha($datos->fecha_vencimiento),'domicilio_fiscal' => $empresa->domicilio_fiscal,'rfc' => $empresa->rfc,
            'telefono' => $empresa->telefono,'correo' => $empresa->correo,
            'watermarkText' =>  $watermarkText,
            'direccion_completa' => $datos->dictamen->instalaciones->direccion_completa,'maestro_mezcalero' => $datos->maestro_mezcalero ?? '------------------------------',
            'numero_cliente' => $numero_cliente,'nombre_firmante' => $datos->firmante->name ?? 'Nombre del firmante no disponible'
    ];

        $pdf = Pdf::loadView('pdfs.Certificado_comercializador', $pdfData);
        return $pdf->stream('Certificado de comercializador.pdf');
    }

    // Funcion LLenar Select
    public function obtenerRevisores(Request $request)
    {
        $tipo = $request->get('tipo');
        $revisores = User::where('tipo', $tipo)->get(['id', 'name']);
        
        return response()->json($revisores);
    }
    
    //Funcion agregar Revisor
    public function storeRevisor(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'tipoRevisor' => 'required|string|in:1,2',
                'nombreRevisor' => 'required|integer|exists:users,id',
                'numeroRevision' => 'required|string|max:50',
                'esCorreccion' => 'nullable|in:si,no',
                'observaciones' => 'nullable|string|max:255',
                'id_certificado' => 'required|integer|exists:certificados,id_certificado',
            ]);
            
            $user = User::find($validatedData['nombreRevisor']);
            if (!$user) {
                return response()->json(['message' => 'El revisor no existe.'], 404);
            }
    
            $certificado = Certificados::find($validatedData['id_certificado']);
            if (!$certificado) {
                return response()->json(['message' => 'El certificado no existe.'], 404);
            }
    
            $revisor = Revisor::where('id_certificado', $validatedData['id_certificado'])->first();
    
            if ($revisor) {
                if ($validatedData['tipoRevisor'] == '1') {
                    if ($revisor->id_revisor == $validatedData['nombreRevisor']) {
                        return response()->json(['message' => 'El revisor ya está asignado.'], 400);
                    }
                    $revisor->id_revisor = $validatedData['nombreRevisor'];
                } else {
                    if ($revisor->id_revisor2 == $validatedData['nombreRevisor']) {
                        $revisor->id_revisor2 = $validatedData['nombreRevisor'];
                        $message = 'Revisor reasignado.';
                    } else {
                        $revisor->id_revisor2 = $validatedData['nombreRevisor'];
                        $message = 'Revisor Miembro del consejo asignado exitosamente.';
                    }
                }
            } else {
                $revisor = new Revisor();
                $revisor->id_certificado = $validatedData['id_certificado'];
                $revisor->tipo_revision = $validatedData['tipoRevisor'];
    
                if ($validatedData['tipoRevisor'] == '1') {
                    $revisor->id_revisor = $validatedData['nombreRevisor'];
                } else {
                    $revisor->id_revisor2 = $validatedData['nombreRevisor'];
                    $message = 'Revisor Miembro del consejo asignado exitosamente.';
                }
            }
    
            $revisor->numero_revision = $validatedData['numeroRevision'];
            $revisor->es_correccion = $validatedData['esCorreccion'] ?? 'no';
            $revisor->observaciones = $validatedData['observaciones'] ?? '';
            
            $revisor->save();
    
            // Notificación
            $data1 = [
                'title' => 'Nuevo registro de solicitud',
                'message' => 'Se ha asignado el revisor (' . $user->name . ') al certificado ' . $certificado->num_certificado, 
                'url' => 'solicitudes-historial',
            ];

            $users = User::whereIn('id', [18, 19, 20])->get();
    
            foreach ($users as $user) {
                $user->notify(new GeneralNotification($data1));
            }
    
/*             try {
                Mail::to('carloszarco888@gmail.com')->send(new CorreoCertificado($data1));
            } catch (\Exception $e) {
                // Captura y muestra el error
                dd('Error al enviar el correo: ' . $e->getMessage());
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
                'id_certificado' => 'required|exists:certificados,id_certificado',
                'accion_reexpedir' => 'required|in:1,2', 
                'observaciones' => 'nullable|string',
                'id_dictamen' => 'required|integer',
                'num_certificado' => 'required|string|max:25',
                'fecha_vigencia' => 'required|date',
                'fecha_vencimiento' => 'required|date',
                'maestro_mezcalero' => 'nullable|string|max:60',
                'num_autorizacion' => 'nullable|integer',
                'id_firmante' => 'required|integer',
            ]);
    
            $certificado = Certificados::findOrFail($request->id_certificado);
    
            if ($request->accion_reexpedir == '1') {
                $certificado->estatus = 1; 
                $certificado->observaciones = $request->observaciones; 
                $certificado->save();
            } elseif ($request->accion_reexpedir == '2') {
                $certificado->estatus = 1;
                $certificado->observaciones = $request->observaciones; 
                $certificado->save(); 
    
                // Crear un nuevo registro de certificado (reexpedición)
                $nuevoCertificado = new Certificados();
                $nuevoCertificado->id_dictamen = $request->id_dictamen;
                $nuevoCertificado->num_certificado = $request->num_certificado;
                $nuevoCertificado->fecha_vigencia = $request->fecha_vigencia;
                $nuevoCertificado->fecha_vencimiento = $request->fecha_vencimiento;
                $nuevoCertificado->maestro_mezcalero = $request->maestro_mezcalero ?: null;
                $nuevoCertificado->num_autorizacion = $request->num_autorizacion ?: null;
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
    
    
//end
}
