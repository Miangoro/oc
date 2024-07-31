<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotesGranel extends Model
{
    use HasFactory;

    protected $table = 'lotes_granel';

    protected $primaryKey = 'id_lote_granel';  // Cambia esto al nombre correcto de la columna de identificación

    protected $fillable = [
        'id_empresa', 'nombre_lote', 'tipo_lote', 'folio_fq', 'volumen', 
        'cont_alc', 'id_categoria', 'id_clase', 'id_tipo', 'ingredientes', 
        'edad', 'id_guia', 'folio_certificado', 'id_organismo', 
        'fecha_emision', 'fecha_vigencia'
    ];


    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function categoria()
    {
        return $this->belongsTo(categorias::class, 'id_categoria');
    }

    public function clase()
    {
        return $this->belongsTo(clases::class, 'id_clase');
    }

    public function tipo()
    {
        return $this->belongsTo(Tipos::class, 'id_tipo');
    }

    public function organismo()
    {
        return $this->belongsTo(organismos::class, 'id_organismo'); 
    }

    public function guias()
    {
        return $this->belongsTo(guias::class, 'id_guia');
    }

    public function lotesGuias()
    {
        return $this->hasMany(LotesGranelGuia::class, 'id_lote_granel');
    }
}