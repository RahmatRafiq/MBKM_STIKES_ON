<?php
namespace App\Http\Controllers;

use App\Models\AktivitasMbkm;
use App\Models\LaporanHarian;
use App\Models\LaporanLengkap;
use App\Models\LaporanMingguan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AktivitasMbkmController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Mengambil data laporan harian, mingguan, dan lengkap dari model masing-masing
        $laporanHarian = LaporanHarian::getByUser($user);
        $laporanMingguan = LaporanMingguan::getByUser($user);
        $laporanLengkap = LaporanLengkap::getByUser($user);

        return view('applications.mbkm.laporan.index', compact('laporanHarian', 'laporanMingguan', 'laporanLengkap'));
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

        return view('applications.mbkm.laporan.laporan-mingguan', compact('aktivitas'));
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

        $user->load(['peserta.registrationPlacement.lowongan']);

        // Menggunakan updateOrCreate untuk memperbarui data yang ada atau membuat baru jika tidak ada
        $laporanHarian = LaporanHarian::updateOrCreate(
            [
                'peserta_id' => $user->peserta->id,
                'mitra_id' => $user->peserta->registrationPlacement->lowongan->mitra_id,
                'tanggal' => $request->tanggal,
            ],
            [
                'isi_laporan' => $request->isi_laporan,
                'status' => 'pending',
                'kehadiran' => $request->kehadiran,
            ]
        );

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

        $user->load(['peserta.registrationPlacement.lowongan']);

        // Menggunakan updateOrCreate untuk memperbarui data yang ada atau membuat baru jika tidak ada
        $laporanMingguan = LaporanMingguan::updateOrCreate(
            [
                'peserta_id' => $user->peserta->id,
                'mitra_id' => $user->peserta->registrationPlacement->lowongan->mitra_id,
                'minggu_ke' => $request->minggu_ke,
            ],
            [
                'isi_laporan' => $request->isi_laporan,
                'status' => 'pending',
                'kehadiran' => $request->kehadiran,
            ]
        );

        return back()->with('success', 'Laporan mingguan berhasil disimpan.');
    }
    public function storeLaporanLengkap(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'isi_laporan' => 'required|string',
        ]);

        $user = Auth::user();
        $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

        // Menggunakan updateOrCreate untuk memperbarui data yang ada atau membuat baru jika tidak ada
        $laporanLengkap = LaporanLengkap::updateOrCreate(
            [
                'peserta_id' => $aktivitas->peserta_id,
                'mitra_id' => $aktivitas->mitra_id,
                'tanggal' => $request->tanggal,
            ],
            [
                'isi_laporan' => $request->isi_laporan,
                'status' => 'pending',
            ]
        );

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

        if ($laporanMingguan->mitra->user_id != Auth::id()) {
            return back()->withErrors('Anda tidak memiliki izin untuk memvalidasi laporan ini.');
        }

        if ($request->action == 'validasi') {
            $laporanMingguan->update(['status' => 'validasi']);
            return back()->with('success', 'Laporan mingguan berhasil divalidasi.');
        } elseif ($request->action == 'revisi') {
            $laporanMingguan->update(['status' => 'revisi']);
            return back()->with('success', 'Laporan mingguan berhasil direvisi.');
        }

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
