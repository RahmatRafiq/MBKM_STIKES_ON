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

    // Methods show, edit, update, and destroy
}
