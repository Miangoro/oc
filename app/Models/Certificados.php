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
        'id_empresa',
        'num_certificado',
        'fecha_vigencia',
        'fecha_vencimiento',
        'maestro_mezcalero',
        'num_autorizacion',
    ];

    public function dictamen()
    {
        return $this->belongsTo(Dictamen::class, 'id_dictamen', 'id_dictamen');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa', 'id_empresa');
    }

    public function dictamenes()
    {
        return $this->hasMany(Dictamen_instalaciones::class, 'id_certificado', 'id_certificado');
    }

}
