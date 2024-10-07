<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activarHologramasModelo extends Model
{
    use HasFactory;

    protected $table = 'activar_hologramas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_inspeccion',
        'id_solicitud',
        'no_lote_agranel',
        'categoria',
        'no_analisis',
        'cont_neto',
        'unidad',
        'clase',
        'contenido',
        'no_lote_envasado',
        'tipo_agave',
        'lugar_produccion',
        'lugar_envasado',
        'cantidad_hologramas',
        'rango_inicial',
        'rango_final',


    ];
}