@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Peserta MBKM Data</h5>
            <div class="mb-3">
                <a href="{{ route('peserta.create') }}" class="btn btn-success">Create New Peserta MBKM</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="styled-table" id="peserta">
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Jurusan</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Jenis Kelamin</th>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#peserta').DataTable({
        responsive: true,
        serverSide: true,
        processing: true,
        paging: true,
        ajax: {
            url: '{{ route('peserta.json') }}',
            type: 'POST',
        },
        columns: [{
                data: 'nim'
            },
            { 
                data: 'nama'
            },
            { 
                data: 'alamat'
            },
            { 
                data: 'jurusan'
            },
            { 
                data: 'email'
            },
            { 
                data: 'telepon'
            },
            { 
                data: 'jenis_kelamin'
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
                        <button class="btn btn-danger delete-button" data-id="${row.id}">Delete</button>
                    `;
                }
            },
        ]
    });

    $(document).on('click', '.delete-button', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this Peserta!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('peserta.destroy', ':id') }}'.replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {
                        $('#peserta').DataTable().ajax.reload();
                        Swal.fire('Deleted!', 'Peserta has been deleted.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to delete Peserta.', 'error');
                    }
                });
            }
        });
    });
</script>
@endpush
