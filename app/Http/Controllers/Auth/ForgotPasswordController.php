<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);
        
        Otp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(15)
            ]
        );

        Mail::to($request->email)->send(new OtpMail($otp));

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'email' => $request->email
            ]);
        }

        return redirect()->route('password.verify', ['email' => $request->email])
            ->with('status', 'We have sent an OTP to your email address.');
    }

    public function showVerifyForm(Request $request)
    {
        return view('auth.verify-otp', ['email' => $request->email]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:6'
        ]);

        $otpRecord = Otp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpRecord) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['otp' => ['Invalid or expired OTP.']]
                ], 422);
            }
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        $token = \Illuminate\Support\Str::random(60);
        $otpRecord->update(['otp' => $token]); 
        
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'OTP verified',
                'token' => $token,
                'email' => $request->email
            ]);
        }
        
        return redirect()->route('password.reset', ['email' => $request->email, 'token' => $otpRecord->otp]);
    }

    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', ['email' => $request->email, 'token' => $request->token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required'
        ]);

        $otpRecord = Otp::where('email', $request->email)
            ->where('otp', $request->token)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpRecord) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['email' => ['Invalid or expired token. Please try again.']]
                ], 422);
            }
            return back()->withErrors(['email' => 'Invalid or expired token. Please try again.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->save();

        $otpRecord->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully'
            ]);
        }

        return redirect()->route('login')->with('status', 'Your password has been reset!');
    }
}
