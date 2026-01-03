<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Services\EmailTemplateService;

class OrderDelivered extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $templateData = $this->getTemplateData();
        $rendered = EmailTemplateService::render('order_delivered', $templateData);
        
        return new Envelope(
            subject: $rendered['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $templateData = $this->getTemplateData();
        $rendered = EmailTemplateService::render('order_delivered', $templateData);
        
        return new Content(
            htmlString: $rendered['body'],
        );
    }

    /**
     * Get template data
     */
    private function getTemplateData(): array
    {
        return [
            'customer_name' => $this->order->customer_name,
            'order_number' => $this->order->order_number,
            'order_items_with_review_html' => EmailTemplateService::generateOrderItemsWithReviewHtml($this->order->items),
            'store_url' => route('home'),
            'current_year' => date('Y'),
        ];
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
