@extends('layouts.app')

@section('content')

  <body>
    <div class="recent_order">
      <h1>Recent Permissions</h1>
      <div class="table-container">
        <table class="styled-table" id="permissions">
          <thead>
            <tr>
              <th>ID</th>
              <th>Role</th>
              <th>Guard Name</th>
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
  @endpush

  @push('javascript')
    <script src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    <script>
      console.log(sm.matches)
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $('#permissions').DataTable({
        responsive: true,
        serverSide: true,
        processing: true,
        paging: true,
        ajax: {
          url: '{{ route('role.json') }}',
          type: 'POST',
        },
        columns: [{
            data: 'id'
          },
          {
            data: 'name'
          },
          {
            data: 'guard_name',
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
                <a href="{{ route('role.edit', ':id') }}" class="btn btn-primary">Ubah</a>
                <form action="{{ route('role.destroy', ':id') }}" method="POST" class="d-inline">
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
  @endpush
