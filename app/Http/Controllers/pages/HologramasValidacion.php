<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\activarHologramasModelo;
use App\Models\Certificado_Exportacion;
use App\Models\empresa;
use App\Models\empresaNumCliente;
use App\Models\marcas;
use App\Models\Guias;
use App\Models\lotes_envasado;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HologramasValidacion extends Controller
{
  public function index2($folio)
  {
    $pageConfigs = ['myLayout' => 'blank'];

    $numero_cliente = substr($folio, 0, 12); // Extrae los primeros 13 caracteres
    $cliente = empresaNumCliente::with('empresa')
      ->where('numero_cliente', $numero_cliente)
      ->first();

    $folio_marca = substr($folio, 14, 1);
    $marca = marcas::where('folio', $folio_marca)->where('id_empresa', $cliente->id_empresa)->first();


    $folio_numerico = (int) substr($folio, -6); // Suponiendo que los últimos 6 dígitos son el número del folio
    $ya_activado = false;
    $datosHolograma = null;

    $activaciones = activarHologramasModelo::with('solicitudHolograma')
      ->whereHas('solicitudHolograma', function ($query) use ($marca) {
        $query->where('id_marca', $marca->id_marca);
      })
      ->get();




    foreach ($activaciones as $activacion) {
      $folios_activados = json_decode($activacion->folios, true);

      for ($i = 0; $i < count($folios_activados['folio_inicial']); $i++) {
        $activado_folio_inicial = (int) $folios_activados['folio_inicial'][$i];
        $activado_folio_final = (int) $folios_activados['folio_final'][$i];

        if ($folio_numerico >= $activado_folio_inicial && $folio_numerico <= $activado_folio_final) {
          $ya_activado = true;
          $datosHolograma = $activacion; // Aquí se guarda el modelo actual
          break 2; // Salimos de ambos bucles
        }
      }
    }



    return view('content.pages.pages-hologramas-validacion', compact('pageConfigs', 'folio', 'cliente', 'marca', 'ya_activado', 'datosHolograma'));
  }



  public function qr_certificado($id)
  {
    /*$certificado = Certificado_Exportacion::where('id_certificado', $id)
      ->get();*/
    $data = Certificado_Exportacion::find($id);

    if (!$data) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
    }

    $empresa = $data->dictamen->inspeccione->solicitud->empresa ?? null;
    
    $datos = $data->dictamen->inspeccione->solicitud->caracteristicas ?? null; //Obtener Características Solicitud
        $caracteristicas =$datos ? json_decode($datos, true) : []; //Decodificar el JSON
        $aduana_salida = $caracteristicas['aduana_salida'] ?? '';
        $no_pedido = $caracteristicas['no_pedido'] ?? '';
        $detalles = $caracteristicas['detalles'] ?? [];//Acceder a detalles (que es un array)
        // Acceder a los detalles
            $botellas = $detalles[0]['cantidad_botellas'] ?? '';
            $cajas = $detalles[0]['cantidad_cajas'] ?? '';
        // Obtener todos los IDs de los lotes
        $loteIds = collect($detalles)->pluck('id_lote_envasado')->filter()->all();//elimina valor vacios y devuelve array
        // Buscar los lotes envasados
        $lotes = !empty($loteIds) ? lotes_envasado::whereIn('id_lote_envasado', $loteIds)->get()
            : collect(); // Si no hay IDs, devolvemos una colección vacía


    return view('content.pages.visualizar_certificado_qr', [
      'datos' => $data,
      'lotes' =>$lotes,
      'empresa' => $empresa->razon_social ?? 'No encontrado',
      'rfc' => $empresa->rfc ?? 'No encontrado',
      'pais' => $data->dictamen->inspeccione->solicitud->direccion_destino->pais_destino ?? 'No encontrado',
      'envasadoEN' => $data->dictamen->inspeccione->solicitud->instalacion_envasado->direccion_completa ?? 'No encontrado',
    ]);
  }



  public function validar_dictamen()
  {

    return view('content.pages.visualizador_dictamen_qr');
  }



  public function qr_guias($id)
  {
    $guias = Guias::with('Predios','empresa')
      ->where('id_guia', $id)
      ->get();

    return view('content.pages.visualizar_guias_qr', [
      'guia' => $guias[0],
    ]);
  }


}
