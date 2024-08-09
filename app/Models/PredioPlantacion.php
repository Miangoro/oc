<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PredioPlantacion extends Model
{
    use HasFactory;
  
    protected $table = 'predio_plantacion';

    protected $primaryKey = 'id_plantacion'; // Clave primaria de la tabla

    // Define los campos que se pueden llenar de forma masiva
    protected $fillable = [
        'id_predio',
        'id_tipo',
        'num_plantas',
        'anio_plantacion',
        'tipo_plantacion'

    ];

    
}
