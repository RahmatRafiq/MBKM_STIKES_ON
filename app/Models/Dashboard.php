<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
   public static function getCounts()
    {
        return [
            'peserta' => Peserta::count(),
            'dosen' => DosenPembimbingLapangan::count(),
            'mitra' => MitraProfile::count(),
            'lowongan' => Lowongan::count(),
            'laporanHarian' => LaporanHarian::count(),
            'laporanMingguan' => LaporanMingguan::count(),
            'laporanLengkap' => LaporanLengkap::count(),
        ];
    }
}
