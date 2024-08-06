<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Predios extends Model
{
    use HasFactory;

    // Puedes especificar la tabla si no sigue la convención
    protected $table = 'predios';

    // Define los campos que se pueden llenar de forma masiva
    protected $fillable = [
        'id_empresa',
        'nombre_productor',
        'nombre_predio',
        'ubicacion_predio',
        'tipo_predio',
        'puntos_referencia',
        'cuenta_con_coordenadas',
        'latitud',
        'longitud',
        'superficie',
        'id_tipo',
        'numero_plantas',
        'edad_plantacion',
        'tipo_plantacion',
    ];
    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }
    public function tipo()
    {
        return $this->belongsTo(Tipos::class, 'id_tipo');
    }
}
