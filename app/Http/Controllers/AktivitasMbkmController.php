<?php
namespace App\Http\Controllers;

use App\Models\AktivitasMbkm;
use App\Models\LaporanHarian;
use App\Models\LaporanLengkap;
use App\Models\LaporanMingguan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AktivitasMbkmController extends Controller
{
//     public function index(Request $request)
// {
//     $user = Auth::user();
//     $pesertaId = $request->input('peserta_id');

//     // Mengambil daftar peserta berdasarkan kriteria yang sudah ditentukan
//     $daftarPeserta = Peserta::whereHas('registrationPlacement.lowongan.mitra', function ($query) use ($user) {
//         $query->where('user_id', $user->id);
//     })->get();

//     // Mengambil data laporan berdasarkan peserta yang dipilih
//     $laporanHarian = $pesertaId ? LaporanHarian::getByUser($user, $pesertaId) : collect();
//     $laporanMingguan = $pesertaId ? LaporanMingguan::getByUser($user, $pesertaId) : collect();
//     $laporanLengkap = $pesertaId ? LaporanLengkap::getByUser($user, $pesertaId) : collect();

//     return view('applications.mbkm.laporan.index', compact('daftarPeserta', 'laporanHarian', 'laporanMingguan', 'laporanLengkap', 'pesertaId'));
// }

//     public function createLaporanHarian()
//     {
//         $user = Auth::user();
//         $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

//         $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
//         $endOfWeek = \Carbon\Carbon::now()->endOfWeek();

//         $laporanHarian = LaporanHarian::where('peserta_id', $user->peserta->id)
//             ->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
//             ->get()
//             ->keyBy('tanggal');

//         return view('applications.mbkm.laporan.laporan-harian', compact('aktivitas', 'laporanHarian'));
//     }

//     public function createLaporanMingguan()
//     {
//         $user = Auth::user();
//         $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

//         return view('applications.mbkm.laporan.laporan-mingguan', compact('aktivitas'));
//     }

//     public function createLaporanLengkap()
//     {
//         $user = Auth::user();
//         $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

//         return view('applications.mbkm.laporan.laporan-lengkap', compact('aktivitas'));
//     }

    public function index(Request $request)
    {
        $user = Auth::user();
        $pesertaId = $request->input('peserta_id');

        // Mengambil daftar peserta berdasarkan kriteria yang sudah ditentukan
        $daftarPeserta = Peserta::whereHas('registrationPlacement.lowongan.mitra', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        // Mengambil data laporan berdasarkan peserta yang dipilih
        $laporanHarian = $pesertaId ? LaporanHarian::getByUser($user, $pesertaId) : collect();
        $laporanMingguan = $pesertaId ? LaporanMingguan::getByUser($user, $pesertaId) : collect();
        $laporanLengkap = $pesertaId ? LaporanLengkap::getByUser($user, $pesertaId) : collect();

        return view('applications.mbkm.laporan.index', compact('daftarPeserta', 'laporanHarian', 'laporanMingguan', 'laporanLengkap', 'pesertaId'));
    }

    public function createLaporanHarian()
    {
        $user = Auth::user();
        $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

        $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
        $endOfWeek = \Carbon\Carbon::now()->endOfWeek();

        $laporanHarian = LaporanHarian::where('peserta_id', $user->peserta->id)
            ->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
            ->get()
            ->keyBy('tanggal');

        return view('applications.mbkm.laporan.laporan-harian', compact('aktivitas', 'laporanHarian'));
    }

    public function createLaporanMingguan()
    {
        $user = Auth::user();
        $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

        $semesterStart = \Carbon\Carbon::parse(env('SEMESTER_START'));
        $semesterEnd = \Carbon\Carbon::parse(env('SEMESTER_END'));
        $currentWeek = \Carbon\Carbon::now()->diffInWeeks($semesterStart) + 1;
        $totalWeeks = $semesterStart->diffInWeeks($semesterEnd) + 1;

        $weeks = [];
        for ($i = 0; $i < $totalWeeks; $i++) {
            $startOfWeek = $semesterStart->copy()->addWeeks($i)->startOfWeek();
            $endOfWeek = $startOfWeek->copy()->endOfWeek();
            $isComplete = AktivitasMbkm::isWorkWeekReportComplete($user->peserta->id, $startOfWeek, $endOfWeek);
            $laporanMingguan = LaporanMingguan::where('peserta_id', $user->peserta->id)
                ->where('minggu_ke', $i + 1)
                ->first();

            $weeks[$i + 1] = [
                'startOfWeek' => $startOfWeek,
                'endOfWeek' => $endOfWeek,
                'isComplete' => $isComplete,
                'laporanMingguan' => $laporanMingguan,
            ];
        }

        return view('applications.mbkm.laporan.laporan-mingguan', compact('aktivitas', 'weeks', 'currentWeek'));
    }

    public function createLaporanLengkap()
    {
        $user = Auth::user();
        $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

        return view('applications.mbkm.laporan.laporan-lengkap', compact('aktivitas'));
    }

    public function storeLaporanHarian(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'isi_laporan' => 'required|string',
            'kehadiran' => 'required|string',
        ]);

        $user = Auth::user();

        $semesterStart = env('SEMESTER_START');
        $semesterEnd = env('SEMESTER_END');

        $user->load([
            'peserta.registrationPlacement.lowongan',
        ]);

        $laporanHarian = LaporanHarian::create([
            'peserta_id' => $user->peserta->id,
            'mitra_id' => $user->peserta->registrationPlacement->lowongan->mitra_id,
            'tanggal' => $request->tanggal,
            'isi_laporan' => $request->isi_laporan,
            'status' => 'pending',
            'kehadiran' => $request->kehadiran,
        ]);

        return back()->with('success', 'Laporan harian berhasil disimpan.');
    }

    public function storeLaporanMingguan(Request $request)
    {
        $request->validate([
            'minggu_ke' => 'required|integer',
            'isi_laporan' => 'required|string',
            'kehadiran' => 'required|string',
        ]);

        $user = Auth::user();

        $semesterStart = env('SEMESTER_START');
        $semesterEnd = env('SEMESTER_END');

        $user->load([
            'peserta.registrationPlacement.lowongan',
        ]);

        $laporanMingguan = LaporanMingguan::create([
            'peserta_id' => $user->peserta->id,
            'mitra_id' => $user->peserta->registrationPlacement->lowongan->mitra_id,
            'minggu_ke' => $request->minggu_ke,
            'isi_laporan' => $request->isi_laporan,
            'status' => 'pending',
            'kehadiran' => $request->kehadiran,
        ]);

        return back()->with('success', 'Laporan mingguan berhasil disimpan.');
    }

    public function storeLaporanLengkap(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date', // Tambahkan validasi 'tanggal
            'isi_laporan' => 'required|string',

        ]);

        $user = Auth::user();
        $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

        $laporanLengkap = LaporanLengkap::create([
            'peserta_id' => $aktivitas->peserta_id,
            'mitra_id' => $aktivitas->mitra_id,
            'tanggal' => $request->tanggal,
            'isi_laporan' => $request->isi_laporan,
            'status' => 'pending',
        ]);

        $aktivitas->laporan_lengkap_id = $laporanLengkap->id;
        $aktivitas->save();

        return back()->with('success', 'Laporan lengkap berhasil disimpan.');
    }

    public function validateLaporanHarian(Request $request, $id)
    {
        $laporanHarian = LaporanHarian::findOrFail($id);

        if ($laporanHarian->mitra->user_id != Auth::id()) {
            return back()->withErrors('Anda tidak memiliki izin untuk memvalidasi laporan ini.');
        }

        if ($request->action == 'validasi') {
            $laporanHarian->update(['status' => 'validasi']);
            return back()->with('success', 'Laporan harian berhasil divalidasi.');
        } elseif ($request->action == 'revisi') {
            $laporanHarian->update(['status' => 'revisi']);
            return back()->with('success', 'Laporan harian berhasil direvisi.');
        }

        return back()->with('success', 'Laporan harian berhasil divalidasi.');
    }

    public function validateLaporanMingguan(Request $request, $id)
    {
        $laporanMingguan = LaporanMingguan::findOrFail($id);
        $aktivitas = AktivitasMbkm::where('laporan_mingguan_id', $id)->firstOrFail();

        if ($aktivitas->mitra->user_id != Auth::id()) {
            return back()->withErrors('Anda tidak memiliki izin untuk memvalidasi laporan ini.');
        }

        $laporanMingguan->update(['status' => 'validated']);

        return back()->with('success', 'Laporan mingguan berhasil divalidasi.');
    }

    public function validateLaporanLengkap(Request $request, $id)
    {
        $laporanLengkap = LaporanLengkap::findOrFail($id);
        $aktivitas = AktivitasMbkm::where('laporan_lengkap_id', $id)->firstOrFail();

        if ($aktivitas->dospem->user_id != Auth::id()) {
            return back()->withErrors('Anda tidak memiliki izin untuk memvalidasi laporan ini.');
        }

        $laporanLengkap->update(['status' => 'validated']);

        return back()->with('success', 'Laporan lengkap berhasil divalidasi.');
    }
}
