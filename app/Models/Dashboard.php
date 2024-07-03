<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

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

    public static function getLaporanHarianStatusCounts()
    {
        return LaporanHarian::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
    }

    public static function getLaporanMingguanStatusCounts()
    {
        return LaporanMingguan::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
    }

    // public static function getCountsByPeserta($pesertaId)
    // {
    //     $laporanHarianCounts = LaporanHarian::where('peserta_id', $pesertaId)
    //         ->selectRaw('status, count(*) as count')
    //         ->groupBy('status')
    //         ->get()
    //         ->pluck('count', 'status')
    //         ->toArray();

    //     $laporanMingguanCounts = LaporanMingguan::where('peserta_id', $pesertaId)
    //         ->selectRaw('status, count(*) as count')
    //         ->groupBy('status')
    //         ->get()
    //         ->pluck('count', 'status')
    //         ->toArray();

    //     return [
    //         'laporanHarianCount' => LaporanHarian::where('peserta_id', $pesertaId)->count(),
    //         'laporanMingguanCount' => LaporanMingguan::where('peserta_id', $pesertaId)->count(),
    //         'laporanHarianStatusCounts' => $laporanHarianCounts,
    //         'laporanMingguanStatusCounts' => $laporanMingguanCounts,
    //     ];
    // }
}
