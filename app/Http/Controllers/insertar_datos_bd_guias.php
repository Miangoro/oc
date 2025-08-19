<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Certificados;
use App\Models\Dictamen_instalaciones;
use App\Models\Documentacion_url;
use App\Models\empresa;
use App\Models\solicitudesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\empresaNumCliente;
use App\Models\Guias;
use App\Models\inspecciones;
use App\Models\predio_plantacion;
use App\Models\Predios;
use Illuminate\Support\Facades\Log;

class insertar_datos_bd_guias extends Controller
{
    public function insertarGuiasDesdeAPI()
    {
        // URL de la API
        $url = 'https://antiguaplataforma.erpcidam.com/api/guias/obtenerGuias.php';

        // Realiza la solicitud GET a la API
        $response = Http::get($url);

        // Verifica si la solicitud fue exitosa
        if ($response->successful()) {
            // Decodifica los datos JSON
            $data = $response->json();

            

        
            // Verifica si existen los datos en la respuesta
            if (isset($data['datos'])) {
                $solicitudes = $data['datos'];

                   $anio = now()->format('Y');
    $contadores = []; // guarda el folio asignado a cada predio
    $contadorGlobal = 1; // solo aumenta cuando aparece un predio nuevo
               
                foreach ($solicitudes as $solicitud) {  
                    if (!empty($solicitud['numero_predio_cidam'])) {
                        $sol = Predios::where('num_predio', $solicitud['numero_predio_cidam'])->first();
                         $plantacion = null;
                   $plantacion = predio_plantacion::with('tipo')
    ->where('id_predio', $sol->id_predio)
    ->whereHas('tipo', function($q) use ($solicitud) {
        $q->whereRaw("nombre COLLATE utf8mb4_general_ci LIKE ?", ["%{$solicitud['nombre_maguey']}%"]);
    })
    ->first();

                    
                    } else {
                        $sol = null;
                    }
                
                      if ($sol && $plantacion) {

                        $predioId = $solicitud['numero_predio_cidam'];

            // si es la primera vez que aparece el predio, le generamos un folio
            if (!isset($contadores[$predioId])) {
                $run_folio = 'SOL-GUIA-' . str_pad($contadorGlobal, 6, '0', STR_PAD_LEFT) . '-' . $anio;
                $contadores[$predioId] = $run_folio;
                $contadorGlobal++;
            }

            // usamos siempre el mismo folio para ese predio
            $run_folio = $contadores[$predioId];



                          $guia = new Guias();    
                          $guia->id_plantacion = $plantacion->id_plantacion;
                          $guia->run_folio = $run_folio;
                          $guia->folio = $solicitud['folio_guia'];
                          $guia->id_empresa = $sol->id_empresa;
                          $guia->id_predio = $sol->id_predio;
                          $guia->numero_plantas = $solicitud['numero_plantas'];
                          $guia->numero_guias = 0;
                          $guia->num_anterior = $solicitud['num_anterior'];
                           $guia->num_comercializadas = $solicitud['num_comercializadas'];
                           $guia->mermas_plantas = $solicitud['mermas_plantas'];
                           $guia->art = $solicitud['art'];
                           $guia->kg_maguey = $solicitud['kg_maguey'];
                           $guia->no_lote_pedido = $solicitud['no_lote_pedido'];
                           $guia->fecha_corte = $solicitud['fecha_corte'];
                           $guia->observaciones = $solicitud['observaciones'];
                           $guia->nombre_cliente = $solicitud['nombre_cliente'];
                           $guia->fecha_ingreso = $solicitud['fecha_ingreso'];
                           $guia->domicilio = $solicitud['domicilio'];
                          $guia->save();

                          

                        // Crear instancia de Documentacion_url
                        $documentacion_url = new Documentacion_url();
                        $documentacion_url->id_relacion = $guia->id_guia;
                        $documentacion_url->id_documento = 71; //132 art
                        $documentacion_url->id_empresa = $sol->id_empresa;
                        // Obtener URL remota
                        $fileUrl = "https://antiguaplataforma.erpcidam.com/apps/georeferenciacion/pdfs/" . $solicitud['documento']; // Construye la URL completa
                        
                        // Obtener solo el nombre del archivo
                        $fileName = basename($fileUrl);
                        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION); // "pdf"
                        $nombreArchivo = str_replace('/', '-','Guía de traslado de agave '.$solicitud['folio_guia']) . '_' . time() . '.' . $fileExtension;

                        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $sol->id_empresa)->first();
                        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                            return !empty($numero);
                        });
                
                        // Definir la carpeta de almacenamiento
                        $storagePath = "uploads/{$numeroCliente}/guias";
                
                        // Ruta final en storage/app/public/
                        $destinationPath = storage_path("app/public/{$storagePath}/{$nombreArchivo}");
                
                        // Crear la carpeta si no existe
                        if (!file_exists(storage_path("app/public/{$storagePath}"))) {
                            mkdir(storage_path("app/public/{$storagePath}"), 0777, true);
                        }
                
                        // Descargar el archivo desde la URL y guardarlo en el servidor
                        $fileContent = file_get_contents($fileUrl);
                        if ($fileContent !== false) {
                            file_put_contents($destinationPath, $fileContent);
                
                            // Guardar la ruta en la base de datos
                            $documentacion_url->nombre_documento = 'Guía de traslado de agave '.$solicitud['folio_guia'];
                            $documentacion_url->url =  $nombreArchivo;
                            $documentacion_url->fecha_vigencia = null;
                            $documentacion_url->save();
                        } else {
                            Log::error("No se pudo descargar el archivo desde: {$fileUrl}");
                        }


                        $documentacion_url = new Documentacion_url();
                        $documentacion_url->id_relacion = $guia->id_guia;
                        $documentacion_url->id_documento = 132; //132 art
                        $documentacion_url->id_empresa = $sol->id_empresa;
                        // Obtener URL remota
                        $fileUrl = "https://antiguaplataforma.erpcidam.com/apps/georeferenciacion/pdfs/" . $solicitud['documento_art']; // Construye la URL completa
                        
                        // Obtener solo el nombre del archivo
                        $fileName = basename($fileUrl);
                        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION); // "pdf"
                        $nombreArchivo = str_replace('/', '-','Resultados de ART '.$solicitud['folio_guia']) . '_' . time() . '.' . $fileExtension;

