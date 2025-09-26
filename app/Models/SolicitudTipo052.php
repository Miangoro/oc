<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SolicitudTipo052 extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_tipo_052';
    protected $primaryKey = 'id_tipo';
    protected $fillable = [
        'tipo',
    ];
}
