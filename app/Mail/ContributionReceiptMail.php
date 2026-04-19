<?php
namespace App\Mail;

use App\Models\Contribution;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContributionReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contribution;

    /**
     * Create a new message instance.
     */
    public function __construct(Contribution $contribution)
    {
        // We make the contribution data available to the view
        $this->contribution = $contribution;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Official Receipt: ' . $this->contribution->transaction_reference,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contributions.receipt', // We will create this view next
        );
    }
}