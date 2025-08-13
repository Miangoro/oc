<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitoEvaluar extends Model
{
    use HasFactory;

    protected $table = 'requisitos_revision';
    protected $primaryKey = 'id_pregunta';
    protected $fillable = [
        'respuestas',
        'decision',
      ];




}
