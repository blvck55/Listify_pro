<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PragmaRX\Google2FAQRCode\Google2FA;

class AuthApiController extends Controller
{
    /**
     * Authenticate using email and password.
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }

        // Check if 2FA is enabled and confirmed
        if ($user->two_factor_secret && $user->two_factor_confirmed_at) {
            return response()->json([
                'success' => true,
                'two_factor' => true,
                'message' => '2FA verification required.',
                'email' => $user->email,
            ], 200);
        }

        // Revoke any existing token with this name before issuing a new one.
        $user->tokens()->where('name', 'api-token')->delete();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'token'   => $token,
            'user'    => $this->formatUserResponse($user),
        ]);
    }

    /**
     * Authenticate with Google id_token and issue a Sanctum token.
     */
    public function googleAuth(Request $request): JsonResponse
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        try {
            // Fetch Google public keys and validate the supplied id_token.
            $token = $request->id_token;
            $jwkResponse = Http::get('https://www.googleapis.com/oauth2/v3/certs');
            $jwks = $jwkResponse->json();
            $keys = JWK::parseKeySet($jwks, 'RS256');

            $decoded = JWT::decode($token, $keys);
            /** @var \stdClass $decoded */
            $payload = (array) $decoded;

            $issuer = $payload['iss'] ?? null;
            $audience = $payload['aud'] ?? null;
            $expiry = $payload['exp'] ?? 0;

            if (! in_array($issuer, ['accounts.google.com', 'https://accounts.google.com'], true)
                || $audience !== config('services.google.client_id')
                || $expiry < time()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid id_token.',
                ], 401);
            }

            $email = $payload['email'] ?? null;
            $name = $payload['name'] ?? 'Google User';
            $googleId = $payload['sub'] ?? null;

            if (! $email || ! $googleId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Google id_token payload is missing required fields.',
                ], 422);
            }

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'      => $name,
                    'google_id' => $googleId,
                    'password'  => Hash::make(Str::random(32)), // Random password for OAuth users
                    'role'      => 'user',
                ]
            );

            // Update google_id if the user account existed without it.
            if (!$user->google_id) {
                $user->update(['google_id' => $googleId]);
            }

            // Check if 2FA is enabled and confirmed
            if ($user->two_factor_secret && $user->two_factor_confirmed_at) {
                return response()->json([
                    'success' => true,
                    'two_factor' => true,
                    'message' => '2FA verification required.',
                    'email' => $user->email,
                ], 200);
            }

            // Revoke any existing token
            $user->tokens()->where('name', 'api-token')->delete();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Google authentication successful.',
                'token'   => $token,
                'user'    => $this->formatUserResponse($user),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Google authentication failed: ' . $e->getMessage(),
            ], 401);
        }
    }

    /**
     * Register a new user account and return an API token.
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Do NOT wrap with Hash::make() — the User model 'password' cast hashes automatically.
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'user',
        ]);

        $user->tokens()->where('name', 'api-token')->delete();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful.',
            'token'   => $token,
            'user'    => $this->formatUserResponse($user),
        ], 201);
    }

    /**
     * Revoke the current API token for the authenticated user.
     */
    public function logout(Request $request): JsonResponse
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            /** @var \Laravel\Sanctum\PersonalAccessToken|null $token */
            $token = $user->currentAccessToken();
            if ($token) {
                $token->delete();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.',
        ]);
    }

    /**
     * Return the authenticated user's profile data.
     */
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'user'    => $this->formatUserResponse($user),
        ]);
    }

    /**
     * Verify two-factor authentication using code or recovery code.
     * Stateless — identifies the user by email (no session required).
     */
    public function twoFactorChallenge(Request $request): JsonResponse
    {
        $request->validate([
            'email'         => 'required|email',
            'code'          => 'nullable|string|size:6',
            'recovery_code' => 'nullable|string',
        ]);

        if (!$request->code && !$request->recovery_code) {
            return response()->json([
                'success' => false,
                'message' => 'Either code or recovery_code is required.',
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->two_factor_secret || !$user->two_factor_confirmed_at) {
            return response()->json([
                'success' => false,
                'message' => '2FA is not enabled for this account.',
            ], 422);
        }

        // Decrypt the stored 2FA secret (Fortify stores it encrypted).
        try {
            $decryptedSecret = decrypt($user->two_factor_secret);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '2FA configuration error. Please reconfigure 2FA in your profile.',
            ], 422);
        }

        // Handle authenticator app TOTP code.
        if ($request->code) {
            $google2FA = new Google2FA();

            if (!$google2FA->verifyKey($decryptedSecret, $request->code)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid 2FA code.',
                ], 422);
            }

            $user->tokens()->where('name', 'api-token')->delete();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => '2FA verified successfully.',
                'token'   => $token,
                'user'    => $this->formatUserResponse($user),
            ]);
        }

        // Handle recovery code.
        if ($request->recovery_code) {
            try {
                $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true) ?? [];
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => '2FA configuration error. Please reconfigure 2FA in your profile.',
                ], 422);
            }

            if (!in_array($request->recovery_code, $recoveryCodes, true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid recovery code.',
                ], 422);
            }

            // Consume the used recovery code so it cannot be reused.
            $remaining = array_values(array_diff($recoveryCodes, [$request->recovery_code]));
            $user->update(['two_factor_recovery_codes' => encrypt(json_encode($remaining))]);

            $user->tokens()->where('name', 'api-token')->delete();
            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => '2FA verified with recovery code.',
                'token'   => $token,
                'user'    => $this->formatUserResponse($user),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Either code or recovery_code is required.',
        ], 422);
    }

    /**
     * Normalize the returned user payload for API responses.
     */
    private function formatUserResponse(User $user): array
    {
        return [
            'id'                => $user->id,
            'name'              => $user->name,
            'email'             => $user->email,
            'role'              => $user->role,
            'profile_photo_url' => $user->profile_photo_url,
            'email_verified'    => ! is_null($user->email_verified_at),
            'two_factor_enabled'=> ! is_null($user->two_factor_confirmed_at),
            'created_at'        => $user->created_at->toDateTimeString(),
        ];
    }
}
