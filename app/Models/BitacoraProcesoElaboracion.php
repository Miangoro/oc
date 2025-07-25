<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraProcesoElaboracion extends Model
{
    use HasFactory;
    protected $table = 'bitacora_proceso_elaboracion';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fecha_ingreso',
        'id_empresa',
        'lote_granel',
        'numero_tapada',
        'numero_guia',
        'id_tipo_maguey',
        'numero_pinas',
        'kg_maguey',
        'porcentaje_azucar',
        'kg_coccion',
        'fecha_inicio_coccion',
        'fecha_fin_coccion',
        'molienda_total_formulado',
        'total_puntas_volumen',
        'total_puntas_porcentaje',
        'total_mezcal_volumen',
        'total_mezcal_porcentaje',
        'total_colas_volumen',
        'total_colas_porcentaje',
        'observaciones',
        'id_firmante',
    ];

    public $timestamps = false;
       // En BitacoraMezcal.php
    public function empresaBitacora()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }
    public function firmante()
    {
        return $this->belongsTo(User::class, 'id_firmante');
    }
    public function molienda()
    {
        return $this->hasMany(BitacoraProcesoMoliendaDestilacion::class, 'id_bitacora');
    }

    public function segundaDestilacion()
    {
        return $this->hasMany(BitacoraProcesoSegundaDestilacion::class, 'id_bitacora');
    }

    protected static function booted()
    {
        static::deleting(function ($bitacora) {
            $bitacora->molienda()->delete();
            $bitacora->segundaDestilacion()->delete();
        });
    }


}
