<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class solicitudesModel extends Model
{
    use  HasFactory;

    protected $table = 'solicitudes';
    protected $primaryKey = 'id_solicitud';
    protected $fillable = [
        'id_empresa',
        'id_tipo',
        'folio',
        'fecha_solicitud',
        'fecha_visita',
        'id_instalacion',
        'id_predio',
        'info_adicional',
        'caracteristicas'
    ];

    // Método para obtener el nombre del registro que sirve para la trazabilidad
    public function getLogName2(): string
    {
        return 'solicitud'; // Devuelve el nombre que desees
    }

    public function empresa()
    {
        return $this->belongsTo(empresa::class, 'id_empresa');
    }

    public function inspeccion()
    {
        return $this->hasOne(inspecciones::class, 'id_solicitud', 'id_solicitud');
    }

    public function inspector()
    {
        return $this->hasOneThrough(User::class, inspecciones::class, 'id_solicitud', 'id', 'id_solicitud', 'id_inspector');
    }

    public function instalacion()
    {
        return $this->hasOne(Instalaciones::class, 'id_instalacion', 'id_instalacion');
    }

    public function predios()
    {
        return $this->hasOne(Predios::class, 'id_predio', 'id_predio');
    }

    public function tipo_solicitud()
    {
        return $this->hasOne(solicitudTipo::class, 'id_tipo', 'id_tipo');
    }
    public function marcas()
    {
        return $this->hasMany(marcas::class, 'id_empresa', 'id_empresa');
    }

    public function instalaciones()
    {
        return $this->belongsTo(Instalaciones::class, 'id_instalacion', 'id_instalacion');
    }

    public function getIdLoteGranelAttribute()
{
    $caracteristicas = json_decode($this->caracteristicas, true);

    // Busca directamente en la raíz del JSON
    if (isset($caracteristicas['id_lote_granel'])) {
        return $caracteristicas['id_lote_granel'];
    }

    // Busca en los lotes relacionados a través de la tabla intermedia
    if ($this->lotes_envasado_granel->isNotEmpty()) {
        return $this->lotes_envasado_granel->pluck('id_lote_granel')->toArray();
    }

    // Devuelve null si no se encuentra
    return null;
}
    

    public function lote_granel()
    {
        return $this->belongsTo(LotesGranel::class, 'id_lote_granel', 'id_lote_granel');
    }

    public function getIdLoteEnvasadoAttribute()
{
    $caracteristicas = json_decode($this->caracteristicas, true);

    // Busca directamente en la raíz del JSON
    if (isset($caracteristicas['id_lote_envasado'])) {
        return $caracteristicas['id_lote_envasado'];
    }

    // Busca dentro del arreglo "detalles"
    if (isset($caracteristicas['detalles']) && is_array($caracteristicas['detalles'])) {
        foreach ($caracteristicas['detalles'] as $detalle) {
            if (isset($detalle['id_lote_envasado'])) {
                return $detalle['id_lote_envasado'];
            }
        }
    }

    // Devuelve null si no se encuentra
    return null;
}

public function lote_envasado()
{
    return $this->belongsTo(lotes_envasado::class, 'id_lote_envasado', 'id_lote_envasado');
}

    public function getInstalacionVigilanciaAttribute()
    {
        $caracteristicas = json_decode($this->caracteristicas, true);
        return $caracteristicas['instalacion_vigilancia'] ?? null; // Devuelve null si no existe la clave
    }
    

    public function instalacion_destino()
    {
        return $this->belongsTo(Instalaciones::class, 'instalacion_vigilancia', 'id_instalacion');
    }

    
    public function lotes_envasado_granel()
    {
        return $this->hasMany(lotes_envasado_granel::class,'id_lote_envasado', 'id_lote_envasado');
    }

    


    

}
