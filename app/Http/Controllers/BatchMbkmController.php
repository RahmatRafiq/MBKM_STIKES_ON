<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\BatchMbkm;
use Illuminate\Http\Request;

class BatchMbkmController extends Controller
{
    public function index()
    {
        $batches = BatchMbkm::all();
        return view('applications.mbkm.batch-mbkm.index', compact('batches'));
    }

    public function json()
    {
        $search = request()->search['value'];
        $query = BatchMbkm::query();

        // columns
        $columns = [
            'id',
            'name',
            'semester_start',
            'semester_end',
            'created_at',
            'updated_at',
        ];

        // search
        if (request()->filled('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('semester_start', 'like', "%{$search}%")
                ->orWhere('semester_end', 'like', "%{$search}%");
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
        return view('applications.mbkm.batch-mbkm.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'semester_start' => 'required|date',
            'semester_end' => 'required|date',
        ]);

        BatchMbkm::create($validatedData);

        return redirect()->route('batch-mbkms.index')->with('success', 'Batch created successfully.');
    }

    public function show($id)
    {
        $batch = BatchMbkm::findOrFail($id);
        return view('applications.mbkm.batch-mbkm.show', compact('batch'));
    }

    public function edit($id)
    {
        $batch = BatchMbkm::findOrFail($id);
        return view('applications.mbkm.batch-mbkm.edit', compact('batch'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'semester_start' => 'required|date',
            'semester_end' => 'required|date',
        ]);

        $batch = BatchMbkm::findOrFail($id);
        $batch->update($validatedData);

        return redirect()->route('batch-mbkms.index')->with('success', 'Batch updated successfully.');
    }

    public function destroy($id)
    {
        $batch = BatchMbkm::findOrFail($id);
        $batch->delete();

        return redirect()->route('batch-mbkms.index')->with('success', 'Batch deleted successfully.');
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
