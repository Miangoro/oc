<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lotes_envasado_granel extends Model
{
    use HasFactory;
    protected $table = 'lotes_envasado';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_lote_envasado',
        'id_lote_granel',
        'volumen_parcial',
    ];

    public function loteEnvasado()
    {
        return $this->belongsTo(lotes_envasado::class, 'id_lote_envasado', 'id_lote_envasado');
    }
}
