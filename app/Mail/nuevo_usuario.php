<?php

namespace App\Mail;

use App\Models\ArmorumappInfodeportistum;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class nuevo_usuario extends Mailable
{
    use Queueable, SerializesModels;

    public $info_deportista;
    public $usuario;


    /**
     * Create a new message instance.
     */
    public function __construct(User $usuario, ArmorumappInfodeportistum $info_deportista)
    {
        $this->usuario = $usuario;
        $this->info_deportista = $info_deportista;
    }

        /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $mailMessage = $this->subject('CREDENCIAL FEDETIRO // (' . $this->usuario->username . ')')
            ->markdown('emails.nuevo_usuario')
            ->withAttachments($this->attachments());

        return $mailMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'CREDENCIAL FEDETIRO // (' . $this->usuario->username . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.nuevo_usuario',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
