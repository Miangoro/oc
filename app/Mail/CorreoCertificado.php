<?php

namespace App\Mail;

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoCertificado extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        return $this->subject('Notificación de Asignación de Revisor') // Puedes personalizar el asunto
                    ->view('emails.CorreoCertificados')
                    ->with([
                        'nombreRevisor' => $this->details['nombreRevisor'], // Nombre del revisor
                        'num_certificado' => $this->details['num_certificado'], // Agrega num_certificado aquí
                    ]);
    }
    
}
