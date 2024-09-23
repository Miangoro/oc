<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revisor extends Model
{
    use HasFactory;

    protected $table = 'certificados_revision';
    protected $primaryKey = 'id_revision'; 

    protected $fillable = [
        'tipo_revision',
        'id_revisor',
        'id_certificado',
        'numero_revision',
        'es_correccion',
        'observaciones',
    ];

    // Relación inversa con Certificados
    public function certificado()
    {
        return $this->belongsTo(Certificados::class, 'id_certificado', 'id_certificado');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_revisor', 'id'); // id_revisor es la clave foránea en la tabla revisores
    }

}
