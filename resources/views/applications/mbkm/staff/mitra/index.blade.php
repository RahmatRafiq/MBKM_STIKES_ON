@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Mitra Data</h5>
                <div class="mb-3">
                    <a href="{{ route('mitra.create') }}" class="btn btn-success">Tambah Data Mitra</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table styled-table" id="mitra">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th>Tipe</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mitraProfile as $mitra)
                            <tr>
                                <td>{{ $mitra->name }}</td>
                                <td>{{ $mitra->address }}</td>
                                <td>{{ $mitra->phone }}</td>
                                <td>{{ $mitra->email }}</td>
                                <td>{{ $mitra->website }}</td>
                                <td>{{ $mitra->type }}</td>
                                <td>{{ $mitra->description }}</td>
                                <td>
                                    <a href="{{ route('mitra.edit', $mitra->id) }}" class="btn btn-primary">Ubah</a>
                                    <form action="{{ route('mitra.destroy', $mitra->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</button>
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



{{-- @extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Mitra Data</h5>
                <div class="mb-3">
                    <a href="{{ route('mitra.create') }}" class="btn btn-success">Tambah Data Mitra</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="styled-table" id="mitra">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th>Tipe</th>
                            <th>Deskripsi</th>
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
@endpush


@push('javascript')
    <script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#mitra').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            paging: true,
            ajax: {
                url: '{{ route('mitra.json') }}',
                type: 'POST',
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'address'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'email'
                },
                {
                    data: 'website'
                },
                {
                    data: 'type'
                },
                {
                    data: 'description'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    // RENDER
                    render: function(data, type, row) {
                        return `
          <a href="{{ route('mitra.edit', ':id') }}" class="btn btn-primary">Ubah</a>
          <form action="{{ route('mitra.destroy', ':id') }}" method="POST" class="d-inline">
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
