<?php

namespace App\Http\Controllers;

use App\Models\DosenPembimbingLapangan;
use Illuminate\Http\Request;

class DosenPembimbingLapanganController extends Controller
{
    public function index()
    {
        // $DosenPembimbingLapangan = DosenPembimbingLapangan::all();
        $dosenPembimbingLapangan = DosenPembimbingLapangan::with('role')->get();


        return response()->json($dosenPembimbingLapangan);    
    }

    public function create()
    {
        // Logika untuk menampilkan form tambah produk
    }

    public function store(Request $request)
    {
        // Logika untuk menyimpan produk baru ke dalam database
    }

    public function show($id)
    {
        // Logika untuk menampilkan detail produk berdasarkan ID
    }

    public function edit($id)
    {
        // Logika untuk menampilkan form edit produk berdasarkan ID
    }

    public function update(Request $request, $id)
    {
        // Logika untuk memperbarui data produk berdasarkan ID
    }

    public function destroy($id)
    {
        // Logika untuk menghapus produk berdasarkan ID
    }
}
