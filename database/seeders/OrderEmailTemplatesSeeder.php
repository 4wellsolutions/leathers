<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class OrderEmailTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Order Placed',
                'code' => 'order_placed',
                'subject' => '🎉 Order Received - {{order_number}} | Leathers.pk',
                'body' => $this->getOrderPlacedTemplate(),
                'variables' => json_encode([
                    '{{customer_name}}' => 'Customer full name',
                    '{{order_number}}' => 'Order number',
                    '{{order_date}}' => 'Order creation date',
                    '{{order_items}}' => 'List of order items (auto-generated)',
                    '{{subtotal}}' => 'Order subtotal',
                    '{{shipping_cost}}' => 'Shipping cost',
                    '{{total}}' => 'Order total',
                    '{{shipping_address}}' => 'Complete shipping address',
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Order Confirmed',
                'code' => 'order_confirmed',
                'subject' => '✅ Order Confirmed - {{order_number}} | Leathers.pk',
                'body' => $this->getOrderConfirmedTemplate(),
                'variables' => json_encode([
                    '{{customer_name}}' => 'Customer full name',
                    '{{order_number}}' => 'Order number',
                    '{{estimated_delivery}}' => 'Estimated delivery date range',
                    '{{order_items}}' => 'List of order items (auto-generated)',
                    '{{subtotal}}' => 'Order subtotal',
                    '{{shipping_cost}}' => 'Shipping cost',
                    '{{total}}' => 'Order total',
                    '{{shipping_address}}' => 'Complete shipping address',
                    '{{customer_phone}}' => 'Customer phone number',
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Order Shipped',
                'code' => 'order_shipped',
                'subject' => '🚚 Order Shipped - {{order_number}} | Leathers.pk',
                'body' => $this->getOrderShippedTemplate(),
                'variables' => json_encode([
                    '{{customer_name}}' => 'Customer full name',
                    '{{order_number}}' => 'Order number',
                    '{{expected_delivery}}' => 'Expected delivery date range',
                    '{{tracking_number}}' => 'Tracking number (if available)',
                    '{{order_items}}' => 'List of order items (auto-generated)',
                    '{{shipping_address}}' => 'Complete shipping address',
                    '{{customer_phone}}' => 'Customer phone number',
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Order Delivered',
                'code' => 'order_delivered',
                'subject' => '🎊 Order Delivered - Share Your Experience! | Leathers.pk',
                'body' => $this->getOrderDeliveredTemplate(),
                'variables' => json_encode([
                    '{{customer_name}}' => 'Customer full name',
                    '{{order_number}}' => 'Order number',
                    '{{order_items_with_review}}' => 'List of items with review buttons (auto-generated)',
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['code' => $template['code']],
                $template
            );
        }
    }

    private function getOrderPlacedTemplate(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #1a1a1a; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; }
        .header { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); padding: 40px 30px; text-align: center; }
        .logo { font-size: 28px; font-weight: 700; letter-spacing: 3px; color: #d4af37; }
        .content { padding: 40px 30px; }
        .title { font-size: 24px; font-weight: 700; color: #1a1a1a; margin-bottom: 16px; }
        .text { font-size: 16px; color: #4a5568; margin-bottom: 16px; }
        .info-box { background: #f9fafb; border-left: 4px solid #d4af37; padding: 20px; margin: 24px 0; border-radius: 8px; }
        .info-label { font-size: 14px; font-weight: 600; color: #6b7280; margin-bottom: 8px; }
        .info-value { font-size: 20px; font-weight: 700; color: #1a1a1a; }
        .product-item { padding: 20px; margin-bottom: 16px; background-color: #fafafa; border-radius: 8px; border: 1px solid #e5e7eb; }
        .summary-row { display: flex; justify-content: space-between; padding: 10px 0; }
        .summary-total { border-top: 2px solid #d4af37; margin-top: 12px; padding-top: 16px; font-weight: 700; font-size: 18px; }
        .btn { display: inline-block; padding: 14px 32px; background: #d4af37; color: #1a1a1a; text-decoration: none; border-radius: 6px; font-weight: 600; }
        .footer { background-color: #1a1a1a; padding: 30px; text-align: center; color: #9ca3af; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">LEATHERS.PK</div>
        </div>
        <div class="content">
            <h1 class="title">🎉 Thank You for Your Order!</h1>
            <p class="text">Hi <strong>{{customer_name}}</strong>,</p>
            <p class="text">We're thrilled to have you as a customer! Your order has been received and is being prepared with care.</p>
            
            <div class="info-box">
                <div class="info-label">Order Number</div>
                <div class="info-value">{{order_number}}</div>
            </div>
            
            <div class="info-box">
                <div class="info-label">Order Date</div>
                <div class="info-value">{{order_date}}</div>
            </div>
            
            <h3>Order Details</h3>
            {{order_items}}
            
            <div style="background: #fafafa; padding: 24px; border-radius: 8px; margin: 30px 0;">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>Rs. {{subtotal}}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span>Rs. {{shipping_cost}}</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Total:</span>
                    <span>Rs. {{total}}</span>
                </div>
            </div>
            
            <h3>Shipping Address</h3>
            <p class="text">{{shipping_address}}</p>
            
            <div style="text-align: center; margin-top: 40px;">
                <a href="{{store_url}}" class="btn">Continue Shopping</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{current_year}} Leathers.pk. All rights reserved.</p>
            <p>Questions? Contact us at hello@leathers.pk</p>
        </div>
    </div>
</body>
</html>
HTML;
    }

    private function getOrderConfirmedTemplate(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #1a1a1a; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; }
        .header { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); padding: 40px 30px; text-align: center; }
        .logo { font-size: 28px; font-weight: 700; letter-spacing: 3px; color: #d4af37; }
        .content { padding: 40px 30px; }
        .title { font-size: 24px; font-weight: 700; color: #1a1a1a; margin-bottom: 16px; }
        .text { font-size: 16px; color: #4a5568; margin-bottom: 16px; }
        .success-box { background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left: 4px solid #22c55e; padding: 20px; margin: 24px 0; border-radius: 8px; }
        .success-label { font-size: 14px; font-weight: 600; color: #166534; margin-bottom: 8px; }
        .success-value { font-size: 20px; font-weight: 700; color: #166534; }
        .delivery-box { background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 20px; margin: 24px 0; border-radius: 8px; }
        .delivery-label { font-size: 14px; font-weight: 600; color: #92400e; margin-bottom: 8px; }
        .delivery-value { font-size: 18px; font-weight: 700; color: #92400e; }
        .summary-row { display: flex; justify-content: space-between; padding: 10px 0; }
        .summary-total { border-top: 2px solid #d4af37; margin-top: 12px; padding-top: 16px; font-weight: 700; font-size: 18px; }
        .btn { display: inline-block; padding: 14px 32px; background: #d4af37; color: #1a1a1a; text-decoration: none; border-radius: 6px; font-weight: 600; }
        .footer { background-color: #1a1a1a; padding: 30px; text-align: center; color: #9ca3af; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">LEATHERS.PK</div>
        </div>
        <div class="content">
            <h1 class="title">✅ Your Order is Confirmed!</h1>
            <p class="text">Hi <strong>{{customer_name}}</strong>,</p>
            <p class="text">Great news! We've confirmed your order and our artisans are now carefully preparing your premium leather goods.</p>
            
            <div class="success-box">
                <div class="success-label">✓ Order Confirmed</div>
                <div class="success-value">{{order_number}}</div>
            </div>
            
            <div class="delivery-box">
                <div class="delivery-label">📦 ESTIMATED DELIVERY</div>
                <div class="delivery-value">{{estimated_delivery}}</div>
            </div>
            
            <h3>Your Items</h3>
            {{order_items}}
            
            <div style="background: #fafafa; padding: 24px; border-radius: 8px; margin: 30px 0;">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>Rs. {{subtotal}}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping:</span>
                    <span>Rs. {{shipping_cost}}</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Total:</span>
                    <span>Rs. {{total}}</span>
                </div>
            </div>
            
            <h3>Delivery Information</h3>
            <p class="text">
                <strong>{{customer_name}}</strong><br>
                {{shipping_address}}<br>
                Phone: {{customer_phone}}
            </p>
            
            <div style="text-align: center; margin-top: 40px;">
                <a href="{{store_url}}" class="btn">Shop More</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{current_year}} Leathers.pk. All rights reserved.</p>
            <p>We'll notify you as soon as your order ships!</p>
        </div>
    </div>
</body>
</html>
HTML;
    }

    private function getOrderShippedTemplate(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #1a1a1a; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; }
        .header { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); padding: 40px 30px; text-align: center; }
        .logo { font-size: 28px; font-weight: 700; letter-spacing: 3px; color: #d4af37; }
        .content { padding: 40px 30px; }
        .title { font-size: 24px; font-weight: 700; color: #1a1a1a; margin-bottom: 16px; }
        .text { font-size: 16px; color: #4a5568; margin-bottom: 16px; }
        .shipped-box { background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border-left: 4px solid #3b82f6; padding: 20px; margin: 24px 0; border-radius: 8px; }
        .shipped-label { font-size: 14px; font-weight: 600; color: #1e40af; margin-bottom: 8px; }
        .shipped-value { font-size: 20px; font-weight: 700; color: #1e40af; }
        .delivery-box { background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 20px; margin: 24px 0; border-radius: 8px; }
        .btn { display: inline-block; padding: 14px 32px; background: #d4af37; color: #1a1a1a; text-decoration: none; border-radius: 6px; font-weight: 600; }
        .footer { background-color: #1a1a1a; padding: 30px; text-align: center; color: #9ca3af; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">LEATHERS.PK</div>
        </div>
        <div class="content">
            <h1 class="title">🚚 Your Order is On Its Way!</h1>
            <p class="text">Hi <strong>{{customer_name}}</strong>,</p>
            <p class="text">Exciting news! Your order has been shipped and is heading your way.</p>
            
            <div class="shipped-box">
                <div class="shipped-label">🚚 SHIPPED</div>
                <div class="shipped-value">{{order_number}}</div>
            </div>
            
            <div class="delivery-box" style="text-align: center;">
                <div style="font-size: 14px; font-weight: 600; color: #92400e; margin-bottom: 8px;">📅 EXPECTED DELIVERY</div>
                <div style="font-size: 18px; font-weight: 700; color: #92400e;">{{expected_delivery}}</div>
            </div>
            
            <h3>What's in Your Package</h3>
            {{order_items}}
            
            <h3>Shipping To</h3>
            <p class="text">
                <strong>{{customer_name}}</strong><br>
                {{shipping_address}}<br>
                Phone: {{customer_phone}}
            </p>
            
            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 24px; border-radius: 8px; margin: 32px 0; text-align: center;">
                <div style="font-size: 16px; color: #92400e; margin-bottom: 8px;">💡 Pro Tip</div>
                <div style="font-size: 14px; color: #78350f;">Make sure someone is available to receive your package.</div>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{current_year}} Leathers.pk. All rights reserved.</p>
            <p>We'll send you another email once your order is delivered!</p>
        </div>
    </div>
</body>
</html>
HTML;
    }

    private function getOrderDeliveredTemplate(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #1a1a1a; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; }
        .header { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); padding: 40px 30px; text-align: center; }
        .logo { font-size: 28px; font-weight: 700; letter-spacing: 3px; color: #d4af37; }
        .content { padding: 40px 30px; }
        .title { font-size: 24px; font-weight: 700; color: #1a1a1a; margin-bottom: 16px; }
        .text { font-size: 16px; color: #4a5568; margin-bottom: 16px; }
        .success-box { background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border-left: 4px solid #22c55e; padding: 20px; margin: 24px 0; border-radius: 8px; }
        .review-cta { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); padding: 32px; border-radius: 12px; margin: 32px 0; text-align: center; color: white; }
        .review-title { font-size: 24px; font-weight: 700; color: #d4af37; margin-bottom: 12px; }
        .btn-review { display: inline-block; padding: 14px 32px; background: #d4af37; color: #1a1a1a; text-decoration: none; border-radius: 6px; font-weight: 600; margin-top: 16px; }
        .offer-box { background-color: #fef3c7; border-left: 4px solid #d4af37; padding: 20px; margin: 32px 0; border-radius: 8px; }
        .footer { background-color: #1a1a1a; padding: 30px; text-align: center; color: #9ca3af; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">LEATHERS.PK</div>
        </div>
        <div class="content">
            <h1 class="title">🎊 Your Order Has Been Delivered!</h1>
            <p class="text">Hi <strong>{{customer_name}}</strong>,</p>
            <p class="text">Wonderful news! Your order has been successfully delivered. We hope you're absolutely thrilled with your new premium leather goods!</p>
            
            <div class="success-box" style="text-align: center;">
                <div style="font-size: 14px; font-weight: 600; color: #166534; margin-bottom: 8px;">✓ DELIVERED SUCCESSFULLY</div>
                <div style="font-size: 20px; font-weight: 700; color: #166534;">{{order_number}}</div>
            </div>
            
            <div class="review-cta">
                <div class="review-title">⭐ Love Your Products?</div>
                <div style="font-size: 16px; color: #e5e7eb; margin-bottom: 24px;">Share your experience and help other customers discover quality!</div>
            </div>
            
            <h3 style="text-align: center;">Rate Your Products</h3>
            {{order_items_with_review}}
            
            <div class="offer-box">
                <div style="font-size: 14px; font-weight: 600; color: #92400e; margin-bottom: 8px;">🎁 EXCLUSIVE OFFER</div>
                <div style="font-size: 15px; color: #78350f;">Leave a review and get <strong>10% OFF</strong> your next purchase!</div>
            </div>
            
  <div style="text-align: center; margin: 40px 0;">
                <h3>Any Issues?</h3>
                <p class="text">We're committed to your satisfaction. Contact us within 7 days if needed.</p>
                <a href="mailto:hello@leathers.pk" style="display: inline-block; padding: 12px 24px; border: 2px solid #1a1a1a; color: #1a1a1a; text-decoration: none; border-radius: 6px; font-weight: 600;">Contact Support</a>
            </div>
            
            <div style="background: #f9fafb; padding: 32px; border-radius: 12px; margin: 32px 0; text-align: center;">
                <div style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px;">Thank you for choosing Leathers.pk!</div>
                <div style="font-size: 15px; color: #6b7280; margin-bottom: 24px;">Your support means everything to us.</div>
                <a href="{{store_url}}" class="btn-review">Shop Again</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{current_year}} Leathers.pk. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
HTML;
    }
}
