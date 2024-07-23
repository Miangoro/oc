<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;
     // Nombre de la tabla en la base de datos
     protected $table = 'catalogo_tipo_agave';

     // Campos que se pueden llenar de forma masiva (si se usa fillable)
     protected $fillable = ['nombre', 'cientifico'];
 
     // Clave primaria
     protected $primaryKey = 'id_tipo';
 
     // Si la clave primaria no es auto-incremental
     public $incrementing = true;
 
     // Tipo de dato de la clave primaria
     protected $keyType = 'int';
 
     // Si no se usan timestamps
     public $timestamps = false;
}
