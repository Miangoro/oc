<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificados extends Model
{
    use HasFactory;
    protected $table = 'certificados';
    protected $primaryKey = 'id_certificado';

    protected $fillable = [
        'id_dictamen',
        'id_firmante',
        'id_empresa',
        'num_certificado',
        'fecha_emision',
        'fecha_vigencia',
        'maestro_mezcalero',
        'num_autorizacion',
        'estatus',
        'observaciones'
    ];

    // Relación con el modelo Dictamen_instalaciones
    public function dictamen()
    {
        return $this->belongsTo(Dictamen_instalaciones::class, 'id_dictamen', 'id_dictamen');
    }

    // Relación con el modelo User (Firmante)
    public function firmante()
    {
        return $this->belongsTo(User::class, 'id_firmante', 'id');
    }

    // Relación con el modelo Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id');
    }

    public function revisor()
    {
        return $this->belongsTo(Revisor::class, 'id_certificado', 'id_certificado');
    }
    
}
