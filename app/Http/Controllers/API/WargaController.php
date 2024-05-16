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
     * Recap all data warga to csv.
     */

    public function recap()
    {
        // rekap ke dalam file csv lalu kirim ke react untuk di download
        $warga = Warga::all();
        $filename = 'rekap_warga.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('ID', 'Nama KK', 'Blok', 'Jalan', 'Jumlah Keluarga', 'Status Kependudukan', 'Nomor HP'));

        foreach ($warga as $row) {
            fputcsv($handle, array($row['id'], $row['nama_kk'], $row['blok'], $row['jalan'], $row['jumlah_keluarga'], $row['status_kependudukan'], $row['nomor_hp']));
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download($filename, 'rekap_warga.csv', $headers);
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
