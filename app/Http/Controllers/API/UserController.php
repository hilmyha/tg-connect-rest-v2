<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // buatkan kondisi jika is_admin = 0 maka tidak bisa mengakses data user
        if (Auth::user()->is_admin == 1) {
            return response()->json([
                'status' => 'success',
                'message' => 'Get all data user success!',
                'data' => User::all()
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username', // Add 'unique:users,username
            'email' => 'required|email|unique:users,email',
            'is_admin' => 'required|boolean',
            'password' => 'required|string|min:8'
        ]);

        $data['password'] = bcrypt($data['password']);

        return response()->json([
            'status' => 'success',
            'message' => 'Create data user success!',
            'data' => User::create($data)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Get data user success!',
            'data' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,'. $user->id,
            'email' => 'required|email|unique:users,email,'. $user->id,
            'is_admin' => 'required|boolean',
            'password' => 'nullable|string|min:8'
        ]);

        if ($request->password) {
            $data['password'] = bcrypt($data['password']);
        }

        User::where('id', $user->id)->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Update data user success!',
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
