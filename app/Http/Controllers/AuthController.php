<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        $user->save();

        $token = $user->createToken('MyApp')->accessToken;

        return response()->json(['token' => $token], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->accessToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->token()->revoke();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
