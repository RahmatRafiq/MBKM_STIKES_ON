<?php

namespace App\Http\Controllers;

use App\Models\DosenPembimbingLapangan;
use Illuminate\Http\Request;

class DosenPembimbingLapanganController extends Controller
{
    public function index()
    {
        // $DosenPembimbingLapangan = DosenPembimbingLapangan::all();
        // $dosenPembimbingLapangan = DosenPembimbingLapangan::with('role:name')->get();
        $dosenPembimbingLapangan = DosenPembimbingLapangan::with('roles:id,name')->get();



        return response()->json($dosenPembimbingLapangan);    
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
