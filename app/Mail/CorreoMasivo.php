<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class CorreoMasivo extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $asunto;
    public $contenido;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $usuario , $asunto , $contenido)
    {
        $this->usuario = $usuario;
        $this->asunto = $asunto;
        $this->contenido = $contenido;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.correo-masivo')->subject($this->asunto);
    }
}
