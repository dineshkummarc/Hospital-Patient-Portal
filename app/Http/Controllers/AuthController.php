<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'role'     => 'required|string|in:patient,doctor,admin,nurse,receptionist,pharmacist,accountant'
            ]);

            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => $validated['role'],
                'email_verified_at' => now()
            ]);

            $token = JWTAuth::claims([
                'role'  => $user->role,
                'email' => $user->email,
                'name'  => $user->name,
            ])->fromUser($user);

            return response()->json([
                'message' => 'User registered successfully',
                'user'    => $user,
                'token'   => $token
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = JWTAuth::user();

        $token = JWTAuth::claims([
            'role'  => $user->role,
            'email' => $user->email,
            'name'  => $user->name,
        ])->fromUser($user);

        return response()->json([
            'message' => 'Login successful',
            'user'    => $user,
            'token'   => $token
        ]);
    }


    public function me()
    {
        return response()->json(JWTAuth::parseToken()->authenticate());
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }
}
