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
        'id_dictamen',
        'num_certificado',
        'fecha_vigencia',
        'fecha_vencimiento',
    ];

    public function dictamen()
    {
        return $this->belongsTo(Dictamen_Granel::class, 'id_dictamen', 'id_dictamen');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_firmante', 'id'); 
    }

    public function revisor()
    {
        return $this->belongsTo(RevisorGranel::class, 'id_certificado', 'id_certificado');
    }
}