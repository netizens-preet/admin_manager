<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCancelledByAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public \App\Models\Order $order, public ?string $reason = null)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): \Illuminate\Mail\Mailables\Envelope
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Order #' . $this->order->id . ' has been cancelled by Admin',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order.admin_cancelled',
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
