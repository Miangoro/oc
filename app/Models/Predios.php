<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Predios extends Model
{
    use HasFactory;

    // Puedes especificar la tabla si no sigue la convención
    protected $table = 'predios';

    protected $primaryKey = 'id_predio'; // Clave primaria de la tabla

    // Define los campos que se pueden llenar de forma masiva
    protected $fillable = [
        'id_predio',
        'id_empresa',
        'nombre_productor',
        'nombre_predio',
        'ubicacion_predio',
        'tipo_predio',
        'puntos_referencia',
        'cuenta_con_coordenadas',
        'superficie',

    ];
    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }
    public function tipo()
    {
        return $this->belongsTo(Tipos::class, 'id_tipo');
    }
      
    public function plantaciones()
    {
        return $this->hasMany(predio_plantacion::class, 'id_tipo');
    }

      // Relación con PredioCoordenadas
      public function coordenadas()
      {
          return $this->hasMany(PredioCoordenadas::class, 'id_predio');
      }
      // Relación con PredioPlantacion
      public function predio_plantaciones()
    {
        return $this->hasMany(predio_plantacion::class, 'id_predio');
    }

}
