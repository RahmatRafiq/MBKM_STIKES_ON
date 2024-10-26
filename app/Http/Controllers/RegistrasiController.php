<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Http\Controllers\Controller;
use App\Models\AktivitasMbkm;
use App\Models\BatchMbkm;
use App\Models\DosenPembimbingLapangan;
use App\Models\Lowongan;
use App\Models\MitraProfile;
use App\Models\Peserta;
use App\Models\Registrasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrasiController extends Controller
{
    public function showPesertaRegistrasiForm(Request $request)
    {
        $search = $request->query('search');
        $type = $request->query('sortByType');
        $lowonganId = $request->query('lowongan_id');

        $query = Lowongan::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($type) {
            $query->whereHas('mitra', function ($q) use ($type) {
                $q->where('type', $type);
            });
        }

        $lowongans = $query->with(['mitra' => function ($query) {
            $query->select('id', 'name', 'type');
        }])->paginate(10);

        $types = MitraProfile::distinct()->pluck('type');
        $batchId = BatchMbkm::getActiveBatch()->id;

        if ($request->ajax()) {
            $selectedLowongan = Lowongan::with('mitra:id,name,website')->find($lowonganId);
            return response()->json([
                'selectedLowongan' => $selectedLowongan,
                'html' => view('applications.mbkm.staff.registrasi-program.peserta.detail', compact('selectedLowongan', 'batchId'))->render(),
            ]);
        }

        return view('applications.mbkm.staff.registrasi-program.peserta.registrasi', compact('lowongans', 'types', 'batchId'));
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

        $lowongans = $query->with('mitra')->paginate(10);

        $lowongans->getCollection()->transform(function ($lowongan) {
            return [
                'id' => $lowongan->id,
                'name' => $lowongan->name,
                'mitra' => [
                    'name' => $lowongan->mitra->name,
                    'type' => $lowongan->mitra->type,
                    'get_first_media_url' => $lowongan->mitra->getFirstMediaUrl('images'),
                ],
            ];
        });

        return response()->json($lowongans);
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('mitra')) {
            $mitraProfile = MitraProfile::where('user_id', $user->id)->first();
            $lowongans = Lowongan::where('mitra_id', $mitraProfile->id)->get();
        } else {
            $lowongans = Lowongan::all();
        }

        $pesertas = Peserta::all();
        $dospems = DosenPembimbingLapangan::all();
        $mitras = MitraProfile::all();
        $types = MitraProfile::distinct()->pluck('type');

        return view('applications.mbkm.staff.registrasi-program.staff.index', compact('dospems', 'pesertas', 'mitras', 'lowongans', 'types'));
    }

    public function json(Request $request)
    {
        $search = $request->search['value'];
        $mitraId = $request->mitra_id;
        $lowonganId = $request->lowongan_id;
        $type = $request->type;

        $query = Registrasi::with('dospem', 'peserta', 'lowongan.mitra');

        $user = Auth::user();
        if ($user->hasRole('mitra')) {
            $mitraProfile = MitraProfile::where('user_id', $user->id)->first();
            $query->whereHas('lowongan', function ($q) use ($mitraProfile) {
                $q->where('mitra_id', $mitraProfile->id);
            });
        }

        if ($search) {
            $query->whereHas('peserta', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })->orWhereHas('lowongan', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($mitraId) {
            $query->whereHas('lowongan.mitra', function ($q) use ($mitraId) {
                $q->where('id', $mitraId);
            });
        }

        if ($lowonganId) {
            $query->where('lowongan_id', $lowonganId);
        }

        if ($type) {
            $query->whereHas('lowongan.mitra', function ($q) use ($type) {
                $q->where('type', $type);
            });
        }

        $columns = ['id', 'nama_peserta', 'nama_lowongan', 'status', 'dospem_id'];

        if ($request->filled('order')) {
            $query->orderBy($columns[$request->order[0]['column']], $request->order[0]['dir']);
        }

        $data = DataTable::paginate($query, $request);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        // Validasi input dari form registrasi
        $request->validate([
            'peserta_id' => 'required|exists:peserta,id',
            'lowongan_id' => 'required|exists:lowongans,id',
            'batch_id' => 'required|exists:batch_mbkms,id',
        ]);

        // Ambil data peserta dari input
        $pesertaId = $request->input('peserta_id');
        $peserta = Peserta::find($pesertaId);

        // Cek apakah dokumen peserta sudah lengkap
        if (!$peserta->hasCompleteDocuments()) {
            return back()->withErrors(['error' => 'Dokumen pelengkap belum lengkap. Tidak bisa melakukan pendaftaran.']);
        }

        // Cek apakah sudah terdaftar sebelumnya di lowongan ini
        $lowonganId = $request->input('lowongan_id');
        $batchId = $request->input('batch_id');
        $existingRegistration = Registrasi::where('peserta_id', $pesertaId)
            ->where('lowongan_id', $lowonganId)
            ->where('batch_id', $batchId)
            ->first();

        if ($existingRegistration) {
            return back()->withErrors(['error' => 'Peserta sudah mendaftar pada lowongan ini di batch ini. Tidak dapat mendaftar lagi.']);
        }

        $peserta = Peserta::find($pesertaId);
        $lowongan = Lowongan::find($lowonganId);

        $existingAcceptedRegistration = Registrasi::where('peserta_id', $pesertaId)
            ->whereIn('status', ['accepted', 'accepted_offer'])
            ->where('batch_id', $batchId)
            ->first();

        if ($existingAcceptedRegistration) {
            return back()->withErrors(['Error' => 'Peserta sudah memiliki tawaran yang diterima di batch ini. Tidak dapat mendaftar di lowongan lain.']);
        }

        $placementRegistration = Registrasi::where('peserta_id', $pesertaId)
            ->where('batch_id', $batchId)
            ->where('status', 'placement')
            ->first();

        if ($placementRegistration) {
            return back()->withErrors(['error' => 'Peserta sudah memiliki lowongan dengan status "placement" di batch ini. Tidak dapat mendaftar untuk lowongan lain.']);
        }
        Registrasi::create([
            'peserta_id' => $pesertaId,
            'lowongan_id' => $lowonganId,
            'status' => 'registered',
            'nama_peserta' => $peserta->nama,
           'nama_lowongan' => $lowongan->name,
            'batch_id' => $batchId,
        ]);

        return back()->with('success', 'Pendaftaran berhasil.');
    }

    public function showDocuments($id)
    {
        $registrasi = Registrasi::findOrFail($id);
        $peserta = $registrasi->peserta;

        $collections = [
            'surat_rekomendasi' => 'Surat Rekomendasi',
            'transkrip_nilai' => 'Transkrip Nilai',
            'cv' => 'Curriculum Vitae (CV)',
            'pakta_integritas' => 'Pakta Integritas',
            'izin_orangtua' => 'Surat Izin Orangtua',
            'surat_keterangan_sehat' => 'Surat Keterangan Sehat',
        ];

        $documents = collect();
        foreach ($collections as $collection => $label) {
            $mediaItems = $peserta->getMedia($collection);
            foreach ($mediaItems as $mediaItem) {
                $documents->push((object) [
                    'label' => $label,
                    'file_name' => $mediaItem->file_name,
                    'url' => $mediaItem->getUrl(),
                ]);
            }
        }

        return view('applications.mbkm.staff.registrasi-program.staff.show-document', compact('peserta', 'documents'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $request->validate([
            'status' => 'required|in:registered,processed,accepted,rejected,rejected_by_user,accepted_offer,placement',
            'dospem_id' => 'nullable|exists:dosen_pembimbing_lapangan,id',
        ]);

        $registration = Registrasi::find($id);

        if ($user->hasRole('mitra')) {
            if (!in_array($request->input('status'), ['accepted', 'rejected'])) {
                return back()->withErrors('Anda hanya dapat menerima atau menolak pendaftar.');
            }
        }

        $registration->status = $request->input('status');

        if ($request->input('status') == 'accepted_offer' && $request->has('dospem_id')) {
            $registration->dospem_id = $request->input('dospem_id');
        }

        if ($request->input('status') == 'placement') {
            if ($registration->dospem_id === null) {
                return back()->withErrors('Dosen pembimbing harus diisi sebelum mengubah status ke "placement".');
            } else {
                AktivitasMbkm::create([
                    'peserta_id' => $registration->peserta_id,
                    'lowongan_id' => $registration->lowongan_id,
                    'mitra_id' => $registration->lowongan->mitra_id,
                    'dospem_id' => $registration->dospem_id,
                    'laporan_harian_id' => null,
                    'laporan_mingguan_id' => null,
                    'laporan_lengkap_id' => null,
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
        $request->validate([]);

        $registration = Registrasi::find($id);

        if ($registration->status != 'accepted') {
            return back()->withErrors('Tawaran hanya dapat diambil jika diterima.');
        }

        $registration->status = 'accepted_offer';
        $registration->save();

        Registrasi::where('peserta_id', $registration->peserta_id)
            ->where('id', '!=', $registration->id)
            ->whereNotIn('status', ['rejected', 'rejected_by_user'])
            ->update(['status' => 'rejected_by_user']);

        return back()->with('success', 'Tawaran berhasil diambil.');
    }

    public function rejectOffer(Request $request, $id)
    {
        $request->validate([]);

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
        $registration = Registrasi::with('lowongan.mitra', 'dospem')->find($id);

        $user = Auth::user();

        $user->load('peserta');

        $registrations = Registrasi::with(['lowongan.mitra'])
            ->where('peserta_id', $user->peserta->id)
            ->get()
            ->map(function ($registration) {
                $registration->lowongan->mitra->image_url = $registration->lowongan->mitra->getFirstMediaUrl('images');
                return $registration;
            });

        return view('applications.mbkm.staff.registrasi-program.peserta.list', compact('registration', 'registrations'));
    }
}
