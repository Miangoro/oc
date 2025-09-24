<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class documentos_registro_historial extends Model
{
            protected $table = 'documentos_registros_historial';

    protected $primaryKey = 'id';  // Cambia esto al nombre correcto de la columna de identificación

    protected $fillable = [
        'id_registro',
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


}
