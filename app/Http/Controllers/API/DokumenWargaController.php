<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DokumenWarga;
use Illuminate\Http\Request;

class DokumenWargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Get all data dokumen warga success!',
            'data' => DokumenWarga::with('user')->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'dokumen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'keterangan' => 'nullable|boolean',
        ]);

        $data['user_id'] = auth()->user()->id;

        if ($request->hasFile('dokumen')) {
            $data['dokumen'] = $request->file('dokumen')->store('dokumen');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Create data dokumen warga success!',
            'data' => DokumenWarga::create($data)
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(DokumenWarga $dokumenWarga)
    {
        
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Get data dokumen warga success!',
        //     'data' => $dokumenWarga->with('user')->get()
        // ], 200);

        $image = asset('storage/' . $dokumenWarga->dokumen);

        // masukkan image ke dalam array data
        $data = $dokumenWarga->with('user')->get();
        $data['image'] = $image;

        return response()->json([
            'status' => 'success',
            'message' => 'Get data dokumen warga success!',
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DokumenWarga $dokumenWarga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DokumenWarga $dokumenWarga)
    {
        //
    }
}
