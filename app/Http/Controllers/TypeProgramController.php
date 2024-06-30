<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\TypeProgram;
use Illuminate\Http\Request;

class TypeProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typePrograms = TypeProgram::all();
        return view('applications.mbkm.staff.type-program.index', compact('typePrograms'));
    }

    public function json(Request $request)
    {
        $search = request()->search['value'];
        $query = TypeProgram::query();

        // columns
        $columns = [
            'id',
            'name',
            'description',
        ];

        // search
        if (request()->filled('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        // order
        if (request()->filled('order')) {
            $query->orderBy($columns[request()->order[0]['column']], request()->order[0]['dir']);
        }

        $data = DataTable::paginate($query, $request);

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('applications.mbkm.staff.type-program.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        TypeProgram::create($validatedData);
        return redirect()->route('type-programs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeProgram $typeProgram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeProgram $typeProgram)
    {
        return view('applications.mbkm.staff.type-program.edit', compact('typeProgram'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeProgram $typeProgram)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $typeProgram->update($validatedData);
        return redirect()->route('type-programs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeProgram $typeProgram)
    {
        $typeProgram->delete();
        return redirect()->route('type-programs.index');
    }
}
