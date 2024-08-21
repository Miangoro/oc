<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitudesModel extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    protected $primaryKey = 'id_solicitud';

    protected $fillable = [
        'id_empresa',

    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function inspeccion()
    {
        return $this->hasOne(inspecciones::class, 'id_solicitud', 'id_solicitud');
    }

    public function inspector()
    {
        return $this->hasOneThrough(User::class, inspecciones::class, 'id_solicitud', 'id', 'id_solicitud', 'id_inspector');
    }

    public function instalacion()
    {
        return $this->hasOne(instalaciones::class, 'id_instalacion', 'id_instalacion');
    }
}
