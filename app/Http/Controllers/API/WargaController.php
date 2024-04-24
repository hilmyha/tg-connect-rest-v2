<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // buatkan kondisi jika user belum login
        if (!Auth::check()) {
            return response([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        } 

        return response()->json([
            'status' => 'success',
            'message' => 'Get all data warga success!',
            'data' => Warga::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kk' => 'required|string',
            'blok' => 'required|string',
            'jalan' => 'required|string',
            'jumlah_keluarga' => 'required|integer',
            'status_kependudukan' => 'required|boolean',
            'nomor_hp' => 'required|string',
        ]);

        $data['user_id'] = Auth::id();

        // cek jika user sudah mempunyai data warga
        if (Warga::where('user_id', Auth::id())->count() > 0) {
            return response([
                'status' => 'error',
                'message' => 'User already has data warga'
            ], 400);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Create data warga success!',
                'data' => Warga::create($data)
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Warga $warga)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Get data warga by id success',
            'data' => $warga
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warga $warga)
    {
        $data = $request->validate([
            'nama_kk' => 'required|string',
            'blok' => 'required|string',
            'jalan' => 'required|string',
            'jumlah_keluarga' => 'required|integer',
            'status_kependudukan' => 'required|boolean',
            'nomor_hp' => 'required|string',
        ]);

        $warga->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Update data warga success!',
            'data' => $warga
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warga $warga)
    {
        $warga->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Delete data warga success!',
            'data' => null
        ], 200);
    }
}
