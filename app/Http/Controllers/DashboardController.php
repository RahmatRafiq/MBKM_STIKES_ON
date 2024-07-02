<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\LaporanHarian;

class DashboardController extends Controller
{
    public function dashboardAdmin()
    {
        // Mengambil counts dari model Dashboard dan LaporanHarian
        $counts = Dashboard::getCounts();
        $laporanHarianCounts = Dashboard::getLaporanHarianStatusCounts();
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
        ]);
    }
}
