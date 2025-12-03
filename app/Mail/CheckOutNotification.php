<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CheckOutNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $task;
    public $time;
    public $workedHours;

    public function __construct($name, $task, $time, $workedHours)
    {
        $this->name = $name;
        $this->task = $task;
        $this->time = $time;
        $this->workedHours = $workedHours;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Check-Out Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.checkout',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
