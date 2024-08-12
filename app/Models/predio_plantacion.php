<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class predio_plantacion extends Model
{
    use HasFactory;

    protected $table = 'predio_plantacion';
    protected $primaryKey = 'id_plantacion';
    protected $fillable = [
        'id_plantacion',
        'id_predio',
        'id_tipo',
        'num_plantas',
        'anio_plantacion',
        'tipo_plantacion',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function tipo()
    {
        return $this->belongsTo(Tipos::class, 'id_tipo');
    }
    public function predio()
    {
        return $this->belongsTo(Predios::class, 'id_predio');
    }
}
