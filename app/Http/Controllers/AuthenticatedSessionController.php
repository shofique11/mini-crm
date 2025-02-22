<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Fortify\Fortify;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle a login request to the application.
     */
    public function store(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        if ($user->two_factor_secret) {
            $user->forceFill([
                'two_factor_code'       => rand(100000, 999999),
                'two_factor_expires_at' => now()->addMinutes(10),
            ])->save();

            $user->notify(new TwoFactorCodeNotification($user->two_factor_code));
            return response()->json([
                'message' => '2FA required. Please check your email for the verification code.',
                'requiresTwoFactor' => true
            ]);
        }
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    /**
     * Handle 2FA Verification
     */
    public function verify2FA(Request $request)
    {
        $request->validate([
            'email'           => 'required|email',
            'two_factor_code' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->two_factor_code !== $request->two_factor_code) {
            return response()->json(['error' => 'Invalid 2FA code'], 401);
        }
        if ($user->two_factor_expires_at->lt(now())) {
            return response()->json(['error' => '2FA code expired'], 401);
        }

        // ✅ Clear OTP after successful verification
        $user->forceFill([
            'two_factor_code'       => null,
            'two_factor_expires_at' => null,
        ])->save();

        // ✅ Generate JWT token
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => '2FA verified successfully',
            'token'   => $token,
            'user'  => $user,
        ]);
    }
}

