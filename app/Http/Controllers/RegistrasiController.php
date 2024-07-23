<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AktivitasMbkm;
use App\Models\DosenPembimbingLapangan;
use App\Models\Lowongan;
use App\Models\MitraProfile;
use App\Models\Peserta;
use App\Models\Registrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrasiController extends Controller
{
    public function showPesertaRegistrasiForm()
    {
        $lowongans = Lowongan::all();
        $types = MitraProfile::distinct()->pluck('type'); // Ambil tipe-tipe mitra yang unik

        return view('applications.mbkm.staff.registrasi-program.peserta.registrasi', compact('lowongans', 'types'));
    }

    public function filter(Request $request)
    {
        $search = $request->query('search');
        $type = $request->query('sortByType');

        $query = Lowongan::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($type) {
            $query->whereHas('mitra', function ($q) use ($type) {
                $q->where('type', $type);
            });
        }

        $lowongans = $query->with('mitra')->get();

        return response()->json($lowongans);
    }

    public function index()
    {
        $registrations = Registrasi::with('dospem')->get();
        $pesertas = Peserta::all();
        $dospems = DosenPembimbingLapangan::all();

        return view('applications.mbkm.staff.registrasi-program.staff.index', compact('registrations', 'dospems', 'pesertas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
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

        $peserta = Peserta::find($pesertaId);
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:registered,processed,accepted,rejected,rejected_by_user,accepted_offer,placement',
            'dospem_id' => 'nullable|exists:dosen_pembimbing_lapangan,id',
        ]);

        $registration = Registrasi::find($id);
        $registration->status = $request->input('status');

        if ($request->input('status') == 'accepted_offer' && $request->has('dospem_id')) {
            $registration->dospem_id = $request->input('dospem_id');
        }

        if ($request->input('status') == 'placement') {
            if ($registration->dospem_id === null) {
                return back()->withErrors('Dosen pembimbing harus diisi sebelum mengubah status ke "placement".');
            } else {
                // Buat entri baru di tabel AktivitasMbkm
                AktivitasMbkm::create([
                    'peserta_id' => $registration->peserta_id,
                    'lowongan_id' => $registration->lowongan_id,
                    'mitra_id' => $registration->lowongan->mitra_id,
                    'dospem_id' => $registration->dospem_id,
                    'laporan_harian_id' => null, // Isi dengan ID laporan harian jika ada
                    'laporan_mingguan_id' => null, // Isi dengan ID laporan mingguan jika ada
                    'laporan_lengkap_id' => null, // Isi dengan ID laporan lengkap jika ada
                    // Anda bisa menambahkan kolom lain yang diperlukan di sini
                ]);
            }
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

        if ($registration->status != 'accepted_offer') {
            return back()->withErrors('Status registrasi harus "accepted_offer" untuk memperbarui dosen pembimbing.');
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

        // Perbarui hanya registrasi yang belum ditolak oleh perusahaan atau pengguna
        Registrasi::where('peserta_id', $registration->peserta_id)
            ->where('id', '!=', $registration->id)
            ->whereNotIn('status', ['rejected', 'rejected_by_user'])
            ->update(['status' => 'rejected_by_user']);

        return back()->with('success', 'Tawaran berhasil diambil.');
    }

    public function rejectOffer(Request $request, $id)
    {
        $request->validate([
            // Tidak ada validasi dospem_id di sini
        ]);

        $registration = Registrasi::find($id);

        if ($registration->status != 'accepted') {
            return back()->withErrors('Tawaran hanya dapat ditolak jika diterima.');
        }

        $registration->status = 'rejected_by_user';
        $registration->save();

        return back()->with('success', 'Tawaran berhasil ditolak.');
    }

    public function showRegistrationsAndAcceptOffer($id)
    {
        $registration = Registrasi::with('lowongan', 'dospem')->find($id);

        $user = Auth::user(); // Pastikan user login merupakan peserta

        // load peserta
        $user->load('peserta');

        $registrations = Registrasi::with(['lowongan'])->where('peserta_id', $user->peserta->id)->get();

        return view('applications.mbkm.staff.registrasi-program.peserta.list', compact('registration', 'registrations'));
    }
}
