<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// catalogoMarca.php
class catalogoMarca extends Model
{
    use HasFactory;

    protected $table = 'marcas'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_marca'; // Nombre de la clave primaria
    protected $fillable = ['folio', 'marca', 'id_empresa']; // Campos que pueden ser asignados en masa

    // Definir la relación con la empresa
    public function cliente()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
    
}
