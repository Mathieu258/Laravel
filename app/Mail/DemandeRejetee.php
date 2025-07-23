<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DemandeRejetee extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $motif;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $motif = null)
    {
        $this->user = $user;
        $this->motif = $motif;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Réponse à votre demande d\'inscription - Eat&Drink',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.demande-rejetee',
            with: [
                'user' => $this->user,
                'motif' => $this->motif,
            ],
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
