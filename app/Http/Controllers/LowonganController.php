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
        $mitraProfile = MitraProfile::all();
        $matakuliahs = Matakuliah::all(); // Mengambil data mata kuliah
        return view('applications.mbkm.lowongan-mitra.create', compact('mitraProfile', 'matakuliahs'));
    }

    public function store(Request $request)
    {
        // Validasi request
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
            'matakuliah_id.*' => 'exists:mysql_second.mk,MKID', // Validasi mata kuliah dari database kedua
        ]);
    
        // Mulai transaksi
        DB::beginTransaction();
    
        try {
            // Membuat entri baru di tabel Lowongan (database mysql)
            $lowongan = Lowongan::create($validatedData);
    
            // Gunakan query manual untuk menyimpan ke tabel pivot di koneksi mysql
            foreach ($request->matakuliah_id as $matakuliahId) {
                DB::connection('mysql')->table('lowongan_has_matakuliah')->insert([
                    'lowongan_id' => $lowongan->id,
                    'matakuliah_id' => $matakuliahId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            // Commit transaksi jika semua operasi berhasil
            DB::commit();
            return redirect()->route('lowongan.index')->with('success', 'Lowongan created successfully.');
    
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
    
            return back()->withErrors(['error' => 'An error occurred while creating Lowongan: ' . $e->getMessage()])->withInput();
        }
    }
    

    public function edit($id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $mitraProfile = MitraProfile::all();
        $matakuliahs = Matakuliah::all(); // Mengambil data mata kuliah dari koneksi kedua
    
        // Ambil matakuliah_id yang sudah terkait dengan lowongan ini
        
        $lowonganHasMatakuliah = LowonganHasMatakuliah::where('lowongan_id', $lowongan->id)->get();
        return view('applications.mbkm.lowongan-mitra.edit', compact('lowongan', 'mitraProfile', 'matakuliahs', 'lowonganHasMatakuliah'));
    }
    

    public function update(Request $request, $id)
    {
        // Ambil data lowongan berdasarkan ID
        $lowongan = Lowongan::findOrFail($id);
    
        // Validasi request
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
            'matakuliah_ids.*' => 'exists:mysql_second.mk,MKID', // Validasi mata kuliah dari database kedua
        ]);
    
        // Mulai transaksi
        DB::beginTransaction();
    
        try {
            // Update data lowongan
            $lowongan->update($validatedData);
    
            // Sinkronisasi relasi dengan mata kuliah menggunakan koneksi manual
            // Hapus relasi lama di tabel pivot
            DB::connection('mysql')->table('lowongan_has_matakuliah')
                ->where('lowongan_id', $lowongan->id)
                ->delete();
    
            // Tambahkan relasi baru di tabel pivot
            foreach ($request->matakuliah_ids as $matakuliahId) {
                DB::connection('mysql')->table('lowongan_has_matakuliah')->insert([
                    'lowongan_id' => $lowongan->id,
                    'matakuliah_id' => $matakuliahId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            // Commit transaksi jika semua operasi berhasil
            DB::commit();
            return redirect()->route('lowongan.index')->with('success', 'Lowongan updated successfully.');
    
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
    
            return back()->withErrors(['error' => 'An error occurred while updating Lowongan: ' . $e->getMessage()])->withInput();
        }
    }
    
    

    public function destroy(Lowongan $lowongan)
{
    DB::beginTransaction();

    try {
        // Hapus relasi dengan mata kuliah di tabel pivot menggunakan koneksi mysql
        DB::connection('mysql')->table('lowongan_has_matakuliah')
            ->where('lowongan_id', $lowongan->id)
            ->delete();

        // Hapus data lowongan
        $lowongan->delete();

        // Commit transaksi jika semua operasi berhasil
        DB::commit();
        return redirect()->route('lowongan.index')->with('success', 'Lowongan deleted successfully.');

    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB::rollBack();

        return back()->withErrors(['error' => 'An error occurred while deleting Lowongan: ' . $e->getMessage()]);
    }
}

}
