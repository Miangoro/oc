<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Dictamen_NoCumplimiento extends Model
{
    use HasFactory;

    protected $table = 'dictamenes_no_cumplimiento';
    protected $primaryKey = 'id_dictamen';
    protected $fillable = [
        'num_dictamen',
        'id_inspeccion',
        'fecha_emision',
        'fecha_vigencia',
        'id_firmante',
        'estatus',
        'observaciones',
    ];


    public function inspeccione()
    {
        return $this->belongsTo(inspecciones::class, 'id_inspeccion', 'id_inspeccion');
    }

    public function firmante()
    {
        return $this->belongsTo(User::class, 'id_firmante', 'id');
    }

    

    
    
}
