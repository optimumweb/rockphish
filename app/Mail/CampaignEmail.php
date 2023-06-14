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
    public $opened;
    public $hooked;
    public $body;

    public function __construct(Email $email)
    {
        $this->email = $email;
        $this->campaign = $email->campaign;
        $this->opened = route('phish.opened', [$email]);
        $this->hooked = route('phish.hooked', [$email]);
        $this->body = str_replace('%hook%', $this->hooked, $this->campaign->body);
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
                'opened' => $this->opened,
                'hooked' => $this->hooked,
                'body' => $this->body,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
