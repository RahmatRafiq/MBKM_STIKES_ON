<?php

namespace App\Http\Controllers;

use App\Models\DosenPembimbingLapangan;
use App\Models\LaporanHarian;
use App\Models\LaporanLengkap;
use App\Models\LaporanMingguan;
use App\Models\Lowongan;
use App\Models\MitraProfile;
use App\Models\Peserta;

class DashboardController extends Controller
{
    public function index()
    {
        $peserta = Peserta::all();
        $dosen = DosenPembimbingLapangan::all();
        $mitra = MitraProfile::all();
        $lowongan = Lowongan::all();
        $laporanHarian = LaporanHarian::all();
        $laporanBulanan = LaporanMingguan::all();
        $laporanLengkap = LaporanLengkap::all();

        return view('applications.mbkm.dashboard', compact
            (
                'peserta',
                'dosen',
                'mitra',
                'lowongan',
                'laporanHarian',
                'laporanBulanan',
                'laporanLengkap'
            )
        );
    }
}
