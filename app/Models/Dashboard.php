<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Peserta;
use App\Models\MitraProfile;
use App\Models\Lowongan;
use App\Models\LaporanHarian;
use App\Models\LaporanMingguan;

class Dashboard extends Model
{
    use HasFactory;

    public static function getPesertaCount($user)
    {
        return Peserta::whereHas('registrationPlacement.lowongan.mitra', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();
    }

    public static function getLowonganData($user)
    {
        return Lowongan::whereHas('mitra', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->withCount('registrations')->get();
    }

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
}
