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
        return view('applications.mbkm.staff.registrasi-program.peserta.registrasi', compact('lowongans'));
    }

    public function index()
    {
        $registrations = Registrasi::all();
        $pesertas = Peserta::all();
        $dospems = DosenPembimbingLapangan::all();

        return view('applications.mbkm.staff.registrasi-program.staff.index', compact('registrations', 'dospems', 'pesertas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required|exists:peserta,user_id',
            'lowongan_id' => 'required|exists:lowongans,id',
        ]);

        $pesertaId = $request->input('peserta_id');
        $lowonganId = $request->input('lowongan_id');


        $existingRegistration = Registrasi::where('peserta_id', $pesertaId)
            ->where('lowongan_id', $lowonganId)
            ->first();

        if ($existingRegistration) {
            return back()->withErrors(['error' => 'Peserta sudah mendaftar pada lowongan ini. Tidak dapat mendaftar lagi.']);
        }


        $peserta = Peserta::where('user_id', $pesertaId)->first();
        $lowongan = Lowongan::find($lowonganId);


        $existingAcceptedRegistration = Registrasi::where('peserta_id', $pesertaId)
            ->whereIn('status', ['accepted', 'accepted_offer'])
            ->first();

        if ($existingAcceptedRegistration) {
            return back()->withErrors(['Error' => 'Peserta sudah memiliki tawaran yang diterima. Tidak dapat mendaftar di lowongan lain.']);
        }


        Registrasi::create([
            'peserta_id' => $pesertaId,
            'lowongan_id' => $lowonganId,
            'status' => 'registered',
            'nama_peserta' => $peserta->nama,
            'nama_lowongan' => $lowongan->name,
        ]);

        return back()->with('success', 'Pendaftaran berhasil.');
    }


    // public function update(Request $request, $id)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'status' => 'required|in:registered,processed,accepted,rejected,accepted_offer',
    //         'dospem_id' => 'nullable|exists:dosen_pembimbing_lapangan,id',
    //     ]);

    //     $registration = Registrasi::find($id);
    //     $registration->status = $request->input('status');

    //     // Hanya jika status 'accepted_offer' dan dospem_id disertakan
    //     if ($request->input('status') == 'accepted_offer' && $request->has('dospem_id')) {
    //         $registration->dospem_id = $request->input('dospem_id');
    //     }

    //     $registration->save();

    //     return back()->with('success', 'Status registrasi berhasil diupdate.');
    // }
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:registered,processed,accepted,accepted_offer,placement,rejected',
            'dospem_id' => 'nullable|exists:dosen_pembimbing_lapangan,id',
        ]);

        $registration = Registrasi::find($id);
        $registration->status = $request->input('status');

        // Hanya jika status 'accepted_offer' atau 'placement' dan dospem_id disertakan
        if (($request->input('status') == 'accepted_offer' || $request->input('status') == 'placement') && $request->has('dospem_id')) {
            $registration->dospem_id = $request->input('dospem_id');
        }

        $registration->save();

        return back()->with('success', 'Status registrasi berhasil diupdate.');
    }


    public function updateDospem(Request $request, $id)
    {
        $request->validate([
            'dospem_id' => 'required|exists:dosen_pembimbing_lapangan,id',
        ]);

        $registration = Registrasi::find($id);

        // Pastikan status adalah accepted_offer sebelum memperbarui dospem_id
        if ($registration->status != 'placement') {
            return back()->withErrors('Status registrasi harus "Penempatan" untuk memperbarui dosen pembimbing.');
        }

        $registration->dospem_id = $request->input('dospem_id');
        $registration->save();

        return back()->with('success', 'Dosen pembimbing berhasil diperbarui.');
    }


    public function acceptOffer(Request $request, $id)
    {
        $request->validate([
            // Tidak ada validasi dospem_id di sini
        ]);

        $registration = Registrasi::find($id);

        if ($registration->status != 'accepted') {
            return back()->withErrors('Tawaran hanya dapat diambil jika diterima.');
        }

        $registration->status = 'accepted_offer';
        $registration->save();

        Registrasi::where('peserta_id', $registration->peserta_id)
            ->where('id', '!=', $registration->id)
            ->update(['status' => 'rejected']);

        return back()->with('success', 'Tawaran berhasil diambil.');
    }


    public function showRegistrationsAndAcceptOffer($id)
    {
        $registration = Registrasi::with('lowongan')->find($id);

        $pesertaId = Auth::user()->id; // Pastikan user login merupakan peserta

        $registrations = Registrasi::with(['lowongan'])->where('peserta_id', $pesertaId)->get();

        $dospems = DosenPembimbingLapangan::all();

        return view('applications.mbkm.staff.registrasi-program.peserta.list', compact('registration', 'registrations', 'dospems'));
    }
}

// $mitraType = $lowongan->mitra->type;

// $existingRegistration = Registrasi::where('peserta_id', $pesertaId)
//     ->whereHas('lowongan.mitra', function ($query) use ($mitraType) {
//         $query->where('type', $mitraType);
//     })
//     ->first();

// if ($existingRegistration) {
//     return back()->withErrors(['error' => 'Peserta sudah mendaftar pada lowongan dari tipe mitra yang sama.']);
// }