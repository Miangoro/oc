<?php

namespace App\Http\Controllers\solicitudCliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\empresa;
use App\Models\empresa_producto;
use App\Models\empresa_norma;
use App\Models\empresa_actividad;
use App\Models\empresaNumCliente;
use App\Models\solicitud_informacion;
use App\Models\catalogo_bebidas;
use App\Models\respuesta_bebidas;
use App\Models\catalogo_clasificacion_bebidas;
use App\Models\estados;
use App\Mail\correoEjemplo;
use App\Models\instalaciones;
use Illuminate\Support\Facades\Mail;

class solicitudClienteController extends Controller
{
  public function index()
  {
    $estados = estados::orderBy('nombre')->get(['id', 'nombre AS estado']);

    return view('solicitudes.solicitudCliente', compact('estados'));
  }


  public function RegistroExitoso()
  {
    return view('solicitudes.registro_exitoso');
  }

  public function registrar(Request $request)
  {
    /* dd($request->all()); */
    $empresa = new empresa();
    $empresa->razon_social = $request->razon_social;
    $empresa->domicilio_fiscal = $request->domicilio_fiscal;
    $empresa->estado = $request->estado_fiscal;
    $empresa->regimen = $request->regimen;
    $empresa->correo = $request->correo;
    $empresa->telefono = $request->telefono;
    $empresa->tipo = 1; //en este caso siempre es 1 porque es un cliente prospecto
    $empresa->rfc = $request->rfc;
    $empresa->representante = $request->representante  ?: 'No aplica';
    $empresa->save();
    $id_empresa = $empresa->id_empresa;

    for ($i = 0; $i < count($request->producto); $i++) {
      $producto = new empresa_producto();
      $producto->id_producto = $request->producto[$i];
      $producto->id_empresa = $id_empresa;
      $producto->save();
    }

            // Mapeo de actividades a tipos
            $mapaTipos = [
                1 => 'Productora',       // Productor de Agave
                3 => 'Productora',       // Productor de Mezcal
                2 => 'Envasadora',       // Envasador de Mezcal
                4 => 'Comercializadora', // Comercializador de Mezcal
            ];

            // Determinar tipos según actividades
            $tiposInstalacion = [];
            if (!empty($request->actividad) && is_array($request->actividad)) {
                foreach ($request->actividad as $actividad) {
                    if (isset($mapaTipos[$actividad]) && !in_array($mapaTipos[$actividad], $tiposInstalacion)) {
                        $tiposInstalacion[] = $mapaTipos[$actividad];
                    }
                }
            }

            // Si no se detectaron tipos, poner "Sin definir"
            if (empty($tiposInstalacion)) {
                $tiposInstalacion[] = 'Sin definir';
            }

            // Guardar UNA sola instalación con todos los tipos
            $instalacion = new instalaciones();
            $instalacion->id_empresa = $id_empresa;
            $instalacion->direccion_completa = $request->direccion_completa;
            $instalacion->estado = $request->id_estado;
            $instalacion->tipo = json_encode($tiposInstalacion); // ["Productora","Envasadora"]

            // Opcionales
            $instalacion->folio = $request->folio ?? null;
            $instalacion->responsable = $request->responsable ?? null;
            $instalacion->certificacion = $request->certificacion ?? null;
            $instalacion->id_organismo = $request->id_organismo ?? null;
            $instalacion->fecha_emision = $request->fecha_emision ?? null;
            $instalacion->fecha_vigencia = $request->fecha_vigencia ?? null;
            $instalacion->eslabon = $request->eslabon ?? null;

            $instalacion->save();
            // Guardar actividades normalmente en empresa_actividad
            $mapaActividades = [
                1 => 1,
                2 => 3,
                3 => 2,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
            ];

            if (!empty($request->actividad) && is_array($request->actividad)) {
                foreach ($request->actividad as $valorActividad) {
                    if (isset($mapaActividades[$valorActividad])) {
                        $id_actividad = $mapaActividades[$valorActividad];

                        if (!empresa_actividad::where('id_empresa', $id_empresa)
                                ->where('id_actividad', $id_actividad)
                                ->exists()) {
                            $actividad = new empresa_actividad();
                            $actividad->id_empresa = $id_empresa;
                            $actividad->id_actividad = $id_actividad;
                            $actividad->save();
                        }
                    }
                }
            }




    /* if (!empty($request->domicilio_productora) && !empty($request->estado_productora)) {
      $productora = new instalaciones();
      $productora->direccion_completa = $request->domicilio_productora;
      $productora->estado = $request->estado_productora;
      $productora->id_empresa = $id_empresa;
      $productora->tipo = 'Productora';
      $productora->save();
    }

    if (!empty($request->domicilio_envasadora) && !empty($request->estado_envasadora)) {
      $envasadora = new instalaciones();
      $envasadora->direccion_completa = $request->domicilio_envasadora;
      $envasadora->estado = $request->estado_envasadora;
      $envasadora->id_empresa = $id_empresa;
      $envasadora->tipo = 'Envasadora';
      $envasadora->save();
    }

    if (!empty($request->domicilio_comercializadora) && !empty($request->estado_comercializadora)) {
      $comercializadora = new instalaciones();
      $comercializadora->direccion_completa = $request->domicilio_comercializadora;
      $comercializadora->estado = $request->estado_comercializadora;
      $comercializadora->id_empresa = $id_empresa;
      $comercializadora->tipo = 'Comercializadora';
      $comercializadora->save();
    }
        if (!empty($request->actividad) && is_array($request->actividad)) {
        foreach ($request->actividad as $id_actividad) {
            $actividad = new empresa_actividad();
            $actividad->id_actividad = $id_actividad;
            $actividad->id_empresa = $id_empresa;
            $actividad->save();
        }
    } */
/*    if ($request->has('bebida')) {
    foreach ($request->bebida as $id_clasificacion => $bebidas) {
        foreach ($bebidas as $campo => $valor) { // <- ahora $campo = "Coctel_de:"
            if ($valor) {
                // Clasificaciones 5 y 6: siempre texto personalizado
                if (in_array($id_clasificacion, [5, 6])) {
                    respuesta_bebidas::create([
                        'id_empresa' => $id_empresa,
                        'id_clasificacion' => $id_clasificacion,
                        'id_bebida' => null,
                        'bebida_personalizada' => "$campo $valor" // queda "Coctel_de: manguito"
                    ]);
                } else {
                    // Para los demás tipos, intentamos buscar en el catálogo
                    $catalogo = catalogo_bebidas::find($valor);
                    if ($catalogo) {
                        respuesta_bebidas::create([
                            'id_empresa' => $id_empresa,
                            'id_clasificacion' => $id_clasificacion,
                            'id_bebida' => $catalogo->id_bebida,
                            'bebida_personalizada' => null
                        ]);
                    } else {
                        // Si es un texto libre, se guarda como personalizado
                        respuesta_bebidas::create([
                            'id_empresa' => $id_empresa,
                            'id_clasificacion' => $id_clasificacion,
                            'id_bebida' => null,
                            'bebida_personalizada' => $valor
                        ]);
                    }
                }
            }
        }
    }
} */
if ($request->has('bebida')) {
    foreach ($request->bebida as $id_clasificacion => $bebidas) {
        foreach ($bebidas as $campo => $valor) {
            if ($valor) {

                // Clasificación 1 y 3 → guardar id_bebida + personalizado si hay texto libre
                if (in_array($id_clasificacion, [1, 3])) {
                    $id_bebida = is_numeric($valor) ? $valor : null;
                    respuesta_bebidas::create([
                        'id_empresa' => $id_empresa,
                        'id_clasificacion' => $id_clasificacion,
                        'id_bebida' => $id_bebida,
                        'bebida_personalizada' => is_string($valor) && !is_numeric($valor) ? $valor : null,
                    ]);
                    continue;
                }

                // Clasificaciones 5 y 6 → siempre texto personalizado (Cócteles)
                if (in_array($id_clasificacion, [5, 6])) {
                    respuesta_bebidas::create([
                        'id_empresa' => $id_empresa,
                        'id_clasificacion' => $id_clasificacion,
                        'id_bebida' => null,
                        'bebida_personalizada' => "$campo $valor",
                    ]);
                    continue;
                }

                // Para otras clasificaciones intentamos buscar en catálogo
                $catalogo = catalogo_bebidas::find($valor);
                if ($catalogo) {
                    respuesta_bebidas::create([
                        'id_empresa' => $id_empresa,
                        'id_clasificacion' => $id_clasificacion,
                        'id_bebida' => $catalogo->id_bebida,
                        'bebida_personalizada' => null,
                    ]);
                } else {
                    // Texto libre ingresado por el usuario
                    respuesta_bebidas::create([
                        'id_empresa' => $id_empresa,
                        'id_clasificacion' => $id_clasificacion,
                        'id_bebida' => null,
                        'bebida_personalizada' => $valor,
                    ]);
                }
            }
        }
    }
}




// Guardar normas asociadas a la empresa
    if (is_array($request->norma)) {
        foreach ($request->norma as $id_norma) {
            $empresaNorma = new empresaNumCliente();
            $empresaNorma->id_empresa = $id_empresa;
            $empresaNorma->id_norma = $id_norma;
            $empresaNorma->save();
        }
    }

    $solicitud = new solicitud_informacion();
    $solicitud->id_empresa = $id_empresa;
    $solicitud->info_procesos = $request->info_procesos;
    $solicitud->cual = $request->cual;
    $solicitud->certificacion = $request->certificacion;
    $solicitud->emiteCertificacion = $request->emiteCertificacion;
    $solicitud->save();

    $details = [
      'title' => "Solicitud de información al cliente",
      'nombre' => $empresa->razon_social,
      'contenido' => "Tu solicitud fué enviada con éxito, a la brevedad posible un miembro del equipo se contactará contigo."
    ];


    //Mail::to($request->correo)->send(new correoEjemplo($details));

    return view('solicitudes.registro_exitoso');
  }


}
