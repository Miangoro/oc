<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraMezcal extends Model
{
    use HasFactory;
    protected $table = 'bitacora_mezcal';
    protected $primaryKey = 'id';

    protected $fillable = [
        'fecha',
        'id_tanque',
        'lote_a_granel',
        'operacion_adicional',
        'categoria',
        'clase',
        'ingredientes',
        'edad',
        'tipo_agave',
        'num_analisis',
        'num_certificado',

        //INVENTARIO INICIAL 
        'volumen_inicial',
        'alcohol_inicial',

        //ENTRADA 
        'procedencia_entrada',
        'volumen_entrada',
        'alcohol_entrada',
        'agua_entrada',

        //SALIDAS
        'volumen_salidas',
        'alcohol_salidas',
        'destino_salidas',

        //INVENTARIO FINAL
        'volumen_final',
        'alcohol_final',
        
        'observaciones',        
    ];
}
