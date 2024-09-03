<?php

namespace App\Http\Controllers;

use App\Models\AktivitasMbkm;
use App\Models\BatchMbkm;
use App\Models\LaporanHarian;
use App\Models\LaporanLengkap;
use App\Models\LaporanMingguan;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AktivitasMbkmController extends Controller
{
    private $activeBatch;

    public function __construct()
    {
        $this->activeBatch = BatchMbkm::getActiveBatch();
        if (!$this->activeBatch) {
            abort(403, 'Tidak ada batch aktif yang sedang berjalan.');
        }
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $pesertaId = $request->input('peserta_id');
        $batchId = $this->activeBatch->id;

        // Eager load the relationships to avoid N+1 problem
        $daftarPeserta = Peserta::with(['registrationPlacement.lowongan.mitra', 'registrationPlacement.dospem'])
            ->whereHas('registrationPlacement.lowongan.mitra', function ($query) use ($user, $batchId) {
                $query->where('user_id', $user->id)->where('batch_id', $batchId);
            })->orWhereHas('registrationPlacement.dospem', function ($query) use ($user, $batchId) {
            $query->where('user_id', $user->id)->where('batch_id', $batchId);
        })->get();

        // Retrieve the reports only if pesertaId is provided
        $laporanHarian = $pesertaId ? LaporanHarian::getByUser($user, $pesertaId, $batchId) : collect();
        $laporanMingguan = $pesertaId ? LaporanMingguan::getByUser($user, $pesertaId, $batchId) : collect();
        $laporanLengkap = $pesertaId ? LaporanLengkap::getByUser($user, $pesertaId, $batchId) : collect();

        return view('applications.mbkm.laporan.index', compact('daftarPeserta', 'laporanHarian', 'laporanMingguan', 'laporanLengkap', 'pesertaId'));
    }

    public function createLaporanHarian(Request $request)
    {
        $user = Auth::user();
        $peserta = Peserta::with('registrationPlacement')->where('user_id', $user->id)->first();

        if (!$peserta || !$peserta->registrationPlacement || $peserta->registrationPlacement->batch_id != $this->activeBatch->id) {
            return response()->view('applications.mbkm.error-page.not-registered', ['message' => 'Anda tidak terdaftar dalam kegiatan MBKM apapun untuk batch ini.'], 403);
        }

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

        return view('applications.mbkm.laporan.laporan-harian', compact(
            'namaPeserta',
            'laporanHarian',
            'totalLaporan',
            'validasiLaporan',
            'revisiLaporan',
            'pendingLaporan',
            'startOfWeek',
            'endOfWeek',
            'currentDate'
        ));
    }

    public function createLaporanMingguan()
    {
        $user = Auth::user();
        $peserta = Peserta::with('registrationPlacement')->where('user_id', $user->id)->first();

        if (!$peserta || !$peserta->registrationPlacement || $peserta->registrationPlacement->batch_id != $this->activeBatch->id) {
            return response()->view('applications.mbkm.error-page.not-registered', ['message' => 'Anda tidak terdaftar dalam kegiatan MBKM apapun untuk batch ini.'], 403);
        }

        $namaPeserta = $user->peserta->nama;
        $semesterStart = \Carbon\Carbon::parse($this->activeBatch->semester_start)->startOfWeek();
        $semesterEnd = \Carbon\Carbon::parse($this->activeBatch->semester_end)->endOfWeek();
        $currentDate = \Carbon\Carbon::now();
        $currentWeek = $currentDate->diffInWeeks($semesterStart) + 1;
        $totalWeeks = $semesterStart->diffInWeeks($semesterEnd) + 1;

        $laporanHarian = LaporanHarian::where('peserta_id', $user->peserta->id)->get();
        $laporanHarian = $laporanHarian->map(function ($item) use ($semesterStart) {
            $tanggal = \Carbon\Carbon::parse($item->tanggal)->startOfWeek();
            $diffWeeks = $semesterStart->diffInWeeks($tanggal->startOfWeek()) + 1;
            $isRevisi = $item->status === 'revisi';
            return array_merge($item->toArray(), [
                'minggu_ke' => $diffWeeks,
                'is_revisi' => $isRevisi,
            ]);
        });

        $laporanHarianPerMinggu = $laporanHarian->groupBy('minggu_ke');
        $totalLaporan = $laporanHarian->count();
        $validasiLaporan = $laporanHarian->where('status', 'validasi')->count();
        $revisiLaporan = $laporanHarian->where('status', 'revisi')->count();
        $pendingLaporan = $laporanHarian->where('status', 'pending')->count();
        $laporanMingguan = LaporanMingguan::where('peserta_id', $user->peserta->id)->get()->keyBy('minggu_ke');

        $weeks = [];
        for ($i = 0; $i < $totalWeeks; $i++) {
            $startOfWeek = $semesterStart->copy()->addWeeks($i)->startOfWeek();
            $endOfWeek = $startOfWeek->copy()->endOfWeek();
            $laporanHarianMingguIni = $laporanHarianPerMinggu->get($i + 1);
            $isComplete = $laporanHarianMingguIni && $laporanHarianMingguIni->count() >= 5;
            $hasRevisi = $laporanHarianMingguIni && $laporanHarianMingguIni->contains('is_revisi', true);

            $weeks[$i + 1] = [
                'startOfWeek' => $startOfWeek,
                'endOfWeek' => $endOfWeek,
                'isComplete' => $isComplete,
                'laporanMingguan' => $laporanMingguan->get($i + 1),
                'canFill' => $isComplete,
                'canFillDaily' => !$isComplete,
                'isCurrentOrPastWeek' => $startOfWeek->lte($currentDate) && $endOfWeek->gte($semesterStart),
                'laporanHarian' => $laporanHarianMingguIni,
                'hasRevisi' => $hasRevisi,
            ];
        }

        $totalLaporanMingguan = $laporanMingguan->count();
        $validasiLaporanMingguan = $laporanMingguan->where('status', 'validasi')->count();
        $revisiLaporanMingguan = $laporanMingguan->where('status', 'revisi')->count();
        $pendingLaporanMingguan = $laporanMingguan->where('status', 'pending')->count();

        return view('applications.mbkm.laporan.laporan-mingguan', compact(
            'namaPeserta',
            'weeks',
            'currentWeek',
            'totalLaporan',
            'validasiLaporan',
            'revisiLaporan',
            'pendingLaporan',
            'totalLaporanMingguan',
            'validasiLaporanMingguan',
            'revisiLaporanMingguan',
            'pendingLaporanMingguan',
        ));
    }

    public function createLaporanLengkap()
    {
        $user = Auth::user();
        $peserta = Peserta::with('registrationPlacement')->where('user_id', $user->id)->first();
    
        if (!$peserta || !$peserta->registrationPlacement || $peserta->registrationPlacement->batch_id != $this->activeBatch->id) {
            return response()->view('applications.mbkm.error-page.not-registered', ['message' => 'Anda tidak terdaftar dalam kegiatan MBKM apapun untuk batch ini.'], 403);
        }
    
        // Cari laporan lengkap berdasarkan peserta_id
        $laporanLengkap = LaporanLengkap::where('peserta_id', $user->peserta->id)->first();
        $laporanLengkapValid = $laporanLengkap->status === 'validasi';

        // Dump hasil pencarian untuk debugging
        // dd($laporanLengkap, $laporanLengkapValid);
    
        // Jika `laporanLengkap` ditemukan, lanjutkan dengan view
        return view('applications.mbkm.laporan.laporan-lengkap', compact('laporanLengkap'));
    }
    

    public function storeLaporanHarian(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'isi_laporan' => 'required|string',
            'kehadiran' => 'required|string',
        ]);

        $user = Auth::user();

        $user->load(['peserta.registrationPlacement.lowongan']);

        $laporanHarian = LaporanHarian::updateOrCreate(
            [
                'peserta_id' => $user->peserta->id,
                'mitra_id' => $user->peserta->registrationPlacement->lowongan->mitra_id,
                'dospem_id' => $user->peserta->registrationPlacement->dospem_id,
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

        $user->load(['peserta.registrationPlacement.lowongan']);

        $laporanMingguan = LaporanMingguan::updateOrCreate(
            [
                'peserta_id' => $user->peserta->id,
                'mitra_id' => $user->peserta->registrationPlacement->lowongan->mitra_id,
                'dospem_id' => $user->peserta->registrationPlacement->dospem_id,
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
            'isi_laporan' => 'required|string',
            'dokumen' => 'required|file|mimes:pdf,doc,docx', // Validasi dokumen sebagai wajib
        ]);
    
        $user = Auth::user();
        $laporanLengkap = LaporanLengkap::updateOrCreate(
            [
                'peserta_id' => $user->peserta->id,
                'mitra_id' => $user->peserta->registrationPlacement->lowongan->mitra_id,
                'dospem_id' => $user->peserta->registrationPlacement->dospem_id,
            ],
            [
                'isi_laporan' => $request->isi_laporan,
                'status' => 'pending',
            ]
        );
    
        // Perbarui dokumen di media collection 'laporan-lengkap'
        if ($request->hasFile('dokumen')) {
            // Hapus dokumen lama jika ada
            if ($laporanLengkap->getFirstMedia('laporan-lengkap')) {
                $laporanLengkap->clearMediaCollection('laporan-lengkap');
            }
            // Tambahkan dokumen baru
            $laporanLengkap->addMedia($request->file('dokumen'))
                ->toMediaCollection('laporan-lengkap', 'laporan-lengkap');
        }
    
        return back()->with('success', 'Laporan lengkap berhasil disimpan.');
    }
    

    public function validateLaporanHarian(Request $request, $id)
    {
        $laporanHarian = LaporanHarian::where('id', $id)
            ->whereHas('peserta.registrationPlacement', function ($query) {
                $query->where('batch_id', $this->activeBatch->id);
            })
            ->firstOrFail();

        if ($laporanHarian->mitra->user_id != Auth::id() && $laporanHarian->dospem->user_id != Auth::id()) {
            return response()->json(['errors' => 'Anda tidak memiliki izin untuk memvalidasi laporan ini.'], 403);
        }

        if ($request->action == 'validasi') {
            $laporanHarian->status = 'validasi';
        } elseif ($request->action == 'revisi') {
            $laporanHarian->status = 'revisi';
            $laporanHarian->feedback = $request->feedback; // Menyimpan feedback
        }

        $laporanHarian->save();

        return response()->json(['success' => 'Laporan harian berhasil diperbarui.']);
    }

    public function validateLaporanMingguan(Request $request, $id)
    {
        $laporanMingguan = LaporanMingguan::where('id', $id)
            ->whereHas('peserta.registrationPlacement', function ($query) {
                $query->where('batch_id', $this->activeBatch->id);
            })
            ->firstOrFail();

        if ($laporanMingguan->mitra->user_id != Auth::id() && $laporanMingguan->dospem->user_id != Auth::id()) {
            return response()->json(['errors' => 'Anda tidak memiliki izin untuk memvalidasi laporan ini.'], 403);
        }

        if ($request->action == 'validasi') {
            $laporanMingguan->status = 'validasi';
        } elseif ($request->action == 'revisi') {
            $laporanMingguan->status = 'revisi';
            $laporanMingguan->feedback = $request->feedback; // Menyimpan feedback
        }

        $laporanMingguan->save();

        return response()->json(['success' => 'Laporan mingguan berhasil diperbarui.']);
    }

    public function validateLaporanLengkap(Request $request, $id)
    {
        $laporanLengkap = LaporanLengkap::where('id', $id)
            ->whereHas('peserta.registrationPlacement', function ($query) {
                $query->where('batch_id', $this->activeBatch->id);
            })
            ->firstOrFail();

        if ($laporanLengkap->mitra->user_id != Auth::id() && $laporanLengkap->dospem->user_id != Auth::id()) {
            return response()->json(['errors' => 'Anda tidak memiliki izin untuk memvalidasi laporan ini.'], 403);
        }

        if ($request->action == 'validasi') {
            $laporanLengkap->status = 'validasi';
        } elseif ($request->action == 'revisi') {
            $laporanLengkap->status = 'revisi';
            $laporanLengkap->feedback = $request->feedback; // Menyimpan feedback
        }

        $laporanLengkap->save();

        return response()->json(['success' => 'Laporan lengkap berhasil diperbarui.']);
    }

}
