<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EtiquetaUITapaMuestra extends Model
{
    use HasFactory;

    protected $table = 'etiqueta_tapa_muestra';
    protected $primaryKey = 'id'; // Clave primaria

    // Campos comunes de todas las tablas
    protected $fillable = [
        'fecha_servicio',
        'num_servicio',
        'razon_social',
        'domicilio',
        'nombre_lote',
        'producto',
        'volumen',
        'folio_fq',
        'categoria',
        'tipo_agave',
        'edad',
        'ingredientes',
        'tipo_analisis',
        'lote_procedencia',
        'estado',
        'destino',
        'inspector',
        'responsable',
    ];


    /*public function getLogName2(): string
    {
        return 'Revisor'; // Devuelve el nombre que desees
    }*/

}