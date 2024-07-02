@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Type Program</h5>
            <div class="mb-3">
                <a href="{{ route('type-programs.create') }}" class="btn btn-success">Create New Type Program</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table styled-table" id="type-programs">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
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
    <link rel="stylesheet" href="{{ asset('assets/css/badges.css') }}">
@endpush

@push('javascript')
    <script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
    <script>
        $('#type-programs').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            paging: true,
            ajax: {
                url: '{{ route('type-programs.json') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'description' },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        const editButton = `<a href="{{ route('type-programs.edit', ':id') }}" class="btn btn-primary me-2">Edit</a>`.replace(':id', row.id);
                        const deleteButton = `<button type="button" class="btn btn-danger" onclick="deleteRow(${row.id})">Delete</button>`;
                        return editButton + deleteButton;
                    }
                }
            ]
        });

        function deleteRow(id) {
            const url = `{{ route('type-programs.destroy', ':id') }}`.replace(':id', id);
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this type program!',
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
                            $('#type-programs').DataTable().ajax.reload();
                            Swal.fire('Deleted!', 'Type program has been deleted.', 'success');
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Failed to delete type program.', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endpush
