<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validate notification emails if present
        if ($request->has('notification_emails')) {
            $request->validate([
                'notification_emails' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
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
        }

        $data = $request->except('_token', '_method', 'logo', 'favicon');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/images', $filename);
            $data['site_logo'] = '/storage/images/' . $filename;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $extension = $file->getClientOriginalExtension();
            $filename = 'favicon.' . $extension;
            $path = $file->storeAs('public/images', $filename);
            $data['site_favicon'] = '/storage/images/' . $filename;
        }

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
    }
}
