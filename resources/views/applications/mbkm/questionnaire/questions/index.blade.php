@extends('layouts.app')

@section('title', 'Daftar Pertanyaan')

@section('content')
    <h1>Daftar Pertanyaan</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('questions.create') }}" class="btn btn-primary">Tambah Pertanyaan Baru</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pertanyaan</th>
                <th>Jenis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->id }}</td>
                    <td>{{ $question->question_text }}</td>
                    <td>{{ $question->question_type }}</td>
                    <td>
                        <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
