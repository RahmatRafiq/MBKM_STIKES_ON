@extends('layouts.app')

@section('content')
<div class="container">
    <h1>About MBKM</h1>
    <a href="{{ route('about-mbkms.create') }}" class="btn btn-primary mb-3">Add New</a>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Program Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($aboutMbkms as $aboutMbkm)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $aboutMbkm->program_name }}</td>
                <td>{{ Str::limit($aboutMbkm->description, 50) }}</td>
                <td>
                    <a href="{{ route('about-mbkms.show', $aboutMbkm->id) }}" class="btn btn-info">Show</a>
                    <a href="{{ route('about-mbkms.edit', $aboutMbkm->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('about-mbkms.destroy', $aboutMbkm->id) }}" method="POST" style="display:inline-block;">
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
