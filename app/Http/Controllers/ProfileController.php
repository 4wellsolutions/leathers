<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('account.profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Phone is read-only now
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->address = $validated['address'];
        $user->city = $validated['city'];
        // Phone is not updated

        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.'
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}
