@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Batch MBKM</h5>
                <div class="mb-3">
                    <a href="{{ route('batch-mbkms.create') }}" class="btn btn-success">Create New Batch</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table styled-table" id="batch-mbkms">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Semester Start</th>
                            <th>Semester End</th>
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
        $(document).ready(function() {
            $('#batch-mbkms').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                paging: true,
                ajax: {
                    url: '{{ route('batch-mbkms.json') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'semester_start'
                    },
                    {
                        data: 'semester_end'
                    },
                    {
                        data: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            const editUrl = `{{ route('batch-mbkms.edit', ':id') }}`.replace(':id',
                                row.id);
                            const deleteUrl = `{{ route('batch-mbkms.destroy', ':id') }}`.replace(
                                ':id', row.id);

                            // Button elements
                            const editButton =
                                `<a href="${editUrl}" class="btn btn-primary">Show</a>`;
                            const deleteButton = `
                                <form action="${deleteUrl}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-danger" onclick="deleteRow(${row.id})">Delete</button>
                                </form>
                            `;

                            // Action container
                            const actions = editButton + deleteButton;

                            return actions;
                        }
                    }
                ]
            });
        });

        function deleteRow(id) {
            const url = `{{ route('batch-mbkms.destroy', ':id') }}`.replace(':id', id);

            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this batch!',
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
                            $('#batch-mbkms').DataTable().ajax.reload();
                            Swal.fire('Deleted!', 'Batch has been deleted.', 'success');
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Failed to delete batch.', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endpush
