<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class documentos_calidad extends Model
{
    use HasFactory;

    protected $table = 'documentos_calidad';

    protected $primaryKey = 'id_doc_calidad';  // Cambia esto al nombre correcto de la columna de identificación

    protected $fillable = [
        'tipo',
        'nombre',
        'identificacion',
        'edicion',
        'fecha_edicion',
        'estatus',
        'archivo',
        'archivo_editable',
        'area',
        'modifico',
        'reviso',
        'aprobo',
        'id_usuario_registro',
      ];
      public $timestamps = false;

    public function historial()
    {
        return $this->hasMany(documentos_calidad_historial::class, 'id_doc_calidad', 'id_doc_calidad');
    }

}
