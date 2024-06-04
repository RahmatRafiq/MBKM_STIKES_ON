<?php

namespace App\Http\Controllers;

use App\Models\AktivitasMbkm;
use App\Models\DosenPembimbingLapangan;
use App\Models\LaporanHarian;
use App\Models\LaporanMingguan;
use App\Models\LaporanLengkap;
use App\Models\Peserta;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AktivitasController extends Controller
{
    public function index()
    {
        $laporanHarian = LaporanHarian::with(['peserta', 'lowongan', 'mitra'])->get();
        $laporanMingguan = LaporanMingguan::with(['peserta', 'lowongan', 'mitra'])->get();
        $laporanLengkap = LaporanLengkap::with(['peserta', 'lowongan', 'dospem'])->get();

        return view('laporan.index', compact('laporanHarian', 'laporanMingguan', 'laporanLengkap'));
    }

    public function createLaporanHarian()
    {
        $pesertas = Peserta::all();
        $lowongans = Lowongan::all();
        return view('applications.mbkm.laporan.laporan-harian', compact('pesertas', 'lowongans'));
    }

    public function createLaporanMingguan()
    {
        $pesertas = Peserta::all();
        $lowongans = Lowongan::all();
        return view('applications.mbkm.laporan.laporan-mingguan', compact('pesertas', 'lowongans'));
    }

    public function createLaporanLengkap()
    {
        $pesertas = Peserta::all();
        $lowongans = Lowongan::all();
        return view('applications.mbkm.laporan.laporan-lengkap', compact('pesertas', 'lowongans'));
    }

    public function storeLaporanHarian(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
            'lowongan_id' => 'required|exists:lowongan,id',
            'tanggal' => 'required|date',
            'isi_laporan' => 'required|string',
        ]);

        $lowongan = Lowongan::find($request->lowongan_id);
        $mitra = $lowongan->mitra;

        $laporanHarian = LaporanHarian::create([
            'peserta_id' => $request->peserta_id,
            'mitra_id' => $mitra->id,
            'tanggal' => $request->tanggal,
            'isi_laporan' => $request->isi_laporan,
            'status' => 'pending',
        ]);

        AktivitasMbkm::create([
            'peserta_id' => $request->peserta_id,
            'lowongan_id' => $request->lowongan_id,
            'mitra_id' => $mitra->id,
            'dospem_id' => $lowongan->dospem_id,
            'laporan_harian_id' => $laporanHarian->id,
        ]);

        return back()->with('success', 'Laporan harian berhasil disimpan.');
    }

    public function storeLaporanMingguan(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
            'lowongan_id' => 'required|exists:lowongan,id',
            'minggu_ke' => 'required|integer',
            'isi_laporan' => 'required|string',
        ]);

        $lowongan = Lowongan::find($request->lowongan_id);
        $mitra = $lowongan->mitra;

        $laporanMingguan = LaporanMingguan::create([
            'peserta_id' => $request->peserta_id,
            'mitra_id' => $mitra->id,
            'minggu_ke' => $request->minggu_ke,
            'isi_laporan' => $request->isi_laporan,
            'status' => 'pending',
        ]);

        AktivitasMbkm::create([
            'peserta_id' => $request->peserta_id,
            'lowongan_id' => $request->lowongan_id,
            'mitra_id' => $mitra->id,
            'dospem_id' => $lowongan->dospem_id,
            'laporan_mingguan_id' => $laporanMingguan->id,
        ]);

        return back()->with('success', 'Laporan mingguan berhasil disimpan.');
    }

    public function storeLaporanLengkap(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
            'lowongan_id' => 'required|exists:lowongan,id',
            'isi_laporan' => 'required|string',
        ]);

        $lowongan = Lowongan::find($request->lowongan_id);
        $dospem = DosenPembimbingLapangan::find($lowongan->dospem_id);

        $laporanLengkap = LaporanLengkap::create([
            'peserta_id' => $request->peserta_id,
            'dospem_id' => $dospem->id,
            'isi_laporan' => $request->isi_laporan,
            'status' => 'pending',
        ]);

        AktivitasMbkm::create([
            'peserta_id' => $request->peserta_id,
            'lowongan_id' => $request->lowongan_id,
            'mitra_id' => $lowongan->mitra_id,
            'dospem_id' => $dospem->id,
            'laporan_lengkap_id' => $laporanLengkap->id,
        ]);

        return back()->with('success', 'Laporan lengkap berhasil disimpan.');
    }

    public function validateLaporanHarian(Request $request, $id)
    {
        $aktifitas = AktivitasMbkm::where('laporan_harian_id', $id)->firstOrFail();
        if ($aktifitas->mitra->user_id != Auth::id()) {
            return back()->withErrors('Anda tidak memiliki izin untuk memvalidasi laporan ini.');
        }

        $laporanHarian = LaporanHarian::findOrFail($id);
        $laporanHarian->update(['status' => 'validated']);

        return back()->with('success', 'Laporan harian berhasil divalidasi.');
    }

    public function validateLaporanMingguan(Request $request, $id)
    {
        $aktifitas = AktivitasMbkm::where('laporan_mingguan_id', $id)->firstOrFail();
        if ($aktifitas->mitra->user_id != Auth::id()) {
            return back()->withErrors('Anda tidak memiliki izin untuk memvalidasi laporan ini.');
        }

        $laporanMingguan = LaporanMingguan::findOrFail($id);
        $laporanMingguan->update(['status' => 'validated']);

        return back()->with('success', 'Laporan mingguan berhasil divalidasi.');
    }

    public function validateLaporanLengkap(Request $request, $id)
    {
        $aktifitas = AktivitasMbkm::where('laporan_lengkap_id', $id)->firstOrFail();
        if ($aktifitas->dospem->user_id != Auth::id()) {
            return back()->withErrors('Anda tidak memiliki izin untuk memvalidasi laporan ini.');
        }

        $laporanLengkap = LaporanLengkap::findOrFail($id);
        $laporanLengkap->update(['status' => 'validated']);

        return back()->with('success', 'Laporan lengkap berhasil divalidasi.');
    }
}
