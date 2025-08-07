<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketEvidencia extends Model
{
    use HasFactory;

    protected $table = 'tickets_evidencia';

    protected $fillable = [
        'ticket_id',
        'evidencia_url',
        'descripcion',
    ];

    public $timestamps = false;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}