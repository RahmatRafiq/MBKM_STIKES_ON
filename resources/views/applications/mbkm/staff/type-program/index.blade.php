@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Type Program</h5>
            <div class="mb-3">
                <a href="{{ route('type-programs.create') }}" class="btn btn-success">Create New Type Program</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table styled-table" id="type-programs">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($typePrograms as $typeProgram)
                    <tr>
                        <td>{{ $typeProgram->id }}</td>
                        <td>{{ $typeProgram->name }}</td>
                        <td>{{ $typeProgram->description }}</td>
                        <td>
                            <a href="{{ route('type-programs.edit', $typeProgram->id) }}"
                                class="btn btn-primary">Edit</a>
                            <form action="{{ route('type-programs.destroy', $typeProgram->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection