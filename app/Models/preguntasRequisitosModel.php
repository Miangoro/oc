<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class preguntasRequisitosModel extends Model
{
    use HasFactory;

    protected $table = 'preguntas_requisitos';
    protected $primaryKey = 'id_pregunta';
    protected $fillable = [
        'pregunta',
        'tipo',
      ];


      public function actividad()
    {
       
        return $this->hasOne(catalogo_actividad_cliente::class, 'id_actividad', 'tipo');
    }


}
