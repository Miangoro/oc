<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organismo extends Model
{
    use HasFactory;
         // Nombre de la tabla en la base de datos
         protected $table = 'catalogo_organismos';

         // Campos que se pueden llenar de forma masiva (si se usa fillable)
         protected $fillable = ['organismo'];
     
         // Clave primaria
         protected $primaryKey = 'id_organismo';
     
         // Si la clave primaria no es auto-incremental
         public $incrementing = true;
     
         // Tipo de dato de la clave primaria
         protected $keyType = 'int';
     
         // Si no se usan timestamps
         public $timestamps = false;
}
