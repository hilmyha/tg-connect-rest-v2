<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request, CreateNewUser $createNewUser) {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $user = $createNewUser->create($request->all());

        $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 5259600);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ])->withCookie($cookie);
    }

    /**
     * Login a user.
     */
    public function login(Request $request) {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if (!auth()->attempt($request->all())) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        /** @var \App\Models\User $user **/ $token = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $token, 5259600);

        return response()->json([
            'status' => true,
            'message' => 'User logged in successfully',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ])->withCookie($cookie);
    }

    /**
     * Logout a user.
     */
    public function logout(Request $request) {
        $cookie = Cookie::forget('jwt');

        return response([
            'status' => true,
            'message' => 'Token deleted'
        ])->withCookie($cookie);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // $cookie = cookie('token', $request->user()->currentAccessToken()->plainTextToken, 60 * 24); // 1 day

        return Auth::user();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
