<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Cek email & password
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'  => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        $user = Auth::user();

        // ===== CEK: ADMIN TIDAK BOLEH LOGIN KE FLUTTER =====
        if ($user->is_admin == 1) {
            // Logout langsung
            Auth::logout();
            
            return response()->json([
                'status'  => false,
                'message' => 'Admin tidak bisa mengakses Flutter app. Gunakan web dashboard.',
                'error'   => 'admin_not_allowed',
            ], 403);
        }

        // ===== USER BIASA BISA LOGIN =====
        // Buat token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status'   => true,
            'message'  => 'Login berhasil',
            'user'     => [
                'id'       => $user->id,
                'name'     => $user->name,
                'email'    => $user->email,
                'is_admin' => $user->is_admin,
            ],
            'token'    => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Logout berhasil',
        ]);
    }
}