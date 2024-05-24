<?php
namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\Lowongan;
use App\Models\MitraProfile;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongan = Lowongan::all();
        $mitraProfile = MitraProfile::all();
        return view('applications.mbkm.lowongan-mitra.index', compact('lowongan', 'mitraProfile'));
    }

    public function json(Request $request)
    {
        $query = Lowongan::with('mitra');
        $search = $request->search['value'];

        // columns
        $columns = [
            'name',
            'mitra_id',
            'description',
            'quota',
            'is_open',
            'location',
            'gpa',
            'semester',
            'experience_required',
            'start_date',
            'end_date',
        ];

        // search
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('mitra_id', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('quota', 'like', "%{$search}%")
                ->orWhere('is_open', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%")
                ->orWhere('gpa', 'like', "%{$search}%")
                ->orWhere('semester', 'like', "%{$search}%")
                ->orWhere('experience_required', 'like', "%{$search}%")
                ->orWhere('start_date', 'like', "%{$search}%")
                ->orWhere('end_date', 'like', "%{$search}%");
        }

        // order
        if ($request->filled('order')) {
            $query->orderBy($columns[$request->order[0]['column']], $request->order[0]['dir']);
        }

        $data = DataTable::paginate($query, $request);

        return response()->json($data);
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

    public function edit($id)
    {
        $lowongan = Lowongan::findOrFail($id);
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
