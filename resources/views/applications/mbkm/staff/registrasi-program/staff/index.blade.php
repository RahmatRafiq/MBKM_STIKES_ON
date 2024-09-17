@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Manajemen Registrasi</h5>
        </div>

        {{-- Filter Section --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="filter_mitra">Filter Mitra</label>
                <select id="filter_mitra" class="form-control">
                    <option value="">Semua Mitra</option>
                    @foreach ($mitras as $mitra)
                    <option value="{{ $mitra->id }}">{{ $mitra->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="filter_lowongan">Filter Lowongan</label>
                <select id="filter_lowongan" class="form-control">
                    <option value="">Semua Lowongan</option>
                    @foreach ($lowongans as $lowongan)
                    <option value="{{ $lowongan->id }}">{{ $lowongan->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="filter_type">Filter Type</label>
                <select id="filter_type" class="form-control">
                    <option value="">Semua Type</option>
                    @foreach ($types as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table styled-table" id="registrations">
                <thead>
                    <tr>
                        <th>ID Registrasi</th>
                        <th>Nama Peserta</th>
                        <th>Lowongan</th>
                        <th>Status</th>
                        <th>Dosen Pembimbing</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- DataTables will handle this --}}
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
            var table = $('#registrations').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                paging: true,
                ajax: {
                    url: '{{ route('registrasi.json') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.mitra_id = $('#filter_mitra').val();
                        d.lowongan_id = $('#filter_lowongan').val();
                        d.type = $('#filter_type').val();
                    }
                },
                columns: [
                    { data: 'id' },
                    { data: 'nama_peserta' },
                    { data: 'nama_lowongan' },
                    { 
                        data: 'status',
                        render: function(data) {
                            return `<span class="badge badge-${data}">${data}</span>`;
                        }
                    },
                    { 
                        data: 'dospem.name',
                        defaultContent: '<span class="text-muted">-</span>' 
                    },
                    { 
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let html = '';

                            // Tombol Lihat Dokumen
                            if (row.status == 'registered') {
                                html += `<a href="{{ route('registrasi.documents', ':id') }}" class="btn btn-info mb-2">Lihat Dokumen</a>`.replace(':id', row.id);
                            }

                            // Pemilihan Dosen Pembimbing jika status 'accepted_offer'
                            if (row.status == 'accepted_offer') {
                                html += `<form action="{{ route('staff.updateDospem', ':id') }}" method="POST" class="d-inline mb-2">`.replace(':id', row.id);
                                html += '@csrf @method("PUT")';
                                html += `<div class="form-group">`;
                                html += `<select name="dospem_id" class="form-control mb-2" required>`;
                                html += `<option value="">Pilih Dosen Pembimbing</option>`;
                                @foreach($dospems as $dospem)
                                html += `<option value="{{ $dospem->id }}" ${(row.dospem_id == {{ $dospem->id }}) ? 'selected' : ''}>{{ $dospem->name }}</option>`;
                                @endforeach
                                html += `</select></div>`;
                                html += `<button type="submit" class="btn btn-success mb-2">Update Dosen</button>`;
                                html += `</form>`;
                            }

                            // Tombol Penempatan jika status 'accepted_offer' dan dospem_id ada
                            if (row.status == 'accepted_offer' && row.dospem_id) {
                                html += `<form action="{{ route('staff.updateRegistrasi', ':id') }}" method="POST" class="d-inline mb-2">`.replace(':id', row.id);
                                html += '@csrf @method("PUT")';
                                html += `<input type="hidden" name="status" value="placement">`;
                                html += `<button type="submit" class="btn btn-success mb-2">Penempatan</button>`;
                                html += `</form>`;
                            }

                            // Dropdown untuk Update Status
                            html += `<form action="{{ route('staff.updateRegistrasi', ':id') }}" method="POST" class="d-inline mb-2">`.replace(':id', row.id);
                            html += '@csrf @method("PUT")';
                            html += `<select name="status" class="form-control mb-2" onchange="updateStatus(this, ${row.id})">`;
                            html += `<option value="registered" ${(row.status == 'registered') ? 'selected' : ''}>Terdaftar</option>`;
                            html += `<option value="processed" ${(row.status == 'processed') ? 'selected' : ''}>Diproses</option>`;
                            html += `<option value="accepted" ${(row.status == 'accepted') ? 'selected' : ''}>Diterima</option>`;
                            html += `<option value="accepted_offer" ${(row.status == 'accepted_offer') ? 'selected' : ''}>Terima Tawaran</option>`;
                            html += `<option value="rejected" ${(row.status == 'rejected') ? 'selected' : ''}>Ditolak</option>`;
                            html += `<option value="rejected_by_user" ${(row.status == 'rejected_by_user') ? 'selected' : ''}>Ditolak oleh Peserta</option>`;
                            html += `</select>`;
                            html += `</form>`;

                            return html;
                        }

                    }
                ]
            });

            // Reload data when filters change
            $('#filter_mitra, #filter_lowongan, #filter_type').change(function() {
                table.ajax.reload();
            });
        });

        // SweetAlert for updating status
        function updateStatus(select, id) {
            const status = select.value;
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Anda ingin mengubah status menjadi ${status}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, update!',
                cancelButtonText: 'Tidak, batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(select).closest('form').submit();
                }
            });
        }
</script>
@endpush