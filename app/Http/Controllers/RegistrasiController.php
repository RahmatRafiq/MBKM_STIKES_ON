<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use App\Models\Lowongan;
use App\Models\DosenPembimbingLapangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrasiController extends Controller
{
    // Method untuk menampilkan halaman registrasi peserta
    public function showPesertaRegistrasiForm()
    {
        // Mengambil semua lowongan yang tersedia
        $lowongans = Lowongan::all();
        // dd(auth()->user());
        return view('applications/mbkm/staff/registrasi-program/peserta.registrasi', compact('lowongans'));
   
    }

    // Method untuk menampilkan halaman registrasi staff
    public function index()
    {
        // Mengambil semua data registrasi dengan relasi peserta dan lowongan
        $registrations = Registrasi::with(['peserta', 'lowongan'])->get();
        // Mengambil semua data dosen pembimbing lapangan
        $dospems = DosenPembimbingLapangan::all();
        return view('applications/mbkm/staff/registrasi-program/staff.registrasi', compact('registrations', 'dospems'));
    }

    // Method untuk mendaftarkan peserta pada lowongan
    public function store(Request $request)
    {
        // Validasi input dari request
        $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
            'lowongan_id' => 'required|exists:lowongans,id',
        ]);

        $pesertaId = $request->input('peserta_id');
        $lowonganId = $request->input('lowongan_id');

        // Mengambil data lowongan berdasarkan ID
        $lowongan = Lowongan::find($lowonganId);
        $mitraType = $lowongan->mitra->type;

        // Cek apakah peserta sudah mendaftar pada lowongan dari tipe mitra yang sama
        $existingRegistration = Registrasi::where('peserta_id', $pesertaId)
            ->whereHas('lowongan.mitra', function($query) use ($mitraType) {
                $query->where('type', $mitraType);
            })
            ->first();

        if ($existingRegistration) {
            return back()->with('error', 'Peserta sudah mendaftar pada lowongan dari tipe mitra yang sama.');
        }

        // Membuat registrasi baru
        Registrasi::create([
            'peserta_id' => $pesertaId,
            'lowongan_id' => $lowonganId,
            'status' => 'registered',
        ]);

        return back()->with('success', 'Pendaftaran berhasil.');
    }

    // Method untuk mengubah status registrasi
    public function update(Request $request, $id)
    {
        // Validasi input dari request
        $request->validate([
            'status' => 'required|in:registered,processed,accepted,rejected',
            'dospem_id' => 'sometimes|exists:dosen_pembimbing_lapangan,id',
        ]);

        // Mengambil data registrasi berdasarkan ID
        $registration = Registrasi::find($id);
        $registration->status = $request->input('status');

        // Jika status diterima dan dosen pembimbing ID disediakan, tambahkan dosen pembimbing
        if ($request->input('status') == 'accepted' && $request->input('dospem_id')) {
            $registration->dospem_id = $request->input('dospem_id');
        }

        $registration->save();

        // Jika status diterima, tolak semua registrasi lain dari peserta yang sama
        if ($request->input('status') == 'accepted') {
            Registrasi::where('peserta_id', $registration->peserta_id)
                        ->where('lowongan_id', '!=', $registration->lowongan_id)
                        ->update(['status' => 'rejected']);
        }

        return back()->with('success', 'Status registrasi berhasil diupdate.');
    }

    // Method untuk peserta mengambil tawaran yang diterima
    public function acceptOffer(Request $request, $id)
    {
        // Validasi input dari request
        $request->validate([
            'dospem_id' => 'required|exists:dosen_pembimbing_lapangan,id',
        ]);

        // Mengambil data registrasi berdasarkan ID
        $registration = Registrasi::find($id);

        // Cek jika status registrasi adalah accepted
        if ($registration->status != 'accepted') {
            return back()->with('error', 'Tawaran hanya dapat diambil jika diterima.');
        }

        // Menetapkan dosen pembimbing
        $registration->dospem_id = $request->input('dospem_id');
        $registration->save();

        return back()->with('success', 'Tawaran berhasil diambil dan dosen pembimbing telah ditetapkan.');
    }
}
