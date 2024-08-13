<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictamen_instalaciones extends Model
{
    use HasFactory;
    protected $table = 'dictamenes_instalaciones';
    protected $primaryKey = 'id_dictamen';
    protected $fillable = [
        'id_dictamen',
        'id_inspeccion',
        'tipo_dictamen',
        'id_instalacion',
        'num_dictamen',
        'fecha_dictamen',
        'fecha_vigencia',
        'categorias',
        'clases',
      ];
      
}
