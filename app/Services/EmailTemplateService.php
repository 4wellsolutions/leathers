<?php

namespace App\Services;

use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Log;

class EmailTemplateService
{
    /**
     * Render an email template with the given data
     */
    public static function render(string $code, array $data): array
    {
        try {
            $template = EmailTemplate::where('code', $code)
                ->where('is_active', true)
                ->first();

            if (!$template) {
                Log::warning("Email template not found or inactive: {$code}");
                return self::getFallback($code, $data);
            }

            $subject = self::replaceVariables($template->subject, $data);
            $body = self::replaceVariables($template->body, $data);

            return [
                'subject' => $subject,
                'body' => $body,
            ];
        } catch (\Exception $e) {
            Log::error("Error rendering email template {$code}: " . $e->getMessage());
            return self::getFallback($code, $data);
        }
    }

    /**
     * Replace variables in template content
     */
    private static function replaceVariables(string $content, array $data): string
    {
        foreach ($data as $key => $value) {
            // Handle arrays (like order items)
            if (is_array($value)) {
                continue;
            }
            
            // Replace {{variable}} with actual value
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }

        // Handle order items specially
        if (isset($data['order_items_html'])) {
            $content = str_replace('{{order_items}}', $data['order_items_html'], $content);
        }

        if (isset($data['order_items_with_review_html'])) {
            $content = str_replace('{{order_items_with_review}}', $data['order_items_with_review_html'], $content);
        }

        return $content;
    }

    /**
     * Generate order items HTML
     */
    public static function generateOrderItemsHtml($items): string
    {
        $html = '';
        foreach ($items as $item) {
            $productImage = $item->product->image ?? asset('images/placeholder.png');
            $html .= '<div class="product-item">';
            $html .= '<div style="display: flex; gap: 16px; margin-bottom: 12px;">';
            $html .= '<img src="' . asset($productImage) . '" alt="' . htmlspecialchars($item->product_name) . '" style="width: 80px; height: 80px; object-fit: contain; border: 1px solid #e5e7eb; border-radius: 8px;">';
            $html .= '<div style="flex: 1;">';
            $html .= '<h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 600; color: #1a1a1a;">' . htmlspecialchars($item->product_name) . '</h4>';
            $html .= '<div style="color: #6b7280; font-size: 14px;">Quantity: ' . $item->quantity . '</div>';
            $html .= '<div style="color: #d4af37; font-size: 16px; font-weight: 600; margin-top: 8px;">Rs. ' . number_format($item->price) . '</div>';
            $html .= '</div></div></div>';
        }
        return $html;
    }

    /**
     * Generate order items with review buttons HTML
     */
    public static function generateOrderItemsWithReviewHtml($items): string
    {
        $html = '';
        foreach ($items as $item) {
            $productImage = $item->product->image ?? asset('images/placeholder.png');
            $reviewUrl = $item->product ? route('products.show', $item->product->slug) . '#reviews' : '#';
            
            $html .= '<div class="product-item">';
            $html .= '<div style="display: flex; gap: 16px; margin-bottom: 16px;">';
            $html .= '<img src="' . asset($productImage) . '" alt="' . htmlspecialchars($item->product_name) . '" style="width: 80px; height: 80px; object-fit: contain; border: 1px solid #e5e7eb; border-radius: 8px;">';
            $html .= '<div style="flex: 1;">';
            $html .= '<h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 600; color: #1a1a1a;">' . htmlspecialchars($item->product_name) . '</h4>';
            $html .= '<div style="color: #6b7280; font-size: 14px; margin-bottom: 12px;">Quantity: ' . $item->quantity . '</div>';
            $html .= '<a href="' . $reviewUrl . '" style="display: inline-block; padding: 10px 24px; background: #d4af37; color: #1a1a1a; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px;">⭐ Write a Review</a>';
            $html .= '</div></div></div>';
        }
        return $html;
    }

    /**
     * Get fallback template if database template is not available
     */
    private static function getFallback(string $code, array $data): array
    {
        $subject = 'Notification from Leathers.pk';
        $body = '<p>Thank you for your order!</p>';

        // You can add code-specific fallbacks here
        switch ($code) {
            case 'order_placed':
                $subject = 'Order Received - ' . ($data['order_number'] ?? '');
                break;
            case 'order_confirmed':
                $subject = 'Order Confirmed - ' . ($data['order_number'] ?? '');
                break;
            case 'order_shipped':
                $subject = 'Order Shipped - ' . ($data['order_number'] ?? '');
                break;
            case 'order_delivered':
                $subject = 'Order Delivered - ' . ($data['order_number'] ?? '');
                break;
        }

        return ['subject' => $subject, 'body' => $body];
    }
}
