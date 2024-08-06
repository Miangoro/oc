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

    public function obtenerInstalaciones(){
        return Instalaciones::where('id_empresa', $this->id_empresa)->get();
    }

    public function lotes_granel(){
        return LotesGranel::where('id_empresa', $this->id_empresa)->get();
    }

    public function marcas(){
        return marcas::where('id_empresa', $this->id_empresa)->get();
    }

    public function guias(){
        return guias::where('id_empresa', $this->id_empresa)->get();
    }


    public function guiasEmpresa()
    {
        return $this->hasMany(guias::class, 'id_empresa');
    }



    
}
