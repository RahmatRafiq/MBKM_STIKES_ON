<?php

namespace App\Http\Controllers;

use App\Models\BatchMbkm;
use App\Models\Dashboard;
use App\Models\LaporanHarian;
use App\Models\LaporanMingguan;
use App\Models\Lowongan;
use App\Models\Peserta;
use App\Models\Registrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $activeBatch;
    private $batchActive;

    public function __construct()
    {
        $this->activeBatch = BatchMbkm::getActiveBatch();
        $this->batchActive = $this->activeBatch !== null;
    }

    public function index()
    {
        if (!$this->batchActive) {
            return response()->view('applications.mbkm.error-page.batch-no-active', [
                'message' => 'Tidak ada batch aktif yang sedang berjalan.',
            ], 403);
        }

        $user = Auth::user();

        if ($user->hasRole('super admin')) {
            return $this->dashboardAdmin();
        } elseif ($user->hasRole('mitra')) {
            return $this->dashboardMitra();
        } elseif ($user->hasRole('dosen')) {
            return $this->dashboardDospem();
        } elseif ($user->hasRole('staff')) {
            return $this->dashboarStaff();
        } elseif ($user->hasRole('peserta')) {
            return $this->dashboardPeserta(app('request'));
        } else {
            return response()->view('applications.mbkm.error-page.batch-no-active', [
                'message' => 'Unauthorized action.',
            ], 403);
        }
    }

    public function dashboardAdmin()
    {
        if (!$this->batchActive) {
            return response()->view('applications.mbkm.error-page.batch-no-active', [
                'message' => 'Tidak ada batch aktif yang sedang berjalan.',
            ], 403);
        }

        $counts = Dashboard::getCounts();
        $laporanHarianCounts = Dashboard::getLaporanHarianStatusCounts();
        $laporanMingguanCounts = Dashboard::getLaporanMingguanStatusCounts();

        return view('applications.mbkm.admin.dashboard', [
            'peserta' => $counts['peserta'],
            'dosen' => $counts['dosen'],
            'mitra' => $counts['mitra'],
            'lowongan' => $counts['lowongan'],
            'laporanHarian' => $counts['laporanHarian'],
            'laporanMingguan' => $counts['laporanMingguan'],
            'laporanLengkap' => $counts['laporanLengkap'],
            'validasiCount' => $laporanHarianCounts['validasi'] ?? 0,
            'pendingCount' => $laporanHarianCounts['pending'] ?? 0,
            'revisiCount' => $laporanHarianCounts['revisi'] ?? 0,
            'validasiCountMingguan' => $laporanMingguanCounts['validasi'] ?? 0,
            'pendingCountMingguan' => $laporanMingguanCounts['pending'] ?? 0,
            'revisiCountMingguan' => $laporanMingguanCounts['revisi'] ?? 0,
        ]);
    }

    public function dashboardMitra()
    {
        if (!$this->batchActive) {
            return response()->view('applications.mbkm.error-page.batch-no-active', [
                'message' => 'Tidak ada batch aktif yang sedang berjalan.',
            ], 403);
        }

        $user = Auth::user();

        // Mengambil data peserta yang ditempatkan di mitra tersebut
        $daftarPeserta = Peserta::whereHas('registrationPlacement.lowongan.mitra', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        $jumlahPeserta = $daftarPeserta->count();

        // Mengambil data lowongan yang dibuat oleh mitra tersebut dan jumlah pendaftarnya
        $lowongan = Lowongan::whereHas('mitra', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->withCount('registrations')->get();

        // Mengambil laporan harian dan mingguan untuk peserta yang ditempatkan di mitra tersebut
        $laporanHarian = LaporanHarian::whereIn('peserta_id', $daftarPeserta->pluck('id'))->get();
        $laporanMingguan = LaporanMingguan::whereIn('peserta_id', $daftarPeserta->pluck('id'))->get();

        // Menghitung status laporan harian
        $validasiHarian = $laporanHarian->where('status', 'validasi')->count();
        $revisiHarian = $laporanHarian->where('status', 'revisi')->count();
        $pendingHarian = $laporanHarian->where('status', 'pending')->count();

        // Menghitung status laporan mingguan
        $validasiMingguan = $laporanMingguan->where('status', 'validasi')->count();
        $revisiMingguan = $laporanMingguan->where('status', 'revisi')->count();
        $pendingMingguan = $laporanMingguan->where('status', 'pending')->count();

        return view('applications.mbkm.mitra.dashboard', [
            'jumlahPeserta' => $jumlahPeserta,
            'lowongan' => $lowongan,
            'laporanHarian' => $laporanHarian->count(),
            'laporanMingguan' => $laporanMingguan->count(),
            'validasiHarian' => $validasiHarian,
            'revisiHarian' => $revisiHarian,
            'pendingHarian' => $pendingHarian,
            'validasiMingguan' => $validasiMingguan,
            'revisiMingguan' => $revisiMingguan,
            'pendingMingguan' => $pendingMingguan,
        ]);
    }

    public function dashboardDospem()
    {
        if (!$this->batchActive) {
            return response()->view('applications.mbkm.error-page.batch-no-active', [
                'message' => 'Tidak ada batch aktif yang sedang berjalan.',
            ], 403);
        }

        $user = Auth::user();

        // Mengambil data peserta yang ditempatkan di dospem tersebut
        $daftarPeserta = Peserta::whereHas('registrationPlacement.dospem', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        // Mengambil laporan harian dan mingguan untuk peserta yang ditempatkan di dospem tersebut
        $laporanHarian = LaporanHarian::whereIn('peserta_id', $daftarPeserta->pluck('id'))
            ->with(['lowongan', 'lowongan.mitra', 'peserta'])
            ->get();

        $laporanMingguan = LaporanMingguan::whereIn('peserta_id', $daftarPeserta->pluck('id'))->get();

        // Menyiapkan data untuk view
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

        // Menghitung statistik laporan
        $totalLaporanHarian = $laporanHarian->count();
        $validasiLaporanHarian = $laporanHarian->where('status', 'validasi')->count();
        $pendingLaporanHarian = $laporanHarian->where('status', 'pending')->count();
        $revisiLaporanHarian = $laporanHarian->where('status', 'revisi')->count();

        $totalLaporanMingguan = $laporanMingguan->count();
        $validasiLaporanMingguan = $laporanMingguan->where('status', 'validasi')->count();
        $pendingLaporanMingguan = $laporanMingguan->where('status', 'pending')->count();
        $revisiLaporanMingguan = $laporanMingguan->where('status', 'revisi')->count();

        // Menghitung jumlah peserta bimbingan
        $jumlahPesertaBimbingan = $daftarPeserta->count();

        return view('applications.mbkm.dospem.dashboard', [
            'dataPeserta' => $dataPeserta,
            'jumlahPesertaBimbingan' => $jumlahPesertaBimbingan,
            'statistikLaporan' => [
                'total_harian' => $totalLaporanHarian,
                'validasi_harian' => $validasiLaporanHarian,
                'pending_harian' => $pendingLaporanHarian,
                'revisi_harian' => $revisiLaporanHarian,
                'total_mingguan' => $totalLaporanMingguan,
                'validasi_mingguan' => $validasiLaporanMingguan,
                'pending_mingguan' => $pendingLaporanMingguan,
                'revisi_mingguan' => $revisiLaporanMingguan,
            ],
        ]);
    }

    public function dashboarStaff()
    {
        if (!$this->batchActive) {
            return response()->view('applications.mbkm.error-page.batch-no-active', [
                'message' => 'Tidak ada batch aktif yang sedang berjalan.',
            ], 403);
        }

        $dashboardData = Dashboard::getStaffDashboardData();

        return view('applications.mbkm.staff.dashboard', $dashboardData);
    }

    public function dashboardPeserta(Request $request)
    {
        if (!$this->batchActive) {
            return response()->view('applications.mbkm.error-page.batch-no-active', [
                'message' => 'Tidak ada batch aktif yang sedang berjalan.',
            ], 403);
        }

        $user = Auth::user();
        $peserta = Peserta::with('registrationPlacement')->where('user_id', $user->id)->first();

        if (!$peserta) {
            return response()->view('applications.mbkm.error-page.batch-no-active', [
                'message' => 'Anda tidak terdaftar sebagai peserta.',
            ], 403);
        }

        // Logika untuk mengambil data laporan harian
        $laporanHarian = LaporanHarian::where('peserta_id', $user->peserta->id)->get()->keyBy('tanggal');
        $totalLaporan = $laporanHarian->count();
        $validasiLaporan = $laporanHarian->where('status', 'validasi')->count();
        $revisiLaporan = $laporanHarian->where('status', 'revisi')->count();
        $pendingLaporan = $laporanHarian->where('status', 'pending')->count();

        // Logika untuk mengambil data laporan mingguan
        $laporanMingguan = LaporanMingguan::where('peserta_id', $user->peserta->id)->get()->keyBy('minggu_ke');
        $totalLaporanMingguan = $laporanMingguan->count();
        $validasiLaporanMingguan = $laporanMingguan->where('status', 'validasi')->count();
        $revisiLaporanMingguan = $laporanMingguan->where('status', 'revisi')->count();
        $pendingLaporanMingguan = $laporanMingguan->where('status', 'pending')->count();

        // Logika untuk mengambil data registrasi
        $registrasi = Registrasi::where('peserta_id', $user->peserta->id)->get();
        $totalLowongan = $registrasi->count();
        $lowonganStatus = $registrasi->groupBy('status')->map->count();

        return view('applications.mbkm.peserta.dashboard', compact(
            'totalLaporan',
            'validasiLaporan',
            'revisiLaporan',
            'pendingLaporan',
            'totalLaporanMingguan',
            'validasiLaporanMingguan',
            'revisiLaporanMingguan',
            'pendingLaporanMingguan',
            'totalLowongan',
            'lowonganStatus'
        ));
    }
}
