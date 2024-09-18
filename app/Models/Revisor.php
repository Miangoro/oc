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
        'numero_revision',
        'es_correccion',
        'observaciones',
    ];
}
