<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  protected $table = 'tickets';
  protected $primaryKey = 'id_ticket';
  protected $fillable = [
    'nombre',
    'email',
    'folio',
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
    return $this->hasMany(TicketMensaje::class, 'ticket_id', 'id_ticket');
}


public function usuario()
{
    return $this->belongsTo(User::class, 'id_usuario', 'id');
}


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($ticket) {
            $ticket->evidencias()->each(function ($evidencia) {
                if ($evidencia->ruta && \Storage::exists($evidencia->ruta)) {
                    \Storage::delete($evidencia->ruta); // Borra archivo
                }
                $evidencia->delete();
            });

            $ticket->mensajes()->delete();
        });
    }



}
