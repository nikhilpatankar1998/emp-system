<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CheckInNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $task;
    public $time;

    public function __construct($name, $task, $time)
    {
        $this->name = $name;
        $this->task = $task;
        $this->time = $time;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Check-In Successful',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.checkin', // path to your Blade file
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
