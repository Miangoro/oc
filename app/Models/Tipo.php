<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    protected $table = 'catalogo_tipo_agave'; // Asegúrate de que este nombre coincida con tu tabla en la base de datos
    protected $primaryKey = 'id_tipo'; // Clave primaria de la tabla
    protected $fillable = [
        'id_tipo',
        'nombre', // Asegúrate de que el nombre del campo sea correcto en la tabla
        'cientifico',
    ];
}