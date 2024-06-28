@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Batch MBKM</h1>
    <a href="{{ route('batch-mbkms.create') }}" class="btn btn-primary">Create New Batch</a>
    <table class="table mt-4">
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

            $('table').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                paging: true,
                ajax: {
                    url: '{{ route('batch-mbkms.json') }}',
                    type: 'POST',
                },
                columns: [
                    data: 'action',
                    ordearble: false,
                    render: function(data, type, row) {
                        return `
                        <a href="{{ route('batch-mbkm.edit', ':id') }}" class="btn btn-primary">Ubah</a>
                        <form action="{{ route('batch-mbkm.destroy', ':id') }}" method="POST" style="display: inline;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                        `.replace(/:id/g, row.id);
                    }
                },
            
                ]       
            });
        });
</script>
@endpush