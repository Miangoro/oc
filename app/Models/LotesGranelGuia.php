<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotesGranelGuia extends Model
{
    use HasFactory;

    protected $table = 'lotes_granel_guias';
    protected $primaryKey = 'id';
    protected $fillable = ['id_lote_granel', 'id_guia'];

}
