<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lotes_envasado extends Model
{
    use HasFactory;
    protected $table = 'lotes_envasado';
    protected $primaryKey = 'id_lote_envasado';
    protected $fillable = [
        'id_lote_envasado',
        'id_empresa',
        'nombre_lote',
        'tipo_lote',
        'sku',
        'id_marca',
        'destino_lote',
        'cant_botellas',
        'presentacion',
        'unidad',
        'volumen_total',
        'lugar_envasado',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }
    public function marca(){
        return $this->belongsTo(marcas::class, 'id_marca', 'id_marca');
    }
    public function lotesGranel()
    {
        return $this->belongsToMany(LotesGranel::class, 'lotes_envasado_granel', 'id_lote_envasado', 'id_lote_granel');
    }
    

    public function lotes_envasado_granel()
    {
        return $this->hasMany(lotes_envasado_granel::class,'id_lote_envasado', 'id_lote_envasado');
    }
    

}
