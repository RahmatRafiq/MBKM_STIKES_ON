<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BatchMbkm;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLowonganController extends Controller
{
    // Mendapatkan daftar lowongan dengan filter (search dan tipe mitra)
    public function getLowongan(Request $request)
    {
        $search = $request->query('search');
        $type = $request->query('type');
        $query = Lowongan::with('mitra');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($type) {
            $query->whereHas('mitra', function ($q) use ($type) {
                $q->where('type', $type);
            });
        }

        $lowongans = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'message' => 'Lowongan berhasil diambil.',
            'data' => $lowongans,
        ]);
    }

    // Mendapatkan detail lowongan berdasarkan ID
    public function getLowonganDetail($id)
    {
        $lowongan = Lowongan::with('mitra')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Detail lowongan berhasil diambil.',
            'data' => $lowongan,
        ]);
    }

    // Mendaftarkan pengguna ke lowongan
    public function registerForLowongan(Request $request)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, kembalikan respons 401 Unauthorized
            return response()->json(['message' => 'Silahkan login terlebih dahulu.'], 401);
        }

        // Validasi data pendaftaran
        $request->validate([
            'lowongan_id' => 'required|exists:lowongans,id',
        ]);

        // Ambil peserta dan batch aktif
        $peserta = Auth::user()->peserta;
        $lowonganId = $request->input('lowongan_id');
        $batchId = BatchMbkm::getActiveBatch()->id;

        // Cek apakah peserta sudah mendaftar di lowongan ini pada batch aktif
        $existingRegistration = $peserta->registrations()
            ->where('lowongan_id', $lowonganId)
            ->where('batch_id', $batchId)
            ->first();

        if ($existingRegistration) {
            return response()->json(['message' => 'Anda sudah mendaftar di lowongan ini.'], 400);
        }

        // Simpan pendaftaran baru
        $peserta->registrations()->create([
            'lowongan_id' => $lowonganId,
            'status' => 'registered',
            'batch_id' => $batchId,
        ]);

        return response()->json(['message' => 'Pendaftaran berhasil.'], 201);
    }
}
