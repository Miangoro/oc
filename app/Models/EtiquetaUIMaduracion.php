<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class EtiquetaUIMaduracion extends Model
{
    use HasFactory;

    protected $table = 'etiqueta_maduracion';
    protected $primaryKey = 'id'; // Clave primaria
    public $timestamps = false; // Desactivar created_at / updated_at

    // Campos comunes de todas las tablas
    protected $fillable = [
        'fecha_servicio',
        'num_servicio',
        'razon_social',
        'nombre_lote',
        'volumen_total',
        'folio_fq',
        'categoria',
        'clase',
        'tipo_agave',
        'cont_alc',
        'num_certificado',
        'maduracion',
        'tipo_madera',
        'tipo_recipiente',
        'no_recipiente',
        'capacidad_recipiente',
        'volumen_ingresado',
        'inspector',
        'responsable',
    ];


    /*public function getLogName2(): string
    {
        return 'Revisor'; // Devuelve el nombre que desees
    }*/

}