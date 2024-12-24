<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\RegisterController;

class MyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $content;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $content)
    {
        //
        $this->email = $name;
        $this->content = $content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Compte creat correctament.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        /*return new Content(
            view: 'mail.test-email',
            with: ['name' => $this->name]
        );*/
        return new Content(
            view: 'mail.test-email',
            //view: 'auth.fortify.login',
            with: ['name' => $this->email, 'content' => $this->content]
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
