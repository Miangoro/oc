<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dictamen_Exportacion;
use App\Models\Dictamen_Granel;
use App\Models\Dictamen_instalaciones;
use App\Models\solicitudesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\empresaNumCliente;
use App\Models\inspecciones;

class insertar_datos_bd_dictamenes_exportacion extends Controller
{
    public function insertarDictamenesExportacionDesdeAPI()
    {
        // URL de la API
        $url = 'https://oc.erpcidam.com/api/inspecciones/obtenerDictamenesExportación.php';

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
                   
                    if (!empty($solicitud['num_servicio'])) {
                        $inspecciones = inspecciones::where('num_servicio', $solicitud['num_servicio'])->first();
                        
                    } else {
                        $inspecciones = null; // O maneja este caso según corresponda
                    }
                    

                    if ($inspecciones AND !empty($inspecciones->solicitud->id_instalacion)) {

                        $firma = $solicitud['firma_oc'];

                    if ($firma === "../img/Firma Inspector Erik.png") {
                        echo $id_firmante = 9;
                    } elseif (in_array($firma, ["../img/firma_mario.png"])) {
                        echo $id_firmante = 14;
                    } elseif (in_array($firma, ["../img/firma_firma karen.png"])) {
                        echo $id_firmante = 6;
                    }
                    else {
                        echo $id_firmante = 14;
                    }

                        

                        //if ($solicitud['n_servicio'] ==$inspecciones->n) {
                            $id_solicitud = Dictamen_Exportacion::create([
                                'id_inspeccion'   => $inspecciones->id_inspeccion,
                                'num_dictamen' => preg_replace('/CIDAM C-EXP(-?\d+)(\/\d{4}(-[A-Z])?)?/','UMEXP$1',$solicitud['n_certificado']),
                                'fecha_emision'   => $solicitud['fecha_expedicion'],
                                'fecha_vigencia'  => $solicitud['fecha_vigencia'],
                                'id_firmante'        => $id_firmante,
                                
                            ]);
                            
                           
                        //}
                    }
                }

                return response()->json(['message' => 'Solicitudes insertadas correctamente']);
            } else {
                return response()->json(['message' => 'No se encontraron datos en la API'], 404);
            }
        } else {
            return response()->json(['message' => 'Error al conectar con la API'], 500);
        }
    }
}
