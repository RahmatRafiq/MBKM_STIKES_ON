<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\AktivitasMbkm;
use App\Models\Peserta;
use App\Models\Registrasi;
use App\Models\Role;
use App\Models\sisfo\Mahasiswa;
use App\Models\TeamMember;
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

        return back()->with('success', 'Peserta updated successfully');
    }

    public function destroy(Peserta $peserta)
    {
        $peserta->delete();
        return redirect()->route('peserta.index')->with('success', 'Peserta deleted successfully');
    }

    public function uploadAllDocuments(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);

        $request->validate([
            'surat_rekomendasi' => 'file|mimes:pdf,doc,docx|max:2048',
            'transkrip_nilai' => 'file|mimes:pdf,doc,docx|max:2048',
            'cv' => 'file|mimes:pdf,doc,docx|max:2048',
            'pakta_integritas' => 'file|mimes:pdf,doc,docx|max:2048',
            'izin_orangtua' => 'file|mimes:pdf,doc,docx|max:2048',
            'surat_keterangan_sehat' => 'file|mimes:pdf,doc,docx|max:2048',
        ]);

        foreach ($request->allFiles() as $type => $file) {
            $peserta->clearMediaCollection($type);
            $peserta->addMedia($file)->toMediaCollection($type, 'dokument-peserta');
        }

        return back()->with('success', 'All files uploaded successfully');
    }

    public function uploadMultipleDocuments(Request $request, $id)
    {
        $peserta = Peserta::findOrFail($id);

        $request->validate([
            'documents.*' => 'file|mimes:pdf,doc,docx|max:2048',
        ]);

        foreach ($request->documents as $type => $file) {
            if ($file) {
                $peserta->clearMediaCollection($type);
                $peserta->addMedia($file)->toMediaCollection($type, 'dokument-peserta');
            }
        }

        return back()->with('success', 'All files uploaded successfully');
    }

    public function destroyFile($id, $type)
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->clearMediaCollection($type);
        return response()->json(['success' => 'File deleted successfully']);
    }

    public function showAddTeamMemberForm(Peserta $ketua)
    {
        // Gunakan fungsi canAddTeamMember untuk validasi
        if (!$ketua->canAddTeamMember()) {
            return back()->withErrors('Hanya ketua dengan lowongan tipe "Wirausaha Merdeka" yang dapat mengakses halaman ini.');
        }
    
        $anggotaTim = TeamMember::where('ketua_id', $ketua->id)->with('peserta')->get();
    
        return view('applications.mbkm.staff.registrasi-program.peserta.add-team-member', compact('ketua', 'anggotaTim'));
    }
    
    public function addTeamMember(Request $request, Peserta $ketua)
    {
        // Gunakan fungsi canAddTeamMember untuk validasi
        if (!$ketua->canAddTeamMember()) {
            return back()->withErrors('Hanya ketua dengan lowongan tipe "Wirausaha Merdeka" yang dapat menambahkan anggota tim.');
        }
    
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nim' => 'required|string|max:20|unique:peserta,nim',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $registrasiPlacement = $ketua->registrationPlacement;
    
        DB::transaction(function () use ($request, $ketua, $registrasiPlacement) {
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $role = Role::findByName('peserta');
            $user->assignRole($role);
    
            $anggota = Peserta::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'nama' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat ?? $ketua->alamat,
                'jurusan' => $request->jurusan ?? $ketua->jurusan,
                'telepon' => $request->telepon ?? null,
                'jenis_kelamin' => $request->jenis_kelamin ?? $ketua->jenis_kelamin,
                'dospem_id' => $ketua->dospem_id,
            ]);
    
            $registrasi = Registrasi::create([
                'peserta_id' => $anggota->id,
                'lowongan_id' => $registrasiPlacement->lowongan->id,
                'status' => 'placement',
                'dospem_id' => $registrasiPlacement->dospem_id,
                'nama_peserta' => $anggota->nama,
                'nama_lowongan' => $registrasiPlacement->lowongan->name,
                'batch_id' => $registrasiPlacement->batch_id,
            ]);
    
            AktivitasMbkm::create([
                'peserta_id' => $anggota->id,
                'lowongan_id' => $registrasi->lowongan_id,
                'mitra_id' => $registrasi->lowongan->mitra_id,
                'dospem_id' => $registrasiPlacement->dospem_id,
            ]);
    
            TeamMember::create([
                'ketua_id' => $ketua->id,
                'peserta_id' => $anggota->id,
            ]);
        });
    
        return back()->with('success', 'Anggota tim berhasil ditambahkan.');
    }
    

    public function removeTeamMember($id)
    {
        DB::transaction(function () use ($id) {
            $teamMember = TeamMember::findOrFail($id);
            $peserta = $teamMember->peserta;

            // Hapus aktivitas MBKM terkait
            AktivitasMbkm::where('peserta_id', $peserta->id)->delete();

            // Hapus registrasi terkait
            Registrasi::where('peserta_id', $peserta->id)->delete();

            // Hapus user terkait
            if ($peserta->user) {
                $peserta->user->delete();
            }

            // Hapus peserta terkait
            $peserta->delete();

            // Hapus team member
            $teamMember->delete();
        });

        return back()->with('success', 'Anggota tim berhasil dihapus.');
    }

}
