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
    protected $activeBatch;

    public function __construct()
    {
        $this->activeBatch = BatchMbkm::getActiveBatch();
        if (!$this->activeBatch) {
            abort(403, 'Tidak ada batch aktif yang sedang berjalan.');
        }
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('super admin')) {
            return $this->dashboardAdmin();
        } elseif ($user->hasRole('dosen')) {
            return $this->dashboardDosen();
        } elseif ($user->hasRole('peserta')) {
            return $this->dashboardPeserta(app('request'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function dashboardAdmin()
    {
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

    public function dashboardDosen()
    {
        return view('dashboard.dosen');
    }

    public function dashboardPeserta(Request $request)
    {
        $user = Auth::user();
        $peserta = Peserta::with('registrationPlacement')->where('user_id', $user->id)->first();

        if (!$peserta) {
            return response()->view('applications.mbkm.error-page.not-registered', ['message' => 'Anda tidak terdaftar sebagai peserta.'], 403);
        }

        // Logika untuk mengambil data laporan harian
        $namaPeserta = $user->peserta->nama;
        $weekNumber = $request->query('week', null);
        if ($weekNumber !== null) {
            $startOfWeek = \Carbon\Carbon::parse($this->activeBatch->semester_start)->addWeeks($weekNumber - 1)->startOfWeek();
            $endOfWeek = $startOfWeek->copy()->endOfWeek();
        } else {
            $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
            $endOfWeek = \Carbon\Carbon::now()->endOfWeek();
        }
        $currentDate = \Carbon\Carbon::now();
        $laporanHarian = LaporanHarian::where('peserta_id', $user->peserta->id)->get()->keyBy('tanggal');
        $totalLaporan = $laporanHarian->count();
        $validasiLaporan = $laporanHarian->where('status', 'validasi')->count();
        $revisiLaporan = $laporanHarian->where('status', 'revisi')->count();
        $pendingLaporan = $laporanHarian->where('status', 'pending')->count();

        // Logika untuk mengambil data laporan mingguan
        $semesterStart = \Carbon\Carbon::parse($this->activeBatch->semester_start);
        $semesterEnd = \Carbon\Carbon::parse($this->activeBatch->semester_end);
        $currentWeek = $currentDate->diffInWeeks($semesterStart) + 1;
        $totalWeeks = $semesterStart->diffInWeeks($semesterEnd) + 1;
        $laporanHarian = LaporanHarian::where('peserta_id', $user->peserta->id)->get();
        $laporanHarianPerMinggu = $laporanHarian->groupBy(function ($item) use ($semesterStart) {
            return \Carbon\Carbon::parse($item->tanggal)->diffInWeeks($semesterStart) + 1;
        });
        $laporanMingguan = LaporanMingguan::where('peserta_id', $user->peserta->id)->get()->keyBy('minggu_ke');

        $weeks = [];
        for ($i = 0; $i < $totalWeeks; $i++) {
            $startOfWeek = $semesterStart->copy()->addWeeks($i)->startOfWeek();
            $endOfWeek = $startOfWeek->copy()->endOfWeek();
            $isComplete = $laporanHarianPerMinggu->has($i + 1);

            $weeks[$i + 1] = [
                'startOfWeek' => $startOfWeek,
                'endOfWeek' => $endOfWeek,
                'isComplete' => $isComplete,
                'laporanMingguan' => $laporanMingguan->get($i + 1),
                'canFill' => $isComplete,
                'canFillDaily' => !$isComplete,
                'isCurrentOrPastWeek' => $startOfWeek->lte($currentDate) && $endOfWeek->gte($semesterStart),
                'laporanHarian' => $laporanHarianPerMinggu->get($i + 1),
            ];
        }

        // Logika untuk mengambil data lowongan yang didaftarkan
        $registrasi = Registrasi::where('peserta_id', $user->peserta->id)->get();
        $totalLowongan = $registrasi->count();
        $lowonganStatus = $registrasi->groupBy('status')->map->count();

        return view('applications.mbkm.peserta.dashboard', compact(
            'namaPeserta',
            'laporanHarian',
            'totalLaporan',
            'validasiLaporan',
            'revisiLaporan',
            'pendingLaporan',
            'startOfWeek',
            'endOfWeek',
            'currentDate',
            'weeks',
            'currentWeek',
            'totalLaporan',
            'validasiLaporan',
            'revisiLaporan',
            'pendingLaporan',
            'totalLowongan',
            'lowonganStatus'
        ));
    }
}
