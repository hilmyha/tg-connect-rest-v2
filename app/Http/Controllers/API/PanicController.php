<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Panic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Get all data panic success!',
            'data' => Panic::latest()->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        $data['user_id'] = Auth::id();

        return response()->json([
            'status' => 'success',
            'message' => 'Create data panic success!',
            'data' => Panic::create($data)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Panic $panic)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Get data panic success!',
            'data' => $panic
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Panic $panic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Panic $panic)
    {
        //
    }
}
