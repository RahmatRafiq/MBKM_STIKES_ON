@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Manajemen Registrasi</h5>
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
                    {{-- Data akan diisi secara dinamis oleh DataTables --}}
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
            $('#registrations').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                paging: true,
                ajax: {
                    url: '{{ route('registrasi.json') }}', // Pastikan route json benar
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    {
                        data: 'id',
                    },
                    {
                        data: 'nama_peserta',
                    },
                    {
                        data: 'nama_lowongan',
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            return `<span class="badge badge-${data.replace('_', '-')}">${data}</span>`;
                        }
                    },
                    {
                        data: 'dospem.name',
                        defaultContent: '<span class="text-muted">-</span>' // Jika tidak ada dospem
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let html = '';
                            if (row.status == 'registered') {
                                html += `<a href="{{ route('registrasi.documents', ':id') }}" class="btn btn-info">Lihat Dokumen</a>`.replace(':id', row.id);
                            }

                            if (row.status != 'rejected' && row.status != 'placement' && row.status != 'rejected_by_user') {
                                html += `<form action="{{ route('staff.updateRegistrasi', ':id') }}" method="POST" style="display: inline;">`.replace(':id', row.id);
                                html += '@csrf @method("PUT")';
                                html += `<select name="status" class="form-control">`;
                                html += `<option value="registered" ${(row.status == 'registered') ? 'selected' : ''}>Terdaftar</option>`;
                                html += `<option value="processed" ${(row.status == 'processed') ? 'selected' : ''}>Diproses</option>`;
                                html += `<option value="accepted" ${(row.status == 'accepted') ? 'selected' : ''}>Diterima</option>`;
                                html += `<option value="accepted_offer" ${(row.status == 'accepted_offer') ? 'selected' : ''}>Terima Tawaran</option>`;
                                html += `<option value="rejected" ${(row.status == 'rejected') ? 'selected' : ''}>Ditolak</option>`;
                                html += `<option value="rejected_by_user" ${(row.status == 'rejected_by_user') ? 'selected' : ''}>Ditolak oleh Peserta</option>`;
                                html += `</select>`;
                                html += `<button type="submit" class="btn btn-success mt-2">Update</button>`;
                                html += `</form>`;
                            }

                            return html;
                        }
                    }
                ]
            });
        });
    </script>
@endpush
