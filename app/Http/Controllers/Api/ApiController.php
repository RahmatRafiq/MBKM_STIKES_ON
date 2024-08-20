<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LaporanLengkap;
use App\Models\BatchMbkm;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getValidatedLaporanLengkap()
    {
        // Dapatkan batch aktif
        $activeBatch = BatchMbkm::getActiveBatch();
        if (!$activeBatch) {
            return response()->json(['error' => 'Tidak ada batch aktif yang sedang berjalan.'], 403);
        }

        // Ambil laporan lengkap dengan status 'validasi' berdasarkan batch aktif
        $laporanLengkap = LaporanLengkap::with([
            'peserta.registrationPlacement.lowongan.mitra',
            'peserta.registrationPlacement.dospem'
        ])
            ->whereHas('peserta.registrationPlacement', function ($query) use ($activeBatch) {
                $query->where('batch_id', $activeBatch->id);
            })
            ->where('status', 'validasi')
            ->get();

        // Jika tidak ada data yang ditemukan
        if ($laporanLengkap->isEmpty()) {
            return response()->json(['message' => 'Tidak ada laporan lengkap dengan status validasi ditemukan.'], 404);
        }

        // Transformasi data untuk kebutuhan API
        $data = $laporanLengkap->map(function ($laporan) {
            return [
                'MhswID' => $laporan->peserta->nim, // Ganti NIM menjadi MhswID
                'Nama Mahasiswa' => $laporan->peserta->nama,
                'Nama Mitra' => $laporan->peserta->registrationPlacement->lowongan->mitra->name ?? 'N/A',
                'Nama Lowongan' => $laporan->peserta->registrationPlacement->lowongan->name ?? 'N/A',
                'Isi Laporan' => $laporan->isi_laporan,
                'Status' => $laporan->status,
                'Tanggal Validasi' => $laporan->updated_at->format('Y-m-d'),
            ];
        });

        // Kembalikan data dalam format JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Data laporan lengkap dengan status validasi berhasil diambil.',
            'data' => $data
        ]);
    }
}
