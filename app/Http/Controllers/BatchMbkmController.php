<?php

namespace App\Http\Controllers;

use App\Models\BatchMbkm;
use Illuminate\Http\Request;

class BatchMbkmController extends Controller
{
    public function index()
    {
        $batches = BatchMbkm::all();
        return view('applications.mbkm.batch-mbkm.index', compact('batches'));
    }

    public function create()
    {
        return view('applications.mbkm.batch-mbkm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'semester_start' => 'required|date',
            'semester_end' => 'required|date',
        ]);

        BatchMbkm::create($request->all());

        // Redirect ke indeks batch setelah berhasil membuat batch
        return redirect()->route('mbkm.batch-mbkms.index')->with('success', 'Batch created successfully.');
    }

    public function show(BatchMbkm $batchMbkm)
    {
        return view('applications.mbkm.batch-mbkm.show', compact('batchMbkm'));
    }

    public function edit(BatchMbkm $batchMbkm)
    {
        return view('applications.mbkm.batch-mbkm.edit', compact('batchMbkm'));
    }

    public function update(Request $request, BatchMbkm $batchMbkm)
    {
        $request->validate([
            'name' => 'required|string',
            'semester_start' => 'required|date',
            'semester_end' => 'required|date',
        ]);

        $batchMbkm->update($request->all());
        return redirect()->route('applications.mbkm.batch-mbkm.index')->with('success', 'Batch updated successfully.');
    }

    public function destroy(BatchMbkm $batchMbkm)
    {
        $batchMbkm->delete();
        return redirect()->route('applications.mbkm.batch-mbkm.index')->with('success', 'Batch deleted successfully.');
    }
}


// use App\Models\BatchMbkm;

// class AktivitasMbkmController extends Controller
// {
//     // ...

//     public function storeLaporanHarian(Request $request)
//     {
//         $request->validate([
//             'tanggal' => 'required|date',
//             'isi_laporan' => 'required|string',
//             'kehadiran' => 'required|string',
//         ]);

//         $user = Auth::user();

//         $currentBatch = BatchMbkm::where('semester_start', '<=', now())
//             ->where('semester_end', '>=', now())
//             ->first();

//         if (!$currentBatch) {
//             return back()->withErrors('No active batch found.');
//         }

//         // Lanjutkan dengan logika penyimpanan laporan harian
//         // ...
//     }

//     // ...
// }
