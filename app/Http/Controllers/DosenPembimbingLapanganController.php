<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\DosenPembimbingLapangan;
use App\Models\Role;
use App\Models\sisfo\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenPembimbingLapanganController extends Controller
{
    public function index()
    {
        $dosenPembimbingLapangan = DosenPembimbingLapangan::all();
        return view('applications.mbkm.dospem.index', compact('dosenPembimbingLapangan'));
    }

    public function json()
    {
        $search = request()->search['value'];
        $query = DosenPembimbingLapangan::query();

        // columns
        $columns = [
            'id',
            'name',
            'email',
            'nip',
            'address',
            'created_at',
            'updated_at',
        ];

        // search
        if (request()->filled('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('nip', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%");
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
        $dosen = Dosen::all();
        // dd($dosen);

        return view('applications.mbkm.dospem.create', compact('dosen'));
    }

    // public function store(Request $request)
    // {
        
    //     $request->validate([
    //         'dosen_id' => 'required|exists:mysql_second.dosen,id_dosen',
    //         'password' => 'required|',
    //     ]);

    //     // Ambil data dosen dari formulir
    //     $dosen = Dosen::findOrFail($request->dosen_id);

    //     // Simpan data ke tabel users
    //     $user = User::create([
    //         'name' => $dosen->nama,
    //         'email' => $dosen->email,
    //         'password' => bcrypt($request->password),
    //     ]);

    //     // Simpan data ke tabel dosen_pembimbing_lapangan
    //     DosenPembimbingLapangan::create([
    //         'name' => $dosen->nama,
    //         'email' => $dosen->email,
    //         'nip' => $dosen->nip, // atau kolom lain yang diperlukan
    //     ]);

    //     return redirect()->route('dospem.index')->with('success', 'Dosen Pembimbing Lapangan created successfully.');
    // }

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'dosen_id' => 'required|exists:mysql_second.dosen,id',
            'password' => 'required|confirmed|min:8',
        ]);

        // Mengambil data dosen dari database kedua
        $dosen = Dosen::findOrFail($request->dosen_id);

        // Menggunakan transaksi untuk memastikan atomicity
        DB::transaction(function () use ($dosen, $request) {
            // Simpan data ke tabel users
            $user = User::create([
                'name' => $dosen->nama,
                'email' => $dosen->email,
                'password' => bcrypt($request->password),
            ]);

            // Berikan role dosen kepada user
            $role = Role::findByName('dosen');
            $user->assignRole($role);
            // Simpan data ke tabel dosen_pembimbing_lapangan
            DosenPembimbingLapangan::create([
                'user_id' => $user->id,
                'name' => $dosen->nama,
                'email' => $dosen->email,
                'nip' => $dosen->nip,
                'address' => $dosen->alamat,

                // Tambahkan field lain sesuai kebutuhan
            ]);
        });

        return redirect()->route('dospem.index')->with('success', 'Dosen Pembimbing Lapangan created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
