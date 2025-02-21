<?php
namespace App\Providers;

use App\Models\User;
use App\Notifications\TwoFactorCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->two_factor_secret) {
                    // Generate a new 2FA code
                    $user->forceFill([
                        'two_factor_code'       => rand(100000, 999999), // Generate 6-digit OTP
                        'two_factor_expires_at' => now()->addMinutes(10),
                    ])->save();
                    // Send the 2FA code via email
                    $user->notify(new TwoFactorCodeNotification($user->two_factor_code));
                    return null; // Stop login until 2FA is verified
                }
                return $user; // Allow login if 2FA is not enabled
            }
        });

        //  Customize Login Response to Issue JWT Token
        Fortify::loginResponse(function (Request $request) {
            $user = $request->user();

            if (! $user) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            //  Issue JWT token if 2FA is not required
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'message' => 'Login successful',
                'token'   => $token,
                'user'    => $user,
            ]);
        });
    }
}
