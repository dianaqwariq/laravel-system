<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Cache::get('login_attempts_' . $request->email) >= 5) {
            return response()->json(['error' => 'Account locked. Please try again in 1 hour.'], 401);
        }

        if (!$token = JWTAuth::attempt($credentials)) {
            $attempts = Cache::get('login_attempts_' . $request->email, 0) + 1;
            Cache::put('login_attempts_' . $request->email, $attempts, now()->addHour());

            if ($attempts >= 5) {
                return response()->json(['error' => 'Account locked. Please try again in 1 hour.'], 401);
            }

            return response()->json(['error' => 'Invalid credentials', 'attempts' => $attempts], 401);
        }

        Cache::forget('login_attempts_' . $request->email);
        return response()->json(['token' => $token, 'user' => Auth::user()]);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function unlockAccount(Request $request)
    {
        // Check if the authenticated user is an admin
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized. Only admins can unlock accounts.'], 403);
        }
    
        // Validate the request
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
    
        $email = $request->email;
    
        // Unlock the account by clearing login attempts
        Cache::forget('login_attempts_' . $email);
    
        return response()->json(['message' => 'Account unlocked successfully']);
    }
}