<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empresa extends Model
{
    use HasFactory;
    protected $table = 'empresa';
    protected $primaryKey = 'id_empresa';
    protected $fillable = [
        'id_empresa',
        'razon_social',
        'domicilio_fiscal',
        'tipo',
      ];

      public function empresaNumClientes()
    {
        return $this->hasMany(EmpresaNumCliente::class, 'id_empresa');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_empresa');
    }

    public function instalaciones()
    {
        return $this->hasMany(Instalaciones::class, 'id_empresa');
    }

    
}
