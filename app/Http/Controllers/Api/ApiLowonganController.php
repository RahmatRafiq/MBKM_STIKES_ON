<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\BatchMbkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLowonganController extends Controller
{
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

    public function getLowonganDetail($id)
    {
        $lowongan = Lowongan::with('mitra')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Detail lowongan berhasil diambil.',
            'data' => $lowongan,
        ]);
    }

    public function registerForLowongan(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Silahkan login terlebih dahulu.'], 401);
        }

        $request->validate([
            'lowongan_id' => 'required|exists:lowongans,id',
        ]);

        $peserta = Auth::user()->peserta;
        $lowonganId = $request->input('lowongan_id');
        $batchId = BatchMbkm::getActiveBatch()->id;

        // Cek jika peserta sudah mendaftar di lowongan ini di batch aktif
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
