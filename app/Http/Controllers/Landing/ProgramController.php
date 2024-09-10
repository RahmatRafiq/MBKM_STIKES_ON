<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Support\Carbon;

class ProgramController extends Controller
{
    public function index()
    {
        return inertia('Program');
    }

    public function show(Lowongan $lowongan)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $peserta = auth()->user()->peserta;

        if (is_null($peserta)) {
            return back()->with('error', 'Anda tidak terdaftar sebagai peserta');
        }

        $lowongan->load([
            'mitra',
            'mitra.lowongan' => function ($query) {
                $query->where('is_open', true)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
            }
        ]);

        return inertia('ProgramShow', [
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
                'start_date' => Carbon::parse($lowongan->start_date)->format('d F Y'),
                'end_date' => Carbon::parse($lowongan->end_date)->format('d F Y'),
                'month_duration' => Carbon::parse($lowongan->start_date)->diffInMonths($lowongan->end_date, 1) . ' bulan',
                'is_registered' => $lowongan->registrations->contains('peserta_id', $peserta->id),
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
                                    'image_url' => $item->mitra->getFirstMediaUrl('images')
                                ]
                            ];
                        })
                    ]
                )
            ]
        ]);
    }
}
