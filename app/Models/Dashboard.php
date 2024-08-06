<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    use HasFactory;

    public static function getPesertaCount($user, $batchId = null)
    {
        return Peserta::whereHas('registrationPlacement.lowongan.mitra', function ($query) use ($user, $batchId) {
            $query->where('user_id', $user->id);
            if ($batchId) {
                $query->where('batch_id', $batchId);
            }
        })->count();
    }

    public static function getLowonganData($user, $batchId = null)
    {
        return Lowongan::whereHas('mitra', function ($query) use ($user, $batchId) {
            $query->where('user_id', $user->id);
            if ($batchId) {
                $query->where('batch_id', $batchId);
            }
        })->withCount('registrations')->get();
    }

    public static function getCounts($batchId = null)
    {
        $pesertaCountQuery = Peserta::query();
        if ($batchId) {
            $pesertaCountQuery->whereHas('registrationPlacement', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            });
        }
        
        $laporanHarianCountQuery = LaporanHarian::query();
        if ($batchId) {
            $laporanHarianCountQuery->whereHas('peserta.registrationPlacement', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            });
        }

        $laporanMingguanCountQuery = LaporanMingguan::query();
        if ($batchId) {
            $laporanMingguanCountQuery->whereHas('peserta.registrationPlacement', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            });
        }

        $laporanLengkapCountQuery = LaporanLengkap::query();
        if ($batchId) {
            $laporanLengkapCountQuery->whereHas('peserta.registrationPlacement', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            });
        }

        return [
            'peserta' => $pesertaCountQuery->count(),
            'dosen' => DosenPembimbingLapangan::count(),
            'mitra' => MitraProfile::count(),
            'lowongan' => Lowongan::count(),
            'laporanHarian' => $laporanHarianCountQuery->count(),
            'laporanMingguan' => $laporanMingguanCountQuery->count(),
            'laporanLengkap' => $laporanLengkapCountQuery->count(),
        ];
    }

    public static function getLaporanHarianStatusCounts($batchId = null)
    {
        $query = LaporanHarian::query();
        if ($batchId) {
            $query->whereHas('peserta.registrationPlacement', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            });
        }
        
        return $query->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();
    }

    public static function getLaporanMingguanStatusCounts($batchId = null)
    {
        $query = LaporanMingguan::query();
        if ($batchId) {
            $query->whereHas('peserta.registrationPlacement', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            });
        }

        return $query->selectRaw('status, count(*) as count')
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

    public static function getMitraDashboardData($user, $batchId = null)
    {
        $daftarPesertaQuery = Peserta::whereHas('registrationPlacement.lowongan.mitra', function ($query) use ($user, $batchId) {
            $query->where('user_id', $user->id);
            if ($batchId) {
                $query->where('batch_id', $batchId);
            }
        });
        $daftarPeserta = $daftarPesertaQuery->get();
        $jumlahPeserta = $daftarPeserta->count();

        $lowonganQuery = Lowongan::whereHas('mitra', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->withCount('registrations');
        $lowongan = $lowonganQuery->get();

        $laporanHarianQuery = LaporanHarian::whereIn('peserta_id', $daftarPeserta->pluck('id'));
        if ($batchId) {
            $laporanHarianQuery->whereHas('peserta.registrationPlacement', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            });
        }
        $laporanHarian = $laporanHarianQuery->get();

        $laporanMingguanQuery = LaporanMingguan::whereIn('peserta_id', $daftarPeserta->pluck('id'));
        if ($batchId) {
            $laporanMingguanQuery->whereHas('peserta.registrationPlacement', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            });
        }
        $laporanMingguan = $laporanMingguanQuery->get();

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

    public static function getDospemDashboardData($user, $batchId = null)
    {
        $daftarPesertaQuery = Peserta::whereHas('registrationPlacement.dospem', function ($query) use ($user, $batchId) {
            $query->where('user_id', $user->id);
            if ($batchId) {
                $query->where('batch_id', $batchId);
            }
        });
        $daftarPeserta = $daftarPesertaQuery->get();

        $laporanHarianQuery = LaporanHarian::whereIn('peserta_id', $daftarPeserta->pluck('id'))->with(['lowongan', 'lowongan.mitra', 'peserta']);
        if ($batchId) {
            $laporanHarianQuery->whereHas('peserta.registrationPlacement', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            });
        }
        $laporanHarian = $laporanHarianQuery->get();

        $laporanMingguanQuery = LaporanMingguan::whereIn('peserta_id', $daftarPeserta->pluck('id'));
        if ($batchId) {
            $laporanMingguanQuery->whereHas('peserta.registrationPlacement', function ($query) use ($batchId) {
                $query->where('batch_id', $batchId);
            });
        }
        $laporanMingguan = $laporanMingguanQuery->get();

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
