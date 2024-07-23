<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentacion_url extends Model
{
    protected $table = 'documentacion_url';
    use HasFactory;
      protected $fillable = [
          'id_empresa',
          'url',
          'id_relacion',
          'id_usuario_registro',
          'nombre_documento',
          'fecha_vigencia'  // <-- Asegúrate de agregar esto

      ];


      public function marca()
      {
          return $this->belongsTo(Marcas::class, 'id_relacion', 'id_marca');
      }
}
