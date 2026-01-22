<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServerError extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public \Throwable $exception, public array $requestData)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->exception->getMessage() ?: 'Server Error',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.server-error',
            with: [
                'errorMessage' => $this->exception->getMessage(),
                'stackTrace' => substr($this->exception->getTraceAsString(), 0, 5000), // Limit trace size
                'url' => $this->requestData['url'] ?? 'N/A',
                'method' => $this->requestData['method'] ?? 'N/A',
                'ip' => $this->requestData['ip'] ?? 'N/A',
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
