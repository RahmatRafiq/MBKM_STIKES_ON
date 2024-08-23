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
                render: function(data, type, row) {
                    // delete use Swal as confirmation
                    const deleteButton = document.createElement('button');
                    deleteButton.classList.add('btn', 'btn-danger');
                    deleteButton.textContent = 'Delete';
                    deleteButton.addEventListener('click', function() {
                        deleteRow(row.id);
                    });

                    // Return the delete button
                    return deleteButton;
                }
            }
        ]
    });

    function deleteRow(id) {
        const url = `{{ route('mitra.destroy', ':id') }}`;
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this Mitra!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url.replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {
                        $('#mitra').DataTable().ajax.reload();
                        Swal.fire('Deleted!', 'Mitra has been deleted.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to delete Mitra.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
