<?php

namespace App\Http\Controllers;

use App\Models\BatchMbkm;
use App\Models\Dashboard;
use App\Models\LaporanHarian;
use App\Models\LaporanMingguan;
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
        $batchId = $this->activeBatch->id;

        if ($user->hasRole('super admin')) {
            return $this->dashboardAdmin();
        } elseif ($user->hasRole('mitra')) {
            return $this->dashboardMitra($batchId);
        } elseif ($user->hasRole('dosen')) {
            return $this->dashboardDospem($batchId);
        } elseif ($user->hasRole('staff')) {
            return $this->dashboardStaff($batchId);
        } elseif ($user->hasRole('peserta')) {
            return $this->dashboardPeserta(app('request'), $batchId);
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

        $counts = Dashboard::getCounts($this->activeBatch->id);
        $laporanHarianCounts = Dashboard::getLaporanHarianStatusCounts($this->activeBatch->id);
        $laporanMingguanCounts = Dashboard::getLaporanMingguanStatusCounts($this->activeBatch->id);

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

    public function dashboardMitra($batchId)
    {
        if (!$this->batchActive) {
            return response()->view('applications.mbkm.error-page.batch-no-active', [
                'message' => 'Tidak ada batch aktif yang sedang berjalan.',
            ], 403);
        }

        $user = Auth::user();
        $data = Dashboard::getMitraDashboardData($user, $batchId);

        return view('applications.mbkm.mitra.dashboard', $data);
    }

    public function dashboardDospem($batchId)
    {
        if (!$this->batchActive) {
            return response()->view('applications.mbkm.error-page.batch-no-active', [
                'message' => 'Tidak ada batch aktif yang sedang berjalan.',
            ], 403);
        }

        $user = Auth::user();
        $data = Dashboard::getDospemDashboardData($user, $batchId);

        return view('applications.mbkm.dospem.dashboard', $data);
    }

    public function dashboardStaff($batchId)
    {
        if (!$this->batchActive) {
            return response()->view('applications.mbkm.error-page.batch-no-active', [
                'message' => 'Tidak ada batch aktif yang sedang berjalan.',
            ], 403);
        }
    
        $dashboardData = Dashboard::getStaffDashboardData($batchId);
    
        return view('applications.mbkm.staff.dashboard', $dashboardData);
    }
    

    public function dashboardPeserta(Request $request, $batchId)
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

        $laporanHarian = LaporanHarian::whereHas('peserta.registrationPlacement', function ($query) use ($batchId) {
            $query->where('batch_id', $batchId);
        })->where('peserta_id', $peserta->id)->get()->keyBy('tanggal');

        $totalLaporan = $laporanHarian->count();
        $validasiLaporan = $laporanHarian->where('status', 'validasi')->count();
        $revisiLaporan = $laporanHarian->where('status', 'revisi')->count();
        $pendingLaporan = $laporanHarian->where('status', 'pending')->count();

        $laporanMingguan = LaporanMingguan::whereHas('peserta.registrationPlacement', function ($query) use ($batchId) {
            $query->where('batch_id', $batchId);
        })->where('peserta_id', $peserta->id)->get()->keyBy('minggu_ke');

        $totalLaporanMingguan = $laporanMingguan->count();
        $validasiLaporanMingguan = $laporanMingguan->where('status', 'validasi')->count();
        $revisiLaporanMingguan = $laporanMingguan->where('status', 'revisi')->count();
        $pendingLaporanMingguan = $laporanMingguan->where('status', 'pending')->count();

        $registrasi = Registrasi::where('peserta_id', $peserta->id)->where('batch_id', $batchId)->get();
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
