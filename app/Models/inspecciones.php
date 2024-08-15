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

    public function solicitud()
    {
        return $this->belongsTo(solicitudesModel::class, 'id_solicitud', 'id_solicitud');
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'id_inspector', 'id');
    }
    
    public function dictamen()
    {
        return $this->hasOne(Dictamen_instalaciones::class, 'id_inspeccion', 'id_inspeccion');
    }

}

