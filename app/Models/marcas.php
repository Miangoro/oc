<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class marcas extends Model
{
    use HasFactory;
    protected $table = 'marcas';
    protected $primaryKey = 'id_marca';
    protected $fillable = [
        'id_marca',
        'folio',
        'marca',
        'id_empresa',
      ];

      
}
