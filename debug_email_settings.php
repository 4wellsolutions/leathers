<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Raw DB Value:\n";
$raw = Setting::get('notification_emails');
var_dump($raw);

echo "\nProcessed Array (getNotificationEmails):\n";
$emails = Setting::getNotificationEmails();
print_r($emails);

if (empty($emails)) {
    echo "\nWARNING: No valid emails found!\n";
} else {
    echo "\nAttempting to send debug email...\n";
    try {
        Mail::raw('This is a test email to verify admin notifications.', function ($message) use ($emails) {
            $message->to('test@example.com') // Dummy To
                ->subject('Debug Admin Notification')
                ->bcc($emails);
        });
        echo "Email dispatched successfully (check logs/inbox).\n";
    } catch (\Exception $e) {
        echo "Error sending email: " . $e->getMessage() . "\n";
    }
}
