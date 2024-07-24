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
}
