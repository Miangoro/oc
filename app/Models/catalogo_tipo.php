<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class catalogo_tipo extends Model
{
    use HasFactory;

    protected $table = 'catalogo_tipo_agave';
    protected $primaryKey = 'id_tipo';
    protected $fillable = [
        'id_tipo',
        'nombre',
        'cientifico',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function plantaciones()
    {
        return $this->hasMany(predio_plantacion::class, 'id_tipo');
    }

    public function tipo()
    {
        return $this->belongsTo(Tipos::class, 'id_tipo');
    }
}
