<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutMbkm;

class AboutMbkmController extends Controller
{
    /**
     * Display and edit the profile.
     */
    public function index()
    {
        // Assuming there's only one profile to be edited
        $aboutMbkm = AboutMbkm::first();

        return view('applications.mbkm.about-mbkms.index', compact('aboutMbkm'));
    }

    /**
     * Update the profile in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'program_name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'nullable|string|max:255',
            'eligibility' => 'nullable|array', // Menggunakan array untuk input multi-item
            'benefits' => 'nullable|array', // Menggunakan array untuk input multi-item
            'contact_email' => 'nullable|string|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:255',
        ]);

        // Assuming there's only one profile to be edited
        $aboutMbkm = AboutMbkm::first();

        // Mengupdate kolom dengan array yang di-encode ke JSON
        if ($aboutMbkm) {
            $aboutMbkm->update([
                'program_name' => $request->program_name,
                'description' => $request->description,
                'duration' => $request->duration,
                'eligibility' => json_encode($request->eligibility), // Simpan sebagai JSON
                'benefits' => json_encode($request->benefits), // Simpan sebagai JSON
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
                'contact_address' => $request->contact_address,
            ]);
            $message = 'About MBKM updated successfully.';
        } else {
            AboutMbkm::create([
                'program_name' => $request->program_name,
                'description' => $request->description,
                'duration' => $request->duration,
                'eligibility' => json_encode($request->eligibility), // Simpan sebagai JSON
                'benefits' => json_encode($request->benefits), // Simpan sebagai JSON
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
                'contact_address' => $request->contact_address,
            ]);
            $message = 'About MBKM created successfully.';
        }

        return redirect()->route('about-mbkms.index')->with('success', $message);
    }
}
