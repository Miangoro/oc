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
        return $this->belongsTo(Dictamen_instalaciones::class, 'id_dictamen', 'id_dictamen');
    }
    
}
