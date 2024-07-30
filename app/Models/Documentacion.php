<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentacion extends Model
{   
    protected $table = 'documentacion';
    protected $primaryKey = 'id_documento';
    use HasFactory;

    public function documentacionUrls()
    {
        return $this->hasMany(Documentacion_url::class, 'id_documento');
    }
}
