<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    public function index()
    {
        // Get all settings
        $settings = [];
        $allSettings = Setting::all();

        foreach ($allSettings as $setting) {
            $settings[$setting->key] = $setting->value;
        }

        // Check if logo exists at public/logo.png
        if (File::exists(public_path('logo.png'))) {
            $settings['site_logo'] = asset('logo.png');
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
            'notification_emails' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if (empty($value))
                        return;
                    // Split by comma and validate each email
                    $emails = array_map('trim', explode(',', $value));
                    foreach ($emails as $email) {
                        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $fail("The email '{$email}' is not valid.");
                            break;
                        }
                    }
                }
            ],
        ]);

        // Handle logo upload - store at public/logo.png
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');

            // Delete old logo if exists
            if (File::exists(public_path('logo.png'))) {
                File::delete(public_path('logo.png'));
            }

            // Move the file to public/logo.png
            $logoFile->move(public_path(), 'logo.png');

            // Store the path in settings
            Setting::set('site_logo', 'logo.png');
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $faviconFile = $request->file('favicon');
            $faviconName = 'favicon.' . $faviconFile->getClientOriginalExtension();

            // Delete old favicon if exists
            if (File::exists(public_path($faviconName))) {
                File::delete(public_path($faviconName));
            }

            // Move the file
            $faviconFile->move(public_path(), $faviconName);

            // Store the path in settings
            Setting::set('site_favicon', $faviconName);
        }

        // Save all text settings
        $textSettings = [
            'site_name',
            'homepage_title',
            'homepage_subtitle',
            'homepage_cta_text',
            'meta_description',
            'topbar_text',
            'social_whatsapp',
            'social_facebook',
            'social_instagram',
            'social_twitter',
            'social_linkedin',
            'social_youtube',
            'contact_email',
            'contact_phone',
            'facebook_url',
            'instagram_url',
        ];

        foreach ($textSettings as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        // Save textarea settings
        $textareaSettings = [
            'header_scripts',
            'footer_scripts',
            'notification_emails',
        ];

        foreach ($textareaSettings as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key), 'textarea');
            }
        }

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully!');
    }
}
