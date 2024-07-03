<?php

namespace App\Http\Controllers;


use App\Models\Dashboard;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('super admin')) {
            return $this->dashboardAdmin();
        } elseif ($user->hasRole('dosen')) {
            return $this->dashboardDosen();
        } elseif ($user->hasRole('peserta')) {
            return $this->dashboardPeserta();
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
    public function dashboardAdmin()
    {
        // Mengambil counts dari model Dashboard dan LaporanHarian
        $counts = Dashboard::getCounts();
        $laporanHarianCounts = Dashboard::getLaporanHarianStatusCounts();
        $laporanMingguanCounts = Dashboard::getLaporanMingguanStatusCounts();
        // dd([
        //     'counts' => $counts,
        //     'laporanHarianCounts' => $laporanHarianCounts,
        // ]);

        // Mengirimkan data ke view 'applications.mbkm.admin.dashboard'
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

    public function dashboardDosen()
    {
        // Logika untuk dashboard dosen
        // Ambil data yang diperlukan untuk dosen
        return view('dashboard.dosen');
    }

    public function dashboardPeserta()
    {
        // Logika untuk dashboard peserta
        // Ambil data yang diperlukan untuk peserta
        return view('dashboard.peserta');
    }
}
