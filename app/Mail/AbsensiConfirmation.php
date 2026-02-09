<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AbsensiConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $eventName;

    /**
     * Create a new message instance.
     * Kita tangkap data peserta ($data) dan nama kegiatan ($eventName)
     */
    public function __construct($data, $eventName)
    {
        $this->data = $data;
        $this->eventName = $eventName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bukti Kehadiran - ' . $this->eventName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.absensi_confirmation', // Kita akan buat view ini di Langkah 3
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}