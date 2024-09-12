<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictamen_Envasado extends Model
{
    use HasFactory;

    protected $table = 'dictamenes_envasado';
    protected $primaryKey = 'id_dictamen_envasado';
    protected $fillable = [
        'num_dictamen',
        'id_empresa',
        'id_inspeccion',
        'id_lote_envasado',
        'fecha_emision',
        'fecha_vigencia',
        'fecha_servicio',
        'estatus',
        'observaciones',
        'id_firmante'
    ];

    public function inspeccion()
    {
        return $this->belongsTo(inspecciones::class, 'id_inspeccion');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function lote_envasado()
    {
        return $this->belongsTo(lotes_envasado::class, 'id_lote_envasado');
    }
    
    public function inspectores()
    {
        return $this->belongsTo(User::class, 'id_firmante', 'id');
    }
  
}
