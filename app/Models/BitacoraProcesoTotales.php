<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraProcesoTotales extends Model
{
    //
    use HasFactory;
    protected $table = 'bitacora_proceso_totales';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_',
        'id_bitacora',
        'etapa',
        'volumen_formulacion',
        'puntas_volumen',
        'puntas_porcentaje',
        'mezcal_volumen',
        'mezcal_porcentaje',
        'colas_volumen',
        'colas_porcentaje',
    ];
    public $timestamps = false;
}
