<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inspecciones extends Model
{
    use HasFactory;
    protected $table = 'inspecciones';
    protected $primaryKey = 'id_inspeccion';
    protected $fillable = [
        'id_inspeccion',
        'id_solicitud',
        'id_inspector',
        'num_servicio',
        'fecha_servicio',
    ];

    public function instalaciones()
    {
        return $this->hasMany(Dictamen_instalaciones::class, 'id_inspeccion');
    }

}

