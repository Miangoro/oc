<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coordenadas extends Model
{   
    use HasFactory;
    protected $table = 'hologramas_coordenadas';
    public $timestamps = false;
    protected $fillable = ['folio_holograma', 'latitud', 'longitud','fecha'];
}
