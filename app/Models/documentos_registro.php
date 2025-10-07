<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class documentos_registro extends Model
{
      use HasFactory;

    protected $table = 'documentos_registros';

    protected $primaryKey = 'id_registro';  // Cambia esto al nombre correcto de la columna de identificación

    protected $fillable = [
        'id_procedimiento',
        'nombre',
        'identificacion',
        'edicion',
        'fecha_edicion',
        'estatus',
        'archivo',
        'area',
        'modifico',
        'reviso',
        'aprobo',
        'id_usuario_registro',
      ];
      public $timestamps = false;

      public function historial()
      {
          return $this->hasMany(documentos_registro_historial::class, 'id_registro', 'id_registro');
      }
       public function procedimientos()
      {
          return $this->hasMany(documentos_calidad::class, 'id_procedimiento', 'id_doc_calidad');
      }


}
