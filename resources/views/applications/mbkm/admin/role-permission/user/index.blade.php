{{-- @extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">User Data</h5>
                <div class="mb-3">
                    <a href="{{ route('user.create') }}" class="btn btn-success">Create New Permission</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="styled-table" id="users">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Role ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Tanggal Dibuat</th>
                            <th>Tanggal Diubah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <a href="#" class="show-all-link">Show All</a>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/DataTables/custom.css') }}">
@endpush --}}


{{-- @push('javascript')
    <script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script>
        console.log(sm.matches)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#users').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            paging: true,
            ajax: {
                url: '{{ route('user.json') }}',
                type: 'POST',
            },
            columns: [{
                    data: 'id',
                    visible: sm.matches
                },
                {
                    data: 'role_id',
                    visible: sm.matches
                },
                {
                    data: 'name',
                    visible: sm.matches
                },
                {
                    data: 'email',
                    visible: sm.matches
                },
                {
                    data: 'created_at',
                    visible: sm.matches
                },
                {
                    data: 'updated_at',
                    visible: sm.matches
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    // RENDER
                    render: function(data, type, row) {
                        return `
          <a href="{{ route('user.edit', ':id') }}" class="btn btn-primary">Ubah</a>
          <form action="{{ route('user.destroy', ':id') }}" method="POST" class="d-inline">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</button>
          </form>
        `.replace(/:id/g, row.id);
                    }
                },
            ]
        })
    </script>
@endpush --}}
@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">User Data</h5>
                <div class="mb-3">
                    <a href="{{ route('user.create') }}" class="btn btn-success">Create New User</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table styled-table" id="users">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="#" class="show-all-link">Show All</a>
        </div>
    </div>
@endsection
