<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ], 201);
    }

    /**
     * Login a user.
     */
    public function login(Request $request) {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
        
        $user = User::where('username', $request->username)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        // /** @var \App\Models\User $user **/ $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'User logged in successfully',
            'data' => [
                'user' => $user,
                'token' => $user->createToken('token')->plainTextToken,
            ]
        ], 200);
    }

    /**
     * Logout a user.
     */
    public function logout(Request $request) {
        // delete token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
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
