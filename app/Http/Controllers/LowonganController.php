<?php
namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\MitraProfile;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongans = Lowongan::all();
        $mitraProfile = MitraProfile::all();
        return view('applications.mbkm.lowongan-mitra.index', compact('lowongans', 'mitraProfile'));
    }

    public function create()
    {
        $lowongans = Lowongan::all();
        $mitraProfile = MitraProfile::all();
        return view('applications.mbkm.lowongan-mitra.create', compact('lowongans', 'mitraProfile'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mitra_id' => 'required|exists:mitra_profile,id',
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

        Lowongan::create($validatedData);

        return redirect()->route('lowongan.index')->with('success', 'Lowongan created successfully.');
    }

    public function edit(Lowongan $lowongan)
    {
        $mitraProfile = MitraProfile::all();
        return view('applications.mbkm.lowongan-mitra.edit', compact('lowongan', 'mitraProfile'));
    }

    public function update(Request $request, $id)
    {
        $lowongan = Lowongan::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mitra_id' => 'required|exists:mitra_profile,id',
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

        $lowongan->update([
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

        return redirect()->route('lowongan.index')->with('success', 'Lowongan updated successfully.');
    }

    public function destroy(Lowongan $lowongan)
    {
        $lowongan->delete();
        return redirect()->route('lowongan.index')->with('success', 'Lowongan deleted successfully.');
    }
}
