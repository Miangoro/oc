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
        'id_lote_granel',
        'numero_tapada',
        'numero_guia',
        'tipo_maguey',
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
    ];

    public $timestamps = false;
       // En BitacoraMezcal.php
    public function loteBitacora()
    {
        return $this->belongsTo(LotesGranel::class, 'id_lote_granel', 'id_lote_granel');
    }
    public function empresaBitacora()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }
    public function firmante()
    {
        return $this->belongsTo(User::class, 'id_firmante');
    }

}
