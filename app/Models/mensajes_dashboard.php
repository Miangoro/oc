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
        'mensaje',
        'activo',
        'orden',
        'id_usuario_registro'

    ];
       public $timestamps = false;

}
