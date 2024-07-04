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
}
