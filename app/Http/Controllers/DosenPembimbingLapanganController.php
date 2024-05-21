<?php

namespace App\Http\Controllers;

use App\Models\DosenPembimbingLapangan;
use App\Models\sisfo\Dosen;
use App\Models\User;
use Illuminate\Http\Request;

class DosenPembimbingLapanganController extends Controller
{
    public function index()
    {
        $dosenPembimbingLapangan = DosenPembimbingLapangan::all();
        return view('applications.mbkm.dospem.index', compact('dosenPembimbingLapangan'));
    }

    public function json()
    {
        $dosenPembimbingLapangan = DosenPembimbingLapangan::all();
        return response()->json($dosenPembimbingLapangan);
    }

    public function create()
    {
        $dosen = Dosen::all();
        return view('applications.mbkm.dospem.create', compact('dosen'));
    }

    public function store(Request $request)
{
    $request->validate([
        'dosen_id' => 'required|exists:sisfo.dosen,id',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Ambil data dosen dari formulir
    $dosen = Dosen::findOrFail($request->dosen_id);

    // Simpan data ke tabel users
    $user = User::create([
        'name' => $dosen->nama,
        'email' => $dosen->email,
        'password' => bcrypt($request->password),
    ]);

    // Simpan data ke tabel dosen_pembimbing_lapangan
    DosenPembimbingLapangan::create([
        'name' => $dosen->nama,
        'email' => $dosen->email,
        'nip' => $dosen->nip, // atau kolom lain yang diperlukan
    ]);

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
