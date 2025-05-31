<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input termasuk role
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,penjual,konsumen', // ← role dipilih user
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status_code' => 400,
                    'success' => false,
                    'message' => 'Validation Error',
                ],
                'errors' => $validator->errors(),
            ], 400);
        }

        // Buat user baru dengan role dari request
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Generate JWT token
        $token = $this->generateJWT($user);

        return response()->json([
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'token' => $token,
            'meta' => [
                'status_code' => 201,
                'success' => true,
                'message' => 'User registered successfully',
            ],
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'status_code' => 400,
                    'success' => false,
                    'message' => 'Validation Error',
                ],
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'meta' => [
                    'status_code' => 401,
                    'success' => false,
                    'message' => 'Invalid email or password',
                ],
            ], 401);
        }

        $token = $this->generateJWT($user);

        return response()->json([
            'data' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'token' => $token,
            'meta' => [
                'status_code' => 200,
                'success' => true,
                'message' => 'Success Login',
                'pagination' => new \stdClass(),
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        return response()->json([
            'meta' => [
                'status_code' => 200,
                'success' => true,
                'message' => 'User logged out successfully',
            ],
        ], 200);
    }

    private function generateJWT($user)
    {
        $payload = [
            'iss' => "your-app-name",
            'sub' => $user->id,
            'role' => $user->role,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24),
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}
