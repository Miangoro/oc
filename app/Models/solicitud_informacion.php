<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitud_informacion extends Model
{
    use HasFactory;
    protected $table = 'solicitud_informacion';
    protected $fillable = [
        'i',
        'id_empresa',
        'medios',
        'competencia',
        'capacidad',
        'comentarios'
      ];

      // En el modelo solicitud_informacion
    public function user()
    {
        return $this->belongsTo(user::class, 'id_revisor');
        // 'id_revisor' es la columna que apunta al id del usuario
    }

}
