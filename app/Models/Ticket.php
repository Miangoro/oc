<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
 protected $fillable = [
    'nombre',
    'email',
    'asunto',
    'prioridad',
    'descripcion',
    'id_usuario',
    'estatus',
];
public function evidencias()
{
    return $this->hasMany(TicketEvidencia::class, 'ticket_id');
}
public function mensajes()
{
    return $this->hasMany(TicketMensaje::class, 'ticket_id');
}



}
