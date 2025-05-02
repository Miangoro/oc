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
        'fecha_emision',
        'fecha_vigencia',
        'id_lote_granel'
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
        return $this->belongsTo(Revisor::class, 'id_certificado', 'id_certificado')->where('tipo_certificado',2);
    }

    public function loteGranel()
    {
        return $this->hasOne(LotesGranel::class, 'id_lote_granel','id_lote_granel');
    }
}