<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\Peserta;
use App\Models\Role;
use App\Models\sisfo\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $request->validate([
           'mahasiswa_id' => 'required|exists:mysql_second,mahasiswa,id',
           'password' => 'required|confirmed|min:8',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);

        if (Mahasiswa::where('email', $mahasiswa->email)->exists()) {
            return back()->withErrors(['email' => 'Email already exists in Dosen Pembimbing Lapangan'])->withInput();
        }

        $user = User::create([
            'name' => $mahasiswa->nama,
            'email' => $mahasiswa->email,
            'password' => bcrypt($request->password),
        ]);

        $role = Role::findByName('peserta');
        $user->assignRole($role);

        Peserta::create([
            'user_id' => $user->id,
            'nim' => $mahasiswa->nim,
            'nama' => $mahasiswa->nama,
            'alamat' => $mahasiswa->alamat,
            'jurusan' => $mahasiswa->jurusan,
            'email' => $mahasiswa->email,
            'telepon' => $mahasiswa->telepon,
            'jenis_kelamin' => $mahasiswa->jenis_kelamin,
        ]);

        return redirect()->route('peserta.index')->with('success', 'Peserta created successfully');

    }

}
