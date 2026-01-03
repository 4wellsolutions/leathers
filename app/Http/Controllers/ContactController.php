<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
// Use a generic mailable or verify if one exists, for now just basic logic or todo

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Send email in background
        \App\Jobs\SendContactEmail::dispatch($validated);

        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
