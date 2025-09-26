<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
//use App\Traits\TranslatableActivityLog;
//use Spatie\Activitylog\Traits\LogsActivity;


class Solicitudes052 extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_052';
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
        'caracteristicas',
        'habilitado',
        'id_usuario_registro'
    ];

    protected static function boot()//registro automatico de usuario
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->id_usuario_registro = Auth::id();
            }
        });
    }

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
        return $this->belongsTo(instalaciones::class, 'id_instalacion', 'id_instalacion');
    }

    public function predios()
    {
        return $this->hasOne(Predios::class, 'id_predio', 'id_predio');
    }

    public function tipo_solicitud()
    {
        return $this->hasOne(SolicitudTipo052::class, 'id_tipo', 'id_tipo');
    }



    
    public function lote_granel()
    {
        return $this->belongsTo(LotesGranel::class, 'id_lote_granel', 'id_lote_granel');
    }

    public function lote_envasado()
    {
        return $this->belongsTo(lotes_envasado::class, 'id_lote_envasado', 'id_lote_envasado');
    }

    public function lotes_envasado_granel()
    {
        return $this->hasMany(lotes_envasado_granel::class,'id_lote_envasado', 'id_lote_envasado');
    }

    public function documentacion($id_documento)
    {
        return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_solicitud')->where('id_documento', $id_documento);
    }

    ///OBTENER COLLECCION CARACTERISTICAS
    public function caracteristicasDecodificadas(): array
    {
        return $this->caracteristicas ? json_decode($this->caracteristicas, true) : [];
    }

 




}
