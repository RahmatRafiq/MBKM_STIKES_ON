@extends('layouts.app')

@section('title', 'Daftar Pertanyaan')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header">
            <h5 class="card-title">Daftar Pertanyaan</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3 text-end">
                <a href="{{ route('questions.create') }}" class="btn btn-primary">Tambah Pertanyaan Baru</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
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
                                    <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteQuestion({{ $question->id }})">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script>
    function deleteQuestion(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda tidak akan dapat memulihkan pertanyaan ini!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Tidak, batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `{{ route('questions.destroy', ':id') }}`.replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {
                        location.reload();
                        Swal.fire('Dihapus!', 'Pertanyaan telah dihapus.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Gagal menghapus pertanyaan.', 'error');
                    }
                });
            }
        });
    }
</script>
@endsection
