<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogoMarca extends Model
{
    use HasFactory;

    protected $table = 'marcas'; // Nombre de la tabla en la base de datos

    protected $primaryKey = 'id_marca'; // Nombre de la clave primaria

    protected $fillable = ['folio','marca','id_empresa']; // Campos que pueden ser asignados en masa

}

