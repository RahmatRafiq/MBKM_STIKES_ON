<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\MitraProfile;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lowongans = Lowongan::all();
        $mitraProfile = MitraProfile::all();
        return view('applications.mbkm.lowongan-mitra.index', compact('lowongans', 'mitraProfile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lowongans = Lowongan::all();
        $mitraProfile = MitraProfile::all();
        return view('applications.mbkm.lowongan-mitra.create', compact('lowongans', 'mitraProfile'));
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mitra_id' => 'required|exists:mitra_profiles,id',
            'description' => 'required|string',
            'quota' => 'required|integer',
            'is_open' => 'required|boolean',
            'location' => 'required|string',
            'gpa' => 'required|numeric',
            'semester' => 'required|integer',
            'experience_required' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        Lowongan::create([
            'name' => $validatedData['name'],
            'mitra_id' => $validatedData['mitra_id'],
            'description' => $validatedData['description'],
            'quota' => $validatedData['quota'],
            'is_open' => $validatedData['is_open'],
            'location' => $validatedData['location'],
            'gpa' => $validatedData['gpa'],
            'semester' => $validatedData['semester'],
            'experience_required' => $validatedData['experience_required'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
        ]);

        return redirect()->route('lowongan.index')->with('success', 'Lowongan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lowongan $lowongan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lowongan $lowongan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lowongan $lowongan)
    {
        //
    }
}
