<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificadosGranel extends Model
{
    use HasFactory;

    protected $table = 'certificados_granel'; 
    protected $primaryKey = 'id_certificado';

    protected $fillable = [
        'id_firmante',
        'num_dictamen',
        'fecha_vigencia',
        'fecha_vencimiento',
    ];

    public function dictamen()
    {
        return $this->belongsTo(Dictamen_Granel::class, 'num_dictamen', 'id_dictamen');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_firmante', 'id'); // id_revisor es la clave foránea en la tabla revisores
    }
}
