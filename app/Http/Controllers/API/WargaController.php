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

    // public function recap()
    // {
    //     // rekap semua data warga dan jadikan csv di storage
    //     $warga = Warga::all();
    //     $filename = 'recap-warga-' . time() . '.csv';
    //     $handle = fopen(storage_path('app/public/' . $filename), 'w');

    //     fputcsv($handle, [
    //         'ID',
    //         'Nama KK',
    //         'Blok',
    //         'Jalan',
    //         'Jumlah Keluarga',
    //         'Status Kependudukan',
    //         'Nomor HP',
    //         'User ID',
    //         'Created At',
    //         'Updated At'
    //     ]);

    //     foreach ($warga as $row) {
    //         fputcsv($handle, [
    //             $row->id,
    //             $row->nama_kk,
    //             $row->blok,
    //             $row->jalan,
    //             $row->jumlah_keluarga,
    //             $row->status_kependudukan,
    //             $row->nomor_hp,
    //             $row->user_id,
    //             $row->created_at,
    //             $row->updated_at
    //         ]);
    //     }

    //     fclose($handle);

    //     // store file csv rekap data warga
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Recap data warga success!',
    //         'data' => asset('storage/' . $filename)
    //     ], 200);
    // }

    public function recap()
{
    // rekap semua data warga dan jadikan csv di storage
    $warga = Warga::all();
    // set time ke timezone indonesia dan format tanggal dan waktu
    $time = \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('Y-m-d-H-i-s');
    $filename = 'recap-warga-' . $time . '.csv';
    $handle = fopen(storage_path('app/public/' . $filename), 'w');

    fputcsv($handle, [
        'ID',
        'Nama KK',
        'Blok',
        'Jalan',
        'Jumlah Keluarga',
        'Status Kependudukan',
        'Nomor HP',
        'User ID',
        'Created At',
        'Updated At'
    ]);

    foreach ($warga as $row) {
        fputcsv($handle, [
            $row->id,
            $row->nama_kk,
            $row->blok,
            $row->jalan,
            $row->jumlah_keluarga,
            $row->status_kependudukan,
            $row->nomor_hp,
            $row->user_id,
            $row->created_at,
            $row->updated_at
        ]);
    }

    fclose($handle);

    // store file csv rekap data warga
    return response()->json([
        'status' => 'success',
        'message' => 'Recap data warga success!',
        'data' => asset('storage/' . $filename)
    ], 200);
}


    // public function downloadRecap()
    // {
    //     // download file csv rekap data warga
    //     return response()->download(storage_path('app/public/recap-warga-' . time() . '.csv'));
    // }

    public function showRecap() {
        $files = scandir(storage_path('app/public'));
        $recaps = [];

        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) == 'csv') {
                $recaps[] = $file;
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Get all recap data success!',
            'data' => $recaps
        ], 200);
    }

    // show csv recap by filename
    public function showRecapWarga($filename)
    {
        // tampikan file csv rekap data warga berdasarkan nama file
        $filePath = storage_path('app/public/' . $filename);

        if (!file_exists($filePath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File not found'
            ], 404);
        }

        $data = array_map('str_getcsv', file($filePath));

        return response()->json([
            'status' => 'success',
            'message' => 'Get recap data success!',
            'data' => $data
        ], 200);
    }

    public function downloadRecap($filename)
    {
        $filePath = storage_path('app/public/' . $filename);
        
        if (!file_exists($filePath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File not found'
            ], 404);
        }

        return response()->download($filePath);
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
