<?php

// namespace App\Models;

// use App\Models\LaporanHarian;
// use App\Models\LaporanMingguan;
// use App\Models\Lowongan;
// use App\Models\MitraProfile;
// use App\Models\Peserta;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Dashboard extends Model
// {
//     use HasFactory;

//     public static function getPesertaCount($user)
//     {
//         return Peserta::whereHas('registrationPlacement.lowongan.mitra', function ($query) use ($user) {
//             $query->where('user_id', $user->id);
//         })->count();
//     }

//     public static function getLowonganData($user)
//     {
//         return Lowongan::whereHas('mitra', function ($query) use ($user) {
//             $query->where('user_id', $user->id);
//         })->withCount('registrations')->get();
//     }

//     public static function getCounts()
//     {
//         return [
//             'peserta' => Peserta::count(),
//             'dosen' => DosenPembimbingLapangan::count(),
//             'mitra' => MitraProfile::count(),
//             'lowongan' => Lowongan::count(),
//             'laporanHarian' => LaporanHarian::count(),
//             'laporanMingguan' => LaporanMingguan::count(),
//             'laporanLengkap' => LaporanLengkap::count(),
//         ];
//     }

//     public static function getLaporanHarianStatusCounts()
//     {
//         return LaporanHarian::selectRaw('status, count(*) as count')
//             ->groupBy('status')
//             ->get()
//             ->pluck('count', 'status')
//             ->toArray();
//     }

//     public static function getLaporanMingguanStatusCounts()
//     {
//         return LaporanMingguan::selectRaw('status, count(*) as count')
//             ->groupBy('status')
//             ->get()
//             ->pluck('count', 'status')
//             ->toArray();
//     }

//     public static function getStaffDashboardData()
//     {
//         // $jumlahPesertaAktif = Peserta::where('status', 'aktif')->count();
//         $laporanHarian = LaporanHarian::count();
//         $laporanMingguan = LaporanMingguan::count();
//         $lowonganTersedia = Lowongan::where('is_open', true)->count();
//         $pesertaTerbaru = Peserta::orderBy('created_at', 'desc')->take(5)->get();

//         return compact( 'laporanHarian', 'laporanMingguan', 'lowonganTersedia', 'pesertaTerbaru');
//     }
// }

namespace App\Models;

use App\Models\LaporanHarian;
use App\Models\LaporanMingguan;
use App\Models\Lowongan;
use App\Models\MitraProfile;
use App\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function getStaffDashboardData()
    {
        return [
            'laporanHarian' => LaporanHarian::count(),
            'laporanMingguan' => LaporanMingguan::count(),
            'lowonganTersedia' => Lowongan::where('is_open', true)->count(),
            'pesertaTerbaru' => Peserta::orderBy('created_at', 'desc')->take(5)->get(),
        ];
    }

    public static function getMitraDashboardData($user)
    {
        $daftarPeserta = Peserta::whereHas('registrationPlacement.lowongan.mitra', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        $jumlahPeserta = $daftarPeserta->count();
        $lowongan = Lowongan::whereHas('mitra', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->withCount('registrations')->get();
        $laporanHarian = LaporanHarian::whereIn('peserta_id', $daftarPeserta->pluck('id'))->get();
        $laporanMingguan = LaporanMingguan::whereIn('peserta_id', $daftarPeserta->pluck('id'))->get();

        return [
            'jumlahPeserta' => $jumlahPeserta,
            'lowongan' => $lowongan,
            'laporanHarian' => $laporanHarian->count(),
            'laporanMingguan' => $laporanMingguan->count(),
            'validasiHarian' => $laporanHarian->where('status', 'validasi')->count(),
            'revisiHarian' => $laporanHarian->where('status', 'revisi')->count(),
            'pendingHarian' => $laporanHarian->where('status', 'pending')->count(),
            'validasiMingguan' => $laporanMingguan->where('status', 'validasi')->count(),
            'revisiMingguan' => $laporanMingguan->where('status', 'revisi')->count(),
            'pendingMingguan' => $laporanMingguan->where('status', 'pending')->count(),
        ];
    }

    public static function getDospemDashboardData($user)
    {
        $daftarPeserta = Peserta::whereHas('registrationPlacement.dospem', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        $laporanHarian = LaporanHarian::whereIn('peserta_id', $daftarPeserta->pluck('id'))->with(['lowongan', 'lowongan.mitra', 'peserta'])->get();
        $laporanMingguan = LaporanMingguan::whereIn('peserta_id', $daftarPeserta->pluck('id'))->get();

        $dataPeserta = $daftarPeserta->map(function ($peserta) use ($laporanHarian, $laporanMingguan) {
            $jumlahLaporanHarian = $laporanHarian->where('peserta_id', $peserta->id)->count();
            $jumlahLaporanMingguan = $laporanMingguan->where('peserta_id', $peserta->id)->count();
            $firstLaporanHarian = $laporanHarian->where('peserta_id', $peserta->id)->first();
            $lowongan = optional($firstLaporanHarian)->lowongan;
            $mitra = optional($lowongan)->mitra;

            return [
                'peserta' => $peserta,
                'jumlah_laporan_harian' => $jumlahLaporanHarian,
                'jumlah_laporan_mingguan' => $jumlahLaporanMingguan,
                'lowongan' => optional($lowongan)->name,
                'mitra' => optional($mitra)->name,
            ];
        });

        return [
            'dataPeserta' => $dataPeserta,
            'jumlahPesertaBimbingan' => $daftarPeserta->count(),
            'statistikLaporan' => [
                'total_harian' => $laporanHarian->count(),
                'validasi_harian' => $laporanHarian->where('status', 'validasi')->count(),
                'pending_harian' => $laporanHarian->where('status', 'pending')->count(),
                'revisi_harian' => $laporanHarian->where('status', 'revisi')->count(),
                'total_mingguan' => $laporanMingguan->count(),
                'validasi_mingguan' => $laporanMingguan->where('status', 'validasi')->count(),
                'pending_mingguan' => $laporanMingguan->where('status', 'pending')->count(),
                'revisi_mingguan' => $laporanMingguan->where('status', 'revisi')->count(),
            ],
        ];
    }
}
