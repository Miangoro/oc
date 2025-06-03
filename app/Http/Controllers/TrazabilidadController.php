<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\empresa;
use App\Models\inspecciones;
use App\Models\instalaciones;
use App\Models\solicitudTipo;
use App\Models\User;
use App\Models\Certificado_Exportacion;
use App\Models\Dictamen_Exportacion;
use App\Models\Revisor;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class TrazabilidadController extends Controller
{
    public function mostrarLogs($id)
    {   
        $inspeccionId = inspecciones::where('id_solicitud', $id)->pluck('id_inspeccion')->first();

        $logs = Activity::where(function($query) use ($id) {
            // Filtrar los registros del modelo inspecciones con el id_solicitud en las properties
            $query->where('subject_type', 'App\Models\inspecciones')
                ->where('properties->attributes->id_solicitud', $id);
        })
        ->orWhere(function($query) use ($id) {
            // Filtrar los registros del modelo solicitudesModel con el causer_id igual al id_solicitud
            $query->where('subject_type', 'App\Models\solicitudesModel')
                ->where('subject_id', $id);
        })
        ->orWhere(function($query) use ($id, $inspeccionId) {
            // Filtrar los registros del modelo Dictamen_instalaciones con id_inspeccion
            $query->where('subject_type', 'App\Models\Dictamen_instalaciones')
                ->where('properties->attributes->id_inspeccion', $id);
        })
        ->orWhere(function($query) use ($inspeccionId) {
            // Filtrar registros cuya id_inspección pertenezca a la inspección de la solicitud
            $query->where('subject_type', 'App\Models\Dictamen_instalaciones')
                ->where('properties->attributes->id_inspeccion', $inspeccionId);
        })
        ->orWhere(function($query) use ($id) {
           
            $query->where('subject_type', 'App\Models\Documentacion_url')
                ->where('properties->attributes->id_relacion', $id);
        })
        ->orWhere(function($query) use ($id) {
           
            $query->where('subject_type', 'App\Models\solicitudesValidacionesModel')
                ->where('properties->attributes->id_solicitud', $id);
        })
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($log) {
            
        // Inicializar variables
            $folio = $log->properties['attributes']['folio'] ?? null;

            // Buscar los objetos solo si los IDs están presentes
            $tipo_solicitud = isset($log->properties['attributes']['id_tipo']) 
                ? solicitudTipo::find($log->properties['attributes']['id_tipo'])->tipo ?? null 
                : null;
            
            $num_dictamen = isset($log->properties['attributes']['num_dictamen']) 
                ? $log->properties['attributes']['num_dictamen'] ?? null 
                : null;

            $instalacion = isset($log->properties['attributes']['id_instalacion']) 
                ? instalaciones::find($log->properties['attributes']['id_instalacion'])->direccion_completa ?? null 
                : null;

            $nombre_documento = isset($log->properties['attributes']['nombre_documento']) 
                ? $log->properties['attributes']['nombre_documento']?? null 
                : null;

            $empresa = isset($log->properties['attributes']['id_empresa']) 
                ? empresa::find($log->properties['attributes']['id_empresa'])->razon_social ?? null 
                : null;

            $inspector = isset($log->properties['attributes']['id_inspector']) 
                ? User::find($log->properties['attributes']['id_inspector'])->name ?? null 
                : null;

            $num_servicio = isset($log->properties['attributes']['num_servicio']) 
                ? $log->properties['attributes']['num_servicio']?? null 
                : null;

            $pdf_validacion = ($log->subject_type == 'App\Models\solicitudesValidacionesModel') 
                ? $log->subject_id ?? null 
                : null;
            

            // Construcción del contenido condicionalmente
            $contenido = '';  // Inicializar vacío

            if ($folio) {
                $contenido .= "<b>Folio:</b> <span class='badge bg-secondary'>$folio</span> ";
            }

            if ($tipo_solicitud) {
                $contenido .= "<b>Solicitud:</b> $tipo_solicitud ";
            }

            if ($nombre_documento) {
                $contenido .= "<b>Nombre del documento:</b> $nombre_documento ";
            }

            if ($empresa) {
                $contenido .= "<b>Cliente:</b> $empresa ";
            }

            if ($num_dictamen) {
                $contenido .= "<b>Número de dictamen:</b> <span class='badge bg-secondary'>$num_dictamen</span> ";
            }

            if ($instalacion) {
                $contenido .= "<b>Instalación:</b> $instalacion ";
            }

            if ($inspector) {
                $contenido .= "<b>Se asignó al inspector:</b> $inspector ";
            }

            if ($num_servicio) {
                $contenido .= "<b>Número de servicio:</b> <span class='badge bg-secondary'>$num_servicio</span> ";
            }

            
            if ($pdf_validacion) {
                $contenido .= "<a class='btn btn-primary btn-sm' target='_blank' href='/pdf_validar_solicitud/$pdf_validacion '><i class='ri-file-pdf-2-fill ri-30px'></i></a>";
            }


            // Retornar los datos con el contenido construido
            return [
                'description' => $log->description,
                'properties' => $log->properties, 
                'created_at' => $log->created_at->toDateTimeString(),
                'contenido' => trim($contenido),  // Eliminar posibles espacios extra
            ];
        });
    
    return response()->json(['success' => true, 'logs' => $logs]);
    
    }



    
    ///TRAZABILIDAD CERTIFICADOS
    public function TrackingCertificados($id)
    {   
        //$inspeccionId = inspecciones::where('id_solicitud', $id)->pluck('id_inspeccion')->first();

        $logs = Activity::where(function($query) use ($id) {
            // Filtrar los registros del modelo inspecciones con el id_solicitud en las properties
            $query->where('subject_type', 'App\Models\Certificado_Exportacion')
                ->where('properties->attributes->id_certificado', $id);
        })

        ->orWhere(function($query) use ($id) {
            $query->where('subject_type', 'App\Models\Revisor')
                ->where('properties->attributes->id_certificado', $id);
        })
        /*->orWhere(function($query) use ($id, $inspeccionId) {
            // Filtrar los registros del modelo Dictamen_instalaciones con id_inspeccion
            $query->where('subject_type', 'App\Models\Dictamen_Exportacion')
                ->where('properties->attributes->id_inspeccion', $id);
        })*/

        ->orderBy('created_at', 'asc')
        ->get()
        ->map(function($log) {
        
         $attributes = $log->properties['attributes'] ?? [];//todas las propiedades
         $evento = $log->event ?? '';
    
            // Buscar los objetos solo si los IDs están presentes
            $num_certificado = $attributes['num_certificado'] ?? null;
            //$num_certificado = $log->properties['attributes']['num_certificado'] ?? null;

            /*$num_dictamen = isset($log->properties['attributes']['id_dictamen']) 
                ? $log->properties['attributes']['id_dictamen'] ?? 'No encontrado' 
                : null;*/
            $num_dictamen = isset($log->properties['attributes']['id_dictamen']) 
                ? Dictamen_Exportacion::find($log->properties['attributes']['id_dictamen'])->num_dictamen ?? 'No encontrado' 
                : null;

            $empresa = null;
            if (isset($log->properties['attributes']['id_dictamen'])) {
                $dictamen = Dictamen_Exportacion::find($log->properties['attributes']['id_dictamen']);
                
                if ($dictamen && $dictamen->inspeccione && $dictamen->inspeccione->solicitud && $dictamen->inspeccione->solicitud->empresa) {
                    $empresa = $dictamen->inspeccione->solicitud->empresa->razon_social;
                }
            }

            //revisiones
            $num_revision = $attributes['numero_revision'] ?? null;
            
            $revisor = isset($attributes['id_revisor']) 
                ? User::find($attributes['id_revisor'])->name ?? null 
                : null;

            //para el PDF BITACORA
            $certificadoRevision = null;
            $id_revision = null;
                if (isset($attributes['id_certificado'], $attributes['id_revisor'])) {
                    $certificadoRevision = Revisor::where([
                        ['id_certificado', $attributes['id_certificado']],
                        ['id_revisor', $attributes['id_revisor']]
                    ])->first();

                    $id_revision = $certificadoRevision->id_revision ?? null;
                }
            $decision = $attributes['decision'] ?? null;
            $tipo_revision = $attributes['tipo_revision'] ?? null;
            $tipo = null;
             if ($tipo_revision == 2) {
                $tipo = 'Granel';
            }
            if ($tipo_revision == 3) {
                $tipo = 'Exportación';
            }



            $obs = $attributes['observaciones'] ?? null;
                $observaciones = null;
                if ($obs) {
                    $parsed = json_decode($obs, true);
                    // Si es JSON válido y tiene 'id_sustituye'
                    if (json_last_error() === JSON_ERROR_NONE && isset($parsed['id_sustituye'])) {
                        $cert_sust = Certificado_Exportacion::find($parsed['id_sustituye']);
                        $num_sustituido = optional($cert_sust)->num_certificado ?? 'Desconocido';
                        $observaciones = "Sustituye al certificado: <span class='badge bg-secondary'>$num_sustituido</span>";
                    } else {
                        // Si no es JSON válido, mostrar texto plano
                        $observaciones = $obs;
                    }
                }


            //CONTENIDO DE LA TABLA
            $contenido = '';  // Inicializar vacío
            //certificados
            if ($num_certificado) {
                $contenido .= "<b>Número del certificado:</b> <span class='badge bg-secondary'>$num_certificado</span>";
            }
            if ($empresa) {
                $contenido .= ", <b>Cliente:</b> $empresa ";
            }
 
            
            
            //revisiones
        if ( $evento === 'created' ){
            if ($num_revision) {
                $contenido .= "<b>Revisión:</b> $num_revision";
            }
            if ($revisor) {
                $contenido .= ", <b>Persona asignada:</b> $revisor";
            }
        
            if ($observaciones) {
                $contenido .= ", <b>Observaciones para el revisor:</b> $observaciones";
            }
        }


        $bitacora = '';
        if ( $evento === 'updated' ){
            if ($num_revision) {
                $contenido .= "<b>Revisión:</b> $num_revision "." realizada";
            }
            if ($decision) {
                $contenido .= ", <b>Resultado:</b> $decision";
            }
        
            if ($obs) {
                $contenido .= ", <b>Observaciones:</b> $obs";
            }

            
            //if ($num_certificado) {
                $bitacora .= "
                    <i class='ri-file-pdf-2-fill text-danger ri-40px cursor-pointer pdf'
                        data-bs-target='#mostrarPdf'
                        data-bs-toggle='modal'
                        data-bs-dismiss='modal'
                        data-num-certificado='$num_certificado'
                        data-id='$id_revision'
                        data-tipo_revision='$tipo_revision'>
                    </i>";
            //}

        }



            // Retornar los datos con el contenido construido
            return [
                'description' => $log->description,
                'properties' => $log->properties, 
                'created_at' => $log->created_at->toDateTimeString(),
                'contenido' => trim($contenido),  // Eliminar posibles espacios extra
                'bitacora' => $bitacora,
            ];
        });
    
    return response()->json(['success' => true, 'logs' => $logs]);
    
    }






}
