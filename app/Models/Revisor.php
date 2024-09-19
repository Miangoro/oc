<?php

namespace App\Models;

use App\Traits\TranslatableActivityLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Revisor extends Model
{
    use LogsActivity, TranslatableActivityLog, HasFactory;

    protected $table = 'certificados_revision';
    protected $primaryKey = 'id_revision'; 

    protected $fillable = [
        'tipo_revision',
        'id_revisor',
        'numero_revision',
        'es_correccion',
        'observaciones',
    ];

    public function getLogName2(): string
    {
        return 'revisor'; // Devuelve el nombre que desees
    }
}
