<?php
namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\Lowongan;
use App\Models\LowonganHasMatakuliah;
use App\Models\MitraProfile;
use App\Models\sisfo\Matakuliah;
use DB;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('mitra')) {
            $mitraProfile = MitraProfile::where('user_id', auth()->user()->id)->first();
            $lowongan = Lowongan::where('mitra_id', $mitraProfile->id)->get();
        } else {
            $lowongan = Lowongan::all();
            $mitraProfile = MitraProfile::all();
        }

        return view('applications.mbkm.lowongan-mitra.index', compact('lowongan', 'mitraProfile'));
    }

    public function json(Request $request)
    {
        $query = Lowongan::with('mitra');

        if (auth()->user()->hasRole('mitra')) {
            $mitraProfile = MitraProfile::where('user_id', auth()->user()->id)->first();
            $query->where('mitra_id', $mitraProfile->id);
        }

        $search = $request->search['value'];

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

        if ($request->filled('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
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
            });
        }

        if ($request->filled('order')) {
            $query->orderBy($columns[$request->order[0]['column']], $request->order[0]['dir']);
        }

        $data = DataTable::paginate($query, $request);

        return response()->json($data);
    }

    public function create()
    {
        if (auth()->user()->hasRole('mitra')) {
            $mitraProfile = MitraProfile::where('user_id', auth()->user()->id)->get();
        } else {
            $mitraProfile = MitraProfile::all();
        }

        $matakuliahs = Matakuliah::all();
        return view('applications.mbkm.lowongan-mitra.create', compact('mitraProfile', 'matakuliahs'));
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
            'matakuliah_id' => 'required|array',
            'matakuliah_id.*' => 'exists:mysql_second.mk,MKID',
        ]);

        DB::beginTransaction();

        try {
            $lowongan = Lowongan::create($validatedData);

            foreach ($request->matakuliah_id as $matakuliahId) {
                $matakuliah = Matakuliah::find($matakuliahId);
                DB::connection('mysql')->table('lowongan_has_matakuliah')->insert([
                    'lowongan_id' => $lowongan->id,
                    'matakuliah_id' => $matakuliahId,
                    'name' => $matakuliah->Nama,
                    'sks' => $matakuliah->SKS,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('lowongan.index')->with('success', 'Lowongan created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'An error occurred while creating Lowongan: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $lowongan = Lowongan::findOrFail($id);

        if (auth()->user()->hasRole('mitra')) {
            $mitraProfile = MitraProfile::where('user_id', auth()->user()->id)->first();
            if ($lowongan->mitra_id !== $mitraProfile->id) {
                return redirect()->route('lowongan.index')->withErrors(['error' => 'Anda tidak memiliki akses ke lowongan ini.']);
            }
        }

        $mitraProfile = MitraProfile::all();
        $matakuliahs = Matakuliah::all();

        $lowonganHasMatakuliah = LowonganHasMatakuliah::where('lowongan_id', $lowongan->id)
            ->with(['matakuliah' => function ($query) {
                $query->select('MKID', 'Nama');
            }])
            ->get()
            ->pluck('matakuliah_id')
            ->toArray();

        return view('applications.mbkm.lowongan-mitra.edit', compact('lowongan', 'mitraProfile', 'matakuliahs', 'lowonganHasMatakuliah'));
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
            'matakuliah_ids' => 'required|array',
            'matakuliah_ids.*' => 'exists:mysql_second.mk,MKID',
        ]);

        DB::beginTransaction();
        try {
            $lowongan->update($validatedData);

            DB::connection('mysql')->table('lowongan_has_matakuliah')
                ->where('lowongan_id', $lowongan->id)
                ->delete();

            foreach ($request->matakuliah_ids as $matakuliahId) {
                $matakuliah = Matakuliah::find($matakuliahId);
                DB::connection('mysql')->table('lowongan_has_matakuliah')->insert([
                    'lowongan_id' => $lowongan->id,
                    'matakuliah_id' => $matakuliahId,
                    'name' => $matakuliah->Nama,
                    'sks' => $matakuliah->SKS,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('lowongan.index')->with('success', 'Lowongan updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'An error occurred while updating Lowongan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Lowongan $lowongan)
    {
        DB::beginTransaction();

        try {
            DB::connection('mysql')->table('lowongan_has_matakuliah')
                ->where('lowongan_id', $lowongan->id)
                ->delete();

            $lowongan->delete();

            DB::commit();
            return redirect()->route('lowongan.index')->with('success', 'Lowongan deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'An error occurred while deleting Lowongan: ' . $e->getMessage()]);
        }
    }
}
