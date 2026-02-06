<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'kamu siapa? ko bisa salah terus loginnya',
            ], 401);
        }

        $user = Auth::user();

        // buat token (Sanctum)
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message'  => 'Login berhasil',
            'user'     => [
                'id'       => $user->id,
                'name'     => $user->name,
                'email'    => $user->email,
                'is_admin' => $user->is_admin,
            ],
            'redirect' => $user->is_admin == 1 ? '/admin' : '/',
            'token'    => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil',
        ]);
    }
}
