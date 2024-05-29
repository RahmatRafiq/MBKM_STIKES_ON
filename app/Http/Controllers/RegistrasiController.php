<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use App\Models\Lowongan;
use App\Models\Peserta;
use Illuminate\Support\Facades\Auth;
use App\Models\DosenPembimbingLapangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrasiController extends Controller
{
    public function showPesertaRegistrasiForm()
    {
        $lowongans = Lowongan::all();
        return view('applications/mbkm/staff/registrasi-program/peserta.registrasi', compact('lowongans'));
    }

    public function index()
    {
        $registrations = Registrasi::get();
        $pesertas = Peserta::all();
        $dospems = DosenPembimbingLapangan::all();
        // dd($registrations, $pesertas, $dospems);
        return view('applications/mbkm/staff/registrasi-program/staff.index', compact('registrations', 'dospems', 'pesertas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required|exists:peserta,user_id',
            'lowongan_id' => 'required|exists:lowongan,id',
        ]); 

        $pesertaId = $request->input('peserta_id');
        $lowonganId = $request->input('lowongan_id');

        $lowongan = Lowongan::find($lowonganId);
        $mitraType = $lowongan->mitra->type;

        $existingRegistration = Registrasi::where('peserta_id', $pesertaId)
            ->whereHas('lowongan.mitra', function ($query) use ($mitraType) {
                $query->where('type', $mitraType);
            })
            ->first();

        if ($existingRegistration) {
            return back()->with('error', 'Peserta sudah mendaftar pada lowongan dari tipe mitra yang sama.');
        }

        Registrasi::create([
            'peserta_id' => $pesertaId,
            'lowongan_id' => $lowonganId,
            'status' => 'registered',
        ]);

        return back()->with('success', 'Pendaftaran berhasil.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:registered,processed,accepted,rejected',
            'dospem_id' => 'sometimes|exists:dosen_pembimbing_lapangan,id',
        ]);

        $registration = Registrasi::find($id);
        $registration->status = $request->input('status');

        if ($request->input('status') == 'accepted' && $request->input('dospem_id')) {
            $registration->dospem_id = $request->input('dospem_id');
        }

        $registration->save();

        if ($request->input('status') == 'accepted') {
            Registrasi::where('peserta_id', $registration->peserta_id)
                ->where('lowongan_id', '!=', $registration->lowongan_id)
                ->update(['status' => 'rejected']);
        }

        return back()->with('success', 'Status registrasi berhasil diupdate.');
    }

    // Method untuk peserta mengambil tawaran yang diterima
    // public function acceptOffer(Request $request, $id)
    // {
    //     // Validasi input dari request
    //     $request->validate([
    //         'dospem_id' => 'required|exists:dosen_pembimbing_lapangan,id',
    //     ]);

    //     // Mengambil data registrasi berdasarkan ID
    //     $registration = Registrasi::find($id);

    //     // Cek jika status registrasi adalah accepted
    //     if ($registration->status != 'accepted') {
    //         return back()->with('error', 'Tawaran hanya dapat diambil jika diterima.');
    //     }

    //     // Menetapkan dosen pembimbing
    //     $registration->dospem_id = $request->input('dospem_id');
    //     $registration->save();

    //     return back()->with('success', 'Tawaran berhasil diambil dan dosen pembimbing telah ditetapkan.');
    // }
    public function showRegistrationsAndAcceptOffer($id)
{
    // Mengambil data registrasi berdasarkan ID
    $registration = Registrasi::with('lowongan')->find($id);

    // Mengambil ID peserta yang sedang login
    $pesertaId = Auth::user()->id; // Pastikan user login merupakan peserta

    // Mengambil semua data registrasi peserta yang sedang login
    $registrations = Registrasi::with(['lowongan'])->where('peserta_id', $pesertaId)->get();

    // Mengambil semua data dosen pembimbing lapangan
    $dospems = DosenPembimbingLapangan::all();

    return view('applications/mbkm/staff/registrasi-program/peserta.list', compact('registration', 'registrations', 'dospems'));
}

}
