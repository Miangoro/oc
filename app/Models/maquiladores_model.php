<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class maquiladores_model extends Model
{
    use HasFactory;
    protected $table = 'maquiladores';
    public $timestamps = false;
    protected $fillable = [
        'id_maquilador',
        'id_maquiladora'
    ];

    
    public function maquiladores()
    {
        return $this->hasMany(empresa::class, 'id_empresa', 'id_maquilador');
    }

     public function maquiladora()
    {
        return $this->hasMany(empresa::class, 'id_empresa', 'id_maquiladora');
    }
    
}
