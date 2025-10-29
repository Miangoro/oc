<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EtiquetaUIAgaveArt extends Model
{
    use HasFactory;

    protected $table = 'etiqueta_agave_art';
    protected $primaryKey = 'id'; // Clave primaria

    // Campos comunes de todas las tablas
    protected $fillable = [
        'fecha_servicio',
        'num_servicio',
        'razon_social',
        'domicilio',
        'maestro_mezcalero',
        'destino',
        'predio',
        'tapada',
        'kg_maguey',
        'edad',
        'no_pinas',
        'tipo_agave',
        'analisis',
        'muestra',
        'inspector',
        'responsable',
    ];


    /*public function getLogName2(): string
    {
        return 'Revisor'; // Devuelve el nombre que desees
    }*/

}