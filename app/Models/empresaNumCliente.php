<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresaNumCliente extends Model
{
    protected $table = 'empresa_num_cliente';
    use HasFactory;
    protected $fillable = [
        'numero_cliente',
        'id_norma',
        'id_empresa'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}