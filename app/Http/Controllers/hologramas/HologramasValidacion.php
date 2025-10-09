<?php

namespace App\Http\Controllers\hologramas;

use App\Http\Controllers\Controller;
use App\Models\activarHologramasModelo;
use App\Models\Certificado_Exportacion;
use App\Models\coordenadas;
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

     $tipo_holograma = substr($folio, 13, 1);



    $folio_numerico = (int) substr($folio, -7); // Suponiendo que los últimos 7 dígitos son el número del folio
    $ya_activado = false;
    $datosHolograma = null;

    $activaciones = activarHologramasModelo::with('solicitudHolograma')
      ->whereHas('solicitudHolograma', function ($query) use ($marca) {
        $query->where('id_marca', $marca->id_marca);
      })
      ->get();



    foreach ($activaciones as $activacion) {
    $folios_activados = json_decode($activacion->folios, true);

    if (!isset($folios_activados['folio_inicial'], $folios_activados['folio_final'])) {
        continue; // si no existen, pasamos a la siguiente activación
    }

    for ($i = 0; $i < count($folios_activados['folio_inicial']); $i++) {
        // Validamos que existan ambos extremos y no estén vacíos
        if (empty($folios_activados['folio_inicial'][$i]) || empty($folios_activados['folio_final'][$i])) {
            continue;
        }

        $activado_folio_inicial = (int) $folios_activados['folio_inicial'][$i];
        $activado_folio_final   = (int) $folios_activados['folio_final'][$i];

        // Validamos que el folio esté dentro del rango correcto
        if (
            $folio_numerico >= $activado_folio_inicial &&
            $folio_numerico <= $activado_folio_final &&
            $activacion->solicitudHolograma->tipo == $tipo_holograma
        ) {
            $ya_activado   = true;
            $datosHolograma = $activacion;
            break 2; // salir de ambos bucles
        }
    }
}






    return view('hologramas.qr_holograma_070', compact('pageConfigs', 'folio', 'cliente', 'marca', 'ya_activado', 'datosHolograma'));
  }

  public function qr_holograma_052($folio)
  {
    $pageConfigs = ['myLayout' => 'blank'];

    $numero_cliente = substr($folio, 0, 12); // Extrae los primeros 13 caracteres
    $cliente = empresaNumCliente::with('empresa')
      ->where('numero_cliente', $numero_cliente)
      ->first();

    $folio_marca = substr($folio, 14, 1);
    $marca = marcas::where('folio', $folio_marca)->where('id_empresa', $cliente->id_empresa)->first();

     $tipo_holograma = substr($folio, 13, 1);



    $folio_numerico = (int) substr($folio, -7); // Suponiendo que los últimos 7 dígitos son el número del folio
    $ya_activado = false;
    $datosHolograma = null;

    $activaciones = activarHologramasModelo::with('solicitudHolograma')
      ->whereHas('solicitudHolograma', function ($query) use ($marca) {
        $query->where('id_marca', $marca->id_marca);
      })
      ->get();



    foreach ($activaciones as $activacion) {
    $folios_activados = json_decode($activacion->folios, true);

    if (!isset($folios_activados['folio_inicial'], $folios_activados['folio_final'])) {
        continue; // si no existen, pasamos a la siguiente activación
    }

    for ($i = 0; $i < count($folios_activados['folio_inicial']); $i++) {
        // Validamos que existan ambos extremos y no estén vacíos
        if (empty($folios_activados['folio_inicial'][$i]) || empty($folios_activados['folio_final'][$i])) {
            continue;
        }

        $activado_folio_inicial = (int) $folios_activados['folio_inicial'][$i];
        $activado_folio_final   = (int) $folios_activados['folio_final'][$i];

        // Validamos que el folio esté dentro del rango correcto
        if (
            $folio_numerico >= $activado_folio_inicial &&
            $folio_numerico <= $activado_folio_final &&
            $activacion->solicitudHolograma->tipo == $tipo_holograma
        ) {
            $ya_activado   = true;
            $datosHolograma = $activacion;
            break 2; // salir de ambos bucles
        }
    }
}






    return view('hologramas.qr_holograma_052', compact('pageConfigs', 'folio', 'cliente', 'marca', 'ya_activado', 'datosHolograma'));
  }



  public function qr_certificado($id)
  {
    $data = Certificado_Exportacion::find($id);

    if (!$data) {
        return abort(404, 'Registro no encontrado.');
        //return response()->json(['message' => 'Registro no encontrado.', $data], 404);
    }

    $empresa = $data->dictamen->inspeccione->solicitud->empresa ?? null;
    $datos = $data->dictamen->inspeccione->solicitud->caracteristicas ?? null; //Obtener Características Solicitud
        $caracteristicas =$datos ? json_decode($datos, true) : []; //Decodificar el JSON
        $detalles = $caracteristicas['detalles'] ?? [];//Acceder a detalles (que es un array)
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

   public function guardar_coordenadas(Request $request)
    {
        $request->validate([
            'folio_holograma' => 'required|string',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'fecha'   => Carbon::now()
        ]);

        coordenadas::create($request->only('folio_holograma','latitud','longitud','fecha'));

        return response()->json(['success' => true]);
    }


}
