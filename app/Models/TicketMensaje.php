<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketMensaje extends Model
{
    protected $table = 'tickets_mensajes';
    protected $primaryKey = 'id';
     protected $fillable = [
        'ticket_id', 'mensaje', 'id_usuario', 'rol_emisor'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
