<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\solicitudesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class insertar_datos_bd extends Controller
{
    public function insertarSolicitudesDesdeAPI()
    {
        // URL de la API
        $url = 'https://oc.erpcidam.com/api/inspecciones/obtenerSolicitudes.php';

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
                    if($solicitud['id_cliente']==11 OR $solicitud['id_cliente']==32){
                        $solicitud['id_cliente'] = 4;
                    }

                    if($solicitud['id_subtipo']==23){
                        $solicitud['id_subtipo'] = 7;
                    }
                    if($solicitud['id_subtipo']==24){
                        $solicitud['id_subtipo'] = 8;
                    }
                    if($solicitud['id_subtipo']==27){
                        $solicitud['id_subtipo'] = 9;
                    }
                    if($solicitud['id_subtipo']==38){
                        $solicitud['id_subtipo'] = 10;
                    }
                    if($solicitud['id_subtipo']==43){
                        $solicitud['id_subtipo'] = 11;
                    }
                    if($solicitud['id_subtipo']==40){
                        $solicitud['id_subtipo'] = 14;
                    }
                    solicitudesModel::create([
                        'id_empresa'             => $solicitud['id_cliente'],
                        'folio'             => $solicitud['folio'],
                        'fecha_solicitud'   => $solicitud['fecha_solicitud'],
                        'fecha_visita'   => $solicitud['fecha_visita'].' '.$solicitud['hora_visita'],
                        'id_tipo'             => $solicitud['id_subtipo'],
                    ]);
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
