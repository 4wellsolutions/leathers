<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type'];

    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $type = 'text')
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    /**
     * Get notification emails as array
     */
    public static function getNotificationEmails()
    {
        $emails = self::get('notification_emails', config('mail.from.address'));

        // Split by comma, trim whitespace, filter empty values
        return array_filter(
            array_map('trim', explode(',', $emails)),
            function ($email) {
                return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
            }
        );
    }
}
