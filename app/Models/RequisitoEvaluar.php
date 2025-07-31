<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitoEvaluar extends Model
{
    use HasFactory;

    protected $table = 'preguntas_requisitos';
    protected $primaryKey = 'id_pregunta';
    protected $fillable = [
        'pregunta',
        'tipo',
      ];




}
