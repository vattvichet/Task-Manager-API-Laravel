<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //


    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        $user = User::create($validated);
        return response()->json([
            'status' => 'success',
            'data' => $user,
            'access_token' => $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
        ], 201);
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|email",
            "password" => "required|min:8"
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json([
                'status' => 'Login Failed',
                'message' => 'User Invalid',
            ], 401);
        }
        $user = User::where('email', $validated['email'])->first();

        return response()->json([
            'access_token' =>  $user->createToken('api_token')->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }
}
