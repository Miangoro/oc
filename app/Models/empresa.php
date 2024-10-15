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
        return $this->hasMany(empresaNumCliente::class, 'id_empresa','id_empresa');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_empresa');
    }

    public function instalaciones()
    {
        return $this->hasMany(Instalaciones::class, 'id_empresa');
    }


    public function guiasEmpresa()
    {
        return $this->hasMany(Guias::class, 'id_empresa');
    }

    public function obtenerInstalaciones(){
        return Instalaciones::where('id_empresa', $this->id_empresa)->get();
    }

    public function lotes_granel(){
        return LotesGranel::where('id_empresa', $this->id_empresa)->get();
    }
    public function lotes_envasado()
    {
    // Aquí deberías implementar la lógica para obtener los lotes envasados
    return lotes_envasado::where('id_empresa', $this->id_empresa)->get();
    }


    public function marcas(){
        return marcas::where('id_empresa', $this->id_empresa)->get();
    }

    public function guias(){
        return Guias::where('id_empresa', $this->id_empresa)->get();
    }

    public function predios(){
        return Predios::where('id_empresa', $this->id_empresa)->get();
    }

    public function solicitudHolograma(){
        return solicitudHolograma::where('id_empresa', $this->id_empresa)->get();
    }

    public function actas_inspeccion()
    {
        return $this->hasMany(actas_inspeccion::class, 'id_empresa');
    }

    public function direcciones(){
        return direcciones::where('id_empresa', $this->id_empresa)->get();
    }

    public function predio_plantacion(){
        return Predios::where('id_empresa', $this->id_empresa)
        ->join('predio_plantacion AS pl', 'predios.id_predio', '=', 'pl.id_predio')
        ->join('catalogo_tipo_agave AS t', 'pl.id_tipo', '=', 't.id_tipo')
        ->select('pl.id_plantacion','t.nombre', 't.cientifico', 'pl.num_plantas', 'pl.anio_plantacion', 'predios.nombre_predio', 'predios.superficie')
        ->get();
    }

    public function solicitudes()
    {
        return $this->hasMany(solicitudesModel::class, 'id_empresa','id_empresa');
    }

    public function contratos()
    {
        return $this->hasMany(empresaContrato::class, 'id_empresa', 'id_empresa');
    }

    public function normas()
    {
        return $this->belongsToMany(normas_catalo::class, 'empresa_norma_certificar', 'id_empresa', 'id_norma');
    }


}
