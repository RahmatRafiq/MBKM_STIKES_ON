<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BatchMbkm;
use App\Models\Lowongan;
use App\Models\MitraProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLowonganController extends Controller
{
    public function getLowongan(Request $request)
    {
        $search = $request->query('search');
        $type = $request->query('type');
        $page = $request->query('page', 1);

        $query = Lowongan::with([
            'mitra' => function ($query) {
                $query->select('id', 'name', 'type');
            },
        ]);

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($type) {
            $query->whereHas('mitra', function ($q) use ($type) {
                $q->where('type', $type);
            });
        }

        $lowongans = $query
            ->inRandomOrder(now()->hour)
            ->paginate(10, page: $page);

        $lowongans->getCollection()->transform(function ($lowongan) {
            return [
                'id' => $lowongan->id,
                'name' => $lowongan->name,
                'description' => $lowongan->description,
                'quota' => $lowongan->quota,
                'is_open' => $lowongan->is_open,
                'location' => \Str::limit($lowongan->location, 30),
                'gpa' => $lowongan->gpa,
                'semester' => $lowongan->semester,
                'experience_required' => $lowongan->experience_required,
                'start_date' => $lowongan->start_date,
                'end_date' => $lowongan->end_date,
                'month_duration' => ceil(Carbon::parse($lowongan->start_date)->diffInMonths($lowongan->end_date, absolute: 1)) . ' bulan',
                'mitra' => [
                    'id' => $lowongan->mitra->id,
                    'name' => $lowongan->mitra->name,
                    'type' => $lowongan->mitra->type,
                    'image_url' => $lowongan->mitra->getFirstMediaUrl('images'),
                ],
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Lowongan berhasil diambil.',
            'data' => $lowongans,
        ]);
    }
    public function getMitraTypes()
    {
        $types = MitraProfile::select('type')->distinct()->get();

        return response()->json([
            'status' => 'success',
            'data' => $types,
        ]);
    }

    public function getLowonganDetail($id)
    {
        $lowongan = Lowongan::with('mitra')->findOrFail($id);

        $isLoggedIn = Auth::check();
        $peserta = $isLoggedIn ? auth()->user()->peserta : null;

        return response()->json([
            'status' => 'success',
            'message' => 'Detail lowongan berhasil diambil.',
            'data' => [
                'id' => $lowongan->id,
                'name' => $lowongan->name,
                'description' => $lowongan->description,
                'quota' => $lowongan->quota,
                'is_open' => $lowongan->is_open,
                'location' => $lowongan->location,
                'gpa' => $lowongan->gpa,
                'semester' => $lowongan->semester,
                'experience_required' => $lowongan->experience_required,
                'start_date' => $lowongan->start_date,
                'end_date' => $lowongan->end_date,
                'month_duration' => (Carbon::parse($lowongan->start_date)->diffInMonths($lowongan->end_date, 1)) . ' bulan',
                'is_registered' => $peserta ? $lowongan->registrations->contains('peserta_id', $peserta->id) : false,
                'mitra' => array_merge(
                    $lowongan->mitra->toArray(),
                    [
                        'image_url' => $lowongan->mitra->getFirstMediaUrl('images'),
                        'others' => $lowongan->mitra->lowongan->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'name' => $item->name,
                                'location' => $item->location,
                                'month_duration' => Carbon::parse($item->start_date)->diffInMonths($item->end_date, 1) . ' bulan',
                                'mitra' => [
                                    'id' => $item->mitra->id,
                                    'name' => $item->mitra->name,
                                    'type' => $item->mitra->type,
                                    'image_url' => $item->mitra->getFirstMediaUrl('images'),
                                ],
                            ];
                        }),
                    ]
                ),
                'can_register' => $isLoggedIn,
            ],
        ]);
    }

    public function registerForLowongan(Request $request)
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return response()->json(['message' => 'Silahkan login terlebih dahulu.'], 401);
        }
    
        // Validasi input
        $request->validate([
            'lowongan_id' => 'required|exists:lowongans,id',
        ]);
    
        // Ambil data peserta dari user yang login
        $peserta = Auth::user()->peserta;
        $lowonganId = $request->input('lowongan_id');
        $batchId = BatchMbkm::getActiveBatch()->id;
    
        // Pengecekan dokumen lengkap
        if (!is_bool($peserta->hasCompleteDocuments())) {
            $missingDocuments = $peserta->hasCompleteDocuments();
            return response()->json([
                'message' => 'Dokumen belum lengkap.',
                'missing_documents' => $missingDocuments
            ], 400); // Status 400 untuk Bad Request
        }
    
        // Pengecekan 1: Cek jika peserta sudah mendaftar di lowongan ini dalam batch ini
        $existingRegistration = $peserta->registrations()
            ->where('lowongan_id', $lowonganId)
            ->where('batch_id', $batchId)
            ->first();
    
        if ($existingRegistration) {
            return response()->json(['message' => 'Anda sudah mendaftar di lowongan ini.'], 400);
        }
    
        // Pengecekan 2: Cek jika peserta sudah diterima di lowongan lain pada batch ini
        $existingAcceptedRegistration = $peserta->registrations()
            ->whereIn('status', ['accepted', 'accepted_offer'])
            ->where('batch_id', $batchId)
            ->first();
    
        if ($existingAcceptedRegistration) {
            return response()->json(['message' => 'Anda sudah diterima di lowongan lain dalam batch ini.'], 400);
        }
    
        // Pengecekan 3: Cek jika peserta sudah memiliki status placement di lowongan lain dalam batch ini
        $placementRegistration = $peserta->registrations()
            ->where('batch_id', $batchId)
            ->where('status', 'placement')
            ->first();
    
        if ($placementRegistration) {
            return response()->json(['message' => 'Anda sudah memiliki lowongan dengan status "placement" dalam batch ini.'], 400);
        }
    
        // Jika semua validasi lolos, simpan pendaftaran baru
        $lowongan = Lowongan::find($lowonganId);
    
        $peserta->registrations()->create([
            'lowongan_id' => $lowonganId,
            'status' => 'registered',
            'batch_id' => $batchId,
            'nama_peserta' => $peserta->nama,
            'nama_lowongan' => $lowongan->name,
        ]);
    
        return response()->json(['message' => 'Pendaftaran berhasil.'], 201);
    }
}