                        $empresa = empresa::with("empresaNumClientes")->where("id_empresa", $sol->id_empresa)->first();
                        $numeroCliente = $empresa->empresaNumClientes->pluck('numero_cliente')->first(function ($numero) {
                            return !empty($numero);
                        });
                
                        // Definir la carpeta de almacenamiento
                        $storagePath = "uploads/{$numeroCliente}/guias";
                
                        // Ruta final en storage/app/public/
                        $destinationPath = storage_path("app/public/{$storagePath}/{$nombreArchivo}");
                
                        // Crear la carpeta si no existe
                        if (!file_exists(storage_path("app/public/{$storagePath}"))) {
                            mkdir(storage_path("app/public/{$storagePath}"), 0777, true);
                        }
                
                        // Descargar el archivo desde la URL y guardarlo en el servidor
                        if (!empty($solicitud['documento_art'])) {
    $fileUrl = "https://antiguaplataforma.erpcidam.com/apps/georeferenciacion/pdfs/" . $solicitud['documento_art'];
    
    $fileContent = @file_get_contents($fileUrl);

    if ($fileContent !== false) {
        file_put_contents($destinationPath, $fileContent);

        // Guardar la ruta en la base de datos
        $documentacion_url->nombre_documento = 'Resultados de ART '.$solicitud['folio_guia'];
        $documentacion_url->url = $nombreArchivo;
        $documentacion_url->fecha_vigencia = null;
        $documentacion_url->save();
    } else {
        Log::error("No se pudo descargar el archivo desde: {$fileUrl}");
    }
} else {
    Log::warning("El documento ART está vacío para la solicitud: ".$solicitud['folio_guia']);
}





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
