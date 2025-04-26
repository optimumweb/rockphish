<?php

namespace App\Mail;

use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CampaignEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $campaign;
    public $openedPath;
    public $hookedPath;
    public $body;

    public function __construct(Email $email)
    {
        $this->email = $email;
        $this->campaign = $email->campaign;
        $this->openedPath = route('phish.opened', ['email' => $email, 'domain' => $this->campaign->domain]);
        $this->hookedPath = route('phish.hooked', ['email' => $email, 'domain' => $this->campaign->domain]);
        $this->body = str_replace('%hook%', $this->hookedPath, $this->campaign->body);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->campaign->from_address, $this->campaign->from_name),
            replyTo: $this->campaign->reply_to,
            subject: $this->campaign->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.campaign-email',
            with: [
                'opened' => $this->openedPath,
                'hooked' => $this->hookedPath,
                'body' => $this->body,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
