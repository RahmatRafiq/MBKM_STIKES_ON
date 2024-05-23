@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Dosen Pembimbing Data</h5>
                <div class="mb-3">
                    <a href="{{ route('dospem.create') }}" class="btn btn-success">Create New Dosen Pembimbing</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="styled-table" id="dosenPembimbing">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIP</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
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
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $('#dosenPembimbing').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                paging: true,
                ajax: {
                    url: '{{ route('dospem.json') }}',
                    type: 'POST',
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'nip'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <a href="{{ route('dospem.edit', ':id') }}" class="btn btn-primary">Ubah</a>
                            <form action="{{ route('dospem.destroy', ':id') }}" method="POST" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-danger" onclick="deleteRow(':id')">Hapus</button>
                            </form>
                        `.replace(/:id/g, row.id);
                        }
                    },
                ]
            });
        });
    
        function deleteRow(id) {
            const url = `{{ route('dospem.destroy', ':id') }}`.replace(':id', id);
    
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this Dospem!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE',
                        },
                        success: function(response) {
                            $('#dosenPembimbing').DataTable().ajax.reload();
                            Swal.fire('Deleted!', 'Dospem has been deleted.', 'success');
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Failed to delete Dospem.', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endpush
