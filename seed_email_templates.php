<?php

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // 1. New Order (Admin Notification / User Confirmation)
    EmailTemplate::updateOrCreate(
        ['code' => 'new_order'],
        [
            'subject' => 'Order Confirmation - Order #{{order_number}}',
            'body' => '<h1>Thank you for your order!</h1>
<p>Hi {{customer_name}},</p>
<p>We have received your order <strong>#{{order_number}}</strong> and it is now being processed.</p>
<h3>Order Summary</h3>
<p>Total: {{total_amount}}</p>
<p>View your order here: <a href="{{order_url}}">View Order</a></p>
<p>Thanks,<br>Leathers PK Team</p>',
            'variables' => json_encode(['order_number', 'customer_name', 'total_amount', 'order_url']),
        ]
    );

    // 2. Confirmed Order
    EmailTemplate::updateOrCreate(
        ['code' => 'confirmed_order'],
        [
            'subject' => 'Your Order #{{order_number}} has been Confirmed',
            'body' => '<h1>Order Confirmed!</h1>
<p>Hi {{customer_name}},</p>
<p>Your order <strong>#{{order_number}}</strong> has been confirmed and is being prepared for shipment.</p>
<p>We will notify you once it ships.</p>
<p>Thanks,<br>Leathers PK Team</p>',
            'variables' => json_encode(['order_number', 'customer_name']),
        ]
    );

    // 3. Delivered Order (with Review)
    EmailTemplate::updateOrCreate(
        ['code' => 'delivered_order'],
        [
            'subject' => 'Your Order #{{order_number}} has been Delivered',
            'body' => '<h1>Your Order is Here!</h1>
<p>Hi {{customer_name}},</p>
<p>We hope you are enjoying your new items from Leathers PK!</p>
<p>Your order <strong>#{{order_number}}</strong> was marked as delivered.</p>
<h3>What do you think?</h3>
<p>We would love to hear your feedback. Please leave a review to help others.</p>
<p><a href="{{review_url}}" style="background-color: #d4af37; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Leave a Review</a></p>
<p>Thanks,<br>Leathers PK Team</p>',
            'variables' => json_encode(['order_number', 'customer_name', 'review_url']),
        ]
    );

    echo "Email templates seeded successfully.\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
