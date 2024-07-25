<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalaciones extends Model
{
    use HasFactory;

    protected $table = 'instalaciones';
    protected $primaryKey = 'id_instalacion';
    protected $fillable = [
        'id_empresa',
        'tipo',
        'direccion_completa',
        'folio'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function organismos()
    {
        return $this->belongsTo(Organismos::class, 'id_organismo');
    }

    public function estados()
    {
        return $this->belongsTo(Estados::class, 'estado');
    }
}
