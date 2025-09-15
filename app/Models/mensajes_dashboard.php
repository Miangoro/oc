<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mensajes_dashboard extends Model
{
        //
   use HasFactory;
    protected $table = 'mensajes_dashboard';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_usuario_destino',
        'titulo',
        'tipo_titulo',
        'mensaje',
        'tipo',
        'activo',
        'orden',
        'id_usuario_registro'

    ];
       public $timestamps = false;

    // Relación con User (usuario destino)
        public function usuarioDestino()
    {
        return $this->belongsTo(User::class, 'id_usuario_destino');
    }
        // Relación con User (usuario registro)
        public function usuarioRegistro()
    {
        return $this->belongsTo(User::class, 'id_usuario_registro');
    }
}
