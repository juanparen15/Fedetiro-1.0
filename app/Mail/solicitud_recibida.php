<?php

namespace App\Mail;

use App\Models\ArmorumappSolicitud;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class solicitud_recibida extends Mailable
{
    use Queueable, SerializesModels;


    public $solicitud;
    public $usuario;

    /**
     * Create a new notification instance.
     */
    public function __construct(ArmorumappSolicitud $solicitud, User $usuario)
    {
        $this->solicitud = $solicitud;
        $this->usuario = $usuario;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $mailMessage = $this->subject('SOLICITUD DE TRÁMITE // (' . $this->usuario->username . ') // (' . $this->usuario->movil . ')')
            ->markdown('emails.solicitud-recibida')
            ->withAttachments($this->attachments());

        return $mailMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SOLICITUD DE TRÁMITE // (' . $this->usuario->username . ') // (' . $this->usuario->movil . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.solicitud-recibida',
        );
    }
    /**
     * Get the attachments for the message.
     *
     * @return \Illuminate\Mail\Mailables\Attachment[]
     */
    public function attachments(): array
    {
        $attachments = [];

        // Consentimiento de padres
        if (!empty($this->solicitud->foto)) {
            $anexo_pdf = json_decode($this->solicitud->foto, true);
            if (is_array($anexo_pdf)) {
                foreach ($anexo_pdf as $archivo) {
                    $attachments[] = Attachment::fromStorageDisk('public', $archivo['download_link'])
                        ->as($archivo['original_name']);
                }
            } else {
                $attachments[] = Attachment::fromStorageDisk('public', $this->solicitud->foto);
            }
        }

        // Comprobante de pago
        if (!empty($this->solicitud->cedula)) {
            $anexo_jpg = json_decode($this->solicitud->cedula, true);
            if (is_array($anexo_jpg)) {
                foreach ($anexo_jpg as $archivo) {
                    $attachments[] = Attachment::fromStorageDisk('public', $archivo['download_link'])
                        ->as($archivo['original_name']);
                }
            } else {
                $attachments[] = Attachment::fromStorageDisk('public', $this->solicitud->cedula);
            }
        }
        // Permiso de porte
        if (!empty($this->solicitud->pago)) {
            $anexo_mp3 = json_decode($this->solicitud->pago, true);
            if (is_array($anexo_mp3)) {
                foreach ($anexo_mp3 as $archivo) {
                    $attachments[] = Attachment::fromStorageDisk('public', $archivo['download_link'])
                        ->as($archivo['original_name']);
                }
            } else {
                $attachments[] = Attachment::fromStorageDisk('public', $this->solicitud->pago);
            }
        }

        if (!empty($this->solicitud->otro_archivo)) {
            $anexo_opcional_pdf = json_decode($this->solicitud->otro_archivo, true);
            if (is_array($anexo_opcional_pdf)) {
                foreach ($anexo_opcional_pdf as $archivo) {
                    $attachments[] = Attachment::fromStorageDisk('public', $archivo['download_link'])
                        ->as($archivo['original_name']);
                }
            } else {
                $attachments[] = Attachment::fromStorageDisk('public', $this->solicitud->otro_archivo);
            }
        }

        // Log::info('Archivos adjuntos procesados: ', $attachments);


        return $attachments;
    }
}
