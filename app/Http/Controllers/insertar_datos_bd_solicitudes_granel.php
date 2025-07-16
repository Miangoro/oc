<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Certificados;
use App\Models\CertificadosGranel;
use App\Models\Dictamen_Granel;
use App\Models\Dictamen_instalaciones;
use App\Models\solicitudesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\empresaNumCliente;
use App\Models\inspecciones;
use App\Models\LotesGranel;

class insertar_datos_bd_solicitudes_granel extends Controller
{
    public function insertarSolicitudesGranelDesdeAPI()
    {
        // URL de la API
        $url = 'https://oc.erpcidam.com/api/inspecciones/obtenerSolicitudesGranel.php';

        // Realiza la solicitud GET a la API
        $response = Http::get($url);

        // Verifica si la solicitud fue exitosa
        if ($response->successful()) {
            // Decodifica los datos JSON
            $data = $response->json();

            // Verifica si existen los datos en la respuesta
            if (isset($data['datos'])) {
                $solicitudes = $data['datos'];

                // Recorre cada solicitud y crea un registro en la base de datos
                foreach ($solicitudes as $solicitud) {
                    /* if($solicitud['id_cliente']==11 OR $solicitud['id_cliente']==32){
                       
                    }*/
                   
          
                    if (!empty($solicitud['n_certificado'])) {
                        $certificados = CertificadosGranel::where('num_certificado', $solicitud['n_certificado'])->first();
                        $id_lote = $certificados?->loteGranel ?? null;
                         $id_lote->id_lote_granel ?? '0';
                        
                    } else {
                        $certificados = null; 
                    }
                    

                    if ($certificados) {

    // 1. Características en JSON
    $caracteristicas = json_encode([
        'id_lote_granel' => $id_lote->id_lote_granel ?? 0,
        'id_dictamen'    => $certificados->dictamen->id_dictamen,
    ]);

    // 2. Crear la nueva solicitud
    $nuevaSolicitud = SolicitudesModel::create([
        'id_empresa'      => $certificados->dictamen->inspeccione->solicitud->id_empresa,
        'id_tipo'         => 12,
        'id_dictamen'     => $certificados->dictamen->id_dictamen,
        'folio'           => $solicitud['folio'],
        'estatus'         => 'Emitido',
        'fecha_solicitud' => $solicitud['fecha_solicitud'],
        'fecha_visita'    => $solicitud['fecha_solicitud'],
        'id_instalacion'  => $certificados->dictamen->inspeccione->solicitud->id_instalacion,
        'id_predio'       => $certificados->id_certificado,
        'caracteristicas' => $caracteristicas,             // ← si tienes este campo en BD
    ]);

}

                }

                return response()->json(['message' => 'Solicitudes insertadas correctamente sss']);
            } else {
                return response()->json(['message' => 'No se encontraron datos en la API'], 404);
            }
        } else {
            return response()->json(['message' => 'Error al conectar con la API'], 500);
        }
    }
}
