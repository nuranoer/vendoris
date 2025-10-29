<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;

class AuthController extends Controller
{
    /**
     * Register user baru
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'User registered successfully',
            'data'    => [
                'id'    => $user->id,
                'email' => $user->email,
                'name'  => $user->name,
            ],
        ], 201);
    }

    /**
     * Login user dan dapatkan JWT token
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        /** @var JWTGuard $guard */
        $guard = auth('api');

        if (! $token = $guard->attempt($credentials)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Mendapatkan data user saat ini
     */
    public function me(): JsonResponse
    {
        /** @var JWTGuard $guard */
        $guard = auth('api');

        return response()->json([
            'status' => true,
            'data'   => $guard->user(),
        ]);
    }

    /**
     * Refresh JWT token
     */
    public function refresh(): JsonResponse
    {
        /** @var JWTGuard $guard */
        $guard = auth('api');

        return $this->respondWithToken($guard->refresh());
    }

    /**
     * Logout user
     */
    public function logout(): JsonResponse
    {
        /** @var JWTGuard $guard */
        $guard = auth('api');

        $guard->logout();

        return response()->json([
            'status'  => true,
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * Format respons token JWT
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        /** @var JWTGuard $guard */
        $guard = auth('api');

        return response()->json([
            'status'      => true,
            'token'       => $token,
            'token_type'  => 'bearer',
            'expires_in'  => $guard->factory()->getTTL() * 60, // detik
            'user'        => $guard->user(),
        ]);
    }
}
