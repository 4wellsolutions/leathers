<?php

namespace App\Services;

use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        $html = '<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px; border-collapse: collapse;">';
        foreach ($items as $item) {
            $productImage = $item->product->image ?? 'images/placeholder.png';
            $imageUrl = Str::startsWith($productImage, 'http') ? $productImage : url($productImage);

            $html .= '<tr>';
            $html .= '<td style="padding: 15px 0; border-bottom: 1px solid #F8F5F2;">';
            $html .= '<table width="100%" cellpadding="0" cellspacing="0">';
            $html .= '<tr>';
            $html .= '<td width="70" valign="top">';
            $html .= '<img src="' . $imageUrl . '" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover; border: 1px solid #EAE2D8;">';
            $html .= '</td>';
            $html .= '<td valign="top" style="padding-left: 15px;">';
            $html .= '<div style="font-size: 15px; font-weight: 600; color: #2D1B14; margin-bottom: 3px;">' . htmlspecialchars($item->product_name) . '</div>';
            if ($item->variant_name) {
                $html .= '<div style="font-size: 12px; color: #8A7366; margin-bottom: 4px;">' . htmlspecialchars($item->variant_name) . '</div>';
            }
            $html .= '<div style="font-size: 13px; color: #5C4A42;">Qty: ' . $item->quantity . '</div>';
            $html .= '</td>';
            $html .= '<td valign="top" style="text-align: right; font-size: 15px; font-weight: 600; color: #2D1B14;">';
            $html .= 'Rs. ' . number_format($item->price * $item->quantity);
            $html .= '</td>';
            $html .= '</tr></table></td></tr>';
        }
        $html .= '</table>';
        return $html;
    }

    /**
     * Generate order items with review buttons HTML
     */
    public static function generateOrderItemsWithReviewHtml($items): string
    {
        $html = '<table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px; border-collapse: collapse;">';
        foreach ($items as $item) {
            $productImage = $item->product->image ?? 'images/placeholder.png';
            $imageUrl = Str::startsWith($productImage, 'http') ? $productImage : url($productImage);
            $reviewUrl = $item->product ? route('products.show', $item->product->slug) . '#reviews' : '#';

            $html .= '<tr>';
            $html .= '<td style="padding: 15px 0; border-bottom: 1px solid rgba(45, 27, 20, 0.05);">';
            $html .= '<table width="100%" cellpadding="0" cellspacing="0">';
            $html .= '<tr>';
            $html .= '<td width="70" valign="top">';
            $html .= '<img src="' . $imageUrl . '" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">';
            $html .= '</td>';
            $html .= '<td valign="top" style="padding-left: 15px;">';
            $html .= '<div style="font-size: 14px; font-weight: 600; color: #2D1B14; margin-bottom: 2px;">' . htmlspecialchars($item->product_name) . '</div>';
            $html .= '<div style="font-size: 12px; color: #8A7366; margin-bottom: 8px;">' . $item->quantity . ' Order(s) Received</div>';
            $html .= '<a href="' . $reviewUrl . '" style="display: inline-block; padding: 7px 18px; background: #C5A359; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">⭐ Write Review</a>';
            $html .= '</td>';
            $html .= '</tr></table></td></tr>';
        }
        $html .= '</table>';
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
