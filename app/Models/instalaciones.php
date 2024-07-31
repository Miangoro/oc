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
        'estado',
        'direccion_completa',
        'folio',
        'id_organismo',
        'fecha_emision',
        'fecha_vigencia'
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

    public function getFechaEmisionAttribute($value)
    {
        return $value ? $value : 'N/A';
    }

    public function getFechaVigenciaAttribute($value)
    {
    return $value ? $value : 'N/A';
    }

    public function documentos()
    {
      
        return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_instalacion');
    }
}
