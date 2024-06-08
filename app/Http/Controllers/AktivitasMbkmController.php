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
        $laporanHarian = LaporanHarian::with(['peserta', 'mitra'])->get();
        $laporanMingguan = LaporanMingguan::with(['peserta', 'mitra'])->get();
        $laporanLengkap = LaporanLengkap::with(['peserta', 'dospem'])->get();

        return view('applications.mbkm.laporan.index', compact('laporanHarian', 'laporanMingguan', 'laporanLengkap'));
    }

    public function createLaporanHarian()
    {
        $user = Auth::user();
        $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

        return view('applications.mbkm.laporan.laporan-harian', compact('aktivitas'));
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

        $user->load([
            'peserta.registrationPlacement.lowongan',
        ]);

        // dd($user->peserta->registrationPlacement);

        // $aktivitas = AktivitasMbkm::find('peserta_id', $user->peserta->id);

        $laporanHarian = LaporanHarian::create([
            'peserta_id' => $user->peserta->id,
            'mitra_id' => $user->peserta->registrationPlacement->lowongan->mitra_id,
            'tanggal' => $request->tanggal,
            'isi_laporan' => $request->isi_laporan,
            'status' => 'pending',
            'kehadiran' => $request->kehadiran,
        ]);

        // $aktivitas->laporan_harian_id = $laporanHarian->id;
        // $aktivitas->save();

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
        $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

        $laporanMingguan = LaporanMingguan::create([
            'peserta_id' => $aktivitas->peserta_id,
            'mitra_id' => $aktivitas->mitra_id,
            'minggu_ke' => $request->minggu_ke,
            'isi_laporan' => $request->isi_laporan,
            'status' => 'pending',
            'kehadiran' => $request->kehadiran,
        ]);

        $aktivitas->laporan_mingguan_id = $laporanMingguan->id;
        $aktivitas->save();

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
        $aktivitas = AktivitasMbkm::where('laporan_harian_id', $id)->firstOrFail();

        if ($aktivitas->mitra->user_id != Auth::id()) {
            return back()->withErrors('Anda tidak memiliki izin untuk memvalidasi laporan ini.');
        }

        $laporanHarian->update(['status' => 'validated']);

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





// namespace App\Http\Controllers;

// use App\Models\AktivitasMbkm;
// use App\Models\LaporanHarian;
// use App\Models\LaporanLengkap;
// use App\Models\LaporanMingguan;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class AktivitasController extends Controller
// {
//     public function index()
//     {
//         $laporanHarian = LaporanHarian::with(['peserta', 'mitra'])->get();
//         $laporanMingguan = LaporanMingguan::with(['peserta', 'mitra'])->get();
//         $laporanLengkap = LaporanLengkap::with(['peserta', 'dospem'])->get();

//         return view('applications.mbkm.laporan.laporan-index', compact('laporanHarian', 'laporanMingguan', 'laporanLengkap'));
//     }

//     public function createLaporanHarian()
//     {
//         $user = Auth::user();
//         $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

//         return view('applications.mbkm.laporan.laporan-harian', compact('aktivitas'));
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

//     public function storeLaporanHarian(Request $request)
//     {
//         $request->validate([
//             'tanggal' => 'required|date',
//             'isi_laporan' => 'required|string',
//             'kehadiran' => 'required|string',
//         ]);

//         $user = Auth::user();
//         $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

//         $laporanHarian = LaporanHarian::create([
//             'peserta_id' => $aktivitas->peserta_id,
//             'mitra_id' => $aktivitas->mitra_id,
//             'tanggal' => $request->tanggal,
//             'isi_laporan' => $request->isi_laporan,
//             'status' => 'pending',
//             'kehadiran' => $request->kehadiran,
//         ]);

//         $aktivitas->laporan_harian_id = $laporanHarian->id;
//         $aktivitas->save();

//         return back()->with('success', 'Laporan harian berhasil disimpan.');
//     }

//     public function storeLaporanMingguan(Request $request)
//     {
//         $request->validate([
//             'minggu_ke' => 'required|integer',
//             'isi_laporan' => 'required|string',
//             'kehadiran' => 'required|string',
//         ]);

//         $user = Auth::user();
//         $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

//         $laporanMingguan = LaporanMingguan::create([
//             'peserta_id' => $aktivitas->peserta_id,
//             'mitra_id' => $aktivitas->mitra_id,
//             'minggu_ke' => $request->minggu_ke,
//             'isi_laporan' => $request->isi_laporan,
//             'status' => 'pending',
//             'kehadiran' => $request->kehadiran,
//         ]);

//         $aktivitas->laporan_mingguan_id = $laporanMingguan->id;
//         $aktivitas->save();

//         return back()->with('success', 'Laporan mingguan berhasil disimpan.');
//     }

//     public function storeLaporanLengkap(Request $request)
//     {
//         $request->validate([
//             'isi_laporan' => 'required|string',
//         ]);

//         $user = Auth::user();
//         $aktivitas = AktivitasMbkm::where('peserta_id', $user->id)->first();

//         $laporanLengkap = LaporanLengkap::create([
//             'peserta_id' => $aktivitas->peserta_id,
//             'dospem_id' => $aktivitas->dospem_id,
//             'isi_laporan' => $request->isi_laporan,
//             'status' => 'pending',
//         ]);

//         $aktivitas->laporan_lengkap_id = $laporanLengkap->id;
//         $aktivitas->save();

//         return back()->with('success', 'Laporan lengkap berhasil disimpan.');
//     }

//     public function validateLaporanHarian(Request $request, $id)
//     {
//         $laporanHarian = LaporanHarian::findOrFail($id);
//         $aktivitas = AktivitasMbkm::where('laporan_harian_id', $id)->firstOrFail();

//         if ($aktivitas->mitra->user_id != Auth::id()) {
//             return back()->withErrors('Anda tidak memiliki izin untuk memvalidasi laporan ini.');
//         }

//         $laporanHarian->update(['status' => 'validated']);

//         return back()->with('success', 'Laporan harian berhasil divalidasi.');
//     }

//     public function validateLaporanMingguan(Request $request, $id)
//     {
//         $laporanMingguan = LaporanMingguan::findOrFail($id);
//         $aktivitas = AktivitasMbkm::where('laporan_mingguan_id', $id)->firstOrFail();

//         if ($aktivitas->mitra->user_id != Auth::id()) {
//             return back()->withErrors('Anda tidak memiliki izin untuk memvalidasi laporan ini.');
//         }

//         $laporanMingguan->update(['status' => 'validated']);

//         return back()->with('success', 'Laporan mingguan berhasil divalidasi.');
//     }

//     public function validateLaporanLengkap(Request $request, $id)
//     {
//         $laporanLengkap = LaporanLengkap::findOrFail($id);
//         $aktivitas = AktivitasMbkm::where('laporan_lengkap_id', $id)->firstOrFail();

//         if ($aktivitas->dospem->user_id != Auth::id()) {
//             return back()->withErrors('Anda tidak memiliki izin untuk memvalidasi laporan ini.');
//         }

//         $laporanLengkap->update(['status' => 'validated']);

//         return back()->with('success', 'Laporan lengkap berhasil divalidasi.');
//     }
// }
