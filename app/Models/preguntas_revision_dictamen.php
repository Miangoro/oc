<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class preguntas_revision_dictamen extends Model
{
    use HasFactory;
    protected $table = 'revision_preguntas_dictamen';
    protected $primaryKey = 'id_pregunta'; 

    public function documentacion()
    {
        return $this->belongsTo(Documentacion::class, 'id_documento', 'id_documento');
    }

    
}
