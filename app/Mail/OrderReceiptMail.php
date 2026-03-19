<?php

namespace App\Mail;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order
    ) {
        $this->order->load(['orderItems.product', 'user']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order #' . $this->order->id . ' Receipt - The Pop Stop',
            from: config('mail.from.address'),
            replyTo: [config('mail.from.address')],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-receipt',
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.receipt', ['order' => $this->order]);
        $pdfContent = $pdf->output();

        return [
            Attachment::fromData(fn () => $pdfContent, 'receipt-' . $this->order->id . '.pdf', [
                'mime' => 'application/pdf',
            ]),
        ];
    }
}
