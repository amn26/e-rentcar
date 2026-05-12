<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserVerificationStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $status;

    public function __construct(User $user, $status)
    {
        $this->user = $user;
        $this->status = $status; // 'approved' or 'rejected'
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Status Update - E-RentCar',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verification-status',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
