<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $redirectUrl = Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard');

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => $redirectUrl
                ]);
            }

            return redirect()->intended($redirectUrl);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'errors' => ['phone' => ['The provided credentials do not match our records.']]
            ], 422);
        }

        return back()->withErrors([
            'phone' => 'The provided credentials do not match our records.',
        ])->onlyInput('phone');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => '/dashboard'
            ]);
        }

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard()
    {
        $user = Auth::user();

        // Fetch orders by email or phone
        $orders = \App\Models\Order::where(function ($query) use ($user) {
            $query->where('customer_email', $user->email);
            if ($user->phone) {
                $query->orWhere('customer_phone', $user->phone);
            }
        })
            ->latest()
            ->get();

        $totalOrders = $orders->count();
        $pendingOrders = $orders->where('status', 'pending')->count();
        $totalSpent = $orders->sum('total');

        return view('account.dashboard', compact('orders', 'totalOrders', 'pendingOrders', 'totalSpent'));
    }
}
