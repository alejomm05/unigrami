<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FollowerNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $follower;

    /**
     * Crear una nueva instancia del correo.
     *
     * @param User $follower
     * @return void
     */
    public function __construct(User $follower)
    {
        $this->follower = $follower;
    }

    /**
     * Construir el mensaje.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('¡Tienes un nuevo seguidor en Unigrami!')
                    ->view('emails.follower_notification');
    }
}