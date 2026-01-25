<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        event(new Registered($user));


       return response()->json([
        'message' => 'User created successfully',
        'user' => $user,
       ], 201);
    } 


    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials!',
        ], 401);
    }

    if (!$user->hasVerifiedEmail()) {
        return response()->json([
            'message' => 'Email not verified!',
        ], 401);
    }

    $token = $user->createToken('auth-token')->plainTextToken;

    return response()->json([
        'message' => 'User logged in successfully',
        'user' => $user,
        'token' => $token,
        'token_type' => 'Bearer',
    ], 200);
}

}
