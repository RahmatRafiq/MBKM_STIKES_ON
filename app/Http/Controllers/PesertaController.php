<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\Peserta;
use App\Models\Role;
use App\Models\sisfo\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    public function index()
    {
        $pesertas = Peserta::all();
        return view('applications.mbkm.peserta.index', compact('pesertas'));
    }

    public function json()
    {
        $search = request()->search['value'];
        $query = Peserta::query();

        // columns
        $columns = [
            'nim',
            'nama',
            'alamat',
            'jurusan',
            'email',
            'telepon',
            'jenis_kelamin',
            'created_at',
            'updated_at',
        ];

        // search
        if (request()->filled('search')) {
            $query->where('nim', 'like', "%{$search}%")
                ->orWhere('nama', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('jurusan', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('telepon', 'like', "%{$search}%")
                ->orWhere('jenis_kelamin', 'like', "%{$search}%");
        }

        // order
        if (request()->filled('order')) {
            $query->orderBy($columns[request()->order[0]['column']], request()->order[0]['dir']);
        }

        $data = DataTable::paginate($query, request());

        return response()->json($data);
    }

    public function create()
    {
        $mahasiswa = Mahasiswa::all();

        return view('applications.mbkm.peserta.create', compact('mahasiswa'));
    }

    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'mahasiswa_id' => 'required|exists:mysql_second.mahasiswa,id',
    //         'password' => 'required|confirmed|min:8',
    //     ]);

    //     $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);

    //     if (Peserta::where('email', $mahasiswa->email)->exists()) {
    //         return back()->withErrors(['email' => 'Email already exists in Peserta'])->withInput();
    //     }

    //     $user = User::create([
    //         'name' => $mahasiswa->nama,
    //         'email' => $mahasiswa->email,
    //         'password' => bcrypt($request->password),
    //     ]);

    //     $role = Role::findByName('peserta');
    //     $user->assignRole($role);

    //     Peserta::create([
    //         'user_id' => $user->id ?? null,
    //         'nim' => $mahasiswa->nim ?? null,
    //         'nama' => $mahasiswa->nama ?? null,
    //         'alamat' => $mahasiswa->alamat ?? null,
    //         'jurusan' => $mahasiswa->jurusan ?? null,
    //         'email' => $mahasiswa->email ?? null,
    //         'telepon' => $mahasiswa->telepon ?? null,
    //         'jenis_kelamin' => $mahasiswa->jenis_kelamin ?? null,
    //     ]);

    //     return redirect()->route('peserta.index')->with('success', 'Peserta created successfully');
    // }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'mahasiswa_id' => 'required|exists:mysql_second.mahasiswa,id',
            'password' => 'required|confirmed|min:8',
        ]);

        // Mulai transaksi
        DB::beginTransaction();

        try {
            $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);

            if (Peserta::where('email', $mahasiswa->email)->exists()) {
                return back()->withErrors(['email' => 'Email already exists in Peserta'])->withInput();
            }

            $user = User::create([
                'name' => $mahasiswa->nama,
                'email' => $mahasiswa->email,
                'password' => bcrypt($request->password),
            ]);

            $role = Role::findByName('peserta');
            $user->assignRole($role);

            Peserta::create([
                'user_id' => $user->id ?? null,
                'nim' => $mahasiswa->nim ?? null,
                'nama' => $mahasiswa->nama ?? null,
                'alamat' => $mahasiswa->alamat ?? null,
                'jurusan' => $mahasiswa->jurusan ?? null,
                'email' => $mahasiswa->email ?? null,
                'telepon' => $mahasiswa->telepon ?? null,
                'jenis_kelamin' => $mahasiswa->jenis_kelamin ?? null,
            ]);

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            return redirect()->route('peserta.index')->with('success', 'Peserta created successfully');

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            return back()->withErrors(['error' => 'An error occurred while creating Peserta: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit(Peserta $peserta) // Pastikan parameter ini konsisten dengan route
    {
        $mahasiswa = Mahasiswa::all();
        return view('applications.mbkm.peserta.edit', compact('peserta', 'mahasiswa'));
    }

    public function update(Request $request, Peserta $peserta) // Gunakan model binding
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
        ]);

        $peserta->update([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('peserta.index')->with('success', 'Peserta updated successfully');
    }

    public function destroy(Peserta $peserta) // Gunakan model binding
    {
        $peserta->delete();

        return redirect()->route('peserta.index')->with('success', 'Peserta deleted successfully');
    }
}
