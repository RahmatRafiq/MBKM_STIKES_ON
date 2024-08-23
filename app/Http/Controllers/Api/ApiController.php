<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BatchMbkm;
use App\Models\LaporanLengkap;

use App\Models\sisfo\Mahasiswa;

use App\Models\sisfo\Dosen;


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


    public function getDataMahasiswaSisfo()
    {
        $dataMahasiswa = Mahasiswa::all();

        if ($dataMahasiswa->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data mahasiswa yang ditemukan.'], 404);
        }

        $data = $dataMahasiswa->map(function ($mahasiswa) {
            return [
                'MhswID' => $mahasiswa->MhswID,
                'Nama' => $mahasiswa->Nama,
                'Kelamin' => $mahasiswa->Kelamin,
                'Alamat' => $mahasiswa->Alamat,
                'Telepon' => $mahasiswa->telepon,
                'Agama' => $mahasiswa->Agama,
                'Email' => $mahasiswa->Email,
                'Login' => $mahasiswa->Login,
                'LevelID' => $mahasiswa->LevelID,
                'Password' => $mahasiswa->Password,
                'NIMSementara' => $mahasiswa->NIMSementara,
                'KDPIN' => $mahasiswa->KDPIN,
                'PMBID' => $mahasiswa->PMBID,
            ];
        });
        return response()->json([
            'status' => 'success',
            'message' => 'Data mahasiswa berhasil diambil.',

    public function getDataDosenSisfo()
    {
        $dataDosen = Dosen::all();

        if ($dataDosen->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data dosen yang ditemukan.'], 404);
        }

        $data = $dataDosen->map(function ($dosen) {
            return [
                'Nama' => $dosen->Nama,
                'NIDN' => $dosen->NIDN,
                'Login' => $dosen->Login,
                'KodeID' => $dosen->KodeID,
                'HomebaseInduk' => $dosen->HomebaseInduk,
                'NIPPNS' => $dosen->NIPPNS,
                'TempatLahir' => $dosen->TempatLahir, // TempatLahir
                'TanggalLahir' => $dosen->TanggalLahir, // TanggalLahir
                'LevelID' => $dosen->LevelID, // LevelID
                'KTP' => $dosen->KTP, // KTP
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Data dosen berhasil diambil.',

            'data' => $data,
        ]);
    }
}
