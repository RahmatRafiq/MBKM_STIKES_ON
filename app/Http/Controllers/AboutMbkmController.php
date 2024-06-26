<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutMbkm;

class AboutMbkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aboutMbkms = AboutMbkm::all();
        return view('applications.mbkm.about_mbkms.index', compact('aboutMbkms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('applications.mbkm.about_mbkms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        AboutMbkm::create($request->all());

        return redirect()->route('applications.mbkm.about_mbkms.index')
            ->with('success', 'About MBKM created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AboutMbkm $aboutMbkm)
    {
        return view('applications.mbkm.about_mbkms.show', compact('aboutMbkm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AboutMbkm $aboutMbkm)
    {
        return view('applications.mbkm.about_mbkms.edit', compact('aboutMbkm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AboutMbkm $aboutMbkm)
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

        $aboutMbkm->update($request->all());

        return redirect()->route('applications.mbkm.about_mbkms.index')
            ->with('success', 'About MBKM updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AboutMbkm $aboutMbkm)
    {
        $aboutMbkm->delete();

        return redirect()->route('applications.mbkm.about_mbkms.index')
            ->with('success', 'About MBKM deleted successfully.');
    }
}
