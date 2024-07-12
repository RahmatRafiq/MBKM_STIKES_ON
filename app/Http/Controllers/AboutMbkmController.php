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
            'eligibility' => 'nullable|string|max:255',
            'benefits' => 'nullable|string|max:255',
            'contact_email' => 'nullable|string|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:255',
        ]);

        // Assuming there's only one profile to be edited
        $aboutMbkm = AboutMbkm::first();

        if ($aboutMbkm) {
            $aboutMbkm->update($request->all());
            $message = 'About MBKM updated successfully.';
        } else {
            AboutMbkm::create($request->all());
            $message = 'About MBKM created successfully.';
        }

        return redirect()->route('about-mbkms.index')
            ->with('success', $message);
    }
}
