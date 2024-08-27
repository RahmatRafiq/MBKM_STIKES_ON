<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BatchMbkm;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLowonganController extends Controller
{
    // Mendapatkan daftar lowongan dengan gambar mitra
    public function getLowongan(Request $request)
    {
        $search = $request->query('search');
        $type = $request->query('type');
        $query = Lowongan::with(['mitra' => function($query) {
            $query->select('id', 'name', 'type'); // Ambil kolom yang diperlukan
        }]);

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($type) {
            $query->whereHas('mitra', function ($q) use ($type) {
                $q->where('type', $type);
            });
        }

        $lowongans = $query->paginate(10);

        // Map untuk menambahkan URL gambar dari koleksi mitra
        $lowongans->getCollection()->transform(function ($lowongan) {
            return [
                'id' => $lowongan->id,
                'name' => $lowongan->name,
                'description' => $lowongan->description,
                'quota' => $lowongan->quota,
                'is_open' => $lowongan->is_open,
                'location' => $lowongan->location,
                'gpa' => $lowongan->gpa,
                'semester' => $lowongan->semester,
                'experience_required' => $lowongan->experience_required,
                'start_date' => $lowongan->start_date,
                'end_date' => $lowongan->end_date,
                'mitra' => [
                    'id' => $lowongan->mitra->id,
                    'name' => $lowongan->mitra->name,
                    'type' => $lowongan->mitra->type,
                    'image_url' => $lowongan->mitra->getFirstMediaUrl('images') // Ambil URL gambar pertama
                ]
            ];
        });

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

        // Periksa apakah pengguna sudah login
        $isLoggedIn = Auth::check();

        return response()->json([
            'status' => 'success',
            'message' => 'Detail lowongan berhasil diambil.',
            'data' => [
                'id' => $lowongan->id,
                'name' => $lowongan->name,
                'description' => $lowongan->description,
                'quota' => $lowongan->quota,
                'is_open' => $lowongan->is_open,
                'location' => $lowongan->location,
                'gpa' => $lowongan->gpa,
                'semester' => $lowongan->semester,
                'experience_required' => $lowongan->experience_required,
                'start_date' => $lowongan->start_date,
                'end_date' => $lowongan->end_date,
                'mitra' => [
                    'id' => $lowongan->mitra->id,
                    'name' => $lowongan->mitra->name,
                    'type' => $lowongan->mitra->type,
                    'image_url' => $lowongan->mitra->getFirstMediaUrl('images') // Ambil URL gambar
                ],
                'can_register' => $isLoggedIn, // Tambahkan informasi apakah user bisa mendaftar atau tidak
            ]
        ]);
    }

    // Mendaftarkan pengguna ke lowongan
    public function registerForLowongan(Request $request)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
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
