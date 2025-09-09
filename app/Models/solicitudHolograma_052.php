<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitudHolograma_052 extends Model
{
    use HasFactory;

    protected $table = 'solicitud_hologramas_052'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_solicitud'; // Clave primaria de la tabla
    protected $fillable = [
        'id_solicitud',
        'folio',
        'id_empresa',
        'id_solicitante',
        'id_marca',
        'cantidad_hologramas',
        'id_direccion',
        'folio_inicial',
        'folio_final',
        'estatus',
        'comentarios',
        'tipo_pago',
        'fecha_envio',
        'costo_envio',
        'no_guia',
        'tipo',


    ];

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }

    public function direcciones()
    {
        return $this->belongsTo(direcciones::class, 'id_direccion', 'id_direccion');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'id_solicitante', 'id');
    }


    public function marcas()
    {
        return $this->belongsTo(marcas::class, 'id_marca', 'id_marca');
    }

    public function empresanumcliente()
    {
        return $this->belongsTo(empresaNumCliente::class, 'id_empresa', 'id_empresa');
    }

    public function empresaNumClientesNorma2()
    {
        return $this->hasMany(empresaNumCliente::class, 'id_empresa', 'id_empresa')
                    ->where('id_norma', 2)
                    ->whereNotNull('numero_cliente');
    }



    public function cantidadActivados($id_solicitud)
    {
        // Obtener los registros que coincidan con la solicitud
        $activaciones = activarHologramasModelo_052::where("id_solicitud", $id_solicitud)->get();

        $totalActivados = 0;

        foreach ($activaciones as $activacion) {
            // Decodificar el JSON almacenado en la columna 'folios'
            $folios = json_decode($activacion->folios, true);

            // Asegurarse de que existen los arrays folio_inicial y folio_final
            if (isset($folios['folio_inicial']) && isset($folios['folio_final'])) {
                // Iterar sobre los valores de folio_inicial y folio_final
                foreach ($folios['folio_inicial'] as $key => $folio_inicial) {
                    $folio_final = $folios['folio_final'][$key] ?? 0;

                    // Calcular el rango activado y sumar al total
                    $totalActivados += ($folio_final - $folio_inicial) + 1; // +1 para incluir ambos folios
                }
            }
        }

        return $totalActivados;
    }

        public function cantidadDisponibles()
        {
            // Obtener la cantidad total autorizada para esa solicitud
            $solicitud = solicitudHolograma_052::find($this->id_solicitud);

            if (!$solicitud || !isset($solicitud->cantidad_hologramas)) {
                return 0; // O lanza excepción si quieres manejar errores
            }

            $cantidad_hologramas = $solicitud->cantidad_hologramas;

            // Obtener la cantidad ya activada
            $activados = $this->cantidadActivados($this->id_solicitud);

            // Calcular disponibles
            $disponibles = $cantidad_hologramas - $activados;

            return max($disponibles, 0); // Nunca negativos
        }



    public function cantidadMermas($id_solicitud)
    {
        // Obtener los registros que coincidan con la solicitud
        $activaciones = activarHologramasModelo_052::where("id_solicitud", $id_solicitud)->get();

        $totalMermas = 0;

        foreach ($activaciones as $activacion) {
            // Decodificar el JSON almacenado en la columna 'mermas'
            $mermas = json_decode($activacion->mermas, true);

            // Asegurarse de que mermas es un array
            if (is_array($mermas) && isset($mermas['mermas'])) {
                // Sumar los valores de mermas
                foreach ($mermas['mermas'] as $merma) {
                    // Verificar si el valor de mermas es un número y no es nulo
                    if (is_numeric($merma)) {
                        $totalMermas += $merma;
                    }
                }
            }
        }

        return $totalMermas;
    }


}
