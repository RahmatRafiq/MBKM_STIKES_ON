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

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'dosen_id' => 'required|exists:mysql_second.dosen,id',
            'password' => 'required|confirmed|min:8',
        ]);

        // Mengambil data dosen dari database kedua
        $dosen = Dosen::findOrFail($request->dosen_id);

        $dosen = Dosen::findOrFail($request->dosen_id);

        // Check for existing email or name in DosenPembimbingLapangan
        if (DosenPembimbingLapangan::where('email', $dosen->email)->exists()) {
            return back()->withErrors(['email' => 'Email already exists in Dosen Pembimbing Lapangan'])->withInput();
        }

        if (DosenPembimbingLapangan::where('name', $dosen->nama)->exists()) {
            return back()->withErrors(['name' => 'Name already exists in Dosen Pembimbing Lapangan'])->withInput();
        }

        $user = User::create([
            'name' => $dosen->nama,
            'email' => $dosen->email,
            'password' => Hash::make($request->password),
        ]);


        $role = Role::findByName('dosen');
        $user->assignRole($role);


        DosenPembimbingLapangan::create([
            'user_id' => $user->id,
            'name' => $dosen->nama,
            'email' => $dosen->email,
            'nip' => $dosen->nip,
            'address' => $dosen->alamat,
            'phone' => $dosen->phone,
            'image' => 'default.jpg',

            // Tambahkan field lain sesuai kebutuhan
        ]);

        return redirect()->route('dospem.index')->with('success', 'Dosen Pembimbing Lapangan created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $dosenPembimbingLapangan = DosenPembimbingLapangan::findOrFail($id);
        return view('applications.mbkm.dospem.edit', compact('dosenPembimbingLapangan'));
    }

    public function update(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $dosenPembimbingLapangan = DosenPembimbingLapangan::findOrFail($id);

        $dosenPembimbingLapangan->update([
            'name' => $request->name,
            'nip' => $request->nip,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return redirect()->route('dospem.index')->with('success', 'Dosen Pembimbing Lapangan updated successfully.');
    }

    public function destroy($id)
    {
        $dosenPembimbingLapangan = DosenPembimbingLapangan::findOrFail($id);
        $dosenPembimbingLapangan->delete();

        return redirect()->route('dospem.index')->with('success', 'Dosen Pembimbing Lapangan deleted successfully.');
    }
}
