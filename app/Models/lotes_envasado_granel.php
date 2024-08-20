<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TranslatableActivityLog;


class lotes_envasado_granel extends Model
{   
    use LogsActivity, TranslatableActivityLog, HasFactory;
    protected $table = 'lotes_envasado_granel';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_lote_envasado',
        'id_lote_granel',
        'volumen_parcial',
    ];

    public function loteEnvasado()
    {
        return $this->belongsTo(lotes_envasado::class, 'id_lote_envasado', 'id_lote_envasado');
    }

   
    protected static $logAttributes = ['id_lote_envasado', 'id_lote_granel', 'volumen_parcial'];
}
