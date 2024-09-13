<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use App\Models\MitraProfile;

class MitraProfileController extends Controller
{
    public function mitraProfile(MitraProfile $mitraProfile)
    {
        // dd($mitraProfile);
        return inertia('MitraProfile', [
            'data' => [
                'id' => $mitraProfile->id,
                'name' => $mitraProfile->name,
                'address' => $mitraProfile->address,
                'phone' => $mitraProfile->phone,
                'email' => $mitraProfile->email,
                'website' => $mitraProfile->website,
                'type' => $mitraProfile->type,
                'description' => $mitraProfile->description,
                'image_url' => $mitraProfile->getFirstMediaUrl('images'),
                'lowongan' => $mitraProfile->lowongan,
            ],
        ]);
    }
}
