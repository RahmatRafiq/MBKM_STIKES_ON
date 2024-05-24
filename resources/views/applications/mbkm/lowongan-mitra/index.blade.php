@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Lowongan Data</h5>
            <div class="mb-3">
                <a href="{{ route('lowongan.create') }}" class="btn btn-success">Tambah Data Lowongan</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table styled-table" id="lowongan">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Mitra</th>
                        <th>Deskripsi</th>
                        <th>Quota</th>
                        <th>Status</th>
                        <th>Lokasi</th>
                        <th>IPK</th>
                        <th>Semester</th>
                        <th>Pengalaman</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Berakhir</th>
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
<link rel="stylesheet" href="{{ asset('assets/css/badges.css') }}">
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

    $('#lowongan').DataTable({
        responsive: true,
        serverSide: true,
        processing: true,
        paging: true,
        ajax: {
            url: '{{ route('lowongan.json') }}',
            type: 'POST',
        },
        columns: [
            {
                data: 'name',
            }, 
            {
                data: 'mitra.name',
                name: 'mitra.name',
                render: function(data, type, row) {
                    return row.mitra ? row.mitra.name : '-';
                }
            }, 
            {
                data: 'description',
            }, 
            {
                data: 'quota',
            }, 
            { 
                //render is_open with badge
                data: 'is_open',
                render: function(data, type, row) {
                    const badgeClass = data ? 'success' : 'danger';
                    const badgeText = data ? 'Open' : 'Closed';
                    return `<span class="badge bg-${badgeClass}">${badgeText}</span>`;
                }
            },
            {
                data: 'location',
            }, 
            {
                data: 'gpa',
            }, 
            {
                data: 'semester',
            }, 
            {
                data: 'experience_required',
            }, 
            {
                data: 'start_date',
            }, 
            {
                data: 'end_date',
            }, 
            {
                data: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    // create element
                    const editButton = document.createElement('a');
                    editButton.classList.add('btn', 'btn-primary', 'me-2');
                    editButton.href = `{{ route('lowongan.edit', ':id') }}`.replace(
                        ':id',
                        row.id
                    );
                    editButton.textContent = 'Edit';

                                // delete use Swal as confirmation
                    const deleteButton = document.createElement('button');
                    deleteButton.classList.add('btn', 'btn-danger');
                    deleteButton.textContent = 'Delete';
                    deleteButton.addEventListener('click', function() {
                        deleteRow(row.id);
                    });
                    console.log(row.id)
                    // Add the buttons to a container element
                    const container = document.createElement('div');
                    container.appendChild(editButton);
                    container.appendChild(deleteButton);

                    // Return the container element
                    return container;
                }
            },
        ]
    });

    function deleteRow(id) {
            const url = `{{ route('lowongan.destroy', ':id') }}`
            // console
            console.log(
                'deleteRow -> id',
                id,
                url,
                url.replace(':id', id)
            );
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this Lowongan!',
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
                            $('#lowongan').DataTable().ajax.reload();
                            Swal.fire('Deleted!', 'Lowongan has been deleted.', 'success');
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Failed to delete Lowongan.', 'error');
                        }
                    });
                }
            });
        }
</script>
@endpush