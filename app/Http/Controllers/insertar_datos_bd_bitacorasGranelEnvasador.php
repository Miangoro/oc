<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BitacoraMezcal;
use App\Models\empresaNumCliente;
use App\Models\predio_plantacion;
use App\Models\PredioCoordenadas;
use App\Models\Predios;
use App\Models\Predios_Inspeccion;
use App\Models\PrediosCaracteristicasMaguey;
use App\Models\solicitudesModel;
use App\Models\tipos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class insertar_datos_bd_bitacorasGranelEnvasador extends Controller
{
    public function insertarBitacorasGranelEnvasadorDesdeAPI()
    {
        // URL de la API
        $url = 'https://oc.erpcidam.com/api/inspecciones/obtenerBitacorasGranelEnvasador.php';

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
                    $id_empresa = empresaNumCliente::where('numero_cliente', trim($solicitud['numero_cliente']))->value('id_empresa');
                 $firma = $solicitud['firma'];
                    if($id_empresa){

                    if ($firma === "../img/Firma Inspector Erik.png") {
                        echo $id_firmante = 9;
                    }elseif (in_array($firma, ["../img/firma_mario.png", "../img/firma_mayra.png"])) { 
                        echo $id_firmante = 14;
                    }elseif (in_array($firma, ["../img/firma_firma_digital-1-removebg-preview.png"])) { 
                            echo $id_firmante = 18;
                    }elseif (in_array($firma, ["../img/firma_7399901d5e2accc11770d49aa44f4af9 (2).png"])) { 
                            echo $id_firmante = 15;
                    }elseif (in_array($firma, ["../img/firma_firma karen.png"])) { 
                            echo $id_firmante = 6;
                    }elseif (in_array($firma, ["../img/firma_ray.png"])) { 
                            echo $id_firmante = 10;
                    
                    }elseif (in_array($firma, ["../img/firma_86b4af2fbf8ba5e5807ac33e1b8a4563.png"])) { 
                            echo $id_firmante = 17;
                    
                    }elseif (in_array($firma, ["../img/firma Daniela Jarquin.png"])) { 
                            echo $id_firmante = 13;
                    }elseif (in_array($firma, ["../img/F_LIDIA.png"])) { 
                            echo $id_firmante = 20;
                    }else{
                        $id_firmante = 0;
                    }
                
                    // Crear el registro del predio
                    $idPredio = BitacoraMezcal::create([
                        'id_empresa'             =>  $id_empresa,
                        'tipo_operacion'       => 'Entradas y salidas',
                        'tipo'             => 2, //Solo envasador
                        'fecha'          => $solicitud['fecha'],
                        'id_tanque'       => $solicitud['id_tanque'],
                        'operacion_adicional'            => $solicitud['operacion_adicional'],
                        'volumen_inicial'      => $solicitud['volumen_inicial'],
                        'alcohol_inicial'             => $solicitud['alcohol_inicial'],


                        'procedencia_entrada'             => $solicitud['procedencia_entrada'],
                        'volumen_entrada'             => $solicitud['volumen_entrada'],
                        'agua'             => $solicitud['agua_entrada'],
                        'volumen_salidas'             => $solicitud['volumen_salidas'],
                        'alcohol_salidas'             => $solicitud['alcohol_salidas'],
                        'destino_salidas'             => $solicitud['destino_salidas'],
                        'volumen_final'             => $solicitud['volumen_final'],
                        'alcohol_final'             => $solicitud['alcohol_final'],
                        'alcohol_final'             => $solicitud['observaciones'],
                        'id_firmante'             => $id_firmante,

                        
                         
                        
                    ]);
                
                  
                    
   

                        
                 



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
