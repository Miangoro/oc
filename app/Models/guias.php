<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guias extends Model
{
    use HasFactory;

    protected $table = 'catalogo_tipo_agave'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_guia '; // Clave primaria de la tabla
    protected $fillable = [
        'id_guia ',
        'Folio', // Asegúrate de que el nombre del campo sea correcto en la tabla
        'id_empresa',
    ];
}
