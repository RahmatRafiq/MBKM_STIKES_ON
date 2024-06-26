@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Batch MBKM</h1>
    <a href="{{ route('batch-mbkms.create') }}" class="btn btn-primary">Create New Batch</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Semester Start</th>
                <th>Semester End</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($batches as $batch)
                <tr>
                    <td>{{ $batch->id }}</td>
                    <td>{{ $batch->name }}</td>
                    <td>{{ $batch->semester_start }}</td>
                    <td>{{ $batch->semester_end }}</td>
                    <td>
                        <a href="{{ route('batch-mbkms.edit', $batch->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('batch-mbkms.destroy', $batch->id) }}" method="POST" style="display:inline-block;">
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
@endsection
