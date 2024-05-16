<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return response([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Get all data informasi success!',
            'data' => Informasi::latest()->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|string',
            'waktu' => 'required|string',
        ]);

        $data['user_id'] = Auth::id();

        return response()->json([
            'status' => 'success',
            'message' => 'Create data informasi success!',
            'data' => Informasi::create($data)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Informasi $informasi)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Get data informasi success!',
            'data' => $informasi->with(['user'])->where('user_id', auth()->id())->latest()->get()
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Informasi $informasi)
    
    {
        $data = $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|string',
            'waktu' => 'required|string',
        ]);

        $informasi->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Update data informasi success!',
            'data' => $informasi
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Informasi $informasi)
    {
        $informasi->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Delete data informasi success!'
        ], 200);
    }
}
