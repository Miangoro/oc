<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class documentos_calidad_historial extends Model
{
        protected $table = 'documentos_calidad_historial';

    protected $primaryKey = 'id';  // Cambia esto al nombre correcto de la columna de identificación

    protected $fillable = [
        'id_doc_calidad',
        'tipo',
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
}
