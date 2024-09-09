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
  
      public function empresa()
      {
          return $this->belongsTo(empresa::class, 'id_empresa');
      }
      public function documentacion_url()
      {
          return $this->hasMany(Documentacion_url::class, 'id_relacion', 'id_marca');
      }
      
}
