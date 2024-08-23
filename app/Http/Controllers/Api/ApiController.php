<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BatchMbkm;
use App\Models\LaporanLengkap;
use App\Models\sisfo\Matakuliah;

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
            'peserta.registrationPlacement.dospem',
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
        $data = $laporanLengkap->map(function ($laporan) use ($activeBatch) {
            return [
                'MhswID' => $laporan->peserta->nim, // Ganti NIM menjadi MhswID
                'Nama Mahasiswa' => $laporan->peserta->nama,
                'Nama Mitra' => $laporan->peserta->registrationPlacement->lowongan->mitra->name ?? 'N/A',
                'Nama Lowongan' => $laporan->peserta->registrationPlacement->lowongan->name ?? 'N/A',
                'Dosen Pembimbing' => $laporan->peserta->registrationPlacement->dospem->name ?? 'N/A',
                'Batch Aktif' => $activeBatch->name, // Nama batch aktif
                'Isi Laporan' => $laporan->isi_laporan,
                'Status' => $laporan->status,
                'Tanggal Validasi' => $laporan->updated_at->format('Y-m-d'),
                'Laporan Dibuat' => $laporan->created_at->format('Y-m-d'),
            ];
        });

        // Kembalikan data dalam format JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Data laporan lengkap dengan status validasi berhasil diambil.',
            'data' => $data,
        ]);
    }

    public function getDataMataKuliahSisfo()
    {
        $matakuliah = Matakuliah::get();

        if ($matakuliah->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data mata kuliah yang ditemukan.'], 404);
        }

        $data = $matakuliah->map(function ($mk) {
            return [
                'MKID' => $mk->MKID,
                'KodeID' => $mk->KodeID,
                'Nama' => $mk->Nama,
                'SKS' => $mk->SKS,
                'MKKode' => $mk->MKKode,
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Data mata kuliah berhasil diambil.',
            'data' => $data,
        ]);
    }
}
