<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            if (! $googleUser->getId() || ! $googleUser->getEmail()) {
                throw new \RuntimeException('Google did not return an ID or email.');
            }

            // Check if user already exists with this Google ID
            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                // Check if user exists with this email
                $user = User::where('email', $googleUser->getEmail())->first();

                if ($user) {
                    // Link Google account to existing user
                    $user->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                } else {
                    // Create new user
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'password' => Hash::make(uniqid()), // Random password since OAuth
                        'email_verified_at' => now(), // Google emails are verified
                    ]);
                }
            }

            if (! $user->email_verified_at) {
                $user->email_verified_at = now();
                $user->save();
            }

            Auth::guard('web')->login($user, true);

            if (! Auth::check()) {
                throw new \RuntimeException('Login failed after Google authentication.');
            }

            // Redirect admins to admin panel, regular users to dashboard
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            \Log::error('Google callback error: '.$e->getMessage(), ['exception' => $e]);
            return redirect('/login')
                ->with('error', 'Unable to authenticate with Google. '.$e->getMessage())
                ->withErrors(['google' => 'Unable to authenticate with Google. '.$e->getMessage()]);
        }
    }
}
