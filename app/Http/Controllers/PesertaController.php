<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\Peserta;
use App\Models\Role;
use App\Models\sisfo\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PesertaController extends Controller
{
    public function index()
    {
        return view('applications.mbkm.peserta.index');
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
        // Ambil mahasiswa yang memiliki email yang tidak null atau kosong
        $mahasiswa = Mahasiswa::whereNotNull('Email')
            ->where('Email', '!=', '')
            ->get();
    
        return view('applications.mbkm.peserta.create', compact('mahasiswa'));
    }
    

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'mahasiswa_id' => 'required|exists:mysql_second.mhsw,Login', // Menggunakan 'Login' sebagai primary key
            'password' => 'required|confirmed|min:8',
        ]);
    
        // Mulai transaksi
        DB::beginTransaction();
    
        try {
            $mahasiswa = Mahasiswa::where('Login', $request->mahasiswa_id)->firstOrFail();
    
            if (Peserta::where('email', $mahasiswa->Email)->exists()) {
                return back()->withErrors(['email' => 'Email already exists in Peserta'])->withInput();
            }
    
            if (Peserta::where('nama', $mahasiswa->Nama)->exists()) {
                return back()->withErrors(['name' => 'Name already exists in Peserta'])->withInput();
            }
    
            $user = User::create([
                'name' => $mahasiswa->Nama,
                'email' => $mahasiswa->Email,
                'password' => Hash::make($request->password),
            ]);
    
            $role = Role::findByName('peserta');
            $user->assignRole($role);
    
            Peserta::create([
                'user_id' => $user->id ?? null,
                'nim' => $mahasiswa->MhswID ?? null,
                'nama' => $mahasiswa->Nama ?? null,
                'email' => $mahasiswa->Email ?? null,
                'alamat' => $mahasiswa->NIMSementara ?? null,
                'jurusan' => $mahasiswa->KDPIN ?? null,
                'telepon' => $mahasiswa->PMBID ?? null,
                'jenis_kelamin' => $mahasiswa->PMBFormJualID ?? null,
            ]);
    
            // Commit transaksi jika semua operasi berhasil
            DB::commit();
    
            return redirect()->route('peserta.index')->with('success', 'Peserta created successfully');
    
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
    
            // Logging error
            \log::error('Error creating Peserta: ' . $e->getMessage());
    
            return back()->withErrors(['error' => 'An error occurred while creating Peserta: ' . $e->getMessage()])->withInput();
        }
    }
    

    public function edit(Peserta $peserta)
    {
        return view('applications.mbkm.peserta.edit', compact('peserta'));
    }

    public function update(Request $request, Peserta $peserta)
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

    public function destroy(Peserta $peserta)
    {
        $peserta->delete();
        return redirect()->route('peserta.index')->with('success', 'Peserta deleted successfully');
    }

    public function uploadDocument(Request $request, $id, $type)
    {
        $peserta = Peserta::findOrFail($id);
    
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);
    
        // Clear any existing file in the specific collection
        $peserta->clearMediaCollection($type);
    
        // Store the new file in the custom directory 'dokument-peserta'
        $peserta->addMediaFromRequest('file')
                ->usingFileName(uniqid().'_'.$request->file('file')->getClientOriginalName()) // Optional: Untuk menambahkan uniqid pada nama file
                ->toMediaCollection($type, 'dokument-peserta');
    
        return response()->json(['success' => 'File uploaded successfully']);
    }
    

    

    public function destroyFile($id, $type)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->clearMediaCollection($type);
        return response()->json(['success' => 'File deleted successfully']);
    }
}
