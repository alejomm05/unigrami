<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewDirectMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    /**
     * Crear una nueva instancia del correo.
     *
     * @param Message $message
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Construir el mensaje.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Tienes un nuevo mensaje directo en Unigrami!')
                    ->view('emails.new_direct_message');
    }
}